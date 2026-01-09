<?php

namespace XoopsModules\Tad_themes;

class Update
{
    // New public entry point for all updates
    public static function run_all_updates()
    {
        self::_update_tad_themes_table();
        self::_create_and_update_tad_themes_menu_table();
        self::_create_and_update_tad_themes_files_center_table();
        self::_create_and_update_tad_themes_data_center_table();
        self::_migrate_to_tad_themes_blocks_table(); // This handles the complex block migration
        self::_create_and_update_tad_themes_config2_table();

        // Data-only migrations and other updates
        self::_run_data_migrations();

        // Other utility functions
        self::add_bt_bg();
        self::chk_tad_themes_block();
    }

    //
    // PRIVATE HELPER METHODS
    //

    private static function _table_exists($table_name)
    {
        global $xoopsDB;
        $sql    = 'SHOW TABLES LIKE ' . $xoopsDB->quote($xoopsDB->prefix($table_name));
        $result = $xoopsDB->queryF($sql);
        return $xoopsDB->getRowsNum($result) > 0;
    }

    private static function _column_exists($table_name, $column_name)
    {
        global $xoopsDB;
        $sql    = 'SHOW COLUMNS FROM ' . $xoopsDB->prefix($table_name) . ' LIKE ' . $xoopsDB->quote($column_name);
        $result = $xoopsDB->queryF($sql);
        return $xoopsDB->getRowsNum($result) > 0;
    }

    private static function _key_exists($table_name, $key_name)
    {
        global $xoopsDB;
        $sql    = 'SHOW KEYS FROM ' . $xoopsDB->prefix($table_name) . ' WHERE Key_name = ' . $xoopsDB->quote($key_name);
        $result = $xoopsDB->queryF($sql);
        return $xoopsDB->getRowsNum($result) > 0;
    }

    private static function _execute_sql($sql)
    {
        global $xoopsDB;
        if (empty($sql)) {
            return;
        }
        $xoopsDB->queryF($sql);
    }

    //
    // SCHEMA AND DATA CONSOLIDATION METHODS
    //

