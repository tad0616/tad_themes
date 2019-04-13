<?php
$adminmenu = [];
$icon_dir = '2.6' === mb_substr(XOOPS_VERSION, 6, 3) ? '' : 'images/';

$i = 1;
$adminmenu[$i]['title'] = _MI_TAD_ADMIN_HOME;
$adminmenu[$i]['link'] = 'admin/index.php';
$adminmenu[$i]['desc'] = _MI_TAD_ADMIN_HOME_DESC;
$adminmenu[$i]['icon'] = 'images/admin/home.png';

$i++;
$adminmenu[$i]['title'] = _MI_TADTHEMES_ADMENU1;
$adminmenu[$i]['link'] = 'admin/main.php';
$adminmenu[$i]['desc'] = _MI_TADTHEMES_ADMENU1;
$adminmenu[$i]['icon'] = 'images/admin/themes.png';

$i++;
$adminmenu[$i]['title'] = _MI_TADTHEMES_ADMENU2;
$adminmenu[$i]['link'] = 'admin/dropdown.php';
$adminmenu[$i]['desc'] = _MI_TADTHEMES_ADMENU2;
$adminmenu[$i]['icon'] = 'images/admin/menu.png';

$i++;
$adminmenu[$i]['title'] = _MI_TADTHEMES_ADMENU3;
$adminmenu[$i]['link'] = 'admin/font2pic.php';
$adminmenu[$i]['desc'] = _MI_TADTHEMES_ADMENU3;
$adminmenu[$i]['icon'] = 'images/admin/edit-text.png';

$i++;
$adminmenu[$i]['title'] = _MI_TAD_ADMIN_ABOUT;
$adminmenu[$i]['link'] = 'admin/about.php';
$adminmenu[$i]['desc'] = _MI_TAD_ADMIN_ABOUT_DESC;
$adminmenu[$i]['icon'] = 'images/admin/about.png';
