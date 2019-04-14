<?php

function xoops_module_uninstall_tad_themes(&$module)
{
    global $xoopsDB;

    $date = date('Ymd');

    rename(XOOPS_ROOT_PATH . '/uploads/tad_themes', XOOPS_ROOT_PATH . "/uploads/tad_themes_bak_{$date}");

    return true;
}
