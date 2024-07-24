<?php

namespace PHPMaker2024\Sakila;

use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Menu Rendering Event
 */
class MenuRenderingEvent extends GenericEvent
{
    public const NAME = "menu.rendering";

    public function getMenu(): Menu
    {
        return $this->subject;
    }
}
