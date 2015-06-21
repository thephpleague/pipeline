<?php

namespace League\Pipeline;

use Closure;
use InvalidArgumentException;

class Pipeline implements PipelineInterface
{
    /**
     * @var OperationInterface[]
     */
    private $operations = [];

    /**
     * @param OperationInterface[] $operations
     */
    public function __construct(array $operations = [])
    {
        $this->guardAgainstInvalidOperations($operations);

        $this->operations = $operations;
    }

    /**
     * Ensure all operations implement the OperationInterface.
     *
     * @param array $operations
     * @throws InvalidArgumentException
     */
    private function guardAgainstInvalidOperations(array $operations)
    {
        foreach ($operations as $operation) {
            if (! $operation instanceof OperationInterface) {
                throw new InvalidArgumentException('All operations should implement the '.OperationInterface::class);
            }
        }
    }

    /**
     * Create a new pipeline
     *
     * @param OperationInterface $operation
     *
     * @return static
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
