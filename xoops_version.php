<?php
$modversion = array();

//---模組基本資訊---//
$modversion['name'] = _MI_TADTHEMES_NAME;
$modversion['version'] = '2.2';
$modversion['description'] = _MI_TADTHEMES_DESC;
$modversion['author'] = 'tad (tad0616@gmail.com)';
$modversion['credits'] = 'hirokofan (hirokofan@mail.cyc.edu.tw)';
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image'] = "images/logo_{$xoopsConfig['language']}.png";
$modversion['dirname'] = basename(dirname(__FILE__));


//---模組狀態資訊---//
$modversion['release_date'] = '2013/11/09';
$modversion['module_website_url'] = 'http://tad0616.net/';
$modversion['module_website_name'] = _MI_TAD_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'http://tad0616.net/';
$modversion['author_website_name'] = _MI_TAD_WEB;
$modversion['min_php']=5.2;
$modversion['min_xoops']='2.5';
$modversion['min_tadtools']='2.01';

//---paypal資訊---//
$modversion ['paypal'] = array();
$modversion ['paypal']['business'] = 'tad0616@gmail.com';
$modversion ['paypal']['item_name'] = 'Donation : ' . _MI_TAD_WEB;
$modversion ['paypal']['amount'] = 0;
$modversion ['paypal']['currency_code'] = 'USD';

//---後台使用系統選單---//
$modversion['system_menu'] = 1;

//---資料表架構---//
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][1] = "tad_themes";
$modversion['tables'][2] = "tad_themes_files_center";
$modversion['tables'][3] = "tad_themes_menu";

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

//---前台主選單設定---//
$modversion['hasMain'] = 0;
//$modversion['sub'][1]['name'] = '';
//$modversion['sub'][1]['url'] = '';

//---模組自動功能---//
$modversion['onInstall'] = "include/onInstall.php";
$modversion['onUpdate'] = "include/onUpdate.php";
$modversion['onUninstall'] = "include/onUninstall.php";


//---偏好設定---//
$modversion['config'] = array();
$modversion['config'][0]['name']	= 'auto_mainmenu';
$modversion['config'][0]['title']	= '_MI_TADTHEMES_AUTO_MENU';
$modversion['config'][0]['description']	= '_MI_TADTHEMES_AUTO_MENU_DESC';
$modversion['config'][0]['formtype']	= 'yesno';
$modversion['config'][0]['valuetype']	= 'int';
$modversion['config'][0]['default']	= 1;


//---搜尋---//
//$modversion['hasSearch'] = 1;
//$modversion['search']['file'] = "include/search.php";
//$modversion['search']['func'] = "搜尋函數名稱";

//---區塊設定---//
$modversion['blocks'][1]['file'] = "tad_themes_responsive_slider.php";
$modversion['blocks'][1]['name'] = _MI_TADTHEMES_BNAME1;
$modversion['blocks'][1]['description'] = _MI_TADTHEMES_BDESC1;
$modversion['blocks'][1]['show_func'] = "tad_themes_responsive_slider";
$modversion['blocks'][1]['template'] = "tad_themes_responsive_slider.html";
//$modversion['blocks'][1]['edit_func'] = "編輯區塊函數名稱";
//$modversion['blocks'][1]['options'] = "設定值1|設定值2";


//---樣板設定---//
$modversion['templates'] = array();
$i=0;
$modversion['templates'][$i]['file'] = 'tad_themes_adm_main_tpl.html';
$modversion['templates'][$i]['description'] = 'tad_themes_adm_main_tpl';

$i++;
$modversion['templates'][$i]['file'] = 'tad_themes_adm_dropdown_tpl.html';
$modversion['templates'][$i]['description'] = 'tad_themes_adm_dropdown_tpl';


//---評論---//
//$modversion['hasComments'] = 1;
//$modversion['comments']['pageName'] = '單一頁面.php';
//$modversion['comments']['itemName'] = '主編號';

//---通知---//
//$modversion['hasNotification'] = 1;


?>