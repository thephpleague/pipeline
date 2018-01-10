<?php

namespace League\Pipeline;


interface ForkedPipelineBuilderInterface extends ForkBuilderInterface
{
    public function join();
}
