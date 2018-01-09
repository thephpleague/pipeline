<?php
/**
 * Created by PhpStorm.
 * User: juzerali
 * Date: 09/01/18
 * Time: 6:51 PM
 */

namespace League\Pipeline;


interface DisjointPipelineBuilderInterface extends PipelineBuilderInterface, ForkBuilderInterface
{
    public function join();
}
