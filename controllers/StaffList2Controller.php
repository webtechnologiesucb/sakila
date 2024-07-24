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

class StaffList2Controller extends ControllerBase
{
    // StaffByCountry (chart)
    #[Map(["GET", "POST", "OPTIONS"], "/stafflist2list/StaffByCountry", [PermissionMiddleware::class], "list.staff_list2.StaffByCountry")]
    public function StaffByCountry(Request $request, Response $response, array $args): Response
    {
        return $this->runChart($request, $response, $args, "StaffList2List", "StaffByCountry");
    }

    // StaffByCity (chart)
    #[Map(["GET", "POST", "OPTIONS"], "/stafflist2list/StaffByCity", [PermissionMiddleware::class], "list.staff_list2.StaffByCity")]
    public function StaffByCity(Request $request, Response $response, array $args): Response
    {
        return $this->runChart($request, $response, $args, "StaffList2List", "StaffByCity");
    }

    // list
    #[Map(["GET","POST","OPTIONS"], "/stafflist2list[/{ID}]", [PermissionMiddleware::class], "list.staff_list2")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "StaffList2List");
    }
}
