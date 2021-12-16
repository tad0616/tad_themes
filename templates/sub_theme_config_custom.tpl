
<{if $custom_config2}>
    <div class="alert alert-warning">
        <h4>
            <{$custom_tab_title}><{$smarty.const._MA_TADTHEMES_CONFIG2}>
        </h4>
        <input type="hidden" name="config2[]" value="custom_config2">
    </div>
    <{foreach from=$custom_config2 item=config}>
        <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_config_other.tpl"}>
    <{/foreach}>
<{/if}>