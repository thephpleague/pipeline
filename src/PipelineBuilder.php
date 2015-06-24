<?php

namespace League\Pipeline;

class PipelineBuilder
{
    /**
     * @var OperationInterface[]
     */
    private $operations = [];

    /**
     * Add an operation.
     *
     * @param OperationInterface $operation
     *
     * @return $this
     */
    public function add(OperationInterface $operation)
    {
        $this->operations[] = $operation;

        return $this;
    }

    /**
     * @return Pipeline
     */
    public function build()
    {
        return new Pipeline($this->operations);
    }
}
