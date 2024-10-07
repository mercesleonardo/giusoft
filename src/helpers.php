<?php

if (!function_exists('env')) {
    /**
     * Retrieve an environment variable or return a default value.
     *
     * @param string $key The environment variable key.
     * @param mixed|null $default The default value if the variable is not found.
     *
     * @return mixed The environment variable value or the default.
     */
    function env(string $key, mixed $default = null): mixed {
        return $_ENV[$key] ?? getenv($key) ?: $default;
    }
}
