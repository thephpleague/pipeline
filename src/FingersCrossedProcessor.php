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
        foreach ($stages as $stage) {
            $payload = call_user_func($stage, $payload);
        }

        return $payload;
    }
}
