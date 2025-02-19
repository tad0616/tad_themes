<?php
use Xmf\Request;
use XoopsModules\Tadtools\FancyBox;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\TreeTable;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = 'tad_themes_adm_dropdown.tpl';
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';

/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$type = Request::getString('type');
$menuid = Request::getInt('menuid');
$of_level = Request::getInt('of_level');
$status = Request::getInt('status', 1);

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

    //會入主選單
    case 'import':
        auto_import();
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //匯入編輯功能選項
    case 'import_edit':
        import_edit();
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
require_once __DIR__ . '/footer.php';

/*-----------function區--------------*/
//tad_themes_menu編輯表單
function tad_themes_menu_form($of_level = '0', $menuid = '', $mode = 'return')
{
    global $xoopsTpl, $xoopsLogger;
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
    $status = (!isset($DBV['status'])) ? '' : $DBV['status'];
    $target = (!isset($DBV['target'])) ? '' : $DBV['target'];
    $icon = (!isset($DBV['icon'])) ? '' : $DBV['icon'];
    $read_group = (!isset($DBV['read_group'])) ? [1, 2, 3] : $DBV['read_group'];
    $read_group_array = is_string($read_group) ? explode(',', $read_group) : $read_group;
    $xoopsTpl->assign('icon', $icon);
    Utility::add_migrate();

    $SelectGroup_name = new \XoopsFormSelectGroup('read_group', 'read_group', true, $read_group_array, 4, true);
    $SelectGroup_name->setExtra("class='form-control' id='read_group'");
    $enable_group = $SelectGroup_name->render();

    $op = (empty($menuid)) ? 'insert_tad_themes_menu' : 'update_tad_themes_menu';

    $get_tad_all_menu = '';
    if (!empty($menuid)) {
        $get_tad_all_menu = "
          <label class='col-sm-3 control-label col-form-label text-md-right text-md-end'>" . _MA_TADTHEMES_OF_LEVEL . _TAD_FOR . "</label>
          <div class='col-sm-3'>
            <select name='of_level' id='of_level' class='form-control form-select'>
            <option value=''>" . _MA_TADTHEMES_ROOT . '</option>
            ' . get_tad_all_menu('', '', $of_level, $menuid, '1') . '
            </select>
          </div>
        ';
    } else {
        $get_tad_all_menu = "<input type='hidden' name='of_level' value='{$of_level}'>";
    }

    $apply_enable_group = '';
    if (!empty($menuid)) {
        $apply_enable_group = "
        <div class='form-group row mb-3'>
            <label class='col-sm-3 control-label col-form-label text-md-right text-md-end' for='itemurl'>" . _MA_TADTHEMES_APPLY_READGROUP . _TAD_FOR . "</label>
            <div class='col-sm-9'>
                <input type='radio' name='apply_enable_group' value='1' checked> " . _YES . "
                <input type='radio' name='apply_enable_group' value='0'> " . _NO . "
            </div>
        </div>
        ";
    }

    $main = "
    <form method='post' id='myForm' enctype='multipart/form-data' class='form-horizontal' role='form'>
        <div class='form-group row mb-3'>
            <label class='col-sm-3 control-label col-form-label text-md-right text-md-end' for='icon'>" . _MA_TADTHEMES_ICON . _TAD_FOR . "</label>
            <div class='col-sm-3'>
                <input name='icon' class='selectpicker form-control' value='{$icon}' type='text'>
            </div>
            $get_tad_all_menu
        </div>


        <div class='form-group row mb-3'>
            <label class='col-sm-3 control-label col-form-label text-md-right text-md-end' for='itemname'>" . _MA_TADTHEMES_ITEMNAME . _TAD_FOR . "</label>
            <div class='col-sm-9'>
                <input type='text' name='itemname' id='itemname' value='{$itemname}' class='form-control' placeholder='" . _MA_TADTHEMES_ITEMNAME . "'>
            </div>
        </div>

        <div class='form-group row mb-3'>
            <label class='col-sm-3 control-label col-form-label text-md-right text-md-end' for='itemurl'>" . _MA_TADTHEMES_ITEMURL . _TAD_FOR . "</label>
            <div class='col-sm-6'>
                <input type='text' name='itemurl' id='itemurl' value='{$itemurl}' class='form-control' placeholder='" . _MA_TADTHEMES_ITEMURL . "'>
            </div>
            <div class='col-sm-3'>
                <select name='target' class='form-control form-select'>
                    <option value='_self'></option>
                    <option value='_blank' " . Utility::chk($target, '_blank', 0, 'selected') . '>' . _MA_TADTHEMES_TARGET_BLANK . "</option>
                    <option value='popup' " . Utility::chk($target, 'popup', 0, 'selected') . '>' . _MA_TADTHEMES_TARGET_FANCYBOX . "</option>
                </select>
            </div>
        </div>

        <div class='form-group row mb-3'>
            <label class='col-sm-3 control-label col-form-label text-md-right text-md-end' for='itemurl'>" . _MA_TADTHEMES_READGROUP . _TAD_FOR . "</label>
            <div class='col-sm-9'>
                {$enable_group}
            </div>
        </div>

        $apply_enable_group

        <div class='form-group row mb-3'>
            <label class='col-sm-3 control-label col-form-label text-md-right text-md-end' for='image'>" . _MA_TADTHEMES_ITEMICON . _TAD_FOR . "</label>
            <div class='col-sm-8'>
                <input type='file' name='image' id='image'>
            </div>
        </div>

        <div class='form-group row mb-3'>
            <label class='col-sm-3 control-label col-form-label text-md-right text-md-end' for='banner_image'>" . _MA_TADTHEMES_ITEMBANNER . _TAD_FOR . "</label>
            <div class='col-sm-8'>
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
        header('HTTP/1.1 200 OK');
        $xoopsLogger->activated = false;
        $migrate = Utility::add_migrate('return');
        $main2 = "<!DOCTYPE html>
        <html lang='zh-TW'>
            <head>
                <meta charset='utf-8'>
                <title></title>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <link rel='stylesheet' type='text/css' media='screen' href='" . XOOPS_URL . "/modules/tadtools/bootstrap5/css/bootstrap.css'>

                <link rel='stylesheet' type='text/css' media='screen' href='" . XOOPS_URL . "/modules/tadtools/css/xoops_adm5.css'>
                <link href='" . XOOPS_URL . "/modules/tadtools/css/fontawesome6/css/all.min.css' rel='stylesheet'>

                <script src='" . XOOPS_URL . "/browse.php?Frameworks/jquery/jquery.js' type='text/javascript'></script>
                <script src='" . XOOPS_URL . "/modules/tadtools/bootstrap5/js/bootstrap.min.js'></script>
                $migrate
                <link href='" . XOOPS_URL . "/modules/tad_themes/class/simple-fontawesome-iconpicker/simple-iconpicker.min.css' rel='stylesheet'>
                <script src='" . XOOPS_URL . "/modules/tad_themes/class/simple-fontawesome-iconpicker/simple-iconpicker.min.js'></script>
            </head>
            <body>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-sm-12'>
                            $main
                        </div>
                    </div>
                </div>
                <script type='text/javascript'>
                    $(document).ready(function(){
                    $('.selectpicker').iconpicker('.selectpicker');
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

//自動取得新排序
function get_max_sort($of_level = '')
{
    global $xoopsDB;
    $sql = 'SELECT MAX(`position`) FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `of_level`=?';
    $result = Utility::query($sql, 'i', [$of_level]) or Utility::web_error($sql, __FILE__, __LINE__);

    list($sort) = $xoopsDB->fetchRow($result);

    return ++$sort;
}

//新增資料到tad_themes_menu中
function insert_tad_themes_menu()
{
    global $xoopsDB;

    $of_level = (int) $_POST['of_level'];
    $position = (int) $_POST['position'];
    $read_group = implode(',', $_POST['read_group']);

    $sql = 'INSERT INTO `' . $xoopsDB->prefix('tad_themes_menu') . '` (`of_level`, `position`, `itemname`, `itemurl`, `status`, `target`, `icon`, `read_group`) VALUES (?, ?, ?, ?, 1, ?, ?, ?)';
    Utility::query($sql, 'iisssss', [$of_level, $position, $_POST['itemname'], $_POST['itemurl'], $_POST['target'], $_POST['icon'], $read_group]) or Utility::web_error($sql, __FILE__, __LINE__);

    //取得最後新增資料的流水編號
    $menuid = $xoopsDB->getInsertId();

    //處理上傳的檔案
    if (!empty($_FILES['image']['name'])) {
        $dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_icons';
        Utility::mk_dir($dir);
        $filename = $_FILES['image']['tmp_name'];
        $thumb_name1 = "{$dir}/{$menuid}_64.png";
        Utility::generateThumbnail($filename, $thumb_name1, 64);
        $thumb_name2 = "{$dir}/{$menuid}_32.png";
        Utility::generateThumbnail($filename, $thumb_name2, 32);
    }

    if (!empty($_FILES['banner_image']['name'])) {
        $dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_banner';
        Utility::mk_dir($dir);
        $filename = $_FILES['banner_image']['tmp_name'];
        $destination = "{$dir}/{$menuid}.png";
        $thumb = "{$dir}/{$menuid}_thumb.png";
        move_uploaded_file($filename, $destination);
        Utility::generateThumbnail($destination, $thumb, 120);
    }

    return $menuid;
}

//列出所有tad_themes_menu資料
function list_tad_themes_menu($add_of_level = '', $menuid = '')
{
    global $xoopsDB, $xoopsModule, $xoopsTpl, $xoTheme;

    $all = get_tad_level_menu(0, 0, $menuid, '', $add_of_level);

    $option = '';
    $jquery = Utility::get_jquery(true);

    $xoopsTpl->assign('jquery', $jquery);
    $xoopsTpl->assign('all', $all);
    $xoopsTpl->assign('option', $option);
    $xoopsTpl->assign('add_item', sprintf(_MA_TADTHEMES_ADDITEM, _MA_TADTHEMES_ROOT));

    $TreeTable = new TreeTable(false, 'menuid', 'of_level', '#tbl', 'save_drag.php', '.folder', '#save_msg', true, '.sort', 'save_sort.php', '#save_msg');
    $TreeTable->render();

    $FancyBox = new FancyBox('.edit_dropdown', '800', '500');
    $FancyBox->render();

    $xoTheme->addStylesheet('modules/tadtools/css/fontawesome6/css/all.min.css');
    $xoTheme->addScript('modules/tadtools/bootstrap3/js/bootstrap.js');
}

//取得分類項目
function get_tad_level_menu($of_level = 0, $level = 0, $v = '', $this_menuid = '', $add_of_level = '0', $parent_position = '')
{
    global $xoopsDB;
    $btn_xs = 4 == $_SESSION['bootstrap'] ? 'btn-sm' : 'btn-xs';
    $left = $level * 30;
    $font_size = 1.2 - ($level * 0.2);
    $icon_size = 1.3 - ($level * 0.2);
    $level += 1;

    $left = (empty($left)) ? 4 : $left;

    $option = '';

    $sql = 'SELECT `menuid`,`of_level`,`itemname`,`position`,`itemurl`,`status`,`target`,`icon`,`link_cate_name`, `link_cate_sn` FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `of_level`=? ORDER BY `position`';
    $result = Utility::query($sql, 'i', [$of_level]) or Utility::web_error($sql, __FILE__, __LINE__);

    $dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_icons';
    $banner_dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_banner';
    $url = XOOPS_URL . '/uploads/tad_themes/menu_icons';
    $banner_url = XOOPS_URL . '/uploads/tad_themes/menu_banner';

    $SweetAlert = new SweetAlert();

    while (list($menuid, $of_level, $itemname, $position, $itemurl, $status, $target, $icon, $link_cate_name, $link_cate_sn) = $xoopsDB->fetchRow($result)) {
        if (strpos($icon, 'fab ') === false) {
            $icon = "fa {$icon}";
        }

        $item = (empty($itemurl)) ? "<i class='{$icon}'></i> " . $itemname : "<a name='$menuid' href='{$itemurl}'><i class='{$icon}'></i> $itemname</a>";

        $add_img = ($level >= 3) ? '' : "<a href='{$_SERVER['PHP_SELF']}?op=add_tad_themes_menu&of_level={$menuid}' class='edit_dropdown' data-fancybox-type='iframe' style='font-size: {$icon_size}rem; margin: 2px 10px;'><i class='fa fa-plus-circle text-success' aria-hidden='true' title='" . sprintf(_MA_TADTHEMES_ADDITEM, $itemname) . "'></i></a>";

        $status_tool = ('1' == $status) ? "<a href='{$_SERVER['PHP_SELF']}?op=tad_themes_menu_status&menuid=$menuid&status=0' class='btn $btn_xs btn-warning'>" . _TAD_UNABLE . '</a>' : "<a href='{$_SERVER['PHP_SELF']}?op=tad_themes_menu_status&menuid=$menuid&status=1' class='btn $btn_xs btn-info'>" . _TAD_ENABLE . '</a>';

        $status_color = ('1' == $status) ? '' : "style='background-color:#D0D0D0'";
        $status_color2 = ('1' == $status) ? '' : 'background-color:#D0D0D0';
        $target_icon = ('_blank' === $target) ? "<span class='badge badge-default' style='padding: 2px 4px;'>" . _MA_TADTHEMES_TARGET_BLANK . '</span>' : '';
        $target_icon = ('popup' === $target) ? "<span class='label label-success' style='padding: 2px 4px;'>popup</span>" : $target_icon;

        $class = (empty($of_level)) ? '' : "class='child-of-node-{$of_level}'";
        $parent = empty($of_level) ? '' : "data-tt-parent-id='$of_level'";

        $icon = '';
        if (file_exists("{$dir}/{$menuid}_32.png")) {
            $SweetAlert->render("delete_tad_themes_icon", "dropdown.php?op=del_pic&type=icon&menuid=", 'menuid');
            $icon = "<a href='{$url}/{$menuid}_32.png' class='edit_dropdown'><img src=\"{$url}/{$menuid}_32.png\"></a><a href=\"javascript:delete_tad_themes_icon($menuid);\"><img src='../images/delete.png'></a>";
        }
        $banner = '';
        if (file_exists("{$banner_dir}/{$menuid}_thumb.png")) {
            $SweetAlert->render("delete_tad_themes_banner", "dropdown.php?op=del_pic&type=banner&menuid=", 'menuid');
            $banner = "<a href='{$banner_url}/{$menuid}.png' class='edit_dropdown'><img src=\"{$banner_url}/{$menuid}_thumb.png\"></a><a href=\"javascript:delete_tad_themes_banner( $menuid);\"><img src='../images/delete.png'></a>";
        }

        $sort = empty($parent_position) ? $position : "{$parent_position}-{$position}";
        $sub_opt = get_tad_level_menu($menuid, $level, $v, $this_menuid, $add_of_level, $sort);
        $span = $sub_opt ? 'folder' : 'file';

        $SweetAlert->render("delete_tad_themes_menu", "dropdown.php?op=delete_tad_themes_menu&menuid=", 'menuid');

        $content = "
        <td style='padding-left:{$left}px; $status_color2' >
            <a name='menuid_{$menuid}'></a>
            <img src='" . XOOPS_URL . "/modules/tadtools/treeTable/images/move.svg' class='folder' alt='" . _MA_TREETABLE_MOVE_PIC . "' title='" . _MA_TREETABLE_MOVE_PIC . "' style='width:20px;'>
            <img src='" . XOOPS_URL . "/modules/tadtools/treeTable/images/updown_s.svg' style='width:20px; cursor: s-resize;margin:0px 4px;' alt='" . _MA_TADTHEMES_SAVE_SORT . "' title='" . _MA_TADTHEMES_SAVE_SORT . "({$sort})' >
            <span style='font-size:{$font_size}rem;' class='$span'>{$item}</span>
            $target_icon
            $add_img
            </td>
            <td $status_color>
            <a href=\"javascript:delete_tad_themes_menu($menuid);\" title='" . _TAD_DEL . "' style='font-size: 1rem; color:red;'><i class=\"fa fa-times-circle\" aria-hidden=\"true\"></i>
            </a>
            $status_tool
            <a href='{$_SERVER['PHP_SELF']}?op=modify_tad_themes_menu&menuid=$menuid#menuid_{$menuid}' class='btn $btn_xs btn-success edit_dropdown' data-fancybox-type='iframe'>" . _TAD_EDIT . "</a>

            $icon
            $banner
        </td>";

        $option .= "
        <tr data-tt-id='{$menuid}' $parent id='node-_{$menuid}' $class style='letter-spacing: 0em;'>
        $content
        </tr>";

        $option .= $sub_opt;

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

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `menuid`=?';
    $result = Utility::query($sql, 'i', [$menuid]) or Utility::web_error($sql, __FILE__, __LINE__);

    $data = $xoopsDB->fetchArray($result);

    return $data;
}

//更新tad_themes_menu某一筆資料
function update_tad_themes_menu($menuid = '')
{
    global $xoopsDB;

    $of_level = (int) $_POST['of_level'];
    $position = (int) $_POST['position'];
    $status = (int) $_POST['status'];
    $apply_enable_group = (int) $_POST['apply_enable_group'];
    $read_group = implode(',', $_POST['read_group']);

    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes_menu') . '` SET `of_level` = ?, `position` = ?, `itemname` = ?, `itemurl` = ?, `status` = ?, `target` = ?, `icon` = ?, `read_group` = ? WHERE `menuid` = ?';
    Utility::query($sql, 'iississsi', [$of_level, $position, $_POST['itemname'], $_POST['itemurl'], $status, $_POST['target'], $_POST['icon'], $read_group, $menuid]) or Utility::web_error($sql, __FILE__, __LINE__);

    if ($apply_enable_group) {
        $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes_menu') . '` SET `read_group`=? WHERE `of_level`=?';
        Utility::query($sql, 'si', [$read_group, $menuid]) or Utility::web_error($sql, __FILE__, __LINE__);

    }

    //處理上傳的檔案
    if (!empty($_FILES['image']['name'])) {
        $dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_icons';
        Utility::mk_dir($dir);
        $filename = $_FILES['image']['tmp_name'];
        $thumb_name1 = "{$dir}/{$menuid}_64.png";
        Utility::generateThumbnail($filename, $thumb_name1, 64);
        $thumb_name2 = "{$dir}/{$menuid}_32.png";
        Utility::generateThumbnail($filename, $thumb_name2, 32);
    }

    if (!empty($_FILES['banner_image']['name'])) {
        $dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_banner';
        Utility::mk_dir($dir);
        $filename = $_FILES['banner_image']['tmp_name'];
        $destination = "{$dir}/{$menuid}.png";
        $thumb = "{$dir}/{$menuid}_thumb.png";
        move_uploaded_file($filename, $destination);
        Utility::generateThumbnail($destination, $thumb, 120);
    }

    return $menuid;
}

//刪除tad_themes_menu某筆資料資料
function delete_tad_themes_menu($menuid = '')
{
    global $xoopsDB;
    $sql = 'DELETE FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `menuid`=? OR `of_level`=?';
    Utility::query($sql, 'ii', [$menuid, $menuid]) or Utility::web_error($sql, __FILE__, __LINE__);

}

//取得分類下拉選單
function get_tad_all_menu($of_level = 0, $level = 0, $v = '', $this_menuid = '', $no_self = '1')
{
    global $xoopsDB;

    $level = intval($level);
    if ($level >= 2) {
        return;
    }

    $left = $level * 3;
    $blank = str_repeat('&nbsp;', $left);
    $level += 1;

    $option = '';

    $sql = 'SELECT `menuid`, `of_level`, `itemname` FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `of_level` =? ORDER BY `position`';
    $result = Utility::query($sql, 'i', [$of_level]) or Utility::web_error($sql, __FILE__, __LINE__);

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
        $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes_menu') . '` SET `position` = ? WHERE `menuid` = ?';
        Utility::query($sql, 'si', [$position, $menuid]) or Utility::web_error($sql, __FILE__, __LINE__);

    }
}

//自動匯入
function auto_import()
{
    global $xoopsDB;

    $sql = 'SELECT `menuid` FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `link_cate_name`=?';
    $result = Utility::query($sql, 's', ['mainmenu']) or Utility::web_error($sql, __FILE__, __LINE__);

    list($menuid) = $xoopsDB->fetchRow($result);

    if (empty($menuid)) {
        $position = get_max_sort(0);
        $sql = 'INSERT INTO `' . $xoopsDB->prefix('tad_themes_menu') . '` (`of_level`, `position`, `itemname`, `itemurl`, `status`, `icon`, `link_cate_name`) VALUES (0, ?, ?, ?, 1, ?, ?)';
        Utility::query($sql, 'sssss', [$position, _MA_TADTHEMES_WEB_MENU, '#', '', 'mainmenu']) or Utility::web_error($sql, __FILE__, __LINE__);

        //取得最後新增資料的流水編號
        $of_level = $xoopsDB->getInsertId();

        $sql = 'SELECT `name`, `dirname` FROM `' . $xoopsDB->prefix('modules') . '` WHERE `isactive`=1 AND `hasmain`=1 ORDER BY `weight`';
        $result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        while (list($name, $dirname) = $xoopsDB->fetchRow($result)) {
            $position = get_max_sort($of_level);
            $sql = 'INSERT INTO `' . $xoopsDB->prefix('tad_themes_menu') . '` (`of_level`, `position`, `itemname`, `itemurl`, `status`, `icon`) VALUES (?, ?, ?, ?, 1, ?)';
            Utility::query($sql, 'issss', [$of_level, $position, $name, XOOPS_URL . '/modules/' . $dirname . '/', '']) or Utility::web_error($sql, __FILE__, __LINE__);

        }
    }
}

// 匯入編輯選項
function import_edit()
{
    global $xoopsDB;

    $sql = 'SELECT `menuid` FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `link_cate_name` = ?';
    $result = Utility::query($sql, 's', ['editemnu']) or Utility::web_error($sql, __FILE__, __LINE__);

    list($of_level) = $xoopsDB->fetchRow($result);

    if (empty($of_level)) {
        $position = get_max_sort(0);
        $sql = 'INSERT INTO `' . $xoopsDB->prefix('tad_themes_menu') . '` (`of_level`, `position`, `itemname`, `itemurl`, `status`, `icon`, `link_cate_name`, `read_group`) VALUES (0, ?, ?, "#", 1, "", "editemnu", 1)';
        Utility::query($sql, 'is', [$position, _MA_TADTHEMES_EDIT_MENU]) or Utility::web_error($sql, __FILE__, __LINE__);

        //取得最後新增資料的流水編號
        $of_level = $xoopsDB->getInsertId();
    }

    // 個模組的編輯連結
    $mod_posts['tadnews'] = ['title' => _MA_TADTHEMES_EDIT_MENU_TADNEWS, 'url' => '/modules/tadnews/post.php'];
    $mod_posts['tadgallery'] = ['title' => _MA_TADTHEMES_EDIT_MENU_TADGALLERY, 'url' => '/modules/tadgallery/uploads.php'];
    $mod_posts['tad_link'] = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_LINK, 'url' => '/modules/tad_link/index.php?op=tad_link_form'];
    $mod_posts['tad_honor'] = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_HONOR, 'url' => '/modules/tad_honor/index.php?op=tad_honor_form'];
    $mod_posts['tad_uploader'] = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_UPLOADER, 'url' => '/modules/tad_uploader/uploads.php'];
    $mod_posts['tad_timeline'] = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_TIMELINE, 'url' => '/modules/tad_timeline/index.php?op=tad_timeline_form'];
    $mod_posts['tad_meeting'] = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_MEETING, 'url' => '/modules/tad_meeting/index.php?op=tad_meeting_form'];
    $mod_posts['tad_book3'] = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_TADBOOK3, 'url' => '/modules/tad_book3/index.php?op=tad_book3_form'];
    $mod_posts['tad_cal'] = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_CAL, 'url' => '/modules/tad_cal/event.php'];
    $mod_posts['tad_faq'] = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_FAQ, 'url' => '/modules/tad_faq/index.php?op=tad_faq_content_form'];
    $mod_posts['tad_player'] = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_PLAYER, 'url' => '/modules/tad_player/uploads.php'];
    $mod_posts['tad_repair'] = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_REPAIR, 'url' => '/modules/tad_repair/repair.php'];
    $mod_posts['tad_blocks'] = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_BLOCKS, 'url' => '/modules/tad_blocks/index.php?op=block_form#block_setup'];
    $mod_posts['tad_gphotos'] = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_GPHOTOS, 'url' => '/modules/tad_gphotos/index.php?op=tad_gphotos_form'];
    $mod_posts['tad_form'] = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_FORM, 'url' => '/modules/tad_form/add.php'];
    $mod_posts['jill_notice'] = ['title' => _MA_TADTHEMES_EDIT_MENU_JILL_NOTICE, 'url' => '/modules/jill_notice/index.php?op=notice_form'];
    $mod_posts['jill_booking'] = ['title' => _MA_TADTHEMES_EDIT_MENU_JILL_BOOKING, 'url' => '/modules/jill_booking/index.php'];
    $mod_posts['kw_device'] = ['title' => _MA_TADTHEMES_EDIT_MENU_KW_DEVICE, 'url' => '/modules/modules/index.php'];
    $mod_posts['tad_assignment'] = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_ASSIGNMENT, 'url' => '/modules/tad_assignment/admin/add.php'];

    //已在資料庫的選項
    $old_items = [];
    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `of_level` =? AND `link_cate_name` !=?';
    $result = Utility::query($sql, 'is', [$of_level, '']) or Utility::web_error($sql, __FILE__, __LINE__);

    while ($item = $xoopsDB->fetchArray($result)) {
        $dirname = $item['link_cate_name'];
        $old_items[$dirname] = $item;
    }

    $old_items_arr = array_keys($old_items);
    $mod_arr = array_keys($mod_posts);

    $sql = 'DELETE FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `of_level` = ? AND `link_cate_name` != ?';
    Utility::query($sql, 'is', [$of_level, '']) or Utility::web_error($sql, __FILE__, __LINE__);

    $sql = 'SELECT `dirname` FROM `' . $xoopsDB->prefix('modules') . '` WHERE `isactive`=1 AND `hasmain`=1 ORDER BY `weight`';
    $result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    while (list($dirname) = $xoopsDB->fetchRow($result)) {
        if (in_array($dirname, $mod_arr)) {
            $position = get_max_sort($of_level);
            if (in_array($dirname, $old_items_arr)) {
                $title = $old_items[$dirname]['itemname'];
                $status = $old_items[$dirname]['status'];
                $icon = $old_items[$dirname]['icon'];
                $read_group = $old_items[$dirname]['read_group'];
            } else {
                $title = $mod_posts[$dirname]['title'];
                $status = 1;
                $icon = '';
                $read_group = '1';
            }

            $sql = 'INSERT INTO `' . $xoopsDB->prefix('tad_themes_menu') . '` (`of_level`, `position`, `itemname`, `itemurl`, `status`, `icon`, `link_cate_name`, `read_group`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
            Utility::query($sql, 'iissssss', [$of_level, $position, $title, XOOPS_URL . $mod_posts[$dirname]['url'], $status, $icon, $dirname, $read_group]) or Utility::web_error($sql, __FILE__, __LINE__);

        }
    }
}

function tad_themes_menu_status($menuid, $status)
{
    global $xoopsDB;

    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes_menu') . '` SET `status` = ? WHERE `menuid` = ?';
    Utility::query($sql, 'si', [$status, $menuid]) or Utility::web_error($sql, __FILE__, __LINE__);

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
