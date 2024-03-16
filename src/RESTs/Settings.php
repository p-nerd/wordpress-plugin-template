<?php

namespace Src\RESTs;

use Src\Services\Router;
use Throwable;
use WP_Error;
use WP_REST_Response;

class Settings
{
    public const RESOURCE_NAME = '/settings';

    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes(): void
    {
        Router::get(self::RESOURCE_NAME, "/hello", [$this, "hello"], [$this, "public"]);
    }

    public function public(): bool|WP_Error
    {
        return Router::public_can_access();
    }

    public function hello(): WP_REST_Response
    {
        try {
            return Router::response(
                200,
                [
                    "message" => "Hello World",
                ]
            );
        } catch (Throwable $th) {
            return Router::response(500, ["message" => $th->getMessage()]);
        }
    }
}
