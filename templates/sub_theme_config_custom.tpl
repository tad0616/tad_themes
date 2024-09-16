
<{if $custom_config2|default:false}>
    <div class="alert alert-warning">
        <h4>
            <{$config.label}><{$smarty.const._MA_TADTHEMES_CONFIG2}>
        </h4>
    </div>
    <{foreach from=$custom_config2 item=config}>
        <{include file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_config_other.tpl"}>
    <{/foreach}>
<{/if}>