<?php

namespace League\Pipeline;

class CallableOperation implements OperationInterface
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * Process the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function process($payload)
    {
        return call_user_func($this->callable, $payload);
    }

    /**
     * Create a new instance from a callable.
     *
     * @param callable $callable
     *
     * @return static
     */
    public static function forCallable(callable $callable)
    {
        return new static($callable);
    }
}
