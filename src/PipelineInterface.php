<?php

namespace League\Pipeline;

interface PipelineInterface extends StageInterface
{
    /**
     * Create a new pipeline with an appended stage.
     *
     * @param callable $stage
     *
     * @return static
     */
    public function pipe(callable $stage);

    /**
     * Process the payload
     *
     * @param mixed $payload
     * @param mixed ...$params
     *
     * @return mixed
     */
    public function process($payload, ...$params);
}
