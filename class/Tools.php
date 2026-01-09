<?php

namespace XoopsModules\Tad_themes;

use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\TadUpFiles;
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

// 將語言檔載入放在類別外部
xoops_loadLanguage('admin', 'tad_themes');

/**
 * Class Update
 */
class Tools
{
    public static $config2_files_arr = [
        'config2_base'    => ['label' => _MA_TADTHEMES_THEME_BASE, 'tpl' => 'sub_theme_config_1', 'type' => 'config', 'key' => '1'],
        'config2_bg'      => ['label' => _MA_TADTHEMES_BG_IMG, 'tpl' => 'sub_theme_config_2', 'type' => 'config', 'key' => '2'],
        'config2_logo'    => ['label' => _MA_TADTHEMES_LOGO_IMG, 'tpl' => 'sub_theme_config_4', 'type' => 'config', 'key' => '4'],
        'config2_nav'     => ['label' => _MA_TADTHEMES_NAVBAR, 'tpl' => 'sub_theme_config_6', 'type' => 'config', 'key' => '6'],
        'config2_slide'   => ['label' => _MA_TAD_THEMES_HEAD, 'tpl' => 'sub_theme_config_3', 'type' => 'config', 'key' => '3'],
        'config2_content' => ['label' => _MA_TADTHEMES_CONTENT, 'tpl' => 'sub_theme_config_custom', 'type' => 'config2'],
        'config2_block'   => ['label' => _MA_TADTHEMES_BLOCK_TITLE, 'tpl' => 'sub_theme_config_5', 'type' => 'config', 'key' => '5'],
        'config2_footer'  => ['label' => _MA_TADTHEMES_FOOTER, 'tpl' => 'sub_theme_config_custom', 'type' => 'config2'],
        'config2_top'     => ['label' => _MA_TADTHEMES_TOP, 'tpl' => 'sub_theme_config_custom', 'type' => 'config2'],
        'config2_middle'  => ['label' => _MA_TADTHEMES_MIDDLE, 'tpl' => 'sub_theme_config_custom', 'type' => 'config2'],
        'config2_bottom'  => ['label' => _MA_TADTHEMES_BOTTOM, 'tpl' => 'sub_theme_config_custom', 'type' => 'config2'],
        'config2'         => ['label' => _MA_TADTHEMES_CONFIG2, 'tpl' => 'sub_theme_config_custom', 'type' => 'config2'],
    ];
    public static $block_position_title = ['leftBlock' => _MA_TADTHEMES_BLOCK_LEFT, 'rightBlock' => _MA_TADTHEMES_BLOCK_RIGHT, 'centerBlock' => _MA_TADTHEMES_BLOCK_TOP_CENTER, 'centerLeftBlock' => _MA_TADTHEMES_BLOCK_TOP_LEFT, 'centerRightBlock' => _MA_TADTHEMES_BLOCK_TOP_RIGHT, 'centerBottomBlock' => _MA_TADTHEMES_BLOCK_BOTTOM_CENTER, 'centerBottomLeftBlock' => _MA_TADTHEMES_BLOCK_BOTTOM_LEFT, 'centerBottomRightBlock' => _MA_TADTHEMES_BLOCK_BOTTOM_RIGHT, 'footerCenterBlock' => _MA_TADTHEMES_BLOCK_FOOTER_CENTER, 'footerLeftBlock' => _MA_TADTHEMES_BLOCK_FOOTER_LEFT, 'footerRightBlock' => _MA_TADTHEMES_BLOCK_FOOTER_RIGHT];

