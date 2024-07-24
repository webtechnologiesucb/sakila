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

class SalesByStoreController extends ControllerBase
{
    // SalesByStore (chart)
    #[Map(["GET", "POST", "OPTIONS"], "/salesbystorelist/SalesByStore", [PermissionMiddleware::class], "list.sales_by_store.SalesByStore")]
    public function SalesByStore(Request $request, Response $response, array $args): Response
    {
        return $this->runChart($request, $response, $args, "SalesByStoreList", "SalesByStore");
    }

    // SalesByManager (chart)
    #[Map(["GET", "POST", "OPTIONS"], "/salesbystorelist/SalesByManager", [PermissionMiddleware::class], "list.sales_by_store.SalesByManager")]
    public function SalesByManager(Request $request, Response $response, array $args): Response
    {
        return $this->runChart($request, $response, $args, "SalesByStoreList", "SalesByManager");
    }

    // list
    #[Map(["GET","POST","OPTIONS"], "/salesbystorelist", [PermissionMiddleware::class], "list.sales_by_store")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "SalesByStoreList");
    }
}
