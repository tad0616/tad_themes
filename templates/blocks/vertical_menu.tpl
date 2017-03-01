<{if $block.menu}>
  <style>
  ul.vertical_menu {
    position:relative;
    background:transparent;
    width:100%;
    margin:auto;
    padding:0;
    list-style: none;
    overflow:hidden;
    z-index: 999;
  }

  .vertical_menu li a {
    width:100%;
    height:40px;
    line-height:40px;
    display:block;
    overflow:hidden;
    position:relative;
    text-decoration:none;
    text-transform:uppercase;
    font-size:14px;
    color:#686868;

    -webkit-transition:all 0.2s linear;
    -moz-transition:all 0.2s linear;
    -o-transition:all 0.2s linear;
    transition:all 0.2s linear;
  }

  .vertical_menu li a:hover {
    background:#efefef;
  }


  .vertical_menu li a:hover i {
    color:#ea4f35;
  }

  .vertical_menu i {
    -webkit-transition:all 0.2s linear;
    -moz-transition:all 0.2s linear;
    -o-transition:all 0.2s linear;
    transition:all 0.2s linear;
  }

  .vertical_menu em {
    font-size: 10px;
    background: #ea4f35;
    padding: 3px 5px;
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px;
    font-style: normal;
    color: #fff;
    margin-top: 17px;
    margin-right: 15px;
    line-height: 10px;
    height: 10px;
    float:right;
  }

  .vertical_menu li.selected a {
    background:#efefef;
  }

  </style>

  <ul class="vertical_menu">
    <li>
      <a style="border-bottom:1px dotted #cfcfcf;" href="<{$xoops_url}>">
        <i class="icon-home"></i>
        <{$smarty.const._YOURHOME}>
      </a>
    </li>

    <{foreach from=$block.menu item=menu key=i}>
      <{if $menu.itemname!=""}>
      <li>
        <a style="border-bottom:1px dotted #cfcfcf;" href="<{$menu.itemurl}>" target="<{$menu.target}>">
          <i class="fa <{$menu.bootstrap_icon}>"></i>
          <{$menu.itemname}>
        </a>
      </li>
      <{/if}>
    <{/foreach}>

  </ul>
<{/if}>