<?php

namespace League\Pipeline;

class FingersCrossedProcessor implements ProcessorInterface
{
    /**
     * @param array $stages
     * @param mixed $payload
     *
     * @return mixed
     */
    public function process(array $stages, $payload)
    {
        return array_reduce($stages, function ($payload, callable $stage) {
            return call_user_func($stage, $payload);
        }, $payload);
    }
}
