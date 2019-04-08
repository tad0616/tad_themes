<{if $block.menu}>
    <ul class="vertical_menu">
        <{foreach from=$block.menu item=menu key=i}>
            <{if $menu.itemname!=""}>
                <li>
                    <a href="<{$menu.itemurl}>" target="<{$menu.target}>">
                        <i class="fa <{$menu.bootstrap_icon}>"></i>
                        <{$menu.itemname}>
                    </a>
                </li>
            <{/if}>
        <{/foreach}>
    </ul>
<{/if}>
