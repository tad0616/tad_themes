<?php
//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2011-12-31
// $Id:$
// ------------------------------------------------------------------------- //

include_once "../../tadtools/language/{$xoopsConfig['language']}/admin_common.php";

//需加入模組語系
define("_TAD_NEED_TADTOOLS"," 需要 tadtools 模組，可至<a href='http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50' target='_blank'>Tad教材網</a>下載。");

define("_MA_TADTHEMES_THEME_ID","佈景編號");
define("_MA_TADTHEMES_THEME_NAME","佈景名稱");
define("_MA_TADTHEMES_THEME_KIND","佈景類型");
define("_MA_TADTHEMES_THEME_KIND_BOOTSTRAP","（bootstrap 是新型的響應式佈景，可以適用在網站及手持裝置上並自動調整版面，全版按比例分為12欄，若以1024解析度來說，每一欄約80px。）");
define("_MA_TADTHEMES_THEME_KIND_HTML","（一般的XOOPS網頁佈景）");
define("_MA_TADTHEMES_THEME_TYPE","版面類型");
define("_MA_TADTHEMES_LB_WIDTH","左區域寬度");
define("_MA_TADTHEMES_CB_WIDTH","中區域寬度");
define("_MA_TADTHEMES_RB_WIDTH","右區域寬度");
define("_MA_TADTHEMES_LB_COLOR","左區域顏色");
define("_MA_TADTHEMES_CB_COLOR","中區域顏色");
define("_MA_TADTHEMES_RB_COLOR","右區域顏色");
define("_MA_TADTHEMES_CLB_WIDTH","中左區域寬度");
define("_MA_TADTHEMES_CRB_WIDTH","中右區域寬度");
define("_MA_TADTHEMES_MARGIN_TOP","離上邊界距離");
define("_MA_TADTHEMES_MARGIN_BOTTOM","離下邊界距離");
define("_MA_TADTHEMES_BG_IMG","背景圖");
define("_MA_TADTHEMES_BG_COLOR","背景顏色");
define("_MA_TADTHEMES_BG_REPEAT","背景重複");
define("_MA_TADTHEMES_BG_REPEAT_NORMAL","一般重複");
define("_MA_TADTHEMES_BG_REPEAT_X","僅橫向重複");
define("_MA_TADTHEMES_BG_REPEAT_Y","僅垂直重複");
define("_MA_TADTHEMES_BG_NO_REPEAT","不重複");
define("_MA_TADTHEMES_BG_ATTACHMENT","背景模式");
define("_MA_TADTHEMES_BG_ATTACHMENT_SCROLL","隨畫面捲動");
define("_MA_TADTHEMES_BG_ATTACHMENT_FIXED","固定不捲動");
define("_MA_TADTHEMES_BG_POSITION","背景位置");
define("_MA_TADTHEMES_BG_POSITION_LT","左上");
define("_MA_TADTHEMES_BG_POSITION_RT","右上");
define("_MA_TADTHEMES_BG_POSITION_LB","左下");
define("_MA_TADTHEMES_BG_POSITION_RB","右下");
define("_MA_TADTHEMES_BG_POSITION_CC","正中");
define("_MA_TADTHEMES_BG_POSITION_CT","上中");
define("_MA_TADTHEMES_BG_POSITION_CB","下中");
define("_MA_TADTHEMES_NONE","無");
define("_MA_TADTHEMES_LOGO_IMG","logo圖");
define("_MA_TADTHEMES_THEME_ENABLE","使用狀況");
define("_MA_TADTHEMES_SLIDE_WIDTH","標題檔頭圖片寬度");
define("_MA_TADTHEMES_SLIDE_HEIGHT","滑動圖片高度");
define("_MA_TADTHEMES_SLIDE_ENABLE","是否使用滑動圖片？");
define("_MA_TAD_THEMES_FORM","佈景設定");

define("_MA_TAD_THEMES_NOT_TAD_THEME","目前使用之佈景「%s」非 Tad Theme 相容佈景，無法使用此工具。<div>該佈景找不到「%s」檔案。</div>");

define("_MA_TAD_THEMES_TYPE1","二欄式（左右區域皆在左邊）");
define("_MA_TAD_THEMES_TYPE2","二欄式（左右區域皆在右邊）");
define("_MA_TAD_THEMES_TYPE3","二欄式（左區域在左邊，右區域在下方）");
define("_MA_TAD_THEMES_TYPE4","二欄式（左區域在右邊，右區域在下方）");
define("_MA_TAD_THEMES_TYPE5","三欄式標準配置");
define("_MA_TAD_THEMES_TYPE6","三欄式（左右區域皆在左邊）");
define("_MA_TAD_THEMES_TYPE7","三欄式（左右區域皆在右邊）");
define("_MA_TAD_THEMES_TYPE8","單欄式（左區域在上方，右區域在下方）");

