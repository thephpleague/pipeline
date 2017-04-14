<?php

namespace League\Pipeline;

use InvalidArgumentException;

class Pipeline implements PipelineInterface
{
    /**
     * @var callable[]
     */
    private $stages = [];

    /**
     * @var ProcessorInterface
     */
    private $processor;

    /**
     * Constructor.
     *
     * @param callable[]         $stages
     * @param ProcessorInterface $processor
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $stages = [], ProcessorInterface $processor = null)
    {
        foreach ($stages as $stage) {
            if (false === is_callable($stage)) {
                throw new InvalidArgumentException('All stages should be callable.');
            }
        }

        $this->stages = $stages;
        $this->processor = $processor ?: new FingersCrossedProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function pipe(callable $stage)
    {
        $pipeline = clone $this;
        $pipeline->stages[] = $stage;

        return $pipeline;
    }

    /**
     * {@inheritdoc}
     */
    public function process($payload, ...$params)
    {
        return $this->processor->process($this->stages, $payload, ...$params);
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke($payload, ...$params)
    {
        return $this->process($payload, ...$params);
    }
}