    private static function _update_tad_themes_table()
    {
        global $xoopsDB;
        if (!self::_table_exists('tad_themes')) {
            return;
        }

        $alter_parts = [];

        $sql    = "SHOW COLUMNS FROM `" . $xoopsDB->prefix('tad_themes') . "` WHERE `Field` = 'theme_name'";
        $result = $xoopsDB->queryF($sql);
        $field  = $xoopsDB->fetchArray($result);
        if ($field && $field['Type'] !== 'varchar(100)') {
            $alter_parts[] = "MODIFY COLUMN `theme_name` varchar(100) NOT NULL";
        }
        $alter_parts[] = "CHANGE `logo_top` `logo_top` smallint(5) NOT NULL DEFAULT '0' COMMENT 'Logo離上方距離'";
        $alter_parts[] = "CHANGE `logo_right` `logo_right` smallint(5) NOT NULL DEFAULT '0' COMMENT 'Logo離右邊距離'";
        $alter_parts[] = "CHANGE `logo_bottom` `logo_bottom` smallint(5) NOT NULL DEFAULT '0' COMMENT 'Logo離下方距離'";
        $alter_parts[] = "CHANGE `logo_left` `logo_left` smallint(5) NOT NULL DEFAULT '0' COMMENT 'Logo離左邊距離'";

        if (!self::_column_exists('tad_themes', 'theme_kind')) {
            $alter_parts[] = "ADD `theme_kind` varchar(255) NOT NULL default 'html'";
        }

        if (!self::_column_exists('tad_themes', 'navbar_pos')) {
            $alter_parts[] = "ADD `navbar_pos` varchar(255) NOT NULL DEFAULT 'default'";
        }

        if (!self::_column_exists('tad_themes', 'navbar_bg_top')) {
            $alter_parts[] = "ADD `navbar_bg_top` varchar(255) NOT NULL DEFAULT '#54b4eb'";
        }

        if (!self::_column_exists('tad_themes', 'navbar_bg_bottom')) {
            $alter_parts[] = "ADD `navbar_bg_bottom` varchar(255) NOT NULL DEFAULT '#2fa4e7'";
        }

        if (!self::_column_exists('tad_themes', 'navbar_hover')) {
            $alter_parts[] = "ADD `navbar_hover` varchar(255) NOT NULL DEFAULT '#1684c2'";
        }

        if (!self::_column_exists('tad_themes', 'navbar_color')) {
            $alter_parts[] = "ADD `navbar_color` varchar(255) NOT NULL default '#FFFFFF'";
        }

        if (!self::_column_exists('tad_themes', 'navbar_color_hover')) {
            $alter_parts[] = "ADD `navbar_color_hover` varchar(255) NOT NULL default 'yellow'";
        }

        if (!self::_column_exists('tad_themes', 'navbar_icon')) {
            $alter_parts[] = "ADD `navbar_icon` varchar(255) NOT NULL default ''";
        }

        if (!self::_column_exists('tad_themes', 'theme_width')) {
            $alter_parts[] = "ADD `theme_width` varchar(255) NOT NULL default '980' after `theme_type`";
        }

        if (!self::_column_exists('tad_themes', 'navlogo_img')) {
            $alter_parts[] = "ADD `navlogo_img` varchar(255) NOT NULL default '' after logo_img";
        }

        if (!self::_column_exists('tad_themes', 'logo_position')) {
            $alter_parts[] = "ADD `logo_position` varchar(255) NOT NULL default 'slide' after logo_img";
        }

        if (!self::_column_exists('tad_themes', 'base_color')) {
            $alter_parts[] = "ADD `base_color` varchar(255) NOT NULL default 'transparent' COMMENT '頁面內容背景色'  after `crb_width`";
        }

        if (!self::_column_exists('tad_themes', 'navbar_img')) {
            $alter_parts[] = "ADD `navbar_img` varchar(255) NOT NULL default 'transparent' COMMENT 'navbar背景圖'  after `navbar_icon`";
        }

        if (!self::_column_exists('tad_themes', 'logo_center')) {
            $alter_parts[] = "ADD `logo_center` enum('0','1') NOT NULL default '0' after `logo_left`";
        }

        if (!self::_column_exists('tad_themes', 'cb_width')) {
            $alter_parts[] = "ADD `cb_width` varchar(255) NOT NULL default '' AFTER `lb_width`";
        }

        if (!self::_column_exists('tad_themes', 'bg_size')) {
            $alter_parts[] = "ADD `bg_size` varchar(255) DEFAULT '' COMMENT '背景縮放'";
        }

        if (!self::_key_exists('tad_themes', 'theme_name')) {
            $alter_parts[] = 'ADD UNIQUE `theme_name` (`theme_name`)';
        }

        if (!empty($alter_parts)) {
            $sql = "ALTER TABLE `" . $xoopsDB->prefix('tad_themes') . "` " . implode(",\n", $alter_parts);
            self::_execute_sql($sql);
        }

        if (self::_column_exists('tad_themes', 'theme_width')) {
            $sql = 'update ' . $xoopsDB->prefix('tad_themes') . " set `theme_width`=12 where theme_kind='bootstrap'";
            self::_execute_sql($sql);
        }
        if (self::_column_exists('tad_themes', 'cb_width')) {
            $sql = 'update ' . $xoopsDB->prefix('tad_themes') . " set `cb_width` = (`theme_width` - `lb_width` - `rb_width`) where theme_kind!='mix'";
            self::_execute_sql($sql);
            $sql = 'update ' . $xoopsDB->prefix('tad_themes') . " set `cb_width` = (12 - `lb_width` - `rb_width`) where theme_kind='mix'";
            self::_execute_sql($sql);
        }
        if (self::_column_exists('tad_themes', 'bg_size')) {
            $sql    = "select theme_id,bg_repeat from " . $xoopsDB->prefix('tad_themes') . " where bg_size = '' OR bg_size IS NULL";
            $result = $xoopsDB->queryF($sql);
            while (list($theme_id, $bg_repeat) = $xoopsDB->fetchRow($result)) {
                if (strpos($bg_repeat, 'cover') !== false) {
                    $sql_update = "update " . $xoopsDB->prefix('tad_themes') . " set bg_repeat='no-repeat', bg_size='cover' where theme_id='$theme_id'";
                } elseif (strpos($bg_repeat, 'contain') !== false) {
                    $sql_update = "update " . $xoopsDB->prefix('tad_themes') . " set bg_repeat='no-repeat', bg_size='contain' where theme_id='$theme_id'";
                } else {
                    $sql_update = "update " . $xoopsDB->prefix('tad_themes') . " set bg_size='auto' where theme_id='$theme_id'";
                }
                self::_execute_sql($sql_update);
            }
        }
        $sql = "update " . $xoopsDB->prefix('tad_themes') . " set `theme_kind`='bootstrap3' where `theme_kind`='bootstrap'";
        self::_execute_sql($sql);
    }

