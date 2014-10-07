<?php
include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFilesSlide=new TadUpFiles("tad_themes","/{$xoopsConfig['theme_set']}/slide",NULL,"","/thumbs");
$TadUpFilesSlide->set_thumb("100px","60px","#000","center center","no-repeat","contain");

$TadUpFilesBg=new TadUpFiles("tad_themes","/{$xoopsConfig['theme_set']}/bg",NULL,"","/thumbs");
$TadUpFilesBg->set_thumb("100px","60px","#000","center center","no-repeat","contain");

$TadUpFilesLogo=new TadUpFiles("tad_themes","/{$xoopsConfig['theme_set']}/logo",NULL,"","/thumbs");
$TadUpFilesLogo->set_thumb("100px","60px","#000","center center","no-repeat","contain");

$TadUpFilesNavLogo=new TadUpFiles("tad_themes","/{$xoopsConfig['theme_set']}/navlogo",NULL,"","/thumbs");
$TadUpFilesNavLogo->set_thumb("100px","60px","#000","center center","no-repeat","contain");

$TadUpFilesNavBg=new TadUpFiles("tad_themes","/{$xoopsConfig['theme_set']}/nav_bg",NULL,"","/thumbs");
$TadUpFilesNavBg->set_thumb("100px","60px","#000","center center","no-repeat","contain");

$TadUpFilesBt_bg=new TadUpFiles("tad_themes","/{$xoopsConfig['theme_set']}/bt_bg",NULL,"","/thumbs");
$TadUpFilesBt_bg->set_thumb("100px","60px","#000","center center","no-repeat","contain");

$TadUpFiles_config2=new TadUpFiles("tad_themes","/{$xoopsConfig['theme_set']}/config2",NULL,"","/thumbs");
$TadUpFiles_config2->set_thumb("100px","60px","#000","center center","no-repeat","contain");



//自動存入佈景
function auto_import_theme(){
  global $xoopsDB,$xoopsConfig;
  if(empty($xoopsConfig['theme_set']))return;
  $theme_name=$xoopsConfig['theme_set'];
  if(!file_exists(XOOPS_ROOT_PATH."/themes/{$theme_name}/config.php")){
    return;
  }

  include_once XOOPS_ROOT_PATH."/themes/{$theme_name}/config.php";
  foreach($config_enable as $k=>$v){
    $$k=$v['default'];
  }

  $bg_img=!empty($bg_img)?XOOPS_URL."/uploads/tad_themes/{$theme_name}/bg/{$bg_img}":"";
  $logo_img=!empty($logo_img)?XOOPS_URL."/uploads/tad_themes/{$theme_name}/logo/{$logo_img}":"";
  $navlogo_img=!empty($navlogo_img)?XOOPS_URL."/uploads/tad_themes/{$theme_name}/navlogo/{$navlogo_img}":"";
  $navbar_img=!empty($navbar_img)?XOOPS_URL."/uploads/tad_themes/{$theme_name}/nav_bg/{$navbar_img}":"";
  $theme_type=empty($theme_type)?"theme_type_2":$theme_type;

  $logo_top=intval($logo_top);
  $logo_right=intval($logo_right);
  $logo_bottom=intval($logo_bottom);
  $logo_left=intval($logo_left);

  //此處增加7+4項by hc
  $sql = "insert into ".$xoopsDB->prefix("tad_themes")."
  (`theme_name` , `theme_type` , `theme_width` , `lb_width` , `rb_width` , `clb_width` , `crb_width` , `base_color` , `lb_color` , `cb_color` , `rb_color` , `margin_top` , `margin_bottom` , `bg_img` , `bg_color`  , `bg_repeat`  , `bg_attachment`  , `bg_position`  , `logo_img`  , `logo_position`  , `navlogo_img` , `logo_top` , `logo_right` , `logo_bottom` , `logo_left` , `theme_enable` , `slide_width` , `slide_height` , `font_size` , `font_color` , `link_color` , `hover_color` , `theme_kind` , `navbar_pos` , `navbar_bg_top` , `navbar_bg_bottom` , `navbar_hover` , `navbar_color` , `navbar_color_hover` , `navbar_icon`, `navbar_img`)
  values('{$theme_name}' , '{$theme_type}', '{$theme_width}' , '{$lb_width}' , '{$rb_width}' , '{$clb_width}' , '{$crb_width}' , '{$base_color}' , '{$lb_color}' , '{$cb_color}' , '{$rb_color}' , '{$margin_top}' , '{$margin_bottom}' , '{$bg_img}' , '{$bg_color}' , '{$bg_repeat}' , '{$bg_attachment}' , '{$bg_position}' , '{$logo_img}', '{$logo_position}' , '{$navlogo_img}' , '{$logo_top}' , '{$logo_right}' , '{$logo_bottom}' , '{$logo_left}' , '1' , '{$slide_width}' , '{$slide_height}' , '{$font_size}' , '{$font_color}' , '{$link_color}' , '{$hover_color}' , '{$theme_kind}', '{$navbar_pos}','{$navbar_bg_top}','{$navbar_bg_bottom}','{$navbar_hover}','{$navbar_color}','{$navbar_color_hover}','{$navbar_icon}','{$navbar_img}')";
  $xoopsDB->queryF($sql) or die($sql."<br>".mysql_error());

  //取得最後新增資料的流水編號
  $theme_id=$xoopsDB->getInsertId();

  //儲存區塊設定
  save_blocks($theme_id,true);
  save_config2($theme_id,true);
  header("location:".$_SERVER['PHP_SELF']);
}



