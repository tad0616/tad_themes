<?php
//區塊主函式 (tad_themes_top_menu)
function tad_themes_top_menu($options)
{
    global $xoopsDB;
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php";

    //$menu=explode(",",$options[0]);
    $sql    = "select `menuid`,`itemname`,`itemurl`,`target`,`icon` from " . $xoopsDB->prefix("tad_themes_menu") . " where menuid in({$options[0]}) order by position";
    $result = $xoopsDB->query($sql);
    $menu   = "";
    $i      = 1;

    $dir = XOOPS_ROOT_PATH . "/uploads/tad_themes/menu_icons";
    $url = XOOPS_URL . "/uploads/tad_themes/menu_icons";

    while (list($menuid, $itemname, $itemurl, $target, $icon) = $xoopsDB->fetchRow($result)) {
        $menu[$menuid]['itemname'] = $itemname;
        $menu[$menuid]['itemurl']  = $itemurl;
        $menu[$menuid]['target']   = $target;
        $icon                      = "";
        if (file_exists($dir . "/" . $menuid . "_64.png")) {
            $icon = "{$url}/{$menuid}_64.png";
        }

        $menu[$menuid]['icon'] = $icon;
        $i++;
    }
    $block['menu']   = $menu;
    $block['width']  = $i * 110;
    $block['jquery'] = get_jquery();
    return $block;
}

//區塊編輯函式 (tad_themes_top_menu_edit)
function tad_themes_top_menu_edit($options)
{

    $block_menu_options = block_menu_options($options[0]);
    $form               = "
  {$block_menu_options['js']}
  {$block_menu_options['form']}
  <INPUT type='hidden' name='options[0]' id='bb' value='{$options[0]}'>";

    return $form;
}

//取得所有類別標題
if (!function_exists("block_menu_options")) {
    function block_menu_options($selected = "")
    {
        global $xoopsDB;

        if (!empty($selected)) {
            $sc = explode(",", $selected);
        }

        $js = "<script>
    function bbv(){
      i=0;
      var arr = new Array();";

        $sql    = "select menuid,itemname from " . $xoopsDB->prefix("tad_themes_menu") . " where of_level=0  order by position";
        $result = $xoopsDB->query($sql);
        $option = "";
        while (list($menuid, $itemname) = $xoopsDB->fetchRow($result)) {

            $js .= "if(document.getElementById('c{$menuid}').checked){
         arr[i] = document.getElementById('c{$menuid}').value;
         i++;
        }";
            $ckecked = (in_array($menuid, $sc)) ? "checked" : "";
            $option .= "<span style='white-space:nowrap;'><input type='checkbox' id='c{$menuid}' value='{$menuid}' class='bbv' onChange=bbv() $ckecked><label for='c{$menuid}'>$itemname</label></span> ";
        }

        $js .= "document.getElementById('bb').value=arr.join(',');
    }
    </script>";

        $main['js']   = $js;
        $main['form'] = $option;
        return $main;
    }
}
