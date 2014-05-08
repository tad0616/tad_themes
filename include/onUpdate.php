<?php

function xoops_module_update_tad_themes(&$module, $old_version) {
    GLOBAL $xoopsDB;

    if(!chk_chk1()) go_update1();
    if(!chk_chk2()) go_update2();
    //if(!chk_chk3()) go_update3();
    if(!chk_chk4()) go_update4();
    if(!chk_chk5()) go_update5();
    if(!chk_chk6()) go_update6();
    if(!chk_chk7()) go_update7();
    if(!chk_chk8()) go_update8();
    if(!chk_chk9()) go_update9();
    if(!chk_chk10()) go_update10();
    if(!chk_chk11()) go_update11();
    if(!chk_chk12()) go_update12();
    if(!chk_chk13()) go_update13();
    if(!chk_chk14()) go_update14();
    if(!chk_chk15()) go_update15();
    if(!chk_chk16()) go_update16();

    mk_dir(XOOPS_ROOT_PATH."/uploads/tad_themes");
    return true;
}


//新增佈景類型欄位
function chk_chk1(){
  global $xoopsDB;
  $sql="select count(`theme_kind`) from ".$xoopsDB->prefix("tad_themes");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

function go_update1(){
  global $xoopsDB;
  $sql="ALTER TABLE ".$xoopsDB->prefix("tad_themes")." ADD `theme_kind` varchar(255) NOT NULL default 'html'";
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL."/modules/system/admin.php?fct=modulesadmin",30,  mysql_error());
}


//新增tad_themes_menu資料表
function chk_chk2(){
  global $xoopsDB;
  $sql="select count(*) from ".$xoopsDB->prefix("tad_themes_menu");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

function go_update2(){
  global $xoopsDB;
  $sql="CREATE TABLE `".$xoopsDB->prefix("tad_themes_menu")."` (
  `menuid` smallint(5) unsigned NOT NULL auto_increment,
  `of_level` smallint(5) unsigned NOT NULL default 0,
  `position` smallint(5) unsigned NOT NULL default 0,
  `itemname` varchar(255) NOT NULL default '',
  `itemurl` varchar(255) NOT NULL default '',
  `membersonly` enum('0','1') NOT NULL,
  `status` enum('1','0') NOT NULL,
  PRIMARY KEY  (`menuid`),
  KEY `of_level` (`of_level`)
)  ENGINE=MyISAM;";
  $xoopsDB->queryF($sql);
}

//新增區塊欄位
function chk_chk3(){
  global $xoopsDB;
  $sql="select count(`block_config`) from ".$xoopsDB->prefix("tad_themes");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

function go_update3(){
  global $xoopsDB;
  $sql="ALTER TABLE ".$xoopsDB->prefix("tad_themes")."
  ADD `block_config` enum('right','left') NOT NULL DEFAULT 'right',
  ADD `bt_text` varchar(255) NOT NULL DEFAULT '',
  ADD `bt_text_padding` tinyint(4) NOT NULL DEFAULT '33',
  ADD `bt_bg_color` varchar(255) NOT NULL DEFAULT '',
  ADD `bt_bg_img` varchar(255) NOT NULL DEFAULT '',
  ADD `bt_bg_repeat` enum('0','1') NOT NULL DEFAULT '0',
  ADD `bt_radius` enum('0','1') NOT NULL DEFAULT '1'";
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL."/modules/system/admin.php?fct=modulesadmin",30,  mysql_error());
}

//新增導覽工具列欄位
function chk_chk4(){
  global $xoopsDB;
  $sql="select count(`navbar_pos`) from ".$xoopsDB->prefix("tad_themes");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

function go_update4(){
  global $xoopsDB;
  $sql="ALTER TABLE ".$xoopsDB->prefix("tad_themes")."
  ADD `navbar_pos` enum('navbar-fixed-top','navbar-fixed-bottom','navbar-static-top','not-use') NOT NULL ,
  ADD `navbar_bg_top` varchar(255) NOT NULL DEFAULT '#54b4eb',
  ADD `navbar_bg_bottom` varchar(255) NOT NULL DEFAULT '#2fa4e7',
  ADD `navbar_hover` varchar(255) NOT NULL DEFAULT '#1684c2'";
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL."/modules/system/admin.php?fct=modulesadmin",30,  mysql_error());
}


