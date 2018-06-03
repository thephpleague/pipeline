<?php
declare(strict_types=1);

namespace League\Pipeline;

class InterruptibleProcessor implements ProcessorInterface
{
    /**
     * @var callable
     */
    private $check;

    public function __construct(callable $check)
    {
        $this->check = $check;
    }

    public function process(array $stages, $payload)
    {
        foreach ($stages as $stage) {
            $payload = call_user_func($stage, $payload);

            if (true !== call_user_func($this->check, $payload)) {
                return $payload;
            }
        }

        return $payload;
    }
}
