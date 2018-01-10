<?php

namespace League\Pipeline;


interface DisjointPipelineBuilderInterface extends PipelineBuilderInterface, ForkBuilderInterface
{
    public function join();
}
