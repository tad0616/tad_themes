<?php
use Xmf\Request;
use XoopsModules\Tadtools\DataList;
use XoopsModules\Tadtools\EasyResponsiveTabs;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\MColorPicker;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_adm\DunZip2;
use XoopsModules\Tad_themes\Tools;
/*-----------引入檔案區-------------- */
$xoopsOption['template_main'] = 'tad_themes_adm_main.tpl';
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/auto_import_theme.php';

/*
一般佈景執行流程：
1.TadTools會取得tad_themes偏好設定及佈景預設設定值
(1)檢查有無 /xoops_data/data/佈景名稱.json" 檔案，若無，import_theme_json() 會根據佈景預設設定值建立之。
1.檢查有無 /xoops_data/data/佈景名稱.json" 檔案
2.並建立 json 檔案

 */

/*-----------執行動作判斷區---------- */
$op = Request::getString('op');
$theme_id = Request::getInt('theme_id');
$type = Request::getString('type', 'config2');
$theme_name = Request::getString('theme_name');
$theme_config_name = Request::getString('theme_config_name');
$mode = Request::getString('mode');
$module_sn = Request::getInt('module_sn');
$style_param = Request::getString('style_param');
$from_theme_id = Request::getInt('from_theme_id');
$config2_file = Request::getString('config2_file');

switch ($op) {
    /*---判斷動作請貼在下方--- */

    //新增資料
    case 'insert_tad_themes':
        $theme_id = insert_tad_themes();
        header("location: " . \Xmf\Request::getString('HTTP_REFERER', '', 'SERVER'));
        exit;

    //更新資料
    case 'update_tad_themes':
        Tools::del_theme_json($theme_name);
        update_tad_themes($theme_id, $theme_name);
        if (isset($_COOKIE['themeTab_baseURI'])) {
            header("location: {$_COOKIE['themeTab_baseURI']}");
        } else {
            header("location: " . \Xmf\Request::getString('HTTP_REFERER', '', 'SERVER'));
        }
        exit;

    //輸入表格
    case 'tad_themes_form':
        tad_themes_form();
        break;

    //刪除資料
    case 'delete_tad_themes':
        delete_tad_themes($theme_id);
        // config2_json_file($theme_id);
        Tools::del_theme_json($theme_name);
        header("location: {$_SERVER['PHP_SELF']}?mode=$mode");
        exit;

    //儲存風格檔
    case 'save_config':
        $msg = save_config($theme_id, $theme_config_name);
        redirect_header($_SERVER['PHP_SELF'], 3, $msg);
        break;

    //刪除資料
    case 'delete_theme_config':
        delete_theme_config($theme_name, $theme_config_name, $theme_id);
        break;

    //匯入資料
    case 'import_config':
        import_config($theme_id, $theme_name);
        // config2_json_file($theme_id);
        Tools::del_theme_json($theme_name);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //匯入遠端資料
    case 'import_style':
        import_style($theme_id, $theme_name, $style_param);
        // config2_json_file($theme_id);
        Tools::del_theme_json($theme_name);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //套用資料
    case 'apply_config':
        apply_config($theme_id, $theme_name, $theme_config_name);
        break;

    //下載資料
    case 'download_zip':
        // 不能存，因為下載的有時並不是現在的佈景
        // save_config($theme_id, $theme_config_name);
        download_zip($theme_name, $theme_config_name, $theme_id);
        break;

    //複製佈景
    case 'copy_theme':
        copy_theme($from_theme_id);
        // config2_json_file($theme_id);
        Tools::del_theme_json($theme_name);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //線上觀看設定檔
    case 'export_config':
        export_config($theme_id);
        break;

    //線上觀看設定檔
    case 'export_config2':
        export_config2($theme_id, $config2_file);
        break;

    //預設動作
    default:
        tad_themes_form($mode);
        $op = 'tad_themes_form';
        break;
        /*---判斷動作請貼在上方--- */
}

/*-----------秀出結果區-------------- */
if (isset($_COOKIE['themeTab_baseURI'])) {
    $xoopsTpl->assign('themeTab_baseURI', $_COOKIE['themeTab_baseURI']);
}

$xoopsTpl->assign('now_op', $op);

$xoTheme->addStylesheet(XOOPS_URL . '/modules/tad_themes/class/bootstrap-select/css/bootstrap-select.min.css');
$xoTheme->addScript(XOOPS_URL . '/modules/tad_themes/class/bootstrap-select/js/bootstrap-select.min.js');
$xoTheme->addScript(XOOPS_URL . '/modules/tad_themes/class/bootstrap-select/js/i18n/defaults-zh_TW.min.js');
require_once __DIR__ . '/footer.php';

/*-----------function區-------------- */

//tad_themes編輯表單(default 或 apply)
function tad_themes_form($mode = '')
{
    global $xoopsConfig, $xoopsTpl, $xoTheme, $TadDataCenter, $config2_files_arr, $xoopsDB;

    //抓取預設值
    $theme = get_tad_themes();
    if (empty($theme)) {
        $theme = [];
    }

    //設定「theme_id」欄位預設值
    $theme_id = empty($theme['theme_id']) ? 0 : $theme['theme_id'];
    $xoopsTpl->assign('theme_id', $theme_id);

    if (empty($theme_id)) {
        $mode = $mode == '' ? 'default' : $mode;
        auto_import_theme($mode);
    }

    $SweetAlert = new SweetAlert();
    $SweetAlert->render("delete_tad_themes_config", "main.php?op=delete_tad_themes&mode=default&theme_id=", 'theme_id');

    $theme_name = $xoopsConfig['theme_set'];
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bg");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/slide");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/logo");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bg/thumbs");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/slide/thumbs");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/logo/thumbs");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bt_bg");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bt_bg/thumbs");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/nav_bg");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/nav_bg/thumbs");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config2");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config2/thumbs");

    //設定「theme_name」欄位預設值
    $theme_name = !isset($theme['theme_name']) ? $xoopsConfig['theme_set'] : $theme['theme_name'];
    $xoopsTpl->assign('theme_name', $theme_name);

    /*
    $theme_change=1; //佈景種類是否可自訂
    $theme_kind='bootstrap3';//預設佈景種類 bootstrap3 or html or mix
    $config_tabs=array();//欲使用的頁籤
    $config_enable['設定項目'] = array('enable', 'min', 'max', 'require', 'default'); //各設定項細節
     */

    if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php")) {
        require XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php";
    }
    if (file_exists(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config.php")) {
        require XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config.php";
    }

    if (empty($config_enable)) {
        redirect_header('index.php', 3, sprintf(_MA_TAD_THEMES_NOT_TAD_THEME, $theme_name, XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php"));
    }

    foreach ($config_enable as $k => $v) {
        $$k = $v['default'];
        $enable[$k] = $v['enable'];
        if ('theme_width' === $k) {
            if (false === mb_strpos($theme['theme_kind'], 'bootstrap')) {
                $v['max'] = '';
                $v['min'] = '';
                $v['default'] = '980';
            } else {
                $v['max'] = '12';
                $v['min'] = '1';
                $v['default'] = '12';
            }
        }
        $validate[$k] = get_validate($v);
    }
    $xoopsTpl->assign('validate', $validate);
    $xoopsTpl->assign('enable', $enable);

    $bg_img = !empty($bg_img) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/bg/{$bg_img}" : '';
    $xoopsTpl->assign('bg_img', $bg_img);
    $logo_img = !empty($logo_img) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/logo/{$logo_img}" : '';
    $navlogo_img = !empty($navlogo_img) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/navlogo/{$navlogo_img}" : '';
    $navbar_img = !empty($navbar_img) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/nav_bg/{$navbar_img}" : '';

    //設定「theme_change」欄位預設值
    $theme_change = (!isset($theme_change)) ? false : $theme_change;
    $xoopsTpl->assign('theme_change', $theme_change);

    foreach ($config_enable as $k => $v) {
        $$k = (!isset($theme[$k]) || !$enable[$k]) ? $$k : $theme[$k];
        $xoopsTpl->assign($k, $$k);
    }

    //設定「cb_width」欄位預設值
    $cb_width = (!isset($theme['cb_width']) || !$enable['cb_width']) ? 9 : $theme['cb_width'];
    $xoopsTpl->assign('cb_width', $cb_width);

    //設定「theme_enable」欄位預設值
    $theme_enable = !isset($theme['theme_enable']) ? '' : $theme['theme_enable'];
    $xoopsTpl->assign('theme_enable', $theme_enable);

    //設定「theme_kind」欄位預設值
    $theme_kind = !isset($theme['theme_kind']) ? $theme_kind : $theme['theme_kind'];
    $xoopsTpl->assign('theme_kind', $theme_kind);

    //設定「theme_kind」欄位預設值
    $theme_kind_arr = !isset($theme['theme_kind_arr']) ? $theme_kind_arr : $theme['theme_kind_arr'];
    $xoopsTpl->assign('theme_kind_arr', explode(',', $theme_kind_arr));

    $op = (empty($theme_id)) ? 'insert_tad_themes' : 'update_tad_themes';
    //$op="replace_tad_themes";

    if ('bootstrap5' === $theme_kind) {
        $theme_kind_txt = _MA_TADTHEMES_THEME_KIND_BOOTSTRAP5;
        $chang_css = change_css_bootstrap($theme_width, $lb_width, $cb_width);
        $theme_unit = _MA_TADTHEMES_COL;
        $_SESSION['bootstrap'] = '5';
    } elseif ('bootstrap4' === $theme_kind) {
        $theme_kind_txt = _MA_TADTHEMES_THEME_KIND_BOOTSTRAP4;
        $chang_css = change_css_bootstrap($theme_width, $lb_width, $cb_width);
        $theme_unit = _MA_TADTHEMES_COL;
        $_SESSION['bootstrap'] = '4';
    } elseif ('bootstrap3' === $theme_kind) {
        $theme_kind_txt = _MA_TADTHEMES_THEME_KIND_BOOTSTRAP3;
        $chang_css = change_css_bootstrap($theme_width, $lb_width);
        $theme_unit = _MA_TADTHEMES_COL;
        $_SESSION['bootstrap'] = '3';
    } elseif ('mix' === $theme_kind) {
        $theme_kind_txt = _MA_TADTHEMES_THEME_KIND_MIX;
        $chang_css = change_css_bootstrap(12, $lb_width);
        $theme_unit = _MA_TADTHEMES_COL;
        $_SESSION['bootstrap'] = '3';
    } else {
        $theme_kind_txt = _MA_TADTHEMES_THEME_KIND_HTML;
        $chang_css = change_css($theme_width, $lb_width);
        $theme_unit = 'px';
        $_SESSION['bootstrap'] = '3';
    }
    $xoopsTpl->assign('chang_css', $chang_css);
    $xoopsTpl->assign('theme_kind_txt', $theme_kind_txt);
    $xoopsTpl->assign('theme_unit', $theme_unit);

    $theme_kind_txt_arr = ['bootstrap5' => _MA_TADTHEMES_THEME_KIND_BOOTSTRAP5, 'bootstrap4' => _MA_TADTHEMES_THEME_KIND_BOOTSTRAP4, 'bootstrap3' => _MA_TADTHEMES_THEME_KIND_BOOTSTRAP3, 'html' => _MA_TADTHEMES_THEME_KIND_HTML, 'mix' => _MA_TADTHEMES_THEME_KIND_MIX];
    $xoopsTpl->assign('theme_kind_txt_arr', $theme_kind_txt_arr);

    $FormValidator = new FormValidator('#myForm', true);
    $FormValidator->render();

    $TadUpFilesBg = TadUpFilesBg();
    $xoopsTpl->assign('upform_bg', $TadUpFilesBg->upform(false, 'bg', null, false));

    $TadUpFilesBg->set_col('bg', $theme_id);
    $xoopsTpl->assign('all_bg', $TadUpFilesBg->get_file_for_smarty());

    $TadUpFilesSlide = TadUpFilesSlide();
    $TadUpFilesSlide->set_col('slide', $theme_id);
    $xoopsTpl->assign('upform_slide', $TadUpFilesSlide->upform(true, 'slide', null, true));

    $TadUpFilesLogo = TadUpFilesLogo();
    $TadUpFilesLogo->set_col('logo', $theme_id);
    $xoopsTpl->assign('all_logo', $TadUpFilesLogo->get_file_for_smarty());
    $xoopsTpl->assign('upform_logo', $TadUpFilesLogo->upform(true, 'logo', null, false));

    $TadUpFilesNavLogo = TadUpFilesNavLogo();
    $TadUpFilesNavLogo->set_col('navlogo', $theme_id);
    $xoopsTpl->assign('all_navlogo', $TadUpFilesNavLogo->get_file_for_smarty());
    $xoopsTpl->assign('upform_navlogo', $TadUpFilesNavLogo->upform(false, 'navlogo', null, false));

    $TadUpFilesNavBg = TadUpFilesNavBg();
    $TadUpFilesNavBg->set_col('navbar_img', $theme_id);
    $xoopsTpl->assign('all_navbar_img', $TadUpFilesNavBg->get_file_for_smarty());
    $xoopsTpl->assign('upform_navbar_img', $TadUpFilesNavBg->upform(false, 'navbar_img', null, false));

    $xoopsTpl->assign('op', $op);

    $xoopsTpl->assign('jquery', Utility::get_jquery(true));

    //區塊設定
    $blocks_values = get_blocks_values($theme_id);
    $xoopsTpl->assign('blocks_values', $blocks_values);

    $xoopsTpl->assign('config_tabs', $config_tabs);
    $xoopsTpl->assign('config_enable', $config_enable);

    //額外佈景設定
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config2");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config2/thumbs");

    $custom_tabs_data = $all_config2 = [];
    foreach ($config2_files_arr as $config2_name => $config2_data) {
        // 讀入額外設定並產生變數

        list($config2, $pass_arr) = mk_config2($theme_id, $theme_name, $config2_name);
        if ($pass_arr) {
            foreach ($config2 as $key => $arr) {
                if (!in_array($arr['name'], $pass_arr)) {
                    $all_config2[$key] = $arr;
                }

            }
        } else {
            $all_config2 = $config2;
        }

        if ($all_config2) {
            $custom_tabs_data[$config2_name] = $all_config2;
        }

    }

    $xoopsTpl->assign('custom_tabs_data', $custom_tabs_data);
    $xoopsTpl->assign('config2_files_arr', $config2_files_arr);

    $MColorPicker = new MColorPicker('.color-picker');
    $MColorPicker->render('bootstrap');

    $xoTheme->addScript('modules/tadtools/jqueryCookie/jquery.cookie.js');

    $EasyResponsiveTabs = new EasyResponsiveTabs('#themeTab');
    $EasyResponsiveTabs->rander('tab_identifier_parent');

    $block_tabs = new EasyResponsiveTabs('#bt_tabs', 'vertical');
    $block_tabs->rander('tab_identifier_child');

    $TadDataCenter->set_col('theme_id', $theme_id);
    $xoopsTpl->assign('navbar_py_input', $TadDataCenter->getForm('return', 'input', 'navbar_py', 'text', $navbar_py, null, ['class' => 'form-control']));
    $xoopsTpl->assign('navbar_py_hidden', $TadDataCenter->getForm('return', 'input', 'navbar_py', 'hidden', $navbar_py, null, ['class' => 'form-control']));

    $xoopsTpl->assign('navbar_px_input', $TadDataCenter->getForm('return', 'input', 'navbar_px', 'text', $navbar_px, null, ['class' => 'form-control']));
    $xoopsTpl->assign('navbar_px_hidden', $TadDataCenter->getForm('return', 'input', 'navbar_px', 'hidden', $navbar_px, null, ['class' => 'form-control']));

    $xoopsTpl->assign('navbar_font_size_input', $TadDataCenter->getForm('return', 'input', 'navbar_font_size', 'text', $navbar_font_size, null, ['class' => 'form-control']));
    $xoopsTpl->assign('navbar_font_size_hidden', $TadDataCenter->getForm('return', 'input', 'navbar_font_size', 'hidden', $navbar_font_size, null, ['class' => 'form-control']));

    // 儲存設定表單
    $dir = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/setup/";

    $theme_config_list = [];
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if (filetype($dir . $file) == 'dir' and substr($file, 0, 1) != '.') {
                    if (file_exists($dir . $file . '/config.php')) {
                        $time = date('Y-m-d H:i:s', filemtime($dir . $file . '/config.php'));
                    } else {
                        $time = "$file is empty";
                    }
                    $theme_config_list[$time] = $file;
                }
            }
            closedir($dh);
        }
    }

    // 找出區塊
    $blocks = [];
    $tags = ['hide', 'pic', 'img', 'link', 'icon'];
    $sql = 'SELECT a.`bid`, a.`mid`, a.`name`, a.`title`, b.`name` AS `mod_name`, b.`dirname` FROM `' . $xoopsDB->prefix('newblocks') . '` AS `a` LEFT JOIN `' . $xoopsDB->prefix('modules') . '` AS `b` ON a.`mid`=b.`mid` WHERE a.`block_type`=? OR b.`isactive` = ? ORDER BY a.`mid`, a.`weight`';
    $result = Utility::query($sql, 'si', ['C', 1]) or Utility::web_error($sql, __FILE__, __LINE__);

    while ($data = $xoopsDB->fetchArray($result)) {
        foreach ($tags as $tag) {
            $start = strpos($data['name'], "[$tag]");
            if ($start !== false) {
                $data['name'] = substr($data['name'], 0, $start);
                break;
            }
            $start = strpos($data['title'], "[$tag]");
            if ($start !== false) {
                $data['title'] = substr($data['title'], 0, $start);
                break;
            }
        }

        if (empty($data['mid'])) {
            $data['mod_name'] = _MA_TADTHEMES_BLOCKS_CUSTOM;
        }

        $blocks[$data['mod_name']][$data['bid']] = $data;
        $xoopsTpl->assign('blocks', $blocks);
    }

    // 進階區塊
    $adv_bids = [];
    $sql = "SHOW TABLES LIKE '" . $xoopsDB->prefix('tad_blocks') . "'";
    $result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    if ($result->num_rows > 0) {

        $sql = 'SELECT `bid` FROM `' . $xoopsDB->prefix('tad_blocks') . '`';
        $result2 = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        while (list($bid) = $xoopsDB->fetchRow($result2)) {
            $adv_bids[] = $bid;
        }
    }
    $xoopsTpl->assign('adv_bids', $adv_bids);

    DataList::render();
    $xoopsTpl->assign('theme_config_list', $theme_config_list);

    $SweetAlert->render("delete_theme_config", "main.php?op=delete_theme_config&theme_name=$theme_name&theme_id=$theme_id&theme_config_name=", 'theme_config_name');

    $url = "https://campus-xoops.tn.edu.tw/modules/tad_modules/style.php?theme=$theme_name";

    if (function_exists('curl_init')) {
        $ch = curl_init();
        $timeout = 5;

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);

    } elseif (function_exists('file_get_contents')) {
        $data = file_get_contents($url);
    } else {
        $handle = fopen($url, "rb");
        $data = stream_get_contents($handle);
        fclose($handle);
    }

    $style_arr = [];
    if (!empty($data)) {
        $style_arr = json_decode($data, true);
    }
    $xoopsTpl->assign('style_arr', $style_arr);

    $themes_arr = $xoopsConfig['theme_set_allowed'];
    $themes = array_diff($themes_arr, [$theme_name]);
    foreach ($themes as $theme) {
        $id = get_theme_id($theme);
        $new_themes[$id] = $theme;
    }

    $xoopsTpl->assign('themes', $new_themes);

}

