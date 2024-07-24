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

class FilmController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/filmlist[/{film_id}]", [PermissionMiddleware::class], "list.film")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FilmList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/filmadd[/{film_id}]", [PermissionMiddleware::class], "add.film")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FilmAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/filmview[/{film_id}]", [PermissionMiddleware::class], "view.film")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FilmView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/filmedit[/{film_id}]", [PermissionMiddleware::class], "edit.film")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FilmEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/filmdelete[/{film_id}]", [PermissionMiddleware::class], "delete.film")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FilmDelete");
    }
}
