<?php

namespace League\Pipeline;

interface PipelineInterface extends OperationInterface
{
    /**
     * Create a new pipeline with an appended operation.
     *
     * @param  OperationInterface $operation
     * @return static
     */
    public function pipe(OperationInterface $operation);
}
