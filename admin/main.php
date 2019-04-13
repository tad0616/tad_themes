<?php
/*-----------引入檔案區-------------- */
$xoopsOption['template_main'] = 'tad_themes_adm_main.tpl';
include_once 'header.php';
include_once '../auto_import_theme.php';

/*-----------function區-------------- */

//tad_themes編輯表單
function tad_themes_form()
{
    global $xoopsDB, $xoopsUser, $xoopsConfig, $xoopsTpl, $block_position_title, $xoTheme, $TadDataCenter, $config2_files;

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
        $DBV = [];
    }

    //設定「theme_id」欄位預設值
    $theme_id = (!isset($DBV['theme_id'])) ? 0 : $DBV['theme_id'];
    if (empty($theme_id)) {
        auto_import_theme();
        header('location: main.php');
        exit;
    }

    import_img(_THEME_BG_PATH, 'bg', $theme_id, '');
    import_img(_THEME_LOGO_PATH, 'logo', $theme_id);
    import_img(_THEME_SLIDE_PATH, 'slide', $theme_id, _TAD_SLIDE_DEFAULT_DESCRIPT, true);
    import_img(_THEME_NAV_BG_PATH, 'navbar_img', $theme_id);
    import_img(_THEME_NAVLOGO_PATH, 'navlogo', $theme_id);
    foreach ($block_position_title as $position => $ttt) {
        import_img(_THEME_BT_BG_PATH, "bt_bg_{$position}", $theme_id);
    }

    //設定「theme_name」欄位預設值
    $theme_name = (!isset($DBV['theme_name'])) ? $xoopsConfig['theme_set'] : $DBV['theme_name'];

    /*
    $theme_change=1; //佈景種類是否可自訂
    $theme_kind='bootstrap3';//預設佈景種類 bootstrap3 or html or mix
    $config_tabs=array();//欲使用的頁籤
    $config_enable['設定項目'] = array('enable', 'min', 'max', 'require', 'default'); //各設定項細節
     */

    if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php")) {
        include_once XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php";
        foreach ($config_enable as $k => $v) {
            $$k = $v['default'];
            $enable[$k] = $v['enable'];
            if ('theme_width' == $k) {
                if (false === mb_strpos($DBV['theme_kind'], 'bootstrap')) {
                    $v['max'] = '';
                    $v['min'] = '';
                    $v['default'] = '980';
                } else {
                    $v['max'] = '12';
                    $v['min'] = '1';
                    $v['default'] = '12';
                }
            }
            $validate[$k] = get_validate($v);
        }
        $xoopsTpl->assign('validate', $validate);
        $xoopsTpl->assign('enable', $enable);

        $bg_img = !empty($bg_img) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/bg/{$bg_img}" : '';
        $logo_img = !empty($logo_img) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/logo/{$logo_img}" : '';
        $navlogo_img = !empty($navlogo_img) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/navlogo/{$navlogo_img}" : '';
        $navbar_img = !empty($navbar_img) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/nav_bg/{$navbar_img}" : '';
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

    //設定「cb_width」欄位預設值
    $cb_width = (!isset($DBV['cb_width']) or !$enable['cb_width']) ? $cb_width : $DBV['cb_width'];

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

    //設定「logo_center」欄位預設值
    $logo_center = (!isset($DBV['logo_center']) or !$enable['logo_center']) ? $logo_center : $DBV['logo_center'];

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

    $op = (empty($theme_id)) ? 'insert_tad_themes' : 'update_tad_themes';
    //$op="replace_tad_themes";

    if ('bootstrap4' == $theme_kind) {
        $theme_kind_txt = _MA_TADTHEMES_THEME_KIND_BOOTSTRAP4;
        $chang_css = change_css_bootstrap($theme_width, $lb_width, $cb_width);
        $theme_unit = _MA_TADTHEMES_COL;
    } elseif ('bootstrap3' == $theme_kind) {
        $theme_kind_txt = _MA_TADTHEMES_THEME_KIND_BOOTSTRAP3;
        $chang_css = change_css_bootstrap($theme_width, $lb_width);
        $theme_unit = _MA_TADTHEMES_COL;
    } elseif ('mix' == $theme_kind) {
        $theme_kind_txt = _MA_TADTHEMES_THEME_KIND_MIX;
        $chang_css = change_css_bootstrap(12, $lb_width);
        $theme_unit = _MA_TADTHEMES_COL;
    } else {
        $theme_kind_txt = _MA_TADTHEMES_THEME_KIND_HTML;
        $chang_css = change_css($theme_width, $lb_width);
        $theme_unit = 'px';
    }

    $theme_kind_txt_arr = ['bootstrap4' => _MA_TADTHEMES_THEME_KIND_BOOTSTRAP4, 'bootstrap3' => _MA_TADTHEMES_THEME_KIND_BOOTSTRAP3, 'html' => _MA_TADTHEMES_THEME_KIND_HTML, 'mix' => _MA_TADTHEMES_THEME_KIND_MIX];

    if (!file_exists(TADTOOLS_PATH . '/formValidator.php')) {
        redirect_header('index.php', 3, _MA_NEED_TADTOOLS);
    }
    include_once TADTOOLS_PATH . '/formValidator.php';
    $formValidator = new formValidator('#myForm', true);
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
    $xoopsTpl->assign('cb_width', $cb_width);
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
    $xoopsTpl->assign('upform_bg', $TadUpFilesBg->upform(false, 'bg', null, false));
    $xoopsTpl->assign('bg_color', $bg_color);
    $xoopsTpl->assign('bg_repeat', $bg_repeat);
    $xoopsTpl->assign('bg_attachment', $bg_attachment);
    $xoopsTpl->assign('bg_position', $bg_position);

    $TadUpFilesBg->set_col('bg', $theme_id);
    $xoopsTpl->assign('all_bg', $TadUpFilesBg->get_file_for_smarty());
    //$xoopsTpl->assign('list_del_file_bg',$TadUpFilesBg->list_del_file());

    $xoopsTpl->assign('use_slide', $use_slide);
    $TadUpFilesSlide = TadUpFilesSlide();
    $TadUpFilesSlide->set_col('slide', $theme_id);
    $xoopsTpl->assign('upform_slide', $TadUpFilesSlide->upform(true, 'slide', null, true));
    $TadUpFilesLogo = TadUpFilesLogo();
    $TadUpFilesLogo->set_col('logo', $theme_id);
    $xoopsTpl->assign('all_logo', $TadUpFilesLogo->get_file_for_smarty());
    $xoopsTpl->assign('logo_img', $logo_img);
    $xoopsTpl->assign('upform_logo', $TadUpFilesLogo->upform(true, 'logo', null, false));
    $TadUpFilesNavLogo = TadUpFilesNavLogo();
    $TadUpFilesNavLogo->set_col('navlogo', $theme_id);
    $xoopsTpl->assign('all_navlogo', $TadUpFilesNavLogo->get_file_for_smarty());
    $xoopsTpl->assign('navlogo_img', $navlogo_img);
    $xoopsTpl->assign('upform_navlogo', $TadUpFilesNavLogo->upform(false, 'navlogo', null, false));
    $TadUpFilesNavBg = TadUpFilesNavBg();
    $TadUpFilesNavBg->set_col('navbar_img', $theme_id);
    $xoopsTpl->assign('all_navbar_img', $TadUpFilesNavBg->get_file_for_smarty());
    $xoopsTpl->assign('navbar_img', $navbar_img);
    $xoopsTpl->assign('upform_navbar_img', $TadUpFilesNavBg->upform(false, 'navbar_img', null, false));

    $xoopsTpl->assign('logo_position', $logo_position);
    $xoopsTpl->assign('logo_top', $logo_top);
    $xoopsTpl->assign('logo_left', $logo_left);
    $xoopsTpl->assign('logo_center', $logo_center);
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

    foreach ($config2_files as $config2_file) {
        mk_config2($theme_id, $theme_name, $config2_file);
    }

    if (!file_exists(XOOPS_ROOT_PATH . '/modules/tadtools/mColorPicker.php')) {
        redirect_header('index.php', 3, _MA_NEED_TADTOOLS);
    }
    include_once XOOPS_ROOT_PATH . '/modules/tadtools/mColorPicker.php';
    $mColorPicker = new mColorPicker('.color');
    $mColorPicker->render();

    $xoTheme->addScript('modules/tadtools/jqueryCookie/jquery.cookie.js');

    if (!file_exists(XOOPS_ROOT_PATH . '/modules/tadtools/easy_responsive_tabs.php')) {
        redirect_header('index.php', 3, _MA_NEED_TADTOOLS);
    }
    include_once XOOPS_ROOT_PATH . '/modules/tadtools/easy_responsive_tabs.php';
    $responsive_tabs = new easy_responsive_tabs('#themeTab');
    $responsive_tabs->rander('tab_identifier_parent');

    $block_tabs = new easy_responsive_tabs('#bt_tabs', 'vertical');
    $block_tabs->rander('tab_identifier_child');

    $TadDataCenter->set_col('theme_id', $theme_id);
    $xoopsTpl->assign('navbar_py_input', $TadDataCenter->getForm('return', 'input', 'navbar_py', 'text', $navbar_py, null, ['class' => 'form-control']));
    $xoopsTpl->assign('navbar_py_hidden', $TadDataCenter->getForm('return', 'input', 'navbar_py', 'hidden', $navbar_py, null, ['class' => 'form-control']));

    $xoopsTpl->assign('navbar_px_input', $TadDataCenter->getForm('return', 'input', 'navbar_px', 'text', $navbar_px, null, ['class' => 'form-control']));
    $xoopsTpl->assign('navbar_px_hidden', $TadDataCenter->getForm('return', 'input', 'navbar_px', 'hidden', $navbar_px, null, ['class' => 'form-control']));

    $xoopsTpl->assign('navbar_font_size_input', $TadDataCenter->getForm('return', 'input', 'navbar_font_size', 'text', 100, null, ['class' => 'form-control']));
    $xoopsTpl->assign('navbar_font_size_hidden', $TadDataCenter->getForm('return', 'input', 'navbar_font_size', 'hidden', 100, null, ['class' => 'form-control']));
}

