<?php

namespace League\Pipeline;

class FingersCrossedProcessor implements ProcessorInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(array $stages, $payload, ...$params)
    {
        foreach ($stages as $stage) {
            $payload = call_user_func($stage, $payload, ...$params);
        }

        return $payload;
    }
}
