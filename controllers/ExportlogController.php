<?php

namespace PHPMaker2024\Sakila;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPMaker2024\Sakila\Attributes\Delete;
use PHPMaker2024\Sakila\Attributes\Get;
use PHPMaker2024\Sakila\Attributes\Map;
use PHPMaker2024\Sakila\Attributes\Options;
use PHPMaker2024\Sakila\Attributes\Patch;
use PHPMaker2024\Sakila\Attributes\Post;
use PHPMaker2024\Sakila\Attributes\Put;

class ExportlogController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/exportloglist[/{FileId:.*}]", [PermissionMiddleware::class], "list.exportlog")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ExportlogList");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/exportlogview[/{FileId:.*}]", [PermissionMiddleware::class], "view.exportlog")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ExportlogView");
    }
}
