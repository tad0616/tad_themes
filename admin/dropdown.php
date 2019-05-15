<?php
use XoopsModules\Tadtools\FancyBox;
use XoopsModules\Tadtools\TreeTable;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = 'tad_themes_adm_dropdown.tpl';
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';

/*-----------function區--------------*/
//tad_themes_menu編輯表單
function tad_themes_menu_form($of_level = '0', $menuid = '', $mode = 'return')
{
    global $xoopsDB, $xoopsTpl, $xoTheme, $xoopsModule;
    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    //抓取預設值
    if (!empty($menuid)) {
        $DBV = get_tad_themes_menu($menuid);
    } else {
        $DBV = [];
    }

    //預設值設定

    $menuid = (!isset($DBV['menuid'])) ? $menuid : $DBV['menuid'];
    $of_level = (!isset($DBV['of_level'])) ? $of_level : $DBV['of_level'];
    $position = (!isset($DBV['position'])) ? get_max_sort($of_level) : $DBV['position'];
    $itemname = (!isset($DBV['itemname'])) ? '' : $DBV['itemname'];
    $itemurl = (!isset($DBV['itemurl'])) ? '' : $DBV['itemurl'];
    $membersonly = (!isset($DBV['membersonly'])) ? '' : $DBV['membersonly'];
    $status = (!isset($DBV['status'])) ? '' : $DBV['status'];
    $target = (!isset($DBV['target'])) ? '' : $DBV['target'];
    $mainmenu = (!isset($DBV['mainmenu'])) ? '' : $DBV['mainmenu'];
    $icon = (!isset($DBV['icon'])) ? '' : $DBV['icon'];
    $read_group = (!isset($DBV['read_group'])) ? [1, 2, 3] : $DBV['read_group'];
    $read_group_array = explode(',', $read_group);
    $xoopsTpl->assign('icon', $icon);
    $ver = (int) str_pad(str_replace('.', '', str_replace('XOOPS ', '', XOOPS_VERSION)), 4, 0);
    if ($ver >= 2590) {
        $xoTheme->addScript('modules/tadtools/jquery/jquery-migrate-3.0.0.min.js');
    } else {
        $xoTheme->addScript('modules/tadtools/jquery/jquery-migrate-1.4.1.min.js');
    }

    $SelectGroup_name = new \XoopsFormSelectGroup('read_group', 'read_group', true, $read_group_array, 4, true);
    $SelectGroup_name->setExtra("class='form-control' id='read_group'");
    $enable_group = $SelectGroup_name->render();

    $op = (empty($menuid)) ? 'insert_tad_themes_menu' : 'update_tad_themes_menu';

    $get_tad_all_menu = '';
    if (!empty($menuid)) {
        $get_tad_all_menu = "
          <label class='col-xs-3 control-label'>" . _MA_TADTHEMES_OF_LEVEL . _TAD_FOR . "</label>
          <div class='col-xs-3'>
            <select name='of_level' id='of_level' class='form-control'>
            <option value=''>" . _MA_TADTHEMES_ROOT . '</option>
            ' . get_tad_all_menu('', '', $of_level, $menuid, '1') . '
            </select>
          </div>
        ';
    } else {
        $get_tad_all_menu = "<input type='hidden' name='of_level' value='{$of_level}'>";
    }

    $main = "
    <form method='post' id='myForm' enctype='multipart/form-data' class='form-horizontal' role='form'>
        <div class='form-group'>
            <label class='col-xs-3 control-label' for='icon'>" . _MA_TADTHEMES_ICON . _TAD_FOR . "</label>
            <div class='col-xs-3'>
                <input name='icon' class='selectpicker form-control' value='{$icon}' type='text'>
            </div>
            $get_tad_all_menu
        </div>


        <div class='form-group'>
            <label class='col-xs-3 control-label' for='itemname'>" . _MA_TADTHEMES_ITEMNAME . _TAD_FOR . "</label>
            <div class='col-xs-9'>
                <input type='text' name='itemname' id='itemname' value='{$itemname}' class='form-control' placeholder='" . _MA_TADTHEMES_ITEMNAME . "'>
            </div>
        </div>

        <div class='form-group'>
            <label class='col-xs-3 control-label' for='itemurl'>" . _MA_TADTHEMES_ITEMURL . _TAD_FOR . "</label>
            <div class='col-xs-6'>
                <input type='text' name='itemurl' id='itemurl' value='{$itemurl}' class='form-control' placeholder='" . _MA_TADTHEMES_ITEMURL . "'>
            </div>
            <div class='col-xs-3'>
                <select name='target' class='form-control'>
                    <option value='_self'></option>
                    <option value='_blank' " . Utility::chk($target, '_blank', 0, 'selected') . '>' . _MA_TADTHEMES_TARGET_BLANK . "</option>
                    <option value='popup' " . Utility::chk($target, 'popup', 0, 'selected') . '>' . _MA_TADTHEMES_TARGET_FANCYBOX . "</option>
                </select>
            </div>
        </div>

        <div class='form-group'>
            <label class='col-xs-3 control-label' for='itemurl'>" . _MA_TADTHEMES_READGROUP . _TAD_FOR . "</label>
            <div class='col-xs-9'>
                {$enable_group}
            </div>
        </div>


        <div class='form-group'>
            <label class='col-xs-3 control-label' for='image'>" . _MA_TADTHEMES_ITEMICON . _TAD_FOR . "</label>
            <div class='col-xs-8'>
                <input type='file' name='image' id='image'>
            </div>
        </div>

        <div class='form-group'>
            <label class='col-xs-3 control-label' for='banner_image'>" . _MA_TADTHEMES_ITEMBANNER . _TAD_FOR . "</label>
            <div class='col-xs-8'>
                <input type='file' name='banner_image' id='banner_image'>
            </div>
        </div>
        <div class='text-center'>
            <input type='hidden' name='menuid' value='{$menuid}'>
            <input type='hidden' name='status' value='{$status}'>
            <input type='hidden' name='op' value='{$op}'>
            <input type='hidden' name='position' value='{$position}'>
            <button type='button' id='submit' class='btn btn-primary'>" . _TAD_SAVE . '</button>
        </div>

    </form>';

    if ('die' === $mode) {
        $jquery = Utility::get_jquery();
        $main2 = "
        <!DOCTYPE html>
        <html lang='zh-TW'>
            <head>
                <meta charset='utf-8'>
                <title></title>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <link rel='stylesheet' type='text/css' media='screen' href='" . XOOPS_URL . "/modules/tadtools/bootstrap3/css/bootstrap.css'>

                <link rel='stylesheet' type='text/css' media='screen' href='" . XOOPS_URL . "/modules/tadtools/css/xoops_adm.css'>
                <link href='" . XOOPS_URL . "/modules/tadtools/css/font-awesome/css/font-awesome.min.css' rel='stylesheet'>

                <script src='" . XOOPS_URL . "/browse.php?Frameworks/jquery/jquery.js' type='text/javascript'></script>
                <script src='" . XOOPS_URL . "/modules/tadtools/bootstrap3/js/bootstrap.min.js'></script>
                <script src='" . XOOPS_URL . $migrate . "'></script>
                <link href='" . XOOPS_URL . "/modules/tad_themes/class/fontawesome-iconpicker/css/fontawesome-iconpicker.min.css' rel='stylesheet'>
                <script src='" . XOOPS_URL . "/modules/tad_themes/class/fontawesome-iconpicker/js/fontawesome-iconpicker.js'></script>
            </head>
            <body>

                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-xs-12'>
                            $main
                        </div>
                    </div>
                </div>

                <script type='text/javascript'>
                    $(document).ready(function(){
                    $('.selectpicker').iconpicker();

                    $('#myForm').bind('submit', function()
                        {
                        $.ajax({
                            type: 'POST',
                            url: '{$_SERVER['PHP_SELF']}',
                            //data: $(this).serializeArray(),
                            data: new FormData( this ),
                            processData: false,
                            contentType: false,
                            success: function(data) {
                            parent.$.fancybox.close();
                            }
                        });
                        });
                    $('#submit').click(function(e)
                    {
                        $('#myForm').trigger('submit');
                        e.preventDefault();

                    });
                    });
                </script>
            </body>
        </html>
        ";
        die($main2);
    }

    return $main;
}

