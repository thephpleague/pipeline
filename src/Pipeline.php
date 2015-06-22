<?php

namespace League\Pipeline;

use InvalidArgumentException;

class Pipeline implements PipelineInterface
{
    /**
     * @var OperationInterface[]
     */
    private $operations = [];

    /**
     * Constructor
     *
     * @param  OperationInterface[]     $operations
     * @throws InvalidArgumentException
     */
    public function __construct(array $operations = [])
    {
        foreach ($operations as $operation) {
            if (! $operation instanceof OperationInterface) {
                throw new InvalidArgumentException('All operations should implement the '.OperationInterface::class);
            }
        }

        $this->operations = $operations;
    }

    /**
     * {@inheritdoc}
     */
    public function pipe(OperationInterface $operation)
    {
        $operations = $this->operations;
        $operations[] = $operation;

        return new static($operations);
    }

    /**
     * {@inheritdoc}
     */
    public function process($payload)
    {
        $reducer = function ($payload, OperationInterface $operation) {
            return $operation->process($payload);
        };

        return array_reduce($this->operations, $reducer, $payload);
    }
}
