<?php
declare(strict_types=1);

namespace League\Pipeline;

trait ParametersTrait
{
    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * Get parameters for each stage.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set parameters for each stage.
     *
     * @param array $params
     * @return void
     */
    public function setParameters(...$params)
    {
        $this->parameters = $params;
    }
}