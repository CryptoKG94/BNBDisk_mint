<?php

if (!function_exists('formatSize')) {
    /**
     * Random Element - Takes an array as input and returns a random element
     *
     * @param    array
     * @return    mixed    depends on what the array contains
     */
    function formatSize($size)
    {
        $sz = (int)($size * 100 / 1024.0) / 100.0;
        if ($sz > 1024) {
            $sz = (int)($sz * 100 / 1024.0) / 100.0;
            return $sz . "MB";
        }
        return $sz . "KB";
    }
}
