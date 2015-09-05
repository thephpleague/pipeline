<?php

namespace League\Pipeline;

use InvalidArgumentException;

class Pipeline implements PipelineInterface
{
    /**
     * @var StageInterface[]
     */
    private $stages = [];

    /**
     * Constructor.
     *
     * @param StageInterface[] $stages
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $stages = [])
    {
        foreach ($stages as $stage) {
            if (!$stage instanceof StageInterface) {
                throw new InvalidArgumentException('All stages should implement the '.StageInterface::class);
            }
        }

        $this->stages = $stages;
    }

    /**
     * {@inheritdoc}
     */
    public function pipe(StageInterface $stage)
    {
        $stages = $this->stages;
        $stages[] = $stage;

        return new static($stages);
    }

    /**
     * {@inheritdoc}
     */
    public function process($payload)
    {
        $reducer = function ($payload, StageInterface $stage) {
            return $stage->process($payload);
        };

        foreach ($this->stages as $stage) {
            $payload = $reducer($payload, $stage);
        }
        return $payload;
    }
}
