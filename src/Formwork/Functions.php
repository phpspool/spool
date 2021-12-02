<?php

/**
 * Help functions
 */


if (!function_exists('env')) {
    function env(string $key, string $defaultValue = null): string
    {
        return BASE_PATH;
    }
}
