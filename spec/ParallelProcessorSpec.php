<?php

namespace spec\League\Pipeline;

use League\Pipeline\ParallelProcessor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParallelProcessorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ParallelProcessor::class);
    }

    function it_should_process_stages()
    {
        $this->process([
            function ($payload) { return $payload * 2; },
            function ($payload) { return $payload * 4; },
            function ($payload) { return $payload / 2; },
        ], 2)->shouldBe([4,8,1]);
    }
}
