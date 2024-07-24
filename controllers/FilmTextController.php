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

class FilmTextController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/filmtextlist[/{film_id}]", [PermissionMiddleware::class], "list.film_text")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FilmTextList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/filmtextadd[/{film_id}]", [PermissionMiddleware::class], "add.film_text")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FilmTextAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/filmtextview[/{film_id}]", [PermissionMiddleware::class], "view.film_text")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FilmTextView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/filmtextedit[/{film_id}]", [PermissionMiddleware::class], "edit.film_text")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FilmTextEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/filmtextdelete[/{film_id}]", [PermissionMiddleware::class], "delete.film_text")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "FilmTextDelete");
    }
}
