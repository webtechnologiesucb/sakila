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

class StaffController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/stafflist[/{staff_id}]", [PermissionMiddleware::class], "list.staff")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StaffList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/staffadd[/{staff_id}]", [PermissionMiddleware::class], "add.staff")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StaffAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/staffview[/{staff_id}]", [PermissionMiddleware::class], "view.staff")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StaffView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/staffedit[/{staff_id}]", [PermissionMiddleware::class], "edit.staff")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StaffEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/staffdelete[/{staff_id}]", [PermissionMiddleware::class], "delete.staff")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StaffDelete");
    }
}
