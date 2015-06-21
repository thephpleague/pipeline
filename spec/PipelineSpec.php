<?php

namespace spec\League\Pipeline;

use League\Pipeline\CallableOperation;
use League\Pipeline\OperationInterface;
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

    function it_should_pipe_operation(OperationInterface $operation)
    {
        $this->pipe($operation)->shouldHaveType(PipelineInterface::class);
        $this->pipe($operation)->shouldNotBe($this);
    }

    function it_should_compose_pipelines(PipelineInterface $pipeline)
    {
        $this->pipe($pipeline)->shouldHaveType(PipelineInterface::class);
        $this->pipe($pipeline)->shouldNotBe($this);
    }

    function it_should_process_a_payload(OperationInterface $operationInterface)
    {
        $payload = 1;
        $operationInterface->process($payload)->willReturn(2);
        $this->pipe($operationInterface)->process($payload)->shouldBe(2);
    }

    function it_should_execute_operations_sequential()
    {
        $this->beConstructedWith([
            CallableOperation::forCallable(function ($p) { return $p + 2; }),
            CallableOperation::forCallable(function ($p) { return $p * 10; }),
        ]);

        $this->process(1)->shouldBe(30);
    }
}
