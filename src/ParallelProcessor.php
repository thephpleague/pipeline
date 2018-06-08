<?php
/**
 * @package League
 * @subpackage Pipeline
 *
 * @author Fernando Almeida <nanditu@gmail.com>
 */

namespace League\Pipeline;

/**
 * Allow parallel processing of results from a stage
 * returning an array with all results appended
 */
class ParallelProcessor implements ProcessorInterface
{
    
    /**
     * ParallelProcessor constructor.
     *
     */
    public function __construct()
    {
        
    }
    /**
     * @param array $stages
     * @param mixed $payload
     *
     * @return mixed
     */
    public function process(array $stages, $payload)
    {
        $results = [];
        foreach ($stages as $stage) {
            $result = call_user_func($stage, $payload);
            array_push($results, $result);
        }
        return $results;
    }
}
