<!--佈景類型-->

<div class="form-group row">
    <!--版面類型-->
    <{if $enable.theme_type}>
        <label class="col-sm-2 col-form-label text-sm-right control-label">
            <{$smarty.const._MA_TADTHEMES_THEME_TYPE}>
        </label>
        <div class="col-sm-2">
            <select name="theme_type" id="theme_type" class="form-control <{$validate.theme_type}>" onChange="change_css();">
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
    <label class="col-sm-2 col-form-label text-sm-right control-label">
        <{$smarty.const._MA_TADTHEMES_THEME_WIDTH}>
    </label>
    <div class="col-sm-2">
        <{if $enable.theme_width}>
            <div class="input-group">
                <input type="text" name="theme_width" class="form-control <{$validate.theme_width}>" value="<{$theme_width}>" id="theme_width">
                <div class="input-group-append input-group-addon">
                    <span class="input-group-text"><{if $theme_kind=="mix"}>px<{else}><{$theme_unit}><{/if}></span>
                </div>
            </div>
        <{else}>
            <input type="hidden" name="theme_width" id="theme_width" value="<{$theme_width}>">
            <input type="text" readonly class="form-control-plaintext" value="<{$theme_width}><{$theme_unit}>">
        <{/if}>
    </div>

    <!--內容區顏色-->
    <label class="col-sm-2 col-form-label text-sm-right control-label">
        <{$smarty.const._MA_TADTHEMES_BASE_COLOR}>
    </label>
    <div class="col-sm-2">
        <{if $enable.base_color}>
            <input type="text" name="base_color" class="form-control color-picker <{$validate.base_color}>" value="<{$base_color}>" id="base_color" data-hex="true" onChange="change_css();">
        <{else}>
            <input type="hidden" name="base_color" id="base_color" value="<{$base_color}>">
        <{/if}>
    </div>
</div>


<div class="form-group row">
    <!--左區塊顏色-->
    <{if $enable.lb_color}>
        <label class="col-sm-2 col-form-label text-sm-right control-label">
            <{$smarty.const._MA_TADTHEMES_LB_COLOR}>
        </label>
        <div class="col-sm-2">
            <input type="text" name="lb_color" id="lb_color" value="<{$lb_color}>" class="form-control color-picker <{$validate.lb_color}>"  data-hex="true" onChange="change_css();">
        </div>
    <{else}>
        <input type="hidden" name="lb_color" id="lb_color" value="<{$lb_color}>">
    <{/if}>

    <!--中區塊顏色-->
    <{if $enable.cb_color}>
        <label class="col-sm-2 col-form-label text-sm-right control-label">
            <{$smarty.const._MA_TADTHEMES_CB_COLOR}>
        </label>
        <div class="col-sm-2">
            <input type="text" name="cb_color" id="cb_color" value="<{$cb_color}>" class="form-control color-picker <{$validate.cb_color}>"  data-hex="true" onChange="change_css();">
        </div>
    <{else}>
        <input type="hidden" name="cb_color" id="cb_color" value="<{$cb_color}>">
    <{/if}>

    <!--右區塊顏色-->
    <{if $enable.rb_color}>
        <label class="col-sm-2 col-form-label text-sm-right control-label"><{$smarty.const._MA_TADTHEMES_RB_COLOR}></label>
        <div class="col-sm-2">
            <input type="text" name="rb_color" id="rb_color" value="<{$rb_color}>" class="form-control color-picker <{$validate.rb_color}>" data-hex="true" onChange="change_css();">
        </div>
    <{else}>
        <input type="hidden" name="rb_color" id="rb_color" value="<{$rb_color}>">
    <{/if}>
</div>

<div class="form-group row">
    <!--左區塊寬度-->
    <{if $enable.lb_width}>
        <label class="col-sm-2 col-form-label text-sm-right control-label"><{$smarty.const._MA_TADTHEMES_LB_WIDTH}></label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" name="lb_width" class="form-control <{$validate.lb_width}>" value="<{$lb_width}>" id="lb_width" onChange="change_css();">
                <div class="input-group-append input-group-addon">
                    <span class="input-group-text"><{$theme_unit}></span>
                </div>
            </div>
        </div>
    <{else}>
        <input type="hidden" name="lb_width" id="lb_width" value="<{$lb_width}>">
    <{/if}>

    <!--中區塊寬度-->
    <{if $enable.cb_width}>
        <label class="col-sm-2 col-form-label text-sm-right control-label"><{$smarty.const._MA_TADTHEMES_CB_WIDTH}></label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" name="cb_width" class="form-control <{$validate.cb_width}>" value="<{$cb_width}>" id="cb_width" onChange="change_css();">
                <div class="input-group-append input-group-addon">
                    <span class="input-group-text"><{$theme_unit}></span>
                </div>
            </div>
        </div>
    <{else}>
        <input type="hidden" name="cb_width" id="cb_width" value="<{$cb_width}>">
    <{/if}>

    <!--右區塊寬度-->
    <{if $enable.rb_width}>
        <label class="col-sm-2 col-form-label text-sm-right control-label"><{$smarty.const._MA_TADTHEMES_RB_WIDTH}></label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" name="rb_width" class="form-control <{$validate.rb_width}>" value="<{$rb_width}>" id="rb_width" onChange="change_css();">
                <div class="input-group-append input-group-addon">
                    <span class="input-group-text"><{$theme_unit}></span>
                </div>
            </div>
        </div>
    <{else}>
        <input type="hidden" name="rb_width" id="rb_width" value="<{$rb_width}>">
    <{/if}>
