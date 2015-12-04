<?php

namespace League\Pipeline;

use InvalidArgumentException;

class Pipeline implements PipelineInterface
{
    /**
     * @var StageInterface[]
     */
    private $stages = [];

    /**
     * Constructor.
     *
     * @param callable[] $stages
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $stages = [])
    {
        foreach ($stages as $stage) {
            if (false === is_callable($stage)) {
                throw new InvalidArgumentException('All stages should be callable.');
            }
        }

        $this->stages = $stages;
    }

    /**
     * @inheritdoc
     */
    public function pipe(callable $stage)
    {
        $stages = $this->stages;
        $stages[] = $stage;
        $pipeline = new static();
        $pipeline->stages = $stages;

        return $pipeline;
    }

    /**
     * Process the payload.
     *
     * @param $payload
     *
     * @return mixed
     */
    public function process($payload)
    {
        $reducer = function ($payload, callable $stage) {
            return $stage($payload);
        };

        foreach ($this->stages as $stage) {
            $payload = $reducer($payload, $stage);
        }
        return $payload;
    }

    /**
     * @inheritdoc
     */
    public function __invoke($payload)
    {
        return $this->process($payload);
    }
}