//做縮圖
if (!function_exists('thumbnail')) {
    function thumbnail($filename = '', $thumb_name = '', $type = 'image/png', $width = '160')
    {
        set_time_limit(0);
        ini_set('memory_limit', '100M');
        // Get new sizes
        list($old_width, $old_height) = getimagesize($filename);

        $percent = ($old_width > $old_height) ? round($width / $old_width, 2) : round($width / $old_height, 2);
        $newwidth = ($old_width > $old_height) ? $width : round($old_width * $percent, 0);
        $newheight = ($old_width > $old_height) ? round($old_height * $percent, 0) : $width;

        // Load
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        if ('image/jpeg' === $type or 'image/jpg' === $type or 'image/pjpg' === $type or 'image/pjpeg' === $type) {
            $source = imagecreatefromjpeg($filename);
            $type = 'image/jpeg';
        } elseif ('image/png' === $type) {
            $source = imagecreatefrompng($filename);
            $type = 'image/png';
        } elseif ('image/gif' === $type) {
            $source = imagecreatefromgif($filename);
            $type = 'image/gif';
        } else {
            die($type);
        }

        imagealphablending($thumb, false);
        // Resize
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $old_width, $old_height);

        imagesavealpha($thumb, true);

        // Output
        imagepng($thumb, $thumb_name);
        imagedestroy($source);
        imagedestroy($thumb);
    }
}

