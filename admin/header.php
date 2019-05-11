<?php
/**
 * Tad Themes module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright    XOOPS Project (https://xoops.org)
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package      Tad Themes
 * @since        2.5.0
 * @author       Tad
 * @version      $Id $
 **/
include dirname(__DIR__) . '/preloads/autoloader.php';

require  dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';

$moduleDirName = basename(dirname(__DIR__));
xoops_loadLanguage('main',  $moduleDirName);

if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
    require_once XOOPS_ROOT_PATH . '/class/template.php';
    $xoopsTpl = new \XoopsTpl();
}

$adminObject = \Xmf\Module\Admin::getInstance();

xoops_cp_header();

// Define Stylesheet and JScript
//$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/css/admin.css');
//$xoTheme->addScript("browse.php?Frameworks/jquery/jquery.js");
//$xoTheme->addScript("browse.php?modules/" . $xoopsModule->getVar("dirname") . "/js/admin.js");

// if ($_SESSION['bootstrap'] == 4) {
//     $GLOBALS['xoopsOption']['template_main'] = str_replace('.tpl', '.tpl', $xoopsOption['template_main']);
// }
