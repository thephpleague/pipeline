<?php

namespace League\Pipeline;

use Illuminate\Database\Schema\Builder;

class PipelineBuilder implements PipelineBuilderInterface
{
    /**
     * @var callable[]
     */
    protected $stages = [];

    /**
     * @var ProcessorInterface
     */
    private $processr;

    /**
     * @var BuilderInterface
     */
    private $last;

    /**
     * Add an stage.
     *
     * @param callable $stage
     *
     * @return $this
     */
    public function pipe(callable $stage)
    {
        $this->buildLast();
        $this->stages[] = $stage;

        return $this;
    }

    public function fork(callable $resolver)
    {
        $this->buildLast();
        $this->last = new ForkBuilder($resolver, $this);
        return $this->last;
    }

    public function processor(ProcessorInterface $processor)
    {
        $this->processr = $processor;
    }

    private function buildLast()
    {
        if($this->last == null) return;
        $this->stages[] = $this->last->build();
        $this->last = null;
    }

    /**
     * Build a new Pipeline object
     *
     * @return Pipeline
     */
    public function build()
    {
        $this->buildLast();
        return new Pipeline($this->stages, $this->processr);
    }
}
