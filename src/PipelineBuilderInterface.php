<?php

namespace League\Pipeline;

interface PipelineBuilderInterface extends BuilderInterface
{
    /**
     * Add a stage.
     *
     * @param callable $stage
     *
     * @return $this
     */
    public function pipe(callable $stage);

    /**
     * Forks the pipeline
     *
     * @param callable $resolver
     * @return mixed
     */
    public function fork(callable $resolver);

    /**
     * Build a new Pipeline object
     *
     *
     * @return PipelineInterface
     */
    public function build();
}