/* 讀入額外設定並產生變數（編輯用）
1.先讀進佈景預設的某個 config2_xxx.php 取得佈景預設的設定項目，以造出設定表單頁面(這是開發者預設的外觀)
2.再讀進目前網站佈景 uploads 下的 config2_xxx.php 設定值 $theme_config，以便填入表單的 value(這是使用者設定後的外觀)
3.讀取資料庫中該佈景所有的額外設定值(其值會和 json 一致)
 */
function mk_config2($theme_id = '', $theme_name = '', $config2_file = '')
{
    global $xoopsTpl, $xoopsConfig;
    $pass_arr = [];
    if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php")) {
        $myts = \MyTextSanitizer::getInstance();
        if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/language/{$xoopsConfig['language']}/main.php")) {
            require_once XOOPS_ROOT_PATH . "/themes/{$theme_name}/language/{$xoopsConfig['language']}/main.php";
        }

        require_once XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php";
        // if (file_exists(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/{$config2_file}.php")) {
        //     require_once XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/{$config2_file}.php";
        // }

        // 取得該佈景所有額外設定值
        $config2_dbv = get_config2_dbv($theme_id);

        // if ($config2_file == 'config2_top') {
        // Utility::dd($config2_dbv);
        // }

        foreach ($theme_config as $k => $config) {
            $TadUpFiles_config2 = TadUpFiles_config2();
            $config_name = $config['name'];
            if (isset($config2_dbv[$config_name])) {
                $value = ($config['type'] == 'checkbox' or $config['type'] == 'custom_zone') ? json_decode($config2_dbv[$config_name], true) : $myts->htmlSpecialChars($config2_dbv[$config_name]);

            } else {
                $value = '';
            }

            // if ($config2_file == 'config2_middle' && $config_name == 'middle_left') {
            //     Utility::dd($config);
            // }

            $config2[$k]['name'] = $config_name;
            $config2[$k]['text'] = $config['text'];
            $config2[$k]['desc'] = $config['desc'];
            $config2[$k]['type'] = $config['type'];
            $config2[$k]['value'] = $value;
            $config2[$k]['default'] = $config['default'];
            $config2[$k]['options'] = isset($config['options']) ? $config['options'] : null;
            $config2[$k]['images'] = isset($config['images']) ? $config['images'] : null;

            if ('file' === $config['type'] or 'bg_file' === $config['type']) {
                import_img($config['default'], "config2_{$config_name}", $theme_id, '');
                $TadUpFiles_config2->set_col("config2_{$config_name}", $theme_id);
                $config2[$k]['form'] = $TadUpFiles_config2->upform(false, "config2_{$config_name}", null, false);
                $config2[$k]['list'] = $TadUpFiles_config2->get_file_for_smarty();
            }

            if ('bg_file' === $config['type']) {
                // Utility::dd($config);
                $config2[$k]['repeat'] = isset($config2_dbv[$config_name . '_repeat']) ? $myts->htmlSpecialChars($config2_dbv[$config_name . '_repeat']) : '';
                $config2[$k]['position'] = isset($config2_dbv[$config_name . '_position']) ? $myts->htmlSpecialChars($config2_dbv[$config_name . '_position']) : '';
                $config2[$k]['size'] = isset($config2_dbv[$config_name . '_size']) ? $myts->htmlSpecialChars($config2_dbv[$config_name . '_size']) : '';
            } elseif ('custom_zone' === $config['type']) {
                $block = json_decode(str_replace(["\r", "\n"], "", $config2_dbv[$config_name . '_block']), true);

                $config2[$k]['bid'] = get_bid($block);
                $config2[$k]['html_content'] = isset($config2_dbv[$config_name . '_html_content']) ? $myts->htmlSpecialChars($config2_dbv[$config_name . '_html_content']) : '';
                $config2[$k]['fa_content'] = isset($config2_dbv[$config_name . '_fa_content']) ? $myts->htmlSpecialChars($config2_dbv[$config_name . '_fa_content']) : '';
                $config2[$k]['menu_content'] = isset($config2_dbv[$config_name . '_menu_content']) ? $myts->htmlSpecialChars($config2_dbv[$config_name . '_menu_content']) : '';

                $config2[$k]['html_content_desc'] = isset($config['html_content_desc']) ? $config['html_content_desc'] : '';
                $config2[$k]['fa_content_desc'] = isset($config['fa_content_desc']) ? $config['fa_content_desc'] : '';
                $config2[$k]['menu_content_desc'] = isset($config['menu_content_desc']) ? $config['menu_content_desc'] : '';

                // 相容舊的
            } elseif ('checkbox' === $config['type'] and isset($config2_dbv[$config_name . '_content'])) {

                $block = json_decode(str_replace(["\r", "\n"], "", $config2_dbv[$config_name . '_block']), true);
                $config2[$k]['bid'] = get_bid($block);

                if (in_array('html', $value)) {
                    $config2[$k]['html_content'] = isset($config2_dbv[$config_name . '_content']) ? $myts->htmlSpecialChars($config2_dbv[$config_name . '_content']) : '';
                }
                if (in_array('fa-icon', $value)) {
                    $config2[$k]['fa_content'] = isset($config2_dbv[$config_name . '_content']) ? $myts->htmlSpecialChars($config2_dbv[$config_name . '_content']) : '';
                }
                if (in_array('menu', $value)) {
                    $config2[$k]['menu_content'] = isset($config2_dbv[$config_name . '_content']) ? $myts->htmlSpecialChars($config2_dbv[$config_name . '_content']) : '';
                }

                $config2[$k]['html_content_desc'] = isset($config['html_content_desc']) ? $config['html_content_desc'] : '';
                $config2[$k]['fa_content_desc'] = isset($config['fa_content_desc']) ? $config['fa_content_desc'] : '';
                $config2[$k]['menu_content_desc'] = isset($config['menu_content_desc']) ? $config['menu_content_desc'] : '';
                $config2[$k]['type'] = 'custom_zone';
                $pass_arr[] = $config_name . '_content';
            } elseif ('padding_margin' === $config['type']) {
                $config2[$k]['mt'] = isset($config2_dbv[$config_name . '_mt']) ? $myts->htmlSpecialChars($config2_dbv[$config_name . '_mt']) : '';
                $config2[$k]['mb'] = isset($config2_dbv[$config_name . '_mb']) ? $myts->htmlSpecialChars($config2_dbv[$config_name . '_mb']) : '';
            }
        }

        // if ($config2_file == 'config2_top' && $config_name == 'top_left') {
        //     Utility::dd($config2);
        // }
        $xoopsTpl->assign($config2_file, $config2);
        return [$config2, $pass_arr];
    } else {
        return;
    }
}

//{"bid":"3","name":"搜尋","show_func":"b_system_search_show","c_type":"H","content":""}
//{"bid":"132","name":"自訂區塊（HTML）","show_func":"","c_type":"H","content":"自訂內容"}
function get_bid($block = [])
{
    global $xoopsDB;
    $bid = '';
    if (isset($block['show_func'])) {
        $sql = 'SELECT `bid` FROM `' . $xoopsDB->prefix('newblocks') . '` WHERE `show_func`=?';
        $result = Utility::query($sql, 's', [$block['show_func']]) or Utility::web_error($sql, __FILE__, __LINE__);

        list($bid) = $xoopsDB->fetchRow($result);
    } elseif (isset($block['bid'])) {
        $bid = $block['bid'];
    }
    return $bid;
}

