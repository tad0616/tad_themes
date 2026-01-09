<?php
use Xmf\Request;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\MColorPicker;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = 'tad_themes_adm_font2pic.tpl';
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';

$TadUpFontFiles = new TadUpFiles('tad_themes', '/fonts');
$TadUpFontFiles->set_col('logo_fonts', 0);

/*-----------執行動作判斷區----------*/
$op            = Request::getString('op');
$title         = Request::getString('title');
$color         = Request::getString('color', '#00a3a8');
$border_color  = Request::getString('border_color', '#ffffff');
$name          = Request::getString('name');
$bg_color      = Request::getString('bg_color');
$logo          = Request::getString('logo');
$shadow_color  = Request::getString('shadow_color', '#000000');
$theme_id      = Request::getInt('theme_id');
$files_sn      = Request::getInt('files_sn');
$status        = Request::getInt('status', 1);
$size          = Request::getInt('size', 24);
$font_file_sn  = Request::getInt('font_file_sn');
$border_size   = Request::getInt('border_size', 2);
$sav_to_logo   = Request::getInt('sav_to_logo');
$shadow_x      = Request::getInt('shadow_x', 1);
$shadow_y      = Request::getInt('shadow_y', 1);
$shadow_size   = Request::getInt('shadow_size', 3);
$margin_top    = Request::getInt('margin_top');
$margin_bottom = Request::getInt('margin_bottom');
$logo_width    = Request::getInt('logo_width');
$logo_height   = Request::getInt('logo_height');

switch ($op) {

    case 'del_logo':
        unlink(XOOPS_ROOT_PATH . "/uploads/logo/{$logo}");
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    case 'save_pic':
        Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/logo');
        if ($sav_to_logo == 1) {
            save_to_logo($name, $theme_id);
            header("location: main.php#themeTab4");
        } else {
            copy(XOOPS_ROOT_PATH . "/uploads/tmp_logo/{$name}.png", XOOPS_ROOT_PATH . "/uploads/logo/{$name}.png");
            delete_dirfile(XOOPS_ROOT_PATH . '/uploads/tmp_logo');
            header("location: font2pic.php");
        }
        exit;

    case 'save_font':
        $TadUpFontFiles->upload_file('font', null, null, $files_sn, null, true, false, 'file_name', 'ttf;otf;ttc');
        header("location: " . \Xmf\Request::getString('HTTP_REFERER', '', 'SERVER'));
        exit;

    case 'mkTitlePic':
        $filename     = Utility::mkTitlePic('/uploads/tmp_logo', date('ymdHis'), $title, $size, $border_size, $color, $border_color, $font_file_sn, $shadow_color, $shadow_x, $shadow_y, $shadow_size, $margin_top, $margin_bottom, false, $logo_width, $logo_height);
        $color        = str_replace('#', '', $color);
        $border_color = str_replace('#', '', $border_color);

        $_SESSION['font_config'] = json_encode(['title' => $title, 'size' => $size, 'border_size' => $border_size, 'color' => $color, 'border_color' => $border_color, 'font_file_sn' => $font_file_sn, 'bg_color' => $bg_color, 'shadow_color' => $shadow_color, 'shadow_x' => $shadow_x, 'shadow_y' => $shadow_y, 'shadow_size' => $shadow_size, 'margin_top' => $margin_top, 'margin_bottom' => $margin_bottom, 'logo_width' => $logo_width, 'logo_height' => $logo_height]);

        header("location: font2pic.php?name=$filename");
        exit;

    //預設動作
    default:
        tad_themes_logo_form();
        $op = 'tad_themes_logo_form';
        break;

}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('op', $op);
require_once __DIR__ . '/footer.php';

