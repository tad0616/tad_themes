<!--區塊標題列背景圖-->
<p>
    <div id="bt_tabs">
        <ul class="resp-tabs-list tab_identifier_child">
            <{foreach from=$blocks_values item=block}>
                <li><{$block.title}></li>
            <{/foreach}>
        </ul>

        <div class="resp-tabs-container tab_identifier_child">
            <{foreach from=$blocks_values item=block}>
                <div>
                    <span style="font-size:1.5em;margin:0px 0px 10px;font-weight:bold;">
                        <{$block.title}>
                    </span>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="apply_to_all" value="<{$block.block_position}>">
                        <{$smarty.const._MA_TADTHEMES_BLOCK_ALL_POSITION}>
                    </label>

                    <div class="form-group row">
                        <!-- 區塊標題文字大小-->
                        <{if $enable.bt_text_size=="1"}>
                            <label class="col-sm-2 col-form-label text-sm-right control-label">
                                <{$smarty.const._MA_TADTHEMES_BLOCK_TITLE_SIZE}>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" name="bt_text_size[<{$block.block_position}>]" class="form-control <{$validate.bt_text_size}>" value="<{$block.bt_text_size}>" id="bt_text_size_<{$block.block_position}>">
                            </div>
                        <{else}>
                            <input type="hidden" name="bt_text_size" id="bt_text_size" value="<{$bt_text_size}>">
                        <{/if}>

                        <!-- 區塊標題文字縮排-->
                        <{if $enable.bt_text_padding=="1"}>
                            <label class="col-sm-2 col-form-label text-sm-right control-label">
                                <{$smarty.const._MA_TADTHEMES_BLOCK_TITLE_PADDING}>
                            </label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" name="bt_text_padding[<{$block.block_position}>]" class="form-control <{$validate.bt_text_padding}>" value="<{$block.bt_text_padding}>" id="bt_text_padding_<{$block.block_position}>">
                                    <div class="input-group-append input-group-addon">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                            </div>
                        <{else}>
                            <input type="hidden" name="bt_text_padding" id="bt_text_padding" value="<{$bt_text_padding}>">
                        <{/if}>
                    </div>

                    <div class="form-group row">
                        <!-- 區塊標題列文字顏色-->
                        <{if $enable.bt_text=="1"}>
                            <label class="col-sm-2 col-form-label text-sm-right control-label">
                                <{$smarty.const._MA_TADTHEMES_FONT_COLOR}>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" name="bt_text[<{$block.block_position}>]" id="bt_text_<{$block.block_position}>" value="<{$block.bt_text}>" class="form-control color-picker <{$validate.bt_text}>"  data-hex="true">
                            </div>
                        <{else}>
                            <input type="hidden" name="bt_text" id="bt_text" value="<{$bt_text}>">
                        <{/if}>

                        <!-- 區塊標題列背景顏色-->
                        <{if $enable.bt_bg_color=="1"}>
                            <label class="col-sm-2 col-form-label text-sm-right control-label">
                                <{$smarty.const._MA_TADTHEMES_BG_COLOR}>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" name="bt_bg_color[<{$block.block_position}>]" id="bt_bg_color_<{$block.block_position}>" value="<{$block.bt_bg_color}>" class="form-control color-picker <{$validate.bt_bg_color}>" data-hex="true">
                            </div>
                        <{else}>
                            <input type="hidden" name="bt_bg_color" id="bt_bg_color" value="<{$bt_bg_color}>">
                        <{/if}>
                    </div>

                    <div class="form-group row">
                        <!-- 區塊標題圓角設定-->
                        <{if $enable.bt_radius=="1"}>
                            <label class="col-sm-2 col-form-label text-sm-right control-label">
                                <{$smarty.const._MA_TADTHEMES_BLOCK_TITLE_RADIUS}>
                            </label>

                            <div class="col-sm-4">
                                <select name="bt_radius[<{$block.block_position}>]" id="bt_radius_<{$block.block_position}>" class="form-control <{$validate.bt_radius}>">
                                    <option value="1" <{if $block.bt_radius=="1"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BLOCK_TITLE_RADIUS_Y}></option>
                                    <option value="0" <{if $block.bt_radius=="0"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BLOCK_TITLE_RADIUS_N}></option>
                                </select>
                            </div>
                        <{else}>
                            <input type="hidden" name="bt_radius" id="bt_radius" value="<{$bt_radius}>">
                        <{/if}>

                        <!-- 區塊標題工具按鈕-->
                        <{if $enable.block_config=="1"}>
                            <label class="col-sm-2 col-form-label text-sm-right control-label">
                                <{$smarty.const._MA_TADTHEMES_BLOCK_TITLE_BUTTOM}>
                            </label>

                            <div class="col-sm-4">
                                <select name="block_config[<{$block.block_position}>]" id="block_config_<{$block.block_position}>" class="form-control <{$validate.block_config}>">
                                    <option value="right" <{if $block.block_config=="right"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_RT}></option>
                                    <option value="left" <{if $block.block_config=="left"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_BG_POSITION_LT}></option>
                                </select>
                            </div>
                        <{else}>
                            <input type="hidden" name="block_config" id="block_config" value="<{$block_config}>">
                        <{/if}>
                    </div>

                    <div class="form-group row">
                        <!-- 上傳區塊標題列背景圖-->
                        <{if $enable.bt_bg_img=="1"}>
                            <label class="col-sm-2 col-form-label text-sm-right control-label">
                                <{$smarty.const._MA_TAD_THEMES_UPLOAD}>
                                <{$smarty.const._MA_TADTHEMES_BG_IMG}>
                            </label>
                            <div class="col-sm-4">
                                <{$block.upform_bt_bg}>
                            </div>
                        <{else}>
                            <input type="hidden" name="bt_bg_img" id="bt_bg_img" value="<{$bt_bg_img}>">
                        <{/if}>

                        <!-- 區塊標題列背景重複-->
                        <{if $enable.bt_bg_repeat=="1"}>
                            <label class="col-sm-2 col-form-label text-sm-right control-label">
                                <{$smarty.const._MA_TADTHEMES_BG_REPEAT}>
                            </label>
                            <div class="col-sm-4">
                                <select name="bt_bg_repeat[<{$block.block_position}>]" id="bt_bg_repeat_<{$block.block_position}>" class="form-control <{$validate.bt_bg_repeat}>">
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
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <div class="thumb_div">
                                    <label for="bt_bg_img0_<{$block.block_position}>" class="thumb_none" >
                                    <input type="radio" name="bt_bg_img[<{$block.block_position}>]" id="bt_bg_img0_<{$block.block_position}>" onChange="$('.del_img_box_<{$block.block_position}>').show();" value="" <{if $block.bt_bg_img==""}>checked<{/if}>>
                                    <{$smarty.const._MA_TADTHEMES_NONE}>
                                    </label>
                                </div>
                                <{foreach from=$block.all_bt_bg item=bt_bg}>
                                    <div class="thumb_div">
                                    <label for="bt_bg_img<{$bt_bg.files_sn}>_<{$block.block_position}>" class="thumb_label" style="background-image: url('<{$bt_bg.tb_path}>'), url('../images/t.gif');" >
                                        <input type="radio" name="bt_bg_img[<{$block.block_position}>]" id="bt_bg_img<{$bt_bg.files_sn}>_<{$block.block_position}>" onChange="$('.del_img_box_<{$block.block_position}>').show(); $('#del_img<{$bt_bg.files_sn}>_<{$block.block_position}>').hide(); " value="<{$bt_bg.file_name}>" <{if $block.bt_bg_img==$bt_bg.file_name}>checked<{/if}>>
                                    </label>
                                    <label class="del_img_box" style="font-size: 0.678em;"  id="del_img<{$bt_bg.files_sn}>_<{$block.block_position}>">
                                        <input type="checkbox" value="<{$bt_bg.files_sn}>" name="del_file[<{$bt_bg.files_sn}>]"> <{$smarty.const._TAD_DEL}>
                                    </label>
                                    </div>
                                <{/foreach}>
                            </div>
                        </div>
                    <{/if}>

                    <div class="form-group row">
                        <!-- 區塊整體樣式-->
                        <{if $enable.block_style=="1"}>
                            <div class="col-sm-12">
                                <{$smarty.const._MA_TADTHEMES_BLOCK_STYLE}>
                                <span style="font-size: 0.75em;color:#0000DC;white-space:nowrap; ">.<{$block.block_position}> {<span style="color:#DE1212;"><{$smarty.const._MA_TADTHEMES_YOUR_STYLE}></span>}</span>
                                <textarea name="block_style[<{$block.block_position}>]" id="block_style_<{$block.block_position}>" class="form-control <{$validate.block_style}>" style="font-size: 0.678em;height:100px;"><{$block.block_style}></textarea>
                            </div>
                        <{else}>
                            <input type="hidden" name="block_style" id="block_style" value="<{$block_style}>">
                        <{/if}>
                    </div>

                    <div class="form-group row">
                        <!-- 區塊標題樣式-->
                        <{if $enable.block_title_style=="1"}>
                            <div class="col-sm-12">
                                <{$smarty.const._MA_TADTHEMES_BLOCK_TITLE_STYLE}>
                                <span style="font-size: 0.75em;color:#0000DC;white-space:nowrap; ">.<{$block.block_position}> .blockTitle {<span style="color:#DE1212;"><{$smarty.const._MA_TADTHEMES_YOUR_STYLE}></span>}</span>
                                <textarea name="block_title_style[<{$block.block_position}>]" id="block_title_style_<{$block.block_position}>" class="form-control <{$validate.block_title_style}>" style="font-size: 0.678em;height:100px;"><{$block.block_title_style}></textarea>
                            </div>
                        <{else}>
                            <input type="hidden" name="block_title_style" id="block_title_style" value="<{$block_title_style}>">
                        <{/if}>
                    </div>

                    <div class="form-group row">
                        <!-- 區塊內容樣式-->
                        <{if $enable.block_content_style=="1"}>
                            <div class="col-sm-12">
                                <{$smarty.const._MA_TADTHEMES_BLOCK_CONTENT_STYLE}>
                                <span style="font-size: 0.75em;color:#0000DC;white-space:nowrap; ">.<{$block.block_position}> .blockContent {<span style="color:#DE1212;"><{$smarty.const._MA_TADTHEMES_YOUR_STYLE}></span>}</span>
                                <textarea name="block_content_style[<{$block.block_position}>]" id="block_content_style_<{$block.block_position}>" class="form-control <{$validate.block_content_style}>" style="font-size: 0.678em;height:100px;"><{$block.block_content_style}></textarea>
                            </div>
                        <{else}>
                            <input type="hidden" name="block_content_style" id="block_content_style" value="<{$block_content_style}>">
                        <{/if}>
                    </div>


                </div>
            <{/foreach}>
        </div>
    </div>
</p>
<div style="clear:both;"></div>

<{if $config2_block}>
    <div class="alert alert-warning">
        <h4>
            <{$smarty.const._MA_TADTHEMES_BLOCK_TITLE}><{$smarty.const._MA_TADTHEMES_CONFIG2}>
        </h4>
        <input type="hidden" name="config2[]" value="config2_block">
    </div>
    <{foreach from=$config2_block item=config}>
        <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_config_other.tpl"}>
    <{/foreach}>
<{/if}>