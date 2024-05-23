<?php

if (! function_exists('nameAndNickName')) {
    /**
     * get first and second name from full name
     *
     * @param string $name
     * @return string
     */
    function nameAndNickName(string $name) {
        $name = trim($name);
        if (! empty($name) && strpos($name, ' ') !== false) {
            $arrName = explode(' ', $name);
            $name    = implode(' ', [$arrName[0], $arrName[1]]);
        }
        return ucwords(strtolower($name));
    }

    if (! function_exists('convertTimestampToBrDate')) {
        /**
         * Convert timestamp to Brazilian date format
         *
         * @param string $timestamp
         * @return string
         */
        function formatDate(string $timestamp, string $format = 'd/m/Y') {
            if (strlen($timestamp) == 10) {
                $timestamp .= ' 00:00:00';
            }
            $date = new DateTime($timestamp);
            return $date->format($format);
        }
    }
}