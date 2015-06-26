<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "tad_themes_adm_main_tpl.html";
include_once "header.php";
include_once "../auto_import_theme.php";

/*-----------function區--------------*/

//tad_themes編輯表單
function tad_themes_form()
{
    global $xoopsDB, $xoopsUser, $xoopsConfig, $xoopsTpl, $block_position_title, $xoTheme;

    $myts = &MyTextSanitizer::getInstance();

    $theme_name = $xoopsConfig['theme_set'];
    mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}");
    mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bg");
    mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/slide");
    mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/logo");
    mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bg/thumbs");
    mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/slide/thumbs");
    mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/logo/thumbs");
    mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bt_bg");
    mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/bt_bg/thumbs");
    mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/nav_bg");
    mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/nav_bg/thumbs");

    //抓取預設值
    $DBV = get_tad_themes();
    if (empty($DBV)) {
        $DBV = array();
    }

    //設定「theme_id」欄位預設值
    $theme_id = (!isset($DBV['theme_id'])) ? 0 : $DBV['theme_id'];
    if (empty($theme_id)) {
        auto_import_theme();
        header("location: main.php");
        exit;
    }

    import_img(_THEME_BG_PATH, "bg", $theme_id, "");
    import_img(_THEME_LOGO_PATH, "logo", $theme_id);
    import_img(_THEME_SLIDE_PATH, "slide", $theme_id, _TAD_SLIDE_DEFAULT_DESCRIPT, true);
    import_img(_THEME_NAV_BG_PATH, "navbar_img", $theme_id);
    import_img(_THEME_NAVLOGO_PATH, "navlogo", $theme_id);
    foreach ($block_position_title as $position => $ttt) {
        import_img(_THEME_BT_BG_PATH, "bt_bg_{$position}", $theme_id);
    }

    //設定「theme_name」欄位預設值
    $theme_name = (!isset($DBV['theme_name'])) ? $xoopsConfig['theme_set'] : $DBV['theme_name'];

    /*
    $theme_change=1; //佈景種類是否可自訂
    $theme_kind='bootstrap3';//預設佈景種類 bootstrap or bootstrap3 or html or mix
    $config_tabs=array();//欲使用的頁籤
    $config_enable['設定項目']=array('enable', 'min' , 'max' , 'require' , 'default'); //各設定項細節
     */

    if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php")) {
        include_once XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php";
        foreach ($config_enable as $k => $v) {
            $$k         = $v['default'];
            $enable[$k] = $v['enable'];
            if ($k == 'theme_width') {
                if (strpos($DBV['theme_kind'], 'bootstrap') === false) {
                    $v['max']     = '';
                    $v['min']     = '';
                    $v['default'] = '980';
                } else {
                    $v['max']     = '12';
                    $v['min']     = '1';
                    $v['default'] = '12';
                }
            }
            $validate[$k] = get_validate($v);
        }
        $xoopsTpl->assign('validate', $validate);
        $xoopsTpl->assign('enable', $enable);

        $bg_img      = !empty($bg_img) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/bg/{$bg_img}" : "";
        $logo_img    = !empty($logo_img) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/logo/{$logo_img}" : "";
        $navlogo_img = !empty($navlogo_img) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/navlogo/{$navlogo_img}" : "";
        $navbar_img  = !empty($navbar_img) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/nav_bg/{$navbar_img}" : "";

    } else {
        return sprintf(_MA_TAD_THEMES_NOT_TAD_THEME, $theme_name, XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php");
    }

    //設定「theme_change」欄位預設值
    $theme_change = (!isset($theme_change)) ? false : $theme_change;

    //設定「theme_type」欄位預設值
    $theme_type = (!isset($DBV['theme_type']) or !$enable['theme_type']) ? $theme_type : $DBV['theme_type'];

    //設定「theme_width」欄位預設值
    $theme_width = (!isset($DBV['theme_width']) or !$enable['theme_width']) ? $theme_width : $DBV['theme_width'];

    //設定「lb_width」欄位預設值
    $lb_width = (!isset($DBV['lb_width']) or !$enable['lb_width']) ? $lb_width : $DBV['lb_width'];

    //設定「rb_width」欄位預設值
    $rb_width = (!isset($DBV['rb_width']) or !$enable['rb_width']) ? $rb_width : $DBV['rb_width'];

    //設定「clb_width」欄位預設值
    $clb_width = (!isset($DBV['clb_width']) or !$enable['clb_width']) ? $clb_width : $DBV['clb_width'];

    //設定「crb_width」欄位預設值
    $crb_width = (!isset($DBV['crb_width']) or !$enable['crb_width']) ? $crb_width : $DBV['crb_width'];

    //設定「base_color」欄位預設值
    $base_color = (!isset($DBV['base_color']) or !$enable['base_color']) ? $base_color : $DBV['base_color'];

    //設定「lb_color」欄位預設值
    $lb_color = (!isset($DBV['lb_color']) or !$enable['lb_color']) ? $lb_color : $DBV['lb_color'];

    //設定「cb_color」欄位預設值
    $cb_color = (!isset($DBV['cb_color']) or !$enable['cb_color']) ? $cb_color : $DBV['cb_color'];

    //設定「rb_color」欄位預設值
    $rb_color = (!isset($DBV['rb_color']) or !$enable['rb_color']) ? $rb_color : $DBV['rb_color'];

    //設定「margin_top」欄位預設值
    $margin_top = (!isset($DBV['margin_top']) or !$enable['margin_top']) ? $margin_top : $DBV['margin_top'];

    //設定「margin_bottom」欄位預設值
    $margin_bottom = (!isset($DBV['margin_bottom']) or !$enable['margin_bottom']) ? $margin_bottom : $DBV['margin_bottom'];

    //設定「bg_img」欄位預設值
    $bg_img = (!isset($DBV['bg_img']) or !$enable['bg_img']) ? $bg_img : $DBV['bg_img'];

    //設定「bg_color」欄位預設值
    $bg_color = (!isset($DBV['bg_color']) or !$enable['bg_color']) ? $bg_color : $DBV['bg_color'];

    //設定「bg_repeat」欄位預設值
    $bg_repeat = (!isset($DBV['bg_repeat']) or !$enable['bg_repeat']) ? $bg_repeat : $DBV['bg_repeat'];

    //設定「bg_attachment」欄位預設值
    $bg_attachment = (!isset($DBV['bg_attachment']) or !$enable['bg_attachment']) ? $bg_attachment : $DBV['bg_attachment'];

    //設定「bg_position」欄位預設值
    $bg_position = (!isset($DBV['bg_position']) or !$enable['bg_position']) ? $bg_position : $DBV['bg_position'];

    //設定「logo_img」欄位預設值
    $logo_img = (!isset($DBV['logo_img']) or !$enable['logo_img']) ? $logo_img : $DBV['logo_img'];

    //設定「logo_position」欄位預設值
    $logo_position = (!isset($DBV['logo_position']) or !$enable['logo_position']) ? $logo_position : $DBV['logo_position'];

    //設定「navlogo_img」欄位預設值
    $navlogo_img = (!isset($DBV['navlogo_img']) or !$enable['navlogo_img']) ? $navlogo_img : $DBV['navlogo_img'];

    //設定「logo_top」欄位預設值
    $logo_top = (!isset($DBV['logo_top']) or !$enable['logo_top']) ? $logo_top : $DBV['logo_top'];

    //設定「logo_right」欄位預設值
    $logo_right = (!isset($DBV['logo_right']) or !$enable['logo_right']) ? $logo_right : $DBV['logo_right'];

    //設定「logo_bottom」欄位預設值
    $logo_bottom = (!isset($DBV['logo_bottom']) or !$enable['logo_bottom']) ? $logo_bottom : $DBV['logo_bottom'];

    //設定「logo_left」欄位預設值
    $logo_left = (!isset($DBV['logo_left']) or !$enable['logo_left']) ? $logo_left : $DBV['logo_left'];

    //設定「theme_enable」欄位預設值
    $theme_enable = (!isset($DBV['theme_enable'])) ? '' : $DBV['theme_enable'];

    //設定「slide_width」欄位預設值
    $slide_width = (!isset($DBV['slide_width']) or !$enable['slide_width']) ? $slide_width : $DBV['slide_width'];

    //設定「slide_height」欄位預設值
    $slide_height = (!isset($DBV['slide_height']) or !$enable['slide_height']) ? $slide_height : $DBV['slide_height'];

    //設定「font_size」欄位預設值
    $font_size = (!isset($DBV['font_size']) or !$enable['font_size']) ? $font_size : $DBV['font_size'];

    //設定「font_color」欄位預設值
    $font_color = (!isset($DBV['font_color']) or !$enable['font_color']) ? $font_color : $DBV['font_color'];

    //設定「link_color」欄位預設值
    $link_color = (!isset($DBV['link_color']) or !$enable['link_color']) ? $link_color : $DBV['link_color'];

    //設定「hover_color」欄位預設值
    $hover_color = (!isset($DBV['hover_color']) or !$enable['hover_color']) ? $hover_color : $DBV['hover_color'];

    //設定「theme_kind」欄位預設值
    $theme_kind = (!isset($DBV['theme_kind'])) ? $theme_kind : $DBV['theme_kind'];

    //新增navbar設定by hc 開始
    //設定「navbar_pos」欄位預設值
    $navbar_pos = (!isset($DBV['navbar_pos']) or !$enable['navbar_pos']) ? $navbar_pos : $DBV['navbar_pos'];

    //設定「navbar_bg_top」欄位預設值
    $navbar_bg_top = (!isset($DBV['navbar_bg_top']) or !$enable['navbar_bg_top']) ? $navbar_bg_top : $DBV['navbar_bg_top'];

    //設定「navbar_bg_bottom」欄位預設值
    $navbar_bg_bottom = (!isset($DBV['navbar_bg_bottom']) or !$enable['navbar_bg_bottom']) ? $navbar_bg_bottom : $DBV['navbar_bg_bottom'];

    //設定「navbar_hover」欄位預設值
    $navbar_hover = (!isset($DBV['navbar_hover']) or !$enable['navbar_hover']) ? $navbar_hover : $DBV['navbar_hover'];
    //設定「navbar_color」欄位預設值
    $navbar_color = (!isset($DBV['navbar_color']) or !$enable['navbar_color']) ? $navbar_color : $DBV['navbar_color'];
    //設定「navbar_color_hover」欄位預設值
    $navbar_color_hover = (!isset($DBV['navbar_color_hover']) or !$enable['navbar_color_hover']) ? $navbar_color_hover : $DBV['navbar_color_hover'];
    //設定「navbar_icon」欄位預設值
    $navbar_icon = (!isset($DBV['navbar_icon']) or !$enable['navbar_icon']) ? $navbar_icon : $DBV['navbar_icon'];
    //設定「navbar_img」欄位預設值
    $navbar_img = (!isset($DBV['navbar_img']) or !$enable['navbar_img']) ? $navbar_img : $DBV['navbar_img'];

    $op = (empty($theme_id)) ? "insert_tad_themes" : "update_tad_themes";
    //$op="replace_tad_themes";

    if ($theme_kind == 'bootstrap' or $theme_kind == 'bootstrap3') {
        $theme_kind_txt = _MA_TADTHEMES_THEME_KIND_BOOTSTRAP;
        $chang_css      = change_css_bootstrap($theme_width, $lb_width);
        $theme_unit     = _MA_TADTHEMES_COL;
    } elseif ($theme_kind == 'bootstrap' or $theme_kind == 'bootstrap3' or $theme_kind == 'mix') {
        $theme_kind_txt = _MA_TADTHEMES_THEME_KIND_MIX;
        $chang_css      = change_css_bootstrap(12, $lb_width);
        $theme_unit     = _MA_TADTHEMES_COL;
    } else {
        $theme_kind_txt = _MA_TADTHEMES_THEME_KIND_HTML;
        $chang_css      = change_css($theme_width, $lb_width);
        $theme_unit     = "px";
    }

    $theme_kind_txt_arr = array('bootstrap' => _MA_TADTHEMES_THEME_KIND_BOOTSTRAP, 'bootstrap3' => _MA_TADTHEMES_THEME_KIND_BOOTSTRAP3, 'html' => _MA_TADTHEMES_THEME_KIND_HTML, 'mix' => _MA_TADTHEMES_THEME_KIND_MIX);

    if (!file_exists(TADTOOLS_PATH . "/formValidator.php")) {
        redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
    }
    include_once TADTOOLS_PATH . "/formValidator.php";
    $formValidator      = new formValidator("#myForm", true);
    $formValidator_code = $formValidator->render();

    $xoopsTpl->assign('theme_change', $theme_change);
    $xoopsTpl->assign('theme_name', $theme_name);
    $xoopsTpl->assign('formValidator_code', $formValidator_code);

    $xoopsTpl->assign('bg_img', $bg_img);
    $xoopsTpl->assign('chang_css', $chang_css);
    $xoopsTpl->assign('theme_kind', $theme_kind);
    $xoopsTpl->assign('theme_kind_txt', $theme_kind_txt);
    $xoopsTpl->assign('theme_kind_txt_arr', $theme_kind_txt_arr);
    $xoopsTpl->assign('theme_kind_arr', explode(',', $theme_kind_arr));
    $xoopsTpl->assign('theme_type', $theme_type);
    $TadUpFilesBg = TadUpFilesBg();
    $xoopsTpl->assign('theme_width', $theme_width);
    $xoopsTpl->assign('lb_width', $lb_width);
    $xoopsTpl->assign('theme_unit', $theme_unit);
    $xoopsTpl->assign('base_color', $base_color);
    $xoopsTpl->assign('lb_color', $lb_color);
    $xoopsTpl->assign('cb_color', $cb_color);
    $xoopsTpl->assign('rb_width', $rb_width);
    $xoopsTpl->assign('rb_color', $rb_color);
    $xoopsTpl->assign('margin_top', $margin_top);
    $xoopsTpl->assign('margin_bottom', $margin_bottom);
    $xoopsTpl->assign('font_size', $font_size);
    $xoopsTpl->assign('font_color', $font_color);
    $xoopsTpl->assign('link_color', $link_color);
    $xoopsTpl->assign('hover_color', $hover_color);
    $xoopsTpl->assign('upform_bg', $TadUpFilesBg->upform(false, "bg", null, false));
    $xoopsTpl->assign('bg_color', $bg_color);
    $xoopsTpl->assign('bg_repeat', $bg_repeat);
    $xoopsTpl->assign('bg_attachment', $bg_attachment);
    $xoopsTpl->assign('bg_position', $bg_position);

    $TadUpFilesBg->set_col("bg", $theme_id);
    $xoopsTpl->assign('all_bg', $TadUpFilesBg->get_file_for_smarty());
    //$xoopsTpl->assign('list_del_file_bg',$TadUpFilesBg->list_del_file());

    $xoopsTpl->assign('use_slide', $use_slide);
    $TadUpFilesSlide = TadUpFilesSlide();
    $TadUpFilesSlide->set_col("slide", $theme_id);
    $xoopsTpl->assign('upform_slide', $TadUpFilesSlide->upform(true, "slide", null, true));
    $TadUpFilesLogo = TadUpFilesLogo();
    $TadUpFilesLogo->set_col("logo", $theme_id);
    $xoopsTpl->assign('all_logo', $TadUpFilesLogo->get_file_for_smarty());
    $xoopsTpl->assign('logo_img', $logo_img);
    $xoopsTpl->assign('upform_logo', $TadUpFilesLogo->upform(true, "logo", null, false));
    $TadUpFilesNavLogo = TadUpFilesNavLogo();
    $TadUpFilesNavLogo->set_col("navlogo", $theme_id);
    $xoopsTpl->assign('all_navlogo', $TadUpFilesNavLogo->get_file_for_smarty());
    $xoopsTpl->assign('navlogo_img', $navlogo_img);
    $xoopsTpl->assign('upform_navlogo', $TadUpFilesNavLogo->upform(false, "navlogo", null, false));
    $TadUpFilesNavBg = TadUpFilesNavBg();
    $TadUpFilesNavBg->set_col("navbar_img", $theme_id);
    $xoopsTpl->assign('all_navbar_img', $TadUpFilesNavBg->get_file_for_smarty());
    $xoopsTpl->assign('navbar_img', $navbar_img);
    $xoopsTpl->assign('upform_navbar_img', $TadUpFilesNavBg->upform(false, "navbar_img", null, false));

    $xoopsTpl->assign('logo_position', $logo_position);
    $xoopsTpl->assign('logo_top', $logo_top);
    $xoopsTpl->assign('logo_left', $logo_left);
    $xoopsTpl->assign('logo_right', $logo_right);
    $xoopsTpl->assign('logo_bottom', $logo_bottom);

    $xoopsTpl->assign('navbar_pos', $navbar_pos);
    $xoopsTpl->assign('navbar_bg_top', $navbar_bg_top);
    $xoopsTpl->assign('navbar_bg_bottom', $navbar_bg_bottom);
    $xoopsTpl->assign('navbar_hover', $navbar_hover);
    $xoopsTpl->assign('navbar_color', $navbar_color);
    $xoopsTpl->assign('navbar_color_hover', $navbar_color_hover);
    $xoopsTpl->assign('navbar_icon', $navbar_icon);
    $xoopsTpl->assign('navbar_img', $navbar_img);
    $xoopsTpl->assign('clb_width', $clb_width);
    $xoopsTpl->assign('crb_width', $crb_width);
    $xoopsTpl->assign('theme_id', $theme_id);
    $xoopsTpl->assign('theme_name', $theme_name);
    $xoopsTpl->assign('slide_width', $slide_width);
    $xoopsTpl->assign('slide_height', $slide_height);
    $xoopsTpl->assign('op', $op);

    $xoopsTpl->assign('jquery', get_jquery(true));

    //區塊設定
    $blocks_values = get_blocks_values($theme_id);
    //die(var_dump($blocks_values));
    $xoopsTpl->assign('blocks_values', $blocks_values);

    $xoopsTpl->assign('config_tabs', $config_tabs);
    $xoopsTpl->assign('config_enable', $config_enable);

    //額外佈景設定
    mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config2");
    mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$theme_name}/config2/thumbs");
    if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/config2.php")) {

        include_once XOOPS_ROOT_PATH . "/themes/{$theme_name}/language/{$xoopsConfig['language']}/main.php";
        include_once XOOPS_ROOT_PATH . "/themes/{$theme_name}/config2.php";

        $xoopsTpl->assign('config2', true);
        $config2_values     = get_config2_values($theme_id);
        $TadUpFiles_config2 = TadUpFiles_config2();
        foreach ($theme_config as $k => $config) {
            $value = $myts->htmlSpecialChars($config2_values[$config['name']]);

            $config2[$k]['name']    = $config['name'];
            $config2[$k]['text']    = $config['text'];
            $config2[$k]['desc']    = $config['desc'];
            $config2[$k]['type']    = $config['type'];
            $config2[$k]['value']   = $value;
            $config2[$k]['default'] = $config['default'];

            if ($config['type'] == "file") {
                import_img($config['default'], "config2_{$config['name']}", $theme_id, "");
                $TadUpFiles_config2->set_col("config2_{$config['name']}", $theme_id);
                $config2[$k]['form'] = $TadUpFiles_config2->upform(false, "config2_{$config['name']}", null, false);
                $config2[$k]['list'] = $TadUpFiles_config2->get_file_for_smarty();
                //die("list:".$config2[$k]['list']);
            }
        }
        $xoopsTpl->assign('theme_config', $config2);
    } else {
        $xoopsTpl->assign('config2', false);
    }

    if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/mColorPicker.php")) {
        redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
    }
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/mColorPicker.php";
    $mColorPicker      = new mColorPicker('.color');
    $mColorPicker_code = $mColorPicker->render();
    $xoopsTpl->assign('mColorPicker_code', $mColorPicker_code);

    $xoTheme->addScript('modules/tadtools/jqueryCookie/jquery.cookie.js');
}

