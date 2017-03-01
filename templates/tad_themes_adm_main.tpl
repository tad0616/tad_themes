<link href="<{$xoops_url}>/modules/tadtools/css/font-awesome/css/font-awesome.css" rel="stylesheet">
<div class="container-fluid">
  <{$jquery}>
  <{$mColorPicker_code}>
  <script type="text/javascript">

    $(document).ready(function(){

      change_css();
      preview_img("bg","<{$bg_img}>");
      $("#tad-themes-tabs").tabs({
       activate: function (e, ui) {
           $.cookie('selected-tab', ui.newTab.index(), { path: '/' });
       },
       active: $.cookie('selected-tab'),
       collapsible: false
      });
      $("#bt_tabs").tabs({
        activate: function (e, ui) {
            $.cookie('selected-tab', ui.newTab.index(), { path: '/' });
        },
        active: $.cookie('selected-tab')
      }).addClass( "ui-tabs-vertical ui-helper-clearfix" );
      $("#bt_tabs li").removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

      <{if $logo_position=="page"}>
        $("#logo_place_setup").hide();
      <{else}>
        $("#logo_place_setup").show();
      <{/if}>

    });


    function logo_place_setup(logo_position){
      if(logo_position=="page"){
        $("#logo_place_setup").hide();
      }else{
        $("#logo_place_setup").show();
      }
    }

    function preview_img(kind,imgSrc){
      var newimgSrc=imgSrc.replace(kind+"/", kind+"/thumbs/");
      var newImg = new Image();
      newImg.src = imgSrc;
      var height = newImg.height * 1;
      if(height > 90){
        $("#preview_zone").css("background-image","url("+newimgSrc+")");
      }else{
        $("#preview_zone").css("background-image","url("+imgSrc+")");
      }
    }

    <{$chang_css}>


    function delete_tad_themes_config(theme_id){
      var sure = window.confirm("<{$smarty.const._MA_TADTHEMES_DEL_CONFIRM}>");
      if (!sure)  return;
      location.href="main.php?op=delete_tad_themes&theme_id=" + theme_id;
    }
  </script>

  <style>
    .ui-tabs-vertical { width: 100%; }
    .ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 20%; }
    .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
    .ui-tabs-vertical .ui-tabs-nav li a { display:block; }
    .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
    .ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: right; width: 72%;}
  </style>

  <{$formValidator_code}>

  <form action="main.php" method="post" id="myForm" enctype="multipart/form-data" role="form">
    <div class="row">
      <div class="col-sm-8">
        <h1>
          <{$theme_name}><{$smarty.const._MA_TAD_THEMES_FORM}>

          <a href="javascript:delete_tad_themes_config(<{$theme_id}>)" class="btn btn-danger"><{$smarty.const._MA_TADTHEMES_TO_DEFAULT}></a>
        </h1>
        <div class="alert alert-info">
          <{$smarty.const._MA_TADTHEMES_CHANGE_KIND_DESC}>
        </div>
          <{if $theme_change}>
            <{foreach from=$theme_kind_arr item=kind}>
              <div class="radio">
                <label>
                  <input type="radio" name="theme_kind" value="<{$kind}>" <{if $theme_kind==$kind}>checked<{/if}>>
                  <b><{$kind}></b>
                  <{$theme_kind_txt_arr.$kind}>
                </label>
              </div>
            <{/foreach}>

            <input type="hidden" name="old_theme_kind" value="<{$theme_kind}>">
          <{else}>
            <{$theme_kind}><{$theme_kind_txt}>
            <input type="hidden" name="theme_kind" value="<{$theme_kind}>">
          <{/if}>

        <div class="row">
          <div id="tad-themes-tabs">
            <ul>
              <{if $config_tabs.1}>
                <li><a href="#tabs-1"><{$smarty.const._MA_TADTHEMES_THEME_BASE}></a></li>
              <{/if}>
              <{if $config_tabs.2}>
                <li><a href="#tabs-2"><{$smarty.const._MA_TADTHEMES_BG_IMG}></a></li>
              <{/if}>
              <{if $config_tabs.3}>
                <li><a href="#tabs-3"><{$smarty.const._MA_TAD_THEMES_HEAD}></a></li>
              <{/if}>
              <{if $config_tabs.4}>
                <li><a href="#tabs-4"><{$smarty.const._MA_TADTHEMES_LOGO_IMG}></a></li>
              <{/if}>
              <{if $config_tabs.5}>
                <li><a href="#tabs-5"><{$smarty.const._MA_TADTHEMES_BLOCK_TITLE}></a></li>
              <{/if}>
              <{if $config_tabs.6}>
                <li><a href="#tabs-6"><{$smarty.const._MA_TADTHEMES_NAVBAR}></a></li>
              <{/if}>
              <!--額外設定-->
              <{if $config2}>
              <li><a href="#tabs-7"><{$smarty.const._MA_TADTHEMES_CONFIG2}></a></li>
              <{/if}>
            </ul>

            <{if $config_tabs.1}>
              <div id="tabs-1">
                <!--版面基本設定-->
                <!--佈景類型-->
                <div class="row">
                  <!--版面類型-->
                  <{if $enable.theme_type}>
                    <div class="col-sm-2 text-right"><{$smarty.const._MA_TADTHEMES_THEME_TYPE}></div>
                    <div class="col-sm-2">
                      <select name="theme_type" id="theme_type" class="<{$validate.theme_type}>" onChange="change_css();">
                        <option value="theme_type_1" <{if $theme_type=="theme_type_1"}>selected<{/if}>><{$smarty.const._MA_TAD_THEMES_TYPE1}></option>
                        <option value="theme_type_2" <{if $theme_type=="theme_type_2"}>selected<{/if}>><{$smarty.const._MA_TAD_THEMES_TYPE2}></option>
                        <option value="theme_type_3" <{if $theme_type=="theme_type_3"}>selected<{/if}>><{$smarty.const._MA_TAD_THEMES_TYPE3}></option>
                        <option value="theme_type_4" <{if $theme_type=="theme_type_4"}>selected<{/if}>><{$smarty.const._MA_TAD_THEMES_TYPE4}></option>
                        <option value="theme_type_5" <{if $theme_type=="theme_type_5"}>selected<{/if}>><{$smarty.const._MA_TAD_THEMES_TYPE5}></option>
                        <option value="theme_type_6" <{if $theme_type=="theme_type_6"}>selected<{/if}>><{$smarty.const._MA_TAD_THEMES_TYPE6}></option>
                        <option value="theme_type_7" <{if $theme_type=="theme_type_7"}>selected<{/if}>><{$smarty.const._MA_TAD_THEMES_TYPE7}></option>
                        <option value="theme_type_8" <{if $theme_type=="theme_type_8"}>selected<{/if}>><{$smarty.const._MA_TAD_THEMES_TYPE8}></option>
                      </select>
                    </div>
                  <{else}>
                    <input type="hidden" name="theme_type" id="theme_type" value="<{$theme_type}>">
                  <{/if}>

                  <!--版面寬度-->
                    <div class="col-sm-2 text-right"><{$smarty.const._MA_TADTHEMES_THEME_WIDTH}></div>
                    <div class="col-sm-2">
                      <{if $enable.theme_width}>
                        <input type="text" name="theme_width" class="col-sm-8 <{$validate.theme_width}>" value="<{$theme_width}>" id="theme_width">
                        <{if $theme_kind=="mix"}>px<{else}><{$theme_unit}><{/if}>
                      <{else}>
                        <input type="hidden" name="theme_width" id="theme_width" value="<{$theme_width}>"><{$theme_width}><{if $theme_kind=="mix"}>px<{else}><{$theme_unit}><{/if}>
                      <{/if}>
                    </div>

                  <!--內容區顏色-->
                  <{if $enable.base_color}>
                    <div class="col-sm-2 text-right"><{$smarty.const._MA_TADTHEMES_BASE_COLOR}></div>
                    <div class="col-sm-2">
                      <input type="text" name="base_color" class="col-sm-8<{$validate.base_color}>" value="<{$base_color}>" id="base_color" data-hex="true" onChange="change_css();">
                    </div>
                  <{else}>
                    <input type="hidden" name="base_color" id="base_color" value="<{$base_color}>">
                  <{/if}>
                </div>


                <div class="row">
                  <!--左區塊顏色-->
                  <{if $enable.lb_color}>
                    <div class="col-sm-2 text-right"><{$smarty.const._MA_TADTHEMES_LB_COLOR}></div>
                    <div class="col-sm-2">
                      <input type="text" name="lb_color" id="lb_color" value="<{$lb_color}>" class="col-sm-8<{$validate.lb_color}>" data-hex="true" onChange="change_css();">
                    </div>
                  <{else}>
                    <input type="hidden" name="lb_color" id="lb_color" value="<{$lb_color}>">
                  <{/if}>

                  <!--中區塊顏色-->
                  <{if $enable.cb_color}>
                    <div class="col-sm-2 text-right"><{$smarty.const._MA_TADTHEMES_CB_COLOR}></div>
                    <div class="col-sm-2">
                      <input type="text" name="cb_color" id="cb_color" value="<{$cb_color}>" class="col-sm-8<{$validate.cb_color}>"  data-hex="true" onChange="change_css();">
                    </div>
                  <{else}>
                    <input type="hidden" name="cb_color" id="cb_color" value="<{$cb_color}>">
                  <{/if}>

                  <!--右區塊顏色-->
                  <{if $enable.rb_color}>
                    <div class="col-sm-2 text-right"><{$smarty.const._MA_TADTHEMES_RB_COLOR}></div>
                    <div class="col-sm-2">
                      <input type="text" name="rb_color" id="rb_color" value="<{$rb_color}>" class="col-sm-8<{$validate.rb_color}>" data-hex="true" onChange="change_css();">
                    </div>
                  <{else}>
                    <input type="hidden" name="rb_color" id="rb_color" value="<{$rb_color}>">
                  <{/if}>
                </div>


                <div class="row">
                  <!--左區塊寬度-->
                  <{if $enable.lb_width}>
                    <div class="col-sm-2 text-right"><{$smarty.const._MA_TADTHEMES_LB_WIDTH}></div>
                    <div class="col-sm-2">
                      <input type="text" name="lb_width" class="col-sm-8<{$validate.lb_width}>" value="<{$lb_width}>" id="lb_width" onChange="change_css();">
                      <{$theme_unit}>
                    </div>
                  <{else}>
                    <input type="hidden" name="lb_width" id="lb_width" value="<{$lb_width}>">
                  <{/if}>

                  <!--中區塊寬度-->
                  <div class="col-sm-2 text-right"><{$smarty.const._MA_TADTHEMES_CB_WIDTH}></div>
                  <div class="col-sm-2">
                    <div id="cb_width"></div>
                  </div>

                  <!--右區塊寬度-->
                  <{if $enable.rb_width}>
                    <div class="col-sm-2 text-right"><{$smarty.const._MA_TADTHEMES_RB_WIDTH}></div>
                    <div class="col-sm-2">
                      <input type="text" name="rb_width" class="col-sm-8<{$validate.rb_width}>" value="<{$rb_width}>" id="rb_width" onChange="change_css();">
                      <{$theme_unit}>
                    </div>
                  <{else}>
                    <input type="hidden" name="rb_width" id="rb_width" value="<{$rb_width}>">
                  <{/if}>

                </div>


                <div class="row">
                  <!--文字大小-->
                  <{if $enable.font_size}>
                    <div class="col-sm-2 text-right"><{$smarty.const._MA_TADTHEMES_FONT_SIZE}></div>
                    <div class="col-sm-2">
                      <input type="text" name="font_size" class="col-sm-8<{$validate.font_size}>" value="<{$font_size}>" id="font_size">
                    </div>
                  <{else}>
                    <input type="hidden" name="font_size" id="font_size" value="<{$font_size}>">
                  <{/if}>

                  <!--離上邊界距離-->
                  <{if $enable.margin_top}>
                    <div class="col-sm-2 text-right"><{$smarty.const._MA_TADTHEMES_MARGIN_TOP}></div>
                    <div class="col-sm-2">
                      <input type="text" name="margin_top" class="col-sm-8<{$validate.margin_top}>" value="<{$margin_top}>" id="margin_top"  onChange="change_css();">px
                    </div>
                  <{else}>
                    <input type="hidden" name="margin_top" id="margin_top" value="<{$margin_top}>">
                  <{/if}>

                  <!--離下邊界距離-->
                  <{if $enable.margin_bottom}>
                    <div class="col-sm-2 text-right"><{$smarty.const._MA_TADTHEMES_MARGIN_BOTTOM}></div>
                    <div class="col-sm-2">
                      <input type="text" name="margin_bottom" class="col-sm-8<{$validate.margin_bottom}>" value="<{$margin_bottom}>" id="margin_bottom"  onChange="change_css();">px
                    </div>
                  <{else}>
                    <input type="hidden" name="margin_bottom" id="margin_bottom" value="<{$margin_bottom}>">
                  <{/if}>
                </div>

                <div class="row">

                  <!--文字顏色-->
                  <{if $enable.font_color}>
                    <div class="col-sm-2 text-right"><{$smarty.const._MA_TADTHEMES_FONT_COLOR}></div>
                    <div class="col-sm-2">
                      <input type="text" name="font_color" id="font_color" value="<{$font_color}>" class="col-sm-8<{$validate.font_color}>" data-hex="true" onChange="change_css();">
                    </div>
                  <{else}>
                    <input type="hidden" name="font_color" id="font_color" value="<{$font_color}>">
                  <{/if}>

                  <!--連結顏色-->
                  <{if $enable.link_color}>
                    <div class="col-sm-2 text-right"><{$smarty.const._MA_TADTHEMES_LINK_COLOR}></div>
                    <div class="col-sm-2">
                      <input type="text" name="link_color" id="link_color" value="<{$link_color}>" class="col-sm-8<{$validate.link_color}>" data-hex="true" onChange="change_css();">
                    </div>
                  <{else}>
                    <input type="hidden" name="link_color" id="link_color" value="<{$link_color}>">
                  <{/if}>

                  <!--滑鼠移到連結顏色-->
                  <{if $enable.hover_color}>
                    <div class="col-sm-2 text-right"><{$smarty.const._MA_TADTHEMES_HOVER_COLOR}></div>
                    <div class="col-sm-2">
                      <input type="text" name="hover_color" id="hover_color" value="<{$hover_color}>" class="col-sm-8<{$validate.hover_color}>" data-hex="true" onChange="change_css();">
                    </div>
                  <{else}>
                    <input type="hidden" name="hover_color" id="hover_color" value="<{$hover_color}>">
                  <{/if}>
                </div>
              </div>
            <{else}>
              <input type="hidden" id="theme_type" name="theme_type" value="<{$theme_type}>">
              <input type="hidden" id="theme_width" name="theme_width" value="<{$theme_width}>">
              <input type="hidden" id="base_color" name="base_color" value="<{$base_color}>">
              <input type="hidden" id="lb_color" name="lb_color" value="<{$lb_color}>">
              <input type="hidden" id="cb_color" name="cb_color" value="<{$cb_color}>">
              <input type="hidden" id="rb_color" name="rb_color" value="<{$rb_color}>">
              <input type="hidden" id="lb_width" name="lb_width" value="<{$lb_width}>">
              <input type="hidden" id="rb_width" name="rb_width" value="<{$rb_width}>">
              <input type="hidden" id="clb_width" name="clb_width" value="<{$clb_width}>">
              <input type="hidden" id="crb_width" name="crb_width" value="<{$crb_width}>">
              <input type="hidden" id="margin_top" name="margin_top" value="<{$margin_top}>">
              <input type="hidden" id="font_size" name="font_size" value="<{$font_size}>">
              <input type="hidden" id="margin_bottom" name="margin_bottom" value="<{$margin_bottom}>">
              <input type="hidden" id="font_color" name="font_color" value="<{$font_color}>">
              <input type="hidden" id="link_color" name="link_color" value="<{$link_color}>">
              <input type="hidden" id="hover_color" name="hover_color" value="<{$hover_color}>">
            <{/if}>

            <!--背景圖-->
            <{if $config_tabs.2}>
              <div id="tabs-2">
                <div class="row">
                  <div class="col-sm-5">
                    <{if $enable.bg_img}>
                      <div class="row">
                        <!-- 上傳 背景圖-->
                        <div class="col-sm-4 text-right">
                          <{$smarty.const._MA_TAD_THEMES_UPLOAD}>
                          <{$smarty.const._MA_TADTHEMES_BG_IMG}>
                        </div>
                        <div class="col-sm-8">
                          <{$upform_bg}>
                        </div>
                      </div>
                    <{else}>
                      <input type="hidden" name="bg_img" id="bg_img" value="<{$bg_img}>">
                    <{/if}>


                    <{if $enable.bg_color}>
                      <div class="row">
                        <!-- 背景顏色-->
                        <div class="col-sm-4 text-right">
                          <{$smarty.const._MA_TADTHEMES_BG_COLOR}>
                        </div>
                        <div class="col-sm-8">
                          <input type="text" name="bg_color" id="bg_color" value="<{$bg_color}>" class="col-sm-6<{$validate.bg_color}>" data-hex="true" onChange="change_css();">
                        </div>
                      </div>
                    <{else}>
                      <input type="hidden" name="bg_color" id="bg_color" value="<{$bg_color}>">
                    <{/if}>

                    <{if $enable.bg_repeat}>
                      <div class="row">
                        <!-- 背景重複-->
                        <div class="col-sm-4 text-right">
                          <{$smarty.const._MA_TADTHEMES_BG_REPEAT}>
                        </div>
                        <div class="col-sm-8">
                          <select name="bg_repeat" id="bg_repeat" class="col-sm-12<{$validate.bg_repeat}>" onChange="change_css();">
                            <option value="repeat" <{if $bg_repeat=="repeat"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_REPEAT_NORMAL}></option>
                            <option value="repeat-x" <{if $bg_repeat=="repeat-x"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_REPEAT_X}></option>
                            <option value="repeat-y" <{if $bg_repeat=="repeat-y"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_REPEAT_Y}></option>
                            <option value="no-repeat" <{if $bg_repeat=="no-repeat"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_NO_REPEAT}></option>
                            <option value="no-repeat; background-size: cover" <{if $bg_repeat=="no-repeat; background-size: cover"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_NO_REPEAT_COVER}></option>
                            <option value="no-repeat; background-size: contain" <{if $bg_repeat=="no-repeat; background-size: contain"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_NO_REPEAT_CONTAIN}></option>
                          </select>
                        </div>
                      </div>
                    <{else}>
                      <input type="hidden" name="bg_repeat" id="bg_repeat" value="<{$bg_repeat}>">
                    <{/if}>


                    <{if $enable.bg_attachment}>
                      <div class="row">
                        <!-- 背景模式-->
                        <div class="col-sm-4 text-right">
                          <{$smarty.const._MA_TADTHEMES_BG_ATTACHMENT}>
                        </div>
                        <div class="col-sm-8">
                          <select name="bg_attachment" id="bg_attachment" class="col-sm-12<{$validate.bg_attachment}>" onChange="change_css();">
                            <option value="scroll" <{if $bg_attachment=="scroll"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_ATTACHMENT_SCROLL}></option>
                            <option value="fixed" <{if $bg_attachment=="fixed"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_ATTACHMENT_FIXED}></option>
                          </select>
                        </div>
                      </div>
                    <{else}>
                      <input type="hidden" name="bg_attachment" id="bg_attachment" value="<{$bg_attachment}>">
                    <{/if}>


                    <{if $enable.bg_position}>
                      <div class="row">
                        <!-- 背景位置-->
                        <div class="col-sm-4 text-right">
                          <{$smarty.const._MA_TADTHEMES_BG_POSITION}>
                        </div>
                        <div class="col-sm-8">
                          <select name="bg_position" id="bg_position" class="col-sm-12<{$validate.bg_position}>" onChange="change_css();">
                            <option value="" <{if $bg_position=="left top"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_LT}></option>
                            <option value="right top" <{if $bg_position=="right top"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_RT}></option>
                            <option value="left bottom" <{if $bg_position=="left bottom"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_LB}></option>
                            <option value="right bottom" <{if $bg_position=="right bottom"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_RB}></option>
                            <option value="center center" <{if $bg_position=="center center"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_CC}></option>
                            <option value="center top" <{if $bg_position=="center top"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_CT}></option>
                            <option value="center bottom" <{if $bg_position=="center bottom"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_CB}></option>
                          </select>
                        </div>
                      </div>
                    <{else}>
                      <input type="hidden" name="bg_position" id="bg_position" value="<{$bg_position}>">
                    <{/if}>
                  </div>

                  <!--選擇預設 背景圖-->
                  <div class="col-sm-7">
                    <{if $all_bg and $enable.bg_img=="1"}>
                      <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                        <label for="bg_img0" style="width:60px; height:60px;border:1px dotted gray;" >
                          <input type="radio" name="bg_img" id="bg_img0" onChange="$('.del_img_box').show(); preview_img('bg',$(this).val());" value="" <{if $bg_img==""}>checked<{/if}>>
                          <{$smarty.const._MA_TADTHEMES_NONE}><{$smarty.const._MA_TADTHEMES_BG_IMG}>
                        </label>
                      </div>
                      <{foreach from=$all_bg item=bg}>
                        <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                          <label for="bg_img<{$bg.files_sn}>" style="width:60px; height:60px; background:#000000 url(<{$bg.tb_path}>);background-position:center center;border:1px solid gray;" >
                            <input type="radio" name="bg_img" id="bg_img<{$bg.files_sn}>" onChange="$('.del_img_box').show(); $('#del_img<{$bg.files_sn}>').hide(); preview_img('bg',$(this).val());" value="<{$bg.path}>" <{if $bg_img==$bg.path}>checked<{/if}>>
                          </label>

                          <label class="del_img_box" style="font-size:12px;" id="del_img<{$bg.files_sn}>">
                            <input type="checkbox" value="<{$bg.files_sn}>" name="del_file[<{$bg.files_sn}>]"> <{$smarty.const._TAD_DEL}>
                          </label>
                        </div>
                      <{/foreach}>
                    <{/if}>
                  </div>
                </div>
              </div>
            <{else}>
              <input type="hidden" id="bg_img" name="bg_img" value="<{$bg_img}>">
              <input type="hidden" id="bg_color" name="bg_color" value="<{$bg_color}>">
              <input type="hidden" id="bg_repeat" name="bg_repeat" value="<{$bg_repeat}>">
              <input type="hidden" id="bg_attachment" name="bg_attachment" value="<{$bg_attachment}>">
              <input type="hidden" id="bg_position" name="bg_position" value="<{$bg_position}>">
            <{/if}>

            <!--滑動圖片高度-->
            <{if $config_tabs.3}>
              <div id="tabs-3">
                <div class="row">

                  <{if $enable.slide_width=="1" or $enable.slide_height=="1"}>
                    <div class="col-sm-5">

                      <!--滑動圖片寬度-->
                      <{if $enable.slide_width=="1"}>
                        <div class="row">
                          <div class="col-sm-4 text-right">
                            <{$smarty.const._MA_TADTHEMES_SLIDE_WIDTH}>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" name="slide_width" class="col-sm-8<{$validate.slide_width}>" value="<{$slide_width}>" id="slide_width" onChange="change_css();">
                            <{if $theme_kind=="mix"}>px<{else}><{$theme_unit}><{/if}>
                          </div>
                        </div>
                      <{else}>
                        <input type="hidden" name="slide_width" id="slide_width" value="<{$slide_width}>">
                      <{/if}>

                      <!--滑動圖片高度-->
                      <{if $enable.slide_height=="1"}>
                        <div class="row">
                          <div class="col-sm-4 text-right">
                            <{$smarty.const._MA_TADTHEMES_SLIDE_HEIGHT}>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" name="slide_height" class="col-sm-8<{$validate.slide_height}>" value="<{$slide_height}>" id="slide_height" onChange="change_css();"> px
                          </div>
                        </div>
                      <{else}>
                        <input type="hidden" name="slide_height" id="slide_height" value="<{$slide_height}>">
                      <{/if}>
                    </div>
                  <{else}>
                    <input type="hidden" id="slide_width" name="slide_width" value="<{$slide_width}>">
                    <input type="hidden" id="slide_height" name="slide_height" value="<{$slide_height}>">
                  <{/if}>

                  <{if $enable.slide_width=="1" or $enable.slide_height=="1" or $enable.use_slide=="1"}>
                    <div class="col-sm-7">
                      <div class="col-sm-12 alert alert-success">
                        <{$smarty.const._MA_TADTHEMES_SLIDE_DESC}>
                      </div>
                    </div>
                  <{/if}>
                </div>

                <{if $enable.slide_width=="1" or $enable.slide_height=="1" or $enable.use_slide=="1"}>
                  <div class="row">
                    <!-- 背景模式-->
                    <div class="col-sm-2 text-right">
                      <{$smarty.const._MA_TAD_THEMES_UPLOAD}>
                      <{$smarty.const._MA_TAD_THEMES_HEAD}>
                    </div>
                    <div class="col-sm-10">
                      <{$upform_slide}>
                    </div>
                  </div>
                <{/if}>
              </div>
            <{else}>
              <input type="hidden" id="slide_width" name="slide_width" value="<{$slide_width}>">
              <input type="hidden" id="slide_height" name="slide_height" value="<{$slide_height}>">
            <{/if}>

            <!--logo圖-->
            <{if $config_tabs.4}>
              <div id="tabs-4">
                <div class="row">
                  <div class="col-sm-5">

                    <!-- 上傳logo圖-->
                    <{if $enable.logo_img=="1"}>
                      <div class="row">
                        <div class="col-sm-4 text-right">
                          <{$smarty.const._MA_TAD_THEMES_UPLOAD}><{$smarty.const._MA_TADTHEMES_LOGO_IMG}>
                        </div>
                        <div class="col-sm-8">
                          <{$upform_logo}>
                        </div>
                      </div>
                    <{else}>
                      <input type="hidden" name="logo_img" id="logo_img" value="<{$logo_img}>">
                    <{/if}>

                    <!-- logo圖位置-->
                    <{if $enable.logo_position=="1"}>
                      <div class="row">
                        <div class="col-sm-4 text-right">
                          <{$smarty.const._MA_TADTHEMES_LOGO_POSITION}>
                        </div>
                        <div class="col-sm-8">
                          <div class="radio">
                            <label>
                              <input type="radio" name="logo_position" onClick="logo_place_setup(this.value)" value="slide" <{if $logo_position=="slide"}>checked<{/if}>><{$smarty.const._MA_TADTHEMES_LOGO_SLIDE}>
                            </label>
                          </div>
                          <div class="radio">
                            <label class="radio">
                              <input type="radio" name="logo_position" onClick="logo_place_setup(this.value)" class="logo_position" value="page" <{if $logo_position=="page"}>checked<{/if}>><{$smarty.const._MA_TADTHEMES_LOGO_PAGE}>
                            </label>
                          </div>
                        </div>
                      </div>
                    <{else}>
                      <input type="hidden" name="logo_position" id="logo_position" value="<{$logo_position}>">
                    <{/if}>



                    <!-- 選擇預設logo圖-->
                    <{if $enable.logo_top=="1" or  $enable.logo_right=="1" or $enable.logo_left=="1" or $enable.logo_bottom=="1"}>
                      <div class="row" id="logo_place_setup">
                        <div class="col-sm-4 text-right">
                          <{$smarty.const._MA_TADTHEMES_LOGO_PLACE}>
                        </div>
                        <div class="col-sm-8">
                          <{if $enable.logo_top=="1"}>
                            <div class="row">
                              <div class="col-sm-4 col-sm-offset-4">
                                <input type="text" name="logo_top" class="col-sm-8<{$validate.logo_top}> form-control" value="<{$logo_top}>" id="logo_top" onChange="if(this.value > 0){$('#logo_bottom').val(0);}"> px
                              </div>
                            </div>
                          <{else}>
                            <input type="hidden" name="logo_top" id="logo_top" value="<{$logo_top}>">
                          <{/if}>

                          <div class="row">
                            <{if $enable.logo_left=="1"}>
                              <div class="col-sm-4">
                                <input type="text" name="logo_left" class="col-sm-8<{$validate.logo_left}> form-control" value="<{$logo_left}>" id="logo_left" onChange="if(this.value > 0){$('#logo_right').val(0);$('#logo_center').attr('checked',false);}"> px
                              </div>
                            <{else}>
                              <input type="hidden" name="logo_left" id="logo_left" value="<{$logo_left}>">
                            <{/if}>

                            <div class="col-sm-4 text-center">
                              <{if $enable.logo_center=="1"}>
                                  <label class="checkbox">
                                    <input type="checkbox" name="logo_center" value="1" id="logo_center" <{if $logo_center=='1'}>checked<{/if}> onChange="if($('#logo_center').attr('checked')){$('#logo_left').val(0);$('#logo_right').val(0);}"><{$smarty.const._MA_TADTHEMES_LOGO_CENTER}>
                                  </label>
                              <{else}>
                                <input type="hidden" name="logo_center" id="logo_right" value="<{$logo_right}>">
                              <{/if}>
                            </div>

                            <{if $enable.logo_right=="1"}>
                              <div class="col-sm-4">
                                <input type="text" name="logo_right" class="col-sm-8<{$validate.logo_right}> form-control" value="<{$logo_right}>" id="logo_right" onChange="if(this.value > 0){$('#logo_left').val(0);$('#logo_center').attr('checked',false);}"> px
                              </div>
                            <{else}>
                              <input type="hidden" name="logo_right" id="logo_right" value="<{$logo_right}>">
                            <{/if}>
                          </div>

                          <{if $enable.logo_bottom=="1"}>
                            <div class="row">
                              <div class="col-sm-4 col-sm-offset-4">
                                <input type="text" name="logo_bottom" class="col-sm-8<{$validate.logo_bottom}> form-control" value="<{$logo_bottom}>" id="logo_bottom" onChange="if(this.value > 0){$('#logo_top').val(0);}"> px
                              </div>
                            </div>
                          <{else}>
                            <input type="hidden" name="logo_bottom" id="logo_bottom" value="<{$logo_bottom}>">
                          <{/if}>
                        </div>
                      </div>
                    <{/if}>
                  </div>

                  <{if $enable.logo_img=="1"}>
                    <div class="col-sm-7">
                      <!-- 選擇預設logo圖-->
                      <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                        <label for="logo_img0" style="width:60px; height:60px;border:1px dotted gray;" >
                          <input type="radio" name="logo_img" id="logo_img0" value="" <{if $logo_img==""}>checked<{/if}>>
                          <{$smarty.const._MA_TADTHEMES_NONE}><{$smarty.const._MA_TADTHEMES_LOGO_IMG}>
                        </label>
                      </div>

                      <{if $all_logo}>
                        <{foreach from=$all_logo item=logo}>
                          <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                            <label for="logo_img<{$logo.files_sn}>" style="width:60px; height:60px; background:#000000 url(<{$logo.tb_path}>);background-repeat:no-repeat;background-position:left center;border:1px solid gray;" >
                              <input type="radio" name="logo_img" id="logo_img<{$logo.files_sn}>" value="<{$logo.path}>" <{if $logo_img==$logo.path}>checked<{/if}>>
                            </label>

                            <label class="del_img_box" style="font-size:11px;"  id="del_img<{$logo.files_sn}>">
                              <input type="checkbox" value="<{$logo.files_sn}>" name="del_file[<{$logo.files_sn}>]"> <{$smarty.const._TAD_DEL}>
                            </label>
                          </div>
                        <{/foreach}>
                      <{/if}>

                    </div>
                  <{/if}>
                </div>
              </div>
            <{else}>
              <input type="hidden" id="logo_img" name="logo_img" value="<{$logo_img}>">
              <input type="hidden" id="logo_position" name="logo_position" value="<{$logo_position}>">
              <input type="hidden" id="logo_top" name="logo_top" value="<{$logo_top}>">
              <input type="hidden" id="logo_right" name="logo_right" value="<{$logo_right}>">
              <input type="hidden" id="logo_bottom" name="logo_bottom" value="<{$logo_bottom}>">
              <input type="hidden" id="logo_left" name="logo_left" value="<{$logo_left}>">
              <input type="hidden" id="logo_center" name="logo_center" value="<{$logo_center}>">
            <{/if}>

            <!--區塊標題列背景圖-->
            <{if $config_tabs.5}>
              <div id="tabs-5">

                <div id="bt_tabs">
                  <ul class="nav nav-tabs">
                    <{foreach from=$blocks_values item=block}>
                      <li><a href="#bp_<{$block.block_position}>"><{$block.title}></a></li>
                    <{/foreach}>
                  </ul>

                  <{foreach from=$blocks_values item=block}>
                    <div id="bp_<{$block.block_position}>">
                      <div style="font-size:1.5em;margin:0px 0px 10px;font-weight:bold;">
                        <{$block.title}>
                      <label class="checkbox-inline">
                        <input type="checkbox" name="apply_to_all" value="<{$block.block_position}>">
                        <{$smarty.const._MA_TADTHEMES_BLOCK_ALL_POSITION}>
                      </label></div>
                      <div class="row">
                        <!-- 區塊標題文字大小-->
                        <{if $enable.bt_text_size=="1"}>
                          <div class="col-sm-2 text-right">
                            <{$smarty.const._MA_TADTHEMES_BLOCK_TITLE_SIZE}>
                          </div>
                          <div class="col-sm-4">
                            <input type="text" name="bt_text_size[<{$block.block_position}>]" class="col-sm-6<{$validate.bt_text_size}>" value="<{$block.bt_text_size}>" id="bt_text_size_<{$block.block_position}>">
                          </div>
                        <{else}>
                          <input type="hidden" name="bt_text_size" id="bt_text_size" value="<{$bt_text_size}>">
                        <{/if}>

                        <!-- 區塊標題文字縮排-->
                        <{if $enable.bt_text_padding=="1"}>
                          <div class="col-sm-2 text-right">
                            <{$smarty.const._MA_TADTHEMES_BLOCK_TITLE_PADDING}>
                          </div>
                          <div class="col-sm-4">
                            <input type="text" name="bt_text_padding[<{$block.block_position}>]" class="col-sm-6<{$validate.bt_text_padding}>" value="<{$block.bt_text_padding}>" id="bt_text_padding_<{$block.block_position}>">px
                          </div>
                        <{else}>
                          <input type="hidden" name="bt_text_padding" id="bt_text_padding" value="<{$bt_text_padding}>">
                        <{/if}>
                      </div>

                      <div class="row">
                        <!-- 區塊標題列文字顏色-->
                        <{if $enable.bt_text=="1"}>
                          <div class="col-sm-2 text-right">
                            <{$smarty.const._MA_TADTHEMES_FONT_COLOR}>
                          </div>
                          <div class="col-sm-4">
                            <input type="text" name="bt_text[<{$block.block_position}>]" id="bt_text_<{$block.block_position}>" value="<{$block.bt_text}>" class="col-sm-6<{$validate.bt_text}>" data-hex="true">
                          </div>
                        <{else}>
                          <input type="hidden" name="bt_text" id="bt_text" value="<{$bt_text}>">
                        <{/if}>

                        <!-- 區塊標題列背景顏色-->
                        <{if $enable.bt_bg_color=="1"}>
                          <div class="col-sm-2 text-right">
                            <{$smarty.const._MA_TADTHEMES_BG_COLOR}>
                          </div>
                          <div class="col-sm-4">
                            <input type="text" name="bt_bg_color[<{$block.block_position}>]" id="bt_bg_color_<{$block.block_position}>" value="<{$block.bt_bg_color}>" class="col-sm-6<{$validate.bt_bg_color}>" data-hex="true">
                          </div>
                        <{else}>
                          <input type="hidden" name="bt_bg_color" id="bt_bg_color" value="<{$bt_bg_color}>">
                        <{/if}>
                      </div>

                      <div class="row">

                        <!-- 區塊標題圓角設定-->
                        <{if $enable.bt_radius=="1"}>
                          <div class="col-sm-2 text-right">
                            <{$smarty.const._MA_TADTHEMES_BLOCK_TITLE_RADIUS}>
                          </div>

                          <div class="col-sm-4">
                            <select name="bt_radius[<{$block.block_position}>]" id="bt_radius_<{$block.block_position}>" class="col-sm-12<{$validate.bt_radius}>">
                              <option value="1" <{if $block.bt_radius=="1"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BLOCK_TITLE_RADIUS_Y}></option>
                              <option value="0" <{if $block.bt_radius=="0"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BLOCK_TITLE_RADIUS_N}></option>
                            </select>
                          </div>
                        <{else}>
                          <input type="hidden" name="bt_radius" id="bt_radius" value="<{$bt_radius}>">
                        <{/if}>

                        <!-- 區塊標題工具按鈕-->
                        <{if $enable.block_config=="1"}>
                          <div class="col-sm-2 text-right">
                            <{$smarty.const._MA_TADTHEMES_BLOCK_TITLE_BUTTOM}>
                          </div>

                          <div class="col-sm-4">
                            <select name="block_config[<{$block.block_position}>]" id="block_config_<{$block.block_position}>" class="col-sm-12<{$validate.block_config}>">
                              <option value="right" <{if $block.block_config=="right"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_RT}></option>
                              <option value="left" <{if $block.block_config=="left"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_LT}></option>
                            </select>
                          </div>
                        <{else}>
                          <input type="hidden" name="block_config" id="block_config" value="<{$block_config}>">
                        <{/if}>
                      </div>

                      <div class="row">
                        <!-- 上傳區塊標題列背景圖-->
                        <{if $enable.bt_bg_img=="1"}>
                          <div class="col-sm-2 text-right">
                            <{$smarty.const._MA_TAD_THEMES_UPLOAD}>
                            <{$smarty.const._MA_TADTHEMES_BG_IMG}>
                          </div>
                          <div class="col-sm-4">
                            <{$block.upform_bt_bg}>
                          </div>
                        <{else}>
                          <input type="hidden" name="bt_bg_img" id="bt_bg_img" value="<{$bt_bg_img}>">
                        <{/if}>

                        <!-- 區塊標題列背景重複-->
                        <{if $enable.bt_bg_repeat=="1"}>
                          <div class="col-sm-2 text-right">
                            <{$smarty.const._MA_TADTHEMES_BG_REPEAT}>
                          </div>
                          <div class="col-sm-4">
                            <select name="bt_bg_repeat[<{$block.block_position}>]" id="bt_bg_repeat_<{$block.block_position}>" class="col-sm-12<{$validate.bt_bg_repeat}>">
                              <option value="1" <{if $block.bt_bg_repeat=="1"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_REPEAT_NORMAL}></option>
                              <option value="0" <{if $block.bt_bg_repeat=="0"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_NO_REPEAT}></option>
                            </select>
                          </div>
                        <{else}>
                          <input type="hidden" name="bt_bg_repeat" id="bt_bg_repeat" value="<{$bt_bg_repeat}>">
                        <{/if}>
                      </div>



                      <!-- 選擇預設區塊標題列背景圖-->
                      <{if $block.all_bt_bg and $enable.bt_bg_img=='1'}>
                        <div class="row">
                          <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                            <label for="bt_bg_img0_<{$block.block_position}>" style="width:60px; height:60px;border:1px dotted gray;" >
                              <input type="radio" name="bt_bg_img[<{$block.block_position}>]" id="bt_bg_img0_<{$block.block_position}>" onChange="$('.del_img_box_<{$block.block_position}>').show();" value="" <{if $block.bt_bg_img==""}>checked<{/if}>>
                              <{$smarty.const._MA_TADTHEMES_NONE}>
                            </label>
                          </div>
                          <{foreach from=$block.all_bt_bg item=bt_bg}>
                            <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                              <label for="bt_bg_img<{$bt_bg.files_sn}>_<{$block.block_position}>" style="width:60px; height:60px; background:#000000 url(<{$bt_bg.tb_path}>);background-position:left center;border:1px solid gray;" >
                                <input type="radio" name="bt_bg_img[<{$block.block_position}>]" id="bt_bg_img<{$bt_bg.files_sn}>_<{$block.block_position}>" onChange="$('.del_img_box_<{$block.block_position}>').show(); $('#del_img<{$bt_bg.files_sn}>_<{$block.block_position}>').hide(); " value="<{$bt_bg.path}>" <{if $block.bt_bg_img==$bt_bg.path}>checked<{/if}>>
                              </label>
                              <label class="del_img_box" style="font-size:11px;"  id="del_img<{$bt_bg.files_sn}>_<{$block.block_position}>">
                                <input type="checkbox" value="<{$bt_bg.files_sn}>" name="del_file[<{$bt_bg.files_sn}>]"> <{$smarty.const._TAD_DEL}>
                              </label>
                            </div>
                          <{/foreach}>
                        </div>
                      <{/if}>



                      <div class="row">
                        <!-- 區塊整體樣式-->
                        <{if $enable.block_style=="1"}>
                          <div>
                            <{$smarty.const._MA_TADTHEMES_BLOCK_STYLE}>
                            <span style="font-size:12px;color:#0000DC;white-space:nowrap; ">.<{$block.block_position}> {<span style="color:#DE1212;"><{$smarty.const._MA_TADTHEMES_YOUR_STYLE}></span>}</span>
                          </div>
                          <textarea name="block_style[<{$block.block_position}>]" id="block_style_<{$block.block_position}>" class="col-sm-12<{$validate.block_style}>" style="font-size:11px;height:50px;"><{$block.block_style}></textarea>
                        <{else}>
                          <input type="hidden" name="block_style" id="block_style" value="<{$block_style}>">
                        <{/if}>
                      </div>


                      <div class="row">
                        <!-- 區塊標題樣式-->
                        <{if $enable.block_title_style=="1"}>
                          <div>
                            <{$smarty.const._MA_TADTHEMES_BLOCK_TITLE_STYLE}>
                            <span style="font-size:12px;color:#0000DC;white-space:nowrap; ">.<{$block.block_position}> .blockTitle {<span style="color:#DE1212;"><{$smarty.const._MA_TADTHEMES_YOUR_STYLE}></span>}</span>
                          </div>
                          <textarea name="block_title_style[<{$block.block_position}>]" id="block_title_style_<{$block.block_position}>" class="col-sm-12<{$validate.block_title_style}>" style="font-size:11px;height:50px;"><{$block.block_title_style}></textarea>
                        <{else}>
                          <input type="hidden" name="block_title_style" id="block_title_style" value="<{$block_title_style}>">
                        <{/if}>
                      </div>


                      <div class="row">
                        <!-- 區塊內容樣式-->
                        <{if $enable.block_content_style=="1"}>
                          <div>
                            <{$smarty.const._MA_TADTHEMES_BLOCK_CONTENT_STYLE}>
                            <span style="font-size:12px;color:#0000DC;white-space:nowrap; ">.<{$block.block_position}> .blockContent {<span style="color:#DE1212;"><{$smarty.const._MA_TADTHEMES_YOUR_STYLE}></span>}</span>
                          </div>
                          <textarea name="block_content_style[<{$block.block_position}>]" id="block_content_style_<{$block.block_position}>" class="col-sm-12<{$validate.block_content_style}>" style="font-size:11px;height:50px;"><{$block.block_content_style}></textarea>
                        <{else}>
                          <input type="hidden" name="block_content_style" id="block_content_style" value="<{$block_content_style}>">
                        <{/if}>
                      </div>


                    </div>
                  <{/foreach}>
                </div>
              </div>
            <{else}>
              <input type="hidden" id="bt_text_size" name="bt_text_size" value="<{$bt_text_size}>">
              <input type="hidden" id="bt_text_padding" name="bt_text_padding" value="<{$bt_text_padding}>">
              <input type="hidden" id="bt_text" name="bt_text" value="<{$bt_text}>">
              <input type="hidden" id="bt_bg_color" name="bt_bg_color" value="<{$bt_bg_color}>">
              <input type="hidden" id="bt_radius" name="bt_radius" value="<{$bt_radius}>">
              <input type="hidden" id="block_config" name="block_config" value="<{$block_config}>">
              <input type="hidden" id="bt_bg_img" name="bt_bg_img" value="<{$bt_bg_img}>">
              <input type="hidden" id="bt_bg_repeat" name="bt_bg_repeat" value="<{$bt_bg_repeat}>">
              <input type="hidden" id="block_style" name="block_style" value="<{$block_style}>">
              <input type="hidden" id="block_title_style" name="block_title_style" value="<{$block_title_style}>">
              <input type="hidden" id="block_content_style" name="block_content_style" value="<{$block_content_style}>">
            <{/if}>

            <!--navbar-->
            <{if $config_tabs.6}>
              <div id="tabs-6">
                <div class="row">
                  <{if $enable.navbar_pos=="1" or $enable.navbar_bg_top=="1" or  $enable.navbar_bg_bottom=="1" or $enable.navbar_hover=="1"}>
                    <div class="col-sm-6">
                      <!--導覽工具列位置-->
                      <{if $enable.navbar_pos=="1"}>
                        <div class="row">
                          <div class="col-sm-4"><{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION}></div>
                          <div class="col-sm-8">
                            <select name="navbar_pos" id="navbar_pos" class="col-sm-12<{$validate.navbar_pos}>">
                              <option value="navbar-fixed-top" <{if $navbar_pos=="navbar-fixed-top"}>selected<{/if}>>
                              <{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION_1}></option>
                              <option value="navbar-fixed-bottom" <{if $navbar_pos=="navbar-fixed-bottom"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION_2}></option>
                              <option value="navbar-static-top" <{if $navbar_pos=="navbar-static-top"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION_3}></option>
                              <option value="navbar-static-bottom" <{if $navbar_pos=="navbar-static-bottom"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION_6}></option>
                              <option value="default" <{if $navbar_pos=="default"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION_4}></option>
                              <option value="not-use" <{if $navbar_pos=="not-use"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION_5}></option>
                            </select>
                          </div>
                        </div>
                      <{else}>
                        <input type="hidden" name="navbar_pos" id="navbar_pos" value="<{$navbar_pos}>">
                      <{/if}>

                      <!--導覽工具列 漸層顏色(top) -->
                      <{if $enable.navbar_bg_top=="1"}>
                        <div class="row">
                          <div class="col-sm-4">
                            <{$smarty.const._MA_TADTHEMES_NAVBAR}>
                            <{$smarty.const._MA_TADTHEMES_NAVBAR_BG_COLOR}>(top)
                          </div>
                          <div class="col-sm-8">
                            <input type="text" name="navbar_bg_top" id="navbar_bg_top" value="<{$navbar_bg_top}>" class="col-sm-6<{$validate.navbar_bg_top}>" data-hex="true">
                          </div>
                        </div>
                      <{else}>
                        <input type="hidden" name="navbar_bg_top" id="navbar_bg_top" value="<{$navbar_bg_top}>">
                      <{/if}>

                      <!--導覽工具列 漸層顏色(bottom)-->
                      <{if $enable.navbar_bg_bottom=="1"}>
                        <div class="row">
                          <div class="col-sm-4">
                            <{$smarty.const._MA_TADTHEMES_NAVBAR}>
                            <{$smarty.const._MA_TADTHEMES_NAVBAR_BG_COLOR}>(bottom)
                          </div>
                          <div class="col-sm-8">
                            <input type="text" name="navbar_bg_bottom" id="navbar_bg_bottom" value="<{$navbar_bg_bottom}>" class="col-sm-6<{$validate.navbar_bg_bottom}>" data-hex="true">
                          </div>
                        </div>
                      <{else}>
                        <input type="hidden" name="navbar_bg_bottom" id="navbar_bg_bottom" value="<{$navbar_bg_bottom}>">
                      <{/if}>

                      <!--導覽工具列 連結區塊底色-->
                      <{if $enable.navbar_hover=="1"}>
                        <div class="row">
                          <div class="col-sm-4">
                            <{$smarty.const._MA_TADTHEMES_NAVBAR}>
                            <{$smarty.const._MA_TADTHEMES_NAVBAR_HOVER_COLOR}>
                          </div>
                          <div class="col-sm-8">
                            <input type="text" name="navbar_hover" id="navbar_hover" value="<{$navbar_hover}>" class="col-sm-6<{$validate.navbar_hover}>" data-hex="true">
                          </div>
                        </div>
                      <{else}>
                        <input type="hidden" name="navbar_hover" id="navbar_hover" value="<{$navbar_hover}>">
                      <{/if}>
                    </div>
                  <{else}>
                    <input type="hidden" id="navbar_pos" name="navbar_pos" value="<{$navbar_pos}>">
                    <input type="hidden" id="navbar_bg_top" name="navbar_bg_top" value="<{$navbar_bg_top}>">
                    <input type="hidden" id="navbar_bg_bottom" name="navbar_bg_bottom" value="<{$navbar_bg_bottom}>">
                    <input type="hidden" id="navbar_hover" name="navbar_hover" value="<{$navbar_hover}>">
                  <{/if}>

                  <div class="col-sm-6">
                    <!--導覽工具列 文字顏色-->
                    <{if $enable.navbar_color=="1"}>
                      <div class="row">
                        <div class="col-sm-4">
                          <{$smarty.const._MA_TADTHEMES_NAVBAR}>
                          <{$smarty.const._MA_TADTHEMES_NAVBAR_COLOR}>
                        </div>
                        <div class="col-sm-8">
                          <input type="text" name="navbar_color" id="navbar_color" value="<{$navbar_color}>" class="col-sm-6<{$validate.navbar_color}>" data-hex="true">
                        </div>
                      </div>
                    <{else}>
                      <input type="hidden" name="navbar_color" id="navbar_color" value="<{$navbar_color}>">
                    <{/if}>


                    <!--導覽工具列 文字移過顏色-->
                    <{if $enable.navbar_color_hover=="1"}>
                      <div class="row">
                        <div class="col-sm-4">
                          <{$smarty.const._MA_TADTHEMES_NAVBAR}>
                          <{$smarty.const._MA_TADTHEMES_NAVBAR_COLOR_HOVER}>
                        </div>
                        <div class="col-sm-8">
                          <input type="text" name="navbar_color_hover" id="navbar_color_hover" value="<{$navbar_color_hover}>" class="col-sm-6<{$validate.navbar_color_hover}>" data-hex="true">
                        </div>
                      </div>
                    <{else}>
                      <input type="hidden" name="navbar_color_hover" id="navbar_color_hover" value="<{$navbar_color_hover}>">
                    <{/if}>

                    <!--導覽工具列 圖示顏色-->
                    <{if $enable.navbar_icon=="1"}>
                      <div class="row">
                        <div class="col-sm-4">
                          <{$smarty.const._MA_TADTHEMES_NAVBAR}>
                          <{$smarty.const._MA_TADTHEMES_NAVBAR_ICON_COLOR}>
                        </div>
                        <div class="col-sm-8">
                          <label for="navbar_icon_white">
                            <input type="radio" name="navbar_icon" id="navbar_icon_white" value="icon-white" <{if $navbar_icon=="icon-white"}>checked<{/if}>>
                            <{$smarty.const._MA_TADTHEMES_NAVBAR_ICON_WHITE}>
                          </label>
                          <label for="navbar_icon_black">
                            <input type="radio" name="navbar_icon" id="navbar_icon_black" value="" <{if $navbar_icon==""}>checked<{/if}>>
                            <{$smarty.const._MA_TADTHEMES_NAVBAR_ICON_BLACK}>
                          </label>
                        </div>
                      </div>
                    <{else}>
                      <input type="hidden" name="navbar_icon" id="navbar_icon" value="<{$navbar_icon}>">
                    <{/if}>
                  </div>
                </div>


                <div class="row">
                  <div class="col-sm-5">
                    <{if $enable.navbar_img=="1"}>
                      <div class="row">
                        <!-- 上傳navbar_img圖-->
                        <div class="col-sm-4 text-right">
                          <{$smarty.const._MA_TAD_THEMES_UPLOAD}><{$smarty.const._MA_TADTHEMES_NAVBAR_IMG}>
                        </div>
                        <div class="col-sm-8">
                          <{$upform_navbar_img}>
                        </div>
                      </div>
                    <{else}>
                      <input type="hidden" name="navbar_img" id="navbar_img" value="<{$navbar_img}>">
                    <{/if}>

                  </div>

                  <{if $enable.navbar_img=="1"}>
                    <div class="col-sm-7">
                      <!-- 選擇預設導覽列navbar_img圖-->
                      <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                        <label for="navbar_img0" style="width:60px; height:60px;border:1px dotted gray;" >
                          <input type="radio" name="navbar_img" id="navbar_img0" onChange="$('.del_img_box').show();" value="" <{if $navbar_img==""}>checked<{/if}>>
                          <{$smarty.const._MA_TADTHEMES_NONE}><{$smarty.const._MA_TADTHEMES_NAVBAR_IMG}>
                        </label>
                      </div>

                      <{if $all_navbar_img}>
                        <{foreach from=$all_navbar_img item=navbarbg}>
                          <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                            <label for="navbar_img<{$navbarbg.files_sn}>" style="width:60px; height:60px; background:#000000 url(<{$navbarbg.tb_path}>);background-repeat:no-repeat;background-position:left center;border:1px solid gray;" >
                              <input type="radio" name="navbar_img" id="navbar_img<{$navbarbg.files_sn}>" onChange="$('.del_img_box').show(); $('#del_img<{$navbarbg.files_sn}>').hide();" value="<{$navbarbg.path}>" <{if $navbar_img==$navbarbg.path}>checked<{/if}>>
                            </label>
                            <label class="del_img_box" style="font-size:11px;"  id="del_img<{$navbarbg.files_sn}>">
                              <input type="checkbox" value="<{$navbarbg.files_sn}>" name="del_file[<{$navbarbg.files_sn}>]"> <{$smarty.const._TAD_DEL}>
                            </label>
                          </div>
                        <{/foreach}>
                      <{/if}>

                    </div>
                  <{/if}>
                </div>


                <div class="row">
                  <div class="col-sm-5">

                    <{if $enable.navlogo_img=="1"}>
                      <div class="row">
                        <!-- 上傳logo圖-->
                        <div class="col-sm-4 text-right">
                          <{$smarty.const._MA_TAD_THEMES_UPLOAD}><{$smarty.const._MA_TADTHEMES_NAVLOGO_IMG}>
                        </div>
                        <div class="col-sm-8">
                          <{$upform_navlogo}>
                        </div>
                      </div>
                    <{else}>
                      <input type="hidden" name="navlogo_img" id="navlogo_img" value="<{$navlogo_img}>">
                    <{/if}>

                  </div>

                  <{if $enable.navlogo_img=="1"}>
                    <div class="col-sm-7">
                      <!-- 選擇預設導覽列navlogo圖-->
                      <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                        <label for="navlogo_img0" style="width:60px; height:60px;border:1px dotted gray;" >
                          <input type="radio" name="navlogo_img" id="navlogo_img0" value="" <{if $navlogo_img==""}>checked<{/if}>>
                          <{$smarty.const._MA_TADTHEMES_NONE}><{$smarty.const._MA_TADTHEMES_NAVLOGO_IMG}>
                        </label>
                      </div>

                      <{if $all_navlogo}>
                        <{foreach from=$all_navlogo item=navlogo}>
                          <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                            <label for="logo_img<{$navlogo.files_sn}>" style="width:60px; height:60px; background:#000000 url(<{$navlogo.tb_path}>);background-repeat:no-repeat;background-position:left center;border:1px solid gray;" >
                              <input type="radio" name="navlogo_img" id="navlogo_img<{$navlogo.files_sn}>" value="<{$navlogo.path}>" <{if $navlogo_img==$navlogo.path}>checked<{/if}>>
                            </label>
                            <label class="del_navimg_box" style="font-size:11px;"  id="del_navimg<{$navlogo.files_sn}>">
                              <input type="checkbox" value="<{$navlogo.files_sn}>" name="del_file[<{$navlogo.files_sn}>]"> <{$smarty.const._TAD_DEL}>
                            </label>
                          </div>
                        <{/foreach}>
                      <{/if}>

                    </div>
                  <{/if}>
                </div>
              </div>
            <{else}>
              <input type="hidden" id="navbar_pos" name="navbar_pos" value="<{$navbar_pos}>">
              <input type="hidden" id="navbar_bg_top" name="navbar_bg_top" value="<{$navbar_bg_top}>">
              <input type="hidden" id="navbar_bg_bottom" name="navbar_bg_bottom" value="<{$navbar_bg_bottom}>">
              <input type="hidden" id="navbar_hover" name="navbar_hover" value="<{$navbar_hover}>">
              <input type="hidden" id="navbar_img" name="navbar_img" value="<{$navbar_img}>">
              <input type="hidden" id="navbar_color" name="navbar_color" value="<{$navbar_color}>">
              <input type="hidden" id="navbar_color_hover" name="navbar_color_hover" value="<{$navbar_color_hover}>">
              <input type="hidden" id="navbar_icon" name="navbar_icon" value="<{$navbar_icon}>">
              <input type="hidden" id="navlogo_img" name="navlogo_img" value="<{$navlogo_img}>">
            <{/if}>

            <!--額外設定-->
            <{if $config2}>
            <div id="tabs-7">
              <input type="hidden" name="config2" value="1">
              <{foreach from=$theme_config item=config}>
                <div class="row">
                  <div class="col-sm-2 text-right">
                    <{$config.text}>
                  </div>
                  <div class="col-sm-5">
                    <{if $config.type=="text"}>
                      <input type="text" name="<{$config.name}>" value="<{$config.value}>" class="col-sm-12">
                    <{elseif $config.type=="color"}>
                      <input type="text" name="<{$config.name}>" id="<{$config.name}>" value="<{$config.value}>" class="col-sm-8" data-hex="true" >
                    <{elseif $config.type=="array"}>
                      <textarea name="<{$config.name}>" class="col-sm-12" rows=4 style="font-size:0.8em;"><{$config.value}></textarea>
                    <{elseif $config.type=="textarea"}>
                      <textarea name="<{$config.name}>" class="col-sm-12" rows=4 style="font-size:0.8em;"><{$config.value}></textarea>
                    <{elseif $config.type=="yesno"}>
                      <label class="radio-inline">
                        <input type="radio" name="<{$config.name}>" id="<{$config.name}>1" value="1" <{if $config.value==1}>checked<{/if}> ><{$smarty.const._YES}>
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="<{$config.name}>" id="<{$config.name}>0" value="0" <{if $config.value==0}>checked<{/if}> ><{$smarty.const._NO}>
                      </label>
                    <{elseif $config.type=="file"}>
                      <{$config.form}>
                    <{/if}>
                  </div>

                  <{if $config.type=="file"}>
                    <div class="col-sm-5">
                      <{if $config.list}>

                        <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                          <label for="<{$config.name}>0" style="width:60px; height:60px;border:1px dotted gray;" >
                            <input type="radio" name="<{$config.name}>" id="<{$config.name}>0" value="" <{if $config.value==""}>checked<{/if}>>
                            <{$smarty.const._MA_TADTHEMES_NONE}>
                          </label>
                        </div>

                        <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                          <label for="<{$config.name}>" style="width:60px; height:60px; background:#000000 url(<{$config.default}>);background-repeat:no-repeat;background-position:left center;border:1px solid gray;background-size: cover;" >
                            <input type="radio" name="<{$config.name}>" id="<{$config.name}><{$file.files_sn}>" value="<{$config.default}>"  <{if $config.value==$config.default}>checked<{/if}>>
                          </label>
                            <label style="font-size:11px;">
                              <{$smarty.const._MA_TADTHEMES_DEFAULT}>
                            </label>

                        </div>

                        <{foreach from=$config.list item=file}>
                          <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                            <label for="<{$config.name}><{$file.files_sn}>" style="width:60px; height:60px; background:#000000 url(<{$file.tb_path}>);background-position:left center;border:1px solid gray;" >
                              <input type="radio" name="<{$config.name}>" id="<{$config.name}><{$file.files_sn}>" value="<{$file.path}>" onChange="$('.del_<{$config.name}>').show(); $('#del_<{$config.name}><{$file.files_sn}>').hide();" <{if $config.value==$file.path}>checked<{/if}>>
                            </label>
                            <label class="del_<{$config.name}>" style="font-size:11px;" id="del_<{$config.name}><{$file.files_sn}>">
                              <input type="checkbox" value="<{$file.files_sn}>" name="del_file[<{$file.files_sn}>]"> <{$smarty.const._TAD_DEL}>
                            </label>
                          </div>
                        <{/foreach}>
                        <div style="clear:both;"></div>
                      <{/if}>
                    </div>
                  <{else}>
                    <div class="col-sm-5 alert alert-info">
                      <{$config.desc}>
                    </div>
                  <{/if}>
                </div>


              <{/foreach}>
            </div>
            <{/if}>
          </div>
        </div>

      </div>



      <div class="col-sm-4">
        <!--預覽-->
        <div class="row">
          <div class="col-sm-12 text-center">
            <div id='preview_zone' class="col-sm-12">
              <div id='theme_demo' style='border:1px solid gray;background-color:white;margin:0px auto;'>
                <div id='theme_head' style='border:1px solid #E0E0E0;background-color:#F0F0F0;margin:4px auto 2px auto;font-size:11px;text-align:center;'><{$smarty.const._MA_TAD_THEMES_HEAD}></div>
                <div id='left_block' style='border:1px solid #E0E0E0;background-color:#99CCFF;font-size:11px;text-align:center;'></div>
                <div id='center_block' style='border:1px solid #E0E0E0;background-color:#CCFF66;font-size:11px;text-align:center;'></div>
                <div id='right_block' style='border:1px solid #E0E0E0;background-color:#FFCC66;font-size:11px;text-align:center;'></div>
                <div id='theme_foot' style='clear:both;border:1px solid #E0E0E0;height:30px;line-height:30px;background-color:#F0F0F0;margin:4px auto;font-size:11px;text-align:center;'><{$smarty.const._MA_TAD_THEMES_FOOT}></div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="text-center">
            <!--中左區塊寬度-->
            <input type="hidden" name="clb_width" value="<{$clb_width}>" id="clb_width" >
            <!--中右區塊寬度-->
            <input type="hidden" name="crb_width" value="<{$crb_width}>" id="crb_width" >
            <input type="hidden" name="theme_id" value="<{$theme_id}>">
            <input type="hidden" name="theme_name" value="<{$theme_name}>">

            <!--佈景圖片寬度-->
            <input type="hidden" name="op" value="<{$op}>">
            <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12 alert alert-info">
            <{if $theme_kind!="bootstrap" and $theme_kind!="bootstrap3"}><{$smarty.const._MA_TADTHEMES_NOTICE}><{/if}>
            <{$smarty.const._MA_TADTHEMES_NOTICE2}>
          </div>
        </div>

      </div>
    </div>
  </form>
</div>
