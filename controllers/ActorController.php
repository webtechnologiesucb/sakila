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

class ActorController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/actorlist[/{actor_id}]", [PermissionMiddleware::class], "list.actor")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ActorList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/actoradd[/{actor_id}]", [PermissionMiddleware::class], "add.actor")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ActorAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/actorview[/{actor_id}]", [PermissionMiddleware::class], "view.actor")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ActorView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/actoredit[/{actor_id}]", [PermissionMiddleware::class], "edit.actor")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ActorEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/actordelete[/{actor_id}]", [PermissionMiddleware::class], "delete.actor")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ActorDelete");
    }
}
