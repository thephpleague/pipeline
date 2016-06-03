<?php

namespace League\Pipeline;

interface ProcessorInterface
{
    /**
     * @param array $stages
     * @param mixed $payload
     *
     * @return mixed
     */
    public function process(array $stages, $payload);
}
