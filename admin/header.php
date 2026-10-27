<?php
/**
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright    XOOPS Project (https://xoops.org)
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package
 * @since        2.5.0
 * @author
 * @version      $Id $
 **/
include dirname(__DIR__) . '/preloads/autoloader.php';

require dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';

xoops_loadLanguage('main', $xoopsModule->getVar('dirname'));

if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
    require_once XOOPS_ROOT_PATH . '/class/template.php';
    $xoopsTpl = new \XoopsTpl();
}

$adminObject = \Xmf\Module\Admin::getInstance();

// XOOPS 2.7 的 xoops_cp_header() 會把 theme_set 改成後台佈景，需還原為前台佈景（2.5.11 無此行為，還原亦無害）
$front_theme_set = $xoopsConfig['theme_set'];
xoops_cp_header();
$xoopsConfig['theme_set'] = $front_theme_set;

// Define Stylesheet and JScript
$xoTheme->addStylesheet('modules/tadtools/css/iconize.css');
$xoTheme->addStylesheet(XOOPS_URL . "/modules/tadtools/css/xoops_adm{$_SESSION['bootstrap']}.css");
$xoTheme->addStylesheet('modules/' . $xoopsModule->getVar('dirname') . '/css/module.css');
$xoTheme->addStylesheet('modules/' . $xoopsModule->getVar('dirname') . '/css/admin.css');
//$xoTheme->addScript("browse.php?Frameworks/jquery/jquery.js");
//$xoTheme->addScript("browse.php?modules/" . $xoopsModule->getVar("dirname") . "/js/admin.js");
