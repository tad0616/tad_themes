<?php
//引入TadTools的函式庫
if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php")) {
    redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50", 3, _TAD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php";

/********************* 自訂函數 *********************/

define("_THEME_BG_PATH", XOOPS_ROOT_PATH . "/themes/{$xoopsConfig['theme_set']}/images/bg");
define("_THEME_LOGO_PATH", XOOPS_ROOT_PATH . "/themes/{$xoopsConfig['theme_set']}/images/logo");
define("_THEME_SLIDE_PATH", XOOPS_ROOT_PATH . "/themes/{$xoopsConfig['theme_set']}/images/slide");
define("_THEME_BT_BG_PATH", XOOPS_ROOT_PATH . "/themes/{$xoopsConfig['theme_set']}/images/bt_bg");
define("_THEME_NAVLOGO_PATH", XOOPS_ROOT_PATH . "/themes/{$xoopsConfig['theme_set']}/images/navlogo");
define("_THEME_NAV_BG_PATH", XOOPS_ROOT_PATH . "/themes/{$xoopsConfig['theme_set']}/images/nav_bg");

$block_position_title = array("leftBlock" => _MA_TADTHEMES_BLOCK_LEFT, "rightBlock" => _MA_TADTHEMES_BLOCK_RIGHT, "centerBlock" => _MA_TADTHEMES_BLOCK_TOP_CENTER, "centerLeftBlock" => _MA_TADTHEMES_BLOCK_TOP_LEFT, "centerRightBlock" => _MA_TADTHEMES_BLOCK_TOP_RIGHT, "centerBottomBlock" => _MA_TADTHEMES_BLOCK_BOTTOM_CENTER, "centerBottomLeftBlock" => _MA_TADTHEMES_BLOCK_BOTTOM_LEFT, "centerBottomRightBlock" => _MA_TADTHEMES_BLOCK_BOTTOM_RIGHT);

/********************* 預設函數 *********************/
//建立目錄
function mk_dir($dir = "")
{
    //若無目錄名稱秀出警告訊息
    if (empty($dir)) {
        return;
    }

    //若目錄不存在的話建立目錄
    if (!is_dir($dir)) {
        umask(000);
        //若建立失敗秀出警告訊息
        mkdir($dir, 0777);
    }
}

//取得圖片選項
function import_img($path = '', $col_name = "logo", $col_sn = '', $desc = "", $safe_name = false)
{
    global $xoopsDB;
    if (strpos($path, "http") !== false) {
        $path = str_replace(XOOPS_URL, XOOPS_ROOT_PATH, $path);
    }
    if (empty($path)) {
        return;
    }

    if (!is_dir($path) and !is_file($path)) {
        return;
    }

    $db_files = array();

    $sql = "select files_sn,file_name,original_filename from " . $xoopsDB->prefix("tad_themes_files_center") . " where col_name='{$col_name}' and col_sn='{$col_sn}'";

    $result          = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error() . "<br>" . $sql);
    $db_files_amount = 0;
    while (list($files_sn, $file_name, $original_filename) = $xoopsDB->fetchRow($result)) {
        $db_files[$files_sn] = $original_filename;
        $db_files_amount++;
    }
    if (!empty($db_files_amount)) {
        return;
    }

    if (is_dir($path)) {
        if ($dh = opendir($path)) {
            while (($file = readdir($dh)) !== false) {
                if ($file == "." or $file == ".." or $file == "Thumbs.db") {
                    continue;
                }

                $type = filetype($path . "/" . $file);

                if ($type != "dir") {
                    if (!in_array($file, $db_files)) {
                        import_file($path . "/" . $file, $col_name, $col_sn, null, null, $desc, $safe_name);
                    }
                }
            }
            closedir($dh);
        }
    } elseif (is_file($path)) {
        import_file($path, $col_name, $col_sn, null, null, $desc, $safe_name);
    }
}

