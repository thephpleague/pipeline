<?php
declare(strict_types=1);

namespace League\Pipeline;

class FingersCrossedProcessor implements ProcessorInterface, ParametersInterface
{
    use ParametersTrait;

    public function process($payload, callable ...$stages)
    {
        foreach ($stages as $stage) {
            $payload = $stage($payload, ...$this->getParameters());
        }

        return $payload;
    }
}
