<?php

namespace spec\League\Pipeline;

use InvalidArgumentException;
use League\Pipeline\CallableOperation;
use League\Pipeline\Pipeline;
use League\Pipeline\PipelineInterface;
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
        $operation = CallableOperation::forCallable(function () {});
        $this->pipe($operation)->shouldHaveType(PipelineInterface::class);
        $this->pipe($operation)->shouldNotBe($this);
    }

    function it_should_compose_pipelines()
    {
        $pipeline = new Pipeline();
        $this->pipe($pipeline)->shouldHaveType(PipelineInterface::class);
        $this->pipe($pipeline)->shouldNotBe($this);
    }

    function it_should_process_a_payload()
    {
        $operation = CallableOperation::forCallable(function ($payload) { return $payload + 1; });
        $this->pipe($operation)->process(1)->shouldBe(2);
    }

    function it_should_execute_operations_sequential()
    {
        $this->beConstructedWith([
            CallableOperation::forCallable(function ($p) { return $p + 2; }),
            CallableOperation::forCallable(function ($p) { return $p * 10; }),
        ]);

        $this->process(1)->shouldBe(30);
    }

    function it_should_only_allow_operations_as_constructor_arguments()
    {
        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', [['fooBar']]);
    }
}
