<?php

use XoopsModules\Tadtools\JqueryPin;
use XoopsModules\Tadtools\Utility;
if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}

//區塊主函式 (vertical_menu)
function vertical_menu($options)
{
    global $xoopsDB, $xoTheme;
    $xoTheme->addStylesheet('modules/tadtools/css/vertical_menu.css');

    require_once XOOPS_ROOT_PATH . '/modules/tad_themes/function_block.php';
    $in = empty($options[0]) ? "`status`='1' AND `of_level`=0" : "`menuid` IN({$options[0]})";

    $sql = 'SELECT `menuid`, `itemname`, `itemurl`, `target`, `icon`, `position`
        FROM `' . $xoopsDB->prefix('tad_themes_menu') . '`
        WHERE ' . $in . '
        ORDER BY `position`';
    $result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

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
        $menu[$i]['position'] = $position;
        $menu[$i]['bootstrap_icon'] = $bootstrap_icon;
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
    $block['pin'] = $options[1];

    if ('1' == $options[1]) {

        $JqueryPin = new JqueryPin();
        $JqueryPin->render('.vertical_menu');
    }

    return $block;
}

//區塊編輯函式 (tad_themes_top_menu_edit)
function vertical_menu_edit($options)
{
    $block_menu_options = block_menu_options($options[0]);

    $checked1 = 1 == $options[1] ? 'checked' : '';
    $checked0 = 0 == $options[1] ? 'checked' : '';

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
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADTHEMES_PIN_MENU . "</lable>
            <div class='my-content'>
                <input type='radio' name='options[1]' id='pin1' value='1' $checked1>" . _YES . "
                <input type='radio' name='options[1]' id='pin0' value='0' $checked0>" . _NO . '
            </div>
        </li>
    </ol>';

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
        $sql = 'SELECT `menuid`, `itemname`, `status`, `of_level`
        FROM `' . $xoopsDB->prefix('tad_themes_menu') . '`
        ORDER BY `position`';
        $result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $option = '';
        while (list($menuid, $itemname, $status, $of_level) = $xoopsDB->fetchRow($result)) {
            $js .= "if(document.getElementById('c{$menuid}').checked){
            arr[i] = document.getElementById('c{$menuid}').value;
            i++;
        }";
            $ckecked = (in_array($menuid, $sc)) ? 'checked' : '';
            $color = '0' == $of_level ? 'blue' : 'black';
            $color = '1' == $status ? $color : 'gray';
            $option .= "
        <span style='white-space:nowrap;'>
            <label for='c{$menuid}' style='color:$color'>
            <input type='checkbox' id='c{$menuid}' value='{$menuid}' class='bbv' onChange=bbv() $ckecked>
            $itemname
            </label>
        </span> ";
        }

        $js .= "document.getElementById('bb').value=arr.join(',');
    }
    </script>";

        $main['js'] = $js;
        $main['form'] = $option;

        return $main;
    }
}
