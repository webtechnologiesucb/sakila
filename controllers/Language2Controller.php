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

class Language2Controller extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/language2list[/{language_id}]", [PermissionMiddleware::class], "list.language2")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Language2List");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/language2add[/{language_id}]", [PermissionMiddleware::class], "add.language2")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Language2Add");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/language2view[/{language_id}]", [PermissionMiddleware::class], "view.language2")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Language2View");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/language2edit[/{language_id}]", [PermissionMiddleware::class], "edit.language2")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Language2Edit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/language2delete[/{language_id}]", [PermissionMiddleware::class], "delete.language2")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Language2Delete");
    }
}
