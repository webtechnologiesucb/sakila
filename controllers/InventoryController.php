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

class InventoryController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/inventorylist[/{inventory_id}]", [PermissionMiddleware::class], "list.inventory")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "InventoryList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/inventoryadd[/{inventory_id}]", [PermissionMiddleware::class], "add.inventory")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "InventoryAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/inventoryview[/{inventory_id}]", [PermissionMiddleware::class], "view.inventory")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "InventoryView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/inventoryedit[/{inventory_id}]", [PermissionMiddleware::class], "edit.inventory")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "InventoryEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/inventorydelete[/{inventory_id}]", [PermissionMiddleware::class], "delete.inventory")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "InventoryDelete");
    }
}
