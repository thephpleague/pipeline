<?php
/**
 * Created by PhpStorm.
 * User: juzerali
 * Date: 09/01/18
 * Time: 7:35 PM
 */

namespace League\Pipeline;


class ForkBuilder implements ForkBuilderInterface
{
    /**
     * @var PipelineBuilder
     */
    private $parent;


    private $forks = [];

    private $resolver;

    /**
     * @var BuilderInterface
     */
    private $currentBuilder;
    private $currentTag;

    public function __construct(callable $resolver, PipelineBuilder $parent)
    {
        $this->resolver = $resolver;
        $this->parent = $parent;
    }

    public function disjoin(string $tag, callable $stage = null)
    {
        $this->buildPrevious();
        $this->currentTag = $tag;
        $this->currentBuilder = new DisjointPipelineBuilder($this, $stage);
        return $this->currentBuilder;
    }

    public function join()
    {
        $this->buildPrevious();
        return $this->parent;
    }

    private function buildPrevious()
    {
        if($this->currentTag == null) return;
        $this->forks[$this->currentTag] = $this->currentBuilder->build();

        $this->currentTag = null;
        $this->currentBuilder = null;
    }

    public function build()
    {
        return new Fork($this->resolver, $this->forks);
    }
}
