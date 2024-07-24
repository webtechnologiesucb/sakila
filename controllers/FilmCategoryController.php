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

class FilmCategoryController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/filmcategorylist[/{keys:.*}]", [PermissionMiddleware::class], "list.film_category")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "FilmCategoryList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/filmcategoryadd[/{keys:.*}]", [PermissionMiddleware::class], "add.film_category")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "FilmCategoryAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/filmcategoryview[/{keys:.*}]", [PermissionMiddleware::class], "view.film_category")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "FilmCategoryView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/filmcategoryedit[/{keys:.*}]", [PermissionMiddleware::class], "edit.film_category")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "FilmCategoryEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/filmcategorydelete[/{keys:.*}]", [PermissionMiddleware::class], "delete.film_category")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $this->getKeyParams($args), "FilmCategoryDelete");
    }

    // Get keys as associative array
    protected function getKeyParams($args)
    {
        global $RouteValues;
        if (array_key_exists("keys", $args)) {
            $sep = Container("film_category")->RouteCompositeKeySeparator;
            $keys = explode($sep, $args["keys"]);
            if (count($keys) == 2) {
                $keyArgs = array_combine(["film_id","category_id"], $keys);
                $RouteValues = array_merge(Route(), $keyArgs);
                $args = array_merge($args, $keyArgs);
            }
        }
        return $args;
    }
}
