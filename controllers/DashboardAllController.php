<?php

namespace PHPMaker2024\Sakila;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPMaker2024\Sakila\Attributes\Delete;
use PHPMaker2024\Sakila\Attributes\Get;
use PHPMaker2024\Sakila\Attributes\Map;
use PHPMaker2024\Sakila\Attributes\Options;
use PHPMaker2024\Sakila\Attributes\Patch;
use PHPMaker2024\Sakila\Attributes\Post;
use PHPMaker2024\Sakila\Attributes\Put;

/**
 * DashboardAll controller
 */
class DashboardAllController extends ControllerBase
{
    // dashboard
    #[Map(["GET", "POST", "OPTIONS"], "/dashboardall", [PermissionMiddleware::class], "dashboard.DashboardAll")]
    public function dashboard(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "DashboardAll");
    }
}
