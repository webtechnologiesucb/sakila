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

class StoreController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/storelist[/{store_id}]", [PermissionMiddleware::class], "list.store")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StoreList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/storeadd[/{store_id}]", [PermissionMiddleware::class], "add.store")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StoreAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/storeview[/{store_id}]", [PermissionMiddleware::class], "view.store")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StoreView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/storeedit[/{store_id}]", [PermissionMiddleware::class], "edit.store")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StoreEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/storedelete[/{store_id}]", [PermissionMiddleware::class], "delete.store")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StoreDelete");
    }
}
