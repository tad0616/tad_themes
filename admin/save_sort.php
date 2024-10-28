<?php
use Xmf\Request;
/*-----------引入檔案區--------------*/
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';
// 關閉除錯訊息
$xoopsLogger->activated = false;

$updateRecordsArray = Request::getVar('node-', [], null, 'array', 4);
$sort = 1;
foreach ($updateRecordsArray as $menuid) {
    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes_menu') . '`
        SET `position` = ?
        WHERE `menuid` = ?';
    Utility::query($sql, 'ii', [$sort, $menuid]) or die(_TAD_SORT_FAIL . ' (' . date('Y-m-d H:i:s') . ');');

    $sort++;
}

echo _TAD_SORTED . "(" . date("Y-m-d H:i:s") . ")";
