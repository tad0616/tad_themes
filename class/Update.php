<?php

namespace XoopsModules\Tad_themes;

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
class Update
{

    //修正上傳檔案的路徑，從絕對路徑改為相對路徑
    public static function fix_config2_file_url()
    {
        global $xoopsDB;
        $sql = 'SELECT `theme_id`, `bg_img`, `logo_img`, `navlogo_img`, `navbar_img` FROM ' . $xoopsDB->prefix('tad_themes') . " where left(`bg_img`, 4)='http' or left(`logo_img`, 4)='http' or left(`navlogo_img`, 4)='http' or left(`navbar_img`, 4)='http'";
        $result = $xoopsDB->query($sql);
        while (list($theme_id, $bg_img, $logo_img, $navlogo_img, $navbar_img) = $xoopsDB->fetchRow($result)) {
            $bg_img = basename($bg_img);
            $logo_img = basename($logo_img);
            $navlogo_img = basename($navlogo_img);
            $navbar_img = basename($navbar_img);
            $sql = 'update ' . $xoopsDB->prefix('tad_themes') . " set `bg_img`='{$bg_img}',`logo_img`='{$logo_img}',`navlogo_img`='{$navlogo_img}',`navbar_img`='{$navbar_img}' where `theme_id`='$theme_id'";
            $xoopsDB->queryF($sql);
        }

        $sql = 'SELECT `theme_id`, `bt_bg_img`, `block_position` FROM ' . $xoopsDB->prefix('tad_themes_blocks') . " where left(`bt_bg_img`, 4)='http'";
        $result = $xoopsDB->query($sql);
        while (list($theme_id, $bt_bg_img, $block_position) = $xoopsDB->fetchRow($result)) {
            $bt_bg_img = basename($bt_bg_img);
            $sql = 'update ' . $xoopsDB->prefix('tad_themes_blocks') . " set `bt_bg_img`='{$bt_bg_img}' where `theme_id`='$theme_id' and `block_position`='$block_position'";
            $xoopsDB->queryF($sql);
        }

        $sql = 'SELECT `theme_id`,`name`,`value` FROM ' . $xoopsDB->prefix('tad_themes_config2') . " where `type`='file' and left(`value`, 4)='http'";
        $result = $xoopsDB->query($sql);
        while (list($theme_id, $name, $value) = $xoopsDB->fetchRow($result)) {
            $filename = basename($value);
            $sql = 'update ' . $xoopsDB->prefix('tad_themes_config2') . " set `value`='$filename' where `type`='file' and `theme_id`='$theme_id' and `name`='$name'";
            $xoopsDB->queryF($sql);
        }
    }

    //新增檔案欄位
    public static function chk_fc_tag()
    {
        global $xoopsDB;
        $sql = 'SELECT count(`tag`) FROM ' . $xoopsDB->prefix('tad_themes_files_center');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return true;
        }

