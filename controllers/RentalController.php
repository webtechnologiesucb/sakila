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

class RentalController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/rentallist[/{rental_id}]", [PermissionMiddleware::class], "list.rental")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RentalList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/rentaladd[/{rental_id}]", [PermissionMiddleware::class], "add.rental")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RentalAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/rentalview[/{rental_id}]", [PermissionMiddleware::class], "view.rental")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RentalView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/rentaledit[/{rental_id}]", [PermissionMiddleware::class], "edit.rental")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RentalEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/rentaldelete[/{rental_id}]", [PermissionMiddleware::class], "delete.rental")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RentalDelete");
    }
}
