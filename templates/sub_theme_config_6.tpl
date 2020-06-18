<!--導覽工具列位置-->
<{if $enable.navbar_pos=="1" or $enable.navbar_font_size!="0"}>
    <div class="form-group row">
        <{if $enable.navbar_pos=="1"}>
            <label class="col-sm-2 col-form-label text-sm-right control-label"><{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION}></label>
            <div class="col-sm-4">
                <select name="navbar_pos" id="navbar_pos" class="form-control <{$validate.navbar_pos}>">
                    <option value="fixed-top" <{if $navbar_pos=="fixed-top"}>selected<{/if}>>
                    <{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION_1}></option>
                    <option value="fixed-bottom" <{if $navbar_pos=="fixed-bottom"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION_2}></option>
                    <option value="sticky-top" <{if $navbar_pos=="sticky-top"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION_3}></option>
                    <option value="default" <{if $navbar_pos=="default"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION_6}></option>
                    <option value="not-use" <{if $navbar_pos=="not-use"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION_5}></option>
                </select>
            </div>
        <{else}>
            <{$navbar_font_size_hidden}>
        <{/if}>


        <!--導覽工具列 文字大小-->
        <{if $enable.navbar_font_size!="0"}>
            <label class="col-sm-2 col-form-label text-sm-right control-label">
                <{$smarty.const._MA_TADTHEMES_NAVBAR_FONT_SIZE}>
            </label>
            <div class="col-sm-4">
                <div class="input-group">
                    <{$navbar_font_size_input}>
                    <div class="input-group-append input-group-addon">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
        <{else}>
            <{$navbar_font_size_hidden}>
        <{/if}>
    </div>
<{else}>
    <input type="hidden" name="navbar_pos" id="navbar_pos" value="<{$navbar_pos}>">
    <{$navbar_font_size_hidden}>
<{/if}>



<{if $enable.navbar_color=="1" or $enable.navbar_icon=="1"}>
    <div class="form-group row">
        <!--導覽工具列 文字顏色-->
        <{if $enable.navbar_color=="1"}>
            <label class="col-sm-2 col-form-label text-sm-right control-label">
                <{$smarty.const._MA_TADTHEMES_NAVBAR_COLOR}>
            </label>
            <div class="col-sm-4">
                <input type="text" name="navbar_color" id="navbar_color" value="<{$navbar_color}>" class="form-control color-picker <{$validate.navbar_color}>" data-hex="true">
            </div>
        <{else}>
            <input type="hidden" name="navbar_color" id="navbar_color" value="<{$navbar_color}>">
        <{/if}>

        <!--導覽工具列 圖示顏色-->
        <{if $enable.navbar_icon=="1"}>
            <label class="col-sm-2 col-form-label text-sm-right control-label">
                <{$smarty.const._MA_TADTHEMES_NAVBAR_ICON_COLOR}>
            </label>
            <div class="col-sm-4">
                <label for="navbar_icon_white">
                    <input type="radio" name="navbar_icon" id="navbar_icon_white" value="icon-white" <{if $navbar_icon=="icon-white"}>checked<{/if}>>
                    <{$smarty.const._MA_TADTHEMES_NAVBAR_ICON_WHITE}>
                </label>
                <label for="navbar_icon_black">
                    <input type="radio" name="navbar_icon" id="navbar_icon_black" value="" <{if $navbar_icon==""}>checked<{/if}>>
                    <{$smarty.const._MA_TADTHEMES_NAVBAR_ICON_BLACK}>
                </label>
            </div>
        <{else}>
            <input type="hidden" name="navbar_icon" id="navbar_icon" value="<{$navbar_icon}>">
        <{/if}>
    </div>
<{else}>
    <input type="hidden" name="navbar_color" id="navbar_color" value="<{$navbar_color}>">
    <input type="hidden" name="navbar_icon" id="navbar_icon" value="<{$navbar_icon}>">
<{/if}>

