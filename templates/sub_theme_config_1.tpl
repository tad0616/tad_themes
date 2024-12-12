<!--佈景類型-->
<div class="form-group row mb-3">
    <!--版面類型-->
    <{if $enable.theme_type|default:false}>
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label">
            <{$smarty.const._MA_TADTHEMES_THEME_TYPE}>
        </label>
        <div class="col-sm-2">
            <select name="theme_type" id="theme_type" class="form-control form-select <{$validate.theme_type}>" onChange="change_css();">
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
        <input type="hidden" name="theme_type" id="theme_type" value="<{$theme_type|default:''}>">
    <{/if}>

    <!--版面寬度-->
    <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label">
        <{$smarty.const._MA_TADTHEMES_THEME_WIDTH}>
    </label>
    <div class="col-sm-2">
        <{if $enable.theme_width|default:false}>
            <div class="input-group">
                <input type="text" name="theme_width" class="form-control <{$validate.theme_width}>" value="<{$theme_width|default:''}>" id="theme_width">
                <div class="input-group-append input-group-addon">
                    <span class="input-group-text"><{if $theme_kind=="mix"}>px<{else}><{$theme_unit|default:''}><{/if}></span>
                </div>
            </div>
        <{else}>
            <input type="hidden" name="theme_width" id="theme_width" value="<{$theme_width|default:''}>">
            <input type="text" readonly class="form-control-plaintext" value="<{$theme_width|default:''}><{$theme_unit|default:''}>">
        <{/if}>
    </div>

    <!--內容區顏色-->
    <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label">
        <{$smarty.const._MA_TADTHEMES_BASE_COLOR}>
    </label>
    <div class="col-sm-2">
        <{if $enable.base_color|default:false}>
            <div class="input-group">
                <input type="text" name="base_color" id="base_color" value="<{$base_color|default:''}>" class="form-control color-picker <{$validate.base_color}>"  onChange="change_css();" data-hex="true">
            </div>
        <{else}>
            <input type="hidden" name="base_color" id="base_color" value="<{$base_color|default:''}>">
        <{/if}>
    </div>
</div>


<div class="form-group row mb-3">
    <!--左區塊顏色-->
    <{if $enable.lb_color|default:false}>
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label">
            <{$smarty.const._MA_TADTHEMES_LB_COLOR}>
        </label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" name="lb_color" id="lb_color" value="<{$lb_color|default:''}>" class="form-control color-picker <{$validate.lb_color}>"  onChange="change_css();" data-hex="true">
            </div>
        </div>
    <{else}>
        <input type="hidden" name="lb_color" id="lb_color" value="<{$lb_color|default:''}>">
    <{/if}>

    <!--中區塊顏色-->
    <{if $enable.cb_color|default:false}>
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label">
            <{$smarty.const._MA_TADTHEMES_CB_COLOR}>
        </label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" name="cb_color" id="cb_color" value="<{$cb_color|default:''}>" class="form-control color-picker <{$validate.cb_color}>"  onChange="change_css();" data-hex="true">
            </div>
        </div>
    <{else}>
        <input type="hidden" name="cb_color" id="cb_color" value="<{$cb_color|default:''}>">
    <{/if}>

    <!--右區塊顏色-->
    <{if $enable.rb_color|default:false}>
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label"><{$smarty.const._MA_TADTHEMES_RB_COLOR}></label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" name="rb_color" id="rb_color" value="<{$rb_color|default:''}>" class="form-control color-picker <{$validate.rb_color}>"  onChange="change_css();" data-hex="true">
            </div>
        </div>
    <{else}>
        <input type="hidden" name="rb_color" id="rb_color" value="<{$rb_color|default:''}>">
    <{/if}>
</div>

<div class="form-group row mb-3">
    <!--左區塊寬度-->
    <{if $enable.lb_width|default:false}>
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label"><{$smarty.const._MA_TADTHEMES_LB_WIDTH}></label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" name="lb_width" class="form-control <{$validate.lb_width}>" value="<{$lb_width|default:''}>" id="lb_width" onChange="change_css();">
                <div class="input-group-append input-group-addon">
                    <span class="input-group-text"><{$theme_unit|default:''}></span>
                </div>
            </div>
        </div>
    <{else}>
        <input type="hidden" name="lb_width" id="lb_width" value="<{$lb_width|default:''}>">
    <{/if}>

    <!--中區塊寬度-->
    <{if $enable.cb_width|default:false}>
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label"><{$smarty.const._MA_TADTHEMES_CB_WIDTH}></label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" name="cb_width" class="form-control <{$validate.cb_width}>" value="<{$cb_width|default:''}>" id="cb_width" onChange="change_css();">
                <div class="input-group-append input-group-addon">
                    <span class="input-group-text"><{$theme_unit|default:''}></span>
                </div>
            </div>
        </div>
    <{else}>
        <input type="hidden" name="cb_width" id="cb_width" value="<{$cb_width|default:''}>">
    <{/if}>

    <!--右區塊寬度-->
    <{if $enable.rb_width|default:false}>
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label"><{$smarty.const._MA_TADTHEMES_RB_WIDTH}></label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" name="rb_width" class="form-control <{$validate.rb_width}>" value="<{$rb_width|default:''}>" id="rb_width" onChange="change_css();">
                <div class="input-group-append input-group-addon">
                    <span class="input-group-text"><{$theme_unit|default:''}></span>
                </div>
            </div>
        </div>
    <{else}>
        <input type="hidden" name="rb_width" id="rb_width" value="<{$rb_width|default:''}>">
    <{/if}>
