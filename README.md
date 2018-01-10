# League\Pipeline

[![Author](http://img.shields.io/badge/author-@frankdejonge-blue.svg?style=flat-square)](https://twitter.com/frankdejonge)
[![Build Status](https://img.shields.io/travis/thephpleague/pipeline/master.svg?style=flat-square)](https://travis-ci.org/thephpleague/pipeline)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/thephpleague/pipeline.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/pipeline/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/thephpleague/pipeline.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/pipeline)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/league/pipeline.svg?style=flat-square)](https://packagist.org/packages/league/pipeline)
[![Total Downloads](https://img.shields.io/packagist/dt/league/pipeline.svg?style=flat-square)](https://packagist.org/packages/league/pipeline)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/44ebfc4c-0e97-4b47-925e-b17de7ddce4f/mini.png)](https://insight.sensiolabs.com/projects/44ebfc4c-0e97-4b47-925e-b17de7ddce4f)

This package provides a pipeline pattern implementation.

## Pipeline Pattern

The pipeline pattern allows you to easily compose sequential stages by
chaining stages.

In this particular implementation the interface consists of two parts:

* StageInterface
* PipelineInterface

A pipeline consists of zero, one, or multiple stages. A pipeline can process
a payload. During the processing the payload will be passed to the first stage.
From that moment on the resulting value is passed on from stage to stage.

In the simplest form, the execution chain can be represented as a foreach:

```php
$result = $payload;

foreach ($stages as $stage) {
    $result = $stage($result);
}

return $result;
```

Effectively this is the same as:

```php
$result = $stage3($stage2($stage1($payload)));
```

## Immutability

Pipelines are implemented as immutable stage chains. When you pipe a new
stage, a new pipeline will be created with the added stage. This makes
pipelines easy to reuse, and minimizes side-effects.

## Usage

Operations in a pipeline, stages, can be anything that satisfies the `callable`
type-hint. So closures and anything that's invokable is good.

```php
$pipeline = (new Pipeline)->pipe(function ($payload) {
    return $payload * 10;
});
```

## Class based stages.

Class based stages are also possible. The StageInterface can be implemented which
ensures you have the correct method signature for the `__invoke` method.

```php
use League\Pipeline\Pipeline;
use League\Pipeline\StageInterface;

class TimesTwoStage implements StageInterface
{
    public function __invoke($payload)
    {
        return $payload * 2;
    }
}

class AddOneStage implements StageInterface
{
    public function __invoke($payload)
    {
        return $payload + 1;
    }
}

$pipeline = (new Pipeline)
    ->pipe(new TimesTwoStage)
    ->pipe(new AddOneStage);

// Returns 21
$pipeline->process(10);
```

## Re-usable Pipelines

Because the PipelineInterface is an extension of the StageInterface
pipelines can be re-used as stages. This creates a highly composable model
to create complex execution patterns while keeping the cognitive load low.

For example, if we'd want to compose a pipeline to process API calls, we'd create
something along these lines:

```php
$processApiRequest = (new Pipeline)
    ->pipe(new ExecuteHttpRequest) // 2
    ->pipe(new ParseJsonResponse); // 3
    
$pipeline = (new Pipeline)
    ->pipe(new ConvertToPsr7Request) // 1
    ->pipe($processApiRequest) // (2,3)
    ->pipe(new ConvertToResponseDto); // 4 
    
$pipeline->process(new DeleteBlogPost($postId));
```

## Fork-Join

Sometimes pipeline needs to fork into one of the disparate paths which aren't related
to each other.

For example, for payload `x` take separate paths depending upon whether `2*x+1` is 0,
positive, or negative and divide final result by 5.

```php
$pipeline = (new Pipeline)
    ->pipe(new TimeTwoStage)
    ->pipe(new AddOneStage)
    ->fork(function($payload) {
            if($payload == 0) return "zero";
            if($payload < 0) return "-";
            if($payload > 0) return "+";
            return false; // for short-circuit
        })
        ->disjoin("zero")
            ->pipe(new ReturnZeroStage)
        ->disjoin("-")
            ->pipe(new ExponentOfTwoStage)
            ->pipe(new AddOneStage)
        ->disjoin("+")
            ->pipe(new SquareRootStage)
            ->pipe(new TimeThirteenStage)
        ->join()
    ->pipe(new TimesEightStage);
```

In order to fork, you need to call `fork` on a pipeline and provide `resolver` of type 
`callable` as argument. The `resolver` should return a tag to identify which disjoint
path to take in the fork. After that, you will need to create disjoins. Each disjoin is
a disparate path which can be followed in the fork. Each disjoin needs to be named with
a tag. Finally calling `join` on a fork joins it and the parent pipeline processing can
resume.

You can optionally pass a stage or a pipeline to `disjoin()`. Like so:

```php
->disjoin("zero", $zeroProcessingPipeline)
    ->disjoin("-", $negativeNumberProcessingPipeline)
    ->disjoin("+", $positiveNumberProcessingPipeline)
    ->join()
```


## Pipeline Builders

Because pipelines themselves are immutable, pipeline builders are introduced to
facilitate distributed composition of a pipeline.

The pipeline builders collect stages and allow you to create a pipeline at
any given time.

```php
use League\Pipeline\PipelineBuilder;

// Prepare the builder
$pipelineBuilder = (new PipelineBuilder)
    ->add(new LogicalStage)
    ->add(new AnotherStage)
    ->add(new LastStage);

// Build the pipeline
$pipeline = $pipelineBuilder->build();
```

## Exception handling

This package is completely transparent when dealing with exceptions. In no case
will this package catch an exception or silence an error. Exceptions should be
dealt with on a per-case basis. Either inside a __stage__ or at the time the
pipeline processes a payload.

```php
$pipeline = (new Pipeline)->pipe(function () {
    throw new LogicException();
});
    
try {
    $pipeline->process($payload);
} catch(LogicException $e) {
    // Handle the exception.
}
```
