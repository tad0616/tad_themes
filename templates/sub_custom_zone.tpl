<h3><{$config.text}></h3>
<{assign var="conf_name" value=$config.name}>
<div class="alert alert-warning">
    <div class="row">
        <div class="col-sm-2">
            <{* Google 翻譯 *}>
            <div class="input-group d-inline-block">
                <div class="input-group-append input-group-addon">
                    <span class="input-group-text">
                        <input id="<{$conf_name|default:''}>_google_translate" class="form-check-input me-2 mr-2" type="checkbox" name="<{$conf_name|default:''}>[]" value="google_translate" <{if $config.value|is_array && 'google_translate'|in_array:$config.value}>checked<{/if}>>
                        <label for="<{$conf_name|default:''}>_google_translate">
                        <{$smarty.const.TF_GOOGLE_TRANSLATE}>
                        </label>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <{* 搜尋 *}>
            <div class="input-group d-inline-block">
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text">
                        <input id="<{$conf_name|default:''}>_search" class="form-check-input me-2 mr-2" type="checkbox" name="<{$conf_name|default:''}>[]" value="search" <{if $config.value|is_array && "search"|in_array:$config.value}>checked<{/if}>>
                        <label for="<{$conf_name|default:''}>_search">
                        <{$smarty.const.TF_SEARCH}>
                        </label>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <{* 登入框 *}>
            <div class="input-group d-inline-block">
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text">
                        <input id="<{$conf_name|default:''}>_login" class="form-check-input me-2 mr-2" type="checkbox" name="<{$conf_name|default:''}>[]" value="login" <{if $config.value|is_array && "login"|in_array:$config.value}>checked<{/if}>>
                        <label for="<{$conf_name|default:''}>_login">
                        <{$smarty.const.TF_LOGIN}>
                        </label>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <{* 導覽列 *}>
            <div class="input-group d-inline">
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text">
                        <input id="<{$conf_name|default:''}>_navbar" class="form-check-input me-2 mr-2" type="checkbox" name="<{$conf_name|default:''}>[]" value="navbar" <{if $config.value|is_array && "navbar"|in_array:$config.value}>checked<{/if}>>
                        <label for="<{$conf_name|default:''}>_navbar">
                        <{$smarty.const.TF_NAVBAR}>
                        </label>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <{* 置入區塊：*}>
            <{*
            <{foreach from=$config key=k item=v name=config.block}>
                <{$k|default:''}>:<{$v|default:''}><br>
            <{/foreach}>
            *}>
            <div class="input-group">
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text">
                        <input id="<{$conf_name|default:''}>_block" class="form-check-input me-2 mr-2" type="checkbox" name="<{$conf_name|default:''}>[]" value="block" <{if $config.value|is_array && "block"|in_array:$config.value}>checked<{/if}>>
                        <label for="<{$conf_name|default:''}>_block">
                        <{$smarty.const.TF_BLOCK}>
                        </label>
                    </span>
                </div>
                <select name="<{$conf_name|default:''}>_bid" class="form-control">
                    <option value="" <{if $bid|default:'' == ""}>selected<{/if}>></option>
                    <{foreach from=$blocks key=mod_name item=mod_blocks}>
                        <optgroup label="<{$mod_name|default:''}>">
                            <{foreach from=$mod_blocks key=bid item=block}>
                                <option value="<{$bid|default:''}>" <{if $bid|default:'' == $config.bid}>selected<{/if}>>
                                    <{if $block.name|strpos:$smarty.const._MA_TADTHEMES_BLOCKS_CUSTOM !== false}>
                                        <{$block.title}><{$block.name|replace:$smarty.const._MA_TADTHEMES_BLOCKS_CUSTOM:''}>
                                    <{elseif $block.title|strpos:$block.name !== false}>
                                        <{$block.name}>
                                    <{else}>
                                        <{$block.name}> (<{$block.title}>)
                                    <{/if}>
                                </option>
                            <{/foreach}>
                        </optgroup>
                    <{/foreach}>
                </select>
                <div class="input-group-append input-group-btn">
                    <{if $config.bid|default:false}>
                        <{if $adv_bids|is_array && $config.bid|in_array:$adv_bids}>
                            <a href="<{$xoops|default:''}>/modules/tad_blocks/index.php?op=block_form&bid=<{$config.bid}>" target="_blank" class="btn btn-primary"><{$smarty.const._TAD_EDIT}></a>
                        <{else}>
                            <a href="<{$xoops|default:''}>/modules/system/admin.php?fct=blocksadmin&op=edit&bid=<{$config.bid}>" target="_blank" class="btn btn-primary"><{$smarty.const._TAD_EDIT}></a>
                        <{/if}>
                    <{/if}>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-sm-4">
            <div class="input-group d-inline">
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text">
                        <input id="<{$conf_name|default:''}>_html" class="form-check-input me-2 mr-2" type="checkbox" name="<{$conf_name|default:''}>[]" value="html" <{if $config.value|is_array && "html"|in_array:$config.value}>checked<{/if}>>
                        <label for="<{$conf_name|default:''}>_html">
                        <{$smarty.const.TF_HTML}>
                        </label>
                    </span>
                </div>
            </div>
            <textarea name="<{$conf_name|default:''}>_html_content" id="<{$conf_name|default:''}>_html_content" class="form-control" placeholder="請輸入任何內容，支援HTML、CSS或JavaScript語法"><{$config.html_content}></textarea>
            <div style="font-size:0.825rem; margin-top:4px;"><{$config.html_content_desc}></div>
        </div>
        <div class="col-sm-4">
            <div class="input-group d-inline">
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text">
                        <input id="<{$conf_name|default:''}>_fa-icon" class="form-check-input me-2 mr-2" type="checkbox" name="<{$conf_name|default:''}>[]" value="fa-icon" <{if $config.value|is_array && "fa-icon"|in_array:$config.value}>checked<{/if}>>
                        <label for="<{$conf_name|default:''}>_fa-icon">
                        <{$smarty.const.TF_FA_ICON}>
                        </label>
                    </span>
                </div>
            </div>
            <textarea name="<{$conf_name|default:''}>_fa_content" id="<{$conf_name|default:''}>_fa_content" class="form-control" placeholder="https://www.facebook.com|fa-facebook|dark|_blank|粉絲專頁"><{$config.fa_content}></textarea>
            <div style="font-size:0.825rem; margin-top:4px;"><{$config.fa_content_desc}></div>
        </div>
        <div class="col-sm-4">
            <div class="input-group d-inline">
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text">
                        <input id="<{$conf_name|default:''}>_menu" class="form-check-input me-2 mr-2" type="checkbox" name="<{$conf_name|default:''}>[]" value="menu" <{if $config.value|is_array && "menu"|in_array:$config.value}>checked<{/if}>>
                        <label for="<{$conf_name|default:''}>_menu">
                        <{$smarty.const.TF_MENU}>
                        </label>
                    </span>
                </div>
            </div>
            <textarea name="<{$conf_name|default:''}>_menu_content" id="<{$conf_name|default:''}>_menu_content" class="form-control" placeholder="最新消息|/modules/tadnews/|#f5c9c9|#ffffff|_blank"><{$config.menu_content}></textarea>
            <div style="font-size:0.825rem; margin-top:4px;"><{$config.menu_content_desc}></div>
        </div>
    </div>
</div>