<{if $enable.navbar_bg_top=="1" or $enable.navbar_bg_bottom=="1"}>
    <div class="form-group row">
        <!--導覽工具列 漸層顏色(top) -->
        <{if $enable.navbar_bg_top=="1"}>
            <label class="col-sm-2 col-form-label text-sm-right control-label">
                <{$smarty.const._MA_TADTHEMES_NAVBAR_BG_COLOR}>
            </label>
            <div class="col-sm-4">
                <input type="text" name="navbar_bg_top" id="navbar_bg_top" value="<{$navbar_bg_top}>" class="form-control color-picker <{$validate.navbar_bg_top}>" data-hex="true">
            </div>
        <{else}>
            <input type="hidden" name="navbar_bg_top" id="navbar_bg_top" value="<{$navbar_bg_top}>">
        <{/if}>
        <!--導覽工具列 漸層顏色(bottom) -->
        <{if $enable.navbar_bg_bottom=="1"}>
            <label class="col-sm-2 col-form-label text-sm-right control-label">
                <{$smarty.const._MA_TADTHEMES_NAVBAR_CHANGE}>
            </label>
            <div class="col-sm-4">
                <input type="text" name="navbar_bg_bottom" id="navbar_bg_bottom" value="<{$navbar_bg_bottom}>" class="form-control color-picker <{$validate.navbar_bg_bottom}>" data-hex="true">
            </div>
        <{else}>
            <input type="hidden" name="navbar_bg_bottom" id="navbar_bg_bottom" value="<{$navbar_bg_bottom}>">
        <{/if}>
    </div>
<{else}>
    <input type="hidden" name="navbar_bg_top" id="navbar_bg_top" value="<{$navbar_bg_top}>">
    <input type="hidden" name="navbar_bg_bottom" id="navbar_bg_bottom" value="<{$navbar_bg_bottom}>">
<{/if}>


<{if $enable.navbar_color_hover=="1" or $enable.navbar_hover=="1"}>
    <div class="form-group row">
        <!--導覽工具列 滑鼠移過顏色-->
        <{if $enable.navbar_color_hover=="1"}>
            <label class="col-sm-2 col-form-label text-sm-right control-label">
                <{$smarty.const._MA_TADTHEMES_NAVBAR_COLOR_HOVER}>
            </label>
            <div class="col-sm-4">
                <input type="text" name="navbar_color_hover" id="navbar_color_hover" value="<{$navbar_color_hover}>" class="form-control color-picker <{$validate.navbar_color_hover}>" data-hex="true">
            </div>
        <{else}>
            <input type="hidden" name="navbar_color_hover" id="navbar_color_hover" value="<{$navbar_color_hover}>">
        <{/if}>
        <{if $enable.navbar_hover=="1"}>
            <label class="col-sm-2 col-form-label text-sm-right control-label">
                <{$smarty.const._MA_TADTHEMES_NAVBAR_HOVER_COLOR}>
            </label>
            <div class="col-sm-4">
                <input type="text" name="navbar_hover" id="navbar_hover" value="<{$navbar_hover}>" class="form-control color-picker <{$validate.navbar_hover}>" data-hex="true">
            </div>
        <{else}>
            <input type="hidden" name="navbar_hover" id="navbar_hover" value="<{$navbar_hover}>">
        <{/if}>
    </div>
<{else}>
    <input type="hidden" name="navbar_color_hover" id="navbar_color_hover" value="<{$navbar_color_hover}>">
    <input type="hidden" name="navbar_hover" id="navbar_hover" value="<{$navbar_hover}>">
<{/if}>





<{if $enable.navbar_py=="1" or $enable.navbar_px=="1"}>
    <div class="form-group row">
        <!--導覽工具列 導覽選項上下距離-->
        <{if $enable.navbar_py=="1"}>
            <label class="col-sm-2 col-form-label text-sm-right control-label">
                <{$smarty.const._MA_TADTHEMES_NAVBAR_PY}>
            </label>
            <div class="col-sm-4">
                <div class="input-group">
                    <{$navbar_py_input}>
                    <div class="input-group-append input-group-addon">
                        <span class="input-group-text">px</span>
                    </div>
                </div>
            </div>
        <{else}>
            <{$navbar_py_hidden}>
        <{/if}>

        <!--導覽工具列 導覽選項左右距離-->
        <{if $enable.navbar_px=="1"}>
            <label class="col-sm-2 col-form-label text-sm-right control-label">
                <{$smarty.const._MA_TADTHEMES_NAVBAR_PX}>
            </label>
            <div class="col-sm-4">
                <div class="input-group">
                    <{$navbar_px_input}>
                    <div class="input-group-append input-group-addon">
                        <span class="input-group-text">px</span>
                    </div>
                </div>
            </div>
        <{else}>
            <{$navbar_px_hidden}>
        <{/if}>
    </div>
