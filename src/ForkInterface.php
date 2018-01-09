<?php

namespace League\Pipeline;


interface ForkInterface extends StageInterface
{
    /**
     * Builder method that joins all the branches in a fork
     *
     * @param callable|null $resolver
     *
     * @return PipelineInterface
     */
    public function join(callable $resolver = null);

    /**
     * Adds a branch to the fork.
     *
     * @param string $tag
     * @param callable|null $stage
     *
     * @return DisjointAwarePipelineInterface
     */
    public function disjoin(string $tag, callable $stage = null);
}
