<?php
xoops_loadLanguage('admin_common', 'tadtools');

//需加入模組語系
define('_TAD_NEED_TADTOOLS', 'This module need tadtools module. You can download tadtools from <a href="http://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1" target="_blank">XOOPS EasyGO</a>.');
define('_MA_TADTHEMES_THEME_BASE', 'Theme Setup');
define('_MA_TADTHEMES_THEME_KIND', 'Theme Kind');
define('_MA_TADTHEMES_THEME_KIND_BOOTSTRAP3', '（XOOPS bootstrap3 themes)');
define('_MA_TADTHEMES_THEME_KIND_BOOTSTRAP4', '（XOOPS bootstrap4 themes)');
define('_MA_TADTHEMES_THEME_KIND_HTML', '(XOOPS themes)');
define('_MA_TADTHEMES_THEME_KIND_MIX', '(bootstrap only for blocks)');
define('_MA_TADTHEMES_THEME_TYPE', 'Theme Type');
define('_MA_TADTHEMES_THEME_WIDTH', 'Theme width');
define('_MA_TADTHEMES_LB_WIDTH', 'Left zone width');
define('_MA_TADTHEMES_CB_WIDTH', 'Center zone width :');
define('_MA_TADTHEMES_RB_WIDTH', 'right zone width');
define('_MA_TADTHEMES_LB_COLOR', 'Left zone color');
define('_MA_TADTHEMES_CB_COLOR', 'Center zone color');
define('_MA_TADTHEMES_RB_COLOR', 'right zone color');
define('_MA_TADTHEMES_MARGIN_TOP', 'margin-top');
define('_MA_TADTHEMES_MARGIN_BOTTOM', 'margin-bottom');
define('_MA_TADTHEMES_BG_IMG', 'background-image');
define('_MA_TADTHEMES_BG_ATTR', 'attribute Settings');
define('_MA_TADTHEMES_BG_COLOR', 'background-color');
define('_MA_TADTHEMES_BG_REPEAT', 'background-repeart');
define('_MA_TADTHEMES_BG_REPEAT_NORMAL', 'repeart');
define('_MA_TADTHEMES_BG_REPEAT_X', 'repeart_x');
define('_MA_TADTHEMES_BG_REPEAT_Y', 'repeart_y');
define('_MA_TADTHEMES_BG_NO_REPEAT', 'no-repeart');
define('_MA_TADTHEMES_BG_SIZE', 'background-size');
define('_MA_TADTHEMES_BG_SIZE_NONE', '');
define('_MA_TADTHEMES_BG_SIZE_COVER', 'background-size: cover');
define('_MA_TADTHEMES_BG_SIZE_CONTAIN', 'background-size: contain');
define('_MA_TADTHEMES_BG_SIZE_FULL', 'background-size: 100%');
define('_MA_TADTHEMES_BG_ATTACHMENT', 'background');
define('_MA_TADTHEMES_BG_ATTACHMENT_SCROLL', 'scroll');
define('_MA_TADTHEMES_BG_ATTACHMENT_FIXED', 'fixed');
define('_MA_TADTHEMES_BG_POSITION', 'background-postiton');
define('_MA_TADTHEMES_BG_POSITION_LT', 'left top');
define('_MA_TADTHEMES_BG_POSITION_RT', 'right top');
define('_MA_TADTHEMES_BG_POSITION_LB', 'left bottom');
define('_MA_TADTHEMES_BG_POSITION_RB', 'right bottom');
define('_MA_TADTHEMES_BG_POSITION_CC', 'center center');
define('_MA_TADTHEMES_BG_POSITION_CT', 'center top');
define('_MA_TADTHEMES_BG_POSITION_CB', 'center bottom');
define('_MA_TADTHEMES_NONE', 'none');
define('_MA_TADTHEMES_LOGO_IMG', 'logo');
define('_MA_TADTHEMES_LOGO_POSITION', 'logo position');
define('_MA_TADTHEMES_LOGO_SLIDE', 'on slide');
define('_MA_TADTHEMES_LOGO_PAGE', 'on page');
define('_MA_TADTHEMES_NAVLOGO_IMG', 'NavBar logo');
define('_MA_TADTHEMES_SLIDE_WIDTH', 'Slide Width');
define('_MA_TADTHEMES_SLIDE_HEIGHT', 'Slide Height');
define('_MA_TADTHEMES_SLIDE_DESC', "<ol><li style='list-style-type:decimal;line-height:180%;list-style-position:outside;'>Slide Width =0 (hide slide)</li><li style='list-style-type:decimal;line-height:180%;list-style-position:outside;'>Slide Height = 0(auto height)</li><li style='list-style-type:decimal;line-height:180%;list-style-position:outside;'>You can input \"<b><u>[url]http://some.web.url[/url]</u></b>\" to add link for slide image. </li><li style='list-style-type:decimal;line-height:180%;list-style-position:outside;'><span style='color: red;'>[url_blank]http://some.web.url[/url_blank]</span>  can open the link in a new window.</li></ol>");
define('_MA_TAD_THEMES_FORM', 'Theme Setup');
define('_MA_TAD_THEMES_NOT_TAD_THEME', 'Defaut Theme "%s" not compatible with Tad Theme.<div>"%s" not found.</div>');
define('_MA_TAD_THEMES_TYPE1', '2 Columns (All Left)');
define('_MA_TAD_THEMES_TYPE2', '2 Columns (All Right)');
define('_MA_TAD_THEMES_TYPE3', '2 Columns (Left + Bottom)');
define('_MA_TAD_THEMES_TYPE4', '2 Columns (Right + Bottom)');
define('_MA_TAD_THEMES_TYPE5', '3 Columns');
define('_MA_TAD_THEMES_TYPE6', '3 Columns (All Left)');
define('_MA_TAD_THEMES_TYPE7', '3 Columns (All Right)');
define('_MA_TAD_THEMES_TYPE8', 'Single Columns');
define('_MA_TAD_THEMES_HEAD', 'Theme Head');
define('_MA_TAD_THEMES_LEFT', 'Left Zone');
define('_MA_TAD_THEMES_CENTER', 'Content and Center Zone');
define('_MA_TAD_THEMES_RIGHT', 'Right Zone');
define('_MA_TAD_THEMES_FOOT', 'Foot');
define('_MA_TAD_THEMES_UPLOAD', 'Upload ');
define('_MA_TADTHEMES_NOTICE', "<ul style='line-height:2em;'>
  <li style='line-height:180%;list-style-position:outside;'>Content and Center Zone width need more than 550px</li>
  </ul>");
define('_MA_TADTHEMES_NOTICE2', "<ul style='line-height:2em;'>
  <li style='line-height:180%;list-style-position:outside;'>All pictures can be uploaded directly to FTP, the system will automatically be added to the database, and generate thumbnails.
    <ul style='list-style-type:circle;margin-left:20px;'>
      <li style='line-height:180%;list-style-position:outside;'>Background images : /themes/{$xoopsConfig['theme_set']}/images/bg</li>
      <li style='line-height:180%;list-style-position:outside;'>Slide images: /themes/{$xoopsConfig['theme_set']}/images/slide</li>
      <li style='line-height:180%;list-style-position:outside;'>Logo images: /themes/{$xoopsConfig['theme_set']}/images/logo</li>
      <li style='line-height:180%;list-style-position:outside;'>Blocks background images: /themes/{$xoopsConfig['theme_set']}/images/bt_bg</li>
      <li style='line-height:180%;list-style-position:outside;'>Navbar background images: /themes/{$xoopsConfig['theme_set']}/images/nav_bg</li>
      <li style='line-height:180%;list-style-position:outside;'>Navbar logo images: /themes/{$xoopsConfig['theme_set']}/images/navlogo</li>
    </ul>
  </li>
  <li>When you delete pictures, all from the background deleted, do not just delete FTP photo!</li>
  </ul>");
define('_MA_TADTHEMES_LOGO_PLACE', 'Setup logo position');
define('_MA_TADTHEMES_FONT_SIZE', 'Font size');
define('_MA_TADTHEMES_FONT_COLOR', 'Font color');
define('_MA_TADTHEMES_LINK_COLOR', 'Link color');
define('_MA_TADTHEMES_HOVER_COLOR', 'Hover color');
define('_MA_TADTHEMES_COL', '');
define('_MA_TADTHEMES_ITEMNAME', 'Item Name');
define('_MA_TADTHEMES_ITEMURL', 'Item URL');
define('_MA_TADTHEMES_ADDITEM', 'Add item in %s');
define('_MA_TADTHEMES_SAVE_SORT', 'Drag sort');
define('_MA_TADTHEMES_ROOT', 'Root');
define('_MA_TADTHEMES_WEB_MENU', 'Menu');
define('_MA_TADTHEMES_EDIT_MENU', 'Various editing functions');
define('_MA_TADTHEMES_IMPORT_MENU', 'Import Menu');
define('_MA_TADTHEMES_IMPORT_EDIT_MENU', 'Import editing options');
define('_MA_TADTHEMES_EDIT_MENU_TADNEWS', 'Publish Article');
define('_MA_TADTHEMES_EDIT_MENU_TAD_LINK', 'Add link');
define('_MA_TADTHEMES_EDIT_MENU_TADGALLERY', 'Upload photo');
define('_MA_TADTHEMES_EDIT_MENU_TAD_TIMELINE', 'Add a note');
define('_MA_TADTHEMES_EDIT_MENU_TAD_MEETING', 'Create a meeting');
define('_MA_TADTHEMES_EDIT_MENU_TAD_HONOR', 'Add honor list');
define('_MA_TADTHEMES_EDIT_MENU_TAD_UPLOADER', 'File Upload');
define('_MA_TADTHEMES_EDIT_MENU_TAD_TADBOOK3', 'Add a book');
define('_MA_TADTHEMES_EDIT_MENU_TAD_CAL', 'Add a calendar');
define('_MA_TADTHEMES_EDIT_MENU_TAD_FAQ', 'Add question and answer');
define('_MA_TADTHEMES_EDIT_MENU_TAD_PLAYER', 'Upload Video');
define('_MA_TADTHEMES_EDIT_MENU_TAD_REPAIR', 'Fill in the repair order');
define('_MA_TADTHEMES_BLOCK_TITLE', 'Block Title');
define('_MA_TADTHEMES_BLOCK_TITLE_BUTTOM', 'Setup button');
define('_MA_TADTHEMES_BLOCK_TITLE_PADDING', 'Block title left padding');
define('_MA_TADTHEMES_BLOCK_TITLE_RADIUS', 'Radius setup');
define('_MA_TADTHEMES_BLOCK_TITLE_RADIUS_Y', 'Radius');
define('_MA_TADTHEMES_BLOCK_TITLE_RADIUS_N', 'None');
define('_MA_TADTHEMES_NAVBAR', 'Navbar');
define('_MA_TADTHEMES_NAVBAR_POSITION', 'Navbar position');
define('_MA_TADTHEMES_NAVBAR_POSITION_1', 'Top fixed');
define('_MA_TADTHEMES_NAVBAR_POSITION_2', 'Bottom fixed');
define('_MA_TADTHEMES_NAVBAR_POSITION_3', 'Slide top');
define('_MA_TADTHEMES_NAVBAR_POSITION_6', 'Slide bottom');
define('_MA_TADTHEMES_NAVBAR_POSITION_4', 'By theme setup');
define('_MA_TADTHEMES_NAVBAR_POSITION_5', 'Hide');
define('_MA_TADTHEMES_NAVBAR_BG_COLOR', 'Color');
define('_MA_TADTHEMES_NAVBAR_HOVER_COLOR', 'Background Color');
define('_MA_TADTHEMES_TARGET_BLANK', '_blank');
define('_MA_TADTHEMES_NAVBAR_COLOR', 'Text Color');
define('_MA_TADTHEMES_NAVBAR_COLOR_HOVER', 'Text hover Color');
define('_MA_TADTHEMES_NAVBAR_ICON_COLOR', 'Icon color');
define('_MA_TADTHEMES_NAVBAR_ICON_WHITE', 'white icon');
define('_MA_TADTHEMES_NAVBAR_ICON_BLACK', 'black icon');
define('_MA_TADTHEMES_CHANGE_KIND_DESC', 'This theme support switch type.');
define('_MA_TADTHEMES_CHANGE_KIND', 'Chang Kind');
define('_MA_TADTHEMES_ITEMICON', 'Item Icon');
define('_MA_TADTHEMES_ITEMBANNER', 'Item Banner');
define('_MA_TADTHEMES_CONFIG2', 'Other theme config');
define('_MA_TADTHEMES_DEFAULT', 'Default');
define('_MA_TADTHEMES_BLOCK_POSITION', 'Block position');
define('_MA_TADTHEMES_BLOCK_ALL_POSITION', 'Apply to all blocks');
define('_MA_TADTHEMES_BLOCK_LEFT', 'Left');
define('_MA_TADTHEMES_BLOCK_RIGHT', 'Right');
define('_MA_TADTHEMES_BLOCK_TOP_CENTER', 'Top center');
define('_MA_TADTHEMES_BLOCK_TOP_LEFT', 'Top center left');
define('_MA_TADTHEMES_BLOCK_TOP_RIGHT', 'Top center right');
define('_MA_TADTHEMES_BLOCK_BOTTOM_CENTER', 'Bottom center');
define('_MA_TADTHEMES_BLOCK_BOTTOM_LEFT', 'Bottom center left');
define('_MA_TADTHEMES_BLOCK_BOTTOM_RIGHT', 'Bottom center right');
define('_MA_TADTHEMES_BLOCK_FOOTER_CENTER', 'Footer center');
define('_MA_TADTHEMES_BLOCK_FOOTER_LEFT', 'Footer left');
define('_MA_TADTHEMES_BLOCK_FOOTER_RIGHT', 'Footer right');
define('_MA_TADTHEMES_BLOCK_TITLE_SIZE', 'Font size');
define('_MA_TADTHEMES_TO_DEFAULT', 'Restored to the default');
define('_MA_TADTHEMES_DEL_CONFIRM', 'This will clear this theme settings and restore default values! You sure you want to perform?');
define('_MA_TADTHEMES_BASE_COLOR', 'Base color');
define('_MA_TADTHEMES_NAVBAR_IMG', 'Navbar background');
define('_MA_TADTHEMES_BLOCK_STYLE', 'Block CSS');
define('_MA_TADTHEMES_BLOCK_TITLE_STYLE', 'Block title CSS');
define('_MA_TADTHEMES_BLOCK_CONTENT_STYLE', 'Block content CSS');
define('_MA_TADTHEMES_YOUR_STYLE', 'Your style content');
define('_MA_TADTHEMES_TARGET_FANCYBOX', 'ColorBox');
define('_MA_TADTHEMES_OF_LEVEL', 'Parent');
define('_MA_TADTHEMES_ICON', 'icon');
define('_MA_TADTHEMES_LOGO_CENTER', 'center');
define('_MA_TADTHEMES_SAVE', 'Export theme setup');
define('_MA_TADTHEMES_CONFIG_NAME', 'Customize the theme Profile name');
define('_MA_TADTHEMES_CONFIG_PATH', 'Successfully saved to %s');
define('_MA_TADTHEMES_APPLY_OK', 'Successfully applied %s');
define('_MA_TADTHEMES_DEL_OK', 'Successfully deleted %s');
define('_MA_TADTHEMES_EXPORT', 'Export theme Profile');
define('_MA_TADTHEMES_IMPORT', 'Import theme Profile');
define('_MA_TADTHEMES_APPLY', 'Apply');
define('_MA_TADTHEMES_MANAGER', 'Manage theme Profile');
define('_MA_TADTHEMES_IMPORT_OK', '% s has been successfully imported, and you can try to apply it');
define('_MA_TADTHEMES_IMPORT_FAIL', 'Import failed, this profile only supports %s theme');
define('_MA_TADTHEMES_IMPORT_STYLE', 'Remote Import Style File');

define('_MA_TADTHEMES_NAVBAR_PY', 'Navigation options padding top and bottom');
define('_MA_TADTHEMES_NAVBAR_PX', 'Navigation options padding left and right');

define('_MA_TADTHEMES_LOGO_MT', 'Logo margin top');
define('_MA_TADTHEMES_LOGO_MB', 'Logo margin bottom');
define('_MA_TADTHEMES_LOGO_DESIGN', 'Simple Logo Design');
define('_MA_TADTHEMES_LOGO_INPUT_TEXT', 'Enter text');
define('_MA_TADTHEMES_LOGO_TEXT_COLOR', 'Text Color');
define('_MA_TADTHEMES_LOGO_BORDER_COLOR', 'Border Color');
define('_MA_TADTHEMES_LOGO_TEXT_SIZE', 'Text size');
define('_MA_TADTHEMES_LOGO_BORDER_SIZE', 'outline size');
define('_MA_TADTHEMES_LOGO_SHADOW_COLOR', 'Shadow Color');
define('_MA_TADTHEMES_LOGO_SHADOW_SIZE', 'Shadow Size');
define('_MA_TADTHEMES_LOGO_SHADOW_X', 'Shadow X');
define('_MA_TADTHEMES_LOGO_SHADOW_Y', 'Shadow Y');
define('_MA_TADTHEMES_LOGO_SELECT_FONT', 'Select font');
define('_MA_TADTHEMES_LOGO_MAKE_PNG', 'Generate image');
define('_MA_TADTHEMES_LOGO_NEED_FONT', 'Please upload at least one font');
define('_MA_TADTHEMES_LOGO_SAVE_PIC', 'Save as Logo');
define('_MA_TADTHEMES_LOGO_SAVE_AS_LOGO', 'Save Picture');
define('_MA_TADTHEMES_LOGO_DEMO_BGCOLOR', 'Example Background Color:');
define('_MA_TADTHEMES_FONT_TOOL', 'Font File Management');
define('_MA_TADTHEMES_FONT_UPLOAD', 'Upload font file');
define('_MA_TADTHEMES_FONT_NOTE', 'Only supports ttf, otf, ttc font files. If there is no font, it can be from <a href="https://forum.gamer.com.tw/C.php?bsn=60076&snA= 3906436" target="_blank">Download here</a> or <a href="http://www.fonts.net.cn/commercial-free-32767/fonts-zh-1.html" target="_blank">Download here</a>');
define('_MA_TADTHEMES_FONT_SAVE', 'Save font files');
define('_MA_TADTHEMES_READGROUP', 'Readable group');
define('_MA_TADTHEMES_APPLY_READGROUP', 'The lower level option applies the same permission');

define('_MA_TADTHEMES_NAVBAR_FONT_SIZE', 'Option text size');
define('_MA_TADTHEMES_NAVBAR_CHANGE', 'Gradient to');
define('_MA_TADTHEMES_NAVBAR_HOVER_COLOR', 'Mouse over background color');

define('_MA_TADTHEMES_EXPAND_ALL', 'Expand all');
define('_MA_TADTHEMES_COLLAPSE_ALL', 'Collapse all');

define('_MA_TADTHEMES_EDIT_MENU_TAD_BLOCKS', 'Add custom block');
define('_MA_TADTHEMES_EDIT_MENU_TAD_GPHOTOS', 'Add Google Photos');
define('_MA_TADTHEMES_EDIT_MENU_TAD_FORM', 'Add Form');
define('_MA_TADTHEMES_EDIT_MENU_JILL_NOTICE', 'Add Notice');
define('_MA_TADTHEMES_EDIT_MENU_JILL_BOOKING', 'Booking Place');

define('_MA_TADTHEMES_DOWNLOAD', 'Download');
define('_MA_TADTHEMES_DL_FAIL', '"%s" failed to download!');