//自動取得新排序
function get_max_sort($of_level = '')
{
    global $xoopsDB, $xoopsModule;
    $sql = 'select max(position) from ' . $xoopsDB->prefix('tad_themes_menu') . " where of_level='$of_level'";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    list($sort) = $xoopsDB->fetchRow($result);

    return ++$sort;
}

//新增資料到tad_themes_menu中
function insert_tad_themes_menu()
{
    global $xoopsDB;
    $myts = \MyTextSanitizer::getInstance();
    $of_level = (int) $_POST['of_level'];
    $position = (int) $_POST['position'];
    $itemname = $myts->addSlashes($_POST['itemname']);
    $itemurl = $myts->addSlashes($_POST['itemurl']);
    $target = $myts->addSlashes($_POST['target']);
    $icon = $myts->addSlashes($_POST['icon']);
    $read_group = implode(',', $_POST['read_group']);

    $sql = 'insert into ' . $xoopsDB->prefix('tad_themes_menu') . " (`of_level`,`position`,`itemname`,`itemurl`,`membersonly`,`status`,`mainmenu`,`target`,`icon`,`read_group`) values('{$of_level}', '{$position}', '{$itemname}', '{$itemurl}', '0', '1', '0', '{$target}', '{$icon}', '{$read_group}')";
    $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    //取得最後新增資料的流水編號
    $menuid = $xoopsDB->getInsertId();

    $type_to_mime['png'] = 'image/png';
    $type_to_mime['jpg'] = 'image/jpg';
    $type_to_mime['peg'] = 'image/jpg';
    $type_to_mime['gif'] = 'image/gif';
    //處理上傳的檔案
    if (!empty($_FILES['image']['name'])) {
        $file_ending = mb_substr(mb_strtolower($_FILES['image']['name']), -3); //file extension
        $dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_icons';
        Utility::mk_dir($dir);
        $filename = $_FILES['image']['tmp_name'];
        $thumb_name1 = "{$dir}/{$menuid}_64.png";
        thumbnail($filename, $thumb_name1, $type_to_mime[$file_ending], 64);
        $thumb_name2 = "{$dir}/{$menuid}_32.png";
        thumbnail($filename, $thumb_name2, $type_to_mime[$file_ending], 32);
    }

    if (!empty($_FILES['banner_image']['name'])) {
        $file_ending = mb_substr(mb_strtolower($_FILES['banner_image']['name']), -3); //file extension
        $dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_banner';
        Utility::mk_dir($dir);
        $filename = $_FILES['banner_image']['tmp_name'];
        $destination = "{$dir}/{$menuid}.png";
        $thumb = "{$dir}/{$menuid}_thumb.png";
        move_uploaded_file($filename, $destination);
        thumbnail($destination, $thumb, $type_to_mime[$file_ending], 120);
    }

    return $menuid;
}

