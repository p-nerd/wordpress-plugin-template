<?php

namespace Src\Exposes;

use Kucrut\Vite;
use Src\Config;

class Admin
{
    public function __construct()
    {
        add_action("admin_enqueue_scripts", [$this, "add_enqueue_scripts"]);
        add_action("admin_menu", [$this, "add_admin_menu"]);
    }

    private const ADMIN_DIST_DIR = "/admin/dist";

    private const ADMIN_ENTRY_JS = "src/index.tsx";

    public function add_enqueue_scripts(): void
    {
        Vite\enqueue_asset(
            Config::PATH.self::ADMIN_DIST_DIR,
            self::ADMIN_ENTRY_JS,
            [
                "handle" => self::HANDLE,
                "in-footer" => true,
            ]
        );
        wp_localize_script(
            self::HANDLE,
            "localize",
            [
                "api_base_url" => home_url("/wp-json"),
                "nonce" => wp_create_nonce("wp_rest"),
                "admin_root_div_id" => Config::ADMIN_ROOT_DIV_ID,
            ]
        );
    }

    private const HANDLE = Config::NAME_SLUG."-admin-handle";

    public function add_admin_menu(): void
    {
        $parent_page_title = Config::NAME." Settings";
        $parent_menu_title = Config::NAME." Settings";
        $capability = "manage_options";
        $menu_slug = Config::NAME_SLUG."-admin";
        $parent_callback = [$this, "callback_menu_page_template"];
        $icon_url = "dashicons-editor-justify";
        $position = 80;

        add_menu_page($parent_page_title, $parent_menu_title, $capability, $menu_slug, $parent_callback, $icon_url, $position);
        add_submenu_page($menu_slug, $parent_page_title, "xx Settings", $capability, $menu_slug, $parent_callback);
    }

    public function callback_menu_page_template(): void
    {
        $root_div_id_name = Config::ADMIN_ROOT_DIV_ID;
        echo "<div class='wrap'><div id='$root_div_id_name'></div></div>";
    }
}
