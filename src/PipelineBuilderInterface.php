<?php
namespace League\Pipeline;

interface PipelineBuilderInterface
{
    /**
     * Add an stage.
     *
     * @param callable $stage
     *
     * @return $this
     */
    public function add(callable $stage);

    /**
     * Build a new Pipeline object
     *
     * @param  ProcessorInterface|null $processor
     *
     * @return PipelineInterface
     */
    public function build(ProcessorInterface $processor = null);
}
