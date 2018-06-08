<?php

namespace spec\League\Pipeline;

use League\Pipeline\ConditionalStage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConditionalStageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(function() { return true; }, 
                                 function(){ return true; },
                                 function(){ return true; } );
        $this->shouldHaveType('League\Pipeline\ConditionalStage');
    }

    function it_should_process_a_payload()
    {
        $stageIfTrue = function ($payload) { return $payload + 1; };
        $stageIfFalse = function ($payload) { return $payload + 2; };
        $conditionFn = function ($payload) { return $payload % 2 == 0; };
        $this->beConstructedWith($conditionFn, $stageIfTrue, $stageIfFalse);
        ($this)(2)->shouldBe(3);
    }
}
