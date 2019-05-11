<?php

use XoopsModules\Tadtools\Utility;
if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}

//區塊主函式 (垂直BootStrap選單)
function vertical_bootstrap_menu($options)
{
    global $xoopsDB;
    require_once XOOPS_ROOT_PATH . '/modules/tadtools/tad_function.php';
    require_once XOOPS_ROOT_PATH . '/modules/tad_themes/function_block.php';
    $in = empty($options[0]) ? "status='1' and of_level=0" : "menuid in({$options[0]})";
    //$menu=explode(",",$options[0]);
    $sql = 'select `menuid`,`itemname`,`itemurl`,`target`,`icon`,`position` from ' . $xoopsDB->prefix('tad_themes_menu') . " where $in order by position";
    $result = $xoopsDB->query($sql);
    $menu = [];

    $dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_icons';
    $url = XOOPS_URL . '/uploads/tad_themes/menu_icons';
    $i = 1;
    while (list($menuid, $itemname, $itemurl, $target, $bootstrap_icon, $position) = $xoopsDB->fetchRow($result)) {
        if (empty($itemname) or empty($itemurl)) {
            continue;
        }

        $menu[$i]['itemname'] = $itemname;
        $menu[$i]['itemurl'] = $itemurl;
        $menu[$i]['target'] = $target;
        $menu[$i]['bootstrap_icon'] = $bootstrap_icon;
        $menu[$i]['position'] = $position;
        $menu[$i]['color'] = genColorCodeFromText($menuid);
        $icon = '';
        if (file_exists($dir . '/' . $menuid . '_64.png')) {
            $icon = "{$url}/{$menuid}_64.png";
        }

        $menu[$menuid]['icon'] = $icon;
        $i++;
    }
    $block['menu'] = $menu;
    $block['jquery'] = Utility::get_jquery();
    //die(var_dump($block));
    return $block;
}

//區塊編輯函式 (tad_themes_top_menu_edit)
function vertical_bootstrap_menu_edit($options)
{
    $block_menu_options = block_menu_options($options[0]);
    $form = "
    {$block_menu_options['js']}
    <ol class='my-form'>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADTHEMES_MENU_OPTIONS . "</lable>
            <div class='my-content'>
                {$block_menu_options['form']}
                <input type='hidden' name='options[0]' id='bb' value='{$options[0]}'>
            </div>
        </li>
    </ol>";

    return $form;
}

//取得所有類別標題
if (!function_exists('block_menu_options')) {
    function block_menu_options($selected = '')
    {
        global $xoopsDB;

        if (!empty($selected)) {
            $sc = explode(',', $selected);
        }

        $js = '<script>
        function bbv(){
        i=0;
        var arr = new Array();';

        $sql = 'SELECT menuid,itemname,status FROM ' . $xoopsDB->prefix('tad_themes_menu') . ' ORDER BY position';
        $result = $xoopsDB->query($sql);
        $option = '';
        while (list($menuid, $itemname, $status) = $xoopsDB->fetchRow($result)) {
            $js .= "if(document.getElementById('c{$menuid}').checked){
                arr[i] = document.getElementById('c{$menuid}').value;
                i++;
                }";
            $ckecked = (in_array($menuid, $sc)) ? 'checked' : '';
            $color = '1' == $status ? 'black' : 'gray';
            $option .= "<span style='white-space:nowrap;'><input type='checkbox' id='c{$menuid}' value='{$menuid}' class='bbv' onChange=bbv() $ckecked><label for='c{$menuid}' style='color:$color'>$itemname</label></span> ";
        }

        $js .= "document.getElementById('bb').value=arr.join(',');
        }
        </script>";

        $main['js'] = $js;
        $main['form'] = $option;

        return $main;
    }
}
