<?php
//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2011-12-31
// $Id:$
// ------------------------------------------------------------------------- //

include_once "../../tadtools/language/{$xoopsConfig['language']}/admin_common.php";

//需加入模組語系
define("_TAD_NEED_TADTOOLS","This module need tadtools module. You can download tadtools from <a href='http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50' target='_blank'>Tad's web</a>.");
define("_MA_TADTHEMES_THEME_BASE","Theme Setup");
define("_MA_TADTHEMES_THEME_KIND","Theme Kind");
define("_MA_TADTHEMES_THEME_KIND_BOOTSTRAP","（XOOPS bootstrap themes)");
define("_MA_TADTHEMES_THEME_KIND_HTML","(XOOPS themes)");
define("_MA_TADTHEMES_THEME_TYPE","Theme Type");
define("_MA_TADTHEMES_THEME_WIDTH","Theme width");
define("_MA_TADTHEMES_LB_WIDTH","Left zone width");
define("_MA_TADTHEMES_CB_WIDTH","Center zone width :");
define("_MA_TADTHEMES_RB_WIDTH","right zone width");
define("_MA_TADTHEMES_LB_COLOR","Left zone color");
define("_MA_TADTHEMES_CB_COLOR","Center zone color");
define("_MA_TADTHEMES_RB_COLOR","right zone color");
define("_MA_TADTHEMES_MARGIN_TOP","margin-top");
define("_MA_TADTHEMES_MARGIN_BOTTOM","margin-bottom");
define("_MA_TADTHEMES_BG_IMG","background-image");
define("_MA_TADTHEMES_BG_COLOR","background-color");
define("_MA_TADTHEMES_BG_REPEAT","background-repeart");
define("_MA_TADTHEMES_BG_REPEAT_NORMAL","repeart");
define("_MA_TADTHEMES_BG_REPEAT_X","repeart_x");
define("_MA_TADTHEMES_BG_REPEAT_Y","repeart_y");
define("_MA_TADTHEMES_BG_NO_REPEAT","no_repeart");
define("_MA_TADTHEMES_BG_ATTACHMENT","background");
define("_MA_TADTHEMES_BG_ATTACHMENT_SCROLL","scroll");
define("_MA_TADTHEMES_BG_ATTACHMENT_FIXED","fixed");
define("_MA_TADTHEMES_BG_POSITION","background-postiton");
define("_MA_TADTHEMES_BG_POSITION_LT","left top");
define("_MA_TADTHEMES_BG_POSITION_RT","right top");
define("_MA_TADTHEMES_BG_POSITION_LB","left bottom");
define("_MA_TADTHEMES_BG_POSITION_RB","right bottom");
define("_MA_TADTHEMES_BG_POSITION_CC","center center");
define("_MA_TADTHEMES_BG_POSITION_CT","center top");
define("_MA_TADTHEMES_BG_POSITION_CB","center bottom");
define("_MA_TADTHEMES_NONE","none");
define("_MA_TADTHEMES_LOGO_IMG","logo");
define("_MA_TADTHEMES_SLIDE_WIDTH","Slide Width");
define("_MA_TADTHEMES_SLIDE_HEIGHT","Slide Height");
define("_MA_TADTHEMES_SLIDE_DESC","Slide Width =0 (hide slide)<br>Slide Height = 0(auto height)");
define("_MA_TAD_THEMES_FORM","Theme Setup");

define("_MA_TAD_THEMES_NOT_TAD_THEME","Defaut Theme \"%s\" can't compatible with Tad Theme.<div>\"%s\" not founded.</div>");

define("_MA_TAD_THEMES_TYPE1","2 Columns (All Left)");
define("_MA_TAD_THEMES_TYPE2","2 Columns (All Right)");
define("_MA_TAD_THEMES_TYPE3","2 Columns (Left + Bottom)");
define("_MA_TAD_THEMES_TYPE4","2 Columns (Right + Bottom)");
define("_MA_TAD_THEMES_TYPE5","3 Columns");
define("_MA_TAD_THEMES_TYPE6","3 Columns (All Left)");
define("_MA_TAD_THEMES_TYPE7","3 Columns (All Right)");
define("_MA_TAD_THEMES_TYPE8","Single Columns");

