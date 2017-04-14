<?php

namespace League\Pipeline;

interface StageInterface
{
    /**
     * Process the payload
     *
     * @param mixed $payload
     * @param mixed ...$params
     *
     * @return mixed
     */
    public function __invoke($payload, ...$params);
}
