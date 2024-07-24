<?php

namespace PHPMaker2024\Sakila;

/**
 * Chart renderer interface
 */
interface ChartRendererInterface
{

    public function getContainer($width, $height);

    public function getScript($width, $height);
}