/*-----------function區--------------*/
function tad_themes_logo_form()
{
    global $TadUpFontFiles, $xoopsTpl;

    if (isset($_SESSION['font_config'])) {
        $fc = json_decode($_SESSION['font_config'], true);
    }

    $pic = isset($_GET['name']) ? XOOPS_URL . "/uploads/tmp_logo/{$_GET['name']}.png" : '';

    $xoopsTpl->assign('pic', $pic);

    $name = isset($_GET['name']) ? $_GET['name'] : '';
    $xoopsTpl->assign('name', $name);

    $title = isset($fc['title']) ? $fc['title'] : '';
    $xoopsTpl->assign('title', $title);

    $size = isset($fc['size']) ? $fc['size'] : '16';
    $xoopsTpl->assign('size', $size);

    $border_size = isset($fc['border_size']) ? $fc['border_size'] : '2';
    $xoopsTpl->assign('border_size', $border_size);

    $color = isset($fc['color']) ? $fc['color'] : '#00a3a8';
    $color = str_replace('#', '', $color);
    $xoopsTpl->assign('color', $color);

    $border_color = isset($fc['border_color']) ? $fc['border_color'] : '#ffffff';
    $border_color = str_replace('#', '', $border_color);
    $xoopsTpl->assign('border_color', $border_color);

    $font_file_sn = isset($fc['font_file_sn']) ? $fc['font_file_sn'] : 0;
    $xoopsTpl->assign('font_file_sn', $font_file_sn);

    $bg_color = !empty($fc['bg_color']) ? $fc['bg_color'] : '#3c3c3c';
    $xoopsTpl->assign('bg_color', $bg_color);

    $shadow_color = !empty($fc['shadow_color']) ? $fc['shadow_color'] : '#000000';
    $shadow_color = str_replace('#', '', $shadow_color);
    $xoopsTpl->assign('shadow_color', $shadow_color);

    $shadow_x = isset($fc['shadow_x']) ? $fc['shadow_x'] : '1';
    $xoopsTpl->assign('shadow_x', $shadow_x);

    $shadow_y = isset($fc['shadow_y']) ? $fc['shadow_y'] : '1';
    $xoopsTpl->assign('shadow_y', $shadow_y);

    $shadow_size = isset($fc['shadow_size']) ? $fc['shadow_size'] : '3';
    $xoopsTpl->assign('shadow_size', $shadow_size);

    $fontUpForm = $TadUpFontFiles->upform(true, 'font', '', true, '.ttf,.otf,.ttc');
    $xoopsTpl->assign('fontUpForm', $fontUpForm);

    $fonts = $TadUpFontFiles->get_file();
    $xoopsTpl->assign('fonts', $fonts);

    $margin_top = isset($fc['margin_top']) ? $fc['margin_top'] : '0';
    $xoopsTpl->assign('margin_top', $margin_top);

    $margin_bottom = isset($fc['margin_bottom']) ? $fc['margin_bottom'] : '0';
    $xoopsTpl->assign('margin_bottom', $margin_bottom);

    $logo_width = isset($fc['logo_width']) ? $fc['logo_width'] : '0';
    $xoopsTpl->assign('logo_width', $logo_width);

    $logo_height = isset($fc['logo_height']) ? $fc['logo_height'] : '0';
    $xoopsTpl->assign('logo_height', $logo_height);

    $MColorPicker = new MColorPicker('.color-picker');
    $MColorPicker->render('bootstrap');

    $dir   = XOOPS_ROOT_PATH . '/uploads/logo/';
    $logos = [];
    // Open a known directory, and proceed to read its contents
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (false !== ($file = readdir($dh))) {
                if (false !== mb_strpos($file, '.png')) {
                    $logos[] = $file;
                }
            }
            closedir($dh);
        }
    }
    arsort($logos);
    $xoopsTpl->assign('logos', $logos);

    $SweetAlert = new SweetAlert();
    $SweetAlert->render('del_logo', 'font2pic.php?op=del_logo&logo=', 'logo');

    $FormValidator = new FormValidator('#myForm', true);
    $FormValidator->render();
}

function strLength($str, $charset = 'utf-8')
{
    if ($charset === 'utf-8') {
        $str = iconv('utf-8', 'big5', $str);
    }

    $num   = strlen($str);
    $cnNum = 0;
    for ($i = 0; $i < $num; ++$i) {
        if (ord(substr($str, $i, 1)) > 127) {
            $cnNum++;
        }
    }
    $enNum  = $num - ($cnNum * 2);
    $number = ($enNum / 2) + $cnNum;
    return ceil($number);
}

function delete_dirfile($dirname)
{
    if (is_dir($dirname)) {
        $dir_handle = opendir($dirname);
    }

    if (!$dir_handle) {
        return false;
    }

    while ($file = readdir($dir_handle)) {
        if ('.' !== $file && '..' !== $file) {
            if (!is_dir($dirname . '/' . $file)) {
                unlink($dirname . '/' . $file);
            } else {
                delete_dirfile($dirname . '/' . $file);
            }
        }
    }
    closedir($dir_handle);

    return true;
}

function save_to_logo($name = '', $theme_id = '')
{
    global $xoopsConfig, $xoopsDB;
    if (empty($theme_id)) {
        $theme_id = Tools::get_theme_id($xoopsConfig['theme_set']);
    }
    Tools::import_file(XOOPS_ROOT_PATH . "/uploads/tmp_logo/{$name}.png", 'logo', $theme_id, null, null, false);

    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes') . '`
        SET `logo_img` = ?
        WHERE `theme_id` = ?';
    Utility::query($sql, 'si', ["{$name}.png", $theme_id]);

    delete_dirfile(XOOPS_ROOT_PATH . '/uploads/tmp_logo');
}
