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

    $fontUpForm = $TadUpFontFiles->upform(true, 'font');
    $xoopsTpl->assign('fontUpForm', $fontUpForm);

    $fonts = $TadUpFontFiles->get_file();
    $xoopsTpl->assign('fonts', $fonts);

    $margin_top = isset($fc['margin_top']) ? $fc['margin_top'] : '0';
    $xoopsTpl->assign('margin_top', $margin_top);

    $margin_bottom = isset($fc['margin_bottom']) ? $fc['margin_bottom'] : '0';
    $xoopsTpl->assign('margin_bottom', $margin_bottom);

    $MColorPicker = new MColorPicker('.color');
    $MColorPicker->render();

    $dir = XOOPS_ROOT_PATH . '/uploads/logo/';
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

    $num = strlen($str);
    $cnNum = 0;
    for ($i = 0; $i < $num; $i++) {
        if (ord(substr($str, $i, 1)) > 127) {
            $cnNum++;
        }
    }
    $enNum = $num - ($cnNum * 2);
    $number = ($enNum / 2) + $cnNum;
    return ceil($number);
}

//製作logo圖
function mkTitlePic($title = '', $size = 24, $border_size = 2, $color = '#00a3a8', $border_color = '#FFFFFF', $font_file_sn = 0, $shadow_color = '#000000', $shadow_x = 1, $shadow_y = 1, $shadow_size = 3, $margin_top = 0, $margin_bottom = 0)
{
    global $TadUpFontFiles;
    $font = $TadUpFontFiles->get_file($font_file_sn);

    //找字數
    if (function_exists('mb_strlen')) {
        $n = mb_strlen($title);
    } else {
        $n = strlen($title) / 3;
    }

    if (empty($size)) {
        return;
    }

    $width = $size * 1.4 * $n;
    $height = $size * 2 + $margin_top + $margin_bottom;

    $x = 2;
    $y = $size * 1.5;
    list($color_r, $color_g, $color_b) = sscanf($color, '#%02x%02x%02x');
    list($border_color_r, $border_color_g, $border_color_b) = sscanf($border_color, '#%02x%02x%02x');
    list($shadow_color_r, $shadow_color_g, $shadow_color_b) = sscanf($shadow_color, '#%02x%02x%02x');

    header('Content-type: image/png');
    $im = imagecreatetruecolor($width, $height);
    // 開了外框會模糊掉
    // imagealphablending($im, false);
    imagesavealpha($im, true);

    $trans_colour = imagecolorallocatealpha($im, 255, 255, 255, 127);
    imagefill($im, 0, 0, $trans_colour);

    $text_color = imagecolorallocate($im, $color_r, $color_g, $color_b);
    $text_border_color = imagecolorallocate($im, $border_color_r, $border_color_g, $border_color_b);
    $text_shadow_color = imagecolorallocatealpha($im, $shadow_color_r, $shadow_color_g, $shadow_color_b, 50);

    $gd = gd_info();
    if ($gd['JIS-mapped Japanese Font Support']) {
        $title = iconv('UTF-8', 'shift_jis', $title);
    }
    // die('shadow_size='.$shadow_size);
    if ($shadow_size > 0) {
        $sx = $shadow_x > 0 ? $shadow_x + $border_size : $shadow_x - $border_size;
        $sy = $shadow_y > 0 ? $shadow_y + $border_size : $shadow_y - $border_size;

        imagettftextblur($im, $size, 0, $x + $sx, $y + $sy + $margin_top, $text_shadow_color, $font[$font_file_sn]['physical_file_path'], $title, $shadow_size);
    }

    imagettftext($im, $size, 0, $x, $y + $margin_top, $text_color, $font[$font_file_sn]['physical_file_path'], $title);

    if ('transparent' !== $border_color) {
        imagettftextoutline($im, $size, 0, $x, $y + $margin_top, $text_color, $text_border_color, $font[$font_file_sn]['physical_file_path'], $title, $border_size);
    }

    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tmp_logo');
    $filename = date('ymdHis');
    imagepng($im, XOOPS_ROOT_PATH . "/uploads/tmp_logo/{$filename}.png");
    imagedestroy($im);

    return $filename;
}

function imagettftextoutline(&$im, $size, $angle, $x, $y, &$col, &$outlinecol, $fontfile, $text, $width)
{
    // For every X pixel to the left and the right
    for ($xc = $x - abs($width); $xc <= $x + abs($width); $xc++) {
        // For every Y pixel to the top and the bottom
        for ($yc = $y - abs($width); $yc <= $y + abs($width); $yc++) {
            // Draw the text in the outline color
            $text1 = imagettftext($im, $size, $angle, $xc, $yc, $outlinecol, $fontfile, $text);
        }
    }
    // Draw the main text
    $text2 = imagettftext($im, $size, $angle, $x, $y, $col, $fontfile, $text);
}