    private static function _create_and_update_tad_themes_menu_table()
    {
        global $xoopsDB;
        if (!self::_table_exists('tad_themes_menu')) {
            $sql = 'CREATE TABLE `' . $xoopsDB->prefix('tad_themes_menu') . "` (
            `menuid` smallint(5) unsigned NOT NULL auto_increment,
            `of_level` smallint(5) unsigned NOT NULL default 0,
            `position` smallint(5) unsigned NOT NULL default 0,
            `itemname` varchar(255) NOT NULL default '',
            `itemurl` varchar(255) NOT NULL default '',
            `status` enum('1','0') NOT NULL,
            PRIMARY KEY  (`menuid`),
            KEY `of_level` (`of_level`)
            ) ENGINE=MyISAM;";
            self::_execute_sql($sql);
        }

        $alter_parts = [];
        if (!self::_column_exists('tad_themes_menu', 'target')) {
            $alter_parts[] = "ADD `target` varchar(255) NOT NULL default ''";
        }

        if (!self::_column_exists('tad_themes_menu', 'icon')) {
            $alter_parts[] = "ADD `icon` varchar(255) NOT NULL default 'icon-th-list'";
        }

        if (!self::_column_exists('tad_themes_menu', 'link_cate_name')) {
            $alter_parts[] = "ADD `link_cate_name` varchar(255) NOT NULL default ''";
        }

        if (!self::_column_exists('tad_themes_menu', 'link_cate_sn')) {
            $alter_parts[] = "ADD `link_cate_sn` smallint(5) unsigned NOT NULL default 0";
        }

        if (!self::_column_exists('tad_themes_menu', 'read_group')) {
            $alter_parts[] = "ADD `read_group` varchar(255) NOT NULL default '1,2,3'";
        }

        if (self::_column_exists('tad_themes_menu', 'membersonly')) {
            $alter_parts[] = 'DROP `membersonly`';
        }

        if (self::_column_exists('tad_themes_menu', 'mainmenu')) {
            $alter_parts[] = 'DROP `mainmenu`';
        }

