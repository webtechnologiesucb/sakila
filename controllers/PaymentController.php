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

class PaymentController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/paymentlist[/{payment_id}]", [PermissionMiddleware::class], "list.payment")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PaymentList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/paymentadd[/{payment_id}]", [PermissionMiddleware::class], "add.payment")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PaymentAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/paymentview[/{payment_id}]", [PermissionMiddleware::class], "view.payment")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PaymentView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/paymentedit[/{payment_id}]", [PermissionMiddleware::class], "edit.payment")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PaymentEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/paymentdelete[/{payment_id}]", [PermissionMiddleware::class], "delete.payment")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PaymentDelete");
    }
}