</div>

<div class="form-group row mb-3">
    <!--文字大小-->
    <{if $enable.font_size|default:false}>
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label">
            <{$smarty.const._MA_TADTHEMES_FONT_SIZE}>
        </label>
        <div class="col-sm-2">
            <input type="text" name="font_size" class="form-control <{$validate.font_size}>" value="<{$font_size|default:''}>" id="font_size">
        </div>
    <{else}>
        <input type="hidden" name="font_size" id="font_size" value="<{$font_size|default:''}>">
    <{/if}>

    <!--離上邊界距離-->
    <{if $enable.margin_top|default:false}>
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label">
            <{$smarty.const._MA_TADTHEMES_MARGIN_TOP}>
        </label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" name="margin_top" class="form-control <{$validate.margin_top}>" value="<{$margin_top|default:''}>" id="margin_top"  onChange="change_css();">
                <div class="input-group-append input-group-addon">
                    <span class="input-group-text">px</span>
                </div>
            </div>
        </div>
    <{else}>
        <input type="hidden" name="margin_top" id="margin_top" value="<{$margin_top|default:''}>">
    <{/if}>

    <!--離下邊界距離-->
    <{if $enable.margin_bottom|default:false}>
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label">
            <{$smarty.const._MA_TADTHEMES_MARGIN_BOTTOM}>
        </label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" name="margin_bottom" class="form-control <{$validate.margin_bottom}>" value="<{$margin_bottom|default:''}>" id="margin_bottom"  onChange="change_css();">
                <div class="input-group-append input-group-addon">
                    <span class="input-group-text">px</span>
                </div>
            </div>
        </div>
    <{else}>
        <input type="hidden" name="margin_bottom" id="margin_bottom" value="<{$margin_bottom|default:''}>">
    <{/if}>
</div>

<div class="form-group row mb-3">
    <!--文字顏色-->
    <{if $enable.font_color|default:false}>
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label">
            <{$smarty.const._MA_TADTHEMES_FONT_COLOR}>
        </label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" name="font_color" id="font_color" value="<{$font_color|default:''}>" class="form-control color-picker <{$validate.font_color}>"  onChange="change_css();" data-hex="true">
            </div>
        </div>
    <{else}>
        <input type="hidden" name="font_color" id="font_color" value="<{$font_color|default:''}>">
    <{/if}>

    <!--連結顏色-->
    <{if $enable.link_color|default:false}>
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label">
            <{$smarty.const._MA_TADTHEMES_LINK_COLOR}>
        </label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" name="link_color" id="link_color" value="<{$link_color|default:''}>" class="form-control color-picker <{$validate.link_color}>"  onChange="change_css();" data-hex="true">
            </div>
        </div>
    <{else}>
        <input type="hidden" name="link_color" id="link_color" value="<{$link_color|default:''}>">
    <{/if}>

    <!--滑鼠移到連結顏色-->
    <{if $enable.hover_color|default:false}>
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label">
            <{$smarty.const._MA_TADTHEMES_HOVER_COLOR}>
        </label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" name="hover_color" id="hover_color" value="<{$hover_color|default:''}>" class="form-control color-picker <{$validate.hover_color}>"  onChange="change_css();" data-hex="true">
            </div>
        </div>
    <{else}>
        <input type="hidden" name="hover_color" id="hover_color" value="<{$hover_color|default:''}>">
    <{/if}>
</div>

<{if $config2_base|default:false}>
    <div class="alert alert-warning">
        <h4>
            <{$smarty.const._MA_TADTHEMES_THEME_BASE}><{$smarty.const._MA_TADTHEMES_CONFIG2}>
        </h4>
        <input type="hidden" name="config2[]" value="config2_base">
    </div>
    <{foreach from=$config2_base item=config}>
        <{include file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_config_other.tpl"}>
    <{/foreach}>
    <a href="<{$xoops_url}>/modules/tad_themes/admin/main.php?op=export_config2&theme_id=<{$theme_id|default:''}>&config2_file=config2_base" class="btn btn-light btn-sm btn-xs text-secondary pull-right float-end mx-2">config2_base.php</a>
<{/if}>
