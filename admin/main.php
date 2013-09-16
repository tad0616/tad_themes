<?php
//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2011-12-31
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "tad_themes_adm_main_tpl.html";
include_once "header.php";
include_once "../function.php";

include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
$TadUpFilesSlide=new TadUpFiles("tad_themes","/{$xoopsConfig['theme_set']}/slide",NULL,"","/thumbs");
$TadUpFilesSlide->set_thumb("100px","60px","#000","center center","no-repeat","contain");

$TadUpFilesBg=new TadUpFiles("tad_themes","/{$xoopsConfig['theme_set']}/bg",NULL,"","/thumbs");
$TadUpFilesBg->set_thumb("100px","60px","#000","center center","no-repeat","contain");

$TadUpFilesLogo=new TadUpFiles("tad_themes","/{$xoopsConfig['theme_set']}/logo",NULL,"","/thumbs");
$TadUpFilesLogo->set_thumb("100px","60px","#000","center center","no-repeat","contain");

$TadUpFilesBt_bg=new TadUpFiles("tad_themes","/{$xoopsConfig['theme_set']}/bt_bg",NULL,"","/thumbs");
$TadUpFilesBt_bg->set_thumb("100px","60px","#000","center center","no-repeat","contain");

//$path=$TadUpFilesLogo->get_path();
//die(var_export($path));

$SlidePath=$TadUpFilesSlide->get_path('image');
$BgPath=$TadUpFilesBg->get_path('image');
$LogoPath=$TadUpFilesLogo->get_path('image');
$Bt_bgPath=$TadUpFilesBt_bg->get_path('image');

define("_THEME_BG_PATH",XOOPS_ROOT_PATH."/themes/{$xoopsConfig['theme_set']}/images/bg");
define("_THEME_BG_URL",XOOPS_URL."/themes/{$xoopsConfig['theme_set']}/images/bg");
define("_THEME_UPLOADS_BG_PATH",$BgPath['dir']);
define("_THEME_UPLOADS_BG_URL",$BgPath['url']);
define("_THEME_LOGO_PATH",XOOPS_ROOT_PATH."/themes/{$xoopsConfig['theme_set']}/images/logo");
define("_THEME_LOGO_URL",XOOPS_URL."/themes/{$xoopsConfig['theme_set']}/images/logo");
define("_THEME_UPLOADS_LOGO_PATH",$LogoPath['dir']);
define("_THEME_UPLOADS_LOGO_URL",$LogoPath['url']);
define("_THEME_UPLOADS_SLIDE_PATH",$SlidePath['dir']);
define("_THEME_UPLOADS_SLIDE_URL",$SlidePath['url']);
// 增加區塊標題背景圖用路徑by hc
define("_THEME_BT_BG_PATH",XOOPS_ROOT_PATH."/themes/{$xoopsConfig['theme_set']}/images/bt_bg");
define("_THEME_BT_BG_URL",XOOPS_URL."/themes/{$xoopsConfig['theme_set']}/images/bt_bg");
define("_THEME_UPLOADS_BT_BG_PATH",$Bt_bgPath['dir']);
define("_THEME_UPLOADS_BT_BG_URL",$Bt_bgPath['url']);



/*-----------function區--------------*/

