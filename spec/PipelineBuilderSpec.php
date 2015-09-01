<?php

namespace spec\League\Pipeline;

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
        $this->build()->shouldHaveType(PipelineInterface::class);
    }

    function it_should_collect_operations_for_a_pipeline()
    {
        $this->add(function ($p) {
            return $p * 2;
        });

        $this->build()->process(4)->shouldBe(8);
    }

    function it_should_have_a_fluent_build_interface()
    {
        $operation = function () {};
        $this->add($operation)->shouldBe($this);
    }
}
