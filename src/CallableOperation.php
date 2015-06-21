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

    public function process($payload)
    {
        return call_user_func($this->callable, $payload);
    }

    public static function forCallable(callable $callable)
    {
        return new static($callable);
    }
}