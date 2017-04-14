<?php

namespace League\Pipeline;

interface ProcessorInterface
{
    /**
     * @param callable[] $stages
     * @param mixed      $payload
     * @param mixed      ...$params
     *
     * @return mixed
     */
    public function process(array $stages, $payload, ...$params);
}
