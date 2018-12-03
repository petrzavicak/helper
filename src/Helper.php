<?php

namespace PetrZavicak;

class Helper
{
    public static function active_menu_class($segments)
    {
        $segments = explode('/', $segments);
        if (count(request()->segments()) > count($segments)) {
            return '';
        }
        foreach ($segments as $index => $segment) {
            if ($segment == '?') {
                return 'active';
            }
            if ($segment != request()->segment($index + 1)) {
                return '';
            }
        }
        return 'active';
    }

    public static function meta_title($text)
    {
        $min = 30;
        $max = 60;
        $length = strlen($text);
        if ($length > $max) {
            throw new Exception('Meta title (aktuálně ' . $length . ' znaků) nesmí obsahovat více než ' . $max . ' znaků');
        } elseif ($length < $min) {
            throw new Exception('Meta title (aktuálně ' . $length . ' znaků) musí obsahovat alespoň ' . $min . ' znaků');
        }
        return $text;
    }

    public static function meta_description($text)
    {
        $min = 60;
        $max = 150;
        $length = strlen($text);
        if ($length > $max) {
            throw new Exception('Meta description (aktuálně ' . $length . ' znaků) nesmí obsahovat více než ' . $max . ' znaků');
        } elseif ($length < $min) {
            throw new Exception('Meta description (aktuálně ' . $length . ' znaků) musí obsahovat alespoň ' . $min . ' znaků');
        }
        return $text;
    }

}