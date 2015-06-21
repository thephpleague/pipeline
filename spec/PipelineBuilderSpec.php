<?php

namespace spec\League\Pipeline;

use League\Pipeline\CallableOperation;
use League\Pipeline\PipelineBuilder;
use League\Pipeline\PipelineInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PipelineBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PipelineBuilder::class);
    }

    function it_should_build_a_pipeline()
    {
        $this->buildPipeline()->shouldHaveType(PipelineInterface::class);
    }

    function it_should_collect_operations_for_a_pipeline()
    {
        $this->add(CallableOperation::forCallable(function ($p) {
            return $p * 2;
        }));

        $this->buildPipeline()->process(4)->shouldBe(8);
    }
}
