<?php

namespace League\Pipeline;


class DisjointPipelineBuilder extends PipelineBuilder implements DisjointPipelineBuilderInterface
{
    private $parent;

    public function __construct(ForkBuilder $parent, callable $stage = null)
    {
        if($stage != null) $this->stages[] = $stage;
        $this->parent = $parent;
    }

    public function disjoin(string $tag, callable $stage = null)
    {
        return $this->parent->disjoin($tag, $stage);
    }

    public function join()
    {
        return $this->parent->join();
    }
}