//儲存區塊設定
function save_blocks($theme_id="",$import=false){
  global $TadUpFilesBt_bg,$xoopsDB,$block_position_title,$xoopsConfig;

  $theme_name=$xoopsConfig['theme_set'];
  if(file_exists(XOOPS_ROOT_PATH."/themes/{$theme_name}/config.php")){
    include XOOPS_ROOT_PATH."/themes/{$theme_name}/config.php";
  }

  $bt_bg_img=!empty($bt_bg_img)?XOOPS_URL."/uploads/tad_themes/{$theme_name}/bt_bg/{$bt_bg_img}":"";


  if($import){
    foreach($block_position_title as $position=>$title){

      if(isset($config_enable['bt_bg_img'][$position])){
        $bt_bg_img_arr[$position]=!empty($config_enable['bt_bg_img'][$position]['default'])?XOOPS_URL."/uploads/tad_themes/{$theme_name}/bt_bg/{$config_enable['bt_bg_img'][$position]['default']}":"";
      }else{
        $bt_bg_img_arr[$position]=!empty($config_enable['bt_bg_img']['default'])?XOOPS_URL."/uploads/tad_themes/{$theme_name}/bt_bg/{$config_enable['bt_bg_img']['default']}":"";
      }

      $block_config_arr[$position]=isset($config_enable['block_config'][$position])?$config_enable['block_config'][$position]['default']:$config_enable['block_config']['default'];
      $bt_text_arr[$position]=isset($config_enable['bt_text'][$position])?$config_enable['bt_text'][$position]['default']:$config_enable['bt_text']['default'];
      $bt_text_padding_arr[$position]=isset($config_enable['bt_text_padding'][$position])?$config_enable['bt_text_padding'][$position]['default']:$config_enable['bt_text_padding']['default'];
      $bt_text_size_arr[$position]=isset($config_enable['bt_text_size'][$position])?$config_enable['bt_text_size'][$position]['default']:$config_enable['bt_text_size']['default'];
      $bt_bg_color_arr[$position]=isset($config_enable['bt_bg_color'][$position])?$config_enable['bt_bg_color'][$position]['default']:$config_enable['bt_bg_color']['default'];
      $bt_bg_repeat_arr[$position]=isset($config_enable['bt_bg_repeat'][$position])?$config_enable['bt_bg_repeat'][$position]['default']:$config_enable['bt_bg_repeat']['default'];
      $bt_radius_arr[$position]=isset($config_enable['bt_radius'][$position])?$config_enable['bt_radius'][$position]['default']:$config_enable['bt_radius']['default'];
      $block_style_arr[$position]=isset($config_enable['block_style'][$position])?$config_enable['block_style'][$position]['default']:$config_enable['block_style']['default'];
      $block_title_style_arr[$position]=isset($config_enable['block_title_style'][$position])?$config_enable['block_title_style'][$position]['default']:$config_enable['block_title_style']['default'];
      $block_content_style_arr[$position]=isset($config_enable['block_content_style'][$position])?$config_enable['block_content_style'][$position]['default']:$config_enable['block_content_style']['default'];
    }

  }elseif(!empty($_POST['apply_to_all'])){
    $apply_to_all_position=$_POST['apply_to_all'];
    foreach($block_position_title as $position=>$title){
      $block_config_arr[$position]=$_POST['block_config'][$apply_to_all_position];
      $bt_text_arr[$position]=$_POST['bt_text'][$apply_to_all_position];
      $bt_text_padding_arr[$position]=$_POST['bt_text_padding'][$apply_to_all_position];
      $bt_text_size_arr[$position]=$_POST['bt_text_size'][$apply_to_all_position];
      $bt_bg_color_arr[$position]=$_POST['bt_bg_color'][$apply_to_all_position];
      $bt_bg_img_arr[$position]=$_POST['bt_bg_img'][$apply_to_all_position];
      $bt_bg_repeat_arr[$position]=$_POST['bt_bg_repeat'][$apply_to_all_position];
      $bt_radius_arr[$position]=$_POST['bt_radius'][$apply_to_all_position];
      $block_style_arr[$position]=$_POST['block_style'][$apply_to_all_position];
      $block_title_style_arr[$position]=$_POST['block_title_style'][$apply_to_all_position];
      $block_content_style_arr[$position]=$_POST['block_content_style'][$apply_to_all_position];
    }
  }else{
    foreach($block_position_title as $position=>$title){
      $block_config_arr[$position]=$_POST['block_config'][$position];
      $bt_text_arr[$position]=$_POST['bt_text'][$position];
      $bt_text_padding_arr[$position]=$_POST['bt_text_padding'][$position];
      $bt_text_size_arr[$position]=$_POST['bt_text_size'][$position];
      $bt_bg_color_arr[$position]=$_POST['bt_bg_color'][$position];
      $bt_bg_img_arr[$position]=$_POST['bt_bg_img'][$position];
      $bt_bg_repeat_arr[$position]=$_POST['bt_bg_repeat'][$position];
      $bt_radius_arr[$position]=$_POST['bt_radius'][$position];
      $block_style_arr[$position]=$_POST['block_style'][$position];
      $block_title_style_arr[$position]=$_POST['block_title_style'][$position];
      $block_content_style_arr[$position]=$_POST['block_content_style'][$position];
    }
  }

  foreach($block_position_title as $position=>$title){
    $block_config=$block_config_arr[$position];
    $bt_text=$bt_text_arr[$position];
    $bt_text_padding=$bt_text_padding_arr[$position];
    $bt_text_size=$bt_text_size_arr[$position];
    $bt_bg_color=$bt_bg_color_arr[$position];
    $bt_bg_img=$bt_bg_img_arr[$position];
    $bt_bg_repeat=$bt_bg_repeat_arr[$position];
    $bt_radius=$bt_radius_arr[$position];
    $block_style=$block_style_arr[$position];
    $block_title_style=$block_title_style_arr[$position];
    $block_content_style=$block_content_style_arr[$position];

    $bt_text_padding=intval($bt_text_padding);
    $bt_bg_repeat=intval($bt_bg_repeat);
    $bt_radius=intval($bt_radius);

    $sql = "replace into ".$xoopsDB->prefix("tad_themes_blocks")."  (`theme_id` , `block_position` , `block_config` , `bt_text` , `bt_text_padding` , `bt_text_size` , `bt_bg_color` , `bt_bg_img` , `bt_bg_repeat` , `bt_radius`, `block_style`, `block_title_style`, `block_content_style`) values('{$theme_id}' , '{$position}' , '{$block_config}' , '{$bt_text}' , '{$bt_text_padding}' , '{$bt_text_size}' , '{$bt_bg_color}' , '{$bt_bg_img}' , '{$bt_bg_repeat}' , '{$bt_radius}' , '{$block_style}' , '{$block_title_style}' , '{$block_content_style}')";

    $xoopsDB->queryF($sql) or die($sql."<br>".mysql_error());

    //if($import)import_img(_THEME_BT_BG_PATH,"bt_bg_{$position}",$theme_id);

    $TadUpFilesBt_bg->set_col("bt_bg_{$position}",$theme_id);
    $TadUpFilesBt_bg->upload_file("bt_bg_{$position}",NULL,NULL,NULL,"",true);
  }
}


