<{if $block.menu|default:false}>
    <{include file="$xoops_rootpath/modules/tad_themes/templates/blocks/sub_vertical_bootstrap_menu_css.tpl"}>

    <nav aria-label="<{$smarty.const._MB_TADTHEMES_VERTICAL_MENU|escape:'html'}>">
        <ul class="vertical_bootstrap_menu">
            <{foreach from=$block.menu item=menu key=i}>
                <{if $menu.itemname|default:false}>
                    <li>
                        <a style="border-left:5px solid <{$menu.color|escape:'html'}>;" href="<{$menu.itemurl|escape:'html'}>" title="<{$menu.title|default:$menu.itemname|escape:'html'}>"<{if $menu.target|default:'' != ''}> target="<{$menu.target|escape:'html'}>"<{/if}><{if $menu.target|default:'' == '_blank'}> rel="noopener noreferrer"<{/if}>>
                            <{if $menu.bootstrap_icon|default:'' != ''}><i class="<{if $menu.bootstrap_icon|substr:0:3=='fa-'}>fa <{/if}><{$menu.bootstrap_icon|escape:'html'}>" aria-hidden="true"></i><{/if}>
                            <span class="vbm-text"><{$menu.itemname|escape:'html'}></span>
                        </a>
                    </li>
                <{/if}>
            <{/foreach}>
        </ul>
    </nav>
<{/if}>
