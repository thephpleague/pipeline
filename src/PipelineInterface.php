<?php
declare(strict_types=1);

namespace League\Pipeline;

interface PipelineInterface extends StageInterface
{
    /**
     * Create a new pipeline with an appended stage.
     *
     * @return static
     */
    public function pipe(callable $operation): PipelineInterface;

    /**
     * Process the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function process($payload);
}
