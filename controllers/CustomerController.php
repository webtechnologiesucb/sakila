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

class CustomerController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/customerlist[/{customer_id}]", [PermissionMiddleware::class], "list.customer")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CustomerList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/customeradd[/{customer_id}]", [PermissionMiddleware::class], "add.customer")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CustomerAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/customerview[/{customer_id}]", [PermissionMiddleware::class], "view.customer")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CustomerView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/customeredit[/{customer_id}]", [PermissionMiddleware::class], "edit.customer")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CustomerEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/customerdelete[/{customer_id}]", [PermissionMiddleware::class], "delete.customer")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CustomerDelete");
    }
}
