<?php

namespace League\Pipeline;

class PipelineBuilder
{
    /**
     * @var callable[]
     */
    private $stages = [];

    /**
     * Add an stage.
     *
     * @param callable $stage
     *
     * @return $this
     */
    public function add(callable $stage)
    {
        $this->stages[] = $stage;

        return $this;
    }

    /**
     * Build a new Pipeline object
     *
     * @param  ProcessorInterface $processor
     *
     * @return Pipeline
     */
    public function build(ProcessorInterface $processor = null)
    {
        return new Pipeline($this->stages, $processor);
    }
}
