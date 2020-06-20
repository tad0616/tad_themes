<?php
$modversion = [];

//---模組基本資訊---//
$modversion['name'] = _MI_TADTHEMES_NAME;
$modversion['version'] = '6.6';
$modversion['description'] = _MI_TADTHEMES_DESC;
$modversion['author'] = 'tad (tad0616@gmail.com)';
$modversion['credits'] = 'hirokofan (hirokofan@mail.cyc.edu.tw)';
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image'] = "images/logo_{$xoopsConfig['language']}.png";
$modversion['dirname'] = basename(__DIR__);

//---模組狀態資訊---//
$modversion['release_date'] = '2020/06/20';
$modversion['module_website_url'] = 'https://www.tad0616.net/';
$modversion['module_website_name'] = _MI_TAD_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'https://www.tad0616.net/';
$modversion['author_website_name'] = _MI_TAD_WEB;
$modversion['min_php'] = 5.4;
$modversion['min_xoops'] = '2.5.9';
$modversion['min_tadtools'] = '3.26';

//---paypal資訊---//
$modversion['paypal'] = [];
$modversion['paypal']['business'] = 'tad0616@gmail.com';
$modversion['paypal']['item_name'] = 'Donation : ' . _MI_TAD_WEB;
$modversion['paypal']['amount'] = 0;
$modversion['paypal']['currency_code'] = 'USD';

//---後台使用系統選單---//
$modversion['system_menu'] = 1;

//---資料表架構---//
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][1] = 'tad_themes';
$modversion['tables'][2] = 'tad_themes_files_center';
$modversion['tables'][3] = 'tad_themes_menu';
$modversion['tables'][4] = 'tad_themes_blocks';
$modversion['tables'][5] = 'tad_themes_config2';
$modversion['tables'][6] = 'tad_themes_data_center';

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

//---前台主選單設定---//
$modversion['hasMain'] = 0;
//$modversion['sub'][1]['name'] = '';
//$modversion['sub'][1]['url'] = '';

//---模組自動功能---//
$modversion['onInstall'] = 'include/onInstall.php';
$modversion['onUpdate'] = 'include/onUpdate.php';
$modversion['onUninstall'] = 'include/onUninstall.php';

//---樣板設定---//
$modversion['templates'] = [];
$i = 0;
$modversion['templates'][$i]['file'] = 'tad_themes_adm_main.tpl';
$modversion['templates'][$i]['description'] = 'tad_themes_adm_main.tpl';

$i++;
$modversion['templates'][$i]['file'] = 'tad_themes_adm_dropdown.tpl';
$modversion['templates'][$i]['description'] = 'tad_themes_adm_dropdown.tpl';

$i++;
$modversion['templates'][$i]['file'] = 'tad_themes_adm_font2pic.tpl';
$modversion['templates'][$i]['description'] = 'tad_themes_adm_font2pic.tpl';

//---偏好設定---//
$modversion['config'] = [];
$i++;
$modversion['config'][$i]['name'] = 'auto_mainmenu';
$modversion['config'][$i]['title'] = '_MI_TADTHEMES_AUTO_MENU';
$modversion['config'][$i]['description'] = '_MI_TADTHEMES_AUTO_MENU_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'show_sitename';
$modversion['config'][$i]['title'] = '_MI_TADTHEMES_SHOW_SITENAME';
$modversion['config'][$i]['description'] = '_MI_TADTHEMES_SHOW_SITENAME_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';
$modversion['config'][$i]['options'] = [_MI_TADTHEMES_HIDE => '2', _MI_TADTHEMES_HOME => '0', _MI_TADTHEMES_SITENAME => '1'];

$i++;
$modversion['config'][$i]['name'] = 'openid_login';
$modversion['config'][$i]['title'] = '_MI_TADTHEMES_TITLE2';
$modversion['config'][$i]['description'] = '_MI_TADTHEMES_DESC2';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';
$modversion['config'][$i]['options'] = [_MI_TADTHEMES_TITLE2_OPT0 => '0', _MI_TADTHEMES_TITLE2_OPT1 => '1', _MI_TADTHEMES_TITLE2_OPT2 => '2', _MI_TADTHEMES_TITLE2_OPT3 => '3'];

$i++;
$modversion['config'][$i]['name'] = 'openid_logo';
$modversion['config'][$i]['title'] = '_MI_TADTHEMES_TITLE3';
$modversion['config'][$i]['description'] = '_MI_TADTHEMES_DESC3';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '4';
$modversion['config'][$i]['options'] = [1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6'];

//---搜尋---//
//$modversion['hasSearch'] = 1;
//$modversion['search']['file'] = "include/search.php";
//$modversion['search']['func'] = "搜尋函數名稱";

//---區塊設定---//
$modversion['blocks'][1]['file'] = 'tad_themes_responsive_slider.php';
$modversion['blocks'][1]['name'] = _MI_TADTHEMES_BNAME1;
$modversion['blocks'][1]['description'] = _MI_TADTHEMES_BDESC1;
$modversion['blocks'][1]['show_func'] = 'tad_themes_responsive_slider';
$modversion['blocks'][1]['template'] = 'tad_themes_responsive_slider.tpl';

$modversion['blocks'][2]['file'] = 'tad_themes_top_menu.php';
$modversion['blocks'][2]['name'] = _MI_TADTHEMES_BNAME2;
$modversion['blocks'][2]['description'] = _MI_TADTHEMES_BDESC2;
$modversion['blocks'][2]['show_func'] = 'tad_themes_top_menu';
$modversion['blocks'][2]['template'] = 'tad_themes_top_menu.tpl';
$modversion['blocks'][2]['edit_func'] = 'tad_themes_top_menu_edit';
$modversion['blocks'][2]['options'] = '';

$modversion['blocks'][3]['file'] = 'vertical_bootstrap_menu.php';
$modversion['blocks'][3]['name'] = _MI_TADTHEMES_BNAME3;
$modversion['blocks'][3]['description'] = _MI_TADTHEMES_BDESC3;
$modversion['blocks'][3]['show_func'] = 'vertical_bootstrap_menu';
$modversion['blocks'][3]['template'] = 'vertical_bootstrap_menu.tpl';
$modversion['blocks'][3]['edit_func'] = 'vertical_bootstrap_menu_edit';
$modversion['blocks'][3]['options'] = '';

$modversion['blocks'][4]['file'] = 'vertical_menu.php';
$modversion['blocks'][4]['name'] = _MI_TADTHEMES_BNAME4;
$modversion['blocks'][4]['description'] = _MI_TADTHEMES_BDESC4;
$modversion['blocks'][4]['show_func'] = 'vertical_menu';
$modversion['blocks'][4]['template'] = 'vertical_menu.tpl';
$modversion['blocks'][4]['edit_func'] = 'vertical_menu_edit';
$modversion['blocks'][4]['options'] = '|0';
