<?php

namespace PetrZavicak;

class Helper
{
    public static function active_class_by_segments($segments, $className = null)
    {
        $config = config('helper.active_menu_class');

        if(!$className) {
            if($config && isset($config['class_name'])) {
                $className = $config['class_name'];
            } else {
                $className = 'active';
            }
        }

        $isActive = false;

        $segments = explode('/', $segments);

/*        if (count(request()->segments()) > count($segments)) {
            return '';
        }*/

        foreach ($segments as $index => $segment) {
            if ($segment == '?' || $segment == '*') {
                return $className;
            }
            if ($segment != request()->segment($index + 1)) {
                return '';
            }
        }

        return $className;
    }

    public static function humanFileSize ($bytes, $si = false) {

        $thresh = $si ? 1000 : 1024;

        if($bytes < $thresh) {
            return $bytes + ' B';
        }

        $units = $si
            ? ['kB','MB','GB','TB','PB','EB','ZB','YB']
            : ['KiB','MiB','GiB','TiB','PiB','EiB','ZiB','YiB'];

        $u = -1;

        do {
            $bytes /= $thresh;
            ++$u;
        } while($bytes >= $thresh && $u < count($units) - 1);

        return round($bytes, 1) . ' ' . $units[$u];
    }

    public static function convertPHPSizeToBytes($sSize)
    {
        if ( is_numeric( $sSize) ) {
            return $sSize;
        }

        $sSuffix = substr($sSize, -1);
        $iValue = substr($sSize, 0, -1);

        switch(strtoupper($sSuffix)){
            case 'P':
                $iValue *= 1024;
            case 'T':
                $iValue *= 1024;
            case 'G':
                $iValue *= 1024;
            case 'M':
                $iValue *= 1024;
            case 'K':
                $iValue *= 1024;
                break;
        }

        return $iValue;
    }

    public static function getMaximumFileUploadSize($textVersion = false)
    {
        $maxUploadSize = min(self::convertPHPSizeToBytes(ini_get('post_max_size')), self::convertPHPSizeToBytes(ini_get('upload_max_filesize')));

        return $textVersion ? self::humanFileSize($maxUploadSize) : $maxUploadSize;
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