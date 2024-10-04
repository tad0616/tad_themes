<?php

use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
require dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';

$of_level = (int) str_replace('node-_', '', $_POST['of_level']);
$menuid = (int) str_replace('node-_', '', $_POST['menuid']);

if ($of_level == $menuid) {
    die(_MA_TREETABLE_MOVE_ERROR1 . '(' . date('Y-m-d H:i:s') . ')');
} elseif (chk_cate_path($menuid, $of_level)) {
    die(_MA_TREETABLE_MOVE_ERROR2 . '(' . date('Y-m-d H:i:s') . ')');
}

$sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes_menu') . '` SET `of_level`=? WHERE `menuid`=?';
Utility::query($sql, 'ii', [$of_level, $menuid]) or die('Reset Fail! (' . date('Y-m-d H:i:s') . ')');

echo 'Reset OK! (' . date('Y-m-d H:i:s') . ')';

//檢查目的地編號是否在其子目錄下
function chk_cate_path($menuid, $to_menuid)
{
    global $xoopsDB;
    //抓出子目錄的編號
    $sql = 'SELECT `menuid` FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `of_level`=?';
    $result = Utility::query($sql, 'i', [$menuid]) or Utility::web_error($sql, __FILE__, __LINE__);

    while (list($sub_menuid) = $xoopsDB->fetchRow($result)) {
        if (chk_cate_path($sub_menuid, $to_menuid)) {
            return true;
        }

        if ($sub_menuid == $to_menuid) {
            return true;
        }
    }

    return false;
}
