<?php

namespace PHPMaker2024\Sakila;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;
use Slim\Exception\HttpUnauthorizedException;
use PHPMaker2024\Sakila\Attributes\Delete;
use PHPMaker2024\Sakila\Attributes\Get;
use PHPMaker2024\Sakila\Attributes\Map;
use PHPMaker2024\Sakila\Attributes\Options;
use PHPMaker2024\Sakila\Attributes\Patch;
use PHPMaker2024\Sakila\Attributes\Post;
use PHPMaker2024\Sakila\Attributes\Put;

/**
 * Class others controller
 */
class OthersController extends ControllerBase
{
    // personaldata
    #[Map(["GET","POST","OPTIONS"], "/personaldata", [PermissionMiddleware::class], "personaldata")]
    public function personaldata(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PersonalData");
    }

    // login
    #[Map(["GET","POST","OPTIONS"], "/login[/{provider}]", [PermissionMiddleware::class], "login")]
    public function login(Request $request, Response $response, array $args): Response
    {
        global $Error;
        $Error = $this->container->get("app.flash")->getFirstMessage("error");
        return $this->runPage($request, $response, $args, "Login");
    }

    // logout
    #[Map(["GET","POST","OPTIONS"], "/logout", [PermissionMiddleware::class], "logout")]
    public function logout(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Logout");
    }

    // Swagger
    #[Get("/swagger/swagger", [], "swagger")]
    public function swagger(Request $request, Response $response, array $args): Response
    {
        $basePath = GetBasePath($request);
        $lang = $this->container->get("app.language");
        $title = $lang->phrase("ApiTitle");
        if (!$title || $title == "ApiTitle") {
            $title = "REST API"; // Default
        }
        $data = [
            "title" => $title,
            "version" => Config("API_VERSION"),
            "basePath" => $basePath
        ];
        $view = $this->container->get("app.view");
        return $view->render($response, "swagger.php", $data);
    }

    // Index
    #[Get("/[index]", [PermissionMiddleware::class], "index")]
    public function index(Request $request, Response $response, array $args): Response
    {
        global $Security, $USER_LEVEL_TABLES;
        $url = "";
        foreach ($USER_LEVEL_TABLES as $t) {
            if ($t[0] == "DashboardAll") { // Check default table
                if ($Security->allowList($t[4] . $t[0])) {
                    $url = $t[5];
                    break;
                }
            } elseif ($url == "") {
                if ($t[5] && $Security->allowList($t[4] . $t[0])) {
                    $url = $t[5];
                }
            }
        }
        if ($url === "" && !$Security->isLoggedIn()) {
            $url = "login";
        }
        if ($url == "") {
            throw new HttpUnauthorizedException($request, DeniedMessage());
        }
        return $response->withHeader("Location", $url)->withStatus(302);
    }
}
