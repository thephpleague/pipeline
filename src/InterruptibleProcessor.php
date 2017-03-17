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
     * {@inheritdoc}
     */
    public function process(array $stages, $payload, ...$params)
    {
        foreach ($stages as $stage) {
            $payload = call_user_func($stage, $payload, ...$params);

            if (true !== call_user_func($this->check, $payload, ...$params)) {
                return $payload;
            }
        }

        return $payload;
    }
}
