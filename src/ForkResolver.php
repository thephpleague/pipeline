<?php
/**
 * Created by PhpStorm.
 * User: juzerali
 * Date: 09/01/18
 * Time: 2:35 PM
 */

namespace League\Pipeline;


interface ForkResolver
{
    /**
     * Resolve the direction in the fork. Should return the tag of the disjoin.
     * Return false to short-circuit the fork and directly jump to join.
     *
     * @param mixed $payload
     *
     * @return string|integer|boolean
     */
    public function __invoke($payload);
}
