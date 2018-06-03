<?php
declare(strict_types=1);

namespace League\Pipeline;

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

    public function __construct(ProcessorInterface $processor = null, callable ...$stages)
    {
        $this->processor = $processor ?? new FingersCrossedProcessor;
        $this->stages = $stages;
    }

    public function pipe(callable $stage): PipelineInterface
    {
        $pipeline = clone $this;
        $pipeline->stages[] = $stage;

        return $pipeline;
    }

    public function process($payload)
    {
        return $this->processor->process($payload, ...$this->stages);
    }

    public function __invoke($payload)
    {
        return $this->process($payload);
    }
}
