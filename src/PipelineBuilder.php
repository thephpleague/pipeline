<?php

namespace League\Pipeline;

class PipelineBuilder
{
    /**
     * @var OperationInterface[]
     */
    private $operations = [];

    /**
     * @param OperationInterface $operation
     */
    public function add(OperationInterface $operation)
    {
        $this->operations[] = $operation;
    }

    /**
     * @return Pipeline
     */
    public function buildPipeline()
    {
        return new Pipeline($this->operations);
    }
}