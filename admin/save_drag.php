<?php
/*-----------引入檔案區--------------*/
include "../../../include/cp_header.php";

$of_level = intval(str_replace("node-_", "", $_POST['of_level']));
$menuid   = intval(str_replace("node-_", "", $_POST['menuid']));

if ($of_level == $menuid) {
    die(_MA_TREETABLE_MOVE_ERROR1 . "(" . date("Y-m-d H:i:s") . ")");
} elseif (chk_cate_path($menuid, $of_level)) {
    die(_MA_TREETABLE_MOVE_ERROR2 . "(" . date("Y-m-d H:i:s") . ")");
}

$sql = "update " . $xoopsDB->prefix("tad_themes_menu") . " set `of_level`='{$of_level}' where `menuid`='{$menuid}'";
$xoopsDB->queryF($sql) or die("Reset Fail! (" . date("Y-m-d H:i:s") . ")");

echo "Reset OK! (" . date("Y-m-d H:i:s") . ")";

//檢查目的地編號是否在其子目錄下
function chk_cate_path($menuid, $to_menuid)
{
    global $xoopsDB;
    //抓出子目錄的編號
    $sql    = "select menuid from " . $xoopsDB->prefix("tad_themes_menu") . " where of_level='{$menuid}'";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
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
