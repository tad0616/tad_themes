<?php
include_once "../../tadtools/language/{$xoopsConfig['language']}/admin_common.php";

//需加入模組語系
define("_TAD_NEED_TADTOOLS"," 需要 tadtools 模組，可至<a href='http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50' target='_blank'>Tad教材網</a>下載。");
define("_MA_TADTHEMES_THEME_BASE","版面基本設定");
define("_MA_TADTHEMES_THEME_KIND","佈景類型");
define("_MA_TADTHEMES_THEME_KIND_BOOTSTRAP","（bootstrap 是新型的響應式佈景，可以適用在網站及手持裝置上並自動調整版面，全版按比例分為12欄，若以1024解析度來說，每一欄約80px。）");
define("_MA_TADTHEMES_THEME_KIND_HTML","（一般的XOOPS網頁佈景）");
define("_MA_TADTHEMES_THEME_KIND_MIX","（版面寬度採用固定式，但版面欄位採 bootstrap 的12欄位式）");
define("_MA_TADTHEMES_THEME_TYPE","版面類型");
define("_MA_TADTHEMES_THEME_WIDTH","版面寬度");
define("_MA_TADTHEMES_LB_WIDTH","左區域寬度");
define("_MA_TADTHEMES_CB_WIDTH","中區域寬度");
define("_MA_TADTHEMES_RB_WIDTH","右區域寬度");
define("_MA_TADTHEMES_LB_COLOR","左區域顏色");
define("_MA_TADTHEMES_CB_COLOR","中區域顏色");
define("_MA_TADTHEMES_RB_COLOR","右區域顏色");
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
define("_MA_TADTHEMES_LOGO_POSITION","logo圖位置");
define("_MA_TADTHEMES_LOGO_SLIDE","置於滑動圖文框中");
define("_MA_TADTHEMES_LOGO_PAGE","置於頁面上");
define("_MA_TADTHEMES_NAVLOGO_IMG","導覽列logo圖");
define("_MA_TADTHEMES_SLIDE_WIDTH","滑動區域寬度");
define("_MA_TADTHEMES_SLIDE_HEIGHT","滑動區域高度");
define("_MA_TADTHEMES_SLIDE_DESC","<ol><li style='list-style-type:decimal;line-height:180%;list-style-position:outside;'>寬度為 0 時表示不顯示滑動區域</li><li style='list-style-type:decimal;line-height:180%;list-style-position:outside;'>高度為 0 時表示自動判斷高度。</li><li style='list-style-type:decimal;line-height:180%;list-style-position:outside;'>圖片說明框中可輸入說明，在說明框中輸入<span style='color:blue;'>[url]http://網址[/url]</span>則可替圖片加上連結。</li></ol>");
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
define("_MA_TADTHEMES_LOGO_PLACE","logo圖位置調整");

define("_MA_TADTHEMES_FONT_SIZE","文字大小");
define("_MA_TADTHEMES_FONT_COLOR","文字顏色");
define("_MA_TADTHEMES_LINK_COLOR","連結顏色");
define("_MA_TADTHEMES_HOVER_COLOR","移到連結顏色");
define("_MA_TADTHEMES_COL","欄");
define("_MA_TADTHEMES_ITEMNAME","名稱");
define("_MA_TADTHEMES_ITEMURL","網址");
define("_MA_TADTHEMES_ADDITEM","在「%s」底下建立一個選項");
define("_MA_TADTHEMES_SAVE_SORT","拉動排序");
define("_MA_TADTHEMES_ROOT","根目錄");
define("_MA_TADTHEMES_WEB_MENU","本站功能選單");
define("_MA_TADTHEMES_IMPORT_MENU","快速匯入主選單");

define("_MA_TADTHEMES_BLOCK_TITLE","區塊標題列");
define("_MA_TADTHEMES_BLOCK_TITLE_BUTTOM","設定按鈕");
define("_MA_TADTHEMES_BLOCK_TITLE_PADDING","標題縮排");
define("_MA_TADTHEMES_BLOCK_TITLE_RADIUS","圓角設定");
define("_MA_TADTHEMES_BLOCK_TITLE_RADIUS_Y","圓角");
define("_MA_TADTHEMES_BLOCK_TITLE_RADIUS_N","不設定（直角）");

