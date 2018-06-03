<?php
declare(strict_types=1);

namespace League\Pipeline;

class FingersCrossedProcessor implements ProcessorInterface
{
    public function process(array $stages, $payload)
    {
        foreach ($stages as $stage) {
            $payload = call_user_func($stage, $payload);
        }

        return $payload;
    }
}
