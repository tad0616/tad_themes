<?php

namespace XoopsModules\Tad_themes;

/*
Update Class Definition

You may not change or alter any portion of this comment or credits of
supporting developers from this source code or any supporting source code
which is considered copyrighted (c) material of the original comment or credit
authors.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       Mamba <mambax7@gmail.com>
 */

/**
 * Class Update
 */
class Tools
{
    //data_center 加入 sort
    public static function del_theme_json($theme_name = '')
    {
        global $xoopsConfig;
        if (empty($theme_name)) {
            $theme_name = $xoopsConfig['theme_set'];
        }

        $json_file = XOOPS_VAR_PATH . "/data/theme_{$theme_name}.json";
        unlink($json_file);
        // file_put_contents($json_file, json_encode($_POST, 256));
    }

}
