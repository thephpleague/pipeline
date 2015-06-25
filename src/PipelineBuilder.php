<?php

namespace League\Pipeline;

class PipelineBuilder
{
    /**
     * @var StageInterface[]
     */
    private $stages = [];

    /**
     * Add an stage.
     *
     * @param StageInterface $stage
     *
     * @return $this
     */
    public function add(StageInterface $stage)
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
