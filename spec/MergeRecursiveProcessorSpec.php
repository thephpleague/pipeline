<?php

namespace spec\League\Pipeline;

use League\Pipeline\MergeRecursiveProcessor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MergeRecursiveProcessorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MergeRecursiveProcessor::class);
    }

    function it_should_process_stages()
    {
        $this->process([
            function ($payload) { return ['mult' => $payload * 2]; },
            function ($payload) { return ['mult' => $payload * 4]; },
            function ($payload) { return ['div' => $payload / 2 ]; },
            function ($payload) { return 2; },
        ], 2)->shouldBe(['mult' => [4,8], 'div' => 1, 2]);
    }
}
