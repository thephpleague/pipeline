---
layout: default
permalink: /usage/
title: Usage
---

# Using League\Pipeline

## Basic Example

~~~php
use League\Pipeline\Pipeline;
use League\Pipeline\StageInterface;

class TimesTwoStage implements StageInterface
{
    public function process($payload)
    {
        return $payload * 2;
    }
}

class AddOneStage implements StageInterface
{
    public function process($payload)
    {
        return $payload + 1;
    }
}

$pipeline = (new Pipeline)
    ->pipe(new TimeTwoStage)
    ->pipe(new AddOneStage);

// Returns 21
$pipeline->process(10);
~~~

## Re-usable Pipelines

Because the PipelineInterface is an extension of the StageInterface
pipelines can be re-used as stages. This creates a highly composable model
to create complex execution patterns while keeping the cognitive load low.

For example, if we'd want to compose a pipeline to process API calls, we'd create
something along these lines:

~~~php
$processApiRequest = (new Pipeline)
    ->pipe(new ExecuteHttpRequest) // 2
    ->pipe(new ParseParseJsonResponse); // 3
    
$pipeline = (new Pipeline)
    ->pipe(new ConvertToPsr7Request) // 1
    ->pipe($processApiRequest) // (2,3)
    ->pipe(new ConvertToResponseDto); // 4 
    
$pipeline->process(new DeleteBlogPost($postId));
~~~

## Callable Stages

The `CallableStage` class is supplied to encapsulate parameters which satisfy
the `callable` type-hint. This class enables you to use any type of callable as an
stage.

~~~php
$pipeline = (new Pipeline)
    ->pipe(CallableStage::forCallable(function ($payload) {
        return $payload * 10;
    }));

// or

$pipeline = (new Pipeline)
    ->pipe(new CallableStage(function ($payload) {
        return $payload * 10;
    }));
~~~

## Pipeline Builders

Because Pipelines themselves are immutable, pipeline builders are introduced to
facilitate distributed composition of a pipeline.

The PipelineBuilder's collect stages and allow you to create a pipelines at
any given time.

~~~php
use League\Pipeline\PipelineBuilder;

// Prepare the builder
$pipelineBuilder = (new PipelineBuilder)
    ->add(new LogicalStage)
    ->add(new AnotherStage)
    ->add(new LastStage);

// Build the pipeline
$pipeline = $pipelineBuilder->build();
~~~

## Exception handling

This package is completely transparent when dealing with exception. In no case
will this package catch an exception or silence an error. Exception should be
dealt with on a per-case basic. Either inside a __stage__ or at time when the
pipeline processes a payload.

~~~php
$pipeline = (new Pipeline)
    ->pipe(CallableStage::forCallable(function () {
        throw new LogicException();
    });
    
try {
    $pipeline->process($payload);
} catch(LogicException $e) {
    // Handle the exception.
}
~~~