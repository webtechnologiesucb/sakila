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

class CountryController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/countrylist[/{country_id}]", [PermissionMiddleware::class], "list.country")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CountryList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/countryadd[/{country_id}]", [PermissionMiddleware::class], "add.country")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CountryAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/countryview[/{country_id}]", [PermissionMiddleware::class], "view.country")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CountryView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/countryedit[/{country_id}]", [PermissionMiddleware::class], "edit.country")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CountryEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/countrydelete[/{country_id}]", [PermissionMiddleware::class], "delete.country")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CountryDelete");
    }
}
