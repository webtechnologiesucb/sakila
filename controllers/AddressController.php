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

class AddressController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/addresslist[/{address_id}]", [PermissionMiddleware::class], "list.address")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AddressList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/addressadd[/{address_id}]", [PermissionMiddleware::class], "add.address")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AddressAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/addressview[/{address_id}]", [PermissionMiddleware::class], "view.address")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AddressView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/addressedit[/{address_id}]", [PermissionMiddleware::class], "edit.address")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AddressEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/addressdelete[/{address_id}]", [PermissionMiddleware::class], "delete.address")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AddressDelete");
    }
}
