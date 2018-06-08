<?php
/**
 * @package League
 * @subpackage Pipeline
 *
 * @author Fernando Almeida <nanditu@gmail.com>
 */

namespace League\Pipeline;

/**
 * Allow a stage to be executed executed based on a conditional check of the payload
 */
class ConditionalStage implements StageInterface
{
	/**
	 * Callable function that takes the payload
	 * and returns a boolean evaluatable result
	 * @var callable
	 */
	protected $conditionFn;

	/**
	 * Stage to process the payload if the condition is NOT verified
	 * @var StageInterface
	 */
	protected $stageIfFalse;

	/**
	 * Stage to invoke if the condition is verified
	 * @var StageInterface
	 */
	protected $stageIfTrue;

	/**
	 * Constructor
	 * @param callable $conditionFn Callable with boolean evaluatable return type that gets passed the payload
	 * @param StageInterface $stageIfTrue Stage to invoke if the condition evaluates to true
	 * @param StageInterface $stageIfFalse Stage to invoke if the condition evaluates to false
	 */
	public function __construct(callable $conditionFn,
							    callable $stageIfTrue,
							    callable $stageIfFalse ) {
		$this->conditionFn = $conditionFn;
		$this->stageIfTrue = $stageIfTrue;
		$this->stageIfFalse = $stageIfFalse;
	}

    /**
     * Process the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function __invoke($payload) {
    	return ($this->conditionFn)($payload)
    		  ? ($this->stageIfTrue)($payload)
    		  : ($this->stageIfFalse)($payload);
    }
}