function mk_config2($theme_id = '', $theme_name = '', $config2_file = '')
{
    global $xoopsTpl, $xoopsConfig;

    if (file_exists(XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php")) {
        $myts = MyTextSanitizer::getInstance();
        include_once XOOPS_ROOT_PATH . "/themes/{$theme_name}/language/{$xoopsConfig['language']}/main.php";
        include_once XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$config2_file}.php";

        $config2_values = get_config2_values($theme_id);
        $TadUpFiles_config2 = TadUpFiles_config2();
        foreach ($theme_config as $k => $config) {
            $config_name = $config['name'];
            $value = $myts->htmlSpecialChars($config2_values[$config_name]);

            $config2[$k]['name'] = $config_name;
            $config2[$k]['text'] = $config['text'];
            $config2[$k]['desc'] = $config['desc'];
            $config2[$k]['type'] = $config['type'];
            $config2[$k]['value'] = $value;
            $config2[$k]['default'] = $config['default'];
            $config2[$k]['options'] = $config['options'];
            $config2[$k]['images'] = $config['images'];

            if ('file' == $config['type']) {
                import_img($config['default'], "config2_{$config_name}", $theme_id, '');
                $TadUpFiles_config2->set_col("config2_{$config_name}", $theme_id);
                $config2[$k]['form'] = $TadUpFiles_config2->upform(false, "config2_{$config_name}", null, false);
                $config2[$k]['list'] = $TadUpFiles_config2->get_file_for_smarty();
                // die(var_export($theme_id));
                // die("list:" . $config2[$k]['list']);
            }
        }
        $xoopsTpl->assign($config2_file, $config2);
    } else {
        $xoopsTpl->assign($config2_file, '');
    }
}

