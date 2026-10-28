<?php

use Xmf\Request;
use XoopsModules\Tadtools\FancyBox;
use XoopsModules\Tadtools\SweetAlert2;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_themes\Tools;
/*-----------引入檔案區--------------*/

$xoopsOption['template_main'] = 'tad_themes_adm_dropdown.tpl';
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';

/*-----------執行動作判斷區----------*/
$op       = Request::getString('op');
$type     = Request::getString('type');
$menuid   = Request::getInt('menuid');
$of_level = Request::getInt('of_level');
$status   = Request::getInt('status', 1);

// 會異動資料的動作一律限 POST 並驗證 Token（使用後即作廢）
$token_ops = ['update_tad_themes_menu', 'insert_tad_themes_menu', 'delete_tad_themes_menu', 'save_tree', 'import', 'import_edit', 'tad_themes_menu_status', 'del_pic'];
if (in_array($op, $token_ops, true)) {
    if ('POST' !== $_SERVER['REQUEST_METHOD'] || !$GLOBALS['xoopsSecurity']->check()) {
        redirect_header('dropdown.php', 3, _TAD_PERMISSION_DENIED);
    }
}

// 同一頁共用一組 Token，避免產生過多 session 資料
function menu_token()
{
    static $token = null;
    if (null === $token) {
        $token = $GLOBALS['xoopsSecurity']->createToken();
    }

    return $token;
}

// HTML 輸出跳脫
function h($str)
{
    return htmlspecialchars((string) $str, ENT_QUOTES, 'UTF-8');
}

// 連結僅允許相對路徑、#、http(s)、mailto、tel，擋掉 javascript: 等危險協定
function safe_menu_url($url)
{
    $url = trim(strip_tags((string) $url));
    $url = preg_replace('/[\x00-\x1F\x7F]/', '', $url);
    if ('' === $url) {
        return '';
    }
    if (preg_match('/^([a-z][a-z0-9+.\-]*):/i', $url, $m) && !in_array(strtolower($m[1]), ['http', 'https', 'mailto', 'tel'], true)) {
        return '';
    }

    return mb_substr($url, 0, 255);
}

// 圖示僅允許 FontAwesome class 名稱
function safe_menu_icon($icon)
{
    $icon = trim((string) $icon);

    return preg_match('/^[A-Za-z0-9 _\-]{0,100}$/', $icon) ? $icon : '';
}

function safe_menu_target($target)
{
    return in_array($target, ['_blank', 'popup'], true) ? $target : '_self';
}

// 檢查 $to_id 是否為 $menuid 本身或其子孫（避免把選單移到自己底下造成迴圈）
function is_menu_descendant($menuid, $to_id)
{
    global $xoopsDB;
    $menuid = (int) $menuid;
    $to_id  = (int) $to_id;
    if (!$to_id) {
        return false;
    }
    if ($menuid === $to_id) {
        return true;
    }
    $seen = [];
    while ($to_id && !isset($seen[$to_id])) {
        $seen[$to_id] = true;
        $sql          = 'SELECT `of_level` FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `menuid`=?';
        $result       = Utility::query($sql, 'i', [$to_id]) or Utility::web_error($sql, __FILE__, __LINE__);
        $to_id        = (int) ($xoopsDB->fetchRow($result)[0] ?? 0);
        if ($to_id === $menuid) {
            return true;
        }
    }

    return false;
}

// 整理表單送出的共用欄位
function get_menu_post_values()
{
    $read_group = array_values(array_unique(array_filter(array_map('intval', (array) ($_POST['read_group'] ?? [])))));

    return [
        'itemname'   => mb_substr(trim(strip_tags((string) ($_POST['itemname'] ?? ''))), 0, 255),
        'itemurl'    => safe_menu_url($_POST['itemurl'] ?? ''),
        'target'     => safe_menu_target($_POST['target'] ?? ''),
        'icon'       => safe_menu_icon($_POST['icon'] ?? ''),
        'read_group' => $read_group ? implode(',', $read_group) : '1',
    ];
}

// 驗證上傳圖片（必須是真正的 jpg/png/gif/webp，且不得超過 2MB）
function is_valid_menu_image($file)
{
    if (!isset($file['tmp_name'], $file['error']) || UPLOAD_ERR_OK !== $file['error'] || !is_uploaded_file($file['tmp_name'])) {
        return false;
    }
    if ($file['size'] > 2 * 1024 * 1024) {
        return false;
    }
    $info = @getimagesize($file['tmp_name']);

    return $info && in_array($info[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP], true);
}

