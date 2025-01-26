<?php

namespace ClassyPhp\Classy\Classes;

// This class is a simple wrapper around PHP's superglobals to make it easier to work with request data.
class Request {
    /**
     * Check if a parameter exists in a specific request type
     * 
     * @param string $key Parameter name
     * @param string|null $type Request type (get/post), defaults to auto-detect
     * @return bool
     */
    public static function has(string $key, ?string $type = null): bool {
        $type = self::determineRequestType($type);
        return $type === 'post' ? isset($_POST[$key]) : isset($_GET[$key]);
    }

    /**
     * Get a parameter as a string
     * 
     * @param string $key Parameter name
     * @param string $default Default value if parameter doesn't exist
     * @param string|null $type Request type (get/post), defaults to auto-detect
     * @return string
     */
    public static function paramStr(string $key, string $default = '', ?string $type = null): string {
        $type = self::determineRequestType($type);
        $source = $type === 'post' ? $_POST : $_GET;
        return isset($source[$key]) ? (string)$source[$key] : $default;
    }

    /**
     * Get a parameter as an integer
     * 
     * @param string $key Parameter name
     * @param int $default Default value if parameter doesn't exist
     * @param string|null $type Request type (get/post), defaults to auto-detect
     * @return int
     */
    public static function paramInt(string $key, int $default = 0, ?string $type = null): int {
        $type = self::determineRequestType($type);
        $source = $type === 'post' ? $_POST : $_GET;
        return isset($source[$key]) ? (int)$source[$key] : $default;
    }

    /**
     * Get a parameter as an array
     * 
     * @param string $key Parameter name
     * @param array $default Default value if parameter doesn't exist
     * @param string|null $type Request type (get/post), defaults to auto-detect
     * @return array
     */
    public static function paramArray(string $key, array $default = [], ?string $type = null): array {
        $type = self::determineRequestType($type);
        $source = $type === 'post' ? $_POST : $_GET;
        return isset($source[$key]) && is_array($source[$key]) ? $source[$key] : $default;
    }

    /**
     * Get a parameter as a float
     * 
     * @param string $key Parameter name
     * @param float $default Default value if parameter doesn't exist
     * @param string|null $type Request type (get/post), defaults to auto-detect
     * @return float
     */
    public static function paramFloat(string $key, float $default = 0.0, ?string $type = null): float {
        $type = self::determineRequestType($type);
        $source = $type === 'post' ? $_POST : $_GET;
        return isset($source[$key]) ? (float)$source[$key] : $default;
    }

    /**
     * Get a parameter as a boolean
     * 
     * @param string $key Parameter name
     * @param bool $default Default value if parameter doesn't exist
     * @param string|null $type Request type (get/post), defaults to auto-detect
     * @return bool
     */
    public static function paramBool(string $key, bool $default = false, ?string $type = null): bool {
        $type = self::determineRequestType($type);
        $source = $type === 'post' ? $_POST : $_GET;
        
        if (!isset($source[$key])) {
            return $default;
        }
        
        $value = $source[$key];
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $default;
    }

    /**
     * Get all parameters for a specific request type
     * 
     * @param string|null $type Request type (get/post), defaults to auto-detect
     * @return array
     */
    public static function getAllParams(?string $type = null): array {
        $type = self::determineRequestType($type);
        return $type === 'post' ? $_POST : $_GET;
    }

    /**
     * Determine the request type
     * 
     * @param string|null $type Explicitly provided type
     * @return string
     */
    private static function determineRequestType(?string $type): string {
        if ($type !== null) {
            return strtolower($type) === 'post' ? 'post' : 'get';
        }
        
        return strtolower($_SERVER['REQUEST_METHOD']) === 'post' ? 'post' : 'get';
    }

    // Existing methods that don't need modification
    public static function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public static function isGet(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public static function getRequestBody(): string {
        return file_get_contents('php://input');
    }

    public static function isAjax(): bool {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public static function sanitizeString(string $input): string {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }

    public static function validateEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
