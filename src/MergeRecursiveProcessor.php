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
 * returning an array with all results merged
 */
class MergeRecursiveProcessor implements ProcessorInterface
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

            $results = is_array($result)
                    ? array_merge_recursive($results, $result)
                    : array_merge_recursive($results, [$result]);
          
        }
        return $results;
    }
}
