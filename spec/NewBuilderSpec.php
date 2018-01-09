<?php
/**
 * Created by PhpStorm.
 * User: juzerali
 * Date: 09/01/18
 * Time: 8:20 PM
 */

namespace spec\League\Pipeline;


use League\Pipeline\PipelineBuilder;
use PhpSpec\Exception\Exception;
use PhpSpec\ObjectBehavior;

class NewBuilderSpec extends ObjectBehavior
{
    public function it_should_pass()
    {
        $pipeline = (new PipelineBuilder())
            ->pipe(function($payload) {return $payload * 2;})
            ->fork(function($payload) {
                if($payload == 0) return '0';
                if($payload > 0) return '+';
                if($payload < 0) return '-';
                return false;
            })
            ->disjoin('0')
            ->pipe(function() {return INF;})
            ->disjoin('+')
            ->pipe(function($payload) {return sqrt($payload);})
            ->pipe(function($payload) {return $payload / 2;})
            ->disjoin('-', function() {return NAN;})
            ->join()
            ->pipe(function ($payload) {return "&" . $payload;})
            ->build()
        ;

        if(($result = $pipeline->process(0)) != '&INF')
        {
            throw new Exception('Should be &INF but was ' . $result);
        }

        if(($result = $pipeline->process(32)) != '&4')
        {
            throw new Exception('Should be &4 but was ' . $result);
        }

        if($pipeline->process(-1) != '&NAN')
        {
            throw new Exception('Should be NAN');
        }
    }

}
