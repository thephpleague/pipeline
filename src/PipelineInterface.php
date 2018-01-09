<?php

namespace League\Pipeline;

interface PipelineInterface extends StageInterface
{
    /**
     * Create a new pipeline with an appended stage.
     *
     * @param callable $operation
     *
     * @return static
     */
    public function pipe(callable $operation);

    /**
     * Forks the pipeline with the given fork
     *
     * @param callable $resolver
     *
     * @return ForkInterface
     */
    public function fork(callable $resolver);
}
