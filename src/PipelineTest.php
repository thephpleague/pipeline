<?php
declare(strict_types=1);

namespace League\Pipeline;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class PipelineTest extends TestCase
{
    #[Test]
    public function it_passes_through_information_without_stages(): void
    {
        $pipeline = new Pipeline();

        $result = $pipeline->process(10);

        self::assertEquals(10, $result);
    }

    #[Test]
    public function it_uses_stages_to_process_the_pipeline(): void
    {
        $pipeline = (new Pipeline())->pipe(
            function($p) { return $p * 10; },
        )->pipe(
            function($p) { return $p - 10; },
        );

        $result = $pipeline->process(10);

        self::assertEquals(90, $result);
    }

    #[Test]
    public function it_can_be_composed_by_piping_multiple_pipelines(): void
    {
        $pipeline1 = new Pipeline(null, function($p) { return $p * 10; });
        $pipeline2 = new Pipeline(null, function($p) { return $p - 10; });

        $pipeline = (new Pipeline())->pipe($pipeline1)->pipe($pipeline2);

        $result = $pipeline(10);

        self::assertEquals(90, $result);
    }
}