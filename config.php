<?php

namespace config;

/**
 * Description of config
 *
 * @author deepak
 */
class config {

    static function getSettings($key = null, $path = '') {
//        if (ENV == 'development' || CATCHE_CLEAR == 'TRUE') {
//            apc_delete('ini');
//        }
//        if (!apc_exists('ini')) {
        $arSet = array();
        if (is_dir($path)) {
            $dir = scandir($path);
            foreach ($dir as $keys => $val) {
                if ($val != '.' && $val != '..') {
                    $settings = parse_ini_file($path . $val);
                    $arSet = array_merge($arSet, $settings);
                }
            }
        } else {
            $arSet = parse_ini_file($path != '' ? $path : 'app/config/app.ini');
        }
//            apc_add('ini', $arSet);
//        }
//        var_dump(apc_fetch('ini'));

        if ($key == null) {
            return $arSet;
        } else {
            return $arSet[$key];
        }
    }

}
