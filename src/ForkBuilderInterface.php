<?php
/**
 * Created by PhpStorm.
 * User: juzerali
 * Date: 09/01/18
 * Time: 7:28 PM
 */

namespace League\Pipeline;


interface ForkBuilderInterface extends BuilderInterface
{
    public function disjoin(string $tag, callable $stage = null);
}
