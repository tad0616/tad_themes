<?php

namespace XoopsModules\Tad_themes;

use XoopsModules\Tadtools\Utility;

/*
Update Class Definition

You may not change or alter any portion of this comment or credits of
supporting developers from this source code or any supporting source code
which is considered copyrighted (c) material of the original comment or credit
authors.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       Mamba <mambax7@gmail.com>
 */

/**
 * Class Update
 */
class Tools
{
    //data_center 加入 sort
    public static function del_theme_json($theme_name = '')
    {
        global $xoopsConfig;
        if (empty($theme_name)) {
            $theme_name = $xoopsConfig['theme_set'];
        }

        $json_file = XOOPS_VAR_PATH . "/data/theme_{$theme_name}.json";
        if (!unlink($json_file)) {
            throw new \Exception(sprintf(_MA_TADTHEMES_CANT_DELETE, $json_file));
        }
    }

    /*
     * Outputs a color (#000000) based Text input
     *
     * @param $text String of text
     * @param $min_brightness Integer between 0 and 100
     * @param $spec Integer between 2-10, determines how unique each color will be
     */

    public static function genColorCodeFromText($text, $min_brightness = 100, $spec = 10)
    {
        // Check inputs
        if (!is_int($min_brightness)) {
            throw new Exception("$min_brightness is not an integer");
        }

        if (!is_int($spec)) {
            throw new Exception("$spec is not an integer");
        }

        if ($spec < 2 or $spec > 10) {
            throw new Exception("$spec is out of range");
        }

        if ($min_brightness < 0 or $min_brightness > 255) {
            throw new Exception("$min_brightness is out of range");
        }

        $hash = md5($text); //Gen hash of text
        $colors = [];
        for ($i = 0; $i < 3; ++$i) {
            $colors[$i] = max([round(((hexdec(mb_substr($hash, $spec * $i, $spec))) / hexdec(str_pad('', $spec, 'F'))) * 255), $min_brightness]);
        }
        //convert hash into 3 decimal values between 0 and 255
        if ($min_brightness > 0) {
            //only check brightness requirements if min_brightness is about 100
            while (array_sum($colors) / 3 < $min_brightness) {
                //loop until brightness is above or equal to min_brightness
                for ($i = 0; $i < 3; ++$i) {
                    $colors[$i] += 10;
                }
            }
        }

        //increase each color by 10
        $output = '';
        for ($i = 0; $i < 3; ++$i) {
            $output .= str_pad(dechex($colors[$i]), 2, 0, STR_PAD_LEFT);
        }
        //convert each color to hex and append to output
        return '#' . $output;
    }

