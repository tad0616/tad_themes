<?php
$modversion = [];
global $xoopsConfig;

//---模組基本資訊---//
$modversion['name']        = _MI_TADTHEMES_NAME;
$modversion['version']     = $_SESSION['xoops_version'] >= 20511 ? '8.2.0-Stable' : '8.2';
$modversion['description'] = _MI_TADTHEMES_DESC;
$modversion['author']      = 'tad (tad0616@gmail.com)';
$modversion['credits']     = 'hirokofan (hirokofan@mail.cyc.edu.tw)';
$modversion['help']        = 'page=help';
$modversion['license']     = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image']       = "images/logo_{$xoopsConfig['language']}.png";
$modversion['dirname']     = basename(__DIR__);

//---模組狀態資訊---//
$modversion['release_date']        = '2025-08-29';
$modversion['module_website_url']  = 'https://www.tad0616.net/';
$modversion['module_website_name'] = _MI_TAD_WEB;
$modversion['module_status']       = 'release';
$modversion['author_website_url']  = 'https://www.tad0616.net/';
$modversion['author_website_name'] = _MI_TAD_WEB;
$modversion['min_php']             = 5.4;
$modversion['min_xoops']           = '2.5.10';

//---paypal資訊---//
$modversion['paypal'] = [
    'business' => 'tad0616@gmail.com',
    'item_name' => 'Donation : ' . _MI_TAD_WEB,
    'amount' => 0,
    'currency_code' => 'USD',
];

//---後台使用系統選單---//
$modversion['system_menu'] = 1;

//---資料表架構---//
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables']           = [
    'tad_themes',
    'tad_themes_files_center',
    'tad_themes_menu',
    'tad_themes_blocks',
    'tad_themes_config2',
    'tad_themes_data_center',
];

//---管理介面設定---//
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';

//---前台主選單設定---//
$modversion['hasMain'] = 0;
//$modversion['sub'][1]['name'] = '';
//$modversion['sub'][1]['url'] = '';

//---模組自動功能---//
$modversion['onInstall']   = 'include/onInstall.php';
$modversion['onUpdate']    = 'include/onUpdate.php';
$modversion['onUninstall'] = 'include/onUninstall.php';
//---樣板設定---//
$modversion['templates'] = [
    ['file' => 'tad_themes_adm_main.tpl', 'description' => 'tad_themes_adm_main.tpl'],
    ['file' => 'tad_themes_adm_dropdown.tpl', 'description' => 'tad_themes_adm_dropdown.tpl'],
    ['file' => 'tad_themes_adm_font2pic.tpl', 'description' => 'tad_themes_adm_font2pic.tpl'],
];

//---偏好設定---//
$modversion['config'] = [
    [
        'name' => 'auto_mainmenu',
        'title' => '_MI_TADTHEMES_AUTO_MENU',
        'description' => '_MI_TADTHEMES_AUTO_MENU_DESC',
        'formtype' => 'yesno',
        'valuetype' => 'int',
        'default' => 1,
    ],
    [
        'name' => 'auto_mainmenu_icon',
        'title' => '_MI_TADTHEMES_AUTO_MENU_ICON',
        'description' => '_MI_TADTHEMES_AUTO_MENU_ICON_DESC',
        'formtype' => 'textbox',
        'valuetype' => 'text',
        'default' => 'fa-list',
    ],
    [
        'name' => 'show_sitename',
        'title' => '_MI_TADTHEMES_SHOW_SITENAME',
        'description' => '_MI_TADTHEMES_SHOW_SITENAME_DESC',
        'formtype' => 'select',
        'valuetype' => 'int',
        'default' => '1',
        'options' => [_MI_TADTHEMES_HIDE => '2', _MI_TADTHEMES_HOME => '0', _MI_TADTHEMES_SITENAME => '1'],
    ],
    [
        'name' => 'openid_login',
        'title' => '_MI_TADTHEMES_TITLE2',
        'description' => '_MI_TADTHEMES_DESC2',
        'formtype' => 'select',
        'valuetype' => 'int',
        'default' => '1',
        'options' => [
            _MI_TADTHEMES_TITLE2_OPT0 => '0',
            _MI_TADTHEMES_TITLE2_OPT1 => '1',
            _MI_TADTHEMES_TITLE2_OPT2 => '2',
            _MI_TADTHEMES_TITLE2_OPT3 => '3',
        ],
    ],
    [
        'name' => 'openid_logo',
        'title' => '_MI_TADTHEMES_TITLE3',
        'description' => '_MI_TADTHEMES_DESC3',
        'formtype' => 'select',
        'valuetype' => 'int',
        'default' => '4',
        'options' => [1, 2, 3, 4, 5, 6],
    ],
    [
        'name' => 'use_pin',
        'title' => '_MI_TADTHEMES_USE_PIN',
        'description' => '_MI_TADTHEMES_USE_PIN_DESC',
        'formtype' => 'yesno',
        'valuetype' => 'int',
        'default' => '1',
    ],
    [
        'name' => 'login_text',
        'title' => '_MI_TADTHEMES_TITLE4',
        'description' => '_MI_TADTHEMES_DESC4',
        'formtype' => 'textbox',
        'valuetype' => 'text',
        'default' => _MI_TADTHEMES_DEFAULT4,
    ],
    [
        'name' => 'login_description',
        'title' => '_MI_TADTHEMES_TITLE5',
        'description' => '_MI_TADTHEMES_DESC5',
        'formtype' => 'textbox',
        'valuetype' => 'text',
    ],
];

//---搜尋---//
//$modversion['hasSearch'] = 1;
//$modversion['search']['file'] = "include/search.php";
//$modversion['search']['func'] = "搜尋函數名稱";

//---區塊設定 (索引為固定值，若欲刪除區塊記得補上索引，避免區塊重複)---//
$modversion['blocks'] = [
    1 => [
        'file' => 'tad_themes_responsive_slider.php',
        'name' => _MI_TADTHEMES_BNAME1,
        'description' => _MI_TADTHEMES_BDESC1,
        'show_func' => 'tad_themes_responsive_slider',
        'template' => 'tad_themes_responsive_slider.tpl',
    ],
    2 => [
        'file' => 'tad_themes_top_menu.php',
        'name' => _MI_TADTHEMES_BNAME2,
        'description' => _MI_TADTHEMES_BDESC2,
        'show_func' => 'tad_themes_top_menu',
        'template' => 'tad_themes_top_menu.tpl',
        'edit_func' => 'tad_themes_top_menu_edit',
        'options' => '',
    ],
    3 => [
        'file' => 'vertical_bootstrap_menu.php',
        'name' => _MI_TADTHEMES_BNAME3,
        'description' => _MI_TADTHEMES_BDESC3,
        'show_func' => 'vertical_bootstrap_menu',
        'template' => 'vertical_bootstrap_menu.tpl',
        'edit_func' => 'vertical_bootstrap_menu_edit',
        'options' => '',
    ],
    4 => [
        'file' => 'vertical_menu.php',
        'name' => _MI_TADTHEMES_BNAME4,
        'description' => _MI_TADTHEMES_BDESC4,
        'show_func' => 'vertical_menu',
        'template' => 'vertical_menu.tpl',
        'edit_func' => 'vertical_menu_edit',
        'options' => '|0',
    ],
];
