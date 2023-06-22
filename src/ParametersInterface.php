<?php
declare(strict_types=1);

namespace League\Pipeline;

interface ParametersInterface
{
    /**
     * Get parameters for each stage.
     *
     * @return array
     */
    public function getParameters();

    /**
     * Set parameters for each stage.
     *
     * @param array $params
     *
     * @return void
     */
    public function setParameters(...$params);
}