// 處理選單圖示及橫幅上傳
function save_menu_images($menuid)
{
    $menuid = (int) $menuid;
    if (!empty($_FILES['image']['name']) && is_valid_menu_image($_FILES['image'])) {
        $dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_icons';
        Utility::mk_dir($dir);
        Utility::generateThumbnail($_FILES['image']['tmp_name'], "{$dir}/{$menuid}_64.png", 64);
        Utility::generateThumbnail($_FILES['image']['tmp_name'], "{$dir}/{$menuid}_32.png", 32);
    }

    if (!empty($_FILES['banner_image']['name']) && is_valid_menu_image($_FILES['banner_image'])) {
        $dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_banner';
        Utility::mk_dir($dir);
        $destination = "{$dir}/{$menuid}.png";
        if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $destination)) {
            Utility::generateThumbnail($destination, "{$dir}/{$menuid}_thumb.png", 120);
        }
    }
}

switch ($op) {
    //更新資料
    case 'update_tad_themes_menu':
        update_tad_themes_menu($menuid);
        Tools::del_theme_json($xoopsConfig['theme_set']);
        header('Location: dropdown.php#menuid_' . $menuid);
        exit;

    //新增資料
    case 'insert_tad_themes_menu':
        $new_menuid = insert_tad_themes_menu();
        Tools::del_theme_json($xoopsConfig['theme_set']);
        header('Location: dropdown.php#menuid_' . (int) $new_menuid);
        exit;

    //刪除資料
    case 'delete_tad_themes_menu':
        delete_tad_themes_menu($menuid);
        Tools::del_theme_json($xoopsConfig['theme_set']);
        header('Location: dropdown.php');
        exit;

    //新增項目
    case 'add_tad_themes_menu':
        tad_themes_menu_form($of_level, 0, 'die');
        break;
    //儲存排序
    case 'save_tree':
        $ok = save_tree();
        Tools::del_theme_json($xoopsConfig['theme_set']);
        redirect_header('dropdown.php', 2, $ok ? _TAD_SORTED : _TAD_SORT_FAIL);
        exit;

    //修改項目
    case 'modify_tad_themes_menu':
        tad_themes_menu_form($of_level, $menuid, 'die');
        break;

    //會入主選單
    case 'import':
        auto_import();
        Tools::del_theme_json($xoopsConfig['theme_set']);
        header('Location: dropdown.php');
        exit;

    //匯入編輯功能選項
    case 'import_edit':
        import_edit();
        Tools::del_theme_json($xoopsConfig['theme_set']);
        header('Location: dropdown.php');
        exit;

    case 'tad_themes_menu_status':
        tad_themes_menu_status($menuid, $status);
        Tools::del_theme_json($xoopsConfig['theme_set']);
        header('Location: dropdown.php#menuid_' . $menuid);
        exit;

    case 'del_pic':
        del_pic($type, $menuid);
        header('Location: dropdown.php#menuid_' . $menuid);
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

    $menuid           = (!isset($DBV['menuid'])) ? $menuid : $DBV['menuid'];
    $of_level         = (!isset($DBV['of_level'])) ? $of_level : $DBV['of_level'];
    $position         = (!isset($DBV['position'])) ? get_max_sort($of_level) : $DBV['position'];
    $itemname         = (!isset($DBV['itemname'])) ? '' : $DBV['itemname'];
    $itemurl          = (!isset($DBV['itemurl'])) ? '' : $DBV['itemurl'];
    $status           = (!isset($DBV['status'])) ? '' : $DBV['status'];
    $target           = (!isset($DBV['target'])) ? '' : $DBV['target'];
    $icon             = (!isset($DBV['icon'])) ? '' : $DBV['icon'];
    $read_group       = (!isset($DBV['read_group'])) ? [1, 2, 3] : $DBV['read_group'];
    $read_group_array = is_string($read_group) ? explode(',', $read_group) : $read_group;
    $menuid           = (int) $menuid;
    $of_level         = (int) $of_level;
    $position         = (int) $position;
    $status           = (int) $status;
    $icon_h           = h($icon);
    $itemname_h       = h($itemname);
    $itemurl_h        = h($itemurl);
    $xoopsTpl->assign('icon', $icon_h);
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
                <input name='icon' class='selectpicker form-control' value='{$icon_h}' type='text' maxlength='100'>
            </div>
            $get_tad_all_menu
        </div>


        <div class='form-group row mb-3'>
            <label class='col-sm-3 control-label col-form-label text-md-right text-md-end' for='itemname'>" . _MA_TADTHEMES_ITEMNAME . _TAD_FOR . "</label>
            <div class='col-sm-9'>
                <input type='text' name='itemname' id='itemname' value='{$itemname_h}' class='form-control' maxlength='255' placeholder='" . _MA_TADTHEMES_ITEMNAME . "'>
            </div>
        </div>

        <div class='form-group row mb-3'>
            <label class='col-sm-3 control-label col-form-label text-md-right text-md-end' for='itemurl'>" . _MA_TADTHEMES_ITEMURL . _TAD_FOR . "</label>
            <div class='col-sm-6'>
                <input type='text' name='itemurl' id='itemurl' value='{$itemurl_h}' class='form-control' maxlength='255' placeholder='" . _MA_TADTHEMES_ITEMURL . "'>
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
                <input type='file' name='image' id='image' accept='image/png,image/jpeg,image/gif,image/webp'>
            </div>
        </div>

        <div class='form-group row mb-3'>
            <label class='col-sm-3 control-label col-form-label text-md-right text-md-end' for='banner_image'>" . _MA_TADTHEMES_ITEMBANNER . _TAD_FOR . "</label>
            <div class='col-sm-8'>
                <input type='file' name='banner_image' id='banner_image' accept='image/png,image/jpeg,image/gif,image/webp'>
            </div>
        </div>
        <div class='text-center'>
            <input type='hidden' name='menuid' value='{$menuid}'>
            <input type='hidden' name='status' value='{$status}'>
            <input type='hidden' name='XOOPS_TOKEN_REQUEST' value='" . menu_token() . "'>
            <input type='hidden' name='op' value='{$op}'>
            <input type='hidden' name='position' value='{$position}'>
            <button type='button' id='submit' class='btn btn-primary'>" . _TAD_SAVE . '</button>
        </div>

    </form>';

    if ('die' === $mode) {
        header('HTTP/1.1 200 OK');
        $xoopsLogger->activated = false;
        $migrate                = Utility::add_migrate('return');
        $main2                  = "<!DOCTYPE html>
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
                <script src='" . XOOPS_URL . "/modules/tadtools/fontawesome6-picker/fontawesome6-picker.js'></script>
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
                    $('.selectpicker').iconPicker('" . XOOPS_URL . "/modules/tadtools/fontawesome6-picker/', {
                        showIconName: false
                    });

                    $('#myForm').bind('submit', function()
                        {
                        $.ajax({
                            type: 'POST',
                            url: 'dropdown.php',
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
    $sql    = 'SELECT MAX(`position`) FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `of_level`=?';
    $result = Utility::query($sql, 'i', [$of_level]) or Utility::web_error($sql, __FILE__, __LINE__);

    $sort = $xoopsDB->fetchRow($result)[0] ?? null;

    return ++$sort;
}

//新增資料到tad_themes_menu中
function insert_tad_themes_menu()
{
    global $xoopsDB;

    $of_level = (int) ($_POST['of_level'] ?? 0);
    $position = (int) ($_POST['position'] ?? 0);
    $values   = get_menu_post_values();

    $sql = 'INSERT INTO `' . $xoopsDB->prefix('tad_themes_menu') . '` (`of_level`, `position`, `itemname`, `itemurl`, `status`, `target`, `icon`, `read_group`) VALUES (?, ?, ?, ?, 1, ?, ?, ?)';
    Utility::query($sql, 'iisssss', [$of_level, $position, $values['itemname'], $values['itemurl'], $values['target'], $values['icon'], $values['read_group']]) or Utility::web_error($sql, __FILE__, __LINE__);

    //取得最後新增資料的流水編號
    $menuid = $xoopsDB->getInsertId();

    save_menu_images($menuid);

    return $menuid;
}

//列出所有tad_themes_menu資料
function list_tad_themes_menu()
{
    global $xoopsDB, $xoopsModule, $xoopsTpl, $xoTheme;

    $all = get_tad_level_menu(0, 0);

    $jquery = Utility::get_jquery(true);

    $xoopsTpl->assign('jquery', $jquery);
    $xoopsTpl->assign('xoops_token_value', menu_token());
    $xoopsTpl->assign('all', $all);
    $xoopsTpl->assign('add_item', sprintf(_MA_TADTHEMES_ADDITEM, _MA_TADTHEMES_ROOT));

    $SweetAlert2 = new SweetAlert2();
    $SweetAlert2->render();
    $confirm_options = [
        'icon'              => 'warning',
        'title'             => _TAD_DEL_CONFIRM_TITLE,
        'text'              => _TAD_DEL_CONFIRM_TEXT,
        'showCancelButton'  => true,
        'confirmButtonText' => _TAD_DEL_CONFIRM_BTN,
        'cancelButtonText'  => _TAD_CANCEL,
    ];
    $xoopsTpl->assign('delete_confirm_options', json_encode($confirm_options, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT));

    $xoTheme->addScript(XOOPS_URL . '/modules/tad_themes/js/Sortable.min.js');

    $FancyBox = new FancyBox('.edit_dropdown', '800', '500');
    $FancyBox->render();
}

//取得分類項目
function get_tad_level_menu($of_level = 0, $level = 0)
{
    global $xoopsDB;
    $btn_xs    = 4 == $_SESSION['bootstrap'] ? 'btn-sm' : 'btn-xs';
    $font_size = 1.2 - ($level * 0.15);
    $level += 1;

    $option = '';

    $sql    = 'SELECT `menuid`,`of_level`,`itemname`,`position`,`itemurl`,`status`,`target`,`icon` FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `of_level`=? ORDER BY `position`';
    $result = Utility::query($sql, 'i', [$of_level]) or Utility::web_error($sql, __FILE__, __LINE__);

    $dir        = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_icons';
    $banner_dir = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_banner';
    $url        = XOOPS_URL . '/uploads/tad_themes/menu_icons';
    $banner_url = XOOPS_URL . '/uploads/tad_themes/menu_banner';

    while ($row = $xoopsDB->fetchRow($result)) {
        list($menuid, $parent_id, $itemname, $position, $itemurl, $status, $target, $icon) = $row;
        $menuid  = (int) $menuid;
        $enabled = 1 == $status;

        $icon_class = safe_menu_icon($icon);
        $icon_class = (false === strpos($icon_class, 'fab ')) ? "fa {$icon_class}" : $icon_class;
        $name_h     = h($itemname);
        $safe_url   = safe_menu_url($itemurl);

        $item = "<i class='{$icon_class}'></i> <span class='tt-name'>{$name_h}</span>";
        if ($safe_url && '#' !== $safe_url) {
            $item .= " <a href='" . h($safe_url) . "' class='tt-link' target='_blank' rel='noopener noreferrer' title='" . h($safe_url) . "'><i class='fa fa-external-link' aria-hidden='true'></i></a>";
        }

        $target_icon = '';
        if ('_blank' === $target) {
            $target_icon = "<span class='tt-badge tt-badge-info'>" . _MA_TADTHEMES_TARGET_BLANK . '</span>';
        } elseif ('popup' === $target) {
            $target_icon = "<span class='tt-badge tt-badge-success'>popup</span>";
        }

        $add_btn = ($level >= 3) ? '' : "<a href='dropdown.php?op=add_tad_themes_menu&of_level={$menuid}' class='btn $btn_xs btn-outline-success btn-default edit_dropdown' data-fancybox-type='iframe' title='" . h(sprintf(_MA_TADTHEMES_ADDITEM, $itemname)) . "'><i class='fa fa-plus' aria-hidden='true'></i></a>";

        $status_btn = $enabled
        ? "<button type='button' class='btn $btn_xs btn-warning menu-action' data-op='tad_themes_menu_status' data-menuid='{$menuid}' data-status='0'><i class='fa fa-eye-slash' aria-hidden='true'></i> " . _TAD_UNABLE . '</button>'
        : "<button type='button' class='btn $btn_xs btn-info menu-action' data-op='tad_themes_menu_status' data-menuid='{$menuid}' data-status='1'><i class='fa fa-eye' aria-hidden='true'></i> " . _TAD_ENABLE . '</button>';

        $status_badge = $enabled ? "<span class='tt-badge tt-badge-success'>" . _TAD_ENABLE . '</span>' : "<span class='tt-badge tt-badge-muted'>" . _TAD_UNABLE . '</span>';

        $off = $enabled ? '' : ' tt-disabled';

        $icon_html = '';
        if (file_exists("{$dir}/{$menuid}_32.png")) {
            $icon_html = "<span class='tt-thumb'><a href='{$url}/{$menuid}_32.png' target='_blank' rel='noopener'><img src='{$url}/{$menuid}_32.png' alt='icon'></a><button type='button' class='tt-thumb-del menu-action' data-op='del_pic' data-type='icon' data-menuid='{$menuid}' title='" . _TAD_DEL . "'>&times;</button></span>";
        }
        $banner_html = '';
        if (file_exists("{$banner_dir}/{$menuid}_thumb.png")) {
            $banner_html = "<span class='tt-thumb'><a href='{$banner_url}/{$menuid}.png' target='_blank' rel='noopener'><img src='{$banner_url}/{$menuid}_thumb.png' alt='banner'></a><button type='button' class='tt-thumb-del menu-action' data-op='del_pic' data-type='banner' data-menuid='{$menuid}' title='" . _TAD_DEL . "'>&times;</button></span>";
        }

        // 第 3 層（$level 已加 1 後為 3）不再開放子層，其餘層級一律輸出子清單，才能把項目拖進空的父項
        $sub_opt = $level >= 3 ? '' : get_tad_level_menu($menuid, $level);

        $content = "
        <div class='tt-col-name'>
            <span class='tt-toggle' title='toggle'><i class='fa fa-caret-down' aria-hidden='true'></i></span>
            <span class='tt-handle' title='" . _MA_TADTHEMES_SAVE_SORT . "'><i class='fa fa-arrows' aria-hidden='true'></i></span>
            <span id='menuid_{$menuid}' style='font-size:{$font_size}rem;'>{$item}</span>
            {$target_icon}
        </div>
        <div class='tt-col-status'>
            {$status_badge}
            {$icon_html}
            {$banner_html}
        </div>
        <div class='tt-col-action'>
            <div class='tt-actions'>
                <a href='dropdown.php?op=modify_tad_themes_menu&menuid={$menuid}' class='btn $btn_xs btn-success edit_dropdown' data-fancybox-type='iframe'><i class='fa fa-pencil' aria-hidden='true'></i> " . _TAD_EDIT . "</a>
                {$add_btn}
                {$status_btn}
                <button type='button' class='btn $btn_xs btn-danger menu-action' data-op='delete_tad_themes_menu' data-menuid='{$menuid}' data-confirm='1' data-name='{$name_h}' title='" . _TAD_DEL . "'><i class='fa fa-trash' aria-hidden='true'></i></button>
            </div>
        </div>";

        $option .= "
        <li class='tt-item{$off}' data-id='{$menuid}'>
            <div class='tt-row'>{$content}</div>
            {$sub_opt}
        </li>";
    }

    return "<ul class='tt-list' data-level='" . ($level - 1) . "'>{$option}</ul>";
}

//以流水號取得某筆tad_themes_menu資料
function get_tad_themes_menu($menuid = '')
{
    global $xoopsDB;
    if (empty($menuid)) {
        return;
    }

    $sql    = 'SELECT * FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `menuid`=?';
    $result = Utility::query($sql, 'i', [$menuid]) or Utility::web_error($sql, __FILE__, __LINE__);

    $data = $xoopsDB->fetchArray($result);

    return $data;
}

//更新tad_themes_menu某一筆資料
function update_tad_themes_menu($menuid = '')
{
    global $xoopsDB;

    $menuid = (int) $menuid;
    if (!get_tad_themes_menu($menuid)) {
        return $menuid;
    }

    $of_level           = (int) ($_POST['of_level'] ?? 0);
    $position           = (int) ($_POST['position'] ?? 0);
    $status             = (int) ($_POST['status'] ?? 1);
    $apply_enable_group = (int) ($_POST['apply_enable_group'] ?? 0);
    $values             = get_menu_post_values();

    // 不可把選單移到自己或自己的子孫底下
    if (is_menu_descendant($menuid, $of_level)) {
        $old      = get_tad_themes_menu($menuid);
        $of_level = (int) $old['of_level'];
    }

    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes_menu') . '` SET `of_level` = ?, `position` = ?, `itemname` = ?, `itemurl` = ?, `status` = ?, `target` = ?, `icon` = ?, `read_group` = ? WHERE `menuid` = ?';
    Utility::query($sql, 'iississsi', [$of_level, $position, $values['itemname'], $values['itemurl'], $status, $values['target'], $values['icon'], $values['read_group'], $menuid]) or Utility::web_error($sql, __FILE__, __LINE__);

    if ($apply_enable_group) {
        $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes_menu') . '` SET `read_group`=? WHERE `of_level`=?';
        Utility::query($sql, 'si', [$values['read_group'], $menuid]) or Utility::web_error($sql, __FILE__, __LINE__);
    }

    save_menu_images($menuid);

    return $menuid;
}

//刪除tad_themes_menu某筆資料資料（含所有子孫及其圖片）
function delete_tad_themes_menu($menuid = '')
{
    global $xoopsDB;

    $ids   = [(int) $menuid];
    $queue = $ids;
    while ($queue) {
        $parent = array_shift($queue);
        $sql    = 'SELECT `menuid` FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `of_level`=?';
        $result = Utility::query($sql, 'i', [$parent]) or Utility::web_error($sql, __FILE__, __LINE__);
        while ($row = $xoopsDB->fetchRow($result)) {
            $child = (int) $row[0];
            if (!in_array($child, $ids, true)) {
                $ids[]   = $child;
                $queue[] = $child;
            }
        }
    }

    foreach ($ids as $id) {
        if ($id <= 0) {
            continue;
        }
        $sql = 'DELETE FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `menuid`=?';
        Utility::query($sql, 'i', [$id]) or Utility::web_error($sql, __FILE__, __LINE__);
        del_pic('icon', $id);
        del_pic('banner', $id);
    }
}

//取得分類下拉選單
function get_tad_all_menu($of_level = 0, $level = 0, $v = '', $this_menuid = '', $no_self = '1')
{
    global $xoopsDB;

    $level = intval($level);
    if ($level >= 2) {
        return;
    }

    $left  = $level * 3;
    $blank = str_repeat('&nbsp;', $left);
    $level += 1;

    $option = '';

    $sql    = 'SELECT `menuid`, `of_level`, `itemname` FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `of_level` =? ORDER BY `position`';
    $result = Utility::query($sql, 'i', [$of_level]) or Utility::web_error($sql, __FILE__, __LINE__);

    while ($row = $xoopsDB->fetchRow($result)) {
        list($menuid, $of_level, $itemname) = $row;
        if ('1' == $no_self and $this_menuid == $menuid) {
            continue;
        }

        $selected = ($v == $menuid) ? 'selected' : '';
        $color    = ('1' == $level) ? '#330033' : '#990099';
        $option .= "<option value='{$menuid}' style='color:{$color};' $selected>{$blank}" . h($itemname) . '</option>';
        $option .= get_tad_all_menu($menuid, $level, $v, $this_menuid, $no_self);
    }

    return $option;
}

//儲存整棵選單樹（排序與父子關係）。JSON 為巢狀結構：[{"id":1,"children":[{"id":2,"children":[]}]}]
function save_tree()
{
    global $xoopsDB;

    $tree = json_decode((string) ($_POST['tree'] ?? ''), true);
    if (!is_array($tree) || strlen((string) $_POST['tree']) > 200000) {
        return false;
    }

    $max_depth = 3;
    $rows      = [];
    $stack     = [[$tree, 0, 1]];
    while ($stack) {
        list($nodes, $parent, $depth) = array_pop($stack);
        if ($depth > $max_depth || !is_array($nodes)) {
            return false;
        }
        $position = 0;
        foreach ($nodes as $node) {
            $id = is_array($node) && isset($node['id']) ? (int) $node['id'] : 0;
            if ($id <= 0 || isset($rows[$id])) {
                return false;
            }
            $rows[$id] = [$parent, ++$position];
            if (!empty($node['children'])) {
                $stack[] = [$node['children'], $id, $depth + 1];
            }
        }
    }

    if (!$rows) {
        return false;
    }

    // 所有節點必須存在於資料庫
    $ids    = array_keys($rows);
    $marks  = implode(',', array_fill(0, count($ids), '?'));
    $sql    = 'SELECT COUNT(*) FROM `' . $xoopsDB->prefix('tad_themes_menu') . "` WHERE `menuid` IN ($marks)";
    $result = Utility::query($sql, str_repeat('i', count($ids)), $ids) or Utility::web_error($sql, __FILE__, __LINE__);
    if ((int) ($xoopsDB->fetchRow($result)[0] ?? 0) !== count($ids)) {
        return false;
    }

    foreach ($rows as $id => $info) {
        list($parent, $position) = $info;
        $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes_menu') . '` SET `of_level` = ?, `position` = ? WHERE `menuid` = ?';
        Utility::query($sql, 'iii', [$parent, $position, $id]) or Utility::web_error($sql, __FILE__, __LINE__);
    }

    return true;
}

//自動匯入
function auto_import()
{
    global $xoopsDB;

    $sql    = 'SELECT `menuid` FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `link_cate_name`=?';
    $result = Utility::query($sql, 's', ['mainmenu']) or Utility::web_error($sql, __FILE__, __LINE__);

    $menuid = $xoopsDB->fetchRow($result)[0] ?? null;

    if (empty($menuid)) {
        $position = get_max_sort(0);
        $sql      = 'INSERT INTO `' . $xoopsDB->prefix('tad_themes_menu') . '` (`of_level`, `position`, `itemname`, `itemurl`, `status`, `icon`, `link_cate_name`) VALUES (0, ?, ?, ?, 1, ?, ?)';
        Utility::query($sql, 'sssss', [$position, _MA_TADTHEMES_WEB_MENU, '#', '', 'mainmenu']) or Utility::web_error($sql, __FILE__, __LINE__);

        //取得最後新增資料的流水編號
        $of_level = $xoopsDB->getInsertId();

        $sql    = 'SELECT `name`, `dirname` FROM `' . $xoopsDB->prefix('modules') . '` WHERE `isactive`=1 AND `hasmain`=1 ORDER BY `weight`';
        $result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        while ($row = $xoopsDB->fetchRow($result)) {
            list($name, $dirname) = $row;
            $position = get_max_sort($of_level);
            $sql      = 'INSERT INTO `' . $xoopsDB->prefix('tad_themes_menu') . '` (`of_level`, `position`, `itemname`, `itemurl`, `status`, `icon`) VALUES (?, ?, ?, ?, 1, ?)';
            Utility::query($sql, 'issss', [$of_level, $position, $name, XOOPS_URL . '/modules/' . $dirname . '/', '']) or Utility::web_error($sql, __FILE__, __LINE__);
        }
    }
}

// 匯入編輯選項
function import_edit()
{
    global $xoopsDB;

    $sql    = 'SELECT `menuid` FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `link_cate_name` = ?';
    $result = Utility::query($sql, 's', ['editemnu']) or Utility::web_error($sql, __FILE__, __LINE__);

    $of_level = $xoopsDB->fetchRow($result)[0] ?? null;

    if (empty($of_level)) {
        $position = get_max_sort(0);
        $sql      = 'INSERT INTO `' . $xoopsDB->prefix('tad_themes_menu') . '` (`of_level`, `position`, `itemname`, `itemurl`, `status`, `icon`, `link_cate_name`, `read_group`) VALUES (0, ?, ?, "#", 1, "", "editemnu", 1)';
        Utility::query($sql, 'is', [$position, _MA_TADTHEMES_EDIT_MENU]) or Utility::web_error($sql, __FILE__, __LINE__);

        //取得最後新增資料的流水編號
        $of_level = $xoopsDB->getInsertId();
    }

    // 個模組的編輯連結
    $mod_posts['tadnews']        = ['title' => _MA_TADTHEMES_EDIT_MENU_TADNEWS, 'url' => '/modules/tadnews/post.php'];
    $mod_posts['tadgallery']     = ['title' => _MA_TADTHEMES_EDIT_MENU_TADGALLERY, 'url' => '/modules/tadgallery/uploads.php'];
    $mod_posts['tad_link']       = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_LINK, 'url' => '/modules/tad_link/index.php?op=tad_link_form'];
    $mod_posts['tad_honor']      = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_HONOR, 'url' => '/modules/tad_honor/index.php?op=tad_honor_form'];
    $mod_posts['tad_uploader']   = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_UPLOADER, 'url' => '/modules/tad_uploader/uploads.php'];
    $mod_posts['tad_timeline']   = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_TIMELINE, 'url' => '/modules/tad_timeline/index.php?op=tad_timeline_form'];
    $mod_posts['tad_meeting']    = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_MEETING, 'url' => '/modules/tad_meeting/index.php?op=tad_meeting_form'];
    $mod_posts['tad_book3']      = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_TADBOOK3, 'url' => '/modules/tad_book3/index.php?op=tad_book3_form'];
    $mod_posts['tad_cal']        = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_CAL, 'url' => '/modules/tad_cal/event.php'];
    $mod_posts['tad_faq']        = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_FAQ, 'url' => '/modules/tad_faq/index.php?op=tad_faq_content_form'];
    $mod_posts['tad_player']     = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_PLAYER, 'url' => '/modules/tad_player/uploads.php'];
    $mod_posts['tad_repair']     = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_REPAIR, 'url' => '/modules/tad_repair/repair.php'];
    $mod_posts['tad_blocks']     = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_BLOCKS, 'url' => '/modules/tad_blocks/index.php?op=block_form#block_setup'];
    $mod_posts['tad_gphotos']    = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_GPHOTOS, 'url' => '/modules/tad_gphotos/index.php?op=tad_gphotos_form'];
    $mod_posts['tad_form']       = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_FORM, 'url' => '/modules/tad_form/add.php'];
    $mod_posts['jill_notice']    = ['title' => _MA_TADTHEMES_EDIT_MENU_JILL_NOTICE, 'url' => '/modules/jill_notice/index.php?op=notice_form'];
    $mod_posts['jill_booking']   = ['title' => _MA_TADTHEMES_EDIT_MENU_JILL_BOOKING, 'url' => '/modules/jill_booking/index.php'];
    $mod_posts['tad_booking']    = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_BOOKING, 'url' => '/modules/tad_booking/index.php'];
    $mod_posts['kw_device']      = ['title' => _MA_TADTHEMES_EDIT_MENU_KW_DEVICE, 'url' => '/modules/modules/index.php'];
    $mod_posts['tad_assignment'] = ['title' => _MA_TADTHEMES_EDIT_MENU_TAD_ASSIGNMENT, 'url' => '/modules/tad_assignment/admin/add.php'];

    //已在資料庫的選項
    $old_items = [];
    $sql       = 'SELECT * FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `of_level` =? AND `link_cate_name` !=?';
    $result    = Utility::query($sql, 'is', [$of_level, '']) or Utility::web_error($sql, __FILE__, __LINE__);

    while ($item = $xoopsDB->fetchArray($result)) {
        $dirname             = $item['link_cate_name'];
        $old_items[$dirname] = $item;
    }

    $old_items_arr = array_keys($old_items);
    $mod_arr       = array_keys($mod_posts);

    $sql = 'DELETE FROM `' . $xoopsDB->prefix('tad_themes_menu') . '` WHERE `of_level` = ? AND `link_cate_name` != ?';
    Utility::query($sql, 'is', [$of_level, '']) or Utility::web_error($sql, __FILE__, __LINE__);

    $sql    = 'SELECT `dirname` FROM `' . $xoopsDB->prefix('modules') . '` WHERE `isactive`=1 AND `hasmain`=1 ORDER BY `weight`';
    $result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    while ($row = $xoopsDB->fetchRow($result)) {
        list($dirname) = $row;
        if (in_array($dirname, $mod_arr)) {
            $position = get_max_sort($of_level);
            if (in_array($dirname, $old_items_arr)) {
                $title      = $old_items[$dirname]['itemname'];
                $status     = $old_items[$dirname]['status'];
                $icon       = $old_items[$dirname]['icon'];
                $read_group = $old_items[$dirname]['read_group'];
            } else {
                $title      = $mod_posts[$dirname]['title'];
                $status     = 1;
                $icon       = '';
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
    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_themes_menu') . '` SET `status` = ? WHERE `menuid` = ?';
    Utility::query($sql, 'ii', [$status ? 1 : 0, (int) $menuid]) or Utility::web_error($sql, __FILE__, __LINE__);
}

//刪除圖片
function del_pic($type, $menuid)
{
    $menuid = (int) $menuid;
    if ('icon' === $type) {
        $dir   = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_icons';
        $file1 = "{$dir}/{$menuid}_64.png";
        $file2 = "{$dir}/{$menuid}_32.png";
    } elseif ('banner' === $type) {
        $dir   = XOOPS_ROOT_PATH . '/uploads/tad_themes/menu_banner';
        $file1 = "{$dir}/{$menuid}.png";
        $file2 = "{$dir}/{$menuid}_thumb.png";
    } else {
        return;
    }

    if (file_exists($file1)) {
        unlink($file1);
    }

    if (file_exists($file2)) {
        unlink($file2);
    }
}
