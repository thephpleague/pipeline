<?php
/**
 * Created by PhpStorm.
 * User: juzerali
 * Date: 09/01/18
 * Time: 7:29 PM
 */

namespace League\Pipeline;


interface ForkedPipelineBuilderInterface extends ForkBuilderInterface
{
    public function join();
}
