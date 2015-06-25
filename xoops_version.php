<?php
$modversion = array();

//---模組基本資訊---//
$modversion['name']        = _MI_TADTHEMES_NAME;
$modversion['version']     = '3.7';
$modversion['description'] = _MI_TADTHEMES_DESC;
$modversion['author']      = 'tad (tad0616@gmail.com)';
$modversion['credits']     = 'hirokofan (hirokofan@mail.cyc.edu.tw)';
$modversion['help']        = 'page=help';
$modversion['license']     = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image']       = "images/logo_{$xoopsConfig['language']}.png";
$modversion['dirname']     = basename(dirname(__FILE__));

//---模組狀態資訊---//
$modversion['release_date']        = '2015/06/25';
$modversion['module_website_url']  = 'http://tad0616.net/';
$modversion['module_website_name'] = _MI_TAD_WEB;
$modversion['module_status']       = 'release';
$modversion['author_website_url']  = 'http://tad0616.net/';
$modversion['author_website_name'] = _MI_TAD_WEB;
$modversion['min_php']             = 5.2;
$modversion['min_xoops']           = '2.5';
$modversion['min_tadtools']        = '2.04';

//---paypal資訊---//
$modversion['paypal']                  = array();
$modversion['paypal']['business']      = 'tad0616@gmail.com';
$modversion['paypal']['item_name']     = 'Donation : ' . _MI_TAD_WEB;
$modversion['paypal']['amount']        = 0;
$modversion['paypal']['currency_code'] = 'USD';

//---後台使用系統選單---//
$modversion['system_menu'] = 1;

//---資料表架構---//
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][1]        = "tad_themes";
$modversion['tables'][2]        = "tad_themes_files_center";
$modversion['tables'][3]        = "tad_themes_menu";
$modversion['tables'][4]        = "tad_themes_blocks";
$modversion['tables'][5]        = "tad_themes_config2";

//---管理介面設定---//
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu']  = "admin/menu.php";

//---前台主選單設定---//
$modversion['hasMain'] = 0;
//$modversion['sub'][1]['name'] = '';
//$modversion['sub'][1]['url'] = '';

//---模組自動功能---//
$modversion['onInstall']   = "include/onInstall.php";
$modversion['onUpdate']    = "include/onUpdate.php";
$modversion['onUninstall'] = "include/onUninstall.php";

//---偏好設定---//
$modversion['config']                   = array();
$modversion['config'][0]['name']        = 'auto_mainmenu';
$modversion['config'][0]['title']       = '_MI_TADTHEMES_AUTO_MENU';
$modversion['config'][0]['description'] = '_MI_TADTHEMES_AUTO_MENU_DESC';
$modversion['config'][0]['formtype']    = 'yesno';
$modversion['config'][0]['valuetype']   = 'int';
$modversion['config'][0]['default']     = 1;

$modversion['config'][1]['name']        = 'show_sitename';
$modversion['config'][1]['title']       = '_MI_TADTHEMES_SHOW_SITENAME';
$modversion['config'][1]['description'] = '_MI_TADTHEMES_SHOW_SITENAME_DESC';
$modversion['config'][1]['formtype']    = 'yesno';
$modversion['config'][1]['valuetype']   = 'int';
$modversion['config'][1]['default']     = '1';

//---搜尋---//
//$modversion['hasSearch'] = 1;
//$modversion['search']['file'] = "include/search.php";
//$modversion['search']['func'] = "搜尋函數名稱";

//---區塊設定---//
$modversion['blocks'][1]['file']        = "tad_themes_responsive_slider.php";
$modversion['blocks'][1]['name']        = _MI_TADTHEMES_BNAME1;
$modversion['blocks'][1]['description'] = _MI_TADTHEMES_BDESC1;
$modversion['blocks'][1]['show_func']   = "tad_themes_responsive_slider";
$modversion['blocks'][1]['template']    = "tad_themes_responsive_slider.html";

$modversion['blocks'][2]['file']        = 'tad_themes_top_menu.php';
$modversion['blocks'][2]['name']        = _MI_TADTHEMES_BNAME2;
$modversion['blocks'][2]['description'] = _MI_TADTHEMES_BDESC2;
$modversion['blocks'][2]['show_func']   = 'tad_themes_top_menu';
$modversion['blocks'][2]['template']    = 'tad_themes_top_menu.html';
$modversion['blocks'][2]['edit_func']   = "tad_themes_top_menu_edit";
$modversion['blocks'][2]['options']     = "";

$modversion['blocks'][3]['file']        = 'vertical_bootstrap_menu.php';
$modversion['blocks'][3]['name']        = _MI_TADTHEMES_BNAME3;
$modversion['blocks'][3]['description'] = _MI_TADTHEMES_BDESC3;
$modversion['blocks'][3]['show_func']   = 'vertical_bootstrap_menu';
$modversion['blocks'][3]['template']    = 'vertical_bootstrap_menu.html';
$modversion['blocks'][3]['edit_func']   = "vertical_bootstrap_menu_edit";
$modversion['blocks'][3]['options']     = "";

$modversion['blocks'][4]['file']        = 'vertical_menu.php';
$modversion['blocks'][4]['name']        = _MI_TADTHEMES_BNAME4;
$modversion['blocks'][4]['description'] = _MI_TADTHEMES_BDESC4;
$modversion['blocks'][4]['show_func']   = 'vertical_menu';
$modversion['blocks'][4]['template']    = 'vertical_menu.html';
$modversion['blocks'][4]['edit_func']   = "vertical_menu_edit";
$modversion['blocks'][4]['options']     = "|0";

//---樣板設定---//
$modversion['templates']                    = array();
$i                                          = 0;
$modversion['templates'][$i]['file']        = 'tad_themes_adm_main_tpl.html';
$modversion['templates'][$i]['description'] = 'tad_themes_adm_main_tpl.html';

$i++;
$modversion['templates'][$i]['file']        = 'tad_themes_adm_main_tpl_b3.html';
$modversion['templates'][$i]['description'] = 'tad_themes_adm_main_tpl_b3.html';

$i++;
$modversion['templates'][$i]['file']        = 'tad_themes_adm_dropdown_tpl.html';
$modversion['templates'][$i]['description'] = 'tad_themes_adm_dropdown_tpl.html';

$i++;
$modversion['templates'][$i]['file']        = 'tad_themes_adm_dropdown_tpl_b3.html';
$modversion['templates'][$i]['description'] = 'tad_themes_adm_dropdown_tpl_b3.html';
