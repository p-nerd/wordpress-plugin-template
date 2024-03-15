<?php

namespace Includes\RESTs;

use Exception;
use Includes\Services\Coupon;
use Includes\Services\Option;
use Includes\Services\Router;
use Throwable;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

class Settings
{
    const RESOURCE_NAME = '/settings';

    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes(): void
    {
        Router::get($this, "/options", "get_options", "manage_options");
        Router::post($this, "/options", "set_options", "manage_options");

        Router::get($this, '/coupons', "get_coupons", "manage_options");
        Router::post($this, '/coupons', "save_coupon", "manage_options");
        Router::delete($this, '/coupons/(?P<name>[a-zA-Z0-9-]+)', "remove_coupon", "manage_options");
    }

    public function manage_options(): bool|WP_Error
    {
        return Router::manage_options_can_access();
    }

    public function get_options(): WP_REST_Response
    {
        try {
            return Router::response2(
                200,
                [
                    "paystub_amount" => Option::get_paystub_amount(),
                    "w2_amount" => Option::get_w2_amount(),
                    "ten99_misc_amount" => Option::get_ten99_misc_amount(),
                    "stripe_secret_key" => Option::get_stripe_secret_key(),
                    "stripe_publishable_key" => Option::get_stripe_publishable_key(),
                    "paypal_client_id" => Option::get_paypal_client_id(),
                    "paypal_client_secret" => Option::get_paypal_client_secret(),
                    "wayforpay_merchant_account" => Option::get_wayforpay_merchant_account(),
                    "wayforpay_secret_key" => Option::get_wayforpay_secret_key(),
                    "wayforpay_merchant_domain_name" => Option::get_wayforpay_merchant_domain_name(),
                ]
            );
        } catch (Throwable $th) {
            return Router::response2(500, ["message" => $th->getMessage()]);
        }
    }

    public function set_options(WP_REST_Request $request): WP_REST_Response
    {
        try {
            $body = Router::get_body($request);

            return Router::response2(
                201,
                [
                    "paystub_amount" => Option::set_paystub_amount($body["paystub_amount"]),
                    "w2_amount" => Option::set_w2_amount($body["w2_amount"]),
                    "ten99_misc_amount" => Option::set_ten99_misc_amount($body["ten99_misc_amount"]),
                    "stripe_secret_key" => Option::set_stripe_secret_key($body["stripe_secret_key"]),
                    "stripe_publishable_key" => Option::set_stripe_publishable_key($body["stripe_publishable_key"]),
                    "paypal_client_id" => Option::set_paypal_client_id($body["paypal_client_id"]),
                    "paypal_client_secret" => Option::set_paypal_client_secret($body["paypal_client_secret"]),
                    "wayforpay_merchant_account" => Option::set_wayforpay_merchant_account($body["wayforpay_merchant_account"]),
                    "wayforpay_secret_key" => Option::set_wayforpay_secret_key($body["wayforpay_secret_key"]),
                    "wayforpay_merchant_domain_name" => Option::set_wayforpay_merchant_domain_name($body["wayforpay_merchant_domain_name"]),
                ]
            );
        } catch (Throwable $th) {
            return Router::response2(500, ["message" => $th->getMessage()]);
        }
    }

    public function get_coupons(): WP_REST_Response
    {
        try {
            return Router::response2(200, Coupon::get_coupons());
        } catch (Exception $th) {
            return Router::response2($th->getCode(), ["message" => $th->getMessage()]);
        }
    }

    public function save_coupon(WP_REST_Request $request): WP_REST_Response
    {
        $body = Router::get_body($request);
        try {
            $result = Coupon::add_coupon($body["name"], $body["percentage"], $body["usage_limit"], floatval($body["fixed_amount"]) * 100);

            return Router::response2(201, $result);
        } catch (Exception $th) {
            return Router::response2(
                $th->getCode(),
                [
                    "message" => $th->getMessage(),
                ]
            );
        }
    }

    public function remove_coupon(WP_REST_Request $request): WP_REST_Response
    {
        try {
            $name = $request->get_param('name');
            if (! is_string($name)) {
                throw new Exception("couponName must be a valid string value");
            }
            $result = Coupon::remove_coupon($name);

            return Router::response2(204, $result);
        } catch (Exception $th) {
            return Router::response2(
                $th->getCode(),
                [
                    "message" => $th->getMessage(),
                ]
            );
        } catch (Throwable) {
            return Router::response2(500, ["message" => "Error in deleting coupons from Option table"]);
        }
    }
}
