<?php
declare(strict_types=1);

namespace League\Pipeline;

use InvalidArgumentException;

class Pipeline implements PipelineInterface
{
    /**
     * @var callable[]
     */
    private $stages = [];

    /**
     * @var ProcessorInterface
     */
    private $processor;

    /**
     * @param callable[] $stages
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $stages = [], ProcessorInterface $processor = null)
    {
        foreach ($stages as $stage) {
            if (false === is_callable($stage)) {
                throw new InvalidArgumentException('All stages should be callable.');
            }
        }

        $this->stages = $stages;
        $this->processor = $processor ?? new FingersCrossedProcessor;
    }

    public function pipe(callable $stage): PipelineInterface
    {
        $pipeline = clone $this;
        $pipeline->stages[] = $stage;

        return $pipeline;
    }

    public function process($payload)
    {
        return $this->processor->process($this->stages, $payload);
    }

    public function __invoke($payload)
    {
        return $this->process($payload);
    }
}
