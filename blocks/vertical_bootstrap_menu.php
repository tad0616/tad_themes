<?php
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_themes\Tools;
if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}

//區塊主函式 (垂直BootStrap選單)
function vertical_bootstrap_menu($options)
{
    global $xoopsDB;
    $in = empty($options[0]) ? "`status`='1' and `of_level`=0" : '`menuid` in(' . implode(',', array_map('intval', explode(',', $options[0]))) . ')';

    $sql = 'SELECT `menuid`, `itemname`, `itemurl`, `target`, `icon`, `position`
        FROM `' . $xoopsDB->prefix('tad_themes_menu') . '`
        WHERE ' . $in . '
        ORDER BY `position`';
    $result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $menu = [];

    $dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_icons';
    $url = XOOPS_URL . '/uploads/tad_themes/menu_icons';
    $i = 1;
    while ($row = $xoopsDB->fetchRow($result)) {
        list($menuid, $itemname, $itemurl, $target, $bootstrap_icon, $position) = $row;
        if (empty($itemname) or empty($itemurl)) {
            continue;
        }

        $menu[$i]['itemname'] = $itemname;
        $menu[$i]['itemurl'] = $itemurl;
        $menu[$i]['target'] = $target;
        $menu[$i]['bootstrap_icon'] = $bootstrap_icon;
        $menu[$i]['position'] = $position;
        $menu[$i]['color'] = Tools::genColorCodeFromText($menuid);
        $icon = '';
        if (file_exists($dir . '/' . $menuid . '_64.png')) {
            $icon = "{$url}/{$menuid}_64.png";
        }

        $menu[$i]['icon'] = $icon;
        $menu[$i]['title'] = vertical_bootstrap_menu_title((string) $itemname, (string) $itemurl, (string) $target);
        $i++;
    }
    $block['menu'] = $menu;
    $block['jquery'] = Utility::get_jquery();
    //die(var_dump($block));
    return $block;
}

//產生連結的 title（無障礙：標示檔案格式與另開新視窗）
if (!function_exists('vertical_bootstrap_menu_title')) {
    function vertical_bootstrap_menu_title(string $itemname, string $itemurl, string $target): string
    {
        // 需要標示格式的檔案副檔名
        $file_exts = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'odt', 'ods', 'odp', 'rtf', 'txt', 'csv', 'zip', 'rar', '7z', 'mp3', 'mp4'];

        $notes = [];
        $path = parse_url($itemurl, PHP_URL_PATH);
        if (is_string($path) && '' !== $path) {
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (in_array($ext, $file_exts, true)) {
                $notes[] = sprintf(_MB_TADTHEMES_FILE_FORMAT, strtoupper($ext));
            }
        }

        if ('_blank' === $target) {
            $notes[] = _MB_TADTHEMES_NEW_WINDOW;
        }

        if (empty($notes)) {
            return $itemname;
        }

        return sprintf(_MB_TADTHEMES_TITLE_FORMAT, $itemname, implode(_MB_TADTHEMES_TITLE_SEP, $notes));
    }
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

        $sc = empty($selected) ? [] : explode(',', $selected);

        $js = '<script>
        function bbv(){
        i=0;
        var arr = new Array();';

        $sql = 'SELECT `menuid`, `itemname`, `status`
        FROM `' . $xoopsDB->prefix('tad_themes_menu') . '`
        ORDER BY `position`';
        $result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $option = '';
        while ($row = $xoopsDB->fetchRow($result)) {
            list($menuid, $itemname, $status) = $row;
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
