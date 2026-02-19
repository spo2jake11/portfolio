<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('time_elapsed')) {
    /**
     * Calculate time elapsed since a given timestamp
     * 
     * @param string $datetime The datetime string (Y-m-d H:i:s format)
     * @return string Human readable time elapsed
     */
    function time_elapsed($datetime)
    {
        $time = strtotime($datetime);
        $current_time = time();
        $elapsed = $current_time - $time;

        if ($elapsed < 60) {
            return $elapsed . ' second' . ($elapsed > 1 ? 's' : '') . ' ago';
        } else if ($elapsed < 3600) {
            $minutes = floor($elapsed / 60);
            return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
        } else if ($elapsed < 86400) {
            $hours = floor($elapsed / 3600);
            return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
        } else if ($elapsed < 604800) {
            $days = floor($elapsed / 86400);
            return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
        } else if ($elapsed < 2592000) {
            $weeks = floor($elapsed / 604800);
            return $weeks . ' week' . ($weeks > 1 ? 's' : '') . ' ago';
        } else if ($elapsed < 31536000) {
            $months = floor($elapsed / 2592000);
            return $months . ' month' . ($months > 1 ? 's' : '') . ' ago';
        } else {
            $years = floor($elapsed / 31536000);
            return $years . ' year' . ($years > 1 ? 's' : '') . ' ago';
        }
    }
}
