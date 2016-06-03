<?php

namespace League\Pipeline;

class InterruptibleProcessor implements ProcessorInterface
{
    /**
     * @var callable
     */
    private $check;

    /**
     * InterruptibleProcessor constructor.
     *
     * @param callable $check
     */
    public function __construct(callable $check)
    {
        $this->check = $check;
    }

    /**
     * @param array $stages
     * @param mixed $payload
     *
     * @return mixed
     */
    public function process(array $stages, $payload)
    {
        $check = $this->check;

        foreach ($stages as $stage) {
            $payload = $stage($payload);

            if ($check($payload) !== true) {
                return $payload;
            }
        }

        return $payload;
    }
}
