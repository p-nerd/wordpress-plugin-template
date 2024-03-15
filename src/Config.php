<?php

namespace Src;

class Config
{
    public const URL = SHIHAB_PLUGIN_DIR_URL;

    public const BASENAME = SHIHAB_PLUGIN_BASENAME;

    public const PATH = SHIHAB_PLUGIN_DIR_PATH;

    public const NAME = "WordPress Plugin Boilerplate";

    public const NAME_SLUG = "wordpress-plugin-boilerplate";

    //@MUST: if you change it, also must change in admin/tailwind.config.js
    public const ADMIN_ROOT_DIV_ID = "wordpress-plugin-boilerplate-admin-root-id";
}