<{else}>
    <{$navbar_py_hidden}>
    <{$navbar_px_hidden}>
<{/if}>

<div class="row">
    <div class="col-sm-5">
        <{if $enable.navbar_img=="1"}>
            <div class="row">
                <!-- 上傳navbar_img圖-->
                <label class="col-sm-4 col-form-label text-sm-right control-label">
                    <{$smarty.const._MA_TAD_THEMES_UPLOAD}><{$smarty.const._MA_TADTHEMES_NAVBAR_IMG}>
                </label>
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
            <div class="thumb_div">
                <label for="navbar_img0" class="thumb_none" >
                <input type="radio" name="navbar_img" id="navbar_img0" onChange="$('.del_img_box').show();" value="" <{if $navbar_img==""}>checked<{/if}>>
                <{$smarty.const._MA_TADTHEMES_NONE}><{$smarty.const._MA_TADTHEMES_NAVBAR_IMG}>
                </label>
            </div>

            <{if $all_navbar_img}>
                <{foreach from=$all_navbar_img item=navbarbg}>
                    <div class="thumb_div">
                        <label for="navbar_img<{$navbarbg.files_sn}>" class="thumb_label" style="background-image: url('<{$navbarbg.tb_path}>'), url('../images/t.gif');" >
                            <input type="radio" name="navbar_img" id="navbar_img<{$navbarbg.files_sn}>" onChange="$('.del_img_box').show(); $('#del_img<{$navbarbg.files_sn}>').hide();" value="<{$navbarbg.file_name}>" <{if $navbar_img==$navbarbg.file_name}>checked<{/if}>>
                        </label>
                        <label class="del_img_box" style="font-size: 0.678em;"  id="del_img<{$navbarbg.files_sn}>">
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
                <label class="col-sm-4 col-form-label text-sm-right control-label">
                    <{$smarty.const._MA_TAD_THEMES_UPLOAD}><{$smarty.const._MA_TADTHEMES_NAVLOGO_IMG}>
                </label>
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
            <div class="thumb_div">
                <label for="navlogo_img0" class="thumb_none" >
                <input type="radio" name="navlogo_img" id="navlogo_img0" value="" <{if $navlogo_img==""}>checked<{/if}>>
                <{$smarty.const._MA_TADTHEMES_NONE}><{$smarty.const._MA_TADTHEMES_NAVLOGO_IMG}>
                </label>
            </div>

            <{if $all_navlogo}>
                <{foreach from=$all_navlogo item=navlogo}>
                    <div class="thumb_div">
                        <label for="logo_img<{$navlogo.files_sn}>" class="thumb_label" style="background-image: url('<{$navlogo.tb_path}>'), url('../images/t.gif');" >
                        <input type="radio" name="navlogo_img" id="navlogo_img<{$navlogo.files_sn}>" value="<{$navlogo.file_name}>" <{if $navlogo_img==$navlogo.file_name}>checked<{/if}>>
                        </label>
                        <label class="del_navimg_box" style="font-size: 0.678em;"  id="del_navimg<{$navlogo.files_sn}>">
                        <input type="checkbox" value="<{$navlogo.files_sn}>" name="del_file[<{$navlogo.files_sn}>]"> <{$smarty.const._TAD_DEL}>
                        </label>
                    </div>
                <{/foreach}>
            <{/if}>

        </div>
    <{/if}>
</div>

<{if $config2_nav}>
    <div class="alert alert-warning">
        <h4>
            <{$smarty.const._MA_TADTHEMES_NAVBAR}><{$smarty.const._MA_TADTHEMES_CONFIG2}>
        </h4>
        <input type="hidden" name="config2[]" value="config2_nav">
    </div>
    <{foreach from=$config2_nav item=config}>
        <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_config_other.tpl"}>
    <{/foreach}>
<{/if}>