define("_MA_TAD_THEMES_HEAD","Theme Head");
define("_MA_TAD_THEMES_LEFT","Left Zone");
define("_MA_TAD_THEMES_CENTER","Content and Center Zone");
define("_MA_TAD_THEMES_RIGHT","Right Zone");
define("_MA_TAD_THEMES_FOOT","Foot");
define("_MA_TAD_THEMES_UPLOAD","Upload ");
define("_MA_TADTHEMES_NOTICE","<ul style='line-height:2em;'>
  <li>Content and Center Zone width need more than 550px</li>
  </ul>");
define("_MA_TADTHEMES_NOTICE2","<ul style='line-height:2em;'>
  <li>All pictures can be uploaded directly to FTP, the system will automatically be added to the database, and generate thumbnails.
    <ul style='list-style-type:circle;margin-left:20px;'>
      <li>Background images : uploads/YourTheme/bg</li>
      <li>Logo images: uploads/YourTheme/logo</li>
      <li>Slide images: uploads/YourTheme/slide</li>
    </ul>
  </li>
  <li>When you delete pictures, all from the background deleted, do not just delete FTP photo!</li>
  </ul>");
define("_MA_TADTHEMES_LOGO_PLACE","Logo position");

define("_MA_TADTHEMES_FONT_SIZE","font size");
define("_MA_TADTHEMES_FONT_COLOR","font color");
define("_MA_TADTHEMES_LINK_COLOR","link color");
define("_MA_TADTHEMES_HOVER_COLOR","hover color");
define("_MA_TADTHEMES_COL","");
define("_MA_TADTHEMES_ITEMNAME","Name");
define("_MA_TADTHEMES_ITEMURL","URL");
define("_MA_TADTHEMES_ADDITEM","Add item in %s");
define("_MA_TADTHEMES_SAVE_SORT","Drag sort");
define("_MA_TADTHEMES_ROOT","Root");
define("_MA_TADTHEMES_WEB_MENU","Menu");
define("_MA_TADTHEMES_IMPORT_MENU","Import Menu");

define("_MA_TADTHEMES_BLOCK_TITLE","Block Title");
define("_MA_TADTHEMES_BLOCK_TITLE_BUTTOM","Block Setup button");
define("_MA_TADTHEMES_BLOCK_TITLE_PADDING","Block title left padding");
define("_MA_TADTHEMES_BLOCK_TITLE_RADIUS","Radius setup");
define("_MA_TADTHEMES_BLOCK_TITLE_RADIUS_Y","Radius");
define("_MA_TADTHEMES_BLOCK_TITLE_RADIUS_N","None");

define("_MA_TADTHEMES_NAVBAR","Navbar");
define("_MA_TADTHEMES_NAVBAR_POSITION","Navbar position");
define("_MA_TADTHEMES_NAVBAR_POSITION_1","Top fixed");
define("_MA_TADTHEMES_NAVBAR_POSITION_2","Bottom fixed");
define("_MA_TADTHEMES_NAVBAR_POSITION_3","Top");
define("_MA_TADTHEMES_NAVBAR_POSITION_4","By theme setup");
define("_MA_TADTHEMES_NAVBAR_BG_COLOR","Color");
define("_MA_TADTHEMES_NAVBAR_HOVER_COLOR","Background Color");
define("_MA_TADTHEMES_TARGET_BLANK","_blank");
define("_MA_TADTHEMES_NAVBAR_COLOR","Text Color");
define("_MA_TADTHEMES_NAVBAR_COLOR_HOVER","Text hover Color");
define("_MA_TADTHEMES_NAVBAR_ICON_WHITE","white icon");
define("_MA_TADTHEMES_NAVBAR_ICON_BLACK","black icon");
?>
