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

class CategoryController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/categorylist[/{category_id}]", [PermissionMiddleware::class], "list.category")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CategoryList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/categoryadd[/{category_id}]", [PermissionMiddleware::class], "add.category")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CategoryAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/categoryview[/{category_id}]", [PermissionMiddleware::class], "view.category")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CategoryView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/categoryedit[/{category_id}]", [PermissionMiddleware::class], "edit.category")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CategoryEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/categorydelete[/{category_id}]", [PermissionMiddleware::class], "delete.category")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CategoryDelete");
    }
}