//tad_themes編輯表單
function tad_themes_form(){
	global $xoopsDB,$xoopsUser,$xoopsConfig ,$xoopsTpl,$TadUpFilesSlide,$TadUpFilesBg,$TadUpFilesLogo,$TadUpFilesBt_bg;

	//抓取預設值
	$DBV=get_tad_themes();
	if(empty($DBV)){
		$DBV=array();
	}

	//預設值設定


	//設定「theme_id」欄位預設值
	$theme_id=(!isset($DBV['theme_id']))?0:$DBV['theme_id'];

	//設定「theme_name」欄位預設值
	$theme_name=(!isset($DBV['theme_name']))?$xoopsConfig['theme_set']:$DBV['theme_name'];

	if(file_exists(XOOPS_ROOT_PATH."/themes/{$theme_name}/config.php")){
    include_once XOOPS_ROOT_PATH."/themes/{$theme_name}/config.php";
  }else{
    return sprintf(_MA_TAD_THEMES_NOT_TAD_THEME,$theme_name,XOOPS_ROOT_PATH."/themes/{$theme_name}/config.php");
  }
	mk_dir(XOOPS_ROOT_PATH."/uploads/tad_themes/{$theme_name}");
	mk_dir(XOOPS_ROOT_PATH."/uploads/tad_themes/{$theme_name}/bg");
	mk_dir(XOOPS_ROOT_PATH."/uploads/tad_themes/{$theme_name}/slide");
	mk_dir(XOOPS_ROOT_PATH."/uploads/tad_themes/{$theme_name}/logo");
	mk_dir(XOOPS_ROOT_PATH."/uploads/tad_themes/{$theme_name}/bg/thumbs");
	mk_dir(XOOPS_ROOT_PATH."/uploads/tad_themes/{$theme_name}/slide/thumbs");
	mk_dir(XOOPS_ROOT_PATH."/uploads/tad_themes/{$theme_name}/logo/thumbs");
	//增加區塊標題背景圖用路徑by hc
	mk_dir(XOOPS_ROOT_PATH."/uploads/tad_themes/{$theme_name}/bt_bg");
	mk_dir(XOOPS_ROOT_PATH."/uploads/tad_themes/{$theme_name}/bt_bg/thumbs");

	
	//設定「theme_type」欄位預設值
	$theme_type=(!isset($DBV['theme_type']))?"theme_type_1":$DBV['theme_type'];

	//設定「lb_width」欄位預設值
	$lb_width=(!isset($DBV['lb_width']))?$theme_left_width:$DBV['lb_width'];

	//設定「rb_width」欄位預設值
	$rb_width=(!isset($DBV['rb_width']))?$theme_right_width:$DBV['rb_width'];

	//設定「clb_width」欄位預設值
	$clb_width=(!isset($DBV['clb_width']))?"49%":$DBV['clb_width'];

	//設定「crb_width」欄位預設值
	$crb_width=(!isset($DBV['crb_width']))?"49%":$DBV['crb_width'];

  //設定「lb_color」欄位預設值
	$lb_color=(!isset($DBV['lb_color']))?$theme_left_color:$DBV['lb_color'];

  //設定「cb_color」欄位預設值
	$cb_color=(!isset($DBV['cb_color']))?$theme_center_color:$DBV['cb_color'];

  //設定「rb_color」欄位預設值
	$rb_color=(!isset($DBV['rb_color']))?$theme_right_color:$DBV['rb_color'];
	
	//設定「margin_top」欄位預設值
	$margin_top=(!isset($DBV['margin_top']))?"0":$DBV['margin_top'];

  //設定「margin_bottom」欄位預設值
	$margin_bottom=(!isset($DBV['margin_bottom']))?"0":$DBV['margin_bottom'];

	//設定「bg_img」欄位預設值
	$bg_img=(!isset($DBV['bg_img']))?"":$DBV['bg_img'];

	//設定「bg_color」欄位預設值
	$bg_color=(!isset($DBV['bg_color']))?"":$DBV['bg_color'];

	//設定「bg_repeat」欄位預設值
	$bg_repeat=(!isset($DBV['bg_repeat']))?"":$DBV['bg_repeat'];

	//設定「bg_attachment」欄位預設值
	$bg_attachment=(!isset($DBV['bg_attachment']))?"":$DBV['bg_attachment'];

	//設定「bg_position」欄位預設值
	$bg_position=(!isset($DBV['bg_position']))?"":$DBV['bg_position'];

	//設定「logo_img」欄位預設值
	$logo_img=(!isset($DBV['logo_img']))?"":$DBV['logo_img'];
	
	//設定「logo_top」欄位預設值
	$logo_top=(!isset($DBV['logo_top']))?"":$DBV['logo_top'];
	
	//設定「logo_right」欄位預設值
	$logo_right=(!isset($DBV['logo_right']))?"":$DBV['logo_right'];
	
	//設定「logo_bottom」欄位預設值
	$logo_bottom=(!isset($DBV['logo_bottom']))?"":$DBV['logo_bottom'];
	
	//設定「logo_left」欄位預設值
	$logo_left=(!isset($DBV['logo_left']))?"":$DBV['logo_left'];

	//設定「theme_enable」欄位預設值
	$theme_enable=(!isset($DBV['theme_enable']))?"":$DBV['theme_enable'];

	//設定「slide_width」欄位預設值
	$slide_width=(!isset($DBV['slide_width']))?$theme_slide_width:$DBV['slide_width'];

	//設定「slide_height」欄位預設值
	$slide_height=(!isset($DBV['slide_height']))?$theme_slide_height:$DBV['slide_height'];

	//設定「font_size」欄位預設值
	$font_size=(!isset($DBV['font_size']))?'11pt':$DBV['font_size'];

	//設定「font_color」欄位預設值
	$font_color=(!isset($DBV['font_color']))?'#111111':$DBV['font_color'];

	//設定「link_color」欄位預設值
	$link_color=(!isset($DBV['link_color']))?'#43597C':$DBV['link_color'];

	//設定「hover_color」欄位預設值
	$hover_color=(!isset($DBV['hover_color']))?'#990000':$DBV['hover_color'];

	//設定「theme_kind」欄位預設值
	$theme_kind=(!isset($DBV['theme_kind']))?$theme_kind:$DBV['theme_kind'];

	//新增區塊標題背景圖設定by hc 開始
	//設定「block_config」欄位預設值
	$block_config=(!isset($DBV['block_config']))?'right':$DBV['block_config'];
	
	//設定「bt_text」欄位預設值
	$bt_text=(!isset($DBV['bt_text']))?'#333333':$DBV['bt_text'];
	
	//設定「bt_text_padding」欄位預設值
	$bt_text_padding=(!isset($DBV['bt_text_padding']))?'33':$DBV['bt_text_padding'];
	
	//設定「bt_bg_color」欄位預設值
	$bt_bg_color=(!isset($DBV['bt_bg_color']))?'#DDEEFF':$DBV['bt_bg_color'];
	
	//設定「bt_bg_img」欄位預設值
	$bt_bg_img=(!isset($DBV['bt_bg_img']))?'':$DBV['bt_bg_img'];
	
	//設定「bt_bg_repeat」欄位預設值
	$bt_bg_repeat=(!isset($DBV['bt_bg_repeat']))?'0':$DBV['bt_bg_repeat'];
	
	//設定「bt_radius」欄位預設值
	$bt_radius=(!isset($DBV['bt_radius']))?'0':$DBV['bt_radius'];
	//新增區塊標題背景圖設定by hc 結束
	
	//新增navbar設定by hc 開始
	//設定「navbar_pos」欄位預設值
	$navbar_pos=(!isset($DBV['navbar_pos']))?'not-use':$DBV['navbar_pos'];
	
	//設定「navbar_bg_top」欄位預設值
	$navbar_bg_top=(!isset($DBV['navbar_bg_top']))?'#54b4eb':$DBV['navbar_bg_top'];
	
	//設定「navbar_bg_bottom」欄位預設值
	$navbar_bg_bottom=(!isset($DBV['navbar_bg_bottom']))?'#2fa4e7':$DBV['navbar_bg_bottom'];
	
	//設定「navbar_hover」欄位預設值
	$navbar_hover=(!isset($DBV['navbar_hover']))?'#1684c2':$DBV['navbar_hover'];
	//新增navbar設定by hc 結束
	
	$op=(empty($theme_id))?"insert_tad_themes":"update_tad_themes";
	//$op="replace_tad_themes";

  if($theme_kind=='bootstrap'){
    $theme_kind_txt=_MA_TADTHEMES_THEME_KIND_BOOTSTRAP;
    $chang_css=change_css_bootstrap($theme_width,$theme_left_width);
    $theme_unit=_MA_TADTHEMES_COL;
    $margin_setup="
    <input type='hidden' name='margin_top' value='0' id='margin_top' >
    <input type='hidden' name='margin_bottom'  value='0' id='margin_bottom'>";
    
    $use_slide="
    <div class='row-fluid'> 
      <!--是否使用滑動圖片 -->
      <div class='span2 text-right'>
        "._MA_TADTHEMES_SLIDE_ENABLE."
      </div>       
      <div class='span10'>
        <label class='radio inline'>
          <input type='radio' name='slide_h' value='300' onClick=\"$('#slide_height').val(300);change_css();\" ".chk($slide_height,300,1).">"._YES."
        </label>
        
        <label class='radio inline'>
          <input type='radio' name='slide_h' value='0'  onClick=\"$('#slide_height').val(0);change_css();\" ".chk($slide_height,0,0).">"._NO."
        </label>
        
        <input type='hidden' name='slide_height' id='slide_height' value='$slide_height'>
      </div>
    </div>
    ";
  }else{
    $theme_kind_txt=_MA_TADTHEMES_THEME_KIND_HTML;
    $chang_css=change_css($theme_width,$theme_left_width);
    $theme_unit="px";
    $margin_setup="
      <div class='row-fluid'>
        <!--離上邊界距離-->
        <div class='span2 text-right'>"._MA_TADTHEMES_MARGIN_TOP."</div>       
        <div class='span4'>
          <input type='text' name='margin_top' class='span6' value='{$margin_top}' id='margin_top'  onChange='change_css();'>px
        </div>
        
        <!--離下邊界距離-->
        <div class='span2 text-right'>"._MA_TADTHEMES_MARGIN_BOTTOM."</div>       
        <div class='span4'>
          <input type='text' name='margin_bottom' class='span6' value='{$margin_bottom}' id='margin_bottom'  onChange='change_css();'>px
        </div>
      </div>      
    ";
    
    $use_slide="    
    <div class='row-fluid'> 
      <!--是否使用滑動圖片 -->
      <div class='span2 text-right'>
        "._MA_TADTHEMES_SLIDE_HEIGHT."
      </div>       
      <div class='span10'>
        <input type='text' name='slide_height' class='span6' value='{$slide_height}' id='slide_height' onChange='change_css();'>
      </div>
    </div>
    ";
  }



	if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
   redirect_header("index.php",3, _MA_NEED_TADTOOLS);
  }
  include_once TADTOOLS_PATH."/formValidator.php";
  $formValidator= new formValidator("#myForm",true);
  $formValidator_code=$formValidator->render();


  $xoopsTpl->assign('theme_name',$theme_name);
  $xoopsTpl->assign('formValidator_code',$formValidator_code);
  $xoopsTpl->assign('bg_img',$bg_img); 
  $xoopsTpl->assign('chang_css',$chang_css);
  $xoopsTpl->assign('theme_kind',$theme_kind);
  $xoopsTpl->assign('theme_kind_txt',$theme_kind_txt);
  $xoopsTpl->assign('theme_type',$theme_type);
  $xoopsTpl->assign('lb_width',$lb_width);
  $xoopsTpl->assign('theme_unit',$theme_unit);
  $xoopsTpl->assign('lb_color',$lb_color);
  $xoopsTpl->assign('cb_color',$cb_color);
  $xoopsTpl->assign('rb_width',$rb_width);
  $xoopsTpl->assign('rb_color',$rb_color);
  $xoopsTpl->assign('margin_setup',$margin_setup);
  $xoopsTpl->assign('font_size',$font_size);
  $xoopsTpl->assign('font_color',$font_color);
  $xoopsTpl->assign('link_color',$link_color);
  $xoopsTpl->assign('hover_color',$hover_color);
  $xoopsTpl->assign('get_bg_img1',get_img(_THEME_BG_PATH,_THEME_BG_URL,$bg_img,"bg",$theme_id));
  $xoopsTpl->assign('get_bg_img2',get_img(_THEME_UPLOADS_BG_PATH,_THEME_UPLOADS_BG_URL,$bg_img,"bg",$theme_id));
  $xoopsTpl->assign('upform_bg',$TadUpFilesBg->upform(false,"bg",NULL,false));
  $xoopsTpl->assign('bg_color',$bg_color);
  $xoopsTpl->assign('bg_repeat',$bg_repeat);
  $xoopsTpl->assign('bg_attachment',$bg_attachment);
  $xoopsTpl->assign('bg_position',$bg_position);
  
  $TadUpFilesBg->set_col("bg",$theme_id);  
  $xoopsTpl->assign('list_del_file_bg',$TadUpFilesBg->list_del_file());
  $xoopsTpl->assign('use_slide',$use_slide);
  
  $TadUpFilesSlide->set_col("slide",$theme_id);  
  $xoopsTpl->assign('upform_slide',$TadUpFilesSlide->upform(true,"slide",NULL,true));  
  //$xoopsTpl->assign('get_slide_img',get_img(_THEME_UPLOADS_SLIDE_PATH,_THEME_UPLOADS_SLIDE_URL,null,"slide",$theme_id,$slide_width,false));
  
  //$xoopsTpl->assign('list_del_file_slide',$TadUpFiles->list_del_file(true)); 
  //echo _THEME_UPLOADS_LOGO_PATH."<br>";
  //echo _THEME_UPLOADS_LOGO_URL."<br>";
  
  $xoopsTpl->assign('get_logo_img1',get_img(_THEME_UPLOADS_LOGO_PATH,_THEME_UPLOADS_LOGO_URL,$logo_img,"logo",$theme_id));
  $xoopsTpl->assign('get_logo_img2',get_img(_THEME_LOGO_PATH,_THEME_LOGO_URL,$logo_img,"logo",$theme_id));

  $xoopsTpl->assign('upform_logo',$TadUpFilesLogo->upform(false,"logo",NULL,false)); 
  
  $xoopsTpl->assign('logo_top',$logo_top);
  $xoopsTpl->assign('logo_left',$logo_left);
  $xoopsTpl->assign('logo_right',$logo_right);
  $xoopsTpl->assign('logo_bottom',$logo_bottom);
  
  $TadUpFilesLogo->set_col("logo",$theme_id);  
  $xoopsTpl->assign('list_del_file_logo',$TadUpFilesLogo->list_del_file());  
  
  $xoopsTpl->assign('get_bt_bg_img1',get_img(_THEME_BT_BG_PATH,_THEME_BT_BG_URL,$bt_bg_img,"bt_bg",$theme_id));  
  $xoopsTpl->assign('get_bt_bg_img2',get_img(_THEME_UPLOADS_BT_BG_PATH,_THEME_UPLOADS_BT_BG_URL,$bt_bg_img,"bt_bg",$theme_id));  
  $xoopsTpl->assign('bt_bg_repeat',$bt_bg_repeat);
  $xoopsTpl->assign('bt_text_padding',$bt_text_padding);
  $xoopsTpl->assign('bt_text',$bt_text);
  $xoopsTpl->assign('bt_bg_color',$bt_bg_color);
  $xoopsTpl->assign('block_config',$block_config);
  $xoopsTpl->assign('bt_radius',$bt_radius);
  
  $xoopsTpl->assign('upform_bt_bg',$TadUpFilesBt_bg->upform(false,"bt_bg",NULL,false)); 
  $TadUpFilesBt_bg->set_col("bt_bg",$theme_id);
  $xoopsTpl->assign('list_del_file_bt_bg',$TadUpFilesBt_bg->list_del_file());
  $xoopsTpl->assign('navbar_pos',$navbar_pos);
  $xoopsTpl->assign('navbar_bg_top',$navbar_bg_top);
  $xoopsTpl->assign('navbar_bg_bottom',$navbar_bg_bottom);
  $xoopsTpl->assign('navbar_hover',$navbar_hover);
  $xoopsTpl->assign('clb_width',$clb_width);
  $xoopsTpl->assign('crb_width',$crb_width);
  $xoopsTpl->assign('theme_id',$theme_id);
  $xoopsTpl->assign('theme_name',$theme_name);
  $xoopsTpl->assign('slide_width',$slide_width);
  $xoopsTpl->assign('op',$op);

}


