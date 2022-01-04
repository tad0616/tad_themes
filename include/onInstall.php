<?php
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_themes\Update;
if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}

function xoops_module_install_tad_themes(&$module)
{
    Update::go_update_conf();
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_themes');

    return true;
}