//列出所有tad_themes_menu資料
function list_tad_themes_menu($add_of_level = '', $menuid = '')
{
    global $xoopsDB, $xoopsModule, $xoopsTpl, $xoTheme;

    $all = get_tad_level_menu(0, 0, $menuid, '', $add_of_level);

    $op = (!isset($_REQUEST['op'])) ? '' : $_REQUEST['op'];
    $option = '';

    //$all=(empty($all))?"<tr><td colspan=2>".tad_themes_menu_form()."</td></tr>":$all;

    $jquery = Utility::get_jquery(true);

    $xoopsTpl->assign('jquery', $jquery);
    $xoopsTpl->assign('all', $all);
    $xoopsTpl->assign('option', $option);
    $xoopsTpl->assign('add_item', sprintf(_MA_TADTHEMES_ADDITEM, _MA_TADTHEMES_ROOT));

    //treetable($show_jquery=true , $sn="cat_sn" , $of_sn="of_cat_sn" , $tbl_id="#tbl" , $post_url="save_drag.php" ,$folder_class=".folder", $msg="#save_msg" ,$expanded=true,$sort_id="", $sort_url="save_sort.php", $sort_msg="#save_msg2")
    $TreeTable = new TreeTable(false, 'menuid', 'of_level', '#tbl', 'save_drag.php', '.folder', '#save_msg', true, '.sort', 'save_sort.php', '#save_msg');
    $treetable_code = $TreeTable->render();

    $xoopsTpl->assign('treetable_code', $treetable_code);

    $FancyBox = new FancyBox('.edit_dropdown', '800', '400');
    $FancyBox->render();

    $xoTheme->addStylesheet('modules/tadtools/css/font-awesome/css/font-awesome.min.css');
    $xoTheme->addScript('modules/tadtools/bootstrap3/js/bootstrap.js');
}