        return false;
    }

    public static function go_fc_tag()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes_files_center') . "
        ADD `upload_date` DATETIME NOT NULL COMMENT '上傳時間',
        ADD `uid` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上傳者',
        ADD `tag` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '註記'
        ";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());
    }

    //新增佈景類型欄位
    public static function chk_chk1()
    {
        global $xoopsDB;
        $sql = 'select count(`theme_kind`) from ' . $xoopsDB->prefix('tad_themes');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update1()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes') . " ADD `theme_kind` varchar(255) NOT NULL default 'html'";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());
    }

    //新增tad_themes_menu資料表
    public static function chk_chk2()
    {
        global $xoopsDB;
        $sql = 'select count(*) from ' . $xoopsDB->prefix('tad_themes_menu');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update2()
    {
        global $xoopsDB;
        $sql = 'CREATE TABLE `' . $xoopsDB->prefix('tad_themes_menu') . "` (
    `menuid` smallint(5) unsigned NOT NULL auto_increment,
    `of_level` smallint(5) unsigned NOT NULL default 0,
    `position` smallint(5) unsigned NOT NULL default 0,
    `itemname` varchar(255) NOT NULL default '',
    `itemurl` varchar(255) NOT NULL default '',
    `status` enum('1','0') NOT NULL,
    PRIMARY KEY  (`menuid`),
    KEY `of_level` (`of_level`)
    )  ENGINE=MyISAM;";
        $xoopsDB->queryF($sql);
    }

    //新增區塊欄位
    public static function chk_chk3()
    {
        global $xoopsDB;
        $sql = 'select count(`block_config`) from ' . $xoopsDB->prefix('tad_themes');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update3()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes') . "
    ADD `block_config` enum('right','left') NOT NULL DEFAULT 'right',
    ADD `bt_text` varchar(255) NOT NULL DEFAULT '',
    ADD `bt_text_padding` tinyint(4) NOT NULL DEFAULT '33',
    ADD `bt_bg_color` varchar(255) NOT NULL DEFAULT '',
    ADD `bt_bg_img` varchar(255) NOT NULL DEFAULT '',
    ADD `bt_bg_repeat` enum('0','1') NOT NULL DEFAULT '0',
    ADD `bt_radius` enum('0','1') NOT NULL DEFAULT '1'";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());
    }

    //新增導覽工具列欄位
    public static function chk_chk4()
    {
        global $xoopsDB;
        $sql = 'select count(`navbar_pos`) from ' . $xoopsDB->prefix('tad_themes');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update4()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes') . "
        ADD `navbar_pos` varchar(255) NOT NULL DEFAULT 'default',
        ADD `navbar_bg_top` varchar(255) NOT NULL DEFAULT '#54b4eb',
        ADD `navbar_bg_bottom` varchar(255) NOT NULL DEFAULT '#2fa4e7',
        ADD `navbar_hover` varchar(255) NOT NULL DEFAULT '#1684c2'";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());
    }

    //新增選單欄位
    public static function chk_chk5()
    {
        global $xoopsDB;
        $sql = 'select count(`target`) from ' . $xoopsDB->prefix('tad_themes_menu');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update5()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes_menu') . "
        ADD `target` varchar(255) NOT NULL default '',
        ADD `icon` varchar(255) NOT NULL default 'icon-th-list'";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());
    }

    //新增original_filename欄位
    public static function chk_chk6()
    {
        global $xoopsDB;
        $sql = 'select count(`original_filename`) from ' . $xoopsDB->prefix('tad_themes_files_center');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update6()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes_files_center') . "
  ADD `original_filename` varchar(255) NOT NULL default ''";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());

        $sql = 'update ' . $xoopsDB->prefix('tad_themes_files_center') . ' set
        `original_filename`=`description`';
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());
    }

    //新增hash_filename欄位
    public static function chk_chk7()
    {
        global $xoopsDB;
        $sql = 'select count(`hash_filename`) from ' . $xoopsDB->prefix('tad_themes_files_center');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update7()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes_files_center') . "
        ADD `hash_filename` varchar(255) NOT NULL default '',
        ADD `sub_dir` varchar(255) NOT NULL default ''";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());
    }

    //新增hash_filename欄位
    public static function chk_chk8()
    {
        global $xoopsDB;
        $sql = 'select count(`navbar_color`) from ' . $xoopsDB->prefix('tad_themes');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update8()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes') . "
        ADD `navbar_color` varchar(255) NOT NULL default '#FFFFFF',
        ADD `navbar_color_hover` varchar(255) NOT NULL default 'yellow',
        ADD `navbar_icon` varchar(255) NOT NULL default ''
        ";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());
    }

    //新增 theme_width 欄位
    public static function chk_chk9()
    {
        global $xoopsDB;
        $sql = 'select count(`theme_width`) from ' . $xoopsDB->prefix('tad_themes');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update9()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes') . "
        ADD `theme_width` varchar(255) NOT NULL default '980' after `theme_type`;
        ";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());

        $sql = 'update ' . $xoopsDB->prefix('tad_themes') . " set `theme_width`=12 where theme_kind='bootstrap'";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());
    }

    //新增導覽列logo圖欄位
    public static function chk_chk10()
    {
        global $xoopsDB;
        $sql = 'select count(`navlogo_img`) from ' . $xoopsDB->prefix('tad_themes');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update10()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes') . " ADD `navlogo_img` varchar(255) NOT NULL default '' after logo_img";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());
    }

    //新增logo圖位置欄位
    public static function chk_chk11()
    {
        global $xoopsDB;
        $sql = 'select count(`logo_position`) from ' . $xoopsDB->prefix('tad_themes');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update11()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes') . " ADD `logo_position` varchar(255) NOT NULL default 'slide' after logo_img";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());
    }

    //新增tad_themes_config2資料表
    public static function chk_chk12()
    {
        global $xoopsDB;
        $sql = 'select count(*) from ' . $xoopsDB->prefix('tad_themes_config2');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update12()
    {
        global $xoopsDB;
        $sql = 'CREATE TABLE `' . $xoopsDB->prefix('tad_themes_config2') . "` (
            `theme_id` smallint(5) unsigned NOT NULL default 0,
            `name` varchar(100) NOT NULL default '',
            `type` varchar(255) NOT NULL default '',
            `value` text NOT NULL,
            PRIMARY KEY  (`theme_id`,`name`)
        )  ENGINE=MyISAM;";
        $xoopsDB->queryF($sql);
    }

    //新增 tad_themes_blocks 資料表
    public static function chk_chk13()
    {
        global $xoopsDB;
        $sql = 'select count(*) from ' . $xoopsDB->prefix('tad_themes_blocks');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update13()
    {
        global $xoopsDB;

        $block_position = ['leftBlock', 'rightBlock', 'centerBlock', 'centerLeftBlock', 'centerRightBlock', 'centerBottomBlock', 'centerBottomLeftBlock', 'centerBottomRightBlock', 'footerLeftBlock', 'footerCenterBlock', 'footerRightBlock'];

        $sql = 'CREATE TABLE `' . $xoopsDB->prefix('tad_themes_blocks') . "` (
            `theme_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '佈景編號',
            `block_position` varchar(30) NOT NULL default '' COMMENT '區塊位置',
            `block_config` enum('right','left') NOT NULL DEFAULT 'right' COMMENT '工具按鈕靠左/右',
            `bt_text` varchar(16) NOT NULL COMMENT '區塊標題字體顏色',
            `bt_text_padding` tinyint(4) NOT NULL DEFAULT '33' COMMENT '區塊標題文字縮排',
            `bt_text_size` varchar(16) NOT NULL COMMENT '區塊標題字體大小',
            `bt_bg_color` varchar(16) NOT NULL COMMENT '區塊標題背景顏色',
            `bt_bg_img` varchar(255) NOT NULL COMMENT '區塊標題背景圖',
            `bt_bg_repeat` enum('0','1') NOT NULL DEFAULT '0' COMMENT '以圖填滿區塊標題列',
            `bt_radius` enum('0','1') NOT NULL DEFAULT '1' COMMENT '區塊標題圓角',
            PRIMARY KEY (`theme_id`,`block_position`)
        ) ENGINE=MyISAM ;";
        $xoopsDB->queryF($sql);

        $sql = 'select `theme_id`,`block_config`,`bt_text`, `bt_text_padding`, `bt_bg_color`, `bt_bg_img`, `bt_bg_repeat`, `bt_radius` from `' . $xoopsDB->prefix('tad_themes') . '` order by `theme_id`';
        $result = $xoopsDB->queryF($sql);
        while (list($theme_id, $block_config, $bt_text, $bt_text_padding, $bt_bg_color, $bt_bg_img, $bt_bg_repeat, $bt_radius) = $xoopsDB->fetchRow($result)) {
            foreach ($block_position as $position) {
                $sql = 'insert into `' . $xoopsDB->prefix('tad_themes_blocks') . "` (`theme_id` , `block_position` , `block_config` , `bt_text` , `bt_text_padding`, `bt_text_size` , `bt_bg_color` , `bt_bg_img` , `bt_bg_repeat` , `bt_radius`) values('$theme_id' , '{$position}' , '$block_config' , '$bt_text' , '$bt_text_padding', '16px' , '$bt_bg_color' , '$bt_bg_img' , '$bt_bg_repeat' , '$bt_radius')";
                $xoopsDB->queryF($sql);
            }
        }

        $sql = 'ALTER TABLE `' . $xoopsDB->prefix('tad_themes') . '` DROP `block_config`, DROP `bt_text`, DROP `bt_text_padding`, DROP `bt_bg_color`, DROP `bt_bg_img`, DROP `bt_bg_repeat`, DROP `bt_radius`;';
        $xoopsDB->queryF($sql);

        $sql = 'select `col_name`, `col_sn`, `sort`, `kind`, `file_name`, `file_type`, `file_size`, `description`, `counter`, `original_filename`, `hash_filename`, `sub_dir` from `' . $xoopsDB->prefix('tad_themes_files_center') . "` where `col_name`='bt_bg'";
        $result = $xoopsDB->queryF($sql);

        while (list($col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description, $counter, $original_filename, $hash_filename, $sub_dir) = $xoopsDB->fetchRow($result)) {
            foreach ($block_position as $position) {
                $sql = 'insert into `' . $xoopsDB->prefix('tad_themes_files_center') . "` (`col_name`, `col_sn`, `sort`, `kind`, `file_name`, `file_type`, `file_size`, `description`, `counter`, `original_filename`, `hash_filename`, `sub_dir`) values('{$col_name}_{$position}' , '{$col_sn}' , '$sort' , '$kind' , '$file_name', '$file_type' , '$file_size' , '$description' , '$counter' , '$original_filename' , '$hash_filename'  , '$sub_dir' )";
                $xoopsDB->queryF($sql);
            }
        }
        $sql = 'delete `' . $xoopsDB->prefix('tad_themes_files_center') . "` where `col_name`='bt_bg'";
        $xoopsDB->queryF($sql);

        $sql = 'ALTER TABLE `' . $xoopsDB->prefix('tad_themes') . "` CHANGE `navbar_pos` `navbar_pos` varchar(255) NOT NULL default 'default'";
        $xoopsDB->queryF($sql);

        $sql = 'update `' . $xoopsDB->prefix('tad_themes') . "` set `navbar_pos`='default' where `navbar_pos`='not-use'";
        $xoopsDB->queryF($sql);
    }

    //新增 theme_width 欄位
    public static function chk_chk14()
    {
        global $xoopsDB;
        $sql = 'select count(`base_color`) from ' . $xoopsDB->prefix('tad_themes');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update14()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes') . "
  ADD `base_color` varchar(255) NOT NULL default 'transparent' COMMENT '頁面內容背景色'  after `crb_width`;
  ";
        $xoopsDB->queryF($sql);
    }

    //新增 navbar_img 欄位
    public static function chk_chk15()
    {
        global $xoopsDB;
        $sql = 'select count(`navbar_img`) from ' . $xoopsDB->prefix('tad_themes');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update15()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes') . "
  ADD `navbar_img` varchar(255) NOT NULL default 'transparent' COMMENT 'navbar背景圖'  after `navbar_icon`;
  ";
        $xoopsDB->queryF($sql);
    }

    //新增區塊內容設定欄位
    public static function chk_chk16()
    {
        global $xoopsDB;
        $sql = 'select count(`block_style`) from ' . $xoopsDB->prefix('tad_themes_blocks');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update16()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes_blocks') . "
    ADD `block_style` text NOT NULL COMMENT '',
    ADD `block_title_style` text NOT NULL COMMENT '',
    ADD `block_content_style` text NOT NULL COMMENT '';
    ";
        $xoopsDB->queryF($sql);

        $sql = 'update ' . $xoopsDB->prefix('tad_themes_blocks') . " set block_title_style='border:none;height:40px;line-height:40px;margin-bottom:10px;'";
        $xoopsDB->queryF($sql);
    }

    //新增唯一索引
    public static function chk_chk17()
    {
        global $xoopsDB;
        $sql = 'show keys from ' . $xoopsDB->prefix('tad_themes') . " where Key_name='theme_name'";
        $result = $xoopsDB->query($sql);
        $data = $xoopsDB->fetchArray($result);
        if (empty($data)) {
            return true;
        }

        return false;
    }

    public static function go_update17()
    {
        global $xoopsDB;

        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes') . ' ADD UNIQUE `theme_name` (`theme_name`)';
        $xoopsDB->queryF($sql);
    }

    public static function chk_chk18()
    {
        global $xoopsDB;
        $sql = 'select count(*) from ' . $xoopsDB->prefix('tad_themes') . " where `theme_kind`='bootstrap'";
        $result = $xoopsDB->queryF($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update18()
    {
        global $xoopsDB;
        $sql = 'update ' . $xoopsDB->prefix('tad_themes') . " set `theme_kind`='bootstrap3' where `theme_kind`='bootstrap'";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());

        return true;
    }

    //修正col_sn欄位
    public static function chk_files_center()
    {
        global $xoopsDB;
        $sql = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
  WHERE table_name = '" . $xoopsDB->prefix('tad_themes_files_center') . "' AND COLUMN_NAME = 'col_sn'";
        $result = $xoopsDB->query($sql);
        list($type) = $xoopsDB->fetchRow($result);
        if ('smallint' === $type) {
            return true;
        }

        return false;
    }

    //新增 logo_center 欄位
    public static function chk_chk19()
    {
        global $xoopsDB;
        $sql = 'select count(`logo_center`) from ' . $xoopsDB->prefix('tad_themes');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return true;
        }

        return false;
    }

    public static function go_update19()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes') . " ADD `logo_center` enum('0','1') NOT NULL default '0' after `logo_left`";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());
    }

    //新增 link_cate_name 欄位
    public static function chk_chk20()
    {
        global $xoopsDB;
        $sql = 'select count(`link_cate_name`) from ' . $xoopsDB->prefix('tad_themes_menu');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return true;
        }

        return false;
    }

    public static function go_update20()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes_menu') . " ADD `link_cate_name` varchar(255) NOT NULL default '', ADD
  `link_cate_sn` smallint(5) unsigned NOT NULL default 0";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());
    }

    //新增 read_group 欄位
    public static function chk_chk22()
    {
        global $xoopsDB;
        $sql = 'select count(`read_group`) from ' . $xoopsDB->prefix('tad_themes_menu');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return true;
        }

        return false;
    }

    public static function go_update22()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes_menu') . " ADD `read_group` varchar(255) NOT NULL default '1,2,3'";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());
    }

    //嚴格模式修正
    public static function chk_chk23()
    {
        global $xoopsDB;

        $sql = "SELECT COLUMN_DEFAULT FROM INFORMATION_SCHEMA.COLUMNS  WHERE table_name = '" . $xoopsDB->prefix('tad_themes_files_center') . "' AND COLUMN_NAME = 'col_id'";

        $result = $xoopsDB->query($sql);
        list($COLUMN_DEFAULT) = $xoopsDB->fetchRow($result);
        if (null === $COLUMN_DEFAULT or 'NULL' === $COLUMN_DEFAULT) {
            return true;
        }

        return false;
    }

    public static function go_update23()
    {
        global $xoopsDB;

        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes_data_center') . " CHANGE `col_id` `col_id` varchar(100) NOT NULL DEFAULT '' COMMENT '辨識字串' AFTER `data_sort`";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());
    }

    //新增 cb_width 欄位
    public static function chk_chk24()
    {
        global $xoopsDB;
        $sql = 'select count(`cb_width`) from ' . $xoopsDB->prefix('tad_themes');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return true;
        }

        return false;
    }

    public static function go_update24()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes') . " ADD `cb_width` varchar(255) NOT NULL default '' AFTER `lb_width`";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());

        $sql = 'update ' . $xoopsDB->prefix('tad_themes') . " set `cb_width` = (`theme_width` - `lb_width` - `rb_width`) where theme_kind!='mix'";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());

        $sql = 'update ' . $xoopsDB->prefix('tad_themes') . " set `cb_width` = (12 - `lb_width` - `rb_width`) where theme_kind='mix'";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());
    }

    //新移除 membersonly、mainmenu 等無用欄位
    public static function chk_chk25()
    {
        global $xoopsDB;
        $sql = 'select count(membersonly) from ' . $xoopsDB->prefix('tad_themes_menu');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    //移除 membersonly、mainmenu 等無用欄位
    public static function go_update25()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE `' . $xoopsDB->prefix('tad_themes_menu') . '` DROP `membersonly`, DROP `mainmenu`;';
        $xoopsDB->queryF($sql);
    }

    //執行更新
    public static function go_update_files_center()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE `' . $xoopsDB->prefix('tad_themes_files_center') . '` CHANGE `col_sn` `col_sn` mediumint(9) unsigned NOT NULL default 0';
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 3, $xoopsDB->error());

        return true;
    }

    //刪除錯誤的重複欄位及樣板檔
    public static function chk_tad_themes_block()
    {
        global $xoopsDB;
        //die(var_export($xoopsConfig));
        require XOOPS_ROOT_PATH . '/modules/tad_themes/xoops_version.php';

        //先找出該有的區塊以及對應樣板
        foreach ($modversion['blocks'] as $i => $block) {
            $show_func = $block['show_func'];
            $tpl_file_arr[$show_func] = $block['template'];
            $tpl_desc_arr[$show_func] = $block['description'];
        }

        //找出目前所有的樣板檔
        $sql = "SELECT `bid`,`name`,`visible`,`show_func`,`template` FROM `" . $xoopsDB->prefix('newblocks') . "`  WHERE `dirname` = 'tad_themes' ORDER BY `func_num`";
        $result = $xoopsDB->query($sql);
        while (list($bid, $name, $visible, $show_func, $template) = $xoopsDB->fetchRow($result)) {
            //假如現有的區塊和樣板對不上就刪掉
            if ($template != $tpl_file_arr[$show_func]) {
                $sql = 'delete from ' . $xoopsDB->prefix('newblocks') . " where bid='{$bid}'";
                $xoopsDB->queryF($sql);

                //連同樣板以及樣板實體檔案也要刪掉
                $sql = "delete from " . $xoopsDB->prefix('tplfile') . " as a
                left join " . $xoopsDB->prefix('tplsource') . "  as b on a.tpl_id=b.tpl_id
                where a.tpl_refid='$bid' and a.tpl_module='tad_themes' and a.tpl_type='block'";
                $xoopsDB->queryF($sql);
            } else {
                $sql = 'update ' . $xoopsDB->prefix('tplfile') . "
                set tpl_file='{$template}' , tpl_desc='{$tpl_desc_arr[$show_func]}'
                where tpl_refid='{$bid}'";
                $xoopsDB->queryF($sql);
            }
        }
    }

    //新增 tad_themes_data_center 資料表
    public static function chk_chk21()
    {
        global $xoopsDB;
        $sql = 'select count(*) from ' . $xoopsDB->prefix('tad_themes_data_center');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return false;
        }

        return true;
    }

    public static function go_update21()
    {
        global $xoopsDB;
        $sql = "CREATE TABLE `" . $xoopsDB->prefix('tad_themes_data_center') . "` (
        `mid` mediumint(9) unsigned NOT NULL  COMMENT '模組編號',
        `col_name` varchar(100) NOT NULL default '' COMMENT '欄位名稱',
        `col_sn` mediumint(9) unsigned NOT NULL COMMENT '欄位編號',
        `data_name` varchar(100) NOT NULL default '' COMMENT '資料名稱',
        `data_value` text NOT NULL COMMENT '儲存值',
        `data_sort` mediumint(9) unsigned NOT NULL  COMMENT '排序',
        PRIMARY KEY  (`mid`,`col_name`,`col_sn`,`data_name`,`data_sort`)
        )  ENGINE=MyISAM";
        $xoopsDB->queryF($sql);
    }

    //加入id以及時間欄位
    public static function chk_data_center()
    {
        global $xoopsDB;
        $sql = 'select count(`col_id`) from ' . $xoopsDB->prefix('tad_themes_data_center');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return true;
        }

        return false;
    }

    //執行更新
    public static function go_update_data_center()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes_data_center') . "
            ADD `col_id` varchar(100) NOT NULL DEFAULT '' COMMENT '辨識字串',
            ADD `update_time` datetime NOT NULL COMMENT '更新時間'";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 3, $xoopsDB->error() . ':' . __FILE__ . ':' . __LINE__);

        return true;
    }

    //移除區塊的流水號
    public static function chk_chk26()
    {
        global $xoopsDB;

        $sql = "SELECT EXTRA FROM INFORMATION_SCHEMA.COLUMNS  WHERE table_name = '" . $xoopsDB->prefix('tad_themes_blocks') . "' AND COLUMN_NAME = 'theme_id'";

        $result = $xoopsDB->query($sql);
        list($EXTRA) = $xoopsDB->fetchRow($result);
        if ('auto_increment' === $EXTRA) {
            return true;
        }

        return false;
    }

    public static function go_update26()
    {
        global $xoopsDB;

        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes_blocks') . " CHANGE  `theme_id` `theme_id` smallint(6) unsigned NOT NULL COMMENT '佈景編號' FIRST;
        ";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 30, $xoopsDB->error());
    }

    //加入id以及時間欄位
    public static function chk_chk27()
    {
        global $xoopsDB;
        $sql = 'select count(`bg_size`) from ' . $xoopsDB->prefix('tad_themes');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return true;
        }

        return false;
    }

    //執行更新
    public static function go_update27()
    {
        global $xoopsDB;
        $sql = "ALTER TABLE " . $xoopsDB->prefix('tad_themes') . " ADD `bg_size` varchar(255) DEFAULT '' COMMENT '背景縮放'";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/tad_themes/admin/index.php', 3, $xoopsDB->error() . ':' . __FILE__ . ':' . __LINE__);

        $sql = "select theme_id,bg_repeat from " . $xoopsDB->prefix('tad_themes') . " ";
        $result = $xoopsDB->queryF($sql);
        while (list($theme_id, $bg_repeat) = $xoopsDB->fetchRow($result)) {
            if (strpos($bg_repeat, 'cover') !== false) {
                $sql = "update " . $xoopsDB->prefix('tad_themes') . " set bg_repeat='no-repeat', bg_size='cover' where theme_id='$theme_id'";
                $xoopsDB->queryF($sql);
            } elseif (strpos($bg_repeat, 'contain') !== false) {
                $sql = "update " . $xoopsDB->prefix('tad_themes') . " set bg_repeat='no-repeat', bg_size='contain' where theme_id='$theme_id'";
                $xoopsDB->queryF($sql);
            } else {
                $sql = "update " . $xoopsDB->prefix('tad_themes') . " set bg_size='auto' where theme_id='$theme_id'";
                $xoopsDB->queryF($sql);
            }

        }

        $sql = "select `theme_id`, `name`, `value` from " . $xoopsDB->prefix('tad_themes_config2') . " where `name`='logo_bg_repeat' or `name`='logo_bg2_repeat'";
        $result = $xoopsDB->queryF($sql);
        while (list($theme_id, $name, $value) = $xoopsDB->fetchRow($result)) {
            $size_name = str_replace('repeat', 'size', $name);
            if (strpos($value, 'cover') !== false) {
                $sql = "update " . $xoopsDB->prefix('tad_themes_config2') . " set `value`='no-repeat' where theme_id='$theme_id' and `name`='{$name}'";
                $xoopsDB->queryF($sql);
                $sql = "replace into " . $xoopsDB->prefix('tad_themes_config2') . " (`theme_id`, `name`, `type`, `value`) values('$theme_id', '{$size_name}', 'text', 'cover')";
                $xoopsDB->queryF($sql);
            } elseif (strpos($value, 'contain') !== false) {
                $sql = "update " . $xoopsDB->prefix('tad_themes_config2') . " set `value`='no-repeat' where theme_id='$theme_id' and `name`='{$name}'";
                $xoopsDB->queryF($sql);
                $sql = "replace into " . $xoopsDB->prefix('tad_themes_config2') . " (`theme_id`, `name`, `type`, `value`) values('$theme_id', '{$size_name}', 'text', 'contain')";
                $xoopsDB->queryF($sql);
            } else {
                $sql = "replace into " . $xoopsDB->prefix('tad_themes_config2') . " (`theme_id`, `name`, `type`, `value`) values('$theme_id', '{$size_name}', 'text', 'auto')";
                $xoopsDB->queryF($sql);
            }

        }

        return true;
    }

    //加入id以及時間欄位
    public static function chk_chk28()
    {
        global $xoopsDB;
        $sql = 'select count(*) from ' . $xoopsDB->prefix('tad_themes_config2') . " where `name` LIKE '%logo_bg%' AND `type` = 'file'";
        $result = $xoopsDB->query($sql);
        list($count) = $xoopsDB->fetchRow($result);
        if (!empty($count)) {
            return true;
        }

        return false;
    }

    //執行更新
    public static function go_update28()
    {
        global $xoopsDB;

        $sql = "select theme_id from " . $xoopsDB->prefix('tad_themes') . " where theme_name='school2019'";
        $result = $xoopsDB->queryF($sql);
        list($theme_id) = $xoopsDB->fetchRow($result);

        $sql = "update " . $xoopsDB->prefix('tad_themes_config2') . " set `type`='bg_file' where (`name`='logo_bg' or `name`='logo_bg2' or `name`='footer_img') and `type` = 'file' and `theme_id`='{$theme_id}'";
        $xoopsDB->queryF($sql);
    }
}
