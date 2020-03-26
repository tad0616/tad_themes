CREATE TABLE `tad_themes` (
  `theme_id` smallint(6) unsigned AUTO_INCREMENT COMMENT '佈景編號',
  `theme_name` varchar(255) default '' COMMENT '佈景名稱',
  `theme_type` varchar(255) default '' COMMENT '版面類型',
  `theme_width` varchar(255) default '' COMMENT '頁面寬度',
  `lb_width` varchar(255) default '' COMMENT '左區塊寬度',
  `cb_width` varchar(255) default '' COMMENT '中間區塊寬度',
  `rb_width` varchar(255) default '' COMMENT '右區塊寬度',
  `clb_width` varchar(255) default '' COMMENT '中左區塊寬度',
  `crb_width` varchar(255) default '' COMMENT '中右區塊寬度',
  `base_color` varchar(255) default 'transparent' COMMENT '頁面內容背景色',
  `lb_color` varchar(255) default '' COMMENT '左區域背景色',
  `cb_color` varchar(255) default '' COMMENT '中區域背景色',
  `rb_color` varchar(255) default '' COMMENT '右區域背景色',
  `margin_top` varchar(255) default '' COMMENT '上邊界',
  `margin_bottom` varchar(255) default '' COMMENT '下邊界',
  `bg_img` varchar(255) default '' COMMENT '背景圖',
  `logo_img` varchar(255) default 'slide' COMMENT 'logo圖',
  `logo_position` varchar(255) default '' COMMENT 'logo圖位置',
  `navlogo_img` varchar(255) default '' COMMENT '導覽列logo圖',
  `bg_attachment` varchar(255) default '' COMMENT '背景固定',
  `bg_color` varchar(255) default '' COMMENT '背景顏色',
  `bg_position` varchar(255) default '' COMMENT '背景位置',
  `bg_repeat` varchar(255) default '' COMMENT '背景重複',
  `bg_size` varchar(255) default '' COMMENT '背景縮放',
  `logo_top` smallint(5) unsigned default 0 COMMENT 'Logo離上方距離',
  `logo_right` smallint(5) unsigned default 0 COMMENT 'Logo離右邊距離',
  `logo_bottom` smallint(5) unsigned default 0 COMMENT 'Logo離下方距離',
  `logo_left` smallint(5) unsigned default 0 COMMENT 'Logo離左邊距離',
  `logo_center` enum('0','1') default '0' COMMENT 'Logo 置中',
  `theme_enable` enum('1','0') default '1' COMMENT '使用狀況',
  `slide_width` varchar(255) default '' COMMENT '佈景圖片寬度',
  `slide_height` varchar(255) default '' COMMENT '佈景圖片高度',
  `font_size` varchar(255) default '' COMMENT '文字大小',
  `font_color` varchar(255) default '' COMMENT '文字顏色',
  `link_color` varchar(255) default '' COMMENT '連結顏色',
  `hover_color` varchar(255) default '' COMMENT '移致連結顏色',
  `theme_kind` varchar(255) default 'html' COMMENT '佈景種類',
  `navbar_pos` varchar(255) default 'default' COMMENT 'navbar位置',
  `navbar_bg_top` varchar(255) COMMENT 'navbar漸層色top',
  `navbar_bg_bottom` varchar(255) COMMENT 'navbar漸層色bottom',
  `navbar_hover` varchar(255) COMMENT 'navbar覆蓋色塊',
  `navbar_color` varchar(255) default '#FFFFFF' COMMENT 'navbar文字顏色',
  `navbar_color_hover` varchar(255) default 'yellow' COMMENT 'navbar文字移過顏色',
  `navbar_icon` varchar(255) default '' COMMENT 'navbar 圖示色調',
  `navbar_img` varchar(255) default '' COMMENT 'navbar背景圖',
  PRIMARY KEY (`theme_id`),
  UNIQUE KEY (`theme_name`)
) ENGINE=MyISAM ;

CREATE TABLE `tad_themes_blocks` (
  `theme_id` smallint(6) unsigned COMMENT '佈景編號',
  `block_position` varchar(30) default '' COMMENT '區塊位置',
  `block_config` enum('right','left') DEFAULT 'right' COMMENT '工具按鈕靠左/右',
  `bt_text` varchar(16) COMMENT '區塊標題字體顏色',
  `bt_text_padding` tinyint(4) DEFAULT '33' COMMENT '區塊標題文字縮排',
  `bt_text_size` varchar(16) COMMENT '區塊標題字體大小',
  `bt_bg_color` varchar(16) COMMENT '區塊標題背景顏色',
  `bt_bg_img` varchar(255) COMMENT '區塊標題背景圖',
  `bt_bg_repeat` enum('0','1') DEFAULT '0' COMMENT '以圖填滿區塊標題列',
  `bt_radius` enum('0','1') DEFAULT '1' COMMENT '區塊標題圓角',
  `block_style` text COMMENT '區塊整體樣式',
  `block_title_style` text COMMENT '區塊標題區樣式',
  `block_content_style` text COMMENT '區塊內容區樣式',
  PRIMARY KEY (`theme_id`,`block_position`)
) ENGINE=MyISAM ;

CREATE TABLE `tad_themes_files_center` (
  `files_sn` smallint(5) unsigned AUTO_INCREMENT,
  `col_name` varchar(255) default '',
  `col_sn` mediumint(9) unsigned default '0',
  `sort` smallint(5) unsigned default '1',
  `kind` enum('img','file') default 'img',
  `file_name` varchar(255) default '',
  `file_type` varchar(255) default '',
  `file_size` int(10) unsigned default '0',
  `description` text NOT NULL,
  `counter` mediumint(8) unsigned default 0,
  `original_filename` varchar(255) default '',
  `hash_filename` varchar(255) default '',
  `sub_dir` varchar(255) default '',
  `upload_date` datetime COMMENT '上傳時間',
  `uid` mediumint(8) unsigned default 0 COMMENT '上傳者',
  `tag` varchar(255) default '' COMMENT '註記',
  PRIMARY KEY (`files_sn`),
  UNIQUE KEY `col_name` (`col_name`,`col_sn`,`sort`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tad_themes_menu` (
  `menuid` mediumint(8) unsigned auto_increment,
  `of_level` smallint(5) unsigned default 0,
  `position` smallint(5) unsigned default 0,
  `itemname` varchar(255) default '',
  `itemurl` varchar(255) default '',
  `status` enum('1','0') NOT NULL,
  `target` varchar(255) default '',
  `icon` varchar(255) default 'fa-th-list',
  `link_cate_name` varchar(255) default '',
  `link_cate_sn` smallint(5) unsigned default 0,
  `read_group` varchar(255) default '',
  PRIMARY KEY  (`menuid`),
  KEY `of_level` (`of_level`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `tad_themes_config2` (
  `theme_id` smallint(5) unsigned default 0,
  `name` varchar(100) default '',
  `type` varchar(255) default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`theme_id`,`name`)
)  ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `tad_themes_data_center` (
`mid` mediumint(9) unsigned  COMMENT '模組編號',
`col_name` varchar(100) default '' COMMENT '欄位名稱',
`col_sn` mediumint(9) unsigned COMMENT '欄位編號',
`data_name` varchar(100) default '' COMMENT '資料名稱',
`data_value` text COMMENT '儲存值',
`data_sort` mediumint(9) unsigned  COMMENT '排序',
`col_id` varchar(100) default '' COMMENT '辨識字串',
`update_time` datetime COMMENT '更新時間',
PRIMARY KEY  (`mid`,`col_name`,`col_sn`,`data_name`,`data_sort`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;