        if (!empty($alter_parts)) {
            $sql = "ALTER TABLE `" . $xoopsDB->prefix('tad_themes_menu') . "` " . implode(",\n", $alter_parts);
            self::_execute_sql($sql);
        }
    }

    private static function _create_and_update_tad_themes_files_center_table()
    {
        global $xoopsDB;
        if (!self::_table_exists('tad_themes_files_center')) {
            return;
        }

        $alter_parts = [];
        if (!self::_column_exists('tad_themes_files_center', 'original_filename')) {
            $alter_parts[] = "ADD `original_filename` varchar(255) NOT NULL default ''";
        }

        if (!self::_column_exists('tad_themes_files_center', 'hash_filename')) {
            $alter_parts[] = "ADD `hash_filename` varchar(255) NOT NULL default ''";
        }

        if (!self::_column_exists('tad_themes_files_center', 'sub_dir')) {
            $alter_parts[] = "ADD `sub_dir` varchar(255) NOT NULL default ''";
        }

        if (!self::_column_exists('tad_themes_files_center', 'upload_date')) {
            $alter_parts[] = "ADD `upload_date` DATETIME NOT NULL COMMENT '上傳時間'";
        }

        if (!self::_column_exists('tad_themes_files_center', 'uid')) {
            $alter_parts[] = "ADD `uid` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上傳者'";
        }

        if (!self::_column_exists('tad_themes_files_center', 'tag')) {
            $alter_parts[] = "ADD `tag` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '註記'";
        }

        $sql        = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '" . $xoopsDB->prefix('tad_themes_files_center') . "' AND COLUMN_NAME = 'col_sn'";
        $result     = $xoopsDB->query($sql);
        list($type) = $xoopsDB->fetchRow($result);
        if ($type === 'smallint') {
            $alter_parts[] = 'CHANGE `col_sn` `col_sn` mediumint(9) unsigned NOT NULL default 0';
        }

        if (!empty($alter_parts)) {
            $sql = "ALTER TABLE `" . $xoopsDB->prefix('tad_themes_files_center') . "` " . implode(",\n", $alter_parts);
            self::_execute_sql($sql);
        }

        if (self::_column_exists('tad_themes_files_center', 'original_filename')) {
            $sql = 'update ' . $xoopsDB->prefix('tad_themes_files_center') . ' set `original_filename`=`description` where `original_filename`=""';
            self::_execute_sql($sql);
        }
    }

    private static function _create_and_update_tad_themes_data_center_table()
    {
        global $xoopsDB;
        if (!self::_table_exists('tad_themes_data_center')) {
            $sql = "CREATE TABLE `" . $xoopsDB->prefix('tad_themes_data_center') . "` (
            `mid` mediumint(9) unsigned NOT NULL  COMMENT '模組編號',
            `col_name` varchar(100) NOT NULL default '' COMMENT '欄位名稱',
            `col_sn` mediumint(9) unsigned NOT NULL COMMENT '欄位編號',
            `data_name` varchar(100) NOT NULL default '' COMMENT '資料名稱',
            `data_value` text NOT NULL COMMENT '儲存值',
            `data_sort` mediumint(9) unsigned NOT NULL  COMMENT '排序',
            PRIMARY KEY  (`mid`,`col_name`,`col_sn`,`data_name`,`data_sort`)
            )  ENGINE=MyISAM";
            self::_execute_sql($sql);
        }

        $alter_parts = [];
        if (!self::_column_exists('tad_themes_data_center', 'col_id')) {
            $alter_parts[] = "ADD `col_id` varchar(100) NOT NULL DEFAULT '' COMMENT '辨識字串'";
        }

        if (!self::_column_exists('tad_themes_data_center', 'update_time')) {
            $alter_parts[] = "ADD `update_time` datetime NOT NULL COMMENT '更新時間'";
        }

        if (!self::_column_exists('tad_themes_data_center', 'sort')) {
            $alter_parts[] = "ADD `sort` mediumint(9) unsigned COMMENT '顯示順序' after `col_id`";
        }

        if (self::_column_exists('tad_themes_data_center', 'col_id')) {
            $sql    = 'SELECT COLUMN_DEFAULT FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = "' . $xoopsDB->prefix('tad_themes_data_center') . '" AND COLUMN_NAME = "col_id"';
            $result = $xoopsDB->query($sql);
            if ($result) {
                list($default) = $xoopsDB->fetchRow($result);
                if ($default === null || $default === 'NULL') {
                    $alter_parts[] = "CHANGE `col_id` `col_id` varchar(100) NOT NULL DEFAULT '' COMMENT '辨識字串' AFTER `data_sort`";
                }
            }
        }

        if (!empty($alter_parts)) {
            $sql = "ALTER TABLE `" . $xoopsDB->prefix('tad_themes_data_center') . "` " . implode(",\n", $alter_parts);
            self::_execute_sql($sql);
        }
    }

    private static function _create_and_update_tad_themes_config2_table()
    {
        global $xoopsDB;
        if (!self::_table_exists('tad_themes_config2')) {
            $sql = 'CREATE TABLE `' . $xoopsDB->prefix('tad_themes_config2') . "` (
                `theme_id` smallint(5) unsigned NOT NULL default 0,
                `name` varchar(100) NOT NULL default '',
                `type` varchar(255) NOT NULL default '',
                `value` text NOT NULL,
                PRIMARY KEY  (`theme_id`,`name`)
            )  ENGINE=MyISAM;";
            self::_execute_sql($sql);
        }
    }

    private static function _migrate_to_tad_themes_blocks_table()
    {
        global $xoopsDB;

        $table_exists = self::_table_exists('tad_themes_blocks');

        // If the migration has already run, just ensure schema is up-to-date
        if ($table_exists) {
            $alter_parts = [];
            if (!self::_column_exists('tad_themes_blocks', 'block_style')) {
                $alter_parts[] = "ADD `block_style` text NOT NULL COMMENT ''";
            }

            if (!self::_column_exists('tad_themes_blocks', 'block_title_style')) {
                $alter_parts[] = "ADD `block_title_style` text NOT NULL COMMENT ''";
            }

            if (!self::_column_exists('tad_themes_blocks', 'block_content_style')) {
                $alter_parts[] = "ADD `block_content_style` text NOT NULL COMMENT ''";
            }

            if (!empty($alter_parts)) {
                $sql = "ALTER TABLE `" . $xoopsDB->prefix('tad_themes_blocks') . "` " . implode(",\n", $alter_parts);
                self::_execute_sql($sql);
                $sql = 'update ' . $xoopsDB->prefix('tad_themes_blocks') . " set block_title_style='border:none;height:40px;line-height:40px;margin-bottom:10px;' WHERE block_title_style=''";
                self::_execute_sql($sql);
            }

            $sql    = "SELECT EXTRA FROM INFORMATION_SCHEMA.COLUMNS  WHERE table_name = '" . $xoopsDB->prefix('tad_themes_blocks') . "' AND COLUMN_NAME = 'theme_id'";
            $result = $xoopsDB->query($sql);
            if ($result) {
                list($EXTRA) = $xoopsDB->fetchRow($result);
                if ('auto_increment' === $EXTRA) {
                    $sql_alter = 'ALTER TABLE ' . $xoopsDB->prefix('tad_themes_blocks') . " CHANGE `theme_id` `theme_id` smallint(6) unsigned NOT NULL COMMENT '佈景編號' FIRST";
                    self::_execute_sql($sql_alter);
                }
            }
            return;
        }

        // --- Start of migration: If tad_themes_blocks does not exist ---

        // Step 1: Add temporary columns to tad_themes
        $temp_cols = [
            'block_config'    => "ADD `block_config` enum('right','left') NOT NULL DEFAULT 'right'",
            'bt_text'         => "ADD `bt_text` varchar(255) NOT NULL DEFAULT ''",
            'bt_text_padding' => "ADD `bt_text_padding` tinyint(4) NOT NULL DEFAULT '33'",
            'bt_bg_color'     => "ADD `bt_bg_color` varchar(255) NOT NULL DEFAULT ''",
            'bt_bg_img'       => "ADD `bt_bg_img` varchar(255) NOT NULL DEFAULT ''",
            'bt_bg_repeat'    => "ADD `bt_bg_repeat` enum('0','1') NOT NULL DEFAULT '0'",
            'bt_radius'       => "ADD `bt_radius` enum('0','1') NOT NULL DEFAULT '1'",
        ];

        $add_temp_cols_parts = [];
        foreach ($temp_cols as $col => $def) {
            if (!self::_column_exists('tad_themes', $col)) {
                $add_temp_cols_parts[] = $def;
            }
        }
        if (!empty($add_temp_cols_parts)) {
            $sql = "ALTER TABLE `" . $xoopsDB->prefix('tad_themes') . "` " . implode(",\n", $add_temp_cols_parts);
            self::_execute_sql($sql);
        }

        // Step 2: Create the new tad_themes_blocks table
        $sql = 'CREATE TABLE `' . $xoopsDB->prefix('tad_themes_blocks') . "` (
            `theme_id` smallint(6) unsigned NOT NULL COMMENT '佈景編號',
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
        self::_execute_sql($sql);

        // Step 3: Migrate data
        $block_position = ['leftBlock', 'rightBlock', 'centerBlock', 'centerLeftBlock', 'centerRightBlock', 'centerBottomBlock', 'centerBottomLeftBlock', 'centerBottomRightBlock', 'footerLeftBlock', 'footerCenterBlock', 'footerRightBlock'];
        $sql_select     = 'select `theme_id`,`block_config`,`bt_text`, `bt_text_padding`, `bt_bg_color`, `bt_bg_img`, `bt_bg_repeat`, `bt_radius` from `' . $xoopsDB->prefix('tad_themes') . '` order by `theme_id`';
        $result         = $xoopsDB->queryF($sql_select);
        while (list($theme_id, $block_config, $bt_text, $bt_text_padding, $bt_bg_color, $bt_bg_img, $bt_bg_repeat, $bt_radius) = $xoopsDB->fetchRow($result)) {
            foreach ($block_position as $position) {
                $sql_insert = 'insert into `' . $xoopsDB->prefix('tad_themes_blocks') . "` (`theme_id` , `block_position` , `block_config` , `bt_text` , `bt_text_padding`, `bt_text_size` , `bt_bg_color` , `bt_bg_img` , `bt_bg_repeat` , `bt_radius`) values('{$theme_id}' , '{$position}' , '{$block_config}' , '{$bt_text}' , '{$bt_text_padding}', '16px' , '{$bt_bg_color}' , '{$bt_bg_img}' , '{$bt_bg_repeat}' , '{$bt_radius}')";
                self::_execute_sql($sql_insert);
            }
        }

        // Step 4: Drop temporary columns from tad_themes
        $drop_cols_parts = [];
        foreach ($temp_cols as $col => $def) {
            $drop_cols_parts[] = "DROP `{$col}`";
        }
        $sql_drop = 'ALTER TABLE `' . $xoopsDB->prefix('tad_themes') . '` ' . implode(', ', $drop_cols_parts);
        self::_execute_sql($sql_drop);
    }

    private static function _run_data_migrations()
    {
        global $xoopsDB;

        // From fix_config2_file_url
        $sql    = 'SELECT `theme_id`, `bg_img`, `logo_img`, `navlogo_img`, `navbar_img` FROM ' . $xoopsDB->prefix('tad_themes') . " where left(`bg_img`, 4)='http' or left(`logo_img`, 4)='http' or left(`navlogo_img`, 4)='http' or left(`navbar_img`, 4)='http'";
        $result = $xoopsDB->query($sql);
        while (list($theme_id, $bg_img, $logo_img, $navlogo_img, $navbar_img) = $xoopsDB->fetchRow($result)) {
            $bg_img      = basename($bg_img);
            $logo_img    = basename($logo_img);
            $navlogo_img = basename($navlogo_img);
            $navbar_img  = basename($navbar_img);
            $sql_update  = 'update ' . $xoopsDB->prefix('tad_themes') . " set `bg_img`='{$bg_img}',`logo_img`='{$logo_img}',`navlogo_img`='{$navlogo_img}',`navbar_img`='{$navbar_img}' where `theme_id`='$theme_id'";
            self::_execute_sql($sql_update);
        }

        // From go_update_logo_right
        $updates = [
            'logo_right_zone'              => 'logo_right',
            'logo_right_zone_fa_content'   => 'logo_right_fa_content',
            'logo_right_zone_menu_content' => 'logo_right_menu_content',
            'logo_right_zone_block'        => 'logo_right_block',
            'logo_right_zone_html_content' => 'logo_right_html_content',
        ];
        foreach ($updates as $new_name => $old_name) {
            $sql = "update " . $xoopsDB->prefix('tad_themes_config2') . " set `name`='{$new_name}' where `name`='{$old_name}'";
            self::_execute_sql($sql);
        }

        // From update_logo_bg_type
        $sql_select = "select theme_id from " . $xoopsDB->prefix('tad_themes') . " where theme_name='school2019'";
        $result     = $xoopsDB->queryF($sql_select);
        if ($result && $xoopsDB->getRowsNum($result) > 0) {
            list($theme_id) = $xoopsDB->fetchRow($result);
            $sql_update     = "update " . $xoopsDB->prefix('tad_themes_config2') . " set `type`='bg_file' where (`name`='logo_bg' or `name`='logo_bg2' or `name`='footer_img') and `type` = 'file' and `theme_id`='{$theme_id}'";
            self::_execute_sql($sql_update);
        }

        // From update_bg_size
        $sql    = "select `theme_id`, `name`, `value` from " . $xoopsDB->prefix('tad_themes_config2') . " where `name`='logo_bg_repeat' or `name`='logo_bg2_repeat'";
        $result = $xoopsDB->queryF($sql);
        while (list($theme_id, $name, $value) = $xoopsDB->fetchRow($result)) {
            $size_name = str_replace('repeat', 'size', $name);
            if (strpos($value, 'cover') !== false) {
                self::_execute_sql("update " . $xoopsDB->prefix('tad_themes_config2') . " set `value`='no-repeat' where theme_id='$theme_id' and `name`='{$name}'");
                self::_execute_sql("replace into " . $xoopsDB->prefix('tad_themes_config2') . " (`theme_id`, `name`, `type`, `value`) values('$theme_id', '{$size_name}', 'text', 'cover')");
            } elseif (strpos($value, 'contain') !== false) {
                self::_execute_sql("update " . $xoopsDB->prefix('tad_themes_config2') . " set `value`='no-repeat' where theme_id='$theme_id' and `name`='{$name}'");
                self::_execute_sql("replace into " . $xoopsDB->prefix('tad_themes_config2') . " (`theme_id`, `name`, `type`, `value`) values('$theme_id', '{$size_name}', 'text', 'contain')");
            } else {
                self::_execute_sql("replace into " . $xoopsDB->prefix('tad_themes_config2') . " (`theme_id`, `name`, `type`, `value`) values('$theme_id', '{$size_name}', 'text', 'auto')");
            }
        }
    }

    //
    // OTHER PUBLIC METHODS (can be called directly if needed)
    //

    public static function add_bt_bg()
    {
        global $xoopsDB;
        $sql         = "SELECT COUNT(*) FROM `" . $xoopsDB->prefix('tad_themes_files_center') . "` WHERE `col_name`='bt_bg' AND `col_sn`=0";
        $result      = $xoopsDB->query($sql);
        list($count) = $xoopsDB->fetchRow($result);

        if ($count > 0) {
            return;
        }

        $sql = "INSERT INTO `" . $xoopsDB->prefix('tad_themes_files_center') . "` (`col_name`, `col_sn`, `sort`, `kind`, `file_name`, `file_type`, `file_size`, `description`, `counter`, `original_filename`, `hash_filename`, `sub_dir`, `upload_date`, `uid`, `tag`) VALUES
        ('bt_bg', 0, 1, 'img', 'blue.gif', 'image/gif', 1352, '', 0, 'blue.gif', 'a4583cc3581d4f4cc2c5b2c0b06efd50.gif', '/school2022/bt_bg', NOW(), 1, ''),
        ('bt_bg', 0, 2, 'img', 'green.gif', 'image/gif', 1411, '', 0, 'green.gif', '7b065e1e65f668bef7abcf9743a653d3.gif', '/school2022/bt_bg', NOW(), 1, ''),
        ('bt_bg', 0, 3, 'img', 'orange.gif', 'image/gif', 1406, '', 0, 'orange.gif', '054624aff9d090f4197a0b517fdc02a8.gif', '/school2022/bt_bg', NOW(), 1, ''),
        ('bt_bg', 0, 4, 'img', 'red.gif', 'image/gif', 1403, '', 0, 'red.gif', '9c30777ba181c72c738e7364a455f643.gif', '/school2022/bt_bg', NOW(), 1, '')";
        self::_execute_sql($sql);
    }

    public static function chk_tad_themes_block()
    {
        global $xoopsDB;
        require XOOPS_ROOT_PATH . '/modules/tad_themes/xoops_version.php';

        $tpl_file_arr = [];
        $tpl_desc_arr = [];
        foreach ($modversion['blocks'] as $i => $block) {
            $show_func                = $block['show_func'];
            $tpl_file_arr[$show_func] = $block['template'];
            $tpl_desc_arr[$show_func] = $block['description'];
        }

        $sql    = "SELECT `bid`, `name`, `visible`,`show_func`,`template` FROM `" . $xoopsDB->prefix('newblocks') . "`  WHERE `dirname` = 'tad_themes' ORDER BY `func_num`";
        $result = $xoopsDB->query($sql);
        while (list($bid, $name, $visible, $show_func, $template) = $xoopsDB->fetchRow($result)) {
            if (!isset($tpl_file_arr[$show_func]) || $template != $tpl_file_arr[$show_func]) {
                $sql_del_block = 'delete from ' . $xoopsDB->prefix('newblocks') . " where bid='{$bid}'";
                self::_execute_sql($sql_del_block);

                $sql_del_tpl = "delete from " . $xoopsDB->prefix('tplfile') . " where tpl_refid='{$bid}' and tpl_module='tad_themes' and tpl_type='block'";
                self::_execute_sql($sql_del_tpl);
            } else {
                $sql_update_tpl = 'update ' . $xoopsDB->prefix('tplfile') . "
                set tpl_file=" . $xoopsDB->quote($template) . " , tpl_desc=" . $xoopsDB->quote($tpl_desc_arr[$show_func]) . "
                where tpl_refid='{$bid}'";
                self::_execute_sql($sql_update_tpl);
            }
        }
    }
}