//取得分類項目
function get_tad_level_menu($of_level = 0, $level = 0, $v = '', $this_menuid = '', $add_of_level = '0')
{
    global $xoopsDB, $xoopsUser, $xoopsModule;
    $btn_xs = 4 == $_SESSION['bootstrap'] ? 'btn-sm' : 'btn-xs';
    $left = $level * 30;
    $font_size = 16 - ($level * 2);
    $level += 1;

    $left = (empty($left)) ? 4 : $left;

    $option = '';
    $sql = 'select `menuid`,`of_level`,`itemname`,`position`,`itemurl`,`status`,`mainmenu`,`target`,`icon`,`link_cate_name`, `link_cate_sn` from ' . $xoopsDB->prefix('tad_themes_menu') . " where of_level='{$of_level}'  order by position";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $op = (!isset($_REQUEST['op'])) ? '' : $_REQUEST['op'];
    $dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_icons';
    $banner_dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_banner';
    $url = XOOPS_URL . '/uploads/tad_themes/menu_icons';
    $banner_url = XOOPS_URL . '/uploads/tad_themes/menu_banner';
    while (list($menuid, $of_level, $itemname, $position, $itemurl, $status, $mainmenu, $target, $icon, $link_cate_name, $link_cate_sn) = $xoopsDB->fetchRow($result)) {
        $item = (empty($itemurl)) ? "<i class='fa {$icon}'></i> " . $itemname : "<a name='$menuid' href='{$itemurl}'><i class='fa {$icon}'></i> $itemname</a>";

        $add_img = ($level >= 3) ? '' : "<a href='{$_SERVER['PHP_SELF']}?op=add_tad_themes_menu&of_level={$menuid}' class='edit_dropdown' data-fancybox-type='iframe'><i class='fa fa-plus-circle fa-2x text-success' aria-hidden='true' title='" . sprintf(_MA_TADTHEMES_ADDITEM, $itemname) . "'></i></a>";

        $status_tool = ('1' == $status) ? "<a href='{$_SERVER['PHP_SELF']}?op=tad_themes_menu_status&menuid=$menuid&status=0' class='btn $btn_xs btn-warning'>" . _TAD_UNABLE . '</a>' : "<a href='{$_SERVER['PHP_SELF']}?op=tad_themes_menu_status&menuid=$menuid&status=1' class='btn $btn_xs btn-info'>" . _TAD_ENABLE . '</a>';

        $status_color = ('1' == $status) ? '' : "style='background-color:#D0D0D0'";
        $status_color2 = ('1' == $status) ? '' : 'background-color:#D0D0D0';
        $target_icon = ('_blank' === $target) ? "<span class='label' style='padding: 2px 4px;'>" . _MA_TADTHEMES_TARGET_BLANK . '</span>' : '';
        $target_icon = ('popup' === $target) ? "<span class='label label-success' style='padding: 2px 4px;'>popup</span>" : $target_icon;

        $class = (empty($of_level)) ? '' : "class='child-of-node-{$of_level}'";
        $parent = empty($of_level) ? '' : "data-tt-parent-id='$of_level'";

        $icon = '';
        if (file_exists("{$dir}/{$menuid}_32.png")) {
            $icon = "<a href='{$url}/{$menuid}_32.png' class='edit_dropdown'><img src=\"{$url}/{$menuid}_32.png\"></a><a href=\"javascript:delete_tad_themes_pic('icon',$menuid);\"><img src='../images/delete.png'></a>";
        }
        $banner = '';
        if (file_exists("{$banner_dir}/{$menuid}_thumb.png")) {
            $banner = "<a href='{$banner_url}/{$menuid}.png' class='edit_dropdown'><img src=\"{$banner_url}/{$menuid}_thumb.png\"></a><a href=\"javascript:delete_tad_themes_pic('banner' , $menuid);\"><img src='../images/delete.png'></a>";
        }

        $content = "
        <td style='padding-left:{$left}px;$status_color2' >
          <a name='menuid_{$menuid}'></a>
          <img src='" . XOOPS_URL . "/modules/tadtools/treeTable/images/move_s.png' class='folder' alt='" . _MA_TREETABLE_MOVE_PIC . "' title='" . _MA_TREETABLE_MOVE_PIC . "'>
          <img src='" . XOOPS_URL . "/modules/tadtools/treeTable/images/updown_s.png' style='cursor: s-resize;margin:0px 4px;' alt='" . _MA_TADTHEMES_SAVE_SORT . "' title='" . _MA_TADTHEMES_SAVE_SORT . "'>
          {$position}
          <span style='font-size:{$font_size}px;' class='folder'>{$item}</span>
          $target_icon
          $add_img
        </td>
        <td $status_color>
          <a href=\"javascript:delete_tad_themes_menu_func($menuid);\" class='btn $btn_xs btn-danger'>" . _TAD_DEL . "</a>
          <a href='{$_SERVER['PHP_SELF']}?op=modify_tad_themes_menu&menuid=$menuid#menuid_{$menuid}' class='btn $btn_xs btn-success edit_dropdown' data-fancybox-type='iframe'>" . _TAD_EDIT . "</a>
          $status_tool

          $icon
          $banner
        </td>";

        $option .= "<tr data-tt-id='{$menuid}' $parent id='node-_{$menuid}' $class style='letter-spacing: 0em;'>$content</tr>";

        $option .= get_tad_level_menu($menuid, $level, $v, $this_menuid, $add_of_level);

        if ($add_of_level == $menuid) {
            $col_left = $level * 30;
            $option .= "<tr id='tr_{$menuid}'><td style='padding-left:{$col_left}px;' colspan=2;>" . tad_themes_menu_form($add_of_level) . '</td></tr>';
        }
    }

    return $option;
}

