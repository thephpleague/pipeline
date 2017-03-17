<?php

namespace League\Pipeline\Stub;

use League\Pipeline\StageInterface;

class StubStage implements StageInterface
{
    const STUBBED_RESPONSE = 'stubbed response';

    /**
     * @inheritdoc
     */
    public function __invoke($payload, ...$params)
    {
        return self::STUBBED_RESPONSE;
    }
}