//儲存額外設定值
function save_config2($theme_id="",$import=false){
  global $xoopsDB,$TadUpFiles_config2,$xoopsConfig;

  $theme_name=$xoopsConfig['theme_set'];
  //額外佈景設定
  if(file_exists(XOOPS_ROOT_PATH."/themes/{$theme_name}/config2.php")){
    include_once XOOPS_ROOT_PATH."/themes/{$theme_name}/language/{$xoopsConfig['language']}/main.php";
    include_once XOOPS_ROOT_PATH."/themes/{$theme_name}/config2.php";
    /*
    $theme_config[$i]['name']="footer_height";
    $theme_config[$i]['text']=TF_FOOTER_HEIGHT;
    $theme_config[$i]['type']="text";
    $theme_config[$i]['default']="200px";
    */
    $myts =& MyTextSanitizer::getInstance();
    foreach($theme_config as $k=>$config){
      $name=$config['name'];
      $value=isset($_POST[$name])?$myts->addSlashes($_POST[$name]):$config['default'];

      $sql="replace into ".$xoopsDB->prefix("tad_themes_config2")." (`theme_id`, `name`, `type`, `value`) values($theme_id , '{$config['name']}' , '{$config['type']}' , '{$value}')";
      $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error()."<br>".$sql);

      if($config['type']=="file"){
        $TadUpFiles_config2->set_col("config2_{$config['name']}",$theme_id);
        $TadUpFiles_config2->upload_file("config2_{$config['name']}",NULL,NULL,NULL,"",true);
      }
    }
  }
}
?>