<?php

namespace League\Pipeline;

interface OperationInterface
{
    /**
     * Process the payload.
     *
     * @param  mixed $payload
     * @return mixed
     */
    public function process($payload);
}