function imagettftextblur(&$im, $size, $angle, $x, $y, $color, $fontfile, $text, $blur_intensity = 0, $blur_filter = IMG_FILTER_GAUSSIAN_BLUR)
{
    $blur_intensity = (int) $blur_intensity;
    // $blur_intensity needs to be an integer greater than zero; if it is not we
    // treat this function call identically to imagettftext
    if (is_int($blur_intensity) && $blur_intensity > 0) {
        // $return_array will be returned once all calculations are complete
        $return_array = [
            imagesx($im), // lower left, x coordinate
            -1, // lower left, y coordinate
            -1, // lower right, x coordinate
            -1, // lower right, y coordinate
            -1, // upper right, x coordinate
            imagesy($im), // upper right, y coordinate
            imagesx($im), // upper left, x coordinate
            imagesy($im), // upper left, y coordinate
        ];
        // $temporary_image is a GD image that is the same size as our
        // original GD image
        $temporary_image = imagecreatetruecolor(
            imagesx($im),
            imagesy($im)
        );
        // fill $temporary_image with a black background
        imagefill(
            $temporary_image,
            0,
            0,
            imagecolorallocate($temporary_image, 0x00, 0x00, 0x00)
        );
        // add white text to $temporary_image with the function call's
        // parameters
        imagettftext(
            $temporary_image,
            $size,
            $angle,
            $x,
            $y,
            imagecolorallocate($temporary_image, 0xFF, 0xFF, 0xFF),
            $fontfile,
            $text
        );
        // execute the blur filters
        for ($blur = 1; $blur <= $blur_intensity; $blur++) {
            imagefilter($temporary_image, $blur_filter);
        }
        // set $color_opacity based on $color's transparency
        $color_opacity = imagecolorsforindex($im, $color)['alpha'];
        $color_opacity = (127 - $color_opacity) / 127;
        // loop through each pixel in $temporary_image
        for ($_x = 0; $_x < imagesx($temporary_image); $_x++) {
            for ($_y = 0; $_y < imagesy($temporary_image); $_y++) {
                // $visibility is the grayscale of the current pixel multiplied
                // by $color_opacity
                $visibility = (imagecolorat(
                    $temporary_image,
                    $_x,
                    $_y
                ) & 0xFF) / 255 * $color_opacity;
                // if the current pixel would not be invisible then add it to
                // $im
                if ($visibility > 0) {
                    // we know we are on an affected pixel so ensure
                    // $return_array is updated accordingly
                    $return_array[0] = min($return_array[0], $_x);
                    $return_array[1] = max($return_array[1], $_y);
                    $return_array[2] = max($return_array[2], $_x);
                    $return_array[3] = max($return_array[3], $_y);
                    $return_array[4] = max($return_array[4], $_x);
                    $return_array[5] = min($return_array[5], $_y);
                    $return_array[6] = min($return_array[6], $_x);
                    $return_array[7] = min($return_array[7], $_y);
                    // set the current pixel in $im
                    imagesetpixel(
                        $im,
                        $_x,
                        $_y,
                        imagecolorallocatealpha(
                            $im,
                            ($color >> 16) & 0xFF,
                            ($color >> 8) & 0xFF,
                            $color & 0xFF,
                            (1 - $visibility) * 127
                        )
                    );
                }
            }
        }
        // destroy our $temporary_image
        imagedestroy($temporary_image);
        return $return_array;
    } else {
        return imagettftext(
            $im,
            $size,
            $angle,
            $x,
            $y,
            $color,
            $fontfile,
            $text
        );
    }
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
        $theme_id = get_theme_id($xoopsConfig['theme_set']);
    }
    import_file(XOOPS_ROOT_PATH . "/uploads/tmp_logo/{$name}.png", 'logo', $theme_id, null, null, '', false, false);
    $sql = 'update ' . $xoopsDB->prefix('tad_themes') . " set logo_img='{$name}.png' where theme_id='{$theme_id}'";
    $xoopsDB->queryF($sql);
    delete_dirfile(XOOPS_ROOT_PATH . '/uploads/tmp_logo');
}

/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$title = Request::getString('title');
$color = Request::getString('color', '#00a3a8');
$border_color = Request::getString('border_color', '#ffffff');
$name = Request::getString('name');
$bg_color = Request::getString('bg_color');
$logo = Request::getString('logo');
$shadow_color = Request::getString('shadow_color', '#000000');
$theme_id = Request::getInt('theme_id');
$files_sn = Request::getInt('files_sn');
$status = Request::getInt('status', 1);
$size = Request::getInt('size', 24);
$font_file_sn = Request::getInt('font_file_sn');
$border_size = Request::getInt('border_size', 2);
$sav_to_logo = Request::getInt('sav_to_logo');
$shadow_x = Request::getInt('shadow_x', 1);
$shadow_y = Request::getInt('shadow_y', 1);
$shadow_size = Request::getInt('shadow_size', 3);
$margin_top = Request::getInt('margin_top');
$margin_bottom = Request::getInt('margin_bottom');

switch ($op) {
    /*---判斷動作請貼在下方---*/

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
        $TadUpFontFiles->upload_file('font', null, null, $files_sn, null, true);
        header("location: " . \Xmf\Request::getString('HTTP_REFERER', '', 'SERVER'));
        exit;

    case 'mkTitlePic':
        $filename = mkTitlePic($title, $size, $border_size, $color, $border_color, $font_file_sn, $shadow_color, $shadow_x, $shadow_y, $shadow_size, $margin_top, $margin_bottom);
        $color = str_replace('#', '', $color);
        $border_color = str_replace('#', '', $border_color);

        $_SESSION['font_config'] = json_encode(['title' => $title, 'size' => $size, 'border_size' => $border_size, 'color' => $color, 'border_color' => $border_color, 'font_file_sn' => $font_file_sn, 'bg_color' => $bg_color, 'shadow_color' => $shadow_color, 'shadow_x' => $shadow_x, 'shadow_y' => $shadow_y, 'shadow_size' => $shadow_size, 'margin_top' => $margin_top, 'margin_bottom' => $margin_bottom]);

        header("location: font2pic.php?name=$filename");
        exit;

    //預設動作
    default:
        tad_themes_logo_form();
        $op = 'tad_themes_logo_form';
        break;
        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('op', $op);
$xoTheme->addStylesheet(XOOPS_URL . '/modules/tad_themes/css/module.css');
require_once __DIR__ . '/footer.php';