define("_MA_TADTHEMES_NAVBAR","導覽工具列");
define("_MA_TADTHEMES_NAVBAR_POSITION","導覽工具列位置");
define("_MA_TADTHEMES_NAVBAR_POSITION_1","上方鎖定");
define("_MA_TADTHEMES_NAVBAR_POSITION_2","下方鎖定");
define("_MA_TADTHEMES_NAVBAR_POSITION_3","滑動圖文上方");
define("_MA_TADTHEMES_NAVBAR_POSITION_6","滑動圖文下方");
define("_MA_TADTHEMES_NAVBAR_POSITION_4","佈景預設呈現方式");
define("_MA_TADTHEMES_NAVBAR_POSITION_5","不使用導覽列");
define("_MA_TADTHEMES_NAVBAR_BG_COLOR","漸層顏色");
define("_MA_TADTHEMES_NAVBAR_HOVER_COLOR","連結區塊底色");
define("_MA_TADTHEMES_TARGET_BLANK","新視窗");
define("_MA_TADTHEMES_NAVBAR_COLOR","文字顏色");
define("_MA_TADTHEMES_NAVBAR_COLOR_HOVER","文字移過顏色");
define("_MA_TADTHEMES_NAVBAR_ICON_COLOR","圖示顏色");
define("_MA_TADTHEMES_NAVBAR_ICON_WHITE","白色圖示");
define("_MA_TADTHEMES_NAVBAR_ICON_BLACK","黑色圖示");

define("_MA_TADTHEMES_CHANGE_KIND_DESC","此佈景支援線上切換佈景類型，您可以在HTML固定寬度佈景或隨螢幕大小自動調整的自適應BootStrap佈景間切換");
define("_MA_TADTHEMES_CHANGE_KIND","切換佈景類型");

define("_MA_TADTHEMES_ITEMICON","上傳項目圖示");
define("_MA_TADTHEMES_ITEMBANNER","上傳項目專屬橫幅");
define("_MA_TADTHEMES_CONFIG2","額外佈景設定");
define("_MA_TADTHEMES_DEFAULT","預設值");
define("_MA_TADTHEMES_BLOCK_POSITION","欲設定的區域");
define("_MA_TADTHEMES_BLOCK_ALL_POSITION","套用到所有區域");
define("_MA_TADTHEMES_BLOCK_LEFT","左區域");
define("_MA_TADTHEMES_BLOCK_RIGHT","右區域");
define("_MA_TADTHEMES_BLOCK_TOP_CENTER","上中區域");
define("_MA_TADTHEMES_BLOCK_TOP_LEFT","上中左區域");
define("_MA_TADTHEMES_BLOCK_TOP_RIGHT","上中右區域");
define("_MA_TADTHEMES_BLOCK_BOTTOM_CENTER","下中區域");
define("_MA_TADTHEMES_BLOCK_BOTTOM_LEFT","下中左區域");
define("_MA_TADTHEMES_BLOCK_BOTTOM_RIGHT","下中右區域");
define("_MA_TADTHEMES_BLOCK_TITLE_SIZE","文字大小");

define("_MA_TADTHEMES_TO_DEFAULT","清除此佈景所有設定以恢復成預設值");
define("_MA_TADTHEMES_DEL_CONFIRM","這會清除此佈景所有設定，並恢復成預設值！確定要執行？");

define("_MA_TADTHEMES_BASE_COLOR","內容區顏色");
define("_MA_TADTHEMES_NAVBAR_IMG","導覽列背景圖");

define("_MA_TADTHEMES_BLOCK_STYLE","區塊整體樣式手動設定");
define("_MA_TADTHEMES_BLOCK_TITLE_STYLE","區塊標題樣式手動設定");
define("_MA_TADTHEMES_BLOCK_CONTENT_STYLE","區塊內容樣式手動設定");
define("_MA_TADTHEMES_YOUR_STYLE","您設定的樣式內容");

define("_MA_TADTHEMES_SLIDE_DEFAULT_DESCRIPT","您可以從<b>佈景管理的後台設定畫面</b>修改這部份內容，除了可以上傳滑動圖片外，也可以自己輸入圖片說明內容。部份佈景都支援HTML語法。");

define("_MA_TADTHEMES_TARGET_FANCYBOX","燈箱效果");
define("_MA_TADTHEMES_OF_LEVEL","父分類");
define("_MA_TADTHEMES_ICON","選擇Bootstrap圖示");
?>