//以流水號取得某筆tad_themes_menu資料
function get_tad_themes_menu($menuid = '')
{
    global $xoopsDB;
    if (empty($menuid)) {
        return;
    }

    $sql = 'select * from ' . $xoopsDB->prefix('tad_themes_menu') . " where menuid='$menuid'";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $data = $xoopsDB->fetchArray($result);

    return $data;
}

//更新tad_themes_menu某一筆資料
function update_tad_themes_menu($menuid = '')
{
    global $xoopsDB;
    $myts = \MyTextSanitizer::getInstance();
    $of_level = (int) $_POST['of_level'];
    $position = (int) $_POST['position'];
    $status = (int) $_POST['status'];
    $itemname = $myts->addSlashes($_POST['itemname']);
    $itemurl = $myts->addSlashes($_POST['itemurl']);
    $target = $myts->addSlashes($_POST['target']);
    $icon = $myts->addSlashes($_POST['icon']);
    $read_group = implode(',', $_POST['read_group']);

    $sql = 'update ' . $xoopsDB->prefix('tad_themes_menu') . " set  `of_level` = '{$of_level}', `position` = '{$position}', `itemname` = '{$itemname}', `itemurl` = '{$itemurl}', `membersonly` = '0', `status` = '{$status}', `target`='{$target}',`icon`='{$icon}', `read_group`='{$read_group}' where menuid='$menuid'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $type_to_mime['png'] = 'image/png';
    $type_to_mime['jpg'] = 'image/jpg';
    $type_to_mime['peg'] = 'image/jpg';
    $type_to_mime['gif'] = 'image/gif';
    //處理上傳的檔案
    if (!empty($_FILES['image']['name'])) {
        $file_ending = mb_substr(mb_strtolower($_FILES['image']['name']), -3); //file extension
        $dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_icons';
        Utility::mk_dir($dir);
        $filename = $_FILES['image']['tmp_name'];
        $thumb_name1 = "{$dir}/{$menuid}_64.png";
        thumbnail($filename, $thumb_name1, $type_to_mime[$file_ending], 64);
        $thumb_name2 = "{$dir}/{$menuid}_32.png";
        thumbnail($filename, $thumb_name2, $type_to_mime[$file_ending], 32);
    }

    if (!empty($_FILES['banner_image']['name'])) {
        $file_ending = mb_substr(mb_strtolower($_FILES['banner_image']['name']), -3); //file extension
        $dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_banner';
        Utility::mk_dir($dir);
        $filename = $_FILES['banner_image']['tmp_name'];
        $destination = "{$dir}/{$menuid}.png";
        $thumb = "{$dir}/{$menuid}_thumb.png";
        move_uploaded_file($filename, $destination);
        thumbnail($destination, $thumb, $type_to_mime[$file_ending], 120);
    }

    return $menuid;
}

//刪除tad_themes_menu某筆資料資料
function delete_tad_themes_menu($menuid = '')
{
    global $xoopsDB;
    $sql = 'delete from ' . $xoopsDB->prefix('tad_themes_menu') . " where menuid='$menuid'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
}

//取得分類下拉選單
function get_tad_all_menu($of_level = 0, $level = 0, $v = '', $this_menuid = '', $no_self = '1')
{
    global $xoopsDB, $xoopsUser, $xoopsModule;

    if ($level >= 2) {
        return;
    }

    //$left=$level*10;
    $blank = str_repeat('&nbsp;', $level * 3);
    $level += 1;

    $option = '';
    $sql = 'select `menuid`,`of_level`,`itemname` from ' . $xoopsDB->prefix('tad_themes_menu') . " where of_level='{$of_level}'  order by position";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    while (list($menuid, $of_level, $itemname) = $xoopsDB->fetchRow($result)) {
        if ('1' == $no_self and $this_menuid == $menuid) {
            continue;
        }

        $selected = ($v == $menuid) ? 'selected' : '';
        $color = ('1' == $level) ? '#330033' : '#990099';
        $option .= "<option value='{$menuid}' style=color:{$color};' $selected>{$blank}{$itemname}</option>";
        $option .= get_tad_all_menu($menuid, $level, $v, $this_menuid, $no_self);
    }

    return $option;
}