</div>

<div class="form-group row">
    <!--文字大小-->
    <{if $enable.font_size}>
        <label class="col-sm-2 col-form-label text-sm-right control-label">
            <{$smarty.const._MA_TADTHEMES_FONT_SIZE}>
        </label>
        <div class="col-sm-2">
            <input type="text" name="font_size" class="form-control <{$validate.font_size}>" value="<{$font_size}>" id="font_size">
        </div>
    <{else}>
        <input type="hidden" name="font_size" id="font_size" value="<{$font_size}>">
    <{/if}>

    <!--離上邊界距離-->
    <{if $enable.margin_top}>
        <label class="col-sm-2 col-form-label text-sm-right control-label">
            <{$smarty.const._MA_TADTHEMES_MARGIN_TOP}>
        </label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" name="margin_top" class="form-control <{$validate.margin_top}>" value="<{$margin_top}>" id="margin_top"  onChange="change_css();">
                <div class="input-group-append input-group-addon">
                    <span class="input-group-text">px</span>
                </div>
            </div>
        </div>
    <{else}>
        <input type="hidden" name="margin_top" id="margin_top" value="<{$margin_top}>">
    <{/if}>

    <!--離下邊界距離-->
    <{if $enable.margin_bottom}>
        <label class="col-sm-2 col-form-label text-sm-right control-label">
            <{$smarty.const._MA_TADTHEMES_MARGIN_BOTTOM}>
        </label>
        <div class="col-sm-2">
            <div class="input-group">
                <input type="text" name="margin_bottom" class="form-control <{$validate.margin_bottom}>" value="<{$margin_bottom}>" id="margin_bottom"  onChange="change_css();">
                <div class="input-group-append input-group-addon">
                    <span class="input-group-text">px</span>
                </div>
            </div>
        </div>
    <{else}>
        <input type="hidden" name="margin_bottom" id="margin_bottom" value="<{$margin_bottom}>">
    <{/if}>
</div>

<div class="form-group row">
    <!--文字顏色-->
    <{if $enable.font_color}>
        <label class="col-sm-2 col-form-label text-sm-right control-label">
            <{$smarty.const._MA_TADTHEMES_FONT_COLOR}>
        </label>
        <div class="col-sm-2">
            <input type="text" name="font_color" id="font_color" value="<{$font_color}>" class="form-control color-picker <{$validate.font_color}>" data-hex="true" onChange="change_css();">
        </div>
    <{else}>
        <input type="hidden" name="font_color" id="font_color" value="<{$font_color}>">
    <{/if}>

    <!--連結顏色-->
    <{if $enable.link_color}>
        <label class="col-sm-2 col-form-label text-sm-right control-label">
            <{$smarty.const._MA_TADTHEMES_LINK_COLOR}>
        </label>
        <div class="col-sm-2">
            <input type="text" name="link_color" id="link_color" value="<{$link_color}>" class="form-control color-picker <{$validate.link_color}>" data-hex="true" onChange="change_css();">
        </div>
    <{else}>
        <input type="hidden" name="link_color" id="link_color" value="<{$link_color}>">
    <{/if}>

    <!--滑鼠移到連結顏色-->
    <{if $enable.hover_color}>
        <label class="col-sm-2 col-form-label text-sm-right control-label">
            <{$smarty.const._MA_TADTHEMES_HOVER_COLOR}>
        </label>
        <div class="col-sm-2">
            <input type="text" name="hover_color" id="hover_color" value="<{$hover_color}>" class="form-control color-picker<{$validate.hover_color}>" data-hex="true" onChange="change_css();">
        </div>
    <{else}>
        <input type="hidden" name="hover_color" id="hover_color" value="<{$hover_color}>">
    <{/if}>
</div>

<{if $config2_base}>
    <div class="alert alert-warning">
        <h4>
            <{$smarty.const._MA_TADTHEMES_THEME_BASE}><{$smarty.const._MA_TADTHEMES_CONFIG2}>
        </h4>
        <input type="hidden" name="config2[]" value="config2_base">
    </div>
    <{foreach from=$config2_base item=config}>
        <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_config_other.tpl"}>
    <{/foreach}>
<{/if}>
