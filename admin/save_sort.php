<?php
/*-----------引入檔案區--------------*/
include_once 'header.php';
include_once '../function.php';
$updateRecordsArray = $_POST['node-'];
$sort = 1;
foreach ($updateRecordsArray as $menuid) {
    $sql = 'update ' . $xoopsDB->prefix('tad_themes_menu') . " set `position`='{$sort}' where `menuid`='{$menuid}'";
    $xoopsDB->queryF($sql) or die('Save Sort Fail! (' . date('Y-m-d H:i:s') . ')');
    $sort++;
}

echo 'Save Sort OK! (' . date('Y-m-d H:i:s') . ')';
