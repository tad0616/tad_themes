<div class="form-group row mb-3">
    <label class="col-sm-2 col-form-label text-sm-right control-label">
        <{$smarty.const._MA_TADTHEMES_SLIDE_ENABLE}>
    </label>
    <div class="col-sm-10">
        <div class="form-check-inline radio-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="radio" name="slide_width" value="1" <{if $slide_width!='0'}>checked<{/if}>>
                <{$smarty.const._YES}>
            </label>
        </div>
        <div class="form-check-inline radio-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="radio" name="slide_width" value="0" <{if $slide_width=='0'}>checked<{/if}>>
                <{$smarty.const._NO}>
            </label>
        </div>

        <div class="alert alert-success" style="margin-top:20px;">
            <{$smarty.const._MA_TADTHEMES_SLIDE_DESC}>
        </div>
    </div>
</div>

<div class="form-group row mb-3">
    <!-- 背景模式-->
    <label class="col-sm-2 col-form-label text-sm-right control-label">
        <{$smarty.const._MA_TAD_THEMES_UPLOAD}>
        <{$smarty.const._MA_TAD_THEMES_HEAD}>
    </label>
    <div class="col-sm-10">
        <{$upform_slide}>
    </div>
</div>


<{if $config2_slide|default:false}>
    <div class="alert alert-warning">
        <h4>
            <{$smarty.const._MA_TAD_THEMES_HEAD}><{$smarty.const._MA_TADTHEMES_CONFIG2}>
        </h4>
        <input type="hidden" name="config2[]" value="config2_slide">
    </div>
    <{foreach from=$config2_slide item=config}>
        <{include file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_config_other.tpl"}>
    <{/foreach}>
    <a href="<{$xoops_url}>/modules/tad_themes/admin/main.php?op=export_config2&theme_id=<{$theme_id}>&config2_file=config2_slide" class="btn btn-light btn-sm btn-xs text-secondary pull-right float-end mx-2">config2_slide.php</a>
<{/if}>