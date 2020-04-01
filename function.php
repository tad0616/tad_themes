<?php
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;
xoops_loadLanguage('admin', basename(dirname(__DIR__)));

$TadDataCenter = new TadDataCenter('tad_themes');

/********************* 自訂函數 *********************/

define('_THEME_BG_PATH', XOOPS_ROOT_PATH . "/themes/{$xoopsConfig['theme_set']}/images/bg");
define('_THEME_LOGO_PATH', XOOPS_ROOT_PATH . "/themes/{$xoopsConfig['theme_set']}/images/logo");
define('_THEME_SLIDE_PATH', XOOPS_ROOT_PATH . "/themes/{$xoopsConfig['theme_set']}/images/slide");
define('_THEME_BT_BG_PATH', XOOPS_ROOT_PATH . "/themes/{$xoopsConfig['theme_set']}/images/bt_bg");
define('_THEME_NAVLOGO_PATH', XOOPS_ROOT_PATH . "/themes/{$xoopsConfig['theme_set']}/images/navlogo");
define('_THEME_NAV_BG_PATH', XOOPS_ROOT_PATH . "/themes/{$xoopsConfig['theme_set']}/images/nav_bg");
define('_THEME_CONFIG2_PATH', XOOPS_ROOT_PATH . "/themes/{$xoopsConfig['theme_set']}/images/config2");

$block_position_title = ['leftBlock' => _MA_TADTHEMES_BLOCK_LEFT, 'rightBlock' => _MA_TADTHEMES_BLOCK_RIGHT, 'centerBlock' => _MA_TADTHEMES_BLOCK_TOP_CENTER, 'centerLeftBlock' => _MA_TADTHEMES_BLOCK_TOP_LEFT, 'centerRightBlock' => _MA_TADTHEMES_BLOCK_TOP_RIGHT, 'centerBottomBlock' => _MA_TADTHEMES_BLOCK_BOTTOM_CENTER, 'centerBottomLeftBlock' => _MA_TADTHEMES_BLOCK_BOTTOM_LEFT, 'centerBottomRightBlock' => _MA_TADTHEMES_BLOCK_BOTTOM_RIGHT, 'footerCenterBlock' => _MA_TADTHEMES_BLOCK_FOOTER_CENTER, 'footerLeftBlock' => _MA_TADTHEMES_BLOCK_FOOTER_LEFT, 'footerRightBlock' => _MA_TADTHEMES_BLOCK_FOOTER_RIGHT];

$config2_files = ['config2_base', 'config2_bg', 'config2_slide', 'config2_logo', 'config2_block', 'config2_nav', 'config2'];

/********************* 預設函數 ********************
 * @param string $path
 * @param string $col_name
 * @param string $col_sn
 * @param string $desc
 * @param bool   $safe_name
 */

//取得圖片選項
function import_img($path = '', $col_name = 'logo', $col_sn = '', $desc = '', $safe_name = false)
{
    global $xoopsDB;

    if (empty($path)) {
        return;
    }

    // 如果路徑含有http，取代成絕對路徑，如：
    // http://localhost/uploads/tad_themes/school2019/config2/config2_footer_img_2_2.png
    if (false !== mb_strpos($path, 'http')) {
        $path = str_replace(XOOPS_URL, XOOPS_ROOT_PATH, $path);
    }

    // 若路徑或檔案不存在就跳出
    if (!is_dir($path) and !is_file($path)) {
        return;
    }

    $db_files = [];

    // 撈出資料庫中該佈景的指定類型圖片（若是套用或恢復佈景，此時這裡應該都是空值）
    $sql = 'select files_sn,file_name,original_filename from ' . $xoopsDB->prefix('tad_themes_files_center') . " where col_name='{$col_name}' and col_sn='{$col_sn}'";

    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $db_files_amount = 0;
    while (list($files_sn, $file_name, $original_filename) = $xoopsDB->fetchRow($result)) {
        $db_files[$files_sn] = $original_filename;
        $db_files_amount++;
    }

    // 若是目錄，撈出該目錄底下檔案，若檔案不在資料庫中，就匯入該檔案
    if (is_dir($path)) {
        if ($dh = opendir($path)) {
            while (false !== ($file = readdir($dh))) {
                if ('.' === $file or '..' === $file or 'Thumbs.db' === $file) {
                    continue;
                }

                $type = filetype($path . '/' . $file);

                if ('dir' !== $type) {
                    if (empty($db_files) or !in_array($file, $db_files)) {
                        import_file($path . '/' . $file, $col_name, $col_sn, null, null, $desc, $safe_name);
                    }
                }
            }
            closedir($dh);
        }
    } elseif (is_file($path)) {
        // 若是檔案，若檔案不在資料庫中，就直接匯入該檔案
        if (!in_array($file, $db_files)) {
            import_file($path, $col_name, $col_sn, null, null, $desc, $safe_name);
        }
    }

}

