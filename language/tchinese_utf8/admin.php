<?php
xoops_loadLanguage('admin_common', 'tadtools');

//需加入模組語系
define('_TAD_NEED_TADTOOLS', '需要 tadtools 模組，可至<a href="http://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1" target="_blank">XOOPS輕鬆架</a>下載。');
define('_MA_TADTHEMES_THEME_BASE', '基本版面');
define('_MA_TADTHEMES_THEME_KIND', '佈景類型');
define('_MA_TADTHEMES_THEME_KIND_BOOTSTRAP4', '（bootstrap 4 響應式佈景，適用在網站及行動裝置上並自動調整版面，全版按比例分為12欄。）');
define('_MA_TADTHEMES_THEME_KIND_BOOTSTRAP3', '（bootstrap 3 響應式佈景，適用在網站及行動裝置上並自動調整版面，全版按比例分為12欄。）');
define('_MA_TADTHEMES_THEME_KIND_HTML', '（一般的XOOPS網頁佈景）');
define('_MA_TADTHEMES_THEME_KIND_MIX', '（版面寬度採用固定式，但版面欄位採 bootstrap 的12欄位式）');
define('_MA_TADTHEMES_THEME_TYPE', '版面類型');
define('_MA_TADTHEMES_THEME_WIDTH', '版面寬度');
define('_MA_TADTHEMES_LB_WIDTH', '左區域寬度');
define('_MA_TADTHEMES_CB_WIDTH', '中區域寬度');
define('_MA_TADTHEMES_RB_WIDTH', '右區域寬度');
define('_MA_TADTHEMES_LB_COLOR', '左區域顏色');
define('_MA_TADTHEMES_CB_COLOR', '中區域顏色');
define('_MA_TADTHEMES_RB_COLOR', '右區域顏色');
define('_MA_TADTHEMES_MARGIN_TOP', '離上邊界距離');
define('_MA_TADTHEMES_MARGIN_BOTTOM', '離下邊界距離');
define('_MA_TADTHEMES_BG_IMG', '背景圖');
define('_MA_TADTHEMES_BG_ATTR', '屬性設定');
define('_MA_TADTHEMES_BG_COLOR', '背景顏色');
define('_MA_TADTHEMES_BG_REPEAT', '背景重複');
define('_MA_TADTHEMES_BG_REPEAT_NORMAL', '一般重複');
define('_MA_TADTHEMES_BG_REPEAT_X', '僅橫向重複');
define('_MA_TADTHEMES_BG_REPEAT_Y', '僅垂直重複');
define('_MA_TADTHEMES_BG_NO_REPEAT', '不重複');
define('_MA_TADTHEMES_BG_SIZE', '底圖縮放');
define('_MA_TADTHEMES_BG_SIZE_NONE', '無');
define('_MA_TADTHEMES_BG_SIZE_COVER', '放大圖片填滿畫面');
define('_MA_TADTHEMES_BG_SIZE_CONTAIN', '縮放以呈現完整圖片');
define('_MA_TADTHEMES_BG_SIZE_FULL', '滿版');
define('_MA_TADTHEMES_BG_ATTACHMENT', '背景模式');
define('_MA_TADTHEMES_BG_ATTACHMENT_SCROLL', '隨畫面捲動');
define('_MA_TADTHEMES_BG_ATTACHMENT_FIXED', '固定不捲動');
define('_MA_TADTHEMES_BG_POSITION', '背景位置');
define('_MA_TADTHEMES_BG_POSITION_LT', '左上');
define('_MA_TADTHEMES_BG_POSITION_RT', '右上');
define('_MA_TADTHEMES_BG_POSITION_LB', '左下');
define('_MA_TADTHEMES_BG_POSITION_RB', '右下');
define('_MA_TADTHEMES_BG_POSITION_CC', '正中');
define('_MA_TADTHEMES_BG_POSITION_CT', '上中');
define('_MA_TADTHEMES_BG_POSITION_CB', '下中');
define('_MA_TADTHEMES_NONE', '無');
define('_MA_TADTHEMES_LOGO_IMG', 'logo圖');
define('_MA_TADTHEMES_LOGO_POSITION', 'logo圖位置');
define('_MA_TADTHEMES_LOGO_SLIDE', '置於滑動圖文框中');
define('_MA_TADTHEMES_LOGO_PAGE', '置於頁面上');
define('_MA_TADTHEMES_NAVLOGO_IMG', '導覽列logo圖');
define('_MA_TADTHEMES_SLIDE_WIDTH', '滑動區域寬度');
define('_MA_TADTHEMES_SLIDE_HEIGHT', '滑動區域高度');
define('_MA_TADTHEMES_SLIDE_DESC', "<ol><li style='list-style-type:decimal;line-height:180%;list-style-position:outside;'>寬度為 0 時表示不顯示滑動區域</li><li style='list-style-type:decimal;line-height:180%;list-style-position:outside;'>高度為 0 時表示自動判斷高度。</li><li style='list-style-type:decimal;line-height:180%;list-style-position:outside;'>圖片說明框中可輸入說明，在說明框中輸入 <span style='color:blue;'>[url]http://網址[/url]</span> 可替圖片加上連結。</li><li style='list-style-type:decimal;line-height:180%;list-style-position:outside;'>用<span style='color: red;'>[url_blank]http://網址[/url_blank]</span> 則可將連結開在新視窗。</li></ol>");
define('_MA_TAD_THEMES_FORM', '佈景設定');

