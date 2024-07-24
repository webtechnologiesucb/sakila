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

class SalesByFilmCategoryController extends ControllerBase
{
    // SalesByCategory (chart)
    #[Map(["GET", "POST", "OPTIONS"], "/salesbyfilmcategorylist/SalesByCategory", [PermissionMiddleware::class], "list.sales_by_film_category.SalesByCategory")]
    public function SalesByCategory(Request $request, Response $response, array $args): Response
    {
        return $this->runChart($request, $response, $args, "SalesByFilmCategoryList", "SalesByCategory");
    }

    // list
    #[Map(["GET","POST","OPTIONS"], "/salesbyfilmcategorylist", [PermissionMiddleware::class], "list.sales_by_film_category")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SalesByFilmCategoryList");
    }
}
