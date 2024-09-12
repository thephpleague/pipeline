# League\Pipeline

[![Author](https://img.shields.io/badge/author-@frankdejonge-blue.svg?style=flat-square)](https://twitter.com/frankdejonge)
[![Maintainer](https://img.shields.io/badge/maintainer-@shadowhand-blue.svg?style=flat-square)](https://twitter.com/shadowhand)
[![Build Status](https://img.shields.io/travis/thephpleague/pipeline/master.svg?style=flat-square)](https://travis-ci.org/thephpleague/pipeline)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/thephpleague/pipeline.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/pipeline/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/thephpleague/pipeline.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/pipeline)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/league/pipeline.svg?style=flat-square)](https://packagist.org/packages/league/pipeline)
[![Total Downloads](https://img.shields.io/packagist/dt/league/pipeline.svg?style=flat-square)](https://packagist.org/packages/league/pipeline)

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
pipelines easy to reuse, and minimizes side effects.

## Usage

Operations in a pipeline, stages, can be anything that satisfies the `callable`
type-hint. So closures and anything that's invokable is good.

```php
$pipeline = (new Pipeline)->pipe(function ($payload) {
    return $payload * 10;
});

// or 

$pipeline = Pipeline::init()->pipe(function ($payload) {
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

## Pipeline Builders

Because pipelines themselves are immutable, pipeline builders are introduced to
facilitate distributed composition of a pipeline.

The pipeline builders collect stages and allow you to create a pipeline at
any given time.

```php
use League\Pipeline\PipelineBuilder;

// Prepare the builder
// $pipelineBuilder = PipelineBuilder::init()
// or
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