define("_MA_TAD_THEMES_HEAD","滑動圖片");
define("_MA_TAD_THEMES_LEFT","左區域");
define("_MA_TAD_THEMES_CENTER","主內容及中間區域");
define("_MA_TAD_THEMES_RIGHT","右區域");
define("_MA_TAD_THEMES_FOOT","頁尾");
define("_MA_TAD_THEMES_UPLOAD","上傳");
define("_MA_TADTHEMES_NOTICE","<ul style='line-height:2em;'>
  <li>主內容區建議至少維持 550px 以上寬度！</li>
  <li>切換「版面類型」時，部份欄位值會自動調整，或設為唯讀。</li>
  </ul>");
define("_MA_TADTHEMES_NOTICE2","<ul style='line-height:2em;'>
  <li>所有圖片亦可直接FTP上傳，系統會自動將之加入資料庫，並產生縮圖。
    <ul style='list-style-type:circle;margin-left:20px;'>
      <li>背景傳至「uploads/佈景名稱/bg」下</li>
      <li>logo傳至「uploads/佈景名稱/logo」下</li>
      <li>滑動圖片傳至「uploads/佈景名稱/slide」下</li>
    </ul>
  </li>
  <li>刪除圖片時，一律從後台刪除，勿直接刪除FTP圖片！</li>
  </ul>");
define("_MA_TADTHEMES_LOGO_PLACE","logo圖位置");
define("_MA_TADTHEMES_LOGO_PLACE_TOP","上");
define("_MA_TADTHEMES_LOGO_PLACE_BOTTOM","下");
define("_MA_TADTHEMES_LOGO_PLACE_LEFT","左");
define("_MA_TADTHEMES_LOGO_PLACE_RIGHT","右");

define("_MA_TADTHEMES_FONT_SIZE","文字大小");
define("_MA_TADTHEMES_FONT_COLOR","文字顏色");
define("_MA_TADTHEMES_LINK_COLOR","連結顏色");
define("_MA_TADTHEMES_HOVER_COLOR","移到連結顏色");
define("_MA_TADTHEMES_SELECT_TO_DEL","選取欲刪除檔案");
define("_MA_TADTHEMES_SELECT","選擇預設");
define("_MA_TADTHEMES_COL","欄");


//dropdown.php
define("_MA_TADTHEMES_MENUID","編號");
define("_MA_TADTHEMES_OF_LEVEL","所屬階層");
define("_MA_TADTHEMES_POSITION","排序");
define("_MA_TADTHEMES_ITEMNAME","名稱");
define("_MA_TADTHEMES_ITEMURL","網址");
define("_MA_TADTHEMES_MEMBERSONLY","登入後才能看見");
define("_MA_TADTHEMES_STATUS","狀態");
define("_MA_TADTHEMES_ADDITEM","在「%s」底下建立一個選項");
define("_MA_TADTHEMES_SAVE_SORT","拉動排序");
define("_MA_TADTHEMES_ROOT","根目錄");
define("_MA_TADTHEMES_WEB_MENU","本站功能選單");
define("_MA_TADTHEMES_IMPORT_MENU","快速匯入主選單");

define("_MA_TADTHEMES_BLOCK_TITLE","區塊標題列");
define("_MA_TADTHEMES_BLOCK_TITLE_BUTTOM","區塊標題工具按鈕");
define("_MA_TADTHEMES_BLOCK_TITLE_PADDING","區塊標題文字縮排");
define("_MA_TADTHEMES_BLOCK_TITLE_RADIUS","區塊標題圓角設定");
define("_MA_TADTHEMES_BLOCK_TITLE_RADIUS_Y","圓角");
define("_MA_TADTHEMES_BLOCK_TITLE_RADIUS_N","不設定（直角）");

define("_MA_TADTHEMES_NAVBAR","導覽工具列");
define("_MA_TADTHEMES_NAVBAR_POSITION","導覽工具列位置");
define("_MA_TADTHEMES_NAVBAR_POSITION_DESC","school2012使用導覽工具列注意事項：<li>滑動圖片下方的原工具列將不顯現</li><li>位置為上方鎖定或下方鎖定時，需設定離上或下邊界距離至少53px</li>");
define("_MA_TADTHEMES_NAVBAR_POSITION_1","上方鎖定");
define("_MA_TADTHEMES_NAVBAR_POSITION_2","下方鎖定");
define("_MA_TADTHEMES_NAVBAR_POSITION_3","上方");
define("_MA_TADTHEMES_NAVBAR_POSITION_4","佈景預設呈現方式");
define("_MA_TADTHEMES_NAVBAR_BG_COLOR","漸層顏色");
define("_MA_TADTHEMES_NAVBAR_HOVER_COLOR","連結區塊底色");
define("_MA_TADTHEMES_TARGET_BLANK","新視窗");
?>
