<{if $block.menu|default:false}>
    <ul class="vertical_menu">
        <{foreach from=$block.menu  key=i item=menu}>
            <{if $menu.itemname|default:false}>
                <li>
                    <a href="<{$menu.itemurl}>" target="<{$menu.target}>">
                        <i class="<{if $menu.bootstrap_icon|substr:0:3=='fa-'}>fa <{/if}><{$menu.bootstrap_icon}>"></i>
                        <{$menu.itemname}>
                    </a>
                </li>
            <{/if}>
        <{/foreach}>
    </ul>
<{/if}>