//新增選單欄位
function chk_chk5(){
  global $xoopsDB;
  $sql="select count(`target`) from ".$xoopsDB->prefix("tad_themes_menu");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

function go_update5(){
  global $xoopsDB;
  $sql="ALTER TABLE ".$xoopsDB->prefix("tad_themes_menu")."
  ADD `mainmenu` enum('0','1') NOT NULL default '0' ,
  ADD `target` varchar(255) NOT NULL default '',
  ADD `icon` varchar(255) NOT NULL default 'icon-th-list'";
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL."/modules/system/admin.php?fct=modulesadmin",30,  mysql_error());
}

//新增original_filename欄位
function chk_chk6(){
  global $xoopsDB;
  $sql="select count(`original_filename`) from ".$xoopsDB->prefix("tad_themes_files_center");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}


function go_update6(){
  global $xoopsDB;
  $sql="ALTER TABLE ".$xoopsDB->prefix("tad_themes_files_center")."
  ADD `original_filename` varchar(255) NOT NULL default ''";
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL."/modules/system/admin.php?fct=modulesadmin",30,  mysql_error());

  $sql="update ".$xoopsDB->prefix("tad_themes_files_center")." set
  `original_filename`=`description`";
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL."/modules/system/admin.php?fct=modulesadmin",30,  mysql_error());
}

//新增hash_filename欄位
function chk_chk7(){
  global $xoopsDB;
  $sql="select count(`hash_filename`) from ".$xoopsDB->prefix("tad_themes_files_center");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}


function go_update7(){
  global $xoopsDB;
  $sql="ALTER TABLE ".$xoopsDB->prefix("tad_themes_files_center")."
  ADD `hash_filename` varchar(255) NOT NULL default '',
  ADD `sub_dir` varchar(255) NOT NULL default ''";
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL."/modules/system/admin.php?fct=modulesadmin",30,  mysql_error());
}

//新增hash_filename欄位
function chk_chk8(){
  global $xoopsDB;
  $sql="select count(`navbar_color`) from ".$xoopsDB->prefix("tad_themes");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}


function go_update8(){
  global $xoopsDB;
  $sql="ALTER TABLE ".$xoopsDB->prefix("tad_themes")."
  ADD `navbar_color` varchar(255) NOT NULL default '#FFFFFF',
  ADD `navbar_color_hover` varchar(255) NOT NULL default 'yellow',
  ADD `navbar_icon` varchar(255) NOT NULL default ''
  ";
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL."/modules/system/admin.php?fct=modulesadmin",30,  mysql_error());
}

//新增 theme_width 欄位
function chk_chk9(){
  global $xoopsDB;
  $sql="select count(`theme_width`) from ".$xoopsDB->prefix("tad_themes");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}


function go_update9(){
  global $xoopsDB;
  $sql="ALTER TABLE ".$xoopsDB->prefix("tad_themes")."
  ADD `theme_width` varchar(255) NOT NULL default '980' after `theme_type`;
  ";
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL."/modules/system/admin.php?fct=modulesadmin",30,  mysql_error());

  $sql="update ".$xoopsDB->prefix("tad_themes")." set `theme_width`=12 where theme_kind='bootstrap'";
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL."/modules/system/admin.php?fct=modulesadmin",30,  mysql_error());
}


//新增導覽列logo圖欄位
function chk_chk10(){
  global $xoopsDB;
  $sql="select count(`navlogo_img`) from ".$xoopsDB->prefix("tad_themes");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

function go_update10(){
  global $xoopsDB;
  $sql="ALTER TABLE ".$xoopsDB->prefix("tad_themes")." ADD `navlogo_img` varchar(255) NOT NULL default '' after logo_img";
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL."/modules/system/admin.php?fct=modulesadmin",30,  mysql_error());
}


