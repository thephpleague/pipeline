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
            // @codeCoverageIgnoreStart
            if (! $operation instanceof OperationInterface) {
                throw new InvalidArgumentException('All operations should implement the '.OperationInterface::class);
            }
            // @codeCoverageIgnoreEnd
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
        $executionChain = $this->createExecutionChain();

        return call_user_func($executionChain, $payload);
    }

    /**
     * Create an execution chain from the operations.
     *
     * @return Closure
     */
    private function createExecutionChain()
    {
        $operations = $this->operations;
        $chain = function ($payload) { return $payload; };

        /** @var OperationInterface $operation */
        while ($operation = array_shift($operations)) {
            $chain = function ($payload) use ($chain, $operation) {
                return $operation->process($chain($payload));
            };
        }

        return $chain;
    }
}