function change_css_bootstrap($theme_width = "12", $theme_left_width = "")
{
    $theme_width      = empty($theme_width) ? 12 : $theme_width;
    $theme_left_width = (empty($theme_left_width) or $theme_left_width == $theme_width) ? 3 : $theme_left_width;
    $main             = "
  function change_css(){
    //原始頁寬，如:12
    var theme_width_org = {$theme_width};
    //原始區域寬，如:12
    var lb_width_org = {$theme_left_width};
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
    var theme_type=$('#theme_type').val();

    //$('#preview_zone').css('width',preview_width+'px');
    $('#preview_zone').css('background-color',$('#bg_color').val());
    $('#preview_zone').css('background-repeat',$('#bg_repeat').val());
    $('#preview_zone').css('background-attachment',$('#bg_attachment').val());
    $('#preview_zone').css('background-position',$('#bg_position').val());

    if(theme_type=='theme_type_1'){
      $('#left_block').css('background-color',$('#lb_color').val()).css('color',$('#font_color').val());
      $('#right_block').css('background-color',$('#lb_color').val()).css('color',$('#font_color').val());
    }else if(theme_type=='theme_type_2'){
      $('#left_block').css('background-color',$('#rb_color').val()).css('color',$('#font_color').val());
      $('#right_block').css('background-color',$('#rb_color').val()).css('color',$('#font_color').val());
    }else{
      $('#left_block').css('background-color',$('#lb_color').val()).css('color',$('#font_color').val());
      $('#right_block').css('background-color',$('#rb_color').val()).css('color',$('#font_color').val());
    }
    $('#center_block').css('background-color',$('#cb_color').val()).css('color',$('#font_color').val());
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



    $('#theme_demo').css('width',theme_div_width+'px').css('height',theme_div_height+'px').css('margin-top',theme_margin_top+'px').css('margin-bottom',theme_margin_bottom+'px').css('background-color',$('#base_color').val());
    $('#theme_head').css('width',theme_width+'px').css('height',slide_height+'px').css('line-height',slide_height+'px');
    $('#theme_foot').css('width',theme_width+'px');


    if(theme_type!='theme_type_8'){
      if($('#lb_width').val()==theme_width_org){
        $('#lb_width').val(lb_width_org);
      }
      if($('#rb_width').val()==theme_width_org){
        $('#rb_width').val(lb_width_org);
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
      $('#left_block').css('float','left').css('margin','2px 2px 2px 4px').css('width',lb_width).css('height','86px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'" . _MA_TADTHEMES_COL . "</div>');
      $('#center_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',center_width).css('height','178px').css('line-height','178px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'" . _MA_TADTHEMES_COL . "');
      $('#right_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',rb_width).css('height','86px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rb_width_org+'" . _MA_TADTHEMES_COL . "</div>');
      $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');

    }else if(theme_type=='theme_type_2'){
      $('#left_block').css('float','right').css('margin','2px 4px 2px 2px').css('width',lb_width).css('height','86px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'" . _MA_TADTHEMES_COL . "</div>');
      $('#center_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',center_width).css('height','178px').css('line-height','178px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'" . _MA_TADTHEMES_COL . "');
      $('#right_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',rb_width).css('height','86px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rb_width_org+'" . _MA_TADTHEMES_COL . "</div>');
      $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');


    }else if(theme_type=='theme_type_3'){
      $('#left_block').css('float','left').css('margin','2px 2px 2px 4px').css('width',lb_width).css('height','132px').html('<div style=\'line-height:12px;margin-top:60px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'" . _MA_TADTHEMES_COL . "</div>');
      $('#center_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',center_width).css('height','132px').css('line-height','132px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'" . _MA_TADTHEMES_COL . "');
      $('#right_block').css('float','none').css('margin','2px 2px 4px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('" . _MA_TAD_THEMES_RIGHT . " '+theme_width_org+'" . _MA_TADTHEMES_COL . "');
      $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');


    }else if(theme_type=='theme_type_4'){
      $('#left_block').css('float','right').css('margin','2px 4px 2px 2px').css('width',lb_width).css('height','132px').html('<div style=\'line-height:12px;margin-top:60px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'" . _MA_TADTHEMES_COL . "</div>');
      $('#center_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',center_width).css('height','132px').css('line-height','132px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'" . _MA_TADTHEMES_COL . "');
      $('#right_block').css('float','none').css('margin','2px 2px 4px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('" . _MA_TAD_THEMES_RIGHT . " '+theme_width_org+'" . _MA_TADTHEMES_COL . "');
      $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');


    }else if(theme_type=='theme_type_5'){
      center_width_org=theme_width_org - lb_width_org -rb_width_org;
      center_width=Math.floor(center_width_org * 80 /4)-3;
      $('#left_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'" . _MA_TADTHEMES_COL . "</div>');
      $('#center_block').css('float','left').css('margin','2px 0px 4px 0px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_CENTER . "<br />'+center_width_org+'" . _MA_TADTHEMES_COL . "</div>');
      $('#right_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rb_width_org+'" . _MA_TADTHEMES_COL . "</div>');
      $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');


    }else if(theme_type=='theme_type_6'){
      center_width_org=theme_width_org - lb_width_org -rb_width_org;
      center_width=Math.floor(center_width_org * 80/4)-3;
      $('#left_block').css('float','left').css('margin','2px 0px 4px 4px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'" . _MA_TADTHEMES_COL . "</div>');
      $('#center_block').css('float','right').css('margin','2px 4px 4px 0px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_CENTER . "<br />'+center_width_org+'" . _MA_TADTHEMES_COL . "</div>');
      $('#right_block').css('float','left').css('margin','2px 2px 4px 2px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rb_width_org+'" . _MA_TADTHEMES_COL . "</div>');
    $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');


    }else if(theme_type=='theme_type_7'){
      center_width_org=theme_width_org - lb_width_org -rb_width_org;
      center_width=Math.floor(center_width_org * 80/4)-3;
      $('#left_block').css('float','right').css('margin','2px 4px 4px 0px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'" . _MA_TADTHEMES_COL . "</div>');
      $('#center_block').css('float','left').css('margin','2px 0px 4px 4px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_CENTER . "<br />'+center_width_org+'" . _MA_TADTHEMES_COL . "</div>');
      $('#right_block').css('float','right').css('margin','2px 2px 4px 2px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rb_width_org+'" . _MA_TADTHEMES_COL . "</div>');
    $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');

    }else if(theme_type=='theme_type_8'){
      $('#left_block').css('float','none').css('margin','2px 4px 2px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').html('" . _MA_TAD_THEMES_LEFT . " '+ theme_width_org +'" . _MA_TADTHEMES_COL . "');
      $('#center_block').css('float','none').css('margin','2px 4px 2px 4px').css('width',theme_width).css('height','90px').css('line-height','100px').html('" . _MA_TAD_THEMES_CENTER . " '+theme_width_org+'" . _MA_TADTHEMES_COL . "');
      $('#right_block').css('float','none').css('margin','2px 4px 2px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('" . _MA_TAD_THEMES_RIGHT . " '+theme_width_org+'" . _MA_TADTHEMES_COL . "');
    $('#cb_width').html(theme_width_org+'" . _MA_TADTHEMES_COL . "');

    }
  }";
    return $main;
}

function get_validate($col = array())
{
    if ($col['enable'] == '1') {
        $v_item[] = $col['require'] ? "required" : "";
        $v_item[] = $col['min'] ? "min[{$col['min']}]" : "";
        $v_item[] = $col['max'] ? "max[{$col['max']}]" : "";
        $class    = implode(',', $v_item);
        if ($class == ",,") {
            return;
        }

        return " validate[{$class}]";
    } else {
        return "\" readonly=\"readonly";
    }
}

function change_css($theme_width, $theme_left_width)
{
    $theme_width      = empty($theme_width) ? 980 : $theme_width;
    $theme_left_width = (empty($theme_left_width) or $theme_left_width == $theme_width) ? 220 : $theme_left_width;
    $main             = "
  function change_css(){
    var theme_width_org = $theme_width;
    var lb_width_org = $theme_left_width;
    var theme_width = Math.round(theme_width_org/4);
    //var preview_width = Math.round(theme_width_org/2);
    var preview_width = $('#preview_width').width();
    var theme_div_width= theme_width+11;
    var slide_height_org = $('#slide_height').val();
    var slide_height= Math.round(slide_height_org/4);
    var theme_div_height=230+slide_height;
    var theme_margin_top_org = $('#margin_top').val();
    var theme_margin_top= Math.round(theme_margin_top_org/4);
    var theme_margin_bottom_org = $('#margin_bottom').val();
    var theme_margin_bottom= Math.round(theme_margin_bottom_org/4);
    var theme_type=$('#theme_type').val();

    $('#preview_zone').css('width',preview_width+'px');
    $('#preview_zone').css('background-color',$('#bg_color').val());
    $('#preview_zone').css('background-repeat',$('#bg_repeat').val());
    $('#preview_zone').css('background-attachment',$('#bg_attachment').val());
    $('#preview_zone').css('background-position',$('#bg_position').val());

    if(theme_type=='theme_type_1'){
      $('#left_block').css('background-color',$('#lb_color').val()).css('color',$('#font_color').val());
      $('#right_block').css('background-color',$('#lb_color').val()).css('color',$('#font_color').val());
    }else if(theme_type=='theme_type_2'){
      $('#left_block').css('background-color',$('#rb_color').val()).css('color',$('#font_color').val());
      $('#right_block').css('background-color',$('#rb_color').val()).css('color',$('#font_color').val());
    }else{
      $('#left_block').css('background-color',$('#lb_color').val()).css('color',$('#font_color').val());
      $('#right_block').css('background-color',$('#rb_color').val()).css('color',$('#font_color').val());
    }

    $('#center_block').css('background-color',$('#cb_color').val()).css('color',$('#font_color').val());
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



    $('#theme_demo').css('width',theme_div_width+'px').css('height',theme_div_height+'px').css('margin-top',theme_margin_top+'px').css('margin-bottom',theme_margin_bottom+'px').css('background-color',$('#base_color').val());
    $('#theme_head').css('width',theme_width+'px').css('height',slide_height+'px').css('line-height',slide_height+'px');
    $('#theme_foot').css('width',theme_width+'px');


    if(theme_type!='theme_type_8'){
      if($('#lb_width').val()==theme_width_org){
        $('#lb_width').val(lb_width_org);
      }
      if($('#rb_width').val()==theme_width_org){
        $('#rb_width').val(lb_width_org);
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
      $('#left_block').css('float','left').css('margin','2px 2px 2px 4px').css('width',lb_width).css('height','86px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'px</div>');
      $('#center_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',center_width).css('height','178px').css('line-height','178px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'px');
      $('#right_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',rb_width).css('height','86px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rb_width_org+'px</div>');
      $('#cb_width').html(center_width_org+'px');

    }else if(theme_type=='theme_type_2'){
      $('#left_block').css('float','right').css('margin','2px 4px 2px 2px').css('width',lb_width).css('height','86px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'px</div>');
      $('#center_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',center_width).css('height','178px').css('line-height','178px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'px');
      $('#right_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',rb_width).css('height','86px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rb_width_org+'px</div>');
      $('#cb_width').html(center_width_org+'px');


    }else if(theme_type=='theme_type_3'){
      $('#left_block').css('float','left').css('margin','2px 2px 2px 4px').css('width',lb_width).css('height','132px').html('<div style=\'line-height:12px;margin-top:60px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'px</div>');
      $('#center_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',center_width).css('height','132px').css('line-height','132px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'px');
      $('#right_block').css('float','none').css('margin','2px 2px 4px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('" . _MA_TAD_THEMES_RIGHT . " '+theme_width_org+'px');
      $('#cb_width').html(center_width_org+'px');


    }else if(theme_type=='theme_type_4'){
      $('#left_block').css('float','right').css('margin','2px 4px 2px 2px').css('width',lb_width).css('height','132px').html('<div style=\'line-height:12px;margin-top:60px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'px</div>');
      $('#center_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',center_width).css('height','132px').css('line-height','132px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'px');
      $('#right_block').css('float','none').css('margin','2px 2px 4px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('" . _MA_TAD_THEMES_RIGHT . " '+theme_width_org+'px');
      $('#cb_width').html(center_width_org+'px');


    }else if(theme_type=='theme_type_5'){
      center_width_org=theme_width_org - lb_width_org -rb_width_org -14;
      center_width=Math.floor(center_width_org/4);
      center_width_org=center_width_org+14;
      $('#left_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'px</div>');
      $('#center_block').css('float','left').css('margin','2px 0px 4px 0px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_CENTER . "<br />'+center_width_org+'px</div>');
      $('#right_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rb_width_org+'px</div>');

      $('#cb_width').html(center_width_org+'px');


    }else if(theme_type=='theme_type_6'){
      center_width_org=theme_width_org - lb_width_org -rb_width_org -14;
      center_width=Math.floor(center_width_org/4);
      center_width_org=center_width_org+14;
      $('#left_block').css('float','left').css('margin','2px 0px 4px 4px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'px</div>');
      $('#center_block').css('float','right').css('margin','2px 4px 4px 0px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_CENTER . "<br />'+center_width_org+'px</div>');
      $('#right_block').css('float','left').css('margin','2px 2px 4px 2px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rb_width_org+'px</div>');

      $('#cb_width').html(center_width_org+'px');


    }else if(theme_type=='theme_type_7'){
      center_width_org=theme_width_org - lb_width_org -rb_width_org -14;
      center_width=Math.floor(center_width_org/4);
      center_width_org=center_width_org+14;
      $('#left_block').css('float','right').css('margin','2px 4px 4px 0px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lb_width_org +'px</div>');
      $('#center_block').css('float','left').css('margin','2px 0px 4px 4px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_CENTER . "<br />'+center_width_org+'px</div>');
      $('#right_block').css('float','right').css('margin','2px 2px 4px 2px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rb_width_org+'px</div>');

      $('#cb_width').html(center_width_org+'px');


    }else if(theme_type=='theme_type_8'){
      $('#left_block').css('float','none').css('margin','2px 4px 2px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').html('" . _MA_TAD_THEMES_LEFT . " '+ theme_width_org +'px');
      $('#center_block').css('float','none').css('margin','2px 4px 2px 4px').css('width',theme_width).css('height','90px').css('line-height','100px').html('" . _MA_TAD_THEMES_CENTER . " '+theme_width_org+'px');
      $('#right_block').css('float','none').css('margin','2px 4px 2px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('" . _MA_TAD_THEMES_RIGHT . " '+theme_width_org+'px');
      $('#cb_width').html(center_width_org+'px');

    }
  }";
    return $main;
}

//新增資料到tad_themes中
function insert_tad_themes()
{
    global $xoopsDB, $xoopsUser, $xoopsConfig;

    $myts                  = &MyTextSanitizer::getInstance();
    $_POST['theme_width']  = $myts->addSlashes($_POST['theme_width']);
    $_POST['lb_width']     = $myts->addSlashes($_POST['lb_width']);
    $_POST['rb_width']     = $myts->addSlashes($_POST['rb_width']);
    $_POST['clb_width']    = $myts->addSlashes($_POST['clb_width']);
    $_POST['crb_width']    = $myts->addSlashes($_POST['crb_width']);
    $_POST['slide_width']  = $myts->addSlashes($_POST['slide_width']);
    $_POST['slide_height'] = $myts->addSlashes($_POST['slide_height']);

    $sql = "update " . $xoopsDB->prefix("tad_themes") . " set `theme_enable`='0'";
    $xoopsDB->query($sql) or die($sql . "<br>" . mysql_error());

    $_POST['logo_top']    = intval($_POST['logo_top']);
    $_POST['logo_right']  = intval($_POST['logo_right']);
    $_POST['logo_bottom'] = intval($_POST['logo_bottom']);
    $_POST['logo_left']   = intval($_POST['logo_left']);

    //此處增加7+4項by hc
    $sql = "insert into " . $xoopsDB->prefix("tad_themes") . "
  (`theme_name` , `theme_type` , `theme_width` , `lb_width` , `rb_width` , `clb_width` , `crb_width`, `base_color` , `lb_color` , `cb_color` , `rb_color` , `margin_top` , `margin_bottom` , `bg_img` , `bg_color`  , `bg_repeat`  , `bg_attachment`  , `bg_position`  , `logo_img` , `logo_position` , `logo_top` , `logo_right` , `logo_bottom` , `logo_left` , `theme_enable` , `slide_width` , `slide_height` , `font_size` , `font_color` , `link_color` , `hover_color` , `theme_kind`, `navbar_pos` , `navbar_bg_top` , `navbar_bg_bottom` , `navbar_hover` , `navbar_color` , `navbar_color_hover` , `navbar_icon` , `navbar_img`)
  values('{$_POST['theme_name']}' , '{$_POST['theme_type']}', '{$_POST['theme_width']}' , '{$_POST['lb_width']}' , '{$_POST['rb_width']}' , '{$_POST['clb_width']}' , '{$_POST['crb_width']}' , '{$_POST['base_color']}', '{$_POST['lb_color']}' , '{$_POST['cb_color']}' , '{$_POST['rb_color']}' , '{$_POST['margin_top']}' , '{$_POST['margin_bottom']}' , '{$_POST['bg_img']}' , '{$_POST['bg_color']}' , '{$_POST['bg_repeat']}' , '{$_POST['bg_attachment']}' , '{$_POST['bg_position']}' , '{$_POST['logo_img']}' , '{$_POST['logo_position']}' , '{$_POST['navlogo_img']}' , '{$_POST['logo_top']}' , '{$_POST['logo_right']}' , '{$_POST['logo_bottom']}' , '{$_POST['logo_left']}' , '1' , '{$_POST['slide_width']}' , '{$_POST['slide_height']}' , '{$_POST['font_size']}' , '{$_POST['font_color']}' , '{$_POST['link_color']}' , '{$_POST['hover_color']}' , '{$_POST['theme_kind']}','{$_POST['navbar_pos']}','{$_POST['navbar_bg_top']}','{$_POST['navbar_bg_bottom']}','{$_POST['navbar_hover']}','{$_POST['navbar_color']}','{$_POST['navbar_color_hover']}','{$_POST['navbar_icon']}','{$_POST['navbar_img']}')";
    $xoopsDB->query($sql) or die($sql . "<br>" . mysql_error());

    //取得最後新增資料的流水編號
    $theme_id = $xoopsDB->getInsertId();

    $slide_width = ($_POST['theme_kind'] == 'bootstrap' or $_POST['theme_kind'] == 'bootstrap3') ? 1920 : $_POST['slide_width'];

    $TadUpFilesSlide = TadUpFilesSlide();
    $TadUpFilesSlide->set_col('slide', $theme_id);
    $TadUpFilesSlide->upload_file('slide', $slide_width, null, null, "", true);
    $TadUpFilesBg = TadUpFilesBg();
    $TadUpFilesBg->set_col('bg', $theme_id);
    $TadUpFilesBg->upload_file('bg', null, null, null, "", true);
    $TadUpFilesLogo = TadUpFilesLogo();
    $TadUpFilesLogo->set_col('logo', $theme_id);
    $TadUpFilesLogo->upload_file('logo', null, null, null, "", true);
    $TadUpFilesNavLogo = TadUpFilesNavLogo();
    $TadUpFilesNavLogo->set_col('navlogo', $theme_id);
    $TadUpFilesNavLogo->upload_file('navlogo', null, null, null, "", true);
    $TadUpFilesNavBg = TadUpFilesNavBg();
    $TadUpFilesNavBg->set_col('navbar_img', $theme_id);
    $TadUpFilesNavBg->upload_file('navbar_img', null, null, null, "", true);
    //儲存區塊設定
    save_blocks($theme_id);

    //儲存額外設定值
    if ($_POST['config2'] == '1') {
        save_config2($theme_id);
    }
    return $theme_id;
}

//更新tad_themes某一筆資料
function update_tad_themes($theme_id = "")
{
    global $xoopsDB, $xoopsUser, $xoopsConfig;

    //切換佈景類型
    if (isset($_POST['old_theme_kind']) and $_POST['old_theme_kind'] !== $_POST['theme_kind']) {
        if ($_POST['theme_kind'] == "bootstrap" or $_POST['theme_kind'] == "bootstrap3") {
            $_POST['theme_width'] = 12;
            $_POST['lb_width']    = 3;
            $_POST['rb_width']    = 3;
            $_POST['slide_width'] = 12;
        } elseif ($_POST['theme_kind'] == "mix") {
            $_POST['theme_width'] = 980;
            $_POST['lb_width']    = 3;
            $_POST['rb_width']    = 3;
            $_POST['slide_width'] = 980;
        } elseif ($_POST['theme_kind'] == "html") {
            $_POST['theme_width'] = 980;
            $_POST['lb_width']    = 240;
            $_POST['rb_width']    = 240;
            $_POST['slide_width'] = 980;
        }
    }
    update_tadtools_setup($_POST['theme_name'], $_POST['theme_kind']);

    $myts                  = &MyTextSanitizer::getInstance();
    $_POST['theme_width']  = $myts->addSlashes($_POST['theme_width']);
    $_POST['lb_width']     = $myts->addSlashes($_POST['lb_width']);
    $_POST['rb_width']     = $myts->addSlashes($_POST['rb_width']);
    $_POST['clb_width']    = $myts->addSlashes($_POST['clb_width']);
    $_POST['crb_width']    = $myts->addSlashes($_POST['crb_width']);
    $_POST['slide_width']  = $myts->addSlashes($_POST['slide_width']);
    $_POST['slide_height'] = $myts->addSlashes($_POST['slide_height']);

    $_POST['logo_top']    = intval($_POST['logo_top']);
    $_POST['logo_right']  = intval($_POST['logo_right']);
    $_POST['logo_bottom'] = intval($_POST['logo_bottom']);
    $_POST['logo_left']   = intval($_POST['logo_left']);

    $sql = "update " . $xoopsDB->prefix("tad_themes") . " set
    `theme_name` = '{$_POST['theme_name']}' ,
    `theme_type` = '{$_POST['theme_type']}' ,
    `theme_width` = '{$_POST['theme_width']}' ,
    `lb_width` = '{$_POST['lb_width']}' ,
    `rb_width` = '{$_POST['rb_width']}' ,
    `clb_width` = '{$_POST['clb_width']}' ,
    `crb_width` = '{$_POST['crb_width']}' ,
    `base_color` = '{$_POST['base_color']}' ,
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
    `logo_position` = '{$_POST['logo_position']}' ,
    `navlogo_img` = '{$_POST['navlogo_img']}' ,
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
    `navbar_pos` = '{$_POST['navbar_pos']}' ,
    `navbar_bg_top` = '{$_POST['navbar_bg_top']}' ,
    `navbar_bg_bottom` = '{$_POST['navbar_bg_bottom']}' ,
    `navbar_hover` = '{$_POST['navbar_hover']}' ,
    `navbar_color` = '{$_POST['navbar_color']}' ,
    `navbar_color_hover` = '{$_POST['navbar_color_hover']}' ,
    `navbar_icon` = '{$_POST['navbar_icon']}',
    `navbar_img` = '{$_POST['navbar_img']}'
    where theme_id='$theme_id'";
    //die($sql);
    $xoopsDB->queryF($sql) or die($sql . "<br>" . mysql_error());

    mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$_POST['theme_name']}");

    $slide_width = ($_POST['theme_kind'] == 'bootstrap' or $_POST['theme_kind'] == 'bootstrap3') ? 1920 : $_POST['slide_width'];

    $TadUpFilesSlide = TadUpFilesSlide();
    $TadUpFilesSlide->set_col('slide', $theme_id);
    $TadUpFilesSlide->upload_file('slide', $slide_width, null, null, "", true);
    $TadUpFilesBg = TadUpFilesBg();
    $TadUpFilesBg->set_col('bg', $theme_id);
    $TadUpFilesBg->upload_file('bg', null, null, null, "", true);
    $TadUpFilesLogo = TadUpFilesLogo();
    $TadUpFilesLogo->set_col('logo', $theme_id);
    $TadUpFilesLogo->upload_file('logo', null, null, null, "", true);
    $TadUpFilesNavLogo = TadUpFilesNavLogo();
    $TadUpFilesNavLogo->set_col('navlogo', $theme_id);
    $TadUpFilesNavLogo->upload_file('navlogo', null, null, null, "", true);
    $TadUpFilesNavBg = TadUpFilesNavBg();
    $TadUpFilesNavBg->set_col('navbar_img', $theme_id);
    $TadUpFilesNavBg->upload_file('navbar_img', null, null, null, "", true);

    //儲存區塊設定
    save_blocks($theme_id);

    //儲存額外設定值
    if ($_POST['config2'] == '1') {
        save_config2($theme_id);
    }
    //$TadUpFiles->upload_file($upname,$width,$thumb_width,$files_sn,$desc,$safe_name=false,$hash=false);
    return $theme_id;
}

//以流水號取得某筆tad_themes資料
function get_tad_themes()
{
    global $xoopsDB, $xoopsConfig;
    if (empty($xoopsConfig['theme_set'])) {
        return;
    }

    if (!file_exists(XOOPS_ROOT_PATH . "/themes/{$xoopsConfig['theme_set']}/config.php")) {
        return;
    }

    $sql    = "select * from " . $xoopsDB->prefix("tad_themes") . " where theme_name='{$xoopsConfig['theme_set']}'";
    $result = $xoopsDB->query($sql) or die($sql . "<br>" . mysql_error());
    $data   = $xoopsDB->fetchArray($result);
    return $data;
}

//刪除tad_themes某筆資料資料
function delete_tad_themes($theme_id = "")
{
    global $xoopsDB, $xoopsConfig, $block_position_title;
    $sql = "delete from " . $xoopsDB->prefix("tad_themes") . " where theme_id='$theme_id'";
    $xoopsDB->queryF($sql) or die($sql . "<br>" . mysql_error());
    $sql = "delete from " . $xoopsDB->prefix("tad_themes_blocks") . " where theme_id='$theme_id'";
    $xoopsDB->queryF($sql) or die($sql . "<br>" . mysql_error());
    $sql = "delete from " . $xoopsDB->prefix("tad_themes_config2") . " where theme_id='$theme_id'";
    $xoopsDB->queryF($sql) or die($sql . "<br>" . mysql_error());

    $TadUpFilesSlide = TadUpFilesSlide();
    $TadUpFilesSlide->set_col('slide', $theme_id);
    $TadUpFilesSlide->del_files();
    $TadUpFilesBg = TadUpFilesBg();
    $TadUpFilesBg->set_col('bg', $theme_id);
    $TadUpFilesBg->del_files();
    $TadUpFilesLogo = TadUpFilesLogo();
    $TadUpFilesLogo->set_col('logo', $theme_id);
    $TadUpFilesLogo->del_files();
    $TadUpFilesNavLogo = TadUpFilesNavLogo();
    $TadUpFilesNavLogo->set_col('navlogo', $theme_id);
    $TadUpFilesNavLogo->del_files();
    $TadUpFilesNavBg = TadUpFilesNavBg();
    $TadUpFilesNavBg->set_col('navbar_img', $theme_id);
    $TadUpFilesNavBg->del_files();

    $TadUpFilesBt_bg = TadUpFilesBt_bg();
    foreach ($block_position_title as $position => $title) {
        $TadUpFilesBt_bg->set_col("bt_bg_{$position}", $theme_id);
        $TadUpFilesBt_bg->del_files();
    }
}

//取得額外設定的儲存值
function get_config2_values($theme_id = "")
{
    global $xoopsDB, $xoopsConfig;
    $sql    = "select `name`, `type`, `value` from " . $xoopsDB->prefix("tad_themes_config2") . " where `theme_id`='{$theme_id}'";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error() . "<br>" . $sql);
    //`theme_id`, `name`, `type`, `value`
    while (list($name, $type, $value) = $xoopsDB->fetchRow($result)) {
        $values[$name] = $value;
    }
    return $values;
}

//取得區塊設定
function get_blocks_values($theme_id = "", $block_position = "")
{
    global $xoopsDB, $xoopsConfig, $block_position_title;

    $theme_name = $xoopsConfig['theme_set'];
    include XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php";
    foreach ($config_enable as $k => $v) {
        $$k = $v['default'];
    }

    $bt_bg_img = !empty($bt_bg_img) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/bt_bg/{$bt_bg_img}" : "";

    $and_block_position = !empty($block_position) ? "and `block_position`='{$block_position}'" : "";
    $sql                = "select * from " . $xoopsDB->prefix("tad_themes_blocks") . " where `theme_id`='{$theme_id}' {$and_block_position}";
    $result             = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error() . "<br>" . $sql);
    //`theme_id`, `block_position`, `block_config`, `bt_text`, `bt_text_padding`, `bt_text_size`, `bt_bg_color`, `bt_bg_img`, `bt_bg_repeat`, `bt_radius`
    while ($all = $xoopsDB->fetchArray($result)) {
        $block_position      = $all['block_position'];
        $db[$block_position] = $all;
    }

    $i      = 0;
    $values = "";
    foreach ($block_position_title as $position => $title) {

        $values[$i]['theme_id']            = $db[$position]['theme_id'];
        $values[$i]['block_position']      = $position;
        $values[$i]['block_config']        = !isset($db[$position]['block_config']) ? $block_config : $db[$position]['block_config'];
        $values[$i]['bt_text']             = !isset($db[$position]['bt_text']) ? $bt_text : $db[$position]['bt_text'];
        $values[$i]['bt_text_padding']     = !isset($db[$position]['bt_text_padding']) ? $bt_text_padding : $db[$position]['bt_text_padding'];
        $values[$i]['bt_text_size']        = !isset($db[$position]['bt_text_size']) ? $bt_text_size : $db[$position]['bt_text_size'];
        $values[$i]['bt_bg_color']         = !isset($db[$position]['bt_bg_color']) ? $bt_bg_color : $db[$position]['bt_bg_color'];
        $values[$i]['bt_bg_img']           = !isset($db[$position]['bt_bg_img']) ? $bt_bg_img : $db[$position]['bt_bg_img'];
        $values[$i]['bt_bg_repeat']        = !isset($db[$position]['bt_bg_repeat']) ? $bt_bg_repeat : $db[$position]['bt_bg_repeat'];
        $values[$i]['bt_radius']           = !isset($db[$position]['bt_radius']) ? $bt_radius : $db[$position]['bt_radius'];
        $values[$i]['block_style']         = !isset($db[$position]['block_style']) ? $block_style : $db[$position]['block_style'];
        $values[$i]['block_title_style']   = !isset($db[$position]['block_title_style']) ? $block_title_style : $db[$position]['block_title_style'];
        $values[$i]['block_content_style'] = !isset($db[$position]['block_content_style']) ? $block_content_style : $db[$position]['block_content_style'];
        $values[$i]['title']               = $title;

        $TadUpFilesBt_bg = TadUpFilesBt_bg();

        $TadUpFilesBt_bg->set_col("bt_bg_{$position}", $theme_id);
        $values[$i]['all_bt_bg']    = $TadUpFilesBt_bg->get_file_for_smarty();
        $values[$i]['upform_bt_bg'] = $TadUpFilesBt_bg->upform(false, "bt_bg_{$position}", null, false);
        $i++;
    }
    return $values;
}
/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op       = system_CleanVars($_REQUEST, 'op', '', 'string');
$theme_id = system_CleanVars($_REQUEST, 'theme_id', 0, 'int');

switch ($op) {
    /*---判斷動作請貼在下方---*/

    //新增資料
    case "insert_tad_themes":
        $theme_id = insert_tad_themes();
        header("location: {$_SERVER['PHP_SELF']}?theme_id=$theme_id");
        exit;
        break;

    //更新資料
    case "update_tad_themes":
        update_tad_themes($theme_id);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;
        break;

    //輸入表格
    case "tad_themes_form":
        tad_themes_form();
        break;

    //刪除資料
    case "delete_tad_themes":
        delete_tad_themes($theme_id);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;
        break;

    //預設動作
    default:
        tad_themes_form();
        break;

    /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
//$xoTheme->addStylesheet(XOOPS_URL.'/modules/tadtools/css/xoops_adm.css');
include_once 'footer.php';