//匯入圖檔
function import_file($file_name = '', $col_name = "", $col_sn = "", $main_width = "", $thumb_width = "90", $desc = "", $safe_name = false)
{
    global $xoopsDB, $xoopsUser, $xoopsModule, $xoopsConfig;

    //$TadUpFiles->import_one_file($from="",$new_filename="",$main_width="1280",$thumb_width="120",$files_sn="" ,$desc="" ,$safe_name=false ,$hash=false);

    //die("file_name={$file_name} , col_name={$col_name} , col_sn={$col_sn} , main_width={$main_width} , thumb_width={$thumb_width} , desc={$desc} , safe_name={$safe_name} ");

    if ($col_name == "slide") {
        $TadUpFilesSlide = TadUpFilesSlide();
        if (is_object($TadUpFilesSlide)) {
            $TadUpFilesSlide->set_col($col_name, $col_sn);
            $TadUpFilesSlide->import_one_file($file_name, null, $main_width, $thumb_width, null, $desc, $safe_name);
        } else {
            die('Need TadUpFilesSlide Object!');
        }
    } elseif ($col_name == "bg") {
        $TadUpFilesBg = TadUpFilesBg();
        if (is_object($TadUpFilesBg)) {
            $TadUpFilesBg->set_col($col_name, $col_sn);
            $TadUpFilesBg->import_one_file($file_name, null, $main_width, $thumb_width, null, $desc, $safe_name);
        } else {
            die('Need TadUpFilesBg Object!');
        }
    } elseif ($col_name == "logo") {
        $TadUpFilesLogo = TadUpFilesLogo();
        if (is_object($TadUpFilesLogo)) {
            $TadUpFilesLogo->set_col($col_name, $col_sn);
            $TadUpFilesLogo->import_one_file($file_name, null, $main_width, $thumb_width, null, $desc, $safe_name);
        } else {
            die('Need TadUpFilesLogo Object!');
        }
    } elseif ($col_name == "navlogo") {
        $TadUpFilesNavLogo = TadUpFilesNavLogo();
        if (is_object($TadUpFilesNavLogo)) {
            $TadUpFilesNavLogo->set_col($col_name, $col_sn);
            $TadUpFilesNavLogo->import_one_file($file_name, null, $main_width, $thumb_width, null, $desc, $safe_name);
        } else {
            die('Need TadUpFilesNavLogo Object!');
        }
    } elseif ($col_name == "navbar_img") {
        $TadUpFilesNavBg = TadUpFilesNavBg();
        if (is_object($TadUpFilesNavBg)) {
            $TadUpFilesNavBg->set_col($col_name, $col_sn);
            $TadUpFilesNavBg->import_one_file($file_name, null, $main_width, $thumb_width, null, $desc, $safe_name);
        } else {
            die('Need TadUpFilesNavBg Object!');
        }
    } elseif (substr($col_name, 0, 5) == "bt_bg") {
        $TadUpFilesBt_bg = TadUpFilesBt_bg();
        if (is_object($TadUpFilesBt_bg)) {
            $TadUpFilesBt_bg->set_col($col_name, $col_sn);
            $TadUpFilesBt_bg->import_one_file($file_name, null, $main_width, $thumb_width, null, $desc, $safe_name);
        } else {
            die('Need TadUpFilesBt_bg Object!');
        }
    } else {
        $TadUpFiles_config2 = TadUpFiles_config2();
        if (is_object($TadUpFiles_config2)) {
            $TadUpFiles_config2->set_col($col_name, $col_sn);
            $TadUpFiles_config2->import_one_file($file_name, null, $main_width, $thumb_width, null, $desc, $safe_name);
        } else {
            die('Need TadUpFiles_config2 Object!');
        }
    }

}

function TadUpFilesBt_bg()
{
    global $xoopsConfig;
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/TadUpFiles.php";
    $TadUpFilesBt_bg = new TadUpFiles("tad_themes", "/{$xoopsConfig['theme_set']}/bt_bg", null, "", "/thumbs");
    $TadUpFilesBt_bg->set_thumb("100px", "60px", "#000", "center center", "no-repeat", "contain");
    return $TadUpFilesBt_bg;
}

function TadUpFiles_config2()
{
    global $xoopsConfig;
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/TadUpFiles.php";
    $TadUpFiles_config2 = new TadUpFiles("tad_themes", "/{$xoopsConfig['theme_set']}/config2", null, "", "/thumbs");
    $TadUpFiles_config2->set_thumb("100px", "60px", "#000", "center center", "no-repeat", "contain");
    return $TadUpFiles_config2;
}

function TadUpFilesSlide()
{
    global $xoopsConfig;
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/TadUpFiles.php";
    $TadUpFilesSlide = new TadUpFiles("tad_themes", "/{$xoopsConfig['theme_set']}/slide", null, "", "/thumbs");
    $TadUpFilesSlide->set_thumb("100px", "60px", "#000", "center center", "no-repeat", "contain");
    return $TadUpFilesSlide;
}

function TadUpFilesBg()
{
    global $xoopsConfig;
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/TadUpFiles.php";
    $TadUpFilesBg = new TadUpFiles("tad_themes", "/{$xoopsConfig['theme_set']}/bg", null, "", "/thumbs");
    $TadUpFilesBg->set_thumb("100px", "60px", "#000", "center center", "no-repeat", "contain");
    return $TadUpFilesBg;
}

function TadUpFilesLogo()
{
    global $xoopsConfig;
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/TadUpFiles.php";
    $TadUpFilesLogo = new TadUpFiles("tad_themes", "/{$xoopsConfig['theme_set']}/logo", null, "", "/thumbs");
    $TadUpFilesLogo->set_thumb("100px", "60px", "#000", "center center", "no-repeat", "contain");
    return $TadUpFilesLogo;
}

function TadUpFilesNavLogo()
{
    global $xoopsConfig;
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/TadUpFiles.php";
    $TadUpFilesNavLogo = new TadUpFiles("tad_themes", "/{$xoopsConfig['theme_set']}/navlogo", null, "", "/thumbs");
    $TadUpFilesNavLogo->set_thumb("100px", "60px", "#000", "center center", "no-repeat", "contain");
    return $TadUpFilesNavLogo;
}

function TadUpFilesNavBg()
{
    global $xoopsConfig;
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/TadUpFiles.php";
    $TadUpFilesNavBg = new TadUpFiles("tad_themes", "/{$xoopsConfig['theme_set']}/nav_bg", null, "", "/thumbs");
    $TadUpFilesNavBg->set_thumb("100px", "60px", "#000", "center center", "no-repeat", "contain");
    return $TadUpFilesNavBg;
}

//更新 tadtools 初始設定
function update_tadtools_setup($theme = "", $theme_kind = "")
{
    global $xoopsDB, $xoopsConfig;
    if ($theme_kind == "bootstrap" or $theme_kind == "bootstrap3") {
        $bootstrap_color = $theme_kind;
    } else {
        $bootstrap_color = "bootstrap";
    }

    $sql = "replace into `" . $xoopsDB->prefix("tadtools_setup") . "` (`tt_theme` , `tt_use_bootstrap`,`tt_bootstrap_color` , `tt_theme_kind`) values('{$theme}', '0', '{$bootstrap_color}', '{$theme_kind}')";
    $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error() . "<hr>" . $sql);
}
