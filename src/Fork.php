<?php

namespace League\Pipeline;


class Fork implements ForkInterface
{
    /**
     * @var Pipeline
     */
    private $parent;

    /**
     * @var array callable
     */
    protected $forks = [];

    /**
     * @var callable
     */
    protected $resolver;

    /**
     * Fork constructor.
     * @param callable|null $resolver
     * @param array $forks
     */
    public function __construct(callable $resolver = null, $forks = [])
    {
        $this->resolver = $resolver;
        $this->forks = $forks;
    }

    public function pipeline(Pipeline $pipeline)
    {
        $this->parent = $pipeline;
    }

    /**
     * @inheritdoc
     */
    public function join(callable $resolver = null)
    {
        if($resolver != null)
        {
            $this->resolver = $resolver;
        }

        return $this->parent;
    }

    /**
     * @inheritdoc
     */
    public function disjoin(string $tag, callable $stage = null)
    {
        $pipeline = new DisjointAwarePipeline($this);

        if($stage != null)
        {
            $pipeline = $pipeline->pipe($stage);
        }

        $this->forks[$tag] = $pipeline;
        return $pipeline;
    }

    /**
     * Chooses a fork or short-circuits based on $resolver
     *
     * @param mixed $payload
     * @return mixed
     */
    public function __invoke($payload)
    {
        $flowTo = call_user_func($this->resolver, $payload);
        if($flowTo === false) return $payload;
        $result = $this->forks[$flowTo]->process($payload);

        return $result;
    }
}
