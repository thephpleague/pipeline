<?php
declare(strict_types=1);

namespace League\Pipeline;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class InterruptibleProcessorTest extends TestCase
{
    #[Test]
    public function it_can_process_stages(): void
    {
        $pipeline = new InterruptibleProcessor(function ($payload) {
            return $payload < 3;
        });

        $result = $pipeline->process(
            2,
            function ($payload) { return $payload * 2; },
            function ($payload) { return $payload + 1; }
        );

        self::assertEquals(4, $result);
    }
}