    //自動存入佈景(default 或 apply)
    public static function auto_import_theme($mode = '')
    {
        global $xoopsDB, $xoopsConfig, $config2_files, $TadDataCenter;

        $theme_name = $xoopsConfig['theme_set'];

        if (empty($theme_name)) {
            return;
        }

        if ($mode == 'default') {
            if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php")) {
                require XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php";
            }
        } else {
            if (file_exists(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config.php")) {
                require XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config.php";
            }
        }

        if (empty($config_enable)) {
            return;
        }

        foreach ($config_enable as $k => $v) {
            $$k = $v['default'];
        }

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

        $theme_type = empty($theme_type) ? 'theme_type_2' : $theme_type;

        $logo_top = (int) $logo_top;
        $logo_right = (int) $logo_right;
        $logo_bottom = (int) $logo_bottom;
        $logo_left = (int) $logo_left;
        $logo_center = (int) $logo_center;

        $theme_id = get_theme_id($theme_name);
        if (empty($theme_id)) {
            $sql = 'insert into ' . $xoopsDB->prefix('tad_themes') . "
            (`theme_name` , `theme_type` , `theme_width` , `lb_width` , `cb_width` , `rb_width` , `clb_width` , `crb_width` , `base_color` , `lb_color` , `cb_color` , `rb_color` , `margin_top` , `margin_bottom` , `bg_img` , `bg_color`  , `bg_repeat`  , `bg_size`  ,`bg_attachment`  , `bg_position`  , `logo_img`  , `logo_position`  , `navlogo_img` , `logo_top` , `logo_right` , `logo_bottom` , `logo_left` , `logo_center` , `theme_enable` , `slide_width` , `slide_height` , `font_size` , `font_color` , `link_color` , `hover_color` , `theme_kind` , `navbar_pos` , `navbar_bg_top` , `navbar_bg_bottom` , `navbar_hover` , `navbar_color` , `navbar_color_hover` , `navbar_icon`, `navbar_img`)
            values('{$theme_name}' , '{$theme_type}', '{$theme_width}' , '{$lb_width}', '{$cb_width}' , '{$rb_width}' , '{$clb_width}' , '{$crb_width}' , '{$base_color}' , '{$lb_color}' , '{$cb_color}' , '{$rb_color}' , '{$margin_top}' , '{$margin_bottom}' , '{$bg_img}' , '{$bg_color}' , '{$bg_repeat}', '{$bg_size}' , '{$bg_attachment}' , '{$bg_position}' , '{$logo_img}', '{$logo_position}' , '{$navlogo_img}' , '{$logo_top}' , '{$logo_right}' , '{$logo_bottom}' , '{$logo_left}' , '{$logo_center}' , '1' , '{$slide_width}' , '{$slide_height}' , '{$font_size}' , '{$font_color}' , '{$link_color}' , '{$hover_color}' , '{$theme_kind}', '{$navbar_pos}','{$navbar_bg_top}','{$navbar_bg_bottom}','{$navbar_hover}','{$navbar_color}','{$navbar_color_hover}','{$navbar_icon}','{$navbar_img}')";
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            // $sql = 'INSERT INTO `' . $xoopsDB->prefix('tad_themes') . '` (`theme_name`, `theme_type`, `theme_width`, `lb_width`, `cb_width`, `rb_width`, `clb_width`, `crb_width`, `base_color`, `lb_color`, `cb_color`, `rb_color`, `margin_top`, `margin_bottom`, `bg_img`, `bg_color`, `bg_repeat`, `bg_size`, `bg_attachment`, `bg_position`, `logo_img`, `logo_position`, `navlogo_img`, `logo_top`, `logo_right`, `logo_bottom`, `logo_left`, `logo_center`, `theme_enable`, `slide_width`, `slide_height`, `font_size`, `font_color`, `link_color`, `hover_color`, `theme_kind`, `navbar_pos`, `navbar_bg_top`, `navbar_bg_bottom`, `navbar_hover`, `navbar_color`, `navbar_color_hover`, `navbar_icon`, `navbar_img`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            // Utility::query($sql, 'sssssssssssssssssssssssiiiisssssssssssssssss', [$theme_name, $theme_type, $theme_width, $lb_width, $cb_width, $rb_width, $clb_width, $crb_width, $base_color, $lb_color, $cb_color, $rb_color, $margin_top, $margin_bottom, $bg_img, $bg_color, $bg_repeat, $bg_size, $bg_attachment, $bg_position, $logo_img, $logo_position, $navlogo_img, $logo_top, $logo_right, $logo_bottom, $logo_left, $logo_center, '1', $slide_width, $slide_height, $font_size, $font_color, $link_color, $hover_color, $theme_kind, $navbar_pos, $navbar_bg_top, $navbar_bg_bottom, $navbar_hover, $navbar_color, $navbar_color_hover, $navbar_icon, $navbar_img]) or Utility::web_error($sql, __FILE__, __LINE__);

            //取得最後新增資料的流水編號
            $theme_id = $xoopsDB->getInsertId();
        } else {
            $sql = 'update ' . $xoopsDB->prefix('tad_themes') . " set
            `theme_name`='{$theme_name}' ,
            `theme_type`='{$theme_type}' ,
            `theme_width`='{$theme_width}' ,
            `lb_width`='{$lb_width}' ,
            `cb_width`='{$cb_width}' ,
            `rb_width`='{$rb_width}' ,
            `clb_width`='{$clb_width}' ,
            `crb_width`='{$crb_width}' ,
            `base_color`='{$base_color}' ,
            `lb_color`='{$lb_color}' ,
            `cb_color`='{$cb_color}' ,
            `rb_color`='{$rb_color}' ,
            `margin_top`='{$margin_top}' ,
            `margin_bottom`='{$margin_bottom}' ,
            `bg_img`='{$bg_img}' ,
            `bg_color`='{$bg_color}'  ,
            `bg_repeat`='{$bg_repeat}'  ,
            `bg_size`='{$bg_size}'  ,
            `bg_attachment`='{$bg_attachment}'  ,
            `bg_position`='{$bg_position}'  ,
            `logo_img`='{$logo_img}'  ,
            `logo_position`='{$logo_position}'  ,
            `navlogo_img`='{$navlogo_img}' ,
            `logo_top`='{$logo_top}' ,
            `logo_right`='{$logo_right}' ,
            `logo_bottom`='{$logo_bottom}' ,
            `logo_left`='{$logo_left}' ,
            `logo_center`='{$logo_center}' ,
            `theme_enable`='{$theme_enable}' ,
            `slide_width`='{$slide_width}' ,
            `slide_height`='{$slide_height}' ,
            `font_size`='{$font_size}' ,
            `font_color`='{$font_color}' ,
            `link_color`='{$link_color}' ,
            `hover_color`='{$hover_color}' ,
            `theme_kind`='{$theme_kind}' ,
            `navbar_pos`='{$navbar_pos}' ,
            `navbar_bg_top`='{$navbar_bg_top}' ,
            `navbar_bg_bottom`='{$navbar_bg_bottom}' ,
            `navbar_hover`='{$navbar_hover}' ,
            `navbar_color`='{$navbar_color}' ,
            `navbar_color_hover`='{$navbar_color_hover}' ,
            `navbar_icon`='{$navbar_icon}',
            `navbar_img`='{$navbar_img}'
            where `theme_id`='{$theme_id}'";
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            // $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes') . '` SET `theme_name`=?, `theme_type`=?, `theme_width`=?, `lb_width`=?, `cb_width`=?, `rb_width`=?, `clb_width`=?, `crb_width`=?, `base_color`=?, `lb_color`=?, `cb_color`=?, `rb_color`=?, `margin_top`=?, `margin_bottom`=?, `bg_img`=?, `bg_color`=?, `bg_repeat`=?, `bg_size`=?, `bg_attachment`=?, `bg_position`=?, `logo_img`=?, `logo_position`=?, `navlogo_img`=?, `logo_top`=?, `logo_right`=?, `logo_bottom`=?, `logo_left`=?, `logo_center`=?, `theme_enable`=?, `slide_width`=?, `slide_height`=?, `font_size`=?, `font_color`=?, `link_color`=?, `hover_color`=?, `theme_kind`=?, `navbar_pos`=?, `navbar_bg_top`=?, `navbar_bg_bottom`=?, `navbar_hover`=?, `navbar_color`=?, `navbar_color_hover`=?, `navbar_icon`=?, `navbar_img`=? WHERE `theme_id`=?';
            // Utility::query($sql, 'sssssssssssssssssssssssiiiissssssssssssssssssi', [$theme_name, $theme_type, $theme_width, $lb_width, $cb_width, $rb_width, $clb_width, $crb_width, $base_color, $lb_color, $cb_color, $rb_color, $margin_top, $margin_bottom, $bg_img, $bg_color, $bg_repeat, $bg_size, $bg_attachment, $bg_position, $logo_img, $logo_position, $navlogo_img, $logo_top, $logo_right, $logo_bottom, $logo_left, $logo_center, $theme_enable, $slide_width, $slide_height, $font_size, $font_color, $link_color, $hover_color, $theme_kind, $navbar_pos, $navbar_bg_top, $navbar_bg_bottom, $navbar_hover, $navbar_color, $navbar_color_hover, $navbar_icon, $navbar_img, $theme_id]) or Utility::web_error($sql, __FILE__, __LINE__);

        }

        $TadDataCenter->set_col('theme_id', $theme_id);
        $data_arr = [
            'navbar_py' => [$navbar_py],
            'navbar_px' => [$navbar_px],
        ];
        $TadDataCenter->saveCustomData($data_arr);

        update_tadtools_setup($theme_name, $theme_kind);

        if ($mode == 'default') {
            self::copy_default_file();
        }
        import_img(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bg", 'bg', $theme_id, '');
        import_img(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/logo", 'logo', $theme_id, '');
        import_img(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/slide", 'slide', $theme_id, '');
        import_img(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/nav_bg", 'navbar_img', $theme_id, '');
        import_img(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/navlogo", 'navlogo', $theme_id, '');
        import_img(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bt_bg", 'bt_bg', $theme_id, '');
        import_img(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config2", 'config2', $theme_id, '');
        foreach ($block_position_title as $position => $ttt) {
            import_img(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bt_bg_{$position}", 'bt_bg_{$position}', $theme_id, '');

        }

        //儲存區塊設定
        self::save_blocks($theme_id, true, $mode);

        //匯入額外設定值
        save_config2($theme_id, $config2_files, $mode);
        $sql = 'SELECT `name`, `value` FROM `' . $xoopsDB->prefix('tad_themes_config2') . "` WHERE `theme_id`='$theme_id' AND (`type`='bg_file' OR `type`='file')";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        while (list($name, $value) = $xoopsDB->fetchRow($result)) {
            if ($value) {
                $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes_files_center') . "` SET `col_name`='config2_', `sort`=1 WHERE `col_sn`='$theme_id' AND `col_name`='config2' AND `file_name`='$value'";
                $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

            }
        }

        header('location: main.php');
        exit;
    }

    // 匯入或套用設定檔
    public static function copy_default_file()
    {
        global $xoopsConfig;
        $theme_name = $xoopsConfig['theme_set'];
        $source = XOOPS_ROOT_PATH . "/themes/{$theme_name}/images";
        $target = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}";
        Utility::mk_dir($target);
        Utility::full_copy($source, $target);
    }

    //儲存區塊設定
    public static function save_blocks($theme_id = '', $import = false, $mode = '')
    {
        global $xoopsDB, $block_position_title, $xoopsConfig;

        $theme_name = $xoopsConfig['theme_set'];

        if ($mode == 'default') {
            if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php")) {
                require XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php";
            }
        } else {
            if (file_exists(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config.php")) {
                require XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config.php";
            }
        }

        if (empty($block_position_title)) {
            return;
        }

        $bt_bg_img = !empty($bt_bg_img) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/bt_bg/{$bt_bg_img}" : '';

        if ($import) {
            foreach ($block_position_title as $position => $title) {
                if (isset($config_enable['bt_bg_img'][$position])) {
                    $bt_bg_img_arr[$position] = !empty($config_enable['bt_bg_img'][$position]['default']) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/bt_bg/{$config_enable['bt_bg_img'][$position]['default']}" : '';
                } else {
                    $bt_bg_img_arr[$position] = !empty($config_enable['bt_bg_img']['default']) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/bt_bg/{$config_enable['bt_bg_img']['default']}" : '';
                }

                $block_config_arr[$position] = isset($config_enable['block_config'][$position]) ? $config_enable['block_config'][$position]['default'] : $config_enable['block_config']['default'];
                if (empty($block_config_arr[$position])) {
                    $block_config_arr[$position] = 'right';
                }

                $bt_text_arr[$position] = isset($config_enable['bt_text'][$position]) ? $config_enable['bt_text'][$position]['default'] : $config_enable['bt_text']['default'];
                $bt_text_padding_arr[$position] = isset($config_enable['bt_text_padding'][$position]) ? $config_enable['bt_text_padding'][$position]['default'] : $config_enable['bt_text_padding']['default'];
                $bt_text_size_arr[$position] = isset($config_enable['bt_text_size'][$position]) ? $config_enable['bt_text_size'][$position]['default'] : $config_enable['bt_text_size']['default'];
                $bt_bg_color_arr[$position] = isset($config_enable['bt_bg_color'][$position]) ? $config_enable['bt_bg_color'][$position]['default'] : $config_enable['bt_bg_color']['default'];
                $bt_bg_repeat_arr[$position] = isset($config_enable['bt_bg_repeat'][$position]) ? $config_enable['bt_bg_repeat'][$position]['default'] : $config_enable['bt_bg_repeat']['default'];
                $bt_radius_arr[$position] = isset($config_enable['bt_radius'][$position]) ? $config_enable['bt_radius'][$position]['default'] : $config_enable['bt_radius']['default'];
                $block_style_arr[$position] = isset($config_enable['block_style'][$position]) ? $config_enable['block_style'][$position]['default'] : $config_enable['block_style']['default'];
                $block_title_style_arr[$position] = isset($config_enable['block_title_style'][$position]) ? $config_enable['block_title_style'][$position]['default'] : $config_enable['block_title_style']['default'];
                $block_content_style_arr[$position] = isset($config_enable['block_content_style'][$position]) ? $config_enable['block_content_style'][$position]['default'] : $config_enable['block_content_style']['default'];
            }
        } elseif (!empty($_POST['apply_to_all'])) {
            $apply_to_all_position = $_POST['apply_to_all'];
            foreach ($block_position_title as $position => $title) {
                $block_config_arr[$position] = $_POST['block_config'][$apply_to_all_position];
                $bt_text_arr[$position] = $_POST['bt_text'][$apply_to_all_position];
                $bt_text_padding_arr[$position] = $_POST['bt_text_padding'][$apply_to_all_position];
                $bt_text_size_arr[$position] = $_POST['bt_text_size'][$apply_to_all_position];
                $bt_bg_color_arr[$position] = $_POST['bt_bg_color'][$apply_to_all_position];
                $bt_bg_img_arr[$position] = $_POST['bt_bg_img'][$apply_to_all_position];
                $bt_bg_repeat_arr[$position] = $_POST['bt_bg_repeat'][$apply_to_all_position];
                $bt_radius_arr[$position] = $_POST['bt_radius'][$apply_to_all_position];
                $block_style_arr[$position] = $_POST['block_style'][$apply_to_all_position];
                $block_title_style_arr[$position] = $_POST['block_title_style'][$apply_to_all_position];
                $block_content_style_arr[$position] = $_POST['block_content_style'][$apply_to_all_position];
            }
        } else {
            foreach ($block_position_title as $position => $title) {
                $block_config_arr[$position] = $_POST['block_config'][$position];
                $bt_text_arr[$position] = $_POST['bt_text'][$position];
                $bt_text_padding_arr[$position] = $_POST['bt_text_padding'][$position];
                $bt_text_size_arr[$position] = $_POST['bt_text_size'][$position];
                $bt_bg_color_arr[$position] = $_POST['bt_bg_color'][$position];
                $bt_bg_img_arr[$position] = $_POST['bt_bg_img'][$position];
                $bt_bg_repeat_arr[$position] = $_POST['bt_bg_repeat'][$position];
                $bt_radius_arr[$position] = $_POST['bt_radius'][$position];
                $block_style_arr[$position] = $_POST['block_style'][$position];
                $block_title_style_arr[$position] = $_POST['block_title_style'][$position];
                $block_content_style_arr[$position] = $_POST['block_content_style'][$position];
            }
        }

        foreach ($block_position_title as $position => $title) {
            $block_config = isset($block_config_arr[$position]) ? $block_config_arr[$position] : '';
            $bt_text = isset($bt_text_arr[$position]) ? $bt_text_arr[$position] : '';
            $bt_text_padding = isset($bt_text_padding_arr[$position]) ? $bt_text_padding_arr[$position] : '';
            $bt_text_size = isset($bt_text_size_arr[$position]) ? $bt_text_size_arr[$position] : '';
            $bt_bg_color = isset($bt_bg_color_arr[$position]) ? $bt_bg_color_arr[$position] : '';
            $bt_bg_img = isset($bt_bg_img_arr[$position]) ? $bt_bg_img_arr[$position] : '';
            $bt_bg_repeat = isset($bt_bg_repeat_arr[$position]) ? $bt_bg_repeat_arr[$position] : '';
            $bt_radius = isset($bt_radius_arr[$position]) ? $bt_radius_arr[$position] : '';
            $block_style = isset($block_style_arr[$position]) ? $block_style_arr[$position] : '';
            $block_title_style = isset($block_title_style_arr[$position]) ? $block_title_style_arr[$position] : '';
            $block_content_style = isset($block_content_style_arr[$position]) ? $block_content_style_arr[$position] : '';

            $bt_text_padding = (int) $bt_text_padding;
            $bt_bg_repeat = (int) $bt_bg_repeat;
            $bt_radius = (int) $bt_radius;

            $sql = 'REPLACE INTO `' . $xoopsDB->prefix('tad_themes_blocks') . '` (`theme_id`, `block_position`, `block_config`, `bt_text`, `bt_text_padding`, `bt_text_size`, `bt_bg_color`, `bt_bg_img`, `bt_bg_repeat`, `bt_radius`, `block_style`, `block_title_style`, `block_content_style`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            Utility::query($sql, 'issssssssssss', [$theme_id, $position, $block_config, $bt_text, $bt_text_padding, $bt_text_size, $bt_bg_color, $bt_bg_img, $bt_bg_repeat, $bt_radius, $block_style, $block_title_style, $block_content_style]) or Utility::web_error($sql, __FILE__, __LINE__);

            $TadUpFilesBt_bg = TadUpFilesBt_bg();
            // die(var_dump($TadUpFilesBt_bg));
            $TadUpFilesBt_bg->set_col("bt_bg_{$position}", $theme_id);
            $bt_bg_img = $TadUpFilesBt_bg->upload_file("bt_bg_{$position}", null, null, null, '', true);
            if ($bt_bg_img) {
                $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes_blocks') . '`
            SET `bt_bg_img` = ?
            WHERE `theme_id` = ?
            AND `block_position` = ?';
                Utility::query($sql, 'sis',
                    [XOOPS_URL . "/uploads/tad_themes/{$theme_name}/bt_bg/{$bt_bg_img}", $theme_id, $position])
                or Utility::web_error($sql, __FILE__, __LINE__);

            }

        }
    }

}
