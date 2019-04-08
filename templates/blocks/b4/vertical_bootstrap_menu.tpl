<{if $block.menu}>
    <{includeq file="$xoops_rootpath/modules/tad_themes/templates/blocks/sub_vertical_bootstrap_menu_css.tpl"}>

    <ul class="vertical_bootstrap_menu">
        <{foreach from=$block.menu item=menu key=i}>
            <{if $menu.itemname!=""}>
                <li><a style="border-left:5px solid <{$menu.color}>;" href="<{$menu.itemurl}>" target="<{$menu.target}>"><i class="fa <{$menu.bootstrap_icon}>"></i> <{$menu.itemname}></a></li>
            <{/if}>
        <{/foreach}>
    </ul>
<{/if}>
