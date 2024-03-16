<?php

namespace Src\Services;

use Src\Config;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

class Router
{
    public static function body(WP_REST_Request $request): array
    {
        $body = $request->get_json_params();

        return $body == null ? [] : $body;
    }

    public static function response(int $status_code, array|object $data): WP_REST_Response
    {
        $response = new WP_REST_Response($data);
        $response->set_status($status_code < 100 || $status_code > 599 ? 500 : $status_code);

        return $response;
    }

    public static function route(string $method, string $resource_name, string $route_name, array $callback, array $permission_callback): void
    {
        register_rest_route(
            Config::REST_API_PREFIX.$resource_name,
            $route_name,
            [
                'methods' => $method,
                'callback' => $callback,
                'permission_callback' => $permission_callback,
            ]
        );
    }

    public static function get(string $resource_name, string $route_name, array $callback, array $permission_callback): void
    {
        Router::route("GET", $resource_name, $route_name, $callback, $permission_callback);
    }

    public static function post(string $resource_name, string $route_name, array $callback, array $permission_callback): void
    {
        Router::route("POST", $resource_name, $route_name, $callback, $permission_callback);
    }

    public static function patch(string $resource_name, string $route_name, array $callback, array $permission_callback): void
    {
        Router::route("PATCH", $resource_name, $route_name, $callback, $permission_callback);
    }

    public static function delete(string $resource_name, string $route_name, array $callback, array $permission_callback): void
    {
        Router::route("DELETE", $resource_name, $route_name, $callback, $permission_callback);
    }

    public static function public_can_access(): bool
    {
        return true;
    }

    public static function noone_can_access(): bool
    {
        return false;
    }

    public static function is_user_logged_in_can_access(): bool
    {
        return is_user_logged_in();
    }

    public static function manage_options_can_access(): bool|WP_Error
    {
        if (! current_user_can('manage_options')) {
            return new WP_Error(
                'rest_forbidden',
                'You are not authorized to access this endpoint.',
                ['status' => 401]
            );
        }

        return true;
    }
}