//新增logo圖位置欄位
function chk_chk11(){
  global $xoopsDB;
  $sql="select count(`logo_position`) from ".$xoopsDB->prefix("tad_themes");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

function go_update11(){
  global $xoopsDB;
  $sql="ALTER TABLE ".$xoopsDB->prefix("tad_themes")." ADD `logo_position` varchar(255) NOT NULL default 'slide' after logo_img";
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL."/modules/system/admin.php?fct=modulesadmin",30,  mysql_error());
}



//新增tad_themes_config2資料表
function chk_chk12(){
  global $xoopsDB;
  $sql="select count(*) from ".$xoopsDB->prefix("tad_themes_config2");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

function go_update12(){
  global $xoopsDB;
  $sql="CREATE TABLE `".$xoopsDB->prefix("tad_themes_config2")."` (
    `theme_id` smallint(5) unsigned NOT NULL default 0,
    `name` varchar(100) NOT NULL default '',
    `type` varchar(255) NOT NULL default '',
    `value` text NOT NULL,
    PRIMARY KEY  (`theme_id`,`name`)
  )  ENGINE=MyISAM;";
  $xoopsDB->queryF($sql);
}


//新增 tad_themes_blocks 資料表
function chk_chk13(){
  global $xoopsDB;
  $sql="select count(*) from ".$xoopsDB->prefix("tad_themes_blocks");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

function go_update13(){
  global $xoopsDB;

  $block_position=array("leftBlock", "rightBlock", "centerBlock", "centerLeftBlock", "centerRightBlock", "centerBottomBlock", "centerBottomLeftBlock", "centerBottomRightBlock");


  $sql="CREATE TABLE `".$xoopsDB->prefix("tad_themes_blocks")."` (
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

  $sql="select `theme_id`,`block_config`,`bt_text`, `bt_text_padding`, `bt_bg_color`, `bt_bg_img`, `bt_bg_repeat`, `bt_radius` from `".$xoopsDB->prefix("tad_themes")."` order by `theme_id`";
  $result=$xoopsDB->queryF($sql);
  while(list($theme_id,$block_config,$bt_text,$bt_text_padding,$bt_bg_color,$bt_bg_img,$bt_bg_repeat,$bt_radius)=$xoopsDB->fetchRow($result)){
    foreach($block_position as $position){
      $sql="insert into `".$xoopsDB->prefix("tad_themes_blocks")."` (`theme_id` , `block_position` , `block_config` , `bt_text` , `bt_text_padding`, `bt_text_size` , `bt_bg_color` , `bt_bg_img` , `bt_bg_repeat` , `bt_radius`) values('$theme_id' , '{$position}' , '$block_config' , '$bt_text' , '$bt_text_padding', '16px' , '$bt_bg_color' , '$bt_bg_img' , '$bt_bg_repeat' , '$bt_radius')";
      $xoopsDB->queryF($sql);
    }
  }

  $sql="ALTER TABLE `".$xoopsDB->prefix("tad_themes")."` DROP `block_config`, DROP `bt_text`, DROP `bt_text_padding`, DROP `bt_bg_color`, DROP `bt_bg_img`, DROP `bt_bg_repeat`, DROP `bt_radius`;";
  $xoopsDB->queryF($sql);

  $sql="select `col_name`, `col_sn`, `sort`, `kind`, `file_name`, `file_type`, `file_size`, `description`, `counter`, `original_filename`, `hash_filename`, `sub_dir` from `".$xoopsDB->prefix("tad_themes_files_center")."` where `col_name`='bt_bg'";
  $result=$xoopsDB->queryF($sql);

  while(list($col_name,$col_sn,$sort,$kind,$file_name,$file_type,$file_size,$description,$counter,$original_filename,$hash_filename,$sub_dir)=$xoopsDB->fetchRow($result)){

    foreach($block_position as $position){
      $sql="insert into `".$xoopsDB->prefix("tad_themes_files_center")."` (`col_name`, `col_sn`, `sort`, `kind`, `file_name`, `file_type`, `file_size`, `description`, `counter`, `original_filename`, `hash_filename`, `sub_dir`) values('{$col_name}_{$position}' , '{$col_sn}' , '$sort' , '$kind' , '$file_name', '$file_type' , '$file_size' , '$description' , '$counter' , '$original_filename' , '$hash_filename'  , '$sub_dir' )";
      $xoopsDB->queryF($sql);
    }
  }
  $sql="delete `".$xoopsDB->prefix("tad_themes_files_center")."` where `col_name`='bt_bg'";
  $xoopsDB->queryF($sql);

  $sql="ALTER TABLE `".$xoopsDB->prefix("tad_themes")."` CHANGE `navbar_pos` `navbar_pos` varchar(255) NOT NULL default 'default'";
  $xoopsDB->queryF($sql);

  $sql="update `".$xoopsDB->prefix("tad_themes")."` set `navbar_pos`='default' where `navbar_pos`='not-use'";
  $xoopsDB->queryF($sql);
}


//新增 theme_width 欄位
function chk_chk14(){
  global $xoopsDB;
  $sql="select count(`base_color`) from ".$xoopsDB->prefix("tad_themes");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}


function go_update14(){
  global $xoopsDB;
  $sql="ALTER TABLE ".$xoopsDB->prefix("tad_themes")."
  ADD `base_color` varchar(255) NOT NULL default 'transparent' COMMENT '頁面內容背景色'  after `crb_width`;
  ";
  $xoopsDB->queryF($sql);
}

//新增 navbar_img 欄位
function chk_chk15(){
  global $xoopsDB;
  $sql="select count(`navbar_img`) from ".$xoopsDB->prefix("tad_themes");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}


function go_update15(){
  global $xoopsDB;
  $sql="ALTER TABLE ".$xoopsDB->prefix("tad_themes")."
  ADD `navbar_img` varchar(255) NOT NULL default 'transparent' COMMENT 'navbar背景圖'  after `navbar_icon`;
  ";
  $xoopsDB->queryF($sql);
}

//新增區塊內容設定欄位
function chk_chk16(){
  global $xoopsDB;
  $sql="select count(`block_style`) from ".$xoopsDB->prefix("tad_themes_blocks");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}


function go_update16(){
  global $xoopsDB;
  $sql="ALTER TABLE ".$xoopsDB->prefix("tad_themes_blocks")."
  ADD `block_style` text NOT NULL COMMENT '區塊整體樣式',
  ADD `block_title_style` text NOT NULL COMMENT '區塊標題區樣式',
  ADD `block_content_style` text NOT NULL COMMENT '區塊內容區樣式';
  ";
  $xoopsDB->queryF($sql);

  $sql="update ".$xoopsDB->prefix("tad_themes_blocks")." set block_title_style='border:none;height:40px;line-height:40px;margin-bottom:10px;'";
  $xoopsDB->queryF($sql);
}



//建立目錄
function mk_dir($dir=""){
    //若無目錄名稱秀出警告訊息
    if(empty($dir))return;
    //若目錄不存在的話建立目錄
    if (!is_dir($dir)) {
        umask(000);
        //若建立失敗秀出警告訊息
        mkdir($dir, 0777);
    }
}

//拷貝目錄
function full_copy( $source="", $target=""){
  if ( is_dir( $source ) ){
    @mkdir( $target );
    $d = dir( $source );
    while ( FALSE !== ( $entry = $d->read() ) ){
      if ( $entry == '.' || $entry == '..' ){
        continue;
      }

      $Entry = $source . '/' . $entry;
      if ( is_dir( $Entry ) ) {
        full_copy( $Entry, $target . '/' . $entry );
        continue;
      }
      copy( $Entry, $target . '/' . $entry );
    }
    $d->close();
  }else{
    copy( $source, $target );
  }
}


function rename_win($oldfile,$newfile) {
   if (!rename($oldfile,$newfile)) {
      if (copy ($oldfile,$newfile)) {
         unlink($oldfile);
         return TRUE;
      }
      return FALSE;
   }
   return TRUE;
}

function delete_directory($dirname) {
    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    if (!$dir_handle)
        return false;
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
            else
                delete_directory($dirname.'/'.$file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}

?>