    //data_center 加入 sort
    public static function del_theme_json($theme_name = '')
    {
        global $xoopsConfig;
        if (empty($theme_name)) {
            $theme_name = $xoopsConfig['theme_set'];
        }

        // $theme_json_file = XOOPS_VAR_PATH . "/data/theme_{$theme_name}.json";
        $theme_json_file = XOOPS_VAR_PATH . "/data/{$theme_name}_setup.json";

        if (file_exists($theme_json_file)) {
            if (!is_writable($theme_json_file)) {
                throw new \Exception(sprintf(_MA_TADTHEMES_CANT_WRITE, $theme_json_file));
            }

            if (!unlink($theme_json_file)) {
                throw new \Exception(sprintf(_MA_TADTHEMES_CANT_DELETE, $theme_json_file));
            }
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

        $hash   = md5($text); //Gen hash of text
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

    //自動存入佈景(default 或 apply 或 school_apply)
    public static function auto_import_theme($mode = '')
    {
        global $xoopsDB, $xoopsConfig;
        $TadDataCenter = new TadDataCenter('tad_themes');
        $theme_name    = $xoopsConfig['theme_set'];

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
        Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/navlogo");
        Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/navlogo/thumbs");
        Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config2");
        Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config2/thumbs");

        $theme_type = empty($theme_type) ? 'theme_type_2' : $theme_type;

        $logo_top    = (int) $logo_top;
        $logo_right  = (int) $logo_right;
        $logo_bottom = (int) $logo_bottom;
        $logo_left   = (int) $logo_left;
        $logo_center = (int) $logo_center;

        $theme_id = self::get_theme_id($theme_name);
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
            $logo_update = '';
            if ($mode != 'school_apply') {
                $logo_update = "`logo_img`='{$logo_img}'  ,";
            }
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
            $logo_update
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
        }

        $TadDataCenter->set_col('theme_id', $theme_id);
        $data_arr = [
            'navbar_py' => [$navbar_py],
            'navbar_px' => [$navbar_px],
        ];
        $TadDataCenter->saveCustomData($data_arr);

        self::update_tadtools_setup($theme_name, $theme_kind);

        if ($mode == 'default') {
            self::copy_default_file();
        }
        self::import_img(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bg", 'bg', $theme_id, '');
        // if ($mode != 'school_apply') {
        self::import_img(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/logo", 'logo', $theme_id, '');
        self::import_img(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/slide", 'slide', $theme_id, '');
        // }
        self::import_img(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/nav_bg", 'navbar_img', $theme_id, '');
        self::import_img(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/navlogo", 'navlogo', $theme_id, '');
        self::import_img(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bt_bg", 'bt_bg', $theme_id, '');
        self::import_img(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config2", 'config2', $theme_id, '');
        foreach (self::$block_position_title as $position => $ttt) {
            self::import_img(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bt_bg_{$position}", 'bt_bg_{$position}', $theme_id, '');

        }

        //儲存區塊設定
        self::save_blocks($theme_id, true, $mode);

        //匯入額外設定值
        $config2_files = array_keys(Tools::$config2_files_arr);
        self::save_config2($theme_id, $config2_files, $mode);
        $sql    = 'SELECT `name`, `value` FROM `' . $xoopsDB->prefix('tad_themes_config2') . "` WHERE `theme_id`='$theme_id' AND (`type`='bg_file' OR `type`='file')";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        while (list($name, $value) = $xoopsDB->fetchRow($result)) {
            if ($value) {
                $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes_files_center') . "` SET `col_name`='config2_{$name}', `sort`=1 WHERE `col_sn`='$theme_id' AND `col_name`='config2' AND `file_name`='$value'";
                $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            }
        }
    }

    //取得佈景編號
    public static function get_theme_id($theme_name = '')
    {
        global $xoopsDB;

        $sql    = 'SELECT `theme_id` FROM `' . $xoopsDB->prefix('tad_themes') . '` WHERE `theme_name` =?';
        $result = Utility::query($sql, 's', [$theme_name]) or Utility::web_error($sql, __FILE__, __LINE__);

        list($theme_id) = $xoopsDB->fetchRow($result);

        return $theme_id;
    }

    // 匯入或套用設定檔
    public static function copy_default_file()
    {
        global $xoopsConfig;
        $theme_name = $xoopsConfig['theme_set'];
        $source     = XOOPS_ROOT_PATH . "/themes/{$theme_name}/images";
        $target     = XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}";
        Utility::mk_dir($target);
        Utility::full_copy($source, $target);
    }

    /**
     * 創建TadUpFiles對象，用於處理各種類型的文件上傳
     *
     * @param string $type 文件類型（'bt_bg', 'config2', 'slide', 'bg', 'logo', 'navlogo', 'nav_bg'等）
     * @param string $theme_set 主題名稱，如果為空則使用當前主題
     * @return TadUpFiles 返回配置好的TadUpFiles對象
     */
    public static function getTadUpFilesObj($type = 'bt_bg', $theme_set = '')
    {
        global $xoopsConfig;
        if (empty($theme_set)) {
            $theme_set = $xoopsConfig['theme_set'];
        }

        $TadUpFiles = new TadUpFiles('tad_themes', "/{$theme_set}/{$type}", null, '', '/thumbs');
        $TadUpFiles->set_thumb('100px', '60px', '#000', 'center center', 'no-repeat', 'contain');

        return $TadUpFiles;
    }

    //儲存區塊設定
    public static function save_blocks($theme_id = '', $import = false, $mode = '')
    {
        global $xoopsDB, $xoopsConfig;

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

        if (empty(self::$block_position_title)) {
            return;
        }

        // $bt_bg_img = !empty($bt_bg_img) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/bt_bg/{$bt_bg_img}" : '';

        if ($import) {
            foreach (self::$block_position_title as $position => $title) {
                if (isset($config_enable['bt_bg_img'][$position])) {
                    $bt_bg_img_arr[$position] = !empty($config_enable['bt_bg_img'][$position]['default']) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/bt_bg/{$config_enable['bt_bg_img'][$position]['default']}" : '';
                } else {
                    $bt_bg_img_arr[$position] = !empty($config_enable['bt_bg_img']['default']) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/bt_bg/{$config_enable['bt_bg_img']['default']}" : '';
                }

                $block_config_arr[$position] = isset($config_enable['block_config'][$position]) ? $config_enable['block_config'][$position]['default'] : $config_enable['block_config']['default'];
                if (empty($block_config_arr[$position])) {
                    $block_config_arr[$position] = 'right';
                }

                $bt_text_arr[$position]             = isset($config_enable['bt_text'][$position]) ? $config_enable['bt_text'][$position]['default'] : $config_enable['bt_text']['default'];
                $bt_text_padding_arr[$position]     = isset($config_enable['bt_text_padding'][$position]) ? $config_enable['bt_text_padding'][$position]['default'] : $config_enable['bt_text_padding']['default'];
                $bt_text_size_arr[$position]        = isset($config_enable['bt_text_size'][$position]) ? $config_enable['bt_text_size'][$position]['default'] : $config_enable['bt_text_size']['default'];
                $bt_bg_color_arr[$position]         = isset($config_enable['bt_bg_color'][$position]) ? $config_enable['bt_bg_color'][$position]['default'] : $config_enable['bt_bg_color']['default'];
                $bt_bg_repeat_arr[$position]        = isset($config_enable['bt_bg_repeat'][$position]) ? $config_enable['bt_bg_repeat'][$position]['default'] : $config_enable['bt_bg_repeat']['default'];
                $bt_radius_arr[$position]           = isset($config_enable['bt_radius'][$position]) ? $config_enable['bt_radius'][$position]['default'] : $config_enable['bt_radius']['default'];
                $block_style_arr[$position]         = isset($config_enable['block_style'][$position]) ? $config_enable['block_style'][$position]['default'] : $config_enable['block_style']['default'];
                $block_title_style_arr[$position]   = isset($config_enable['block_title_style'][$position]) ? $config_enable['block_title_style'][$position]['default'] : $config_enable['block_title_style']['default'];
                $block_content_style_arr[$position] = isset($config_enable['block_content_style'][$position]) ? $config_enable['block_content_style'][$position]['default'] : $config_enable['block_content_style']['default'];
            }
        } elseif (!empty($_POST['apply_to_all'])) {
            $apply_to_all_position = (string) $_POST['apply_to_all'];
            foreach (self::$block_position_title as $position => $title) {
                $block_config_arr[$position]        = (string) $_POST['block_config'][$apply_to_all_position];
                $bt_text_arr[$position]             = (string) $_POST['bt_text'][$apply_to_all_position];
                $bt_text_padding_arr[$position]     = (string) $_POST['bt_text_padding'][$apply_to_all_position];
                $bt_text_size_arr[$position]        = (string) $_POST['bt_text_size'][$apply_to_all_position];
                $bt_bg_color_arr[$position]         = (string) $_POST['bt_bg_color'][$apply_to_all_position];
                $bt_bg_img_arr[$position]           = (string) $_POST['bt_bg_img'][$apply_to_all_position];
                $bt_bg_repeat_arr[$position]        = (string) $_POST['bt_bg_repeat'][$apply_to_all_position];
                $bt_radius_arr[$position]           = (string) $_POST['bt_radius'][$apply_to_all_position];
                $block_style_arr[$position]         = (string) $_POST['block_style'][$apply_to_all_position];
                $block_title_style_arr[$position]   = (string) $_POST['block_title_style'][$apply_to_all_position];
                $block_content_style_arr[$position] = (string) $_POST['block_content_style'][$apply_to_all_position];
            }
        } else {
            foreach (self::$block_position_title as $position => $title) {
                $block_config_arr[$position]        = (string) $_POST['block_config'][$position];
                $bt_text_arr[$position]             = (string) $_POST['bt_text'][$position];
                $bt_text_padding_arr[$position]     = (string) $_POST['bt_text_padding'][$position];
                $bt_text_size_arr[$position]        = (string) $_POST['bt_text_size'][$position];
                $bt_bg_color_arr[$position]         = (string) $_POST['bt_bg_color'][$position];
                $bt_bg_img_arr[$position]           = (string) $_POST['bt_bg_img'][$position];
                $bt_bg_repeat_arr[$position]        = (string) $_POST['bt_bg_repeat'][$position];
                $bt_radius_arr[$position]           = (string) $_POST['bt_radius'][$position];
                $block_style_arr[$position]         = (string) $_POST['block_style'][$position];
                $block_title_style_arr[$position]   = (string) $_POST['block_title_style'][$position];
                $block_content_style_arr[$position] = (string) $_POST['block_content_style'][$position];
            }
        }

        foreach (self::$block_position_title as $position => $title) {
            $block_config        = isset($block_config_arr[$position]) ? $block_config_arr[$position] : '';
            $bt_text             = isset($bt_text_arr[$position]) ? $bt_text_arr[$position] : '';
            $bt_text_padding     = isset($bt_text_padding_arr[$position]) ? $bt_text_padding_arr[$position] : '';
            $bt_text_size        = isset($bt_text_size_arr[$position]) ? $bt_text_size_arr[$position] : '';
            $bt_bg_color         = isset($bt_bg_color_arr[$position]) ? $bt_bg_color_arr[$position] : '';
            $bt_bg_img           = isset($bt_bg_img_arr[$position]) ? $bt_bg_img_arr[$position] : '';
            $bt_bg_repeat        = isset($bt_bg_repeat_arr[$position]) ? $bt_bg_repeat_arr[$position] : '';
            $bt_radius           = isset($bt_radius_arr[$position]) ? $bt_radius_arr[$position] : '';
            $block_style         = isset($block_style_arr[$position]) ? $block_style_arr[$position] : '';
            $block_title_style   = isset($block_title_style_arr[$position]) ? $block_title_style_arr[$position] : '';
            $block_content_style = isset($block_content_style_arr[$position]) ? $block_content_style_arr[$position] : '';

            $bt_text_padding = (int) $bt_text_padding;
            $bt_bg_repeat    = (int) $bt_bg_repeat;
            $bt_radius       = (int) $bt_radius;

            $sql = 'REPLACE INTO `' . $xoopsDB->prefix('tad_themes_blocks') . '` (`theme_id`, `block_position`, `block_config`, `bt_text`, `bt_text_padding`, `bt_text_size`, `bt_bg_color`, `bt_bg_img`, `bt_bg_repeat`, `bt_radius`, `block_style`, `block_title_style`, `block_content_style`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            Utility::query($sql, 'issssssssssss', [$theme_id, $position, $block_config, $bt_text, $bt_text_padding, $bt_text_size, $bt_bg_color, $bt_bg_img, $bt_bg_repeat, $bt_radius, $block_style, $block_title_style, $block_content_style]) or Utility::web_error($sql, __FILE__, __LINE__);

            $TadUpFilesBt_bg = self::getTadUpFilesObj("bt_bg", $theme_name);
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

    //取得圖片選項
    public static function import_img($path = '', $col_name = 'logo', $col_sn = '', $desc = '', $safe_name = false)
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
        $sql = 'SELECT `files_sn`, `original_filename`
        FROM `' . $xoopsDB->prefix('tad_themes_files_center') . "`
        WHERE `col_name` = '$col_name' AND `col_sn` = '$col_sn'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $db_files_amount = 0;
        while (list($files_sn, $original_filename) = $xoopsDB->fetchRow($result)) {
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
                            self::import_file($path . '/' . $file, $col_name, $col_sn);
                        }
                    }
                }
                closedir($dh);
            }
        } elseif (is_file($path)) {
            // 若是檔案，若檔案不在資料庫中，就直接匯入該檔案
            if (!in_array($path, $db_files)) {
                self::import_file($path, $col_name, $col_sn);
            }
        }
    }

    //匯入圖檔
    public static function import_file($file_name = '', $col_name = '', $col_sn = '', $main_width = '', $thumb_width = '240', $only_import2db = true)
    {
        if ('bt_bg' === substr($col_name, 0, 5)) {
            $col_name = 'bt_bg';
        }
        $TadUpFiles = self::getTadUpFilesObj($col_name);
        if (is_object($TadUpFiles)) {
            $TadUpFiles->set_col($col_name, $col_sn);
            $TadUpFiles->import_one_file($file_name, null, $main_width, $thumb_width, '', false, false, false, false, $only_import2db);
        } else {
            die("Need TadUpFiles Object for {$col_name}!");
        }
    }

    //更新 tadtools 初始設定
    public static function update_tadtools_setup($theme = '', $theme_kind = '')
    {
        global $xoopsDB;
        if (empty($theme_kind)) {
            $theme_kind = 'bootstrap5';
        }
        $bootstrap_color = $theme_kind;

        $sql = 'SELECT `tt_theme_kind`
        FROM `' . $xoopsDB->prefix('tadtools_setup') . '`
        WHERE `tt_theme` = ?';
        $result = Utility::query($sql, 's', [$theme]) or Utility::web_error($sql, __FILE__, __LINE__);

        list($old_tt_theme_kind) = $xoopsDB->fetchRow($result);

        if ($theme_kind !== $old_tt_theme_kind) {
            $sql = 'REPLACE INTO `' . $xoopsDB->prefix('tadtools_setup') . '`
        (`tt_theme`, `tt_use_bootstrap`, `tt_bootstrap_color`, `tt_theme_kind`)
        VALUES (?, ?, ?, ?)';
            Utility::query($sql, 'ssss', [$theme, '0', $bootstrap_color, $theme_kind]) or Utility::web_error($sql, __FILE__, __LINE__);

        }
    }

    //儲存額外設定值($mode = default 或 apply 或 school_apply 或 post)，自動匯入、新增佈景、儲存佈景時會用到。$config2_files 是佈景額外設定的所有頁籤項目
    public static function save_config2($theme_id = '', $config2_files = [], $mode = '')
    {
        global $xoopsDB, $xoopsConfig;

        $theme_name = $xoopsConfig['theme_set'];

        if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/language/{$xoopsConfig['language']}/main.php")) {
            require XOOPS_ROOT_PATH . "/themes/{$theme_name}/language/{$xoopsConfig['language']}/main.php";
        }
        $TadUpFiles_config2 = self::getTadUpFilesObj('config2');

        //額外佈景設定

        foreach ($config2_files as $config2_file) {
            $theme_config = [];
            if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php")) {
                require XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php";
            }

            // 按下套用的話
            if ($mode == 'apply' || $mode == 'school_apply') {
                if (file_exists(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/{$config2_file}.php")) {
                    require XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/{$config2_file}.php";
                }
            }

            if (empty($theme_config)) {
                continue;
            }

            // $theme_config 就是每個額外設定下的完整設定項目陣列
            foreach ($theme_config as $k => $config) {
                // $config 就是一組額外設定
                // $name 就是一組額外設定的名稱
                $name = $config['name'];

                if (in_array($config['name'], ['slide_mask', 'slide_def_mask'])) {
                    continue;
                }

                $config_value = $mode == "post" ? $_POST[$name] : $config['default'];
                $value        = is_array($config_value) ? json_encode($config_value, 256) : $config_value;

                if ('file' === $config['type']) {
                    $value = basename($value);
                }

                $sql = 'REPLACE INTO `' . $xoopsDB->prefix('tad_themes_config2') . '`
            (`theme_id`, `name`, `type`, `value`)
            VALUES (?, ?, ?, ?)';
                Utility::query($sql, 'isss', [$theme_id, $config['name'], $config['type'], (string) $value]) or Utility::web_error($sql, __FILE__, __LINE__);

                // 若是上傳的欄位，需將圖片也上傳或匯入
                if ('file' === $config['type'] or 'bg_file' === $config['type']) {
                    // 上傳
                    $TadUpFiles_config2->set_col("config2_{$config['name']}", $theme_id);
                    $filename = $TadUpFiles_config2->upload_file("config2_{$config['name']}", null, null, null, '', true, false, 'file_name', 'png;jpg;gif;svg;webp');
                    if ($filename) {
                        self::update_theme_config2($config['name'], $filename, $theme_id);
                    }
                }

                if ('bg_file' === $config['type']) {
                    $value_repeat   = isset($_POST[$name . '_repeat']) ? $_POST[$name . '_repeat'] : $config['repeat'];
                    $value_position = isset($_POST[$name . '_position']) ? $_POST[$name . '_position'] : $config['position'];
                    $value_size     = isset($_POST[$name . '_size']) ? $_POST[$name . '_size'] : $config['size'];

                    $sql = 'REPLACE INTO `' . $xoopsDB->prefix('tad_themes_config2') . '`
                (`theme_id`, `name`, `type`, `value`)
                VALUES (?, ?, ?, ?), (?, ?, ?, ?), (?, ?, ?, ?)';
                    $result = Utility::query($sql, 'isssisssisss',
                        [$theme_id, $config['name'] . '_repeat', 'select', $value_repeat,
                            $theme_id, $config['name'] . '_position', 'select', $value_position,
                            $theme_id, $config['name'] . '_size', 'select', $value_size])
                    or Utility::web_error($sql, __FILE__, __LINE__);

                } elseif ('custom_zone' === $config['type']) {
                    $block_value = '';
                    if (!empty($_POST[$config['name'] . '_bid'])) {
                        $bid = (int) $_POST[$config['name'] . '_bid'];
                        $sql = "SELECT `bid`, `name`, `title`, `show_func`, `c_type`, `content`
                    FROM `" . $xoopsDB->prefix('newblocks') . "`
                    WHERE `bid` = ?";
                        $result = Utility::query($sql, 'i', [$bid]) or Utility::web_error($sql, __FILE__, __LINE__);

                        $block       = $xoopsDB->fetchArray($result);
                        $block_value = json_encode($block, 256);
                    }

                    $value_html_content = isset($_POST[$name . '_html_content']) ? $_POST[$name . '_html_content'] : $config['html_content'];
                    $value_fa_content   = isset($_POST[$name . '_fa_content']) ? $_POST[$name . '_fa_content'] : $config['fa_content'];
                    $value_menu_content = isset($_POST[$name . '_menu_content']) ? $_POST[$name . '_menu_content'] : $config['menu_content'];
                    // 將 config2_xxx 中，有啥寫啥
                    $sql = 'REPLACE INTO `' . $xoopsDB->prefix('tad_themes_config2') . '`
                (`theme_id`, `name`, `type`, `value`)
                VALUES (?, ?, ?, ?), (?, ?, ?, ?), (?, ?, ?, ?), (?, ?, ?, ?)';
                    Utility::query($sql, 'isssisssisssisss',
                        [$theme_id, $config['name'] . '_block', 'text', $block_value,
                            $theme_id, $config['name'] . '_html_content', 'text', $value_html_content,
                            $theme_id, $config['name'] . '_fa_content', 'text', $value_fa_content,
                            $theme_id, $config['name'] . '_menu_content', 'text', $value_menu_content])
                    or Utility::web_error($sql, __FILE__, __LINE__);
                } elseif ('padding_margin' === $config['type']) {
                    $value_mt = isset($_POST[$name . '_mt']) ? $_POST[$name . '_mt'] : $config['mt'];
                    $value_mb = isset($_POST[$name . '_mb']) ? $_POST[$name . '_mb'] : $config['mb'];

                    $sql = 'REPLACE INTO `' . $xoopsDB->prefix('tad_themes_config2') . '`
                (`theme_id`, `name`, `type`, `value`)
                VALUES (?, ?, ?, ?), (?, ?, ?, ?)';
                    Utility::query($sql, 'isssisss',
                        [$theme_id, $config['name'] . '_mt', 'text', $value_mt,
                            $theme_id, $config['name'] . '_mb', 'text', $value_mb])
                    or Utility::web_error($sql, __FILE__, __LINE__);
                }
            }
        }
    }

    //更新佈景的某個設定值
    public static function update_theme_config2($name = '', $value = '', $theme_id = '')
    {
        global $xoopsDB;
        $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes_config2') . '` SET `value` =? WHERE `theme_id` =? AND `name` =?';
        Utility::query($sql, 'sis', [$value, $theme_id, $name]) or Utility::web_error($sql, __FILE__, __LINE__);

    }
}
