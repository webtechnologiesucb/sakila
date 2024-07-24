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

class FilmActorController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/filmactorlist[/{keys:.*}]", [PermissionMiddleware::class], "list.film_actor")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "FilmActorList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/filmactoradd[/{keys:.*}]", [PermissionMiddleware::class], "add.film_actor")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "FilmActorAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/filmactorview[/{keys:.*}]", [PermissionMiddleware::class], "view.film_actor")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "FilmActorView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/filmactoredit[/{keys:.*}]", [PermissionMiddleware::class], "edit.film_actor")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "FilmActorEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/filmactordelete[/{keys:.*}]", [PermissionMiddleware::class], "delete.film_actor")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "FilmActorDelete");
    }

    // Get keys as associative array
    protected function getKeyParams($args)
    {
        global $RouteValues;
        if (array_key_exists("keys", $args)) {
            $sep = Container("film_actor")->RouteCompositeKeySeparator;
            $keys = explode($sep, $args["keys"]);
            if (count($keys) == 2) {
                $keyArgs = array_combine(["actor_id","film_id"], $keys);
                $RouteValues = array_merge(Route(), $keyArgs);
                $args = array_merge($args, $keyArgs);
            }
        }
        return $args;
    }
}
