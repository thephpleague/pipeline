<?php

namespace League\Pipeline;

interface PipelineInterface extends StageInterface
{
    /**
     * Create a new pipeline with an appended stage.
     *
     * @param StageInterface $operation
     *
     * @return static
     */
    public function pipe(StageInterface $operation);
}