//匯入圖檔
function import_file($file_name = '', $col_name = '', $col_sn = '', $main_width = '', $thumb_width = '240', $desc = '', $safe_name = false, $only_import2db = true)
{
    global $xoopsDB, $xoopsUser, $xoopsModule, $xoopsConfig;

    if ('slide' === $col_name) {
        $TadUpFilesSlide = TadUpFilesSlide();
        if (is_object($TadUpFilesSlide)) {
            $TadUpFilesSlide->set_col($col_name, $col_sn);
            $TadUpFilesSlide->import_one_file($file_name, null, $main_width, $thumb_width, '', false, false, false, false, $only_import2db);
        } else {
            die('Need TadUpFilesSlide Object!');
        }
    } elseif ('bg' === $col_name) {
        $TadUpFilesBg = TadUpFilesBg();
        if (is_object($TadUpFilesBg)) {
            $TadUpFilesBg->set_col($col_name, $col_sn);
            $TadUpFilesBg->import_one_file($file_name, null, $main_width, $thumb_width, '', false, false, false, false, $only_import2db);
        } else {
            die('Need TadUpFilesBg Object!');
        }
    } elseif ('logo' === $col_name) {
        $TadUpFilesLogo = TadUpFilesLogo();
        if (is_object($TadUpFilesLogo)) {
            $TadUpFilesLogo->set_col($col_name, $col_sn);
            $TadUpFilesLogo->import_one_file($file_name, null, $main_width, $thumb_width, '', false, false, false, false, $only_import2db);
        } else {
            die('Need TadUpFilesLogo Object!');
        }
    } elseif ('navlogo' === $col_name) {
        $TadUpFilesNavLogo = TadUpFilesNavLogo();
        if (is_object($TadUpFilesNavLogo)) {
            $TadUpFilesNavLogo->set_col($col_name, $col_sn);
            $TadUpFilesNavLogo->import_one_file($file_name, null, $main_width, $thumb_width, '', false, false, false, false, $only_import2db);
        } else {
            die('Need TadUpFilesNavLogo Object!');
        }
    } elseif ('navbar_img' === $col_name) {
        $TadUpFilesNavBg = TadUpFilesNavBg();
        if (is_object($TadUpFilesNavBg)) {
            $TadUpFilesNavBg->set_col($col_name, $col_sn);
            $TadUpFilesNavBg->import_one_file($file_name, null, $main_width, $thumb_width, '', false, false, false, false, $only_import2db);
        } else {
            die('Need TadUpFilesNavBg Object!');
        }
    } elseif ('bt_bg' === mb_substr($col_name, 0, 5)) {
        $TadUpFilesBt_bg = TadUpFilesBt_bg();
        if (is_object($TadUpFilesBt_bg)) {
            $TadUpFilesBt_bg->set_col($col_name, $col_sn);
            $TadUpFilesBt_bg->import_one_file($file_name, null, $main_width, $thumb_width, '', false, false, false, false, $only_import2db);
        } else {
            die('Need TadUpFilesBt_bg Object!');
        }
    } else {
        $TadUpFiles_config2 = TadUpFiles_config2();
        if (is_object($TadUpFiles_config2)) {
            $TadUpFiles_config2->set_col($col_name, $col_sn);
            $TadUpFiles_config2->import_one_file($file_name, null, $main_width, $thumb_width, '', false, false, false, false, $only_import2db);
        } else {
            die('Need TadUpFiles_config2 Object!');
        }
    }
}