function change_css_bootstrap($theme_width = '12', $theme_left_width = '', $theme_center_width = '')
{
    $theme_width = empty($theme_width) ? 12 : $theme_width;
    $theme_left_width = (empty($theme_left_width) or $theme_left_width == $theme_width) ? 3 : $theme_left_width;
    $theme_center_width = (empty($theme_center_width) or $theme_center_width == $theme_width) ? 9 : $theme_center_width;
    $main = "
    function change_css(){
    console.log('change_css');
        //原始頁寬，如:12
        var theme_width_org = {$theme_width};
        //原始區域寬，如:12
        var lb_width_org = '{$theme_left_width}';
        //原始區域寬，如:12
        var cb_width_org = '{$theme_center_width}';
        //原始區域寬，如:12
        var rb_width_org = '{$theme_left_width}';

        //模擬頁寬
        var theme_width = Math.round(theme_width_org * 80/4);
        //模擬視窗寬
        var preview_width = Math.round(theme_width_org * 80/2);
        //模擬區之外框寬
        var theme_div_width= theme_width+11;

        //滑動圖文框原始高
        // var slide_height_org = $('#slide_height').val();
        //頂部模擬高
        var top_height= 15;
        //滑動圖文框模擬高
        var slide_height= 30;

        //模擬區之外框高
        var theme_div_height=230+top_height+slide_height;

        var theme_margin_top_org = $('#margin_top').val();
        var theme_margin_top= Math.round(theme_margin_top_org/4);
        var theme_margin_bottom_org = $('#margin_bottom').val();
        var theme_margin_bottom= Math.round(theme_margin_bottom_org/4);
        var theme_type=$('#theme_type').val();

        //$('#preview_zone').css('width',preview_width+'px');
        $('#preview_zone').css('background-color',$('#bg_color').val());
        $('#preview_zone').css('background-repeat',$('#bg_repeat').val());
        $('#preview_zone').css('background-size',$('#size').val());
        $('#preview_zone').css('background-attachment',$('#bg_attachment').val());
        $('#preview_zone').css('background-position',$('#bg_position').val());

        if(theme_type=='theme_type_1'){
            $('#left_block').css('background-color',$('#lb_color').val()).css('color',$('#font_color').val());
            $('#right_block').css('background-color',$('#lb_color').val()).css('color',$('#font_color').val());
        }else if(theme_type=='theme_type_2'){
            $('#left_block').css('background-color',$('#rb_color').val()).css('color',$('#font_color').val());
            $('#right_block').css('background-color',$('#rb_color').val()).css('color',$('#font_color').val());
        }else{
            $('#left_block').css('background-color',$('#lb_color').val()).css('color',$('#font_color').val());
            $('#right_block').css('background-color',$('#rb_color').val()).css('color',$('#font_color').val());
        }
        $('#center_block').css('background-color',$('#cb_color').val()).css('color',$('#font_color').val());
        $('#theme_head').css('color',$('#link_color').val()).hover( function () {
            $(this).css('color',$('#hover_color').val());
        },function () {
            $(this).css('color',$('#link_color').val());
        });
        $('#theme_foot').css('color',$('#link_color').val()).hover( function () {
            $(this).css('color',$('#hover_color').val());
        },function () {
            $(this).css('color',$('#link_color').val());
        });



        $('#theme_demo').css('width',theme_div_width+'px').css('height',theme_div_height+'px').css('margin-top',theme_margin_top+'px').css('margin-bottom',theme_margin_bottom+'px').css('background-color',$('#base_color').val());
        $('#theme_top').css('width',theme_width+'px').css('height',top_height+'px').css('line-height',top_height+'px');
        $('#theme_head').css('width',theme_width+'px').css('height',slide_height+'px').css('line-height',slide_height+'px');
        $('#theme_foot').css('width',theme_width+'px');


        if(theme_type!='theme_type_8'){
            if($('#lb_width').val()==theme_width_org){
                $('#lb_width').val(lb_width_org);
            }
            if($('#rb_width').val()==theme_width_org){
                $('#rb_width').val(lb_width_org);
            }
        }

        if(theme_type=='theme_type_1'){
            $('#lb_width').prop('readonly',false);
            $('#rb_width').val($('#lb_width').val()).prop('readonly','readonly');
        }else if(theme_type=='theme_type_2'){
            $('#rb_width').prop('readonly',false);
            $('#lb_width').val($('#rb_width').val()).prop('readonly','readonly');
        }else if(theme_type=='theme_type_3'){
            $('#lb_width').prop('readonly',false);
            $('#rb_width').val({$theme_width}).prop('readonly','readonly');
        }else if(theme_type=='theme_type_4'){
            $('#lb_width').prop('readonly',false);
            $('#rb_width').val({$theme_width}).prop('readonly','readonly');
        }else if(theme_type=='theme_type_5' || theme_type=='theme_type_6' || theme_type=='theme_type_7' ){
            $('#lb_width').prop('readonly',false);
            $('#rb_width').prop('readonly',false);
        }else if(theme_type=='theme_type_8'){
            $('#lb_width').val(theme_width_org).prop('readonly','readonly');
            $('#rb_width').val(theme_width_org).prop('readonly','readonly');
        }else{
            $('#lb_width').prop('readonly',false);
            $('#rb_width').prop('readonly',false);
        }

        var cbw = $('#cb_width').val();

        //左區塊原始寬
        var lbw = $('#lb_width').val();
        if(lbw == 'auto' || lbw == ''){
            //左區塊原始寬
            var lb_width_org = $theme_width - cbw;
        }else{
            //左區塊原始寬
            var lb_width_org = lbw * 1;
        }

        //左區塊模擬寬
        var lb_width = Math.round(lb_width_org * 80/4)-3;

        //右區塊原始寬
        var rbw = $('#rb_width').val();
        if(rbw == 'auto' || rbw == ''){
            //右區塊原始寬
            var rb_width_org = $theme_width - cbw;
        }else{
            //右區塊原始寬
            var rb_width_org=$('#rb_width').val()*1;
        }
        //右區塊模擬寬
        var rb_width=Math.round(rb_width_org * 80 /4)-3;


        //中間區塊原始寬
        if(theme_type=='theme_type_5' || theme_type=='theme_type_6' || theme_type=='theme_type_7'){
            var center_width_org = cbw;
            //左區塊模擬寬
            var lb_width = Math.round((12-center_width_org)/2 * 80/4)-3;
            //右區塊模擬寬
            var rb_width=Math.round((12-center_width_org)/2 * 80/4)-3;
        }else{
            var center_width_org = {$theme_width} - lb_width_org;
        }
        //中間區塊模擬寬
        var center_width=Math.round(center_width_org * 80 /4)-3;

        console.log('lbw='+lbw);
        console.log('center_width_org='+center_width_org);
        console.log('lb_width_org='+lb_width_org);
        console.log('lb_width='+lb_width);

        if(theme_type=='theme_type_1'){
            $('#left_block').css('float','left').css('margin','2px 2px 2px 4px').css('width',lb_width).css('height','86px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lbw +'" . _MA_TADTHEMES_COL . "</div>');
            $('#center_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',center_width).css('height','178px').css('line-height','178px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'" . _MA_TADTHEMES_COL . "');
            $('#right_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',rb_width).css('height','86px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rbw+'" . _MA_TADTHEMES_COL . "</div>');
            $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');

        }else if(theme_type=='theme_type_2'){
            $('#left_block').css('float','right').css('margin','2px 4px 2px 2px').css('width',lb_width).css('height','86px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lbw +'" . _MA_TADTHEMES_COL . "</div>');
            $('#center_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',center_width).css('height','178px').css('line-height','178px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'" . _MA_TADTHEMES_COL . "');
            $('#right_block').css('float','right').css('margin','2px 4px 4px 0px').css('width',rb_width).css('height','86px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rbw+'" . _MA_TADTHEMES_COL . "</div>');
            $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');


        }else if(theme_type=='theme_type_3'){
            $('#left_block').css('float','left').css('margin','2px 2px 2px 4px').css('width',lb_width).css('height','132px').html('<div style=\'line-height:12px;margin-top:60px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lbw +'" . _MA_TADTHEMES_COL . "</div>');
            $('#center_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',center_width).css('height','132px').css('line-height','132px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'" . _MA_TADTHEMES_COL . "');
            $('#right_block').css('float','none').css('margin','2px 2px 4px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('" . _MA_TAD_THEMES_RIGHT . " '+theme_width_org+'" . _MA_TADTHEMES_COL . "');
            $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');


        }else if(theme_type=='theme_type_4'){
            $('#left_block').css('float','right').css('margin','2px 4px 2px 2px').css('width',lb_width).css('height','132px').html('<div style=\'line-height:12px;margin-top:60px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lbw +'" . _MA_TADTHEMES_COL . "</div>');
            $('#center_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',center_width).css('height','132px').css('line-height','132px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'" . _MA_TADTHEMES_COL . "');
            $('#right_block').css('float','none').css('margin','2px 2px 4px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('" . _MA_TAD_THEMES_RIGHT . " '+theme_width_org+'" . _MA_TADTHEMES_COL . "');
            $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');


        }else if(theme_type=='theme_type_5'){
            $('#left_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lbw +'" . _MA_TADTHEMES_COL . "</div>');
            $('#center_block').css('float','left').css('margin','2px 0px 4px 0px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_CENTER . "<br>'+center_width_org+'" . _MA_TADTHEMES_COL . "</div>');
            $('#right_block').css('float','right').css('margin','2px 4px 4px 0px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rbw+'" . _MA_TADTHEMES_COL . "</div>');
            $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');


        }else if(theme_type=='theme_type_6'){
            $('#left_block').css('float','left').css('margin','2px 0px 4px 4px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lbw +'" . _MA_TADTHEMES_COL . "</div>');
            $('#center_block').css('float','right').css('margin','2px 4px 4px 0px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_CENTER . "<br>'+center_width_org+'" . _MA_TADTHEMES_COL . "</div>');
            $('#right_block').css('float','left').css('margin','2px 2px 4px 2px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rbw+'" . _MA_TADTHEMES_COL . "</div>');
        $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');


        }else if(theme_type=='theme_type_7'){
            $('#left_block').css('float','right').css('margin','2px 4px 4px 0px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lbw +'" . _MA_TADTHEMES_COL . "</div>');
            $('#center_block').css('float','left').css('margin','2px 0px 4px 4px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_CENTER . "<br>'+center_width_org+'" . _MA_TADTHEMES_COL . "</div>');
            $('#right_block').css('float','right').css('margin','2px 2px 4px 0px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rbw+'" . _MA_TADTHEMES_COL . "</div>');
        $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');

        }else if(theme_type=='theme_type_8'){
            $('#left_block').css('float','none').css('margin','2px 4px 2px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').html('" . _MA_TAD_THEMES_LEFT . " '+ theme_width_org +'" . _MA_TADTHEMES_COL . "');
            $('#center_block').css('float','none').css('margin','2px 4px 2px 4px').css('width',theme_width).css('height','90px').css('line-height','100px').html('" . _MA_TAD_THEMES_CENTER . " '+theme_width_org+'" . _MA_TADTHEMES_COL . "');
            $('#right_block').css('float','none').css('margin','2px 4px 2px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('" . _MA_TAD_THEMES_RIGHT . " '+theme_width_org+'" . _MA_TADTHEMES_COL . "');
            $('#cb_width').html(theme_width_org+'" . _MA_TADTHEMES_COL . "');

        }
    }";

    return $main;
}

function get_validate($col = [])
{
    if ('1' == $col['enable']) {
        $v_item[] = $col['require'] ? 'required' : '';
        $v_item[] = $col['min'] ? "min[{$col['min']}]" : '';
        $v_item[] = $col['max'] ? "max[{$col['max']}]" : '';
        $class = implode(',', $v_item);
        if (',,' === $class) {
            return;
        }

        return " validate[{$class}]";
    }

    return '" readonly="readonly';
}

function change_css($theme_width, $theme_left_width)
{
    $theme_width = empty($theme_width) ? 980 : $theme_width;
    $theme_left_width = (empty($theme_left_width) or $theme_left_width == $theme_width) ? 220 : $theme_left_width;
    $main = "
    function change_css(){
        var theme_width_org = $theme_width;
        var lb_width_org = $theme_left_width;
        var theme_width = Math.round(theme_width_org/4);
        //var preview_width = Math.round(theme_width_org/2);
        var preview_width = $('#preview_width').width();
        var theme_div_width= theme_width+11;
        var top_height= 15;
        var slide_height= 30;
        var theme_div_height=230+top_height+slide_height;
        var theme_margin_top_org = $('#margin_top').val();
        var theme_margin_top= Math.round(theme_margin_top_org/4);
        var theme_margin_bottom_org = $('#margin_bottom').val();
        var theme_margin_bottom= Math.round(theme_margin_bottom_org/4);
        var theme_type=$('#theme_type').val();

        $('#preview_zone').css('width',preview_width+'px');
        $('#preview_zone').css('background-color',$('#bg_color').val());
        $('#preview_zone').css('background-repeat',$('#bg_repeat').val());
        $('#preview_zone').css('background-size',$('#bg_size').val());
        $('#preview_zone').css('background-attachment',$('#bg_attachment').val());
        $('#preview_zone').css('background-position',$('#bg_position').val());

        if(theme_type=='theme_type_1'){
            $('#left_block').css('background-color',$('#lb_color').val()).css('color',$('#font_color').val());
            $('#right_block').css('background-color',$('#lb_color').val()).css('color',$('#font_color').val());
        }else if(theme_type=='theme_type_2'){
            $('#left_block').css('background-color',$('#rb_color').val()).css('color',$('#font_color').val());
            $('#right_block').css('background-color',$('#rb_color').val()).css('color',$('#font_color').val());
        }else{
            $('#left_block').css('background-color',$('#lb_color').val()).css('color',$('#font_color').val());
            $('#right_block').css('background-color',$('#rb_color').val()).css('color',$('#font_color').val());
        }

        $('#center_block').css('background-color',$('#cb_color').val()).css('color',$('#font_color').val());
        $('#theme_head').css('color',$('#link_color').val()).hover( function () {
            $(this).css('color',$('#hover_color').val());
        },function () {
            $(this).css('color',$('#link_color').val());
        });
        $('#theme_foot').css('color',$('#link_color').val()).hover( function () {
            $(this).css('color',$('#hover_color').val());
        },function () {
            $(this).css('color',$('#link_color').val());
        });



        $('#theme_demo').css('width',theme_div_width+'px').css('height',theme_div_height+'px').css('margin-top',theme_margin_top+'px').css('margin-bottom',theme_margin_bottom+'px').css('background-color',$('#base_color').val());
        $('#theme_top').css('width',theme_width+'px').css('height',top_height+'px').css('line-height',top_height+'px');
        $('#theme_head').css('width',theme_width+'px').css('height',slide_height+'px').css('line-height',slide_height+'px');
        $('#theme_foot').css('width',theme_width+'px');


        if(them e_type!='theme_type_8'){
            if($('#lb_width').val()==theme_width_org){
                $('#lb_width').val(lb_width_org);
            }
            if($('#rb_width').val()==theme_width_org){
                $('#rb_width').val(lb_width_org);
            }
        }

        if(theme_type=='theme_type_1'){
            $('#lb_width').prop('readonly',false);
            $('#rb_width').val($('#lb_width').val()).prop('readonly','readonly');
        }else if(theme_type=='theme_type_2'){
            $('#lb_width').prop('readonly',false);
            $('#rb_width').val($('#lb_width').val()).prop('readonly','readonly');
        }else if(theme_type=='theme_type_3'){
            $('#lb_width').prop('readonly',false);
            $('#rb_width').val($theme_width).prop('readonly','readonly');
        }else if(theme_type=='theme_type_4'){
            $('#lb_width').prop('readonly',false);
            $('#rb_width').val($theme_width).prop('readonly','readonly');
        }else if(theme_type=='theme_type_5' || theme_type=='theme_type_6' || theme_type=='theme_type_7' ){
            $('#lb_width').prop('readonly',false);
            $('#rb_width').prop('readonly',false);
        }else if(theme_type=='theme_type_8'){
            $('#lb_width').val(theme_width_org).prop('readonly','readonly');
            $('#rb_width').val(theme_width_org).prop('readonly','readonly');
        }else{
            $('#lb_width').prop('readonly',false);
            $('#rb_width').prop('readonly',false);
        }

        var lb_width_org=$('#lb_width').val()*1;
        var lb_width=Math.round(lb_width_org/4)-2;
        var rb_width_org=$('#rb_width').val()*1;
        var rb_width=Math.round(rb_width_org/4)-2;
        var center_width_org=$theme_width - $('#lb_width').val()*1 -5;
        var center_width=Math.round(center_width_org/4)-2;


        if(theme_type=='theme_type_1'){
            $('#left_block').css('float','left').css('margin','2px 2px 2px 4px').css('width',lb_width).css('height','86px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'px</div>');
            $('#center_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',center_width).css('height','178px').css('line-height','178px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'px');
            $('#right_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',rb_width).css('height','86px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rb_width_org+'px</div>');
            $('#cb_width').html(center_width_org+'px');
        }else if(theme_type=='theme_type_2'){
            $('#left_block').css('float','right').css('margin','2px 4px 2px 2px').css('width',lb_width).css('height','86px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'px</div>');
            $('#center_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',center_width).css('height','178px').css('line-height','178px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'px');
            $('#right_block').css('float','right').css('margin','2px 4px 4px 0px').css('width',rb_width).css('height','86px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rb_width_org+'px</div>');
            $('#cb_width').html(center_width_org+'px');
        }else if(theme_type=='theme_type_3'){
            $('#left_block').css('float','left').css('margin','2px 2px 2px 4px').css('width',lb_width).css('height','132px').html('<div style=\'line-height:12px;margin-top:60px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'px</div>');
            $('#center_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',center_width).css('height','132px').css('line-height','132px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'px');
            $('#right_block').css('float','none').css('margin','2px 2px 4px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('" . _MA_TAD_THEMES_RIGHT . " '+theme_width_org+'px');
            $('#cb_width').html(center_width_org+'px');
        }else if(theme_type=='theme_type_4'){
            $('#left_block').css('float','right').css('margin','2px 4px 2px 2px').css('width',lb_width).css('height','132px').html('<div style=\'line-height:12px;margin-top:60px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'px</div>');
            $('#center_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',center_width).css('height','132px').css('line-height','132px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'px');
            $('#right_block').css('float','none').css('margin','2px 2px 4px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('" . _MA_TAD_THEMES_RIGHT . " '+theme_width_org+'px');
            $('#cb_width').html(center_width_org+'px');
        }else if(theme_type=='theme_type_5'){
            center_width_org=theme_width_org - lb_width_org -rb_width_org -14;
            center_width=Math.floor(center_width_org/4);
            center_width_org=center_width_org+14;
            $('#left_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'px</div>');
            $('#center_block').css('float','left').css('margin','2px 0px 4px 0px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_CENTER . "<br>'+center_width_org+'px</div>');
            $('#right_block').css('float','right').css('margin','2px 4px 4px 0px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rb_width_org+'px</div>');

            $('#cb_width').html(center_width_org+'px');
        }else if(theme_type=='theme_type_6'){
            center_width_org=theme_width_org - lb_width_org -rb_width_org -14;
            center_width=Math.floor(center_width_org/4);
            center_width_org=center_width_org+14;
            $('#left_block').css('float','left').css('margin','2px 0px 4px 4px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'px</div>');
            $('#center_block').css('float','right').css('margin','2px 4px 4px 0px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_CENTER . "<br>'+center_width_org+'px</div>');
            $('#right_block').css('float','left').css('margin','2px 2px 4px 2px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rb_width_org+'px</div>');

            $('#cb_width').html(center_width_org+'px');
        }else if(theme_type=='theme_type_7'){
            center_width_org=theme_width_org - lb_width_org -rb_width_org -14;
            center_width=Math.floor(center_width_org/4);
            center_width_org=center_width_org+14;
            $('#left_block').css('float','right').css('margin','2px 4px 4px 0px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'px</div>');
            $('#center_block').css('float','left').css('margin','2px 0px 4px 4px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_CENTER . "<br>'+center_width_org+'px</div>');
            $('#right_block').css('float','right').css('margin','2px 2px 4px 0px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rb_width_org+'px</div>');

            $('#cb_width').html(center_width_org+'px');
        }else if(theme_type=='theme_type_8'){
            $('#left_block').css('float','none').css('margin','2px 4px 2px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').html('" . _MA_TAD_THEMES_LEFT . " '+ theme_width_org +'px');
            $('#center_block').css('float','none').css('margin','2px 4px 2px 4px').css('width',theme_width).css('height','90px').css('line-height','100px').html('" . _MA_TAD_THEMES_CENTER . " '+theme_width_org+'px');
            $('#right_block').css('float','none').css('margin','2px 4px 2px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('" . _MA_TAD_THEMES_RIGHT . " '+theme_width_org+'px');
            $('#cb_width').html(center_width_org+'px');
        }
    }";

    return $main;
}

//新增資料到tad_themes中
function insert_tad_themes()
{
    global $xoopsDB, $TadDataCenter;

    foreach ($_POST as $key => $value) {
        $$key = $value;
    }

    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes') . '` SET `theme_enable`=0';
    Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    //此處增加7+4項by hc
    $sql = 'INSERT INTO `' . $xoopsDB->prefix('tad_themes') . '` (`theme_name`, `theme_type`, `theme_width`, `lb_width`, `cb_width`, `rb_width`, `clb_width`, `crb_width`, `base_color`, `lb_color`, `cb_color`, `rb_color`, `margin_top`, `margin_bottom`, `bg_img`, `bg_color`, `bg_repeat`, `bg_size`, `bg_attachment`, `bg_position`, `logo_img`, `logo_position`, `navlogo_img`, `logo_top`, `logo_right`, `logo_bottom`, `logo_left`, `logo_center`, `theme_enable`, `slide_width`, `slide_height`, `font_size`, `font_color`, `link_color`, `hover_color`, `theme_kind`, `navbar_pos`, `navbar_bg_top`, `navbar_bg_bottom`, `navbar_hover`, `navbar_color`, `navbar_color_hover`, `navbar_icon`, `navbar_img`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
    Utility::query($sql, 'ssssssssssssssssssssssssssssssssssssssss', [
        $theme_name, $theme_type, $theme_width, $lb_width, $cb_width, $rb_width, $clb_width, $crb_width, $base_color, $lb_color, $cb_color, $rb_color, $margin_top, $margin_bottom, $bg_img, $bg_color, $bg_repeat, $bg_size, $bg_attachment, $bg_position, $logo_img, $logo_position, $navlogo_img, $logo_top, $logo_right, $logo_bottom, $logo_left, $logo_center, $slide_width, $slide_height, $font_size, $font_color, $link_color, $hover_color, $theme_kind, $navbar_pos, $navbar_bg_top, $navbar_bg_bottom, $navbar_hover, $navbar_color, $navbar_color_hover, $navbar_icon, $navbar_img,
    ]) or Utility::web_error($sql, __FILE__, __LINE__);

    //取得最後新增資料的流水編號
    $theme_id = $xoopsDB->getInsertId();

    $TadDataCenter->set_col('theme_id', $theme_id);
    $TadDataCenter->saveData();
    $TadUpFilesSlide = TadUpFilesSlide();
    $TadUpFilesSlide->set_col('slide', $theme_id);
    $TadUpFilesSlide->upload_file('slide', 1920, null, null, '', true);
    $TadUpFilesBg = TadUpFilesBg();
    $TadUpFilesBg->set_col('bg', $theme_id);
    $TadUpFilesBg->upload_file('bg', 2048, null, null, '', true);
    $TadUpFilesLogo = TadUpFilesLogo();
    $TadUpFilesLogo->set_col('logo', $theme_id);
    $TadUpFilesLogo->upload_file('logo', 2048, null, null, '', true);
    $TadUpFilesNavLogo = TadUpFilesNavLogo();
    $TadUpFilesNavLogo->set_col('navlogo', $theme_id);
    $TadUpFilesNavLogo->upload_file('navlogo', null, null, null, '', true);
    $TadUpFilesNavBg = TadUpFilesNavBg();
    $TadUpFilesNavBg->set_col('navbar_img', $theme_id);
    $TadUpFilesNavBg->upload_file('navbar_img', null, null, null, '', true);
    //儲存區塊設定
    save_blocks($theme_id);

    //儲存額外設定值
    save_config2($theme_id, $_POST['config2'], 'post');

    return $theme_id;
}

//更新tad_themes某一筆資料
function update_tad_themes($theme_id = '', $theme_name = '')
{
    global $xoopsDB, $TadDataCenter, $config2_files;

    foreach ($_POST as $key => $value) {
        $$key = $value;
    }

    //切換佈景類型
    if (isset($old_theme_kind) and $old_theme_kind !== $theme_kind) {
        if ('mix' === $theme_kind) {
            $theme_width = 980;
            $lb_width = 3;
            $cb_width = 6;
            $rb_width = 3;
        } elseif ('html' === $theme_kind) {
            $theme_width = 980;
            $lb_width = 240;
            $cb_width = 500;
            $rb_width = 240;
        } elseif ('bootstrap5' === $theme_kind) {
            $theme_width = 12;
            $lb_width = 'auto';
            $cb_width = 9;
            $rb_width = 'auto';
        } elseif ('bootstrap3' === $theme_kind) {
            $theme_width = 12;
            $lb_width = 3;
            $cb_width = 6;
            $rb_width = 3;
        } else {
            $theme_width = 12;
            $lb_width = 'auto';
            $cb_width = 9;
            $rb_width = 'auto';
        }
    }
    update_tadtools_setup($theme_name, $theme_kind);

    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes') . '` SET `theme_name` = ?, `theme_type` = ?, `theme_width` = ?, `lb_width` = ?, `cb_width` = ?, `rb_width` = ?, `clb_width` = ?, `crb_width` = ?, `base_color` = ?, `lb_color` = ?, `cb_color` = ?, `rb_color` = ?, `margin_top` = ?, `margin_bottom` = ?, `bg_img` = ?, `bg_color` = ?, `bg_repeat` = ?, `bg_size` = ?, `bg_attachment` = ?, `bg_position` = ?, `logo_img` = ?, `logo_position` = ?, `navlogo_img` = ?, `logo_top` = ?, `logo_right` = ?, `logo_bottom` = ?, `logo_left` = ?, `logo_center` = ?, `theme_enable` = 1, `slide_width` = ?, `slide_height` = ?, `font_size` = ?, `font_color` = ?, `link_color` = ?, `hover_color` = ?, `theme_kind` = ?, `navbar_pos` = ?, `navbar_bg_top` = ?, `navbar_bg_bottom` = ?, `navbar_hover` = ?, `navbar_color` = ?, `navbar_color_hover` = ?, `navbar_icon` = ?, `navbar_img` = ? WHERE `theme_id` = ?';
    Utility::query($sql, 'sssssssssssssssssssssssssssssssssssssssssssi', [$theme_name, $theme_type, $theme_width, $lb_width, $cb_width, $rb_width, $clb_width, $crb_width, $base_color, $lb_color, $cb_color, $rb_color, $margin_top, $margin_bottom, $bg_img, $bg_color, $bg_repeat, $bg_size, $bg_attachment, $bg_position, $logo_img, $logo_position, $navlogo_img, $logo_top, $logo_right, $logo_bottom, $logo_left, $logo_center, $slide_width, $slide_height, $font_size, $font_color, $link_color, $hover_color, $theme_kind, $navbar_pos, $navbar_bg_top, $navbar_bg_bottom, $navbar_hover, $navbar_color, $navbar_color_hover, $navbar_icon, $navbar_img, $theme_id]) or Utility::web_error($sql, __FILE__, __LINE__);

    $TadDataCenter->set_col('theme_id', $theme_id);
    $TadDataCenter->saveData();

    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}");

    $TadUpFilesSlide = TadUpFilesSlide();
    $TadUpFilesSlide->set_col('slide', $theme_id);
    $TadUpFilesSlide->upload_file('slide', 1920, null, null, '', true);

    $TadUpFilesBg = TadUpFilesBg();
    $TadUpFilesBg->set_col('bg', $theme_id);
    $bg_img = $TadUpFilesBg->upload_file('bg', 2048, null, null, '', true);
    if ($bg_img) {
        update_theme('bg_img', $bg_img, $theme_id);
    }
    $TadUpFilesLogo = TadUpFilesLogo();
    $TadUpFilesLogo->set_col('logo', $theme_id);
    $logo_img = $TadUpFilesLogo->upload_file('logo', 2048, null, null, '', true);
    if ($logo_img) {
        update_theme('logo_img', $logo_img, $theme_id);
    }
    $TadUpFilesNavLogo = TadUpFilesNavLogo();
    $TadUpFilesNavLogo->set_col('navlogo', $theme_id);
    $navlogo_img = $TadUpFilesNavLogo->upload_file('navlogo', null, null, null, '', true);
    if ($navlogo_img) {
        update_theme('navlogo_img', $navlogo_img, $theme_id);
    }
    $TadUpFilesNavBg = TadUpFilesNavBg();
    $TadUpFilesNavBg->set_col('navbar_img', $theme_id);
    $navbar_img = $TadUpFilesNavBg->upload_file('navbar_img', null, null, null, '', true);
    if ($navbar_img) {
        update_theme('navbar_img', $navbar_img, $theme_id);
    }

    //儲存區塊設定
    save_blocks($theme_id);

    //儲存額外設定值
    save_config2($theme_id, $_POST['config2'], 'post');

    // 匯出主設定檔
    export_config($theme_id, $theme_config_name, true);

    // 匯出額外設定
    foreach ($config2_files as $config2_file) {
        export_config2($theme_id, $config2_file, true, $theme_config_name, $theme_name, $theme_name);
    }

    return $theme_id;
}

//更新佈景的某個設定值
function update_theme($col = '', $file_name = '', $theme_id = '')
{
    global $xoopsDB;
    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes') . '` SET `' . $col . '` = ? WHERE `theme_id` = ?';
    Utility::query($sql, 'si', [$file_name, $theme_id]) or Utility::web_error($sql, __FILE__, __LINE__);

}

//以流水號取得某筆tad_themes資料
function get_tad_themes($theme_id = '')
{
    global $xoopsDB, $xoopsConfig, $TadDataCenter;
    if (empty($theme_id)) {
        if (empty($xoopsConfig['theme_set'])) {
            return;
        }

        if (!file_exists(XOOPS_ROOT_PATH . "/themes/{$xoopsConfig['theme_set']}/config.php")) {
            return;
        }
        $where = "WHERE `theme_name` = ?";
    } else {
        $where = "WHERE `theme_id` = ?";
    }

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_themes') . '` ' . $where;
    $result = Utility::query($sql, 's', [empty($theme_id) ? $xoopsConfig['theme_set'] : $theme_id])
    or Utility::web_error($sql, __FILE__, __LINE__);

    $data = $xoopsDB->fetchArray($result);
    $TadDataCenter->set_col('theme_id', $theme_id);
    $data['navbar_px'] = $TadDataCenter->getData('navbar_px', 0);
    $data['navbar_py'] = $TadDataCenter->getData('navbar_py', 0);
    return $data;
}

//刪除tad_themes某筆資料資料
function delete_tad_themes($theme_id = '')
{
    global $xoopsDB, $xoopsConfig, $block_position_title, $config2_files;
    $sql = 'DELETE FROM `' . $xoopsDB->prefix('tad_themes') . '`
    WHERE `theme_id` = ?';
    Utility::query($sql, 'i', [$theme_id]) or Utility::web_error($sql, __FILE__, __LINE__);

    $sql = 'DELETE FROM `' . $xoopsDB->prefix('tad_themes_blocks') . '`
    WHERE `theme_id` = ?';
    Utility::query($sql, 'i', [$theme_id]) or Utility::web_error($sql, __FILE__, __LINE__);

    $sql = 'DELETE FROM `' . $xoopsDB->prefix('tad_themes_config2') . '`
    WHERE `theme_id` = ?';
    Utility::query($sql, 'i', [$theme_id]) or Utility::web_error($sql, __FILE__, __LINE__);

    $theme_name = $xoopsConfig['theme_set'];

    // 建立備份資料（以免使用者自己上傳的圖檔被刪掉）
    // Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}_bak");

    Utility::delete_directory(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/slide/thumbs");
    $TadUpFilesSlide = TadUpFilesSlide();
    $TadUpFilesSlide->set_col('slide', $theme_id);
    $TadUpFilesSlide->del_files();
    Utility::delete_directory(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/slide");

    Utility::delete_directory(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bg/thumbs");
    $TadUpFilesBg = TadUpFilesBg();
    $TadUpFilesBg->set_col('bg', $theme_id);
    $TadUpFilesBg->del_files();
    Utility::delete_directory(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bg");

    Utility::delete_directory(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/logo/thumbs");
    $TadUpFilesLogo = TadUpFilesLogo();
    $TadUpFilesLogo->set_col('logo', $theme_id);
    $TadUpFilesLogo->del_files();
    Utility::delete_directory(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/logo");

    Utility::delete_directory(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/navlogo/thumbs");
    $TadUpFilesNavLogo = TadUpFilesNavLogo();
    $TadUpFilesNavLogo->set_col('navlogo', $theme_id);
    $TadUpFilesNavLogo->del_files();
    Utility::delete_directory(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/navlogo");

    Utility::delete_directory(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/nav_bg/thumbs");
    $TadUpFilesNavBg = TadUpFilesNavBg();
    $TadUpFilesNavBg->set_col('nav_bg', $theme_id);
    $TadUpFilesNavBg->del_files();
    Utility::delete_directory(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/navbar_img");

    Utility::delete_directory(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bt_bg/thumbs");
    Utility::delete_directory(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bt_bg");

    $TadUpFilesBt_bg = TadUpFilesBt_bg();
    foreach ($block_position_title as $position => $title) {
        Utility::delete_directory(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bt_bg_{$position}/thumbs");
        $TadUpFilesBt_bg->set_col("bt_bg_{$position}", $theme_id);
        $TadUpFilesBt_bg->del_files();
        Utility::delete_directory(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bt_bg_{$position}");
    }
    Tools::del_theme_json($theme_name);

    //額外佈景設定
    Utility::delete_directory(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config2/thumbs");
    $TadUpFiles_config2 = TadUpFiles_config2();

    if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/language/{$xoopsConfig['language']}/main.php")) {
        require XOOPS_ROOT_PATH . "/themes/{$theme_name}/language/{$xoopsConfig['language']}/main.php";
    }

    foreach ($config2_files as $config2) {
        if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2}.php")) {
            require XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2}.php";
        }

        if (file_exists(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/{$config2}.php")) {
            require XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/{$config2}.php";
        }

        if (!empty($theme_config)) {
            foreach ($theme_config as $k => $config) {
                if ('file' === $config['type']) {
                    $TadUpFiles_config2->set_col("config2_{$config['name']}", $theme_id);
                    $TadUpFiles_config2->del_files();
                }
            }
        }

        if (file_exists(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/{$config2}.php")) {
            if (!unlink(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/{$config2}.php")) {
                die(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/{$config2}.php 刪除失敗，請檢查權限");
            }
        }
    }
    Utility::delete_directory(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config2");
}

//取得額外設定的儲存值
function get_config2_dbv($theme_id = '')
{
    global $xoopsDB;
    $values = [];
    $sql = 'SELECT `name`, `value`
        FROM `' . $xoopsDB->prefix('tad_themes_config2') . '`
        WHERE `theme_id` = ?';
    $result = Utility::query($sql, 'i', [$theme_id]) or Utility::web_error($sql, __FILE__, __LINE__);

    //`theme_id`, `name`, `type`, `value`
    while (list($name, $value) = $xoopsDB->fetchRow($result)) {
        $values[$name] = $value;
    }

    return $values;
}

//取得區塊設定
function get_blocks_values($theme_id = '', $block_position = '')
{
    global $xoopsDB, $xoopsConfig, $block_position_title;

    $theme_name = $xoopsConfig['theme_set'];
    $config_enable = [];

    if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php")) {
        require_once XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php";
    }

    if (file_exists(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config.php")) {
        require_once XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config.php";
    }
    if ($config_enable) {
        foreach ($config_enable as $k => $v) {
            $$k = $v['default'];
        }
    }

    $bt_bg_img = !empty($bt_bg_img) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/bt_bg/{$bt_bg_img}" : '';

    $and_block_position = !empty($block_position) ? 'AND `block_position` = ?' : '';
    $sql = 'SELECT *
            FROM `' . $xoopsDB->prefix('tad_themes_blocks') . '`
            WHERE `theme_id` = ? ' . $and_block_position;
    $params = [$theme_id];
    if (!empty($block_position)) {
        $params[] = $block_position;
    }
    $result = Utility::query($sql, str_repeat('s', count($params)), $params) or Utility::web_error($sql, __FILE__, __LINE__);

    //`theme_id`, `block_position`, `block_config`, `bt_text`, `bt_text_padding`, `bt_text_size`, `bt_bg_color`, `bt_bg_img`, `bt_bg_repeat`, `bt_radius`
    $mydb = [];
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        $block_position = $all['block_position'];
        $mydb[$block_position] = $all;
    }

    $i = 0;
    $values = [];
    foreach ($block_position_title as $position => $title) {
        $values[$i]['theme_id'] = isset($mydb[$position]) ? $mydb[$position]['theme_id'] : '';
        $values[$i]['block_position'] = $position;
        $values[$i]['block_config'] = !isset($mydb[$position]['block_config']) ? $block_config : $mydb[$position]['block_config'];
        $values[$i]['bt_text'] = !isset($mydb[$position]['bt_text']) ? $bt_text : $mydb[$position]['bt_text'];
        $values[$i]['bt_text_padding'] = !isset($mydb[$position]['bt_text_padding']) ? $bt_text_padding : $mydb[$position]['bt_text_padding'];
        $values[$i]['bt_text_size'] = !isset($mydb[$position]['bt_text_size']) ? $bt_text_size : $mydb[$position]['bt_text_size'];
        $values[$i]['bt_bg_color'] = !isset($mydb[$position]['bt_bg_color']) ? $bt_bg_color : $mydb[$position]['bt_bg_color'];
        $values[$i]['bt_bg_img'] = !isset($mydb[$position]['bt_bg_img']) ? $bt_bg_img : $mydb[$position]['bt_bg_img'];
        $values[$i]['bt_bg_repeat'] = !isset($mydb[$position]['bt_bg_repeat']) ? $bt_bg_repeat : $mydb[$position]['bt_bg_repeat'];
        $values[$i]['bt_radius'] = !isset($mydb[$position]['bt_radius']) ? $bt_radius : $mydb[$position]['bt_radius'];
        $values[$i]['block_style'] = !isset($mydb[$position]['block_style']) ? $block_style : $mydb[$position]['block_style'];
        $values[$i]['block_title_style'] = !isset($mydb[$position]['block_title_style']) ? $block_title_style : $mydb[$position]['block_title_style'];
        $values[$i]['block_content_style'] = !isset($mydb[$position]['block_content_style']) ? $block_content_style : $mydb[$position]['block_content_style'];
        $values[$i]['title'] = $title;

        $TadUpFilesBt_bg = TadUpFilesBt_bg();

        $TadUpFilesBt_bg->set_col("bt_bg_{$position}", $theme_id);
        $values[$i]['all_bt_bg'] = $TadUpFilesBt_bg->get_file_for_smarty();
        $values[$i]['upform_bt_bg'] = $TadUpFilesBt_bg->upform(false, "bt_bg_{$position}", null, false);
        $i++;
    }

    return $values;
}

// 將用到的圖片複製到設定目錄
function copy_image($from_theme_name, $to_theme_name, $theme_config_name, $type, $filename)
{
    $theme_image_path = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$from_theme_name}/{$type}";
    $theme_config_image_path = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$to_theme_name}/setup/{$theme_config_name}/{$type}";
    Utility::mk_dir($theme_config_image_path);
    Utility::mk_dir($theme_config_image_path . '/thumbs');

    $from = "{$theme_image_path}/{$filename}";
    $target = "{$theme_config_image_path}/{$filename}";
    copy($from, $target);

    $from = "{$theme_image_path}/thumbs/{$filename}";
    $target = "{$theme_config_image_path}/thumbs/{$filename}";
    copy($from, $target);
}

// 匯出主設定檔
function export_config($theme_id = '', $theme_config_name = '', $main_theme = false, $from_theme_name = '', $to_theme_name = '', $force = [])
{
    global $xoopsConfig, $xoopsDB;
    $to_theme_name = $to_theme_name ? $to_theme_name : $xoopsConfig['theme_set'];

    if (file_exists(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$to_theme_name}/config.php")) {
        require XOOPS_ROOT_PATH . "/uploads/tad_themes/{$to_theme_name}/config.php";
        $org_config_tabs = $config_tabs;
        $org_config_enable = $config_enable;
    } elseif (file_exists(XOOPS_ROOT_PATH . "/themes/{$to_theme_name}/config.php")) {
        require XOOPS_ROOT_PATH . "/themes/{$to_theme_name}/config.php";
        $org_config_tabs = $config_tabs;
        $org_config_enable = $config_enable;
    }

    if ($force) {
        $force_config_tabs = $force['config_tabs'];
        $force_config_enable = $force['config_enable'];
    }

    // 頁籤以原始的佈景為主
    $config_tabs = $org_config_tabs;
    foreach ($org_config_enable as $type => $item) {
        $config_enable[$type]['enable'] = $item['enable'];
        $config_enable[$type]['min'] = $item['min'];
        $config_enable[$type]['max'] = $item['max'];
        $config_enable[$type]['require'] = $item['require'];
    }

    if (!empty($theme_config_name)) {
        $theme_config_image_path = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$to_theme_name}/setup/{$theme_config_name}";
        Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$to_theme_name}/setup");
        Utility::mk_dir($theme_config_image_path);
    }

    $myts = \MyTextSanitizer::getInstance();
    //抓取預設值
    $theme = get_tad_themes($theme_id);

    $from_theme_name = $from_theme_name ? $from_theme_name : $theme['theme_name'];

    foreach ($force as $k => $v) {
        if (!is_array($v)) {
            $v = $myts->addSlashes($v);
        }
        $$k = $v;
    }

    foreach ($theme as $k => $v) {
        $v = $myts->addSlashes($v);
        $$k = isset($force[$k]) ? $force[$k] : $v;
        $config_enable[$k]['default'] = isset($force_config_enable[$k]['default']) ? $force_config_enable[$k]['default'] : $v;
    }

    $bg_img_default = $logo_img_default = $bt_bg_img_default = $navbar_img_default = $navlogo_img_default = '';

    if ($config_enable['bg_img']['default']) {
        $bg_img_default = basename($config_enable['bg_img']['default']);
        if (!empty($theme_config_name)) {
            copy_image($from_theme_name, $to_theme_name, $theme_config_name, "bg", $bg_img_default);
        }
    }

    if ($config_enable['logo_img']['default']) {
        $logo_img_default = basename($config_enable['logo_img']['default']);
        if (!empty($theme_config_name)) {
            copy_image($from_theme_name, $to_theme_name, $theme_config_name, "logo", $logo_img_default);
        }
    }

    if ($config_enable['navbar_img']['default']) {
        $navbar_img_default = basename($config_enable['navbar_img']['default']);
        if (!empty($theme_config_name)) {
            copy_image($from_theme_name, $to_theme_name, $theme_config_name, "nav_bg", $navbar_img_default);
        }
    }

    if ($config_enable['navlogo_img']['default']) {
        $navlogo_img_default = basename($config_enable['navlogo_img']['default']);

        if (!empty($theme_config_name)) {
            copy_image($from_theme_name, $to_theme_name, $theme_config_name, "nav_logo", $navlogo_img_default);
        }
    }

    // 取得滑動圖
    if (!empty($theme_config_name)) {
        $sql = 'SELECT `sub_dir`, `original_filename`, `file_name` FROM `' . $xoopsDB->prefix('tad_themes_files_center') . '` WHERE `col_name` =? AND `col_sn` =? ORDER BY `sort`';
        $result = Utility::query($sql, 'si', ['slide', $theme_id]) or Utility::web_error($sql, __FILE__, __LINE__);

        while (false !== ($all = $xoopsDB->fetchArray($result))) {
            copy_image($from_theme_name, $to_theme_name, $theme_config_name, "slide", $all['file_name']);
        }
    }

    //取得區塊設定
    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_themes_blocks') . '` WHERE `theme_id` = ?';
    $result = Utility::query($sql, 'i', [$theme_id]) or Utility::web_error($sql, __FILE__, __LINE__);

    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        $block_position = $all['block_position'];
        $blocks[$block_position] = $all;
    }

    $bs = ['block_config', 'bt_text', 'bt_text_padding', 'bt_text_size', 'bt_bg_color', 'bt_bg_img', 'bt_bg_repeat', 'bt_radius', 'block_style', 'block_title_style', 'block_content_style'];

    foreach ($bs as $col) {
        $sql = 'SELECT `' . $col . '` FROM
        (
            SELECT COUNT(*) AS c, `' . $col . '` FROM `' . $xoopsDB->prefix('tad_themes_blocks') . '` WHERE `theme_id` = ? GROUP BY `' . $col . '`
        ) tmp
        ORDER BY c DESC LIMIT 1';

        $result = Utility::query($sql, 'i', [$theme_id]) or Utility::web_error($sql, __FILE__, __LINE__);

        list($v) = $xoopsDB->fetchRow($result);
        $bt_default[$col] = $myts->addSlashes($v);
        if ('bt_bg_img' === $col) {
            if ($bt_default[$col] and 'transparent' !== $bt_default[$col]) {
                $bt_bg_img_default = basename($bt_default[$col]);
                if (!empty($theme_config_name)) {
                    copy_image($from_theme_name, $to_theme_name, $theme_config_name, "bt_bg", $bt_bg_img_default);
                }
            }
        }
    }

    $position_blocks = '';
    foreach ($blocks as $block_position => $b) {
        foreach ($b as $k => $v) {
            if (in_array($k, $bs)) {
                if ($bt_default[$k] != $v) {
                    if ('bt_bg_img' === $k) {
                        if ($v and 'transparent' !== $v) {
                            $v = basename($v);
                            if (!empty($theme_config_name)) {
                                copy_image($from_theme_name, $to_theme_name, $theme_config_name, "bt_bg", $v);
                            }
                        }
                    }

                    $v = $myts->addSlashes($v);
                    $position_blocks .= "\$config_enable['{$k}']['{$block_position}'] = array('enable'=>1, 'min' => '', 'max' => '', 'require'=>0 , 'default' => '{$v}');\n";
                }
            }
        }
    }

    $all_content = "<?php
//佈景種類是否可自訂
\$theme_change = {$theme_change};

//預設佈景種類 bootstrap5 , bootstrap4 , bootstrap3 , html , mix
\$theme_kind = '{$theme_kind}';

//可選用佈景種類 bootstrap5 , bootstrap4 , bootstrap3 , html , mix （\$theme_change=1 時才有用）
\$theme_kind_arr = '{$theme_kind_arr}';

//引入哪些選單？ all(含 my_menu,admin,user),my_menu,admin,user
\$menu_var_kind = '{$menu_var_kind}';

//額外顏色設定 如： bootstrap3/themes/light/Cerulean
\$theme_color = '{$theme_color}';

//是否為可選用佈景
\$theme_set_allowed = {$theme_set_allowed};

/*
tabs-1 版面基礎設定
 */

\$config_tabs[1] = {$config_tabs[1]};

//版面類型[自]，值： theme_type_1 ~ theme_type_8
\$config_enable['theme_type'] = array('enable' => '{$config_enable['theme_type']['enable']}', 'min' => '{$config_enable['theme_type']['min']}', 'max' => '{$config_enable['theme_type']['max']}', 'require' => '{$config_enable['theme_type']['require']}', 'default' => '{$config_enable['theme_type']['default']}');

//版面寬度[自]，值：若bootstrap模式，最大值為 12，若 html 模式，則輸入預設版面寬度，如： 980
\$config_enable['theme_width'] = array('enable' => '{$config_enable['theme_width']['enable']}', 'min' => '{$config_enable['theme_width']['min']}', 'max' => '{$config_enable['theme_width']['max']}', 'require' => '{$config_enable['theme_width']['require']}', 'default' => '{$config_enable['theme_width']['default']}');

//內容區顏色[theme_type_x.tpl]
\$config_enable['base_color'] = array('enable' => '{$config_enable['base_color']['enable']}', 'min' => '{$config_enable['base_color']['min']}', 'max' => '{$config_enable['base_color']['max']}', 'require' => '{$config_enable['base_color']['require']}', 'default' => '{$config_enable['base_color']['default']}');

//左區域顏色[theme_type_1.tpl]
\$config_enable['lb_color'] = array('enable' => '{$config_enable['lb_color']['enable']}', 'min' => '{$config_enable['lb_color']['min']}', 'max' => '{$config_enable['lb_color']['max']}', 'require' => '{$config_enable['lb_color']['require']}', 'default' => '{$config_enable['lb_color']['default']}');

//中區域顏色[theme_type_x.tpl]
\$config_enable['cb_color'] = array('enable' => '{$config_enable['cb_color']['enable']}', 'min' => '{$config_enable['cb_color']['min']}', 'max' => '{$config_enable['cb_color']['max']}', 'require' => '{$config_enable['cb_color']['require']}', 'default' => '{$config_enable['cb_color']['default']}');

//右區域顏色[theme_type_2~4.tpl]
\$config_enable['rb_color'] = array('enable' => '{$config_enable['rb_color']['enable']}', 'min' => '{$config_enable['rb_color']['min']}', 'max' => '{$config_enable['rb_color']['max']}', 'require' => '{$config_enable['rb_color']['require']}', 'default' => '{$config_enable['rb_color']['default']}');

//左區域寬度[theme_type_x.tpl]，值：若 bootstrap 模式，最大值為 12，若 html 模式，則輸入預設左區域寬度，如： 220
\$config_enable['lb_width'] = array('enable' => '{$config_enable['lb_width']['enable']}', 'min' => '{$config_enable['lb_width']['min']}', 'max' => '{$config_enable['lb_width']['max']}', 'require' => '{$config_enable['lb_width']['require']}', 'default' => '{$config_enable['lb_width']['default']}');

//中區域寬度[theme_type_1~8.tpl]，值：若 bootstrap 模式，最大值為 12，若 html 模式，則輸入預設右區域寬度，如： 220
\$config_enable['cb_width'] = array('enable' => '{$config_enable['cb_width']['enable']}', 'min' => '{$config_enable['cb_width']['min']}', 'max' => '{$config_enable['cb_width']['max']}', 'require' => '{$config_enable['cb_width']['require']}', 'default' => '{$config_enable['cb_width']['default']}');

//右區域寬度[theme_type_2~8.tpl]，值：若 bootstrap 模式，最大值為 12，若 html 模式，則輸入預設右區域寬度，如： 220
\$config_enable['rb_width'] = array('enable' => '{$config_enable['rb_width']['enable']}', 'min' => '{$config_enable['rb_width']['min']}', 'max' => '{$config_enable['rb_width']['max']}', 'require' => '{$config_enable['rb_width']['require']}', 'default' => '{$config_enable['rb_width']['default']}');

//中左區塊寬度[無]
\$config_enable['clb_width'] = array('enable' => '{$config_enable['clb_width']['enable']}', 'min' => '{$config_enable['clb_width']['min']}', 'max' => '{$config_enable['clb_width']['max']}', 'require' => '{$config_enable['clb_width']['require']}', 'default' => '{$config_enable['clb_width']['default']}');

//中右區塊寬度[無]
\$config_enable['crb_width'] = array('enable' => '{$config_enable['crb_width']['enable']}', 'min' => '{$config_enable['crb_width']['min']}', 'max' => '{$config_enable['crb_width']['max']}', 'require' => '{$config_enable['crb_width']['require']}', 'default' => '{$config_enable['crb_width']['default']}');

//離上邊界距離[自]
\$config_enable['margin_top'] = array('enable' => '{$config_enable['margin_top']['enable']}', 'min' => '{$config_enable['margin_top']['min']}', 'max' => '{$config_enable['margin_top']['max']}', 'require' => '{$config_enable['margin_top']['require']}', 'default' => '{$config_enable['margin_top']['default']}');

//文字大小[theme_css.tpl]
\$config_enable['font_size'] = array('enable' => '{$config_enable['font_size']['enable']}', 'min' => '{$config_enable['font_size']['min']}', 'max' => '{$config_enable['font_size']['max']}', 'require' => '{$config_enable['font_size']['require']}', 'default' => '{$config_enable['font_size']['default']}');

//離下邊界距離[自]
\$config_enable['margin_bottom'] = array('enable' => '{$config_enable['margin_bottom']['enable']}', 'min' => '{$config_enable['margin_bottom']['min']}', 'max' => '{$config_enable['margin_bottom']['max']}', 'require' => '{$config_enable['margin_bottom']['require']}', 'default' => '{$config_enable['margin_bottom']['default']}');

//文字顏色[theme_css.tpl]
\$config_enable['font_color'] = array('enable' => '{$config_enable['font_color']['enable']}', 'min' => '{$config_enable['font_color']['min']}', 'max' => '{$config_enable['font_color']['max']}', 'require' => '{$config_enable['font_color']['require']}', 'default' => '{$config_enable['font_color']['default']}');

//連結顏色[theme_css.tpl]
\$config_enable['link_color'] = array('enable' => '{$config_enable['link_color']['enable']}', 'min' => '{$config_enable['link_color']['min']}', 'max' => '{$config_enable['link_color']['max']}', 'require' => '{$config_enable['link_color']['require']}', 'default' => '{$config_enable['link_color']['default']}');

//移到連結顏色[theme_css.tpl]
\$config_enable['hover_color'] = array('enable' => '{$config_enable['hover_color']['enable']}', 'min' => '{$config_enable['hover_color']['min']}', 'max' => '{$config_enable['hover_color']['max']}', 'require' => '{$config_enable['hover_color']['require']}', 'default' => '{$config_enable['hover_color']['default']}');

/*
tabs-2 背景圖
 */

\$config_tabs[2] = {$config_tabs[2]};

//上傳背景圖[theme_css.tpl]，值：可指定置於「themes/佈景/images/bg/」下的某一檔案名稱
\$config_enable['bg_img'] = array('enable' => '{$config_enable['bg_img']['enable']}', 'min' => '{$config_enable['bg_img']['min']}', 'max' => '{$config_enable['bg_img']['max']}', 'require' => '{$config_enable['bg_img']['require']}', 'default' => '{$bg_img_default}');

//背景顏色[theme_css.tpl]
\$config_enable['bg_color'] = array('enable' => '{$config_enable['bg_color']['enable']}', 'min' => '{$config_enable['bg_color']['min']}', 'max' => '{$config_enable['bg_color']['max']}', 'require' => '{$config_enable['bg_color']['require']}', 'default' => '{$config_enable['bg_color']['default']}');

//背景重複[theme_css.tpl]，值： repeat （重複）, repeat-x （水平重複）, repeat-y （垂直重複）, no-repeat （不重複）
\$config_enable['bg_repeat'] = array('enable' => '{$config_enable['bg_repeat']['enable']}', 'min' => '{$config_enable['bg_repeat']['min']}', 'max' => '{$config_enable['bg_repeat']['max']}', 'require' => '{$config_enable['bg_repeat']['require']}', 'default' => '{$config_enable['bg_repeat']['default']}');

//背景縮放[theme_css.tpl]，值： cover （放大圖片填滿畫面）, contain （縮放以呈現完整圖片）
\$config_enable['bg_size'] = array('enable' => '{$config_enable['bg_size']['enable']}', 'min' => '{$config_enable['bg_size']['min']}', 'max' => '{$config_enable['bg_size']['max']}', 'require' => '{$config_enable['bg_size']['require']}', 'default' => '{$config_enable['bg_size']['default']}');


//背景模式[theme_css.tpl]，值： scroll （捲動）,fixed （固定）
\$config_enable['bg_attachment'] = array('enable' => '{$config_enable['bg_attachment']['enable']}', 'min' => '{$config_enable['bg_attachment']['min']}', 'max' => '{$config_enable['bg_attachment']['max']}', 'require' => '{$config_enable['bg_attachment']['require']}', 'default' => '{$config_enable['bg_attachment']['default']}');

//背景位置[theme_css.tpl]，值： left top （預設，左上）, right top （右上）, left bottom （左下）, right bottom （右下）, center center （中中）, center top （中上）, center bottom （中下）
\$config_enable['bg_position'] = array('enable' => '{$config_enable['bg_position']['enable']}', 'min' => '{$config_enable['bg_position']['min']}', 'max' => '{$config_enable['bg_position']['max']}', 'require' => '{$config_enable['bg_position']['require']}', 'default' => '{$config_enable['bg_position']['default']}');


/*
tabs-3 滑動圖片
 */

\$config_tabs[3] = {$config_tabs[3]};

//佈景圖片寬度[slideshow_responsive.tpl]，值：若bootstrap模式，最大值為 12，若 html 模式，則輸入預設佈景圖片寬度，如： 980
\$config_enable['slide_width'] = array('enable' => '{$config_enable['slide_width']['enable']}', 'min' => '{$config_enable['slide_width']['min']}', 'max' => '{$config_enable['slide_width']['max']}', 'require' => '{$config_enable['slide_width']['require']}', 'default' => '{$config_enable['slide_width']['default']}');

//佈景圖片高度[slideshow_responsive.tpl]，值：數值，單位一律為 px
\$config_enable['slide_height'] = array('enable' => '{$config_enable['slide_height']['enable']}', 'min' => '{$config_enable['slide_height']['min']}', 'max' => '{$config_enable['slide_height']['max']}', 'require' => '{$config_enable['slide_height']['require']}', 'default' => '{$config_enable['slide_height']['default']}');

//是否可上傳滑動圖片[slideshow_responsive.tpl]
\$config_enable['use_slide'] = array('enable' => '{$config_enable['use_slide']['enable']}', 'min' => '{$config_enable['use_slide']['min']}', 'max' => '{$config_enable['use_slide']['max']}', 'require' => '{$config_enable['use_slide']['require']}', 'default' => '{$config_enable['use_slide']['default']}');


/*
tabs-4 logo圖
 */

\$config_tabs[4] = {$config_tabs[4]};

// 上傳logo圖[logo.tpl]，值：可指定置於「themes/佈景/images/logo/」下的某一檔案名稱
\$config_enable['logo_img'] = array('enable' => '{$config_enable['logo_img']['enable']}', 'min' => '{$config_enable['logo_img']['min']}', 'max' => '{$config_enable['logo_img']['max']}', 'require' => '{$config_enable['logo_img']['require']}', 'default' => '{$logo_img_default}');

//logo圖位置[logo.tpl]，值： slide （在滑動圖文上）, page （在頁面上）
\$config_enable['logo_position'] = array('enable' => '{$config_enable['logo_position']['enable']}', 'min' => '{$config_enable['logo_position']['min']}', 'max' => '{$config_enable['logo_position']['max']}', 'require' => '{$config_enable['logo_position']['require']}', 'default' => '{$config_enable['logo_position']['default']}');

//Logo離上方距離[logo.tpl]，值：數值，單位一律為 px
\$config_enable['logo_top'] = array('enable' => '{$config_enable['logo_top']['enable']}', 'min' => '{$config_enable['logo_top']['min']}', 'max' => '{$config_enable['logo_top']['max']}', 'require' => '{$config_enable['logo_top']['require']}', 'default' => '{$config_enable['logo_top']['default']}');

//Logo離右邊距離[logo.tpl]，值：數值，單位一律為 px
\$config_enable['logo_right'] = array('enable' => '{$config_enable['logo_right']['enable']}', 'min' => '{$config_enable['logo_right']['min']}', 'max' => '{$config_enable['logo_right']['max']}', 'require' => '{$config_enable['logo_right']['require']}', 'default' => '{$config_enable['logo_right']['default']}');

//Logo離下方距離[logo.tpl]，值：數值，單位一律為 px
\$config_enable['logo_bottom'] = array('enable' => '{$config_enable['logo_bottom']['enable']}', 'min' => '{$config_enable['logo_bottom']['min']}', 'max' => '{$config_enable['logo_bottom']['max']}', 'require' => '{$config_enable['logo_bottom']['require']}', 'default' => '{$config_enable['logo_bottom']['default']}');

//Logo離左邊距離[logo.tpl]，值：數值，單位一律為 px
\$config_enable['logo_left'] = array('enable' => '{$config_enable['logo_left']['enable']}', 'min' => '{$config_enable['logo_left']['min']}', 'max' => '{$config_enable['logo_left']['max']}', 'require' => '{$config_enable['logo_left']['require']}', 'default' => '{$config_enable['logo_left']['default']}');

//Logo置中[logo.tpl]，值：1,0
\$config_enable['logo_center'] = array('enable' => '{$config_enable['logo_center']['enable']}', 'min' => '{$config_enable['logo_center']['min']}', 'max' => '{$config_enable['logo_center']['max']}', 'require' => '{$config_enable['logo_center']['require']}', 'default' => '{$config_enable['logo_center']['default']}');


/*
tabs-5 區塊外觀
 */

\$config_tabs[5] = {$config_tabs[5]};

//區塊標題文字大小[theme_css_blocks.tpl]，值：數值含單位
\$config_enable['bt_text_size'] = array('enable' => '{$config_enable['bt_text_size']['enable']}', 'min' => '{$config_enable['bt_text_size']['min']}', 'max' => '{$config_enable['bt_text_size']['max']}', 'require' => '{$config_enable['bt_text_size']['require']}', 'default' => '{$bt_default['bt_text_size']}');

//區塊標題縮排[theme_css_blocks.tpl]，值：數值，單位一律為 px
\$config_enable['bt_text_padding'] = array('enable' => '{$config_enable['bt_text_padding']['enable']}', 'min' => '{$config_enable['bt_text_padding']['min']}', 'max' => '{$config_enable['bt_text_padding']['max']}', 'require' => '{$config_enable['bt_text_padding']['require']}', 'default' => '{$bt_default['bt_text_padding']}');

//區塊標題文字顏色[theme_css_blocks.tpl]
\$config_enable['bt_text'] = array('enable' => '{$config_enable['bt_text']['enable']}', 'min' => '{$config_enable['bt_text']['min']}', 'max' => '{$config_enable['bt_text']['max']}', 'require' => '{$config_enable['bt_text']['require']}', 'default' => '{$bt_default['bt_text']}');

//區塊標題背景顏色[theme_css_blocks.tpl]
\$config_enable['bt_bg_color'] = array('enable' => '{$config_enable['bt_bg_color']['enable']}', 'min' => '{$config_enable['bt_bg_color']['min']}', 'max' => '{$config_enable['bt_bg_color']['max']}', 'require' => '{$config_enable['bt_bg_color']['require']}', 'default' => '{$bt_default['bt_bg_color']}');

//區塊標題圓角設定[theme_css_blocks.tpl]，值： 1 （圓角）, 0 （直角）
\$config_enable['bt_radius'] = array('enable' => '{$config_enable['bt_radius']['enable']}', 'min' => '{$config_enable['bt_radius']['min']}', 'max' => '{$config_enable['bt_radius']['max']}', 'require' => '{$config_enable['bt_radius']['require']}', 'default' => '{$bt_default['bt_radius']}');

//區塊標題設定按鈕[theme_css_blocks.tpl]，值： right （右）, left （左）
\$config_enable['block_config'] = array('enable' => '{$config_enable['block_config']['enable']}', 'min' => '{$config_enable['block_config']['min']}', 'max' => '{$config_enable['block_config']['max']}', 'require' => '{$config_enable['block_config']['require']}', 'default' => '{$bt_default['block_config']}');

//區塊標題背景圖[theme_css_blocks.tpl]
\$config_enable['bt_bg_img'] = array('enable' => '{$config_enable['bt_bg_img']['enable']}', 'min' => '{$config_enable['bt_bg_img']['min']}', 'max' => '{$config_enable['bt_bg_img']['max']}', 'require' => '{$config_enable['bt_bg_img']['require']}', 'default' => '{$bt_bg_img_default}');

//區塊標題背景重複[theme_css_blocks.tpl]，值： 1 （重複）, 0 （不重複）
\$config_enable['bt_bg_repeat'] = array('enable' => '{$config_enable['bt_bg_repeat']['enable']}', 'min' => '{$config_enable['bt_bg_repeat']['min']}', 'max' => '{$config_enable['bt_bg_repeat']['max']}', 'require' => '{$config_enable['bt_bg_repeat']['require']}', 'default' => '{$bt_default['bt_bg_repeat']}');

//區塊整體樣式手動設定[theme_css_blocks.tpl]，值： 1 （重複）, 0 （不重複）
\$config_enable['block_style'] = array('enable' => '{$config_enable['block_style']['enable']}', 'min' => '{$config_enable['block_style']['min']}', 'max' => '{$config_enable['block_style']['max']}', 'require' => '{$config_enable['block_style']['require']}', 'default' => '{$bt_default['block_style']}');

//區塊標題區樣式手動設定[theme_css_blocks.tpl]，值： 1 （重複）, 0 （不重複）
\$config_enable['block_title_style'] = array('enable' => '{$config_enable['block_title_style']['enable']}', 'min' => '{$config_enable['block_title_style']['min']}', 'max' => '{$config_enable['block_title_style']['max']}', 'require' => '{$config_enable['block_title_style']['require']}', 'default' => '{$bt_default['block_title_style']}');

//區塊內容區樣式手動設定[theme_css_blocks.tpl]，值： 1 （重複）, 0 （不重複）
\$config_enable['block_content_style'] = array('enable' => '{$config_enable['block_content_style']['enable']}', 'min' => '{$config_enable['block_content_style']['min']}', 'max' => '{$config_enable['block_content_style']['max']}', 'require' => '{$config_enable['block_content_style']['require']}', 'default' => '{$bt_default['block_content_style']}');

/*
若沒指定位置（如上方預設），那就是全部區塊預設值，若欲指定位置，只要多一個索引值即可：
\$config_enable['bt_xx']['leftBlock']：左區塊設定
\$config_enable['bt_xx']['rightBlock']：右區塊設定
\$config_enable['bt_xx']['centerBlock']：上中區塊設定
\$config_enable['bt_xx']['centerLeftBlock']：上中左區塊設定
\$config_enable['bt_xx']['centerRightBlock']：上中右區塊設定
\$config_enable['bt_xx']['centerBottomBlock']：下中區塊設定
\$config_enable['bt_xx']['centerBottomLeftBlock']：下中左區塊設定
\$config_enable['bt_xx']['centerBottomRightBlock']：下中右區塊設定
\$config_enable['bt_xx']['footerCenterBlock']：頁尾中區塊設定
\$config_enable['bt_xx']['footerLeftBlock']：頁尾左區塊設定
\$config_enable['bt_xx']['footerRightBlock']：頁尾右區塊設定
例如：
\$config_enable['bt_bg_color']['leftBlock'] = array('enable'=>1, 'min' => '', 'max' => '', 'require'=>0 , 'default' => '#7CBBBB');
\$config_enable['bt_bg_color']['rightBlock'] = array('enable'=>1, 'min' => '', 'max' => '', 'require'=>0 , 'default' => '#D2C38E');
 */
{$position_blocks}
/*
tabs-6 導覽列
 */

\$config_tabs[6] = {$config_tabs[6]};

//導覽列位置[navbar.tpl]，值： fixed-top （固定上方）, fixed-bottom （固定下方）, sticky-top（滑動圖片上方）, default （滑動圖片下方）, middle-bottom （中間區域下方）, not-use （不使用）
\$config_enable['navbar_pos'] = array('enable' => '{$config_enable['navbar_pos']['enable']}', 'min' => '{$config_enable['navbar_pos']['min']}', 'max' => '{$config_enable['navbar_pos']['max']}', 'require' => '{$config_enable['navbar_pos']['require']}', 'default' => '{$config_enable['navbar_pos']['default']}');

//導覽列 漸層顏色(top)[theme_css_navbar.tpl]
\$config_enable['navbar_bg_top'] = array('enable' => '{$config_enable['navbar_bg_top']['enable']}', 'min' => '{$config_enable['navbar_bg_top']['min']}', 'max' => '{$config_enable['navbar_bg_top']['max']}', 'require' => '{$config_enable['navbar_bg_top']['require']}', 'default' => '{$config_enable['navbar_bg_top']['default']}');

//導覽列 漸層顏色(bottom)[theme_css_navbar.tpl]
\$config_enable['navbar_bg_bottom'] = array('enable' => '{$config_enable['navbar_bg_bottom']['enable']}', 'min' => '{$config_enable['navbar_bg_bottom']['min']}', 'max' => '{$config_enable['navbar_bg_bottom']['max']}', 'require' => '{$config_enable['navbar_bg_bottom']['require']}', 'default' => '{$config_enable['navbar_bg_bottom']['default']}');

//導覽列 連結區塊底色[theme_css_navbar.tpl]
\$config_enable['navbar_hover'] = array('enable' => '{$config_enable['navbar_hover']['enable']}', 'min' => '{$config_enable['navbar_hover']['min']}', 'max' => '{$config_enable['navbar_hover']['max']}', 'require' => '{$config_enable['navbar_hover']['require']}', 'default' => '{$config_enable['navbar_hover']['default']}');

//上傳導覽列背景圖[navbar.tpl]，值：可指定置於「themes/佈景/images/nav_bg/」下的某一檔案名稱
\$config_enable['navbar_img'] = array('enable' => '{$config_enable['navbar_img']['enable']}', 'min' => '{$config_enable['navbar_img']['min']}', 'max' => '{$config_enable['navbar_img']['max']}', 'require' => '{$config_enable['navbar_img']['require']}', 'default' => '{$navbar_img_default}');

//導覽列 文字顏色[theme_css_navbar.tpl]
\$config_enable['navbar_color'] = array('enable' => '{$config_enable['navbar_color']['enable']}', 'min' => '{$config_enable['navbar_color']['min']}', 'max' => '{$config_enable['navbar_color']['max']}', 'require' => '{$config_enable['navbar_color']['require']}', 'default' => '{$config_enable['navbar_color']['default']}');

//導覽列 文字移過顏色[theme_css_navbar.tpl]
\$config_enable['navbar_color_hover'] = array('enable' => '{$config_enable['navbar_color_hover']['enable']}', 'min' => '{$config_enable['navbar_color_hover']['min']}', 'max' => '{$config_enable['navbar_color_hover']['max']}', 'require' => '{$config_enable['navbar_color_hover']['require']}', 'default' => '{$config_enable['navbar_color_hover']['default']}');

//導覽列 圖示顏色[navbar.tpl]，值： icon-white （白色圖案）, '' （黑色圖案）
\$config_enable['navbar_icon'] = array('enable' => '{$config_enable['navbar_icon']['enable']}', 'min' => '{$config_enable['navbar_icon']['min']}', 'max' => '{$config_enable['navbar_icon']['max']}', 'require' => '{$config_enable['navbar_icon']['require']}', 'default' => '{$config_enable['navbar_icon']['default']}');

//導覽列 導覽選項上下距離[theme_css_navbar.tpl]
\$config_enable['navbar_py'] = array('enable' => '{$config_enable['navbar_py']['enable']}', 'min' => '{$config_enable['navbar_py']['min']}', 'max' => '{$config_enable['navbar_py']['max']}', 'require' => '{$config_enable['navbar_py']['require']}', 'default' => '{$config_enable['navbar_py']['default']}');

//導覽列 導覽選項左右距離[theme_css_navbar.tpl]
\$config_enable['navbar_px'] = array('enable' => '{$config_enable['navbar_px']['enable']}', 'min' => '{$config_enable['navbar_px']['min']}', 'max' => '{$config_enable['navbar_px']['max']}', 'require' => '{$config_enable['navbar_px']['require']}', 'default' => '{$config_enable['navbar_px']['default']}');

//導覽列 導覽選項文字大小[theme_css_navbar.tpl]
\$config_enable['navbar_font_size'] = array('enable' => '{$config_enable['navbar_font_size']['enable']}', 'min' => '{$config_enable['navbar_font_size']['min']}', 'max' => '{$config_enable['navbar_font_size']['max']}', 'require' => '{$config_enable['navbar_font_size']['require']}', 'default' => '{$config_enable['navbar_font_size']['default']}');

// 上傳導覽列logo圖[navbar.tpl]，值：可指定置於「themes/佈景/images/navlogo/」下的某一檔案名稱
\$config_enable['navlogo_img'] = array('enable' => '{$config_enable['navlogo_img']['enable']}', 'min' => '{$config_enable['navlogo_img']['min']}', 'max' => '{$config_enable['navlogo_img']['max']}', 'require' => '{$config_enable['navlogo_img']['require']}', 'default' => '{$navlogo_img_default}');
";

    if ($main_theme) {
        $file = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$to_theme_name}/config.php";
        if (file_put_contents($file, $all_content)) {
            return '<div>' . sprintf(_MA_TADTHEMES_CONFIG_PATH, $file) . '</div>';
        } else {
            return '<div>' . sprintf(_MA_TADTHEMES_CONFIG_PATH_ERROR, $file) . '</div>';
        }

    } elseif (empty($theme_config_name)) {
        header('Content-type: text/php');
        header('Content-Disposition: attachment; filename=config.php');
        echo $all_content;
        exit;
    } else {
        Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$to_theme_name}/setup");
        Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$to_theme_name}/setup/{$theme_config_name}");
        $file = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$to_theme_name}/setup/{$theme_config_name}/config.php";
        if (file_put_contents($file, $all_content)) {
            return '<div>' . sprintf(_MA_TADTHEMES_CONFIG_PATH, $file) . '</div>';
        } else {
            return '<div>' . sprintf(_MA_TADTHEMES_CONFIG_PATH_ERROR, $file) . '</div>';
        }
    }
}

// 匯出額外設定
function export_config2($theme_id = '', $config2_file = 'config2', $main_theme = false, $theme_config_name = '', $from_theme_name = '', $to_theme_name = '')
{
    global $xoopsConfig, $xoopsDB;

    $theme_name = $to_theme_name ? $to_theme_name : $xoopsConfig['theme_set'];

    if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php")) {
        require XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php";
        // Utility::dd($theme_config);
        if (empty($theme_config)) {
            return;
        }

        $blocks = [];
        $sql = 'SELECT `bid`, `name` FROM `' . $xoopsDB->prefix('newblocks') . '`';
        $result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        while (list($bid, $name) = $xoopsDB->fetchRow($result)) {
            $blocks[$bid] = $name;
        }

        $config2 = [];
        $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_themes_config2') . '` WHERE `theme_id` = ?';
        $result = Utility::query($sql, 'i', [$theme_id]) or Utility::web_error($sql, __FILE__, __LINE__);

        while (false !== ($all = $xoopsDB->fetchArray($result))) {
            $col = $all['name'];
            $config2[$col] = $all;
        }

        $all_col = $default_v = $type_v = [];

        if ($theme_config_name) {
            $theme_config_image_path = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/setup/{$theme_config_name}";
            Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/setup");
            Utility::mk_dir($theme_config_image_path);
            Utility::mk_dir($theme_config_image_path . "/config2");
        }

        // $theme_config 來自各個 config2 設定檔
        foreach ($theme_config as $item) {
            $col = $item['name'];

            $default_v[$col] = $config2[$col]['value'];
            $type_v[$col] = $config2[$col]['type'];
            $all_col[] = $col;
            if ($config2[$col]['type'] == 'file' or $config2[$col]['type'] == 'bg_file') {
                $config2_img = basename($config2[$col]['value']);
                if ($theme_config_name) {
                    copy_image($from_theme_name, $to_theme_name, $theme_config_name, "config2", $config2_img);
                    $default_v[$col] = $config2_img;
                }
            } elseif ($config2[$col]['type'] == 'custom_zone') {
                $default_v[$col] = $config2[$col]['value'];
                $default_v[$col . '_block'] = $config2[$col . '_block']['value'];
                $default_v[$col . '_html_content'] = $config2[$col . '_html_content']['value'];
                $default_v[$col . '_fa_content'] = $config2[$col . '_fa_content']['value'];
                $default_v[$col . '_menu_content'] = $config2[$col . '_menu_content']['value'];
            }

            if ($config2[$col]['type'] == 'bg_file') {
                $default_v[$col . '_repeat'] = $config2[$col . '_repeat']['value'];
                $default_v[$col . '_position'] = $config2[$col . '_position']['value'];
                $default_v[$col . '_size'] = $config2[$col . '_size']['value'];
            } elseif ($config2[$col]['type'] == 'padding_margin') {
                $default_v[$col . '_mt'] = $config2[$col . '_mt']['value'];
                $default_v[$col . '_mb'] = $config2[$col . '_mb']['value'];
            }

        }
        // if ($config2_file == "config2_logo") {
        //     Utility::dd($theme_config);
        // }

        if ($theme_config_name == '' && $main_theme == false) {
            header('Content-type: text/php');
            header("Content-Disposition: attachment; filename={$config2_file}.php");
        }

        // 載入佈景語系
        // if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/language/tchinese_utf8/main.php")) {
        //     require XOOPS_ROOT_PATH . "/themes/{$theme_name}/language/tchinese_utf8/main.php";
        // }

        $all_content = '<?php' . "\n";
        if (file_exists(XOOPS_ROOT_PATH . '/themes/' . $theme_name . '/bg_config.php')) {
            $all_content .= 'require XOOPS_ROOT_PATH . \'/themes/' . $theme_name . '/bg_config.php\';' . "\n";
        }
        $all_content .= '$i = 0;' . "\n";

        foreach ($theme_config as $setup_items) {
            //$all_content .= "\n//" . $setup_items['text'] . "\n";
            $all_content .= "\n" . '$i++;' . "\n";
            $col = $setup_items['name'];
            foreach ($setup_items as $label => $value) {

                if ($label == 'default') {
                    $value = $default_v[$col];
                } elseif ($label == 'repeat' || $label == 'position' || $label == 'size' || $label == 'mt' || $label == 'mb' || $label == 'bid_name') {
                    $value = $default_v[$col . '_' . $label];
                }

                if (is_array($value)) {
                    $values = [];
                    foreach ($value as $k => $v) {
                        if (is_string($v) && substr($v, 0, 3) == 'TF_') {
                            $values[] = is_int($k) ? "'$v'" : "'$k' => $v";
                        } elseif (is_string($v) && strpos($v, XOOPS_URL) !== false) {
                            $v = str_replace(XOOPS_URL, '', $v);
                            $values[] = is_int($k) ? "'$v'" : "'$k' => XOOPS_URL . '$v'";
                        } else {
                            $values[] = is_int($k) ? "'$v'" : "'$k' => '$v'";
                        }

                    }
                    $value = '[' . implode(', ', $values) . ']';
                }

                if ($label == 'name' || $label == 'type') {
                    $all_content .= "\$theme_config[\$i]['$label'] = \"$value\";\n";
                } elseif ($label == 'text' || $label == 'desc') {
                    if (strpos($value, 'TF_', 3) !== false) {
                        $value = substr(str_replace("TF_", " . TF_", $value), 3);
                        $all_content .= "\$theme_config[\$i]['$label'] = $value;\n";
                    } else {
                        $all_content .= "\$theme_config[\$i]['$label'] = '$value';\n";
                    }
                } elseif ($label == 'options' || $label == 'images') {
                    if ($setup_items['type'] == 'bg_file') {
                        $all_content .= "\$theme_config[\$i]['$label'] = \$bg_file;\n";
                    } else {
                        $all_content .= "\$theme_config[\$i]['$label'] = $value;\n";
                    }
                } elseif ($label == 'default') {
                    if ($setup_items['type'] == 'checkbox') {
                        if (empty($value)) {
                            $all_content .= "\$theme_config[\$i]['$label'] = [];\n";
                        } else {
                            $all_content .= "\$theme_config[\$i]['$label'] = $value;\n";
                        }
                    } else {
                        $value = str_replace('"', '\"', $value);
                        $all_content .= "\$theme_config[\$i]['$label'] = \"$value\";\n";
                    }
                } else {
                    $value = str_replace('"', '\"', $value);
                    $all_content .= "\$theme_config[\$i]['$label'] = \"$value\";\n";
                }
            }
        }

        if ($main_theme) {
            $file = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/{$config2_file}.php";
            file_put_contents($file, $all_content);
        } elseif ($theme_config_name == '') {
            echo $all_content;
            exit;
        } else {
            $file = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/setup/{$theme_config_name}/{$config2_file}.php";
            if (file_put_contents($file, $all_content)) {
                return '<div>' . sprintf(_MA_TADTHEMES_CONFIG_PATH, $file) . '</div>';
            } else {
                return '<div>' . sprintf(_MA_TADTHEMES_CONFIG_PATH_ERROR, $file) . '</div>';
            }
        }
    }
}

// 儲存設定
function save_config($theme_id = '', $theme_config_name = '')
{
    global $xoopsConfig, $config2_files;

    if (empty($theme_config_name)) {
        $theme_config_name = date('YmdHis');
    }
    $theme_name = $xoopsConfig['theme_set'];
    Tools::del_theme_json($theme_name);

    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/setup");
    if ($theme_config_name) {
        $theme_config_image_path = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/setup/{$theme_config_name}";
        Utility::delete_directory($theme_config_image_path);
        Utility::mk_dir($theme_config_image_path);
    }

    // 匯出主設定檔
    $msg = export_config($theme_id, $theme_config_name);

    // 匯出額外設定
    foreach ($config2_files as $config2_file) {
        $msg .= export_config2($theme_id, $config2_file, false, $theme_config_name, $theme_name, $theme_name);
    }

    return $msg;

}

// 匯入或套用設定檔
function apply_config($theme_id, $theme_name, $theme_config_name)
{
    delete_tad_themes($theme_id);
    $source = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/setup/{$theme_config_name}";
    $target = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}";
    Utility::mk_dir($target);
    Utility::full_copy($source, $target);
    redirect_header($_SERVER['PHP_SELF'] . '?mode=apply', 3, sprintf(_MA_TADTHEMES_APPLY_OK, $theme_config_name));
}

// 匯入設定檔
function import_config($theme_id = '', $theme_name = '')
{
    $zip_name = filter_var(substr($_FILES['config_zip']['name'], 0, -4), FILTER_SANITIZE_SPECIAL_CHARS);
    list($for_theme_name, $theme_config_name) = explode('-', $zip_name);
    if ($for_theme_name != $theme_name) {
        redirect_header($_SERVER['PHP_SELF'] . "?theme_name={$theme_name}&theme_id={$theme_id}", 3, sprintf(_MA_TADTHEMES_IMPORT_FAIL, $for_theme_name));
    }
    $target = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/setup/$theme_config_name/";
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/setup/");
    Utility::mk_dir($target);

    require_once '../class/dunzip2/dUnzip2.inc.php';
    require_once '../class/dunzip2/dZip.inc.php';
    $zip = new dUnzip2($_FILES['config_zip']['tmp_name']);
    $zip->getList();
    $zip->unzipAll($target);

    redirect_header($_SERVER['PHP_SELF'] . "?theme_name={$theme_name}&theme_id={$theme_id}", 3, sprintf(_MA_TADTHEMES_IMPORT_OK, $theme_config_name));
}

// 匯入遠端設定檔
function import_style($theme_id = '', $theme_name = '', $style_param = '')
{
    list($module_name, $file_link, $update_sn, $module_sn) = explode(';', $style_param);
    // die("$module_name, $file_link, $update_sn, $module_sn");
    get_remote_file($theme_name, $module_name, $file_link, $update_sn, $module_sn);

    redirect_header($_SERVER['PHP_SELF'] . "?theme_name={$theme_name}&theme_id={$theme_id}", 3, sprintf(_MA_TADTHEMES_IMPORT_OK, $theme_config_name));
}

//下載檔案
function get_remote_file($theme_name, $module_name, $file_link, $update_sn, $module_sn)
{
    $moduleHandler = xoops_getHandler('module');
    $xModule = $moduleHandler->getByDirname('tad_adm');
    $configHandler = xoops_getHandler('config');
    $TadAmModuleConfig = $configHandler->getConfigsByCat(0, $xModule->mid());

    $file_link = str_replace('[source]', $TadAmModuleConfig['source'], $file_link);
    $new_file = str_replace($TadAmModuleConfig['source'] . "/uploads/tad_modules/file/", XOOPS_ROOT_PATH . "/uploads/tad_themes/$theme_name/setup/", $file_link);

    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/$theme_name/setup/");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/$theme_name/setup/{$module_name}/");
    copyemz($file_link, $new_file, $update_sn);

    if (!is_file($new_file)) {
        redirect_header($_SERVER['PHP_SELF'] . '?tad_adm_tpl=clean', 3, sprintf(_MA_TADTHEMES_DL_FAIL, $file_link));
    }

    $zip = new DunZip2($new_file);
    $zip->getList();
    $zip->unzipAll(XOOPS_ROOT_PATH . "/uploads/tad_themes/$theme_name/setup/{$module_name}/");
    $zip->close($new_file);
}

function copyemz($file1, $file2, $update_sn = '')
{
    global $xoopsConfig;

    $moduleHandler = xoops_getHandler('module');
    $xModule = $moduleHandler->getByDirname('tad_adm');
    $configHandler = xoops_getHandler('config');
    $TadAmModuleConfig = $configHandler->getConfigsByCat(0, $xModule->mid());

    $ver = (int) str_replace('.', '', substr(XOOPS_VERSION, 6, 5));
    $add_count_url = $TadAmModuleConfig['source'] . "/modules/tad_modules/api.php?update_sn={$update_sn}&from=" . XOOPS_URL . "&sitename={$xoopsConfig['sitename']}&theme={$xoopsConfig['theme_set']}&version=$ver&language={$xoopsConfig['language']}";

    $url = $file1;
    if (function_exists('curl_init')) {
        $ch = curl_init();
        $timeout = 5;

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $contentx = curl_exec($ch);
        curl_close($ch);

        $ch = curl_init();
        $timeout = 5;

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $add_count_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $count = curl_exec($ch);
        curl_close($ch);
        // die('curl');
    } elseif (function_exists('file_get_contents')) {
        $contentx = file_get_contents($url);
        $count = file_get_contents($add_count_url);
        // die('file_get_contents');
    } else {
        $handle = fopen($url, 'rb');
        $contentx = stream_get_contents($handle);
        fclose($handle);

        $handle = fopen($add_count_url, 'rb');
        $count = stream_get_contents($handle);
        fclose($handle);
    }

    $openedfile = fopen($file2, 'wb');
    fwrite($openedfile, $contentx);
    fclose($openedfile);
    if (false === $contentx) {
        $status = false;
    } else {
        $status = true;
    }
    return $status;
}

// 刪除指定設定檔
function delete_theme_config($theme_name, $theme_config_name, $theme_id)
{
    $dir = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/setup/{$theme_config_name}";
    Utility::delete_directory($dir);
    redirect_header($_SERVER['PHP_SELF'] . "?theme_name={$theme_name}&theme_id={$theme_id}", 3, sprintf(_MA_TADTHEMES_DEL_OK, $theme_config_name));
}

// 下載指定設定檔
function download_zip($theme_name, $theme_config_name, $theme_id)
{
    $FromDir = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/setup/{$theme_config_name}";
    $zipname = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/setup/{$theme_name}-{$theme_config_name}.zip";
    $zipurl = XOOPS_URL . "/uploads/tad_themes/{$theme_name}/setup/{$theme_name}-{$theme_config_name}.zip";

    if (file_exists($zipname)) {
        unlink($zipname);
    }

    shell_exec("zip -r -j $zipname $FromDir");

    if (file_exists($zipname)) {
        header("location: $zipurl");
        exit;
    } else {
        require '../class/pclzip.lib.php';
        $zipfile = new PclZip($zipname);
        $v_list = $zipfile->create($FromDir, PCLZIP_OPT_REMOVE_PATH, XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/setup/{$theme_config_name}");

        if ($v_list == 0) {
            redirect_header($_SERVER['PHP_SELF'] . "?theme_name={$theme_name}&theme_id={$theme_id}", 3, $zipfile->errorInfo(true));
        } else {
            header("location: $zipurl");
            exit;
        }
    }
}

// 複製佈景
function copy_theme($from_theme_id)
{
    global $xoopsConfig, $xoopsDB;
    if (empty($xoopsConfig['theme_set'])) {
        return;
    }

    $theme_name = $xoopsConfig['theme_set'];
    $theme_id = get_theme_id($theme_name);

    $from_theme = get_tad_themes($from_theme_id);
    $from_theme_name = $from_theme['theme_name'];

    $files = scandir(XOOPS_ROOT_PATH . "/uploads/tad_themes/$from_theme_name/slide/");

    if (count($files) > 3) {
        Utility::delete_directory(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/slide/thumbs");
        $TadUpFilesSlide = TadUpFilesSlide();
        $TadUpFilesSlide->set_col('slide', $theme_id);
        $TadUpFilesSlide->del_files();
        Utility::delete_directory(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/slide");
        Utility::full_copy(XOOPS_ROOT_PATH . "/uploads/tad_themes/$from_theme_name/slide/", XOOPS_ROOT_PATH . "/uploads/tad_themes/$theme_name/slide/");
    }

    import_img(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$from_theme_name}/logo", 'logo', $theme_id, '');
    import_img(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$from_theme_name}/slide", 'slide', $theme_id, '');

    // 不用匯出額外設定
    redirect_header($_SERVER['PHP_SELF'], 3, sprintf(_MA_TADTHEMES_CONFIG_PATH, $from_theme_name));
}
