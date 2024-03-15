<?php

namespace Includes\Services;

use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

class Router
{
    private const BASE_URL = "/wpt/v1";

    public static function get_body(WP_REST_Request $request): array
    {
        $body = $request->get_json_params();

        return $body == null ? [] : $body;
    }

    public static function response2(int $status_code, array|object $data): WP_REST_Response
    {
        $response = new WP_REST_Response($data);
        $response->set_status($status_code < 100 || $status_code > 599 ? 500 : $status_code);

        return $response;
    }

    public static function route($class, string $method, string $routeName, string $callback, string $permissionCallback): void
    {
        $namespace = self::BASE_URL.$class::RESOURCE_NAME;
        $route = $routeName;
        $args = [
            'methods' => $method,
            'callback' => [$class, $callback],
            'permission_callback' => [$class, $permissionCallback],
        ];
        register_rest_route($namespace, $route, $args);
    }

    public static function setPermalinkToPostname(): void
    {
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure('/%postname%/');
    }

    public static function get($class, string $routeName, string $callback, string $permissionCallback): void
    {
        Router::route($class, "GET", $routeName, $callback, $permissionCallback);
    }

    public static function post($class, string $routeName, string $callback, string $permissionCallback): void
    {
        Router::route($class, "POST", $routeName, $callback, $permissionCallback);
    }

    public static function delete($class, string $routeName, string $callback, string $permissionCallback): void
    {
        Router::route($class, "DELETE", $routeName, $callback, $permissionCallback);
    }

    public static function patch($class, string $routeName, string $callback, string $permissionCallback): void
    {
        Router::route($class, "PATCH", $routeName, $callback, $permissionCallback);
    }

    public static function public_can_access(): bool
    {
        return true;
    }

    public static function noOneCanAccess(): bool
    {
        return false;
    }

    public static function logged_in_user_emailCanAccess(): bool
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