function TadUpFilesBt_bg()
{
    global $xoopsConfig;
    $TadUpFilesBt_bg = new TadUpFiles('tad_themes', "/{$xoopsConfig['theme_set']}/bt_bg", null, '', '/thumbs');
    $TadUpFilesBt_bg->set_thumb('100px', '60px', '#000', 'center center', 'no-repeat', 'contain');

    return $TadUpFilesBt_bg;
}

function TadUpFiles_config2()
{
    global $xoopsConfig;
    $TadUpFiles_config2 = new TadUpFiles('tad_themes', "/{$xoopsConfig['theme_set']}/config2", null, '', '/thumbs');
    $TadUpFiles_config2->set_thumb('100px', '60px', '#000', 'center center', 'no-repeat', 'contain');

    return $TadUpFiles_config2;
}

function TadUpFilesSlide()
{
    global $xoopsConfig;
    $TadUpFilesSlide = new TadUpFiles('tad_themes', "/{$xoopsConfig['theme_set']}/slide", null, '', '/thumbs');
    $TadUpFilesSlide->set_thumb('100px', '60px', '#000', 'center center', 'no-repeat', 'contain');

    return $TadUpFilesSlide;
}

function TadUpFilesBg()
{
    global $xoopsConfig;
    $TadUpFilesBg = new TadUpFiles('tad_themes', "/{$xoopsConfig['theme_set']}/bg", null, '', '/thumbs');
    $TadUpFilesBg->set_thumb('100px', '60px', '#000', 'center center', 'no-repeat', 'contain');

    return $TadUpFilesBg;
}

function TadUpFilesLogo()
{
    global $xoopsConfig;
    $TadUpFilesLogo = new TadUpFiles('tad_themes', "/{$xoopsConfig['theme_set']}/logo", null, '', '/thumbs');
    $TadUpFilesLogo->set_thumb('100px', '60px', '#000', 'center center', 'no-repeat', 'contain');

    return $TadUpFilesLogo;
}

function TadUpFilesNavLogo()
{
    global $xoopsConfig;
    $TadUpFilesNavLogo = new TadUpFiles('tad_themes', "/{$xoopsConfig['theme_set']}/navlogo", null, '', '/thumbs');
    $TadUpFilesNavLogo->set_thumb('100px', '60px', '#000', 'center center', 'no-repeat', 'contain');

    return $TadUpFilesNavLogo;
}

function TadUpFilesNavBg()
{
    global $xoopsConfig;
    $TadUpFilesNavBg = new TadUpFiles('tad_themes', "/{$xoopsConfig['theme_set']}/nav_bg", null, '', '/thumbs');
    $TadUpFilesNavBg->set_thumb('100px', '60px', '#000', 'center center', 'no-repeat', 'contain');

    return $TadUpFilesNavBg;
}

//更新 tadtools 初始設定
function update_tadtools_setup($theme = '', $theme_kind = '')
{
    global $xoopsDB, $xoopsConfig;
    if ('bootstrap4' === $theme_kind) {
        $bootstrap_color = $theme_kind;
    } elseif ('bootstrap3' === $theme_kind) {
        $bootstrap_color = $theme_kind;
    } else {
        $bootstrap_color = 'bootstrap3';
    }

    $sql = 'select `tt_theme_kind` from `' . $xoopsDB->prefix('tadtools_setup') . "` where `tt_theme`='{$theme}'";
    $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    list($old_tt_theme_kind) = $xoopsDB->fetchRow($result);

    if ($theme_kind !== $old_tt_theme_kind) {
        $sql = 'replace into `' . $xoopsDB->prefix('tadtools_setup') . "` (`tt_theme` , `tt_use_bootstrap`,`tt_bootstrap_color` , `tt_theme_kind`) values('{$theme}', '0', '{$bootstrap_color}', '{$theme_kind}')";

        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    }
}

