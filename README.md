# League\Pipeline

This package provides a pipeline pattern implementation.

## Pipeline Pattern

The pipeline pattern allows you to easily compose sequential operations by
chaining operations.

In this particular implementation the interface consists of two parts:

* OperationInterface
* PipelineInterface

A pipeline consists of zero, one, or multiple operations. A pipeline can process
a payload. During the processing the payload will be passed to the first operation.
From that moment on the resulting value is passed on from operation to operation.

In the simplest form, the execution chain can be represented as a foreach:

```php
$result = $payload;

foreach ($operations as $operation) {
    $result = $operation->process($result);
}

return $result;
```

## Immutability

Pipelines are implemented as immutable operation chains. When you pipe a new
operation, a new pipelines will be created with the added operation. This makes
pipelines easy to reuse, and minimizes side-effects.

## Simple Example

```php
use League\Pipeline\Pipeline;
use League\Pipeline\OperationInterface;

class TimesTwoOperation implements OperationInterface
{
    public function process($payload)
    {
        return $payload * 2;
    }
}

class AddOneOperation implements OperationInterface
{
    public function process($payload)
    {
        return $payload + 1;
    }
}

$pipeline = (new Pipeline)
    ->pipe(new TimeTwoOperation)
    ->pipe(new AddOneOperation);

// Returns 21
$pipeline->process(10);
```

## Re-usable Pipelines

Because the PipelineInterface is an extension of the OperationInterface
pipelines can be re-used as operations. This creates a highly composable model
to create complex execution patterns while keeping the cognitive load low.

For example, if we'd want to compose a pipeline to process API calls, we'd create
something along these lines:

```php
$processApiRequest = (new Pipeline)
    ->pipe(new ExecuteHttpRequest) // 2
    ->pipe(new ParseParseJsonResponse); // 3
    
$pipeline = (new Pipeline)
    ->pipe(new ConvertToPsr7Request) // 1
    ->pipe($processApiRequest) // (2,3)
    ->pipe(new ConvertToResponseDto); // 4 
    
$pipeline->process(new DeleteBlogPost($postId));
```

## Callable Operations

The `CallableOperation` class is supplied to encapsulate parameters which satisfy
the `callable` typehint. This class enables you to use any type of callable as an
operation.

```php
$pipeline = (new Pipeline)
    ->pipe(CallableOperation::forCallable(function ($payload) {
        return $payload * 10;
    }));

// or

$pipeline = (new Pipeline)
    ->pipe(new CallableOperation(function ($payload) {
        return $payload * 10;
    }));
```

## Pipeline Builders

Because Pipelines themselves are immutable, pipeline builders are introduced to
facilitate distributed composition of a pipeline.

The PipelineBuilder's collect operations and allow you to create a pipelines at
any given time.

```php
use League\Pipeline\PipelineBuilder;

$pipelineBuilder = new PipelineBuilder;
$pipelineBuilder->add(new LogicalOperation);
$pipelineBuilder->add(new AnotherOperation);
$pipelineBuilder->add(new LastOperation);

$pipeline = $pipelineBuilder->build();
```

