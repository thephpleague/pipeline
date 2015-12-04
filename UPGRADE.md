# Upgrade guide

## From 0.1.0 to 0.2.0

Callables don't have to be wrapped anymore.

```php
// BEFORE
$pipeline->pipe(CallableStage::forCallable(function ($payload) {
    return $payload;
}))->process($payload);

// After
$pipeline->pipe(function ($payload) {
    return $payload;
})->process($payload);
```

Class based stages now require to implement the `__invoke` method.

```php
// BEFORE
class MyStage implements StageInterface
{
    public function process($payload)
    {
        return $payload;
     }
}

// AFTER
class MyStage implements StageInterface
{
    public function __invoke($payload)
    {
        return $payload;
     }
}
```