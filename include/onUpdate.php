<?php
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_themes\Update;

if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}
if (!class_exists('XoopsModules\Tad_themes\Update')) {
    require dirname(__DIR__) . '/preloads/autoloader.php';
}

function xoops_module_update_tad_themes(&$module, $old_version)
{
    global $xoopsDB;

    if (!Update::chk_chk1()) {
        Update::go_update1();
    }

    if (!Update::chk_chk2()) {
        Update::go_update2();
    }

    //if(!Update::chk_chk3()) Update::go_update3();
    if (!Update::chk_chk4()) {
        Update::go_update4();
    }

    if (!Update::chk_chk5()) {
        Update::go_update5();
    }

    if (!Update::chk_chk6()) {
        Update::go_update6();
    }

    if (!Update::chk_chk7()) {
        Update::go_update7();
    }

    if (!Update::chk_chk8()) {
        Update::go_update8();
    }

    if (!Update::chk_chk9()) {
        Update::go_update9();
    }

    if (!Update::chk_chk10()) {
        Update::go_update10();
    }

    if (!Update::chk_chk11()) {
        Update::go_update11();
    }

    if (!Update::chk_chk12()) {
        Update::go_update12();
    }

    if (!Update::chk_chk13()) {
        Update::go_update13();
    }

    if (!Update::chk_chk14()) {
        Update::go_update14();
    }

    if (!Update::chk_chk15()) {
        Update::go_update15();
    }

    if (!Update::chk_chk16()) {
        Update::go_update16();
    }

    if (Update::chk_chk17()) {
        Update::go_update17();
    }

    if (Update::chk_chk18()) {
        Update::go_update18();
    }

    if (Update::chk_chk19()) {
        Update::go_update19();
    }

    if (Update::chk_chk20()) {
        Update::go_update20();
    }

    if (Update::chk_files_center()) {
        Update::go_update_files_center();
    }

    if (!Update::chk_chk21()) {
        Update::go_update21();
    }

    if (Update::chk_chk22()) {
        Update::go_update22();
    }

    //加入id以及時間欄位
    if (Update::chk_data_center()) {
        Update::go_update_data_center();
    }

    if (Update::chk_chk23()) {
        Update::go_update23();
    }
    if (Update::chk_chk24()) {
        Update::go_update24();
    }
    if (Update::chk_chk25()) {
        Update::go_update25();
    }
    Update::chk_tad_themes_block();

    //新增檔案欄位
    if (Update::chk_fc_tag()) {
        Update::go_fc_tag();
    }

    //修正上傳檔案的路徑
    Update::fix_config2_file_url();

    if (Update::chk_chk26()) {
        Update::go_update26();
    }
    if (Update::chk_chk27()) {
        Update::go_update27();
    }

    if (Update::chk_chk28()) {
        Update::go_update28();
    }

    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_themes');

    return true;
}
