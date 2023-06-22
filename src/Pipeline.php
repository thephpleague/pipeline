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

    /**
     * Pipeline constructor.
     *
     * @param \League\Pipeline\ProcessorInterface|null $processor
     * @param callable ...$stages
     */
    public function __construct(ProcessorInterface $processor = null, callable ...$stages)
    {
        $this->processor = $processor ?? new FingersCrossedProcessor;
        $this->stages = $stages;
    }

    /**
     * One pipe for your task.
     *
     * @param callable $stage
     * @return \League\Pipeline\PipelineInterface|$this
     */
    public function pipe(callable $stage): PipelineInterface
    {
        $pipeline = clone $this;
        $pipeline->stages[] = $stage;

        return $pipeline;
    }

    public function process($payload, ...$params)
    {
        if ($this->processor instanceof ParametersInterface) {
            $this->processor->setParameters(...$params);
            return $this->processor->process($payload, ...$this->stages);
        }

        return $this->processor->process($payload, ...$this->stages);
    }

    public function __invoke($payload, ...$params)
    {
        return $this->process($payload, ...$params);
    }
}
