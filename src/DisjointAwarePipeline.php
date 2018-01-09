<?php
/**
 * Created by PhpStorm.
 * User: juzerali
 * Date: 09/01/18
 * Time: 1:58 PM
 */

namespace League\Pipeline;

/**
 * Internal class used as a wrapper around pipelines within a fork.
 * There should be no need to use this class directly.
 *
 * Class DisjointAwarePipeline
 * @package League\Pipeline
 */
class DisjointAwarePipeline extends Pipeline implements DisjointAwarePipelineInterface
{
    /**
     * @var Fork
     */
    public $fork;

    /**
     * DisjointAwarePipeline constructor.
     * @param Fork $fork
     */
    public function __construct(Fork $fork)
    {
        parent::__construct();
        $this->fork = $fork;
    }

    /**
     * @inheritdoc
     */
    public function disjoin(string $tag, callable $stage = null)
    {
        return $this->fork->disjoin($tag, $stage);
    }

    /**
     * @inheritdoc
     */
    public function join(callable $resolver = null)
    {
        return $this->fork->join($resolver);
    }

    /**
     * @inheritdoc
     */
    public function pipe(callable $stage)
    {
        $this->stages[] = $stage;
        return $this;
    }
}