//儲存排序
function save_sort()
{
    global $xoopsDB;
    foreach ($_POST['sort'] as $menuid => $position) {
        $sql = 'update ' . $xoopsDB->prefix('tad_themes_menu') . " set  `position` = '{$position}' where menuid='{$menuid}'";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    }
}

//自動匯入
function auto_import()
{
    global $xoopsDB, $xoopsUser, $xoopsModule;

    $position = get_max_sort(0);
    $sql = 'insert into ' . $xoopsDB->prefix('tad_themes_menu') . " (`of_level`,`position`,`itemname`,`itemurl`,`membersonly`,`status`) values(0,'{$position}','" . _MA_TADTHEMES_WEB_MENU . "','','0','1')";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    //取得最後新增資料的流水編號
    $of_level = $xoopsDB->getInsertId();

    $sql = 'select name,dirname from ' . $xoopsDB->prefix('modules') . " where isactive='1' and hasmain='1' order by weight";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    while (list($name, $dirname) = $xoopsDB->fetchRow($result)) {
        $position = get_max_sort($of_level);
        $sql = 'insert into ' . $xoopsDB->prefix('tad_themes_menu') . " (`of_level`,`position`,`itemname`,`itemurl`,`membersonly`,`status`) values('{$of_level}','{$position}','{$name}','" . XOOPS_URL . "/modules/{$dirname}/','0','1')";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    }
}

function tad_themes_menu_status($menuid, $status)
{
    global $xoopsDB;
    $sql = 'update ' . $xoopsDB->prefix('tad_themes_menu') . " set  `status` = '$status' where menuid='$menuid'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
}

//刪除圖片
function del_pic($type, $menuid)
{
    if ('icon' === $type) {
        $dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_icons';
        $file1 = "{$dir}/{$menuid}_64.png";
        $file2 = "{$dir}/{$menuid}_32.png";
    } elseif ('banner' === $type) {
        $dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_banner';
        $file1 = "{$dir}/{$menuid}.png";
        $file2 = "{$dir}/{$menuid}_thumb.png";
    }

    if (file_exists($file1)) {
        unlink($file1);
    }

    if (file_exists($file2)) {
        unlink($file2);
    }
}

/*-----------執行動作判斷區----------*/
require_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$menuid = system_CleanVars($_REQUEST, 'menuid', 0, 'int');
$of_level = system_CleanVars($_REQUEST, 'of_level', 0, 'int');
$status = system_CleanVars($_REQUEST, 'status', 1, 'int');
$type = system_CleanVars($_REQUEST, 'type', '', 'string');

switch ($op) {
    //更新資料
    case 'update_tad_themes_menu':
        update_tad_themes_menu($menuid);
        header("location: {$_SERVER['PHP_SELF']}#{$menuid}");
        exit;

    //新增資料
    case 'insert_tad_themes_menu':
        insert_tad_themes_menu();
        header("location: {$_SERVER['PHP_SELF']}#{$menuid}");
        exit;

    //刪除資料
    case 'delete_tad_themes_menu':
        delete_tad_themes_menu($menuid);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //新增項目
    case 'add_tad_themes_menu':
        tad_themes_menu_form($of_level, $menuid, 'die');
        break;
    //儲存排序
    case 'save_sort':
        save_sort();
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //修改項目
    case 'modify_tad_themes_menu':
        tad_themes_menu_form($of_level, $menuid, 'die');
        break;
    //修改項目
    case 'import':
        auto_import();
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    case 'tad_themes_menu_status':
        tad_themes_menu_status($menuid, $status);
        header("location: {$_SERVER['PHP_SELF']}#{$menuid}");
        exit;

    case 'del_pic':
        del_pic($type, $menuid);
        header("location: {$_SERVER['PHP_SELF']}#{$menuid}");
        exit;

    //預設動作
    default:
        list_tad_themes_menu();
        break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('now_op', $op);
$xoTheme->addStylesheet(XOOPS_URL . '/modules/tad_themes/css/module.css');
require_once __DIR__ . '/footer.php';