function change_css_bootstrap($theme_width = '12', $theme_left_width = '', $theme_center_width = '')
{
    $theme_width = empty($theme_width) ? 12 : $theme_width;
    $theme_left_width = (empty($theme_left_width) or $theme_left_width == $theme_width) ? 3 : $theme_left_width;
    $theme_center_width = (empty($theme_center_width) or $theme_center_width == $theme_width) ? 9 : $theme_center_width;
    $main = "
    function change_css(){
        //原始頁寬，如:12
        var theme_width_org = {$theme_width};
        //原始區域寬，如:12
        var lb_width_org = '{$theme_left_width}';
        //原始區域寬，如:12
        var cb_width_org = '{$theme_center_width}';
        //原始區域寬，如:12
        var rb_width_org = '{$theme_left_width}';

        //模擬頁寬
        var theme_width = Math.round(theme_width_org * 80/4);
        //模擬視窗寬
        var preview_width = Math.round(theme_width_org * 80/2);
        //模擬區之外框寬
        var theme_div_width= theme_width+11;

        //滑動圖文框原始高
        // var slide_height_org = $('#slide_height').val();
        //滑動圖文框模擬高
        var slide_height= 30;

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
            $('#lb_width').prop('readonly',false);
            $('#rb_width').val($('#lb_width').val()).prop('readonly','readonly');
        }else if(theme_type=='theme_type_2'){
            $('#rb_width').prop('readonly',false);
            $('#lb_width').val($('#rb_width').val()).prop('readonly','readonly');
        }else if(theme_type=='theme_type_3'){
            $('#lb_width').prop('readonly',false);
            $('#rb_width').val({$theme_width}).prop('readonly','readonly');
        }else if(theme_type=='theme_type_4'){
            $('#lb_width').prop('readonly',false);
            $('#rb_width').val({$theme_width}).prop('readonly','readonly');
        }else if(theme_type=='theme_type_5' || theme_type=='theme_type_6' || theme_type=='theme_type_7' ){
            $('#lb_width').prop('readonly',false);
            $('#rb_width').prop('readonly',false);
        }else if(theme_type=='theme_type_8'){
            $('#lb_width').val(theme_width_org).prop('readonly','readonly');
            $('#rb_width').val(theme_width_org).prop('readonly','readonly');
        }else{
            $('#lb_width').prop('readonly',false);
            $('#rb_width').prop('readonly',false);
        }

        var cbw = $('#cb_width').val();

        //左區塊原始寬
        var lbw = $('#lb_width').val();
        if(lbw == 'auto' || lbw == ''){
            //左區塊原始寬
            var lb_width_org = $theme_width - cbw;
        }else{
            //左區塊原始寬
            var lb_width_org = lbw * 1;
        }

        //左區塊模擬寬
        var lb_width = Math.round(lb_width_org * 80/4)-3;

        //右區塊原始寬
        var rbw = $('#rb_width').val();
        if(rbw == 'auto' || rbw == ''){
            //右區塊原始寬
            var rb_width_org = $theme_width - cbw;
        }else{
            //右區塊原始寬
            var rb_width_org=$('#rb_width').val()*1;
        }
        //右區塊模擬寬
        var rb_width=Math.round(rb_width_org * 80 /4)-3;

        if(theme_type=='theme_type_5' || theme_type=='theme_type_6' || theme_type=='theme_type_7'){
            lb_width=lb_width/2;
            rb_width=rb_width/2;
        }

        //中間區塊原始寬
        if(lbw == 'auto' || lbw == '' || rbw == 'auto' || rbw == ''){
            var center_width_org = cbw;
            console.log('auto:'+center_width_org);
        }else{
            var center_width_org = {$theme_width} - $('#lb_width').val()*1;
            console.log(center_width_org);
        }
        //中間區塊模擬寬
        var center_width=Math.round(center_width_org * 80 /4)-3;


        if(theme_type=='theme_type_1'){
            $('#left_block').css('float','left').css('margin','2px 2px 2px 4px').css('width',lb_width).css('height','86px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lbw +'" . _MA_TADTHEMES_COL . "</div>');
            $('#center_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',center_width).css('height','178px').css('line-height','178px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'" . _MA_TADTHEMES_COL . "');
            $('#right_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',rb_width).css('height','86px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rbw+'" . _MA_TADTHEMES_COL . "</div>');
            $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');

        }else if(theme_type=='theme_type_2'){
            $('#left_block').css('float','right').css('margin','2px 4px 2px 2px').css('width',lb_width).css('height','86px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lbw +'" . _MA_TADTHEMES_COL . "</div>');
            $('#center_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',center_width).css('height','178px').css('line-height','178px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'" . _MA_TADTHEMES_COL . "');
            $('#right_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',rb_width).css('height','86px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rbw+'" . _MA_TADTHEMES_COL . "</div>');
            $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');


        }else if(theme_type=='theme_type_3'){
            $('#left_block').css('float','left').css('margin','2px 2px 2px 4px').css('width',lb_width).css('height','132px').html('<div style=\'line-height:12px;margin-top:60px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lbw +'" . _MA_TADTHEMES_COL . "</div>');
            $('#center_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',center_width).css('height','132px').css('line-height','132px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'" . _MA_TADTHEMES_COL . "');
            $('#right_block').css('float','none').css('margin','2px 2px 4px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('" . _MA_TAD_THEMES_RIGHT . " '+theme_width_org+'" . _MA_TADTHEMES_COL . "');
            $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');


        }else if(theme_type=='theme_type_4'){
            $('#left_block').css('float','right').css('margin','2px 4px 2px 2px').css('width',lb_width).css('height','132px').html('<div style=\'line-height:12px;margin-top:60px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lbw +'" . _MA_TADTHEMES_COL . "</div>');
            $('#center_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',center_width).css('height','132px').css('line-height','132px').html('" . _MA_TAD_THEMES_CENTER . " '+center_width_org+'" . _MA_TADTHEMES_COL . "');
            $('#right_block').css('float','none').css('margin','2px 2px 4px 4px').css('width',theme_width).css('height','40px').css('line-height','40px').css('clear','both').html('" . _MA_TAD_THEMES_RIGHT . " '+theme_width_org+'" . _MA_TADTHEMES_COL . "');
            $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');


        }else if(theme_type=='theme_type_5'){
            $('#left_block').css('float','left').css('margin','2px 2px 4px 4px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lbw +'" . _MA_TADTHEMES_COL . "</div>');
            $('#center_block').css('float','left').css('margin','2px 0px 4px 0px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_CENTER . "<br />'+center_width_org+'" . _MA_TADTHEMES_COL . "</div>');
            $('#right_block').css('float','right').css('margin','2px 4px 4px 2px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rbw+'" . _MA_TADTHEMES_COL . "</div>');
            $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');


        }else if(theme_type=='theme_type_6'){
            $('#left_block').css('float','left').css('margin','2px 0px 4px 4px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lbw +'" . _MA_TADTHEMES_COL . "</div>');
            $('#center_block').css('float','right').css('margin','2px 4px 4px 0px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_CENTER . "<br />'+center_width_org+'" . _MA_TADTHEMES_COL . "</div>');
            $('#right_block').css('float','left').css('margin','2px 2px 4px 2px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rbw+'" . _MA_TADTHEMES_COL . "</div>');
        $('#cb_width').html(center_width_org+'" . _MA_TADTHEMES_COL . "');


        }else if(theme_type=='theme_type_7'){
            $('#left_block').css('float','right').css('margin','2px 4px 4px 0px').css('width',lb_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_LEFT . " '+ lbw +'" . _MA_TADTHEMES_COL . "</div>');
            $('#center_block').css('float','left').css('margin','2px 0px 4px 4px').css('width',center_width).css('height','178px').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_CENTER . "<br />'+center_width_org+'" . _MA_TADTHEMES_COL . "</div>');
            $('#right_block').css('float','right').css('margin','2px 2px 4px 2px').css('width',rb_width).css('height','178px').css('clear','none').html('<div style=\'line-height:12px;margin-top:30px;\'>" . _MA_TAD_THEMES_RIGHT . " '+rbw+'" . _MA_TADTHEMES_COL . "</div>');
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

function get_validate($col = [])
{
    if ('1' == $col['enable']) {
        $v_item[] = $col['require'] ? 'required' : '';
        $v_item[] = $col['min'] ? "min[{$col['min']}]" : '';
        $v_item[] = $col['max'] ? "max[{$col['max']}]" : '';
        $class = implode(',', $v_item);
        if (',,' == $class) {
            return;
        }

        return " validate[{$class}]";
    }

    return '" readonly="readonly';
}

function change_css($theme_width, $theme_left_width)
{
    $theme_width = empty($theme_width) ? 980 : $theme_width;
    $theme_left_width = (empty($theme_left_width) or $theme_left_width == $theme_width) ? 220 : $theme_left_width;
    $main = "
    function change_css(){
        var theme_width_org = $theme_width;
        var lb_width_org = $theme_left_width;
        var theme_width = Math.round(theme_width_org/4);
        //var preview_width = Math.round(theme_width_org/2);
        var preview_width = $('#preview_width').width();
        var theme_div_width= theme_width+11;
        // var slide_height_org = $('#slide_height').val();
        var slide_height= 30;
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


        if(them e_type!='theme_type_8'){
            if($('#lb_width').val()==theme_width_org){
                $('#lb_width').val(lb_width_org);
            }
            if($('#rb_width').val()==theme_width_org){
                $('#rb_width').val(lb_width_org);
            }
        }

        if(theme_type=='theme_type_1'){
            $('#lb_width').prop('readonly',false);
            $('#rb_width').val($('#lb_width').val()).prop('readonly','readonly');
        }else if(theme_type=='theme_type_2'){
            $('#lb_width').prop('readonly',false);
            $('#rb_width').val($('#lb_width').val()).prop('readonly','readonly');
        }else if(theme_type=='theme_type_3'){
            $('#lb_width').prop('readonly',false);
            $('#rb_width').val($theme_width).prop('readonly','readonly');
        }else if(theme_type=='theme_type_4'){
            $('#lb_width').prop('readonly',false);
            $('#rb_width').val($theme_width).prop('readonly','readonly');
        }else if(theme_type=='theme_type_5' || theme_type=='theme_type_6' || theme_type=='theme_type_7' ){
            $('#lb_width').prop('readonly',false);
            $('#rb_width').prop('readonly',false);
        }else if(theme_type=='theme_type_8'){
            $('#lb_width').val(theme_width_org).prop('readonly','readonly');
            $('#rb_width').val(theme_width_org).prop('readonly','readonly');
        }else{
            $('#lb_width').prop('readonly',false);
            $('#rb_width').prop('readonly',false);
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
    global $xoopsDB, $xoopsUser, $xoopsConfig, $TadDataCenter;

    $myts = MyTextSanitizer::getInstance();
    $_POST['theme_width'] = $myts->addSlashes($_POST['theme_width']);
    $_POST['lb_width'] = $myts->addSlashes($_POST['lb_width']);
    $_POST['cb_width'] = $myts->addSlashes($_POST['cb_width']);
    $_POST['rb_width'] = $myts->addSlashes($_POST['rb_width']);
    $_POST['clb_width'] = $myts->addSlashes($_POST['clb_width']);
    $_POST['crb_width'] = $myts->addSlashes($_POST['crb_width']);
    $_POST['slide_width'] = $myts->addSlashes($_POST['slide_width']);
    $_POST['slide_height'] = $myts->addSlashes($_POST['slide_height']);

    $sql = 'update ' . $xoopsDB->prefix('tad_themes') . " set `theme_enable`='0'";
    $xoopsDB->query($sql) or web_error($sql, __FILE__, __LINE__);

    $_POST['logo_top'] = (int) $_POST['logo_top'];
    $_POST['logo_right'] = (int) $_POST['logo_right'];
    $_POST['logo_bottom'] = (int) $_POST['logo_bottom'];
    $_POST['logo_left'] = (int) $_POST['logo_left'];
    $_POST['logo_center'] = (int) $_POST['logo_center'];

    //此處增加7+4項by hc
    $sql = 'insert into ' . $xoopsDB->prefix('tad_themes') . "
    (`theme_name` , `theme_type` , `theme_width` , `lb_width`, `cb_width` , `rb_width` , `clb_width` , `crb_width`, `base_color` , `lb_color` , `cb_color` , `rb_color` , `margin_top` , `margin_bottom` , `bg_img` , `bg_color`  , `bg_repeat`  , `bg_attachment`  , `bg_position`  , `logo_img` , `logo_position` , `logo_top` , `logo_right` , `logo_bottom` , `logo_left`, `logo_center` , `theme_enable` , `slide_width` , `slide_height` , `font_size` , `font_color` , `link_color` , `hover_color` , `theme_kind`, `navbar_pos` , `navbar_bg_top` , `navbar_bg_bottom` , `navbar_hover` , `navbar_color` , `navbar_color_hover` , `navbar_icon` , `navbar_img`)
    values('{$_POST['theme_name']}', '{$_POST['theme_type']}', '{$_POST['theme_width']}', '{$_POST['lb_width']}', '{$_POST['cb_width']}', '{$_POST['rb_width']}', '{$_POST['clb_width']}', '{$_POST['crb_width']}', '{$_POST['base_color']}', '{$_POST['lb_color']}', '{$_POST['cb_color']}', '{$_POST['rb_color']}', '{$_POST['margin_top']}', '{$_POST['margin_bottom']}', '{$_POST['bg_img']}', '{$_POST['bg_color']}', '{$_POST['bg_repeat']}', '{$_POST['bg_attachment']}', '{$_POST['bg_position']}', '{$_POST['logo_img']}', '{$_POST['logo_position']}', '{$_POST['navlogo_img']}', '{$_POST['logo_top']}', '{$_POST['logo_right']}', '{$_POST['logo_bottom']}', '{$_POST['logo_left']}', '{$_POST['logo_center']}', '1', '{$_POST['slide_width']}', '{$_POST['slide_height']}', '{$_POST['font_size']}', '{$_POST['font_color']}', '{$_POST['link_color']}', '{$_POST['hover_color']}', '{$_POST['theme_kind']}','{$_POST['navbar_pos']}','{$_POST['navbar_bg_top']}','{$_POST['navbar_bg_bottom']}','{$_POST['navbar_hover']}','{$_POST['navbar_color']}','{$_POST['navbar_color_hover']}','{$_POST['navbar_icon']}','{$_POST['navbar_img']}')";
    $xoopsDB->query($sql) or web_error($sql, __FILE__, __LINE__);

    //取得最後新增資料的流水編號
    $theme_id = $xoopsDB->getInsertId();

    $TadDataCenter->set_col('theme_id', $theme_id);
    $TadDataCenter->saveData();

    $slide_width = ('bootstrap3' == $_POST['theme_kind'] or 'bootstrap4' == $_POST['theme_kind']) ? 1920 : $_POST['slide_width'];

    $TadUpFilesSlide = TadUpFilesSlide();
    $TadUpFilesSlide->set_col('slide', $theme_id);
    $TadUpFilesSlide->upload_file('slide', $slide_width, null, null, '', true);
    $TadUpFilesBg = TadUpFilesBg();
    $TadUpFilesBg->set_col('bg', $theme_id);
    $TadUpFilesBg->upload_file('bg', 2048, null, null, '', true);
    $TadUpFilesLogo = TadUpFilesLogo();
    $TadUpFilesLogo->set_col('logo', $theme_id);
    $TadUpFilesLogo->upload_file('logo', 2048, null, null, '', true);
    $TadUpFilesNavLogo = TadUpFilesNavLogo();
    $TadUpFilesNavLogo->set_col('navlogo', $theme_id);
    $TadUpFilesNavLogo->upload_file('navlogo', null, null, null, '', true);
    $TadUpFilesNavBg = TadUpFilesNavBg();
    $TadUpFilesNavBg->set_col('navbar_img', $theme_id);
    $TadUpFilesNavBg->upload_file('navbar_img', null, null, null, '', true);
    //儲存區塊設定
    save_blocks($theme_id);

    //儲存額外設定值
    save_config2($theme_id, $_POST['config2']);

    return $theme_id;
}

//更新tad_themes某一筆資料
function update_tad_themes($theme_id = '')
{
    global $xoopsDB, $xoopsUser, $xoopsConfig, $TadDataCenter;

    //切換佈景類型
    if (isset($_POST['old_theme_kind']) and $_POST['old_theme_kind'] !== $_POST['theme_kind']) {
        if ('mix' == $_POST['theme_kind']) {
            $_POST['theme_width'] = 980;
            $_POST['lb_width'] = 3;
            $_POST['cb_width'] = 6;
            $_POST['rb_width'] = 3;
            $_POST['slide_width'] = 980;
        } elseif ('html' == $_POST['theme_kind']) {
            $_POST['theme_width'] = 980;
            $_POST['lb_width'] = 240;
            $_POST['cb_width'] = 500;
            $_POST['rb_width'] = 240;
            $_POST['slide_width'] = 980;
        } elseif ('bootstrap4' == $_POST['theme_kind']) {
            $_POST['theme_width'] = 12;
            $_POST['lb_width'] = 'auto';
            $_POST['cb_width'] = 9;
            $_POST['rb_width'] = 'auto';
            $_POST['slide_width'] = 12;
        } else {
            $_POST['theme_kind'] = 'bootstrap3';
            $_POST['theme_width'] = 12;
            $_POST['lb_width'] = 3;
            $_POST['cb_width'] = 6;
            $_POST['rb_width'] = 3;
            $_POST['slide_width'] = 12;
        }
    }
    update_tadtools_setup($_POST['theme_name'], $_POST['theme_kind']);

    $myts = MyTextSanitizer::getInstance();
    $_POST['theme_width'] = $myts->addSlashes($_POST['theme_width']);
    $_POST['lb_width'] = $myts->addSlashes($_POST['lb_width']);
    $_POST['cb_width'] = $myts->addSlashes($_POST['cb_width']);
    $_POST['rb_width'] = $myts->addSlashes($_POST['rb_width']);
    $_POST['clb_width'] = $myts->addSlashes($_POST['clb_width']);
    $_POST['crb_width'] = $myts->addSlashes($_POST['crb_width']);
    $_POST['slide_width'] = $myts->addSlashes($_POST['slide_width']);
    $_POST['slide_height'] = $myts->addSlashes($_POST['slide_height']);

    $_POST['logo_top'] = (int) $_POST['logo_top'];
    $_POST['logo_right'] = (int) $_POST['logo_right'];
    $_POST['logo_bottom'] = (int) $_POST['logo_bottom'];
    $_POST['logo_left'] = (int) $_POST['logo_left'];
    $_POST['logo_center'] = (int) $_POST['logo_center'];

    $sql = 'update ' . $xoopsDB->prefix('tad_themes') . " set
    `theme_name` = '{$_POST['theme_name']}' ,
    `theme_type` = '{$_POST['theme_type']}' ,
    `theme_width` = '{$_POST['theme_width']}' ,
    `lb_width` = '{$_POST['lb_width']}' ,
    `cb_width` = '{$_POST['cb_width']}' ,
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
    `logo_center` = '{$_POST['logo_center']}' ,
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
    $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);

    $TadDataCenter->set_col('theme_id', $theme_id);
    $TadDataCenter->saveData();

    mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes/{$_POST['theme_name']}");

    $slide_width = ('bootstrap3' == $_POST['theme_kind'] or 'bootstrap4' == $_POST['theme_kind']) ? 1920 : $_POST['slide_width'];

    $TadUpFilesSlide = TadUpFilesSlide();
    $TadUpFilesSlide->set_col('slide', $theme_id);
    $TadUpFilesSlide->upload_file('slide', $slide_width, null, null, '', true);
    $TadUpFilesBg = TadUpFilesBg();
    $TadUpFilesBg->set_col('bg', $theme_id);
    $bg_img = $TadUpFilesBg->upload_file('bg', 2048, null, null, '', true);
    if ($bg_img) {
        update_theme('bg_img', 'bg', $bg_img, $theme_id, $_POST['theme_name']);
    }
    $TadUpFilesLogo = TadUpFilesLogo();
    $TadUpFilesLogo->set_col('logo', $theme_id);
    $logo_img = $TadUpFilesLogo->upload_file('logo', 2048, null, null, '', true);
    if ($logo_img) {
        update_theme('logo_img', 'logo', $logo_img, $theme_id, $_POST['theme_name']);
    }
    $TadUpFilesNavLogo = TadUpFilesNavLogo();
    $TadUpFilesNavLogo->set_col('navlogo', $theme_id);
    $navlogo_img = $TadUpFilesNavLogo->upload_file('navlogo', null, null, null, '', true);
    if ($navlogo_img) {
        update_theme('navlogo_img', 'navlogo', $navlogo_img, $theme_id, $_POST['theme_name']);
    }
    $TadUpFilesNavBg = TadUpFilesNavBg();
    $TadUpFilesNavBg->set_col('navbar_img', $theme_id);
    $navbar_img = $TadUpFilesNavBg->upload_file('navbar_img', null, null, null, '', true);
    if ($navbar_img) {
        update_theme('navbar_img', 'navbar', $navbar_img, $theme_id, $_POST['theme_name']);
    }

    //儲存區塊設定
    save_blocks($theme_id);

    //儲存額外設定值
    save_config2($theme_id, $_POST['config2']);
    //$TadUpFiles->upload_file($upname,$width,$thumb_width,$files_sn,$desc,$safe_name=false,$hash=false);
    return $theme_id;
}

//更新佈景的某個設定值
function update_theme($col = '', $folder = '', $file_name = '', $theme_id = '', $theme_name = '')
{
    global $xoopsDB, $xoopsUser, $xoopsConfig;
    $file_name_url = XOOPS_URL . "/uploads/tad_themes/{$theme_name}/{$folder}/{$file_name}";
    $sql = 'update ' . $xoopsDB->prefix('tad_themes') . " set `{$col}` = '{$file_name_url}' where theme_id='$theme_id'";
    $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
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

    $sql = 'select * from ' . $xoopsDB->prefix('tad_themes') . " where theme_name = '{$xoopsConfig['theme_set']}'";
    $result = $xoopsDB->query($sql) or web_error($sql, __FILE__, __LINE__);
    $data = $xoopsDB->fetchArray($result);

    return $data;
}

//刪除tad_themes某筆資料資料
function delete_tad_themes($theme_id = '')
{
    global $xoopsDB, $xoopsConfig, $block_position_title;
    $sql = 'delete from ' . $xoopsDB->prefix('tad_themes') . " where theme_id='$theme_id'";
    $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
    $sql = 'delete from ' . $xoopsDB->prefix('tad_themes_blocks') . " where theme_id='$theme_id'";
    $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
    $sql = 'delete from ' . $xoopsDB->prefix('tad_themes_config2') . " where theme_id='$theme_id'";
    $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);

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
function get_config2_values($theme_id = '')
{
    global $xoopsDB, $xoopsConfig;
    $sql = 'select `name`, `type`, `value` from ' . $xoopsDB->prefix('tad_themes_config2') . " where `theme_id` = '{$theme_id}'";
    $result = $xoopsDB->query($sql) or web_error($sql, __FILE__, __LINE__);
    //`theme_id`, `name`, `type`, `value`
    while (list($name, $type, $value) = $xoopsDB->fetchRow($result)) {
        $values[$name] = $value;
    }

    return $values;
}

//取得區塊設定
function get_blocks_values($theme_id = '', $block_position = '')
{
    global $xoopsDB, $xoopsConfig, $block_position_title;

    $theme_name = $xoopsConfig['theme_set'];
    include XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php";
    foreach ($config_enable as $k => $v) {
        $$k = $v['default'];
    }

    $bt_bg_img = !empty($bt_bg_img) ? XOOPS_URL . "/uploads/tad_themes/{$theme_name}/bt_bg/{$bt_bg_img}" : '';

    $and_block_position = !empty($block_position) ? "and `block_position` = '{$block_position}'" : '';
    $sql = 'select * from ' . $xoopsDB->prefix('tad_themes_blocks') . " where `theme_id` = '{$theme_id}' {$and_block_position}";
    $result = $xoopsDB->query($sql) or web_error($sql, __FILE__, __LINE__);
    //`theme_id`, `block_position`, `block_config`, `bt_text`, `bt_text_padding`, `bt_text_size`, `bt_bg_color`, `bt_bg_img`, `bt_bg_repeat`, `bt_radius`
    while ($all = $xoopsDB->fetchArray($result)) {
        $block_position = $all['block_position'];
        $db[$block_position] = $all;
    }

    $i = 0;
    $values = [];
    foreach ($block_position_title as $position => $title) {
        $values[$i]['theme_id'] = $db[$position]['theme_id'];
        $values[$i]['block_position'] = $position;
        $values[$i]['block_config'] = !isset($db[$position]['block_config']) ? $block_config : $db[$position]['block_config'];
        $values[$i]['bt_text'] = !isset($db[$position]['bt_text']) ? $bt_text : $db[$position]['bt_text'];
        $values[$i]['bt_text_padding'] = !isset($db[$position]['bt_text_padding']) ? $bt_text_padding : $db[$position]['bt_text_padding'];
        $values[$i]['bt_text_size'] = !isset($db[$position]['bt_text_size']) ? $bt_text_size : $db[$position]['bt_text_size'];
        $values[$i]['bt_bg_color'] = !isset($db[$position]['bt_bg_color']) ? $bt_bg_color : $db[$position]['bt_bg_color'];
        $values[$i]['bt_bg_img'] = !isset($db[$position]['bt_bg_img']) ? $bt_bg_img : $db[$position]['bt_bg_img'];
        $values[$i]['bt_bg_repeat'] = !isset($db[$position]['bt_bg_repeat']) ? $bt_bg_repeat : $db[$position]['bt_bg_repeat'];
        $values[$i]['bt_radius'] = !isset($db[$position]['bt_radius']) ? $bt_radius : $db[$position]['bt_radius'];
        $values[$i]['block_style'] = !isset($db[$position]['block_style']) ? $block_style : $db[$position]['block_style'];
        $values[$i]['block_title_style'] = !isset($db[$position]['block_title_style']) ? $block_title_style : $db[$position]['block_title_style'];
        $values[$i]['block_content_style'] = !isset($db[$position]['block_content_style']) ? $block_content_style : $db[$position]['block_content_style'];
        $values[$i]['title'] = $title;

        $TadUpFilesBt_bg = TadUpFilesBt_bg();

        $TadUpFilesBt_bg->set_col("bt_bg_{$position}", $theme_id);
        $values[$i]['all_bt_bg'] = $TadUpFilesBt_bg->get_file_for_smarty();
        $values[$i]['upform_bt_bg'] = $TadUpFilesBt_bg->upform(false, "bt_bg_{$position}", null, false);
        $i++;
    }

    return $values;
}

function export_config($theme_id = '')
{
    global $xoopsConfig, $xoopsDB;
    $theme_name = $xoopsConfig['theme_set'];
    include XOOPS_ROOT_PATH . "/themes/{$theme_name}/config.php";
    // foreach ($config_enable as $k => $v) {
    //     $$k = $v['default'];
    // }
    //抓取預設值
    $DBV = get_tad_themes();
    // die(var_export($DBV));
    foreach ($DBV as $k => $v) {
        $$k = $v;
        $config_enable[$k]['default'] = $v;
    }
    // die(var_export($config_enable));
    $bg_img_default = $bg_img_default_text = $logo_img_default = $logo_img_default_text = $bt_bg_img_default = $bt_bg_img_default_text = $navbar_img_default = $navbar_img_default_text = $navlogo_img_default = $navlogo_img_default_text = '';
    if ($config_enable['bg_img']['default']) {
        $bg_img_default = basename($config_enable['bg_img']['default']);
        $bg_img_default_text = "\n// 請下載 {$config_enable['bg_img']['default']} 並上傳至 " . XOOPS_ROOT_PATH . "/themes/{$theme_name}/images/bg/ 下";
    }
    if ($config_enable['logo_img']['default']) {
        $logo_img_default = basename($config_enable['logo_img']['default']);
        $logo_img_default_text = "\n// 請下載 {$config_enable['logo_img']['default']} 並上傳至 " . XOOPS_ROOT_PATH . "/themes/{$theme_name}/images/logo/ 下";
    }

    if ($config_enable['navbar_img']['default']) {
        $navbar_img_default = basename($config_enable['navbar_img']['default']);
        $navbar_img_default_text = "\n// 請下載 {$config_enable['navbar_img']['default']} 並上傳至 " . XOOPS_ROOT_PATH . "/themes/{$theme_name}/images/navbg/ 下";
    }
    if ($config_enable['navlogo_img']['default']) {
        $navlogo_img_default = basename($config_enable['navlogo_img']['default']);
        $navlogo_img_default_text = "\n// 請下載 {$config_enable['navlogo_img']['default']} 並上傳至 " . XOOPS_ROOT_PATH . "/themes/{$theme_name}/images/nav_logo/ 下";
    }

    //取得區塊設定
    $sql = 'select * from ' . $xoopsDB->prefix('tad_themes_blocks') . " where `theme_id` = '{$theme_id}'";
    $result = $xoopsDB->query($sql) or web_error($sql, __FILE__, __LINE__);
    while ($all = $xoopsDB->fetchArray($result)) {
        $block_position = $all['block_position'];
        $blocks[$block_position] = $all;
    }

    $bs = ['block_config', 'bt_text', 'bt_text_padding', 'bt_text_size', 'bt_bg_color', 'bt_bg_img', 'bt_bg_repeat', 'bt_radius', 'block_style', 'block_title_style', 'block_content_style'];

    foreach ($bs as $col) {
        $sql = "select `$col` from
        (
            select count(*) as c, `$col` from `" . $xoopsDB->prefix('tad_themes_blocks') . "` WHERE `theme_id` = '{$theme_id}' group by `$col`
        ) tmp
        order by c desc limit 1";

        $result = $xoopsDB->query($sql) or web_error($sql, __FILE__, __LINE__);
        list($bt_default[$col]) = $xoopsDB->fetchRow($result);
        if ('bt_bg_img' == $col) {
            if ($bt_default[$col] and 'transparent' != $bt_default[$col]) {
                $bt_bg_img_default = basename($bt_default[$col]);
                $bt_bg_img_default_text = "\n// 請下載 {$bt_default[$col]} 並上傳至 " . XOOPS_ROOT_PATH . "/themes/{$theme_name}/images/bt_bg/ 下";
            }
        }
    }

    $position_blocks = '';
    foreach ($blocks as $block_position => $b) {
        foreach ($b as $k => $v) {
            if (in_array($k, $bs, true)) {
                if ($bt_default[$k] != $v) {
                    if ('bt_bg_img' == $k) {
                        if ($v and 'transparent' != $v) {
                            $bt_bg_img_default_text .= "\n// 請下載 {$v} 並上傳至 " . XOOPS_ROOT_PATH . "/themes/{$theme_name}/images/bt_bg/ 下";
                            $v = basename($v);
                        }
                    }
                    $position_blocks .= "\$config_enable['{$k}']['{$block_position}'] = array('enable'=>1, 'min' => '', 'max' => '', 'require'=>0 , 'default' => '{$v}');\n";
                }
            }
        }
    }

    // die(var_export($blocks));
    $file = "<?php{$bg_img_default_text}{$logo_img_default_text}{$bt_bg_img_default_text}{$navbar_img_default_text}{$navlogo_img_default_text}
//佈景種類是否可自訂
\$theme_change = {$theme_change};

//預設佈景種類 bootstrap4 , bootstrap3 , html , mix
\$theme_kind = '{$theme_kind}';

//可選用佈景種類 bootstrap4 , bootstrap3 , html , mix （\$theme_change=1 時才有用）
\$theme_kind_arr = '{$theme_kind_arr}';

//引入哪些選單？ all(含 my_menu,admin,user),my_menu,admin,user
\$menu_var_kind = '{$menu_var_kind}';

//額外顏色設定 如： bootstrap3/themes/light/Cerulean
\$theme_color = '{$theme_color}';

//是否為可選用佈景
\$theme_set_allowed = {$theme_set_allowed};

/*
tabs-1 版面基礎設定
 */

\$config_tabs[1] = {$config_tabs[1]};

//版面類型[自]，值： theme_type_1 ~ theme_type_8
\$config_enable['theme_type'] = array('enable' => '{$config_enable['theme_type']['enable']}', 'min' => '{$config_enable['theme_type']['min']}', 'max' => '{$config_enable['theme_type']['max']}', 'require' => '{$config_enable['theme_type']['require']}', 'default' => '{$config_enable['theme_type']['default']}');

//版面寬度[自]，值：若bootstrap模式，最大值為 12，若 html 模式，則輸入預設版面寬度，如： 980
\$config_enable['theme_width'] = array('enable' => '{$config_enable['theme_width']['enable']}', 'min' => '{$config_enable['theme_width']['min']}', 'max' => '{$config_enable['theme_width']['max']}', 'require' => '{$config_enable['theme_width']['require']}', 'default' => '{$config_enable['theme_width']['default']}');

//內容區顏色[theme_type_x.tpl]
\$config_enable['base_color'] = array('enable' => '{$config_enable['base_color']['enable']}', 'min' => '{$config_enable['base_color']['min']}', 'max' => '{$config_enable['base_color']['max']}', 'require' => '{$config_enable['base_color']['require']}', 'default' => '{$config_enable['base_color']['default']}');

//左區域顏色[theme_type_1.tpl]
\$config_enable['lb_color'] = array('enable' => '{$config_enable['lb_color']['enable']}', 'min' => '{$config_enable['lb_color']['min']}', 'max' => '{$config_enable['lb_color']['max']}', 'require' => '{$config_enable['lb_color']['require']}', 'default' => '{$config_enable['lb_color']['default']}');

//中區域顏色[theme_type_x.tpl]
\$config_enable['cb_color'] = array('enable' => '{$config_enable['cb_color']['enable']}', 'min' => '{$config_enable['cb_color']['min']}', 'max' => '{$config_enable['cb_color']['max']}', 'require' => '{$config_enable['cb_color']['require']}', 'default' => '{$config_enable['cb_color']['default']}');

//右區域顏色[theme_type_2~4.tpl]
\$config_enable['rb_color'] = array('enable' => '{$config_enable['rb_color']['enable']}', 'min' => '{$config_enable['rb_color']['min']}', 'max' => '{$config_enable['rb_color']['max']}', 'require' => '{$config_enable['rb_color']['require']}', 'default' => '{$config_enable['rb_color']['default']}');

//左區域寬度[theme_type_x.tpl]，值：若 bootstrap 模式，最大值為 12，若 html 模式，則輸入預設左區域寬度，如： 220
\$config_enable['lb_width'] = array('enable' => '{$config_enable['lb_width']['enable']}', 'min' => '{$config_enable['lb_width']['min']}', 'max' => '{$config_enable['lb_width']['max']}', 'require' => '{$config_enable['lb_width']['require']}', 'default' => '{$config_enable['lb_width']['default']}');

//中區域寬度[theme_type_1~8.tpl]，值：若 bootstrap 模式，最大值為 12，若 html 模式，則輸入預設右區域寬度，如： 220
\$config_enable['cb_width'] = array('enable' => '{$config_enable['cb_width']['enable']}', 'min' => '{$config_enable['cb_width']['min']}', 'max' => '{$config_enable['cb_width']['max']}', 'require' => '{$config_enable['cb_width']['require']}', 'default' => '{$config_enable['cb_width']['default']}');

//右區域寬度[theme_type_2~8.tpl]，值：若 bootstrap 模式，最大值為 12，若 html 模式，則輸入預設右區域寬度，如： 220
\$config_enable['rb_width'] = array('enable' => '{$config_enable['rb_width']['enable']}', 'min' => '{$config_enable['rb_width']['min']}', 'max' => '{$config_enable['rb_width']['max']}', 'require' => '{$config_enable['rb_width']['require']}', 'default' => '{$config_enable['rb_width']['default']}');

//中左區塊寬度[無]
\$config_enable['clb_width'] = array('enable' => '{$config_enable['clb_width']['enable']}', 'min' => '{$config_enable['clb_width']['min']}', 'max' => '{$config_enable['clb_width']['max']}', 'require' => '{$config_enable['clb_width']['require']}', 'default' => '{$config_enable['clb_width']['default']}');

//中右區塊寬度[無]
\$config_enable['crb_width'] = array('enable' => '{$config_enable['crb_width']['enable']}', 'min' => '{$config_enable['crb_width']['min']}', 'max' => '{$config_enable['crb_width']['max']}', 'require' => '{$config_enable['crb_width']['require']}', 'default' => '{$config_enable['crb_width']['default']}');

//離上邊界距離[自]
\$config_enable['margin_top'] = array('enable' => '{$config_enable['margin_top']['enable']}', 'min' => '{$config_enable['margin_top']['min']}', 'max' => '{$config_enable['margin_top']['max']}', 'require' => '{$config_enable['margin_top']['require']}', 'default' => '{$config_enable['margin_top']['default']}');

//文字大小[theme_css.tpl]
\$config_enable['font_size'] = array('enable' => '{$config_enable['font_size']['enable']}', 'min' => '{$config_enable['font_size']['min']}', 'max' => '{$config_enable['font_size']['max']}', 'require' => '{$config_enable['font_size']['require']}', 'default' => '{$config_enable['font_size']['default']}');

//離下邊界距離[自]
\$config_enable['margin_bottom'] = array('enable' => '{$config_enable['margin_bottom']['enable']}', 'min' => '{$config_enable['margin_bottom']['min']}', 'max' => '{$config_enable['margin_bottom']['max']}', 'require' => '{$config_enable['margin_bottom']['require']}', 'default' => '{$config_enable['margin_bottom']['default']}');

//文字顏色[theme_css.tpl]
\$config_enable['font_color'] = array('enable' => '{$config_enable['font_color']['enable']}', 'min' => '{$config_enable['font_color']['min']}', 'max' => '{$config_enable['font_color']['max']}', 'require' => '{$config_enable['font_color']['require']}', 'default' => '{$config_enable['font_color']['default']}');

//連結顏色[theme_css.tpl]
\$config_enable['link_color'] = array('enable' => '{$config_enable['link_color']['enable']}', 'min' => '{$config_enable['link_color']['min']}', 'max' => '{$config_enable['link_color']['max']}', 'require' => '{$config_enable['link_color']['require']}', 'default' => '{$config_enable['link_color']['default']}');

//移到連結顏色[theme_css.tpl]
\$config_enable['hover_color'] = array('enable' => '{$config_enables['hover_color']['enable']}', 'min' => '{$config_enable['hover_color']['min']}', 'max' => '{$config_enable['hover_color']['max']}', 'require' => '{$config_enable['hover_color']['require']}', 'default' => '{$config_enable['hover_color']['default']}');

/*
tabs-2 背景圖
 */

\$config_tabs[2] = {$config_tabs[2]};

//上傳背景圖[theme_css.tpl]，值：可指定置於「themes/佈景/images/bg/」下的某一檔案名稱
\$config_enable['bg_img'] = array('enable' => '{$config_enable['bg_img']['enable']}', 'min' => '{$config_enable['bg_img']['min']}', 'max' => '{$config_enable['bg_img']['max']}', 'require' => '{$config_enable['bg_img']['require']}', 'default' => '{$bg_img_default}');

//背景顏色[theme_css.tpl]
\$config_enable['bg_color'] = array('enable' => '{$config_enable['bg_color']['enable']}', 'min' => '{$config_enable['bg_color']['min']}', 'max' => '{$config_enable['bg_color']['max']}', 'require' => '{$config_enable['bg_color']['require']}', 'default' => '{$config_enable['bg_color']['default']}');

//背景重複[theme_css.tpl]，值： repeat （重複）, repeat-x （水平重複）, repeat-y （垂直重複）, no-repeat （不重複）
\$config_enable['bg_repeat'] = array('enable' => '{$config_enable['bg_repeat']['enable']}', 'min' => '{$config_enable['bg_repeat']['min']}', 'max' => '{$config_enable['bg_repeat']['max']}', 'require' => '{$config_enable['bg_repeat']['require']}', 'default' => '{$config_enable['bg_repeat']['default']}');

//背景模式[theme_css.tpl]，值： scroll （捲動）,fixed （固定）
\$config_enable['bg_attachment'] = array('enable' => '{$config_enable['bg_attachment']['enable']}', 'min' => '{$config_enable['bg_attachment']['min']}', 'max' => '{$config_enable['bg_attachment']['max']}', 'require' => '{$config_enable['bg_attachment']['require']}', 'default' => '{$config_enable['bg_attachment']['default']}');

//背景位置[theme_css.tpl]，值： left top （預設，左上）, right top （右上）, left bottom （左下）, right bottom （右下）, center center （中中）, center top （中上）, center bottom （中下）
\$config_enable['bg_position'] = array('enable' => '{$config_enable['bg_position']['enable']}', 'min' => '{$config_enable['bg_position']['min']}', 'max' => '{$config_enable['bg_position']['max']}', 'require' => '{$config_enable['bg_position']['require']}', 'default' => '{$config_enable['bg_position']['default']}');


/*
tabs-3 滑動圖片
 */

\$config_tabs[3] = {$config_tabs[3]};

//佈景圖片寬度[slideshow_responsive.tpl]，值：若bootstrap模式，最大值為 12，若 html 模式，則輸入預設佈景圖片寬度，如： 980
\$config_enable['slide_width'] = array('enable' => '{$config_enable['slide_width']['enable']}', 'min' => '{$config_enable['slide_width']['min']}', 'max' => '{$config_enable['slide_width']['max']}', 'require' => '{$config_enable['slide_width']['require']}', 'default' => '{$config_enable['slide_width']['default']}');

//佈景圖片高度[slideshow_responsive.tpl]，值：數值，單位一律為 px
\$config_enable['slide_height'] = array('enable' => '{$config_enable['slide_height']['enable']}', 'min' => '{$config_enable['slide_height']['min']}', 'max' => '{$config_enable['slide_height']['max']}', 'require' => '{$config_enable['slide_height']['require']}', 'default' => '{$config_enable['slide_height']['default']}');

//是否可上傳滑動圖片[slideshow_responsive.tpl]
\$config_enable['use_slide'] = array('enable' => '{$config_enable['use_slide']['enable']}', 'min' => '{$config_enable['use_slide']['min']}', 'max' => '{$config_enable['use_slide']['max']}', 'require' => '{$config_enable['use_slide']['require']}', 'default' => '{$config_enable['use_slide']['default']}');


/*
tabs-4 logo圖
 */

\$config_tabs[4] = {$config_tabs[4]};

// 上傳logo圖[logo.tpl]，值：可指定置於「themes/佈景/images/logo/」下的某一檔案名稱
\$config_enable['logo_img'] = array('enable' => '{$config_enable['logo_img']['enable']}', 'min' => '{$config_enable['logo_img']['min']}', 'max' => '{$config_enable['logo_img']['max']}', 'require' => '{$config_enable['logo_img']['require']}', 'default' => '{$logo_img_default}');

//logo圖位置[logo.tpl]，值： slide （在滑動圖文上）, page （在頁面上）
\$config_enable['logo_position'] = array('enable' => '{$config_enable['logo_position']['enable']}', 'min' => '{$config_enable['logo_position']['min']}', 'max' => '{$config_enable['logo_position']['max']}', 'require' => '{$config_enable['logo_position']['require']}', 'default' => '{$config_enable['logo_position']['default']}');

//Logo離上方距離[logo.tpl]，值：數值，單位一律為 px
\$config_enable['logo_top'] = array('enable' => '{$config_enable['logo_top']['enable']}', 'min' => '{$config_enable['logo_top']['min']}', 'max' => '{$config_enable['logo_top']['max']}', 'require' => '{$config_enable['logo_top']['require']}', 'default' => '{$config_enable['logo_top']['default']}');

//Logo離右邊距離[logo.tpl]，值：數值，單位一律為 px
\$config_enable['logo_right'] = array('enable' => '{$config_enable['logo_right']['enable']}', 'min' => '{$config_enable['logo_right']['min']}', 'max' => '{$config_enable['logo_right']['max']}', 'require' => '{$config_enable['logo_right']['require']}', 'default' => '{$config_enable['logo_right']['default']}');

//Logo離下方距離[logo.tpl]，值：數值，單位一律為 px
\$config_enable['logo_bottom'] = array('enable' => '{$config_enable['logo_bottom']['enable']}', 'min' => '{$config_enable['logo_bottom']['min']}', 'max' => '{$config_enable['logo_bottom']['max']}', 'require' => '{$config_enable['logo_bottom']['require']}', 'default' => '{$config_enable['logo_bottom']['default']}');

//Logo離左邊距離[logo.tpl]，值：數值，單位一律為 px
\$config_enable['logo_left'] = array('enable' => '{$config_enable['logo_left']['enable']}', 'min' => '{$config_enable['logo_left']['min']}', 'max' => '{$config_enable['logo_left']['max']}', 'require' => '{$config_enable['logo_left']['require']}', 'default' => '{$config_enable['logo_left']['default']}');

//Logo置中[logo.tpl]，值：1,0
\$config_enable['logo_center'] = array('enable' => '{$config_enable['logo_center']['enable']}', 'min' => '{$config_enable['logo_center']['min']}', 'max' => '{$config_enable['logo_center']['max']}', 'require' => '{$config_enable['logo_center']['require']}', 'default' => '{$config_enable['logo_center']['default']}');


/*
tabs-5 區塊標題列
 */

\$config_tabs[5] = {$config_tabs[5]};

//區塊標題文字大小[theme_css_blocks.tpl]，值：數值含單位
\$config_enable['bt_text_size'] = array('enable' => '{$config_enable['bt_text_size']['enable']}', 'min' => '{$config_enable['bt_text_size']['min']}', 'max' => '{$config_enable['bt_text_size']['max']}', 'require' => '{$config_enable['bt_text_size']['require']}', 'default' => '{$bt_default['bt_text_size']}');

//區塊標題縮排[theme_css_blocks.tpl]，值：數值，單位一律為 px
\$config_enable['bt_text_padding'] = array('enable' => '{$config_enable['bt_text_padding']['enable']}', 'min' => '{$config_enable['bt_text_padding']['min']}', 'max' => '{$config_enable['bt_text_padding']['max']}', 'require' => '{$config_enable['bt_text_padding']['require']}', 'default' => '{$bt_default['bt_text_padding']}');

//區塊標題文字顏色[theme_css_blocks.tpl]
\$config_enable['bt_text'] = array('enable' => '{$config_enable['bt_text']['enable']}', 'min' => '{$config_enable['bt_text']['min']}', 'max' => '{$config_enable['bt_text']['max']}', 'require' => '{$config_enable['bt_text']['require']}', 'default' => '{$bt_default['bt_text']}');

//區塊標題背景顏色[theme_css_blocks.tpl]
\$config_enable['bt_bg_color'] = array('enable' => '{$config_enable['bt_bg_color']['enable']}', 'min' => '{$config_enable['bt_bg_color']['min']}', 'max' => '{$config_enable['bt_bg_color']['max']}', 'require' => '{$config_enable['bt_bg_color']['require']}', 'default' => '{$bt_default['bt_bg_color']}');

//區塊標題圓角設定[theme_css_blocks.tpl]，值： 1 （圓角）, 0 （直角）
\$config_enable['bt_radius'] = array('enable' => '{$config_enable['bt_radius']['enable']}', 'min' => '{$config_enable['bt_radius']['min']}', 'max' => '{$config_enable['bt_radius']['max']}', 'require' => '{$config_enable['bt_radius']['require']}', 'default' => '{$bt_default['bt_radius']}');

//區塊標題設定按鈕[theme_css_blocks.tpl]，值： right （右）, left （左）
\$config_enable['block_config'] = array('enable' => '{$config_enable['block_config']['enable']}', 'min' => '{$config_enable['block_config']['min']}', 'max' => '{$config_enable['block_config']['max']}', 'require' => '{$config_enable['block_config']['require']}', 'default' => '{$bt_default['block_config']}');

//區塊標題背景圖[theme_css_blocks.tpl]
\$config_enable['bt_bg_img'] = array('enable' => '{$config_enable['bt_bg_img']['enable']}', 'min' => '{$config_enable['bt_bg_img']['min']}', 'max' => '{$config_enable['bt_bg_img']['max']}', 'require' => '{$config_enable['bt_bg_img']['require']}', 'default' => '{$bt_bg_img_default}');

//區塊標題背景重複[theme_css_blocks.tpl]，值： 1 （重複）, 0 （不重複）
\$config_enable['bt_bg_repeat'] = array('enable' => '{$config_enable['bt_bg_repeat']['enable']}', 'min' => '{$config_enable['bt_bg_repeat']['min']}', 'max' => '{$config_enable['bt_bg_repeat']['max']}', 'require' => '{$config_enable['bt_bg_repeat']['require']}', 'default' => '{$bt_default['bt_bg_repeat']}');

//區塊整體樣式手動設定[theme_css_blocks.tpl]，值： 1 （重複）, 0 （不重複）
\$config_enable['block_style'] = array('enable' => '{$config_enable['block_style']['enable']}', 'min' => '{$config_enable['block_style']['min']}', 'max' => '{$config_enable['block_style']['max']}', 'require' => '{$config_enable['block_style']['require']}', 'default' => '{$bt_default['block_style']}');

//區塊標題區樣式手動設定[theme_css_blocks.tpl]，值： 1 （重複）, 0 （不重複）
\$config_enable['block_title_style'] = array('enable' => '{$config_enable['block_title_style']['enable']}', 'min' => '{$config_enable['block_title_style']['min']}', 'max' => '{$config_enable['block_title_style']['max']}', 'require' => '{$config_enable['block_title_style']['require']}', 'default' => '{$bt_default['block_title_style']}');

//區塊內容區樣式手動設定[theme_css_blocks.tpl]，值： 1 （重複）, 0 （不重複）
\$config_enable['block_content_style'] = array('enable' => '{$config_enable['block_content_style']['enable']}', 'min' => '{$config_enable['block_content_style']['min']}', 'max' => '{$config_enable['block_content_style']['max']}', 'require' => '{$config_enable['block_content_style']['require']}', 'default' => '{$bt_default['block_content_style']}');

/*
若沒指定位置（如上方預設），那就是全部區塊預設值，若欲指定位置，只要多一個索引值即可：
\$config_enable['bt_xx']['leftBlock']：左區塊設定
\$config_enable['bt_xx']['rightBlock']：右區塊設定
\$config_enable['bt_xx']['centerBlock']：上中區塊設定
\$config_enable['bt_xx']['centerLeftBlock']：上中左區塊設定
\$config_enable['bt_xx']['centerRightBlock']：上中右區塊設定
\$config_enable['bt_xx']['centerBottomBlock']：下中區塊設定
\$config_enable['bt_xx']['centerBottomLeftBlock']：下中左區塊設定
\$config_enable['bt_xx']['centerBottomRightBlock']：下中右區塊設定
例如：
\$config_enable['bt_bg_color']['leftBlock'] = array('enable'=>1, 'min' => '', 'max' => '', 'require'=>0 , 'default' => '#7CBBBB');
\$config_enable['bt_bg_color']['rightBlock'] = array('enable'=>1, 'min' => '', 'max' => '', 'require'=>0 , 'default' => '#D2C38E');
 */
{$position_blocks}
/*
tabs-6 導覽工具列
 */

\$config_tabs[6] = {$config_tabs[6]};

//導覽工具列位置[navbar.tpl]，值： navbar-fixed-top （固定上方）, navbar-fixed-bottom （固定下方）, navbar-static-top （滑動圖片上方）, navbar-static-bottom （滑動圖片下方）, default （佈景預設值）, not-use （不使用）
\$config_enable['navbar_pos'] = array('enable' => '{$config_enable['navbar_pos']['enable']}', 'min' => '{$config_enable['navbar_pos']['min']}', 'max' => '{$config_enable['navbar_pos']['max']}', 'require' => '{$config_enable['navbar_pos']['require']}', 'default' => '{$config_enable['navbar_pos']['default']}');

//導覽工具列 漸層顏色(top)[theme_css_navbar.tpl]
\$config_enable['navbar_bg_top'] = array('enable' => '{$config_enable['navbar_bg_top']['enable']}', 'min' => '{$config_enable['navbar_bg_top']['min']}', 'max' => '{$config_enable['navbar_bg_top']['max']}', 'require' => '{$config_enable['navbar_bg_top']['require']}', 'default' => '{$config_enable['navbar_bg_top']['default']}');

//導覽工具列 漸層顏色(bottom)[theme_css_navbar.tpl]
\$config_enable['navbar_bg_bottom'] = array('enable' => '{$config_enable['navbar_bg_bottom']['enable']}', 'min' => '{$config_enable['navbar_bg_bottom']['min']}', 'max' => '{$config_enable['navbar_bg_bottom']['max']}', 'require' => '{$config_enable['navbar_bg_bottom']['require']}', 'default' => '{$config_enable['navbar_bg_bottom']['default']}');

//導覽工具列 連結區塊底色[theme_css_navbar.tpl]
\$config_enable['navbar_hover'] = array('enable' => '{$config_enable['navbar_hover']['enable']}', 'min' => '{$config_enable['navbar_hover']['min']}', 'max' => '{$config_enable['navbar_hover']['max']}', 'require' => '{$config_enable['navbar_hover']['require']}', 'default' => '{$config_enable['navbar_hover']['default']}');

//上傳導覽列背景圖[navbar.tpl]，值：可指定置於「themes/佈景/images/nav_bg/」下的某一檔案名稱
\$config_enable['navbar_img'] = array('enable' => '{$config_enable['navbar_img']['enable']}', 'min' => '{$config_enable['navbar_img']['min']}', 'max' => '{$config_enable['navbar_img']['max']}', 'require' => '{$config_enable['navbar_img']['require']}', 'default' => '{$navbar_img_default}');

//導覽工具列 文字顏色[theme_css_navbar.tpl]
\$config_enable['navbar_color'] = array('enable' => '{$config_enable['navbar_color']['enable']}', 'min' => '{$config_enable['navbar_color']['min']}', 'max' => '{$config_enable['navbar_color']['max']}', 'require' => '{$config_enable['navbar_color']['require']}', 'default' => '{$config_enable['navbar_color']['default']}');

//導覽工具列 文字移過顏色[theme_css_navbar.tpl]
\$config_enable['navbar_color_hover'] = array('enable' => '{$config_enable['navbar_color_hover']['enable']}', 'min' => '{$config_enable['navbar_color_hover']['min']}', 'max' => '{$config_enable['navbar_color_hover']['max']}', 'require' => '{$config_enable['navbar_color_hover']['require']}', 'default' => '{$config_enable['navbar_color_hover']['default']}');

//導覽工具列 圖示顏色[navbar.tpl]，值： icon-white （白色圖案）, '' （黑色圖案）
\$config_enable['navbar_icon'] = array('enable' => '{$config_enable['navbar_icon']['enable']}', 'min' => '{$config_enable['navbar_icon']['min']}', 'max' => '{$config_enable['navbar_icon']['max']}', 'require' => '{$config_enable['navbar_icon']['require']}', 'default' => '{$config_enable['navbar_icon']['default']}');

// 上傳導覽列logo圖[navbar.tpl]，值：可指定置於「themes/佈景/images/navlogo/」下的某一檔案名稱
\$config_enable['navlogo_img'] = array('enable' => '{$config_enable['navlogo_img']['enable']}', 'min' => '{$config_enable['navlogo_img']['min']}', 'max' => '{$config_enable['navlogo_img']['max']}', 'require' => '{$config_enable['navlogo_img']['require']}', 'default' => '{$navlogo_img_default}');
  ";
    header('Content-type: text/php');
    header('Content-Disposition: attachment; filename=config.php');
    echo $file;
    exit;
}

function export_config2($theme_id = '', $type = '')
{
    global $xoopsConfig, $xoopsDB;
    $theme_name = $xoopsConfig['theme_set'];
    include_once XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$type}.php";

    $config2 = [];
    $sql = 'select * from ' . $xoopsDB->prefix('tad_themes_config2') . " where `theme_id` = '{$theme_id}'";
    $result = $xoopsDB->query($sql) or web_error($sql, __FILE__, __LINE__);
    while ($all = $xoopsDB->fetchArray($result)) {
        $col = $all['name'];
        $config2[$col] = $all;
    }
    $all_col = $default_v = [];

    foreach ($theme_config as $i => $c2) {
        $col = $c2['name'];
        $default_v[$col] = $config2[$col]['value'];
        $all_col[] = $col;
    }

    $myts = MyTextSanitizer::getInstance();

    // die(var_export($default_v));
    $handle = fopen(XOOPS_ROOT_PATH . "/themes/{$theme_name}/{$type}.php", 'rb');
    header('Content-type: text/php');
    header("Content-Disposition: attachment; filename={$type}.php");

    if ($handle) {
        while (false !== ($buffer = fgets($handle, 4096))) {
            if (false !== mb_strpos($buffer, "'name'")) {
                list($opt, $val) = explode('=', $buffer);
                $val = trim($val);
                $val = str_replace(';', '', $val);
                $val = str_replace('"', '', $val);
                $val = str_replace(' ', '', $val);
                $new_default = $myts->addSlashes($default_v[$val]);
            } elseif (false !== mb_strpos($buffer, "'default'")) {
                list($opt, $val) = explode('=', $buffer);
                $val = trim($val);
                $val = str_replace('"', '', $val);
                $buffer = "\$theme_config[\$i]['default'] = \"$new_default\";\n";
            }
            echo $buffer;
        }

        fclose($handle);
    }

    exit;
}
/*-----------執行動作判斷區---------- */
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$theme_id = system_CleanVars($_REQUEST, 'theme_id', 0, 'int');
$type = system_CleanVars($_REQUEST, 'type', '', 'string');

switch ($op) {
    /*---判斷動作請貼在下方--- */

    //新增資料
    case 'insert_tad_themes':
        $theme_id = insert_tad_themes();
        header("location: {$_SERVER['HTTP_REFERER']}");
        exit;

    //更新資料
    case 'update_tad_themes':
        update_tad_themes($theme_id);
        if (isset($_COOKIE['themeTab_baseURI'])) {
            header("location: {$_COOKIE['themeTab_baseURI']}");
        } else {
            header("location: {$_SERVER['HTTP_REFERER']}");
        }
        exit;

    //輸入表格
    case 'tad_themes_form':
        tad_themes_form();
        break;
    //刪除資料
    case 'delete_tad_themes':
        delete_tad_themes($theme_id);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //匯出資料
    case 'export_config':
        export_config($theme_id);
        exit;

    //匯出資料
    case 'export_config2':
        export_config2($theme_id, $type);
        exit;

    //預設動作
    default:
        tad_themes_form();
        break;
        /*---判斷動作請貼在上方--- */
}

/*-----------秀出結果區-------------- */
$xoopsTpl->assign('themeTab_baseURI', $_COOKIE['themeTab_baseURI']);
$xoTheme->addStylesheet('modules/tad_themes/css/module.css');
$xoTheme->addStylesheet('modules/tadtools/css/font-awesome/css/font-awesome.css');
$xoTheme->addStylesheet('modules/tad_themes/class/bootstrap-select/css/bootstrap-select.min.css');
$xoTheme->addScript('modules/tad_themes/class/bootstrap-select/js/bootstrap-select.min.js');
$xoTheme->addScript('modules/tad_themes/class/bootstrap-select/js/i18n/defaults-zh_TW.min.js');
include_once 'footer.php';
