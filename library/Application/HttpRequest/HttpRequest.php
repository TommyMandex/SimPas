<?php

namespace Application\HttpRequest;

use Application\Security\DataFilters\PreDatabaseSave;

class HttpRequest
{
    /**
     * POST Request.
     *
     * @param string $field_name
     * @param bool   $restricted_characters
     *
     * @return string|bool
     */
    public static function post($field_name, $restricted_characters = false)
    {
        if (isset($_POST[$field_name]) === false) {
            return false;
        }

        if ($_POST[$field_name] == null) {
            return false;
        }

        $_POST[$field_name] = (new PreDatabaseSave())->filter($_POST[$field_name], $restricted_characters);

        return $_POST[$field_name];
    }

    /**
     * Check whether given fields are not empty.
     *
     * @param array  $fields
     * @param string $required_field
     *
     * @return bool
     */
    public static function isEmptyField(array $fields, $required_field = null)
    {
        if (!count($fields)) {
            return false;
        }

        $empty = false;

        foreach ($fields as $field) {
            if ($field === false && $field !== $required_field) {
                continue;
            }

            $field = preg_replace('/[\s\t\r\n]+/s', null, $field);

            if ($field == null) {
                $empty = true;
            }
        }

        return $empty;
    }

    /**
     * Client IP (IPv4 / IPv6).
     *
     * @return string
     */
    public static function getClientIpAddress()
    {
        $_ip = filter_var(getenv('REMOTE_ADDR'), FILTER_VALIDATE_IP);

        if ($_ip === false) {
            $_ip = '0.0.0.0';
        }

        return $_ip;
    }
}
