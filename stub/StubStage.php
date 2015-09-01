<?php

namespace League\Pipeline\Stub;

use League\Pipeline\StageInterface;

class StubStage implements StageInterface
{
    const STUBBED_RESPONSE = 'stubbed response';

    /**
     * Process the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function __invoke($payload)
    {
        return self::STUBBED_RESPONSE;
    }
}
