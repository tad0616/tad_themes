<div class="row">
    <{if $enable.slide_width=="1" or $enable.slide_height=="1"}>
        <div class="col-sm-5">

            <!--滑動圖片寬度-->
            <{if $enable.slide_width=="1"}>
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <{$smarty.const._MA_TADTHEMES_SLIDE_WIDTH}>
                    </label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" name="slide_width" class="form-control <{$validate.slide_width}>" value="<{$slide_width}>" id="slide_width" onChange="change_css();">
                            <span class="input-group-addon"><{if $theme_kind=="mix"}>px<{else}><{$theme_unit}><{/if}></span>   
                        </div>                     
                    </div>
                </div>
            <{else}>
                <input type="hidden" name="slide_width" id="slide_width" value="<{$slide_width}>">
            <{/if}>

            <!--滑動圖片高度-->
            <{if $enable.slide_height=="1"}>
                <div class="form-group">
                    <label class="col-sm-4 control-label">
                        <{$smarty.const._MA_TADTHEMES_SLIDE_HEIGHT}>
                    </label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" name="slide_height" class="form-control <{$validate.slide_height}>" value="<{$slide_height}>" id="slide_height" onChange="change_css();">
                            <span class="input-group-addon">px</span>
                        </div>
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
            <div class="alert alert-success">
                <{$smarty.const._MA_TADTHEMES_SLIDE_DESC}>
            </div>
        </div>
    <{/if}>
</div>

<{if $enable.slide_width=="1" or $enable.slide_height=="1" or $enable.use_slide=="1"}>
    <div class="form-group">
        <!-- 背景模式-->
        <label class="col-sm-2 control-label">
            <{$smarty.const._MA_TAD_THEMES_UPLOAD}>
            <{$smarty.const._MA_TAD_THEMES_HEAD}>
        </label>
        <div class="col-sm-10">
            <{$upform_slide}>
        </div>
    </div>
<{/if}>