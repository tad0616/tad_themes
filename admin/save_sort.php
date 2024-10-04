<?php
/*-----------引入檔案區--------------*/
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';
$updateRecordsArray = $_POST['node-'];
$sort = 1;
foreach ($updateRecordsArray as $menuid) {
    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes_menu') . '`
        SET `position` = ?
        WHERE `menuid` = ?';
    Utility::query($sql, 'ii', [$sort, $menuid]) or die('Save Sort Fail! (' . date('Y-m-d H:i:s') . ');');

    $sort++;
}

echo 'Save Sort OK! (' . date('Y-m-d H:i:s') . ')';