define('_MA_TAD_THEMES_NOT_TAD_THEME', '目前使用之佈景「%s」非 Tad Theme 相容佈景，無法使用此工具。<div>該佈景找不到「%s」檔案。</div>');
define('_MA_TAD_THEMES_TYPE1', '二欄式（左右區域皆在左邊）');
define('_MA_TAD_THEMES_TYPE2', '二欄式（左右區域皆在右邊）');
define('_MA_TAD_THEMES_TYPE3', '二欄式（左區域在左邊，右區域在下方）');
define('_MA_TAD_THEMES_TYPE4', '二欄式（左區域在右邊，右區域在下方）');
define('_MA_TAD_THEMES_TYPE5', '三欄式標準配置');
define('_MA_TAD_THEMES_TYPE6', '三欄式（左右區域皆在左邊）');
define('_MA_TAD_THEMES_TYPE7', '三欄式（左右區域皆在右邊）');
define('_MA_TAD_THEMES_TYPE8', '單欄式（左區域在上方，右區域在下方）');

define('_MA_TAD_THEMES_HEAD', '滑動圖片');
define('_MA_TAD_THEMES_LEFT', '左區域');
define('_MA_TAD_THEMES_CENTER', '主內容及中間區域');
define('_MA_TAD_THEMES_RIGHT', '右區域');
define('_MA_TAD_THEMES_FOOT', '頁尾');
define('_MA_TAD_THEMES_UPLOAD', '上傳');
define('_MA_TADTHEMES_NOTICE', "<ul style='line-height:2em;'>
  <li style='line-height:180%;list-style-position:outside;'>主內容區建議至少維持 550px 以上寬度！</li>
  <li style='line-height:180%;list-style-position:outside;'>切換「版面類型」時，部份欄位值會自動調整，或設為唯讀。</li>
  </ul>");
define('_MA_TADTHEMES_NOTICE2', "<ul style='line-height:2em;'>
  <li style='line-height:180%;list-style-position:outside;'>所有圖片亦可直接FTP上傳，系統會自動將之加入資料庫，並產生縮圖。
    <ul style='list-style-type:circle;margin-left:20px;'>
      <li style='line-height:180%;list-style-position:outside;'>頁面背景傳至：/themes/{$xoopsConfig['theme_set']}/images/bg</li>
      <li style='line-height:180%;list-style-position:outside;'>滑動圖片傳至：/themes/{$xoopsConfig['theme_set']}/images/slide</li>
      <li style='line-height:180%;list-style-position:outside;'>logo圖傳至：/themes/{$xoopsConfig['theme_set']}/images/logo</li>
      <li style='line-height:180%;list-style-position:outside;'>區塊背景傳至：/themes/{$xoopsConfig['theme_set']}/images/bt_bg</li>
      <li style='line-height:180%;list-style-position:outside;'>導覽列背景傳至：/themes/{$xoopsConfig['theme_set']}/images/nav_bg</li>
      <li style='line-height:180%;list-style-position:outside;'>導覽列logo圖傳至：/themes/{$xoopsConfig['theme_set']}/images/navlogo</li>
    </ul>
  </li>
  <li style='line-height:180%;list-style-position:outside;'>刪除圖片時，一律從後台刪除，勿直接刪除FTP圖片！</li>
  </ul>");
define('_MA_TADTHEMES_LOGO_PLACE', 'logo圖位置調整');
define('_MA_TADTHEMES_FONT_SIZE', '文字大小');
define('_MA_TADTHEMES_FONT_COLOR', '文字顏色');
define('_MA_TADTHEMES_LINK_COLOR', '連結顏色');
define('_MA_TADTHEMES_HOVER_COLOR', '移到連結顏色');
define('_MA_TADTHEMES_COL', '欄');
define('_MA_TADTHEMES_ITEMNAME', '選項名稱');
define('_MA_TADTHEMES_ITEMURL', '選項網址');
define('_MA_TADTHEMES_ADDITEM', '在「%s」底下建立一個選項');
define('_MA_TADTHEMES_SAVE_SORT', '拉動排序');
define('_MA_TADTHEMES_ROOT', '根目錄');
define('_MA_TADTHEMES_WEB_MENU', '主選單');
define('_MA_TADTHEMES_EDIT_MENU', '編輯功能');
define('_MA_TADTHEMES_EDIT_MENU_TADNEWS', '發布文章');
define('_MA_TADTHEMES_EDIT_MENU_TAD_LINK', '新增連結');
define('_MA_TADTHEMES_EDIT_MENU_TADGALLERY', '上傳照片');
define('_MA_TADTHEMES_EDIT_MENU_TAD_TIMELINE', '新增記事');
define('_MA_TADTHEMES_EDIT_MENU_TAD_MEETING', '建立會議');
define('_MA_TADTHEMES_EDIT_MENU_TAD_HONOR', '新增榮譽榜');
define('_MA_TADTHEMES_EDIT_MENU_TAD_UPLOADER', '檔案上傳');
define('_MA_TADTHEMES_EDIT_MENU_TAD_TADBOOK3', '新增書籍');
define('_MA_TADTHEMES_EDIT_MENU_TAD_CAL', '新增行事曆');
define('_MA_TADTHEMES_EDIT_MENU_TAD_FAQ', '新增問答');
define('_MA_TADTHEMES_EDIT_MENU_TAD_PLAYER', '上傳影片');
define('_MA_TADTHEMES_EDIT_MENU_TAD_REPAIR', '填寫維修單');
define('_MA_TADTHEMES_IMPORT_MENU', '匯入主選單');
define('_MA_TADTHEMES_IMPORT_EDIT_MENU', '匯入各模組編輯選項');
define('_MA_TADTHEMES_BLOCK_TITLE', '區塊標題列');
define('_MA_TADTHEMES_BLOCK_TITLE_BUTTOM', '設定按鈕');
define('_MA_TADTHEMES_BLOCK_TITLE_PADDING', '標題縮排');
define('_MA_TADTHEMES_BLOCK_TITLE_RADIUS', '圓角設定');
define('_MA_TADTHEMES_BLOCK_TITLE_RADIUS_Y', '圓角');
define('_MA_TADTHEMES_BLOCK_TITLE_RADIUS_N', '不設定（直角）');
define('_MA_TADTHEMES_NAVBAR', '導覽工具列');
define('_MA_TADTHEMES_NAVBAR_POSITION', '導覽工具列位置');
define('_MA_TADTHEMES_NAVBAR_POSITION_1', '上方鎖定');
define('_MA_TADTHEMES_NAVBAR_POSITION_2', '下方鎖定');
define('_MA_TADTHEMES_NAVBAR_POSITION_3', '滑動圖文上方');
define('_MA_TADTHEMES_NAVBAR_POSITION_6', '滑動圖文下方');
define('_MA_TADTHEMES_NAVBAR_POSITION_4', '佈景預設呈現方式');
define('_MA_TADTHEMES_NAVBAR_POSITION_5', '不使用導覽列');
define('_MA_TADTHEMES_NAVBAR_BG_COLOR', '選項底色上方色');
define('_MA_TADTHEMES_TARGET_BLANK', '新視窗');
define('_MA_TADTHEMES_NAVBAR_COLOR', '選項文字顏色');
define('_MA_TADTHEMES_NAVBAR_COLOR_HOVER', '滑鼠移過時文字顏色');
define('_MA_TADTHEMES_NAVBAR_ICON_COLOR', '圖示顏色');
define('_MA_TADTHEMES_NAVBAR_ICON_WHITE', '白色圖示');
define('_MA_TADTHEMES_NAVBAR_ICON_BLACK', '黑色圖示');
define('_MA_TADTHEMES_CHANGE_KIND_DESC', '此佈景支援線上切換佈景類型，您可以在HTML固定寬度佈景或隨螢幕大小自動調整的自適應BootStrap佈景間切換');
define('_MA_TADTHEMES_CHANGE_KIND', '切換佈景類型');
define('_MA_TADTHEMES_ITEMICON', '上傳項目圖示');
define('_MA_TADTHEMES_ITEMBANNER', '上傳項目專屬橫幅');
define('_MA_TADTHEMES_CONFIG2', '額外設定');
define('_MA_TADTHEMES_DEFAULT', '預設值');
define('_MA_TADTHEMES_BLOCK_POSITION', '欲設定的區域');
define('_MA_TADTHEMES_BLOCK_ALL_POSITION', '套用到所有區域');
define('_MA_TADTHEMES_BLOCK_LEFT', '左區域');
define('_MA_TADTHEMES_BLOCK_RIGHT', '右區域');
define('_MA_TADTHEMES_BLOCK_TOP_CENTER', '上中區域');
define('_MA_TADTHEMES_BLOCK_TOP_LEFT', '上中左區域');
define('_MA_TADTHEMES_BLOCK_TOP_RIGHT', '上中右區域');
define('_MA_TADTHEMES_BLOCK_BOTTOM_CENTER', '下中區域');
define('_MA_TADTHEMES_BLOCK_BOTTOM_LEFT', '下中左區域');
define('_MA_TADTHEMES_BLOCK_BOTTOM_RIGHT', '下中右區域');
define('_MA_TADTHEMES_BLOCK_FOOTER_CENTER', '頁尾中區域');
define('_MA_TADTHEMES_BLOCK_FOOTER_LEFT', '頁尾左區域');
define('_MA_TADTHEMES_BLOCK_FOOTER_RIGHT', '頁尾右區域');
define('_MA_TADTHEMES_BLOCK_TITLE_SIZE', '文字大小');
define('_MA_TADTHEMES_TO_DEFAULT', '恢復成預設值');
define('_MA_TADTHEMES_DEL_CONFIRM', '這會清除此佈景所有設定，並恢復成預設值！確定要執行？');
define('_MA_TADTHEMES_BASE_COLOR', '內容區顏色');
define('_MA_TADTHEMES_NAVBAR_IMG', '導覽列背景圖');
define('_MA_TADTHEMES_BLOCK_STYLE', '區塊整體樣式手動設定');
define('_MA_TADTHEMES_BLOCK_TITLE_STYLE', '區塊標題樣式手動設定');
define('_MA_TADTHEMES_BLOCK_CONTENT_STYLE', '區塊內容樣式手動設定');
define('_MA_TADTHEMES_YOUR_STYLE', '您設定的樣式內容');
define('_MA_TADTHEMES_TARGET_FANCYBOX', '燈箱效果');
define('_MA_TADTHEMES_OF_LEVEL', '父分類');
define('_MA_TADTHEMES_ICON', '選擇圖示');
define('_MA_TADTHEMES_LOGO_CENTER', '置中');
define('_MA_TADTHEMES_SAVE', '暫存當前佈景設定');
define('_MA_TADTHEMES_CONFIG_NAME', '請自訂佈景設定名稱');
define('_MA_TADTHEMES_CONFIG_PATH', '已成功存至 %s');
define('_MA_TADTHEMES_APPLY_OK', '已成功套用 %s');
define('_MA_TADTHEMES_DEL_OK', '已成功刪除 %s');
define('_MA_TADTHEMES_EXPORT', '匯出佈景設定檔');
define('_MA_TADTHEMES_IMPORT', '匯入佈景設定檔');
define('_MA_TADTHEMES_APPLY', '套用');
define('_MA_TADTHEMES_MANAGER', '管理佈景設定檔');
define('_MA_TADTHEMES_IMPORT_OK', '已成功匯入 %s，接著可套用之試試');
define('_MA_TADTHEMES_IMPORT_FAIL', '匯入失敗，該設定檔僅支援 %s 佈景');
define('_MA_TADTHEMES_IMPORT_STYLE', '遠端匯入佈景設定檔');

define('_MA_TADTHEMES_NAVBAR_PY', '選項上下間距');
define('_MA_TADTHEMES_NAVBAR_PX', '選項左右間距');

define('_MA_TADTHEMES_LOGO_MT', 'Logo 上方間距');
define('_MA_TADTHEMES_LOGO_MB', 'Logo 下方間距');
define('_MA_TADTHEMES_LOGO_DESIGN', '簡易Logo設計');
define('_MA_TADTHEMES_LOGO_INPUT_TEXT', '輸入文字');
define('_MA_TADTHEMES_LOGO_TEXT_COLOR', '文字顏色');
define('_MA_TADTHEMES_LOGO_BORDER_COLOR', '邊框顏色');
define('_MA_TADTHEMES_LOGO_TEXT_SIZE', '文字大小');
define('_MA_TADTHEMES_LOGO_BORDER_SIZE', '外框粗細');
define('_MA_TADTHEMES_LOGO_SHADOW_COLOR', '陰影顏色');
define('_MA_TADTHEMES_LOGO_SHADOW_SIZE', '陰影大小');
define('_MA_TADTHEMES_LOGO_SHADOW_X', '陰影左右位置');
define('_MA_TADTHEMES_LOGO_SHADOW_Y', '陰影上下位置');
define('_MA_TADTHEMES_LOGO_SELECT_FONT', '選擇字型');
define('_MA_TADTHEMES_LOGO_MAKE_PNG', '產生圖片');
define('_MA_TADTHEMES_LOGO_NEED_FONT', '請至少先上傳一個字型');
define('_MA_TADTHEMES_LOGO_SAVE_PIC', '儲存圖片');
define('_MA_TADTHEMES_LOGO_SAVE_AS_LOGO', '存為logo');
define('_MA_TADTHEMES_LOGO_DEMO_BGCOLOR', '範例背景色：');
define('_MA_TADTHEMES_FONT_TOOL', '字型檔管理');
define('_MA_TADTHEMES_FONT_UPLOAD', '上傳字型檔');
define('_MA_TADTHEMES_FONT_NOTE', '僅支援 ttf、otf、ttc 字型檔，若無字型，可參考<a href="https://mrmad.com.tw/free-chinese-font" target="_blank">免費中文字體總整理，可用於商業使用</a>或<a href="http://www.fonts.net.cn/commercial-free-32767/fonts-zh-1.html" target="_blank">這裡</a>');
define('_MA_TADTHEMES_FONT_SAVE', '儲存字型檔');
define('_MA_TADTHEMES_READGROUP', '可讀群組');
define('_MA_TADTHEMES_APPLY_READGROUP', '下層選項套用相同權限');

define('_MA_TADTHEMES_NAVBAR_FONT_SIZE', '選項文字大小');
define('_MA_TADTHEMES_NAVBAR_CHANGE', '選項底色下方色');
define('_MA_TADTHEMES_NAVBAR_HOVER_COLOR', '滑鼠移過時底色');

define('_MA_TADTHEMES_EXPAND_ALL', '全部展開');
define('_MA_TADTHEMES_COLLAPSE_ALL', '全部闔起');

define('_MA_TADTHEMES_EDIT_MENU_TAD_BLOCKS', '新增自訂區塊');
define('_MA_TADTHEMES_EDIT_MENU_TAD_GPHOTOS', '加入Google相簿');
define('_MA_TADTHEMES_EDIT_MENU_TAD_FORM', '新增萬用表單');
define('_MA_TADTHEMES_EDIT_MENU_JILL_NOTICE', '新增臨時公告');
define('_MA_TADTHEMES_EDIT_MENU_JILL_BOOKING', '預約場地');

define('_MA_TADTHEMES_DOWNLOAD', '下載');
define('_MA_TADTHEMES_DL_FAIL', '「%s」下載失敗！');