function change_css_bootstrap($theme_width="",$theme_left_width=""){

  $main="
  function change_css(){
    //原始頁寬，如:12
    var theme_width_org = {$theme_width};
    //模擬頁寬
    var theme_width = Math.round(theme_width_org * 80/4);
    //模擬視窗寬
    var preview_width = Math.round(theme_width_org * 80/2);
    //模擬區之外框寬
    var theme_div_width= theme_width+11;

    //滑動圖文框原始高
    var slide_height_org = $('#slide_height').val();
    //滑動圖文框模擬高
    var slide_height= Math.round(slide_height_org/4);

    //模擬區之外框高
    var theme_div_height=230+slide_height;

    var theme_margin_top_org = $('#margin_top').val();
    var theme_margin_top= Math.round(theme_margin_top_org/4);
    var theme_margin_bottom_org = $('#margin_bottom').val();
    var theme_margin_bottom= Math.round(theme_margin_bottom_org/4);

    //$('#preview_zone').css('width',preview_width+'px');
    $('#preview_zone').css('background-color',$('#bg_color').val());
    $('#preview_zone').css('background-repeat',$('#bg_repeat').val());
    $('#preview_zone').css('background-attachment',$('#bg_attachment').val());
    $('#preview_zone').css('background-position',$('#bg_position').val());

    $('#left_block').css('background-color',$('#lb_color').val()).css('color',$('#font_color').val());
    $('#center_block').css('background-color',$('#cb_color').val()).css('color',$('#font_color').val());
    $('#right_block').css('background-color',$('#rb_color').val()).css('color',$('#font_color').val());
    $('#theme_head').css('color',$('#link_color').val()).hover( function () {
      $(this).css('color',$('#hover_color').val());
    },function () {
      $(this).css('color',$('#link_color').val());
    });
    $('#theme_foot').css('color',$('#link_color').val()).hover( function () {
      $(this).css('color',$('#hover_color').val());
    },function () {
      $(this).css('color',$('#link_color').val());
    });



    $('#theme_demo').css('width',theme_div_width+'px').css('height',theme_div_height+'px').css('margin-top',theme_margin_top+'px').css('margin-bottom',theme_margin_bottom+'px');
    $('#theme_head').css('width',theme_width+'px').css('height',slide_height+'px').css('line-height',slide_height+'px');
    $('#theme_foot').css('width',theme_width+'px');

    var theme_type=$('#theme_type').val();

    if(theme_type!='theme_type_8'){
      if($('#lb_width').val()==theme_width_org){
        $('#lb_width').val({$theme_left_width});
      }
      if($('#rb_width').val()==theme_width_org){
        $('#rb_width').val({$theme_left_width});
      }
    }

    if(theme_type=='theme_type_1'){
      $('#lb_width').attr('readonly',false);
      $('#rb_width').val($('#lb_width').val()).attr('readonly','readonly');
    }else if(theme_type=='theme_type_2'){
      $('#lb_width').attr('readonly',false);
      $('#rb_width').val($('#lb_width').val()).attr('readonly','readonly');
    }else if(theme_type=='theme_type_3'){
      $('#lb_width').attr('readonly',false);
      $('#rb_width').val({$theme_width}).attr('readonly','readonly');
    }else if(theme_type=='theme_type_4'){
      $('#lb_width').attr('readonly',false);
      $('#rb_width').val({$theme_width}).attr('readonly','readonly');
    }else if(theme_type=='theme_type_5' || theme_type=='theme_type_6' || theme_type=='theme_type_7' ){
      $('#lb_width').attr('readonly',false);
      $('#rb_width').attr('readonly',false);
    }else if(theme_type=='theme_type_8'){
      $('#lb_width').val(theme_width_org).attr('readonly','readonly');
      $('#rb_width').val(theme_width_org).attr('readonly','readonly');
    }else{
      $('#lb_width').attr('readonly',false);
      $('#rb_width').attr('readonly',false);
    }

    //左區塊原始寬
    var lb_width_org=$('#lb_width').val()*1;
    //左區塊模擬寬
    var lb_width=Math.round(lb_width_org * 80/4)-3;
    //右區塊原始寬
    var rb_width_org=$('#rb_width').val()*1;
    //右區塊模擬寬
    var rb_width=Math.round(rb_width_org * 80 /4)-3;
    //中間區塊原始寬
    var center_width_org={$theme_width} - $('#lb_width').val()*1;
    //中間區塊模擬寬
    var center_width=Math.round(center_width_org * 80 /4)-3;


    if(theme_type=='theme_type_1'){
      $('#left_block').css('float','left').css('margin','2px 2px 2px 4px').css('width',lb_width).css('height','86px').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_LEFT." '+ lb_width_org +'"._MA_TADTHEMES_COL."</div>');
      $('#center_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',center_width).css('height','178px').css('line-height','178px').html('"._MA_TAD_THEMES_CENTER." '+center_width_org+'"._MA_TADTHEMES_COL."');
      $('#right_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',rb_width).css('height','86px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_RIGHT." '+rb_width_org+'"._MA_TADTHEMES_COL."</div>');
    $('#cb_width').html(center_width_org+'"._MA_TADTHEMES_COL."');

    }else if(theme_type=='theme_type_2'){
      $('#left_block').css('float','right').css('margin','2px 4px 2px 2px').css('width',lb_width).css('height','86px').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_LEFT." '+ lb_width_org +'"._MA_TADTHEMES_COL."</div>');
      $('#center_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',center_width).css('height','178px').css('line-height','178px').html('"._MA_TAD_THEMES_CENTER." '+center_width_org+'"._MA_TADTHEMES_COL."');
      $('#right_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',rb_width).css('height','86px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_RIGHT." '+rb_width_org+'"._MA_TADTHEMES_COL."</div>');
    $('#cb_width').html(center_width_org+'"._MA_TADTHEMES_COL."');


    }else if(theme_type=='theme_type_3'){
      $('#left_block').css('float','left').css('margin','2px 2px 2px 4px').css('width',lb_width).css('height','132px').html('<div style=\'line-height:12px;margin-top:60px;\'>"._MA_TAD_THEMES_LEFT." '+ lb_width_org +'"._MA_TADTHEMES_COL."</div>');
      $('#center_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',center_width).css('height','132px').css('line-height','132px').html('"._MA_TAD_THEMES_CENTER." '+center_width_org+'"._MA_TADTHEMES_COL."');
      $('#right_block').css('float','none').css('margin','2px 2px 4px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('"._MA_TAD_THEMES_RIGHT." '+theme_width_org+'"._MA_TADTHEMES_COL."');
    $('#cb_width').html(center_width_org+'"._MA_TADTHEMES_COL."');


    }else if(theme_type=='theme_type_4'){
      $('#left_block').css('float','right').css('margin','2px 4px 2px 2px').css('width',lb_width).css('height','132px').html('<div style=\'line-height:12px;margin-top:60px;\'>"._MA_TAD_THEMES_LEFT." '+ lb_width_org +'"._MA_TADTHEMES_COL."</div>');
      $('#center_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',center_width).css('height','132px').css('line-height','132px').html('"._MA_TAD_THEMES_CENTER." '+center_width_org+'"._MA_TADTHEMES_COL."');
      $('#right_block').css('float','none').css('margin','2px 2px 4px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('"._MA_TAD_THEMES_RIGHT." '+theme_width_org+'"._MA_TADTHEMES_COL."');
    $('#cb_width').html(center_width_org+'"._MA_TADTHEMES_COL."');


    }else if(theme_type=='theme_type_5'){
      center_width_org=theme_width_org - lb_width_org -rb_width_org;
      center_width=Math.floor(center_width_org * 80 /4)-3;
      $('#left_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_LEFT." '+ lb_width_org +'"._MA_TADTHEMES_COL."</div>');
      $('#center_block').css('float','left').css('margin','2px 0px 4px 0px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_CENTER."<br />'+center_width_org+'"._MA_TADTHEMES_COL."</div>');
      $('#right_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_RIGHT." '+rb_width_org+'"._MA_TADTHEMES_COL."</div>');
    $('#cb_width').html(center_width_org+'"._MA_TADTHEMES_COL."');


    }else if(theme_type=='theme_type_6'){
      center_width_org=theme_width_org - lb_width_org -rb_width_org;
      center_width=Math.floor(center_width_org * 80/4)-3;
      $('#left_block').css('float','left').css('margin','2px 0px 4px 4px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_LEFT." '+ lb_width_org +'"._MA_TADTHEMES_COL."</div>');
      $('#center_block').css('float','right').css('margin','2px 4px 4px 0px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_CENTER."<br />'+center_width_org+'"._MA_TADTHEMES_COL."</div>');
      $('#right_block').css('float','left').css('margin','2px 2px 4px 2px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_RIGHT." '+rb_width_org+'"._MA_TADTHEMES_COL."</div>');
    $('#cb_width').html(center_width_org+'"._MA_TADTHEMES_COL."');


    }else if(theme_type=='theme_type_7'){
      center_width_org=theme_width_org - lb_width_org -rb_width_org;
      center_width=Math.floor(center_width_org * 80/4)-3;
      $('#left_block').css('float','right').css('margin','2px 4px 4px 0px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_LEFT." '+ lb_width_org +'"._MA_TADTHEMES_COL."</div>');
      $('#center_block').css('float','left').css('margin','2px 0px 4px 4px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_CENTER."<br />'+center_width_org+'"._MA_TADTHEMES_COL."</div>');
      $('#right_block').css('float','right').css('margin','2px 2px 4px 2px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_RIGHT." '+rb_width_org+'"._MA_TADTHEMES_COL."</div>');
    $('#cb_width').html(center_width_org+'"._MA_TADTHEMES_COL."');
    
    }else if(theme_type=='theme_type_8'){
      $('#left_block').css('float','none').css('margin','2px 4px 2px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').html('"._MA_TAD_THEMES_LEFT." '+ theme_width_org +'"._MA_TADTHEMES_COL."');
      $('#center_block').css('float','none').css('margin','2px 4px 2px 4px').css('width',theme_width).css('height','90px').css('line-height','100px').html('"._MA_TAD_THEMES_CENTER." '+theme_width_org+'"._MA_TADTHEMES_COL."');
      $('#right_block').css('float','none').css('margin','2px 4px 2px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('"._MA_TAD_THEMES_RIGHT." '+theme_width_org+'"._MA_TADTHEMES_COL."');
    $('#cb_width').html(theme_width_org+'"._MA_TADTHEMES_COL."');

    }
  }";
  return $main;
}


function change_css($theme_width,$theme_left_width){
  $main="
  function change_css(){
    var theme_width_org = $theme_width;
    var theme_width = Math.round(theme_width_org/4);
    var preview_width = Math.round(theme_width_org/2);
    var theme_div_width= theme_width+11;
    var slide_height_org = $('#slide_height').val();
    var slide_height= Math.round(slide_height_org/4);
    var theme_div_height=230+slide_height;
    var theme_margin_top_org = $('#margin_top').val();
    var theme_margin_top= Math.round(theme_margin_top_org/4);
    var theme_margin_bottom_org = $('#margin_bottom').val();
    var theme_margin_bottom= Math.round(theme_margin_bottom_org/4);

    $('#preview_zone').css('width',preview_width+'px');
    $('#preview_zone').css('background-color',$('#bg_color').val());
    $('#preview_zone').css('background-repeat',$('#bg_repeat').val());
    $('#preview_zone').css('background-attachment',$('#bg_attachment').val());
    $('#preview_zone').css('background-position',$('#bg_position').val());

    $('#left_block').css('background-color',$('#lb_color').val()).css('color',$('#font_color').val());
    $('#center_block').css('background-color',$('#cb_color').val()).css('color',$('#font_color').val());
    $('#right_block').css('background-color',$('#rb_color').val()).css('color',$('#font_color').val());
    $('#theme_head').css('color',$('#link_color').val()).hover( function () {
      $(this).css('color',$('#hover_color').val());
    },function () {
      $(this).css('color',$('#link_color').val());
    });
    $('#theme_foot').css('color',$('#link_color').val()).hover( function () {
      $(this).css('color',$('#hover_color').val());
    },function () {
      $(this).css('color',$('#link_color').val());
    });



    $('#theme_demo').css('width',theme_div_width+'px').css('height',theme_div_height+'px').css('margin-top',theme_margin_top+'px').css('margin-bottom',theme_margin_bottom+'px');
    $('#theme_head').css('width',theme_width+'px').css('height',slide_height+'px').css('line-height',slide_height+'px');
    $('#theme_foot').css('width',theme_width+'px');

    var theme_type=$('#theme_type').val();

    if(theme_type!='theme_type_8'){
      if($('#lb_width').val()==theme_width_org){
        $('#lb_width').val($theme_left_width);
      }
      if($('#rb_width').val()==theme_width_org){
        $('#rb_width').val($theme_left_width);
      }
    }

    if(theme_type=='theme_type_1'){
      $('#lb_width').attr('readonly',false);
      $('#rb_width').val($('#lb_width').val()).attr('readonly','readonly');
    }else if(theme_type=='theme_type_2'){
      $('#lb_width').attr('readonly',false);
      $('#rb_width').val($('#lb_width').val()).attr('readonly','readonly');
    }else if(theme_type=='theme_type_3'){
      $('#lb_width').attr('readonly',false);
      $('#rb_width').val($theme_width).attr('readonly','readonly');
    }else if(theme_type=='theme_type_4'){
      $('#lb_width').attr('readonly',false);
      $('#rb_width').val($theme_width).attr('readonly','readonly');
    }else if(theme_type=='theme_type_5' || theme_type=='theme_type_6' || theme_type=='theme_type_7' ){
      $('#lb_width').attr('readonly',false);
      $('#rb_width').attr('readonly',false);
    }else if(theme_type=='theme_type_8'){
      $('#lb_width').val(theme_width_org).attr('readonly','readonly');
      $('#rb_width').val(theme_width_org).attr('readonly','readonly');
    }else{
      $('#lb_width').attr('readonly',false);
      $('#rb_width').attr('readonly',false);
    }

    var lb_width_org=$('#lb_width').val()*1;
    var lb_width=Math.round(lb_width_org/4)-2;
    var rb_width_org=$('#rb_width').val()*1;
    var rb_width=Math.round(rb_width_org/4)-2;
    var center_width_org=$theme_width - $('#lb_width').val()*1 -5;
    var center_width=Math.round(center_width_org/4)-2;


    if(theme_type=='theme_type_1'){
      $('#left_block').css('float','left').css('margin','2px 2px 2px 4px').css('width',lb_width).css('height','86px').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_LEFT." '+ lb_width_org +'px</div>');
      $('#center_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',center_width).css('height','178px').css('line-height','178px').html('"._MA_TAD_THEMES_CENTER." '+center_width_org+'px');
      $('#right_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',rb_width).css('height','86px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_RIGHT." '+rb_width_org+'px</div>');
    $('#cb_width').html(center_width_org+'px');

    }else if(theme_type=='theme_type_2'){
      $('#left_block').css('float','right').css('margin','2px 4px 2px 2px').css('width',lb_width).css('height','86px').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_LEFT." '+ lb_width_org +'px</div>');
      $('#center_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',center_width).css('height','178px').css('line-height','178px').html('"._MA_TAD_THEMES_CENTER." '+center_width_org+'px');
      $('#right_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',rb_width).css('height','86px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_RIGHT." '+rb_width_org+'px</div>');
    $('#cb_width').html(center_width_org+'px');


    }else if(theme_type=='theme_type_3'){
      $('#left_block').css('float','left').css('margin','2px 2px 2px 4px').css('width',lb_width).css('height','132px').html('<div style=\'line-height:12px;margin-top:60px;\'>"._MA_TAD_THEMES_LEFT." '+ lb_width_org +'px</div>');
      $('#center_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',center_width).css('height','132px').css('line-height','132px').html('"._MA_TAD_THEMES_CENTER." '+center_width_org+'px');
      $('#right_block').css('float','none').css('margin','2px 2px 4px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('"._MA_TAD_THEMES_RIGHT." '+theme_width_org+'px');
    $('#cb_width').html(center_width_org+'px');


    }else if(theme_type=='theme_type_4'){
      $('#left_block').css('float','right').css('margin','2px 4px 2px 2px').css('width',lb_width).css('height','132px').html('<div style=\'line-height:12px;margin-top:60px;\'>"._MA_TAD_THEMES_LEFT." '+ lb_width_org +'px</div>');
      $('#center_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',center_width).css('height','132px').css('line-height','132px').html('"._MA_TAD_THEMES_CENTER." '+center_width_org+'px');
      $('#right_block').css('float','none').css('margin','2px 2px 4px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('"._MA_TAD_THEMES_RIGHT." '+theme_width_org+'px');
    $('#cb_width').html(center_width_org+'px');


    }else if(theme_type=='theme_type_5'){
      center_width_org=theme_width_org - lb_width_org -rb_width_org -14;
      center_width=Math.floor(center_width_org/4);
      $('#left_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_LEFT." '+ lb_width_org +'px</div>');
      $('#center_block').css('float','left').css('margin','2px 0px 4px 0px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_CENTER."<br />'+center_width_org+'px</div>');
      $('#right_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_RIGHT." '+rb_width_org+'px</div>');
    $('#cb_width').html(center_width_org+'px');


    }else if(theme_type=='theme_type_6'){
      center_width_org=theme_width_org - lb_width_org -rb_width_org -14;
      center_width=Math.floor(center_width_org/4);
      $('#left_block').css('float','left').css('margin','2px 0px 4px 4px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_LEFT." '+ lb_width_org +'px</div>');
      $('#center_block').css('float','right').css('margin','2px 4px 4px 0px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_CENTER."<br />'+center_width_org+'px</div>');
      $('#right_block').css('float','left').css('margin','2px 2px 4px 2px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_RIGHT." '+rb_width_org+'px</div>');
    $('#cb_width').html(center_width_org+'px');


    }else if(theme_type=='theme_type_7'){
      center_width_org=theme_width_org - lb_width_org -rb_width_org -14;
      center_width=Math.floor(center_width_org/4);
      $('#left_block').css('float','right').css('margin','2px 4px 4px 0px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_LEFT." '+ lb_width_org +'px</div>');
      $('#center_block').css('float','left').css('margin','2px 0px 4px 4px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_CENTER."<br />'+center_width_org+'px</div>');
      $('#right_block').css('float','right').css('margin','2px 2px 4px 2px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>"._MA_TAD_THEMES_RIGHT." '+rb_width_org+'px</div>');
    $('#cb_width').html(center_width_org+'px');


    }else if(theme_type=='theme_type_8'){
      $('#left_block').css('float','none').css('margin','2px 4px 2px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').html('"._MA_TAD_THEMES_LEFT." '+ theme_width_org +'px');
      $('#center_block').css('float','none').css('margin','2px 4px 2px 4px').css('width',theme_width).css('height','90px').css('line-height','100px').html('"._MA_TAD_THEMES_CENTER." '+theme_width_org+'px');
      $('#right_block').css('float','none').css('margin','2px 4px 2px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('"._MA_TAD_THEMES_RIGHT." '+theme_width_org+'px');
    $('#cb_width').html(center_width_org+'px');

    }
  }";
  return $main;
}


//取得圖片選項
function get_img($path='',$url="",$img='',$col_name="logo",$col_sn='',$width='',$return=true){
  global $xoopsConfig,$xoopsDB;
  if(empty($path))return;
  if(!is_dir($path))return;

  $sql = "select files_sn,file_name,original_filename from ".$xoopsDB->prefix("tad_themes_files_center")." where col_name='{$col_name}' and col_sn='{$col_sn}'";
//die($sql);
  $result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error()."<br>".$sql);
  while(list($files_sn,$file_name,$original_filename)=$xoopsDB->fetchRow($result)){
    $db_files[$files_sn]=$file_name;
    $show_name[$file_name]=$original_filename;
  }
  
  $img=basename($img);
  //die($img);
  
  $main="";
  if($dh = opendir($path)){
    while(($file = readdir($dh)) !== false){
      if($file=="." or $file=="..")continue;
      $type=filetype($path."/".$file);

      if($type!="dir"){
        if(!in_array($file,$db_files)){
          import_file($path."/".$file,$col_name,$col_sn,$width);
        }
        
        if($return){
          $selected=($img==$file)?"selected='selected'":"";
          $main.="<option value='{$url}/{$file}' $selected>{$show_name[$file]}</option>";
        }  
      }
    }
    closedir($dh);
  }
//die($main);
  if($return)  return $main;
}



//匯入圖檔
function import_file($file_name='',$col_name="",$col_sn="",$main_width="",$thumb_width="90"){
  global $xoopsDB,$xoopsUser,$xoopsModule,$xoopsConfig;
  
  $TadUpFiles=new TadUpFiles("tad_themes","/{$xoopsConfig['theme_set']}/{$col_name}",NULL,"","/thumbs");
  
  $TadUpFiles->set_col($col_name,$col_sn,$sort);
  //取消上傳時間限制
  set_time_limit(0);
  //設置上傳大小
  ini_set('memory_limit', '80M');
  //取得檔名
  $file=basename($file_name);

  $path=XOOPS_ROOT_PATH."/uploads/tad_themes/{$xoopsConfig['theme_set']}/{$col_name}";
  $import_file="{$path}/{$file}";
  $thumb_name=XOOPS_ROOT_PATH."/uploads/tad_themes/{$xoopsConfig['theme_set']}/{$col_name}/thumbs/{$file}";

  //自動排序
  $sort=$TadUpFiles->auto_sort();
  //取得附檔
  $ext=strtolower(strrchr($file, "."));

  //判斷檔案種類
  if($ext==".jpg" or $ext==".jpeg" or $ext==".png" or $ext==".gif"){
    $kind="img";
  }else{
    $kind="file";
  }
  $type=mime_content_type($file_name);
  $size=filesize($file_name);

//做縮圖
  if(!empty($main_width))thumbnail($file_name,$import_file,$type,$main_width);
  if(!empty($thumb_width)){
    thumbnail($file_name,$thumb_name,$type,$thumb_width);
  }
  //匯入資料庫
  $sql = "insert into ".$xoopsDB->prefix("tad_themes_files_center")." (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`,`original_filename`) values('$col_name','$col_sn','$sort','{$kind}','{$file}','{$type}','{$size}','{$file}','{$file}')";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
}



//做縮圖
function thumbnail($filename="",$thumb_name="",$type="image/jpeg",$width="120"){

  ini_set('memory_limit', '50M');
  // Get new sizes
  list($old_width, $old_height) = getimagesize($filename);
  if($old_width > $width){
    $percent=($old_width>$old_height)?round($width/$old_width,2):round($width/$old_height,2);

    $newwidth = ($old_width>$old_height)?$width:$old_width * $percent;
    $newheight = ($old_width>$old_height)?$old_height * $percent:$width;

    // Load
    $thumb = imagecreatetruecolor($newwidth, $newheight);
    if($type=="image/jpeg" or $type=="image/jpg" or $type=="image/pjpg" or $type=="image/pjpeg"){
      $source = imagecreatefromjpeg($filename);
      $type="image/jpeg";
    }elseif($type=="image/png"){
      $source = imagecreatefrompng($filename);
      $type="image/png";
    }elseif($type=="image/gif"){
      $source = imagecreatefromgif($filename);
      $type="image/gif";
    }

    // Resize
    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $old_width, $old_height);

    header("Content-type: $type");
    if($type=="image/jpeg"){
     imagejpeg($thumb,$thumb_name);
    }elseif($type=="image/png"){
     imagepng($thumb,$thumb_name);
    }elseif($type=="image/gif"){
     imagegif($thumb,$thumb_name);
    }
    return;
    exit;
  }else{
    copy($filename,$thumb_name);
  }
}


if(!function_exists('mime_content_type')) {

  function mime_content_type($filename) {

  $mime_types = array(

      'txt' => 'text/plain',
      'htm' => 'text/html',
      'html' => 'text/html',
      'php' => 'text/html',
      'css' => 'text/css',
      'js' => 'application/javascript',
      'json' => 'application/json',
      'xml' => 'application/xml',
      'swf' => 'application/x-shockwave-flash',
      'flv' => 'video/x-flv',

      // images
      'png' => 'image/png',
      'jpe' => 'image/jpeg',
      'jpeg' => 'image/jpeg',
      'jpg' => 'image/jpeg',
      'gif' => 'image/gif',
      'bmp' => 'image/bmp',
      'ico' => 'image/vnd.microsoft.icon',
      'tiff' => 'image/tiff',
      'tif' => 'image/tiff',
      'svg' => 'image/svg+xml',
      'svgz' => 'image/svg+xml',

      // archives
      'zip' => 'application/zip',
      'rar' => 'application/x-rar-compressed',
      'exe' => 'application/x-msdownload',
      'msi' => 'application/x-msdownload',
      'cab' => 'application/vnd.ms-cab-compressed',

      // audio/video
      'mp3' => 'audio/mpeg',
      'qt' => 'video/quicktime',
      'mov' => 'video/quicktime',

      // adobe
      'pdf' => 'application/pdf',
      'psd' => 'image/vnd.adobe.photoshop',
      'ai' => 'application/postscript',
      'eps' => 'application/postscript',
      'ps' => 'application/postscript',

      // ms office
      'doc' => 'application/msword',
      'rtf' => 'application/rtf',
      'xls' => 'application/vnd.ms-excel',
      'ppt' => 'application/vnd.ms-powerpoint',

      // open office
      'odt' => 'application/vnd.oasis.opendocument.text',
      'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
      );

      $ext = strtolower(array_pop(explode('.',$filename)));
      if (array_key_exists($ext, $mime_types)) {
          return $mime_types[$ext];
      }
      elseif (function_exists('finfo_open')) {
          $finfo = finfo_open(FILEINFO_MIME);
          $mimetype = finfo_file($finfo, $filename);
          finfo_close($finfo);
          return $mimetype;
      }
      else {
          return 'application/octet-stream';
      }
  }
}

//新增資料到tad_themes中
function insert_tad_themes(){
	global $xoopsDB,$xoopsUser,$TadUpFilesSlide,$TadUpFilesBg,$TadUpFilesLogo,$TadUpFilesBt_bg,$xoopsConfig;


	$myts =& MyTextSanitizer::getInstance();
	$_POST['lb_width']=$myts->addSlashes($_POST['lb_width']);
	$_POST['rb_width']=$myts->addSlashes($_POST['rb_width']);
	$_POST['clb_width']=$myts->addSlashes($_POST['clb_width']);
	$_POST['crb_width']=$myts->addSlashes($_POST['crb_width']);
	$_POST['slide_width']=$myts->addSlashes($_POST['slide_width']);
	$_POST['slide_height']=$myts->addSlashes($_POST['slide_height']);

  $sql="update ".$xoopsDB->prefix("tad_themes")." set `theme_enable`='0'";
  $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

//此處增加7+4項by hc
	$sql = "insert into ".$xoopsDB->prefix("tad_themes")."
	(`theme_name` , `theme_type` , `lb_width` , `rb_width` , `clb_width` , `crb_width` , `lb_color` , `cb_color` , `rb_color` , `margin_top` , `margin_bottom` , `bg_img` , `bg_color`  , `bg_repeat`  , `bg_attachment`  , `bg_position`  , `logo_img` , `logo_top` , `logo_right` , `logo_bottom` , `logo_left` , `theme_enable` , `slide_width` , `slide_height` , `font_size` , `font_color` , `link_color` , `hover_color` , `theme_kind`,`block_config` , `bt_text` , `bt_text_padding` , `bt_bg_color` , `bt_bg_img` , `bt_bg_repeat` , `bt_radius` , `navbar_pos` , `navbar_bg_top` , `navbar_bg_bottom` , `navbar_hover`)
	values('{$_POST['theme_name']}' , '{$_POST['theme_type']}' , '{$_POST['lb_width']}' , '{$_POST['rb_width']}' , '{$_POST['clb_width']}' , '{$_POST['crb_width']}' , '{$_POST['lb_color']}' , '{$_POST['cb_color']}' , '{$_POST['rb_color']}' , '{$_POST['margin_top']}' , '{$_POST['margin_bottom']}' , '{$_POST['bg_img']}' , '{$_POST['bg_color']}' , '{$_POST['bg_repeat']}' , '{$_POST['bg_attachment']}' , '{$_POST['bg_position']}' , '{$_POST['logo_img']}' , '{$_POST['logo_top']}' , '{$_POST['logo_right']}' , '{$_POST['logo_bottom']}' , '{$_POST['logo_left']}' , '1' , '{$_POST['slide_width']}' , '{$_POST['slide_height']}' , '{$_POST['font_size']}' , '{$_POST['font_color']}' , '{$_POST['link_color']}' , '{$_POST['hover_color']}' , '{$_POST['theme_kind']}', '{$_POST['block_config']}' , '{$_POST['bt_text']}' , '{$_POST['bt_text_padding']}' , '{$_POST['bt_bg_color']}' , '{$_POST['bt_bg_img']}' , '{$_POST['bt_bg_repeat']}' ,'{$_POST['bt_radius']}','{$_POST['navbar_pos']}','{$_POST['navbar_bg_top']}','{$_POST['navbar_bg_bottom']}','{$_POST['navbar_hover']}')";
	$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

	//取得最後新增資料的流水編號
	$theme_id=$xoopsDB->getInsertId();

  $slide_width=($_POST['theme_kind']=='bootstrap')?$_POST['slide_width']*80:$_POST['slide_width'];

  //$TadUpFilesSlide,$TadUpFilesBg,$TadUpFilesLogo,$TadUpFilesBt_bg
  $TadUpFilesSlide->set_col('slide',$theme_id);
  $TadUpFilesSlide->upload_file('slide',$slide_width);
  
  $TadUpFilesBg->set_col('bg',$theme_id);
  $TadUpFilesBg->upload_file('bg');
  
  $TadUpFilesLogo->set_col('logo',$theme_id);
  $TadUpFilesLogo->upload_file('logo');
  
  $TadUpFilesBt_bg->set_col('bt_bg',$theme_id);
  $TadUpFilesBt_bg->upload_file('bt_bg');
  
	return $theme_id;
}



//更新tad_themes某一筆資料
function update_tad_themes($theme_id=""){
	global $xoopsDB,$xoopsUser,$TadUpFilesSlide,$TadUpFilesBg,$TadUpFilesLogo,$TadUpFilesBt_bg,$xoopsConfig;


	$myts =& MyTextSanitizer::getInstance();
	$_POST['lb_width']=$myts->addSlashes($_POST['lb_width']);
	$_POST['rb_width']=$myts->addSlashes($_POST['rb_width']);
	$_POST['clb_width']=$myts->addSlashes($_POST['clb_width']);
	$_POST['crb_width']=$myts->addSlashes($_POST['crb_width']);
	$_POST['slide_width']=$myts->addSlashes($_POST['slide_width']);
	$_POST['slide_height']=$myts->addSlashes($_POST['slide_height']);


	$sql = "update ".$xoopsDB->prefix("tad_themes")." set
	 `theme_name` = '{$_POST['theme_name']}' ,
	 `theme_type` = '{$_POST['theme_type']}' ,
	 `lb_width` = '{$_POST['lb_width']}' ,
	 `rb_width` = '{$_POST['rb_width']}' ,
	 `clb_width` = '{$_POST['clb_width']}' ,
	 `crb_width` = '{$_POST['crb_width']}' ,
	 `lb_color` = '{$_POST['lb_color']}' ,
   `cb_color` = '{$_POST['cb_color']}' ,
   `rb_color` = '{$_POST['rb_color']}' ,
	 `margin_top` = '{$_POST['margin_top']}' ,
   `margin_bottom` = '{$_POST['margin_bottom']}' ,
	 `bg_img` = '{$_POST['bg_img']}' ,
	 `bg_color` = '{$_POST['bg_color']}' ,
   `bg_repeat` = '{$_POST['bg_repeat']}' ,
   `bg_attachment` = '{$_POST['bg_attachment']}' ,
   `bg_position` = '{$_POST['bg_position']}' ,
	 `logo_img` = '{$_POST['logo_img']}' ,
	 `logo_top` = '{$_POST['logo_top']}' ,
   `logo_right` = '{$_POST['logo_right']}' ,
   `logo_bottom` = '{$_POST['logo_bottom']}' ,
   `logo_left` = '{$_POST['logo_left']}' ,
	 `theme_enable` = '1' ,
	 `slide_width` = '{$_POST['slide_width']}' ,
	 `slide_height` = '{$_POST['slide_height']}' ,
	 `font_size` = '{$_POST['font_size']}' ,
	 `font_color` = '{$_POST['font_color']}' ,
   `link_color` = '{$_POST['link_color']}' ,
   `hover_color` = '{$_POST['hover_color']}' ,
   `theme_kind` = '{$_POST['theme_kind']}' ,
	`block_config` = '{$_POST['block_config']}' ,
	`bt_text` = '{$_POST['bt_text']}' ,
	`bt_text_padding` = '{$_POST['bt_text_padding']}' ,
	`bt_bg_color` = '{$_POST['bt_bg_color']}' ,
	`bt_bg_img` = '{$_POST['bt_bg_img']}' ,
	`bt_bg_repeat` = '{$_POST['bt_bg_repeat']}' ,
	`bt_radius` = '{$_POST['bt_radius']}' ,
	`navbar_pos` = '{$_POST['navbar_pos']}' ,
	`navbar_bg_top` = '{$_POST['navbar_bg_top']}' ,
	`navbar_bg_bottom` = '{$_POST['navbar_bg_bottom']}' ,
	`navbar_hover` = '{$_POST['navbar_hover']}'
	
	where theme_id='$theme_id'";

	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	

	mk_dir(XOOPS_ROOT_PATH."/uploads/tad_themes/{$_POST['theme_name']}");

  $slide_width=($_POST['theme_kind']=='bootstrap')?$_POST['slide_width']*80:$_POST['slide_width'];

  //$TadUpFilesSlide,$TadUpFilesBg,$TadUpFilesLogo,$TadUpFilesBt_bg
  $TadUpFilesSlide->set_col('slide',$theme_id);
  $TadUpFilesSlide->upload_file('slide',$slide_width);
  
  $TadUpFilesBg->set_col('bg',$theme_id);
  $TadUpFilesBg->upload_file('bg');
  
  $TadUpFilesLogo->set_col('logo',$theme_id);
  $TadUpFilesLogo->upload_file('logo');
  
  $TadUpFilesBt_bg->set_col('bt_bg',$theme_id);
  $TadUpFilesBt_bg->upload_file('bt_bg');
  
	return $theme_id;
}


//以流水號取得某筆tad_themes資料
function get_tad_themes(){
	global $xoopsDB,$xoopsConfig;
	if(empty($xoopsConfig['theme_set']))return;

  if(!file_exists(XOOPS_ROOT_PATH."/themes/{$xoopsConfig['theme_set']}/config.php")){
    return;
  }
	
	$sql = "select * from ".$xoopsDB->prefix("tad_themes")." where theme_name='{$xoopsConfig['theme_set']}'";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$data=$xoopsDB->fetchArray($result);
	return $data;
}

//刪除tad_themes某筆資料資料
function delete_tad_themes($theme_id=""){
	global $xoopsDB,$xoopsConfig,$TadUpFilesSlide,$TadUpFilesBg,$TadUpFilesLogo,$TadUpFilesBt_bg;
	$sql = "delete from ".$xoopsDB->prefix("tad_themes")." where theme_id='$theme_id'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  
  //$TadUpFilesSlide,$TadUpFilesBg,$TadUpFilesLogo,$TadUpFilesBt_bg
  $TadUpFilesSlide->set_col('slide',$theme_id);
  $TadUpFilesSlide->del_files();
  
  $TadUpFilesBg->set_col('bg',$theme_id);
  $TadUpFilesBg->del_files();
  
  $TadUpFilesLogo->set_col('logo',$theme_id);
  $TadUpFilesLogo->del_files();
  
  $TadUpFilesBt_bg->set_col('bt_bg',$theme_id);
  $TadUpFilesBt_bg->del_files();
  
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


/*-----------執行動作判斷區----------*/
$op = (!isset($_REQUEST['op']))? "":$_REQUEST['op'];
$theme_id= (!isset($_REQUEST['theme_id']))? "":intval($_REQUEST['theme_id']);

switch($op){
	/*---判斷動作請貼在下方---*/
	
  //新增資料
  case "insert_tad_themes":
  $theme_id=insert_tad_themes();
  header("location: {$_SERVER['PHP_SELF']}?theme_id=$theme_id");
  break;

  //更新資料
  case "update_tad_themes":
  update_tad_themes($theme_id);
  header("location: {$_SERVER['PHP_SELF']}");
  break;

  //輸入表格
  case "tad_themes_form":
  tad_themes_form();
  break;

  //刪除資料
  case "delete_tad_themes":
  delete_tad_themes($theme_id);
  header("location: {$_SERVER['PHP_SELF']}");
  break;

  //預設動作
  default:
  tad_themes_form();
  break;

	
	/*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
include_once 'footer.php';
?>