//儲存額外設定值
function save_config2($theme_id = '', $config2_arr = [], $mode = '')
{
    global $xoopsDB, $xoopsConfig;

    $theme_name = $xoopsConfig['theme_set'];

    require XOOPS_ROOT_PATH . "/themes/{$theme_name}/language/{$xoopsConfig['language']}/main.php";
    $TadUpFiles_config2 = TadUpFiles_config2();

    // Utility::dd($config2_arr);

    //額外佈景設定
    $myts = \MyTextSanitizer::getInstance();
    foreach ($config2_arr as $config2) {
        $theme_config = [];
        if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2}.php")) {
            require XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2}.php";
        }
        if ($mode != 'default') {
            if (file_exists(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/{$config2}.php")) {
                require XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/{$config2}.php";
            }
        }

        if (empty($theme_config)) {
            continue;
        }

        /*
        $theme_config[$i]['name']="footer_height";
        $theme_config[$i]['text']=TF_FOOTER_HEIGHT;
        $theme_config[$i]['type']="text";
        $theme_config[$i]['default']="200px";
         */

        foreach ($theme_config as $k => $config) {
            $name = $config['name'];
            $value = isset($_POST[$name]) ? $myts->addSlashes($_POST[$name]) : $config['default'];
            if ('file' === $config['type']) {
                $value = basename($value);
            }

            $sql = 'replace into ' . $xoopsDB->prefix('tad_themes_config2') . " (`theme_id`, `name`, `type`, `value`) values($theme_id , '{$config['name']}' , '{$config['type']}' , '{$value}')";

            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

            // 若是上傳的欄位，需將圖片也上傳或匯入
            if ('file' === $config['type'] or 'bg_file' === $config['type']) {
                // 上傳
                $TadUpFiles_config2->set_col("config2_{$config['name']}", $theme_id);
                $filename = $TadUpFiles_config2->upload_file("config2_{$config['name']}", null, null, null, '', true, false, 'file_name', 'png;jpg;gif');
                if ($filename) {
                    update_theme_config2($config['name'], $filename, $theme_id, $theme_name);
                }

            }

            if ('bg_file' === $config['type']) {

                $value_repeat = isset($_POST[$name . '_repeat']) ? $myts->addSlashes($_POST[$name . '_repeat']) : $config['repeat'];
                $value_position = isset($_POST[$name . '_position']) ? $myts->addSlashes($_POST[$name . '_position']) : $config['position'];
                $value_size = isset($_POST[$name . '_size']) ? $myts->addSlashes($_POST[$name . '_size']) : $config['size'];

                $sql = 'replace into ' . $xoopsDB->prefix('tad_themes_config2') . " (`theme_id`, `name`, `type`, `value`)
                values($theme_id , '{$config['name']}_repeat' , 'select' , '{$value_repeat}'),
                ($theme_id , '{$config['name']}_position' , 'select' , '{$value_position}'),
                ($theme_id , '{$config['name']}_size' , 'select' , '{$value_size}')";
                // die($sql);
                $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            }
        }
    }
}

//更新佈景的某個設定值
function update_theme_config2($col = '', $file_name = '', $theme_id = '', $theme_name = '')
{
    global $xoopsDB, $xoopsUser, $xoopsConfig;
    $sql = 'update ' . $xoopsDB->prefix('tad_themes_config2') . " set `value` = '{$file_name}' where theme_id='$theme_id' and `name`='{$col}'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
}

//取得佈景編號
function get_theme_id($theme_name = '')
{
    global $xoopsDB;

    $sql = 'select theme_id from ' . $xoopsDB->prefix('tad_themes') . " where `theme_name` = '{$theme_name}'";
    $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    list($theme_id) = $xoopsDB->fetchRow($result);

    return $theme_id;
}
