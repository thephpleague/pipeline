<?php

namespace spec\League\Pipeline;

use League\Pipeline\FingersCrossedProcessor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FingersCrossedProcessorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FingersCrossedProcessor::class);
    }

    function it_should_process_stages()
    {
        $this->process(
            2,
            function ($payload) { return $payload * 2; }
        )->shouldBe(4);
    }
}
