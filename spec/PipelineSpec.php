<?php

namespace spec\League\Pipeline;

use InvalidArgumentException;
use League\Pipeline\CallableStage;
use League\Pipeline\Pipeline;
use League\Pipeline\PipelineInterface;
use League\Pipeline\Stub\StubStage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PipelineSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Pipeline::class);
        $this->shouldHaveType(PipelineInterface::class);
    }

    function it_should_pipe_operation()
    {
        $operation = function () {};
        $this->pipe($operation)->shouldNotBe($this);
    }

    function it_should_compose_pipelines()
    {
        $pipeline = (new Pipeline)->pipe(function () { return 10; });
        $this->pipe($pipeline)->process('something')->shouldBe(10);
    }

    function it_should_process_a_payload()
    {
        $operation = function ($payload) { return $payload + 1; };
        $this->pipe($operation)->process(1)->shouldBe(2);
    }

    function it_should_execute_operations_in_sequence()
    {
        $this->beConstructedWith(
            null,
            function ($p) { return $p + 2; },
            function ($p) { return $p * 10; }
        );

        $this->__invoke(1)->shouldBe(30);
    }

    function it_should_accept_implementations_of_stage()
    {
        $this->pipe(new StubStage)->process('payload')->shouldBe(StubStage::STUBBED_RESPONSE);
    }
}
