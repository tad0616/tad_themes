<div class="row">
    <div class="col-sm-5">
        <{if $enable.bg_img|default:false}>
            <div class="form-group row mb-3">
                <!-- 上傳 背景圖-->
                <label class="col-sm-4 col-form-label text-sm-right text-sm-end control-label">
                    <{$smarty.const._MA_TAD_THEMES_UPLOAD}>
                    <{$smarty.const._MA_TADTHEMES_BG_IMG}>
                </label>
                <div class="col-sm-8">
                    <{$upform_bg|default:''}>
                </div>
            </div>
        <{else}>
            <input type="hidden" name="bg_img" id="bg_img" value="<{$bg_img|default:''}>">
        <{/if}>


        <{if $enable.bg_color|default:false}>
            <div class="form-group row mb-3">
                <!-- 背景顏色-->
                <label class="col-sm-4 col-form-label text-sm-right text-sm-end control-label">
                    <{$smarty.const._MA_TADTHEMES_BG_COLOR}>
                </label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" name="bg_color" id="bg_color" value="<{$bg_color|default:''}>" class="form-control color-picker <{$validate.bg_color}>"  onChange="change_css();" data-hex="true">
                    </div>
                </div>
            </div>
        <{else}>
            <input type="hidden" name="bg_color" id="bg_color" value="<{$bg_color|default:''}>">
        <{/if}>

        <{if $enable.bg_repeat|default:false}>
        <div class="form-group row mb-3">
            <!-- 背景重複-->
            <label class="col-sm-4 col-form-label text-sm-right text-sm-end control-label">
                <{$smarty.const._MA_TADTHEMES_BG_REPEAT}>
            </label>
            <div class="col-sm-8">
            <select name="bg_repeat" id="bg_repeat" class="form-select <{$validate.bg_repeat}>" onChange="change_css();">
                <option value="repeat" <{if $bg_repeat=="repeat"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_REPEAT_NORMAL}></option>
                <option value="repeat-x" <{if $bg_repeat=="repeat-x"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_REPEAT_X}></option>
                <option value="repeat-y" <{if $bg_repeat=="repeat-y"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_REPEAT_Y}></option>
                <option value="no-repeat" <{if $bg_repeat=="no-repeat"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_NO_REPEAT}></option>
            </select>
            </div>
        </div>
        <{else}>
        <input type="hidden" name="bg_repeat" id="bg_repeat" value="<{$bg_repeat|default:''}>">
        <{/if}>

        <{if $enable.bg_size|default:false}>
        <div class="form-group row mb-3">
            <!-- 背景縮放-->
            <label class="col-sm-4 col-form-label text-sm-right text-sm-end control-label">
                <{$smarty.const._MA_TADTHEMES_BG_SIZE}>
            </label>
            <div class="col-sm-8">
            <select name="bg_size" id="bg_size" class="form-select <{$validate.bg_size}>" onChange="change_css();">
                <option value="auto" <{if $bg_size=="auto" or $bg_size==""}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_SIZE_NONE}></option>
                <option value="cover" <{if $bg_size=="cover"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_SIZE_COVER}></option>
                <option value="contain" <{if $bg_size=="contain"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_SIZE_CONTAIN}></option>
                <option value="100%" <{if $bg_size=="100%"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_SIZE_FULL}></option>
            </select>
            </div>
        </div>
        <{else}>
        <input type="hidden" name="bg_size" id="bg_size" value="<{$bg_size|default:''}>">
        <{/if}>


        <{if $enable.bg_attachment|default:false}>
        <div class="form-group row mb-3">
            <!-- 背景模式-->
            <label class="col-sm-4 col-form-label text-sm-right text-sm-end control-label">
                <{$smarty.const._MA_TADTHEMES_BG_ATTACHMENT}>
            </label>
            <div class="col-sm-8">
            <select name="bg_attachment" id="bg_attachment" class="form-select <{$validate.bg_attachment}>" onChange="change_css();">
                <option value="scroll" <{if $bg_attachment=="scroll"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_ATTACHMENT_SCROLL}></option>
                <option value="fixed" <{if $bg_attachment=="fixed"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_ATTACHMENT_FIXED}></option>
            </select>
            </div>
        </div>
        <{else}>
        <input type="hidden" name="bg_attachment" id="bg_attachment" value="<{$bg_attachment|default:''}>">
        <{/if}>


        <{if $enable.bg_position|default:false}>
        <div class="form-group row mb-3">
            <!-- 背景位置-->
            <label class="col-sm-4 col-form-label text-sm-right text-sm-end control-label">
                <{$smarty.const._MA_TADTHEMES_BG_POSITION}>
            </label>
            <div class="col-sm-8">
                <select name="bg_position" id="bg_position" class="form-select <{$validate.bg_position}>" onChange="change_css();">
                    <option value="left top" <{if $bg_position=="left top" or $bg_position==""}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_LT}></option>
                    <option value="left center" <{if $bg_position=="left center"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_LC}></option>
                    <option value="left bottom" <{if $bg_position=="left bottom"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_LB}></option>
                    <option value="right top" <{if $bg_position=="right top"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_RT}></option>
                    <option value="right center" <{if $bg_position=="right center"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_RC}></option>
                    <option value="right bottom" <{if $bg_position=="right bottom"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_RB}></option>
                    <option value="center top" <{if $bg_position=="center top"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_CT}></option>
                    <option value="center center" <{if $bg_position=="center center"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_CC}></option>
                    <option value="center bottom" <{if $bg_position=="center bottom"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_CB}></option>
                </select>
            </div>
        </div>
        <{else}>
        <input type="hidden" name="bg_position" id="bg_position" value="<{$bg_position|default:''}>">
        <{/if}>
    </div>

    <!--選擇預設 背景圖-->
    <div class="col-sm-7">
        <{if $all_bg and $enable.bg_img=="1"}>
        <div class="thumb_div">
            <label for="bg_img0" class="thumb_none" >
                <input type="radio" name="bg_img" id="bg_img0" onChange="$('.del_img_box').show(); preview_img('bg',$(this).val());" value="" <{if $bg_img==""}>checked<{/if}>>
                <{$smarty.const._MA_TADTHEMES_NONE}><{$smarty.const._MA_TADTHEMES_BG_IMG}>
            </label>
        </div>
        <{foreach from=$all_bg item=bg}>
            <div class="thumb_div">
            <label for="bg_img<{$bg.files_sn}>" class="thumb_label" style="background-image: url('<{$bg.tb_path}>'), url('../images/t.gif');" >
                <input type="radio" name="bg_img" id="bg_img<{$bg.files_sn}>" onChange="$('.del_img_box').show(); $('#del_img<{$bg.files_sn}>').hide(); preview_img('bg',$(this).val());" value="<{$bg.file_name}>" <{if $bg_img==$bg.file_name}>checked<{/if}>>
            </label>

            <label class="del_img_box" style="font-size:0.75em;" id="del_img<{$bg.files_sn}>">
                <input type="checkbox" value="<{$bg.files_sn}>" name="del_file[<{$bg.files_sn}>]"> <{$smarty.const._TAD_DEL}>
            </label>
            </div>
        <{/foreach}>
        <{/if}>
    </div>
</div>

<{if $config2_bg|default:false}>
    <div class="alert alert-warning">
        <h4>
            <{$smarty.const._MA_TADTHEMES_BG_IMG}><{$smarty.const._MA_TADTHEMES_CONFIG2}>
        </h4>
        <input type="hidden" name="config2[]" value="config2_bg">
    </div>
    <{foreach from=$config2_bg item=config}>
        <{include file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_config_other.tpl"}>
    <{/foreach}>
    <a href="<{$xoops_url}>/modules/tad_themes/admin/main.php?op=export_config2&theme_id=<{$theme_id|default:''}>&config2_file=config2_bg" class="btn btn-light btn-sm btn-xs text-secondary pull-right float-end mx-2">config2_bg.php</a>
<{/if}>