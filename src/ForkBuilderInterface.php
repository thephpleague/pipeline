<?php

namespace League\Pipeline;


interface ForkBuilderInterface extends BuilderInterface
{
    public function disjoin(string $tag, callable $stage = null);
}
