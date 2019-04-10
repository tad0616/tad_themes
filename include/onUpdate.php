<?php

use XoopsModules\Tad_themes\Utility;

function xoops_module_update_tad_themes(&$module, $old_version)
{
    global $xoopsDB;

    if (!Utility::chk_chk1()) {
        Utility::go_update1();
    }

    if (!Utility::chk_chk2()) {
        Utility::go_update2();
    }

    //if(!Utility::chk_chk3()) Utility::go_update3();
    if (!Utility::chk_chk4()) {
        Utility::go_update4();
    }

    if (!Utility::chk_chk5()) {
        Utility::go_update5();
    }

    if (!Utility::chk_chk6()) {
        Utility::go_update6();
    }

    if (!Utility::chk_chk7()) {
        Utility::go_update7();
    }

    if (!Utility::chk_chk8()) {
        Utility::go_update8();
    }

    if (!Utility::chk_chk9()) {
        Utility::go_update9();
    }

    if (!Utility::chk_chk10()) {
        Utility::go_update10();
    }

    if (!Utility::chk_chk11()) {
        Utility::go_update11();
    }

    if (!Utility::chk_chk12()) {
        Utility::go_update12();
    }

    if (!Utility::chk_chk13()) {
        Utility::go_update13();
    }

    if (!Utility::chk_chk14()) {
        Utility::go_update14();
    }

    if (!Utility::chk_chk15()) {
        Utility::go_update15();
    }

    if (!Utility::chk_chk16()) {
        Utility::go_update16();
    }

    if (Utility::chk_chk17()) {
        Utility::go_update17();
    }

    if (Utility::chk_chk18()) {
        Utility::go_update18();
    }

    if (Utility::chk_chk19()) {
        Utility::go_update19();
    }

    if (Utility::chk_chk20()) {
        Utility::go_update20();
    }

    if (Utility::chk_files_center()) {
        Utility::go_update_files_center();
    }

    if (!Utility::chk_chk21()) {
        Utility::go_update21();
    }

    if (Utility::chk_chk22()) {
        Utility::go_update22();
    }

    //加入id以及時間欄位
    if (Utility::chk_data_center()) {
        Utility::go_update_data_center();
    }

    if (Utility::chk_chk23()) {
        Utility::go_update23();
    }
    if (Utility::chk_chk24()) {
        Utility::go_update24();
    }


    Utility::chk_tad_themes_block();

    //新增檔案欄位
    if (Utility::chk_fc_tag()) {
        Utility::go_fc_tag();
    }


    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_themes");
    return true;
}

