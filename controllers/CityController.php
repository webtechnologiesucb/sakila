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

class CityController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/citylist[/{city_id}]", [PermissionMiddleware::class], "list.city")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CityList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/cityadd[/{city_id}]", [PermissionMiddleware::class], "add.city")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CityAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/cityview[/{city_id}]", [PermissionMiddleware::class], "view.city")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CityView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/cityedit[/{city_id}]", [PermissionMiddleware::class], "edit.city")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CityEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/citydelete[/{city_id}]", [PermissionMiddleware::class], "delete.city")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CityDelete");
    }
}
