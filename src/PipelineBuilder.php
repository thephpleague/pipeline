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
     * @return Pipeline
     */
    public function build()
    {
        return new Pipeline($this->stages);
    }
}
