<h2><{$smarty.const._MA_TADTHEMES_MANAGER}></h2>
<input type="hidden" name="theme_name" value="<{$theme_name|default:''}>">
<input type="hidden" name="theme_id" value="<{$theme_id|default:''}>">
<table class="table" style="width: auto;">
    <tr>
        <td colspan=2>
            <input name="theme_config_name" class="form-control" placeholder="<{$smarty.const._MA_TADTHEMES_CONFIG_NAME}>" list="theme_config_list">

            <datalist id="theme_config_list">
                <{foreach from=$theme_config_list item=title}>
                    <option value="<{$title|default:''}>">
                <{/foreach}>
            </datalist>
        </td>
        <td>
            <button type="submit" name="op" value="save_config" class="btn btn-primary"><{$smarty.const._MA_TADTHEMES_SAVE}></button>
        </td>
    </tr>
    <tr>
        <td colspan=2>
            <select name="style_param" class="form-control form-select">
                <{foreach from=$style_arr key=module_name item=style}>
                    <option value="<{$module_name|default:''}>;<{$style.file_link}>;<{$style.update_sn}>;<{$style.module_sn}>"><{$module_name|default:''}> <{$style.new_last_update|date_format:"%Y-%m-%d"}></option>
                <{/foreach}>
            </select>
        </td>
        <td>
            <button type="submit" name="op" value="import_style" class="btn btn-info"><{$smarty.const._MA_TADTHEMES_IMPORT_STYLE}></button>
        </td>
    </tr>
    <{*
    <{if $themes}>
    <tr>
        <td colspan=2>
            <select name="from_theme_id" class="form-control form-select">
                <{foreach from=$themes key=from_theme_id item=from_theme_name}>
                    <option value="<{$from_theme_id|default:''}>"><{$from_theme_name|default:''}></option>
                <{/foreach}>
            </select>
        </td>
        <td>
            <button type="submit" name="op" value="copy_theme" class="btn btn-warning"><{$smarty.const._MA_TADTHEMES_COPY_THEME}></button>
        </td>
    </tr>
    <{/if}>
    *}>
    <tr>
        <td colspan=2>
            <input type="file" class="form-control" name="config_zip">
        </td>
        <td>
            <button type="submit" name="op" value="import_config" class="btn btn-success"><{$smarty.const._MA_TADTHEMES_IMPORT}></button>
        </td>
    </tr>
    <{foreach from=$theme_config_list key=date item=title}>
        <tr>
            <td><{$title|default:''}></td>
            <td style="font-size: 0.678em;"><{$date|default:''}></td>
            <td>
                <a href="javascript:delete_theme_config('<{$title|default:''}>')" class="btn btn-sm btn-xs btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> <{$smarty.const._TAD_DEL}></a>
                <a href="main.php?op=download_zip&theme_config_name=<{$title|default:''}>&theme_id=<{$theme_id|default:''}>&theme_name=<{$theme_name|default:''}>" class="btn btn-sm btn-xs btn-success"><{$smarty.const._MA_TADTHEMES_DOWNLOAD}></a>
                <a href="main.php?op=apply_config&theme_config_name=<{$title|default:''}>&theme_id=<{$theme_id|default:''}>&theme_name=<{$theme_name|default:''}>" class="btn btn-sm btn-xs btn-info"><{$smarty.const._MA_TADTHEMES_APPLY}></a>
            </td>
        </tr>
    <{/foreach}>
</table>


<script>
$(document).ready(function() {
    // 設置顏色對的關聯關係，用於在顏色選擇器內部移動時更新對比度
    if (typeof setupContrastRatioPairs === 'function') {
        setupContrastRatioPairs([
            {display: 'base_color_contrast', color1: 'base_color', color2: 'font_color'},
            {display: 'lb_color_contrast', color1: 'lb_color', color2: 'font_color'},
            {display: 'cb_color_contrast', color1: 'cb_color', color2: 'font_color'},
            {display: 'rb_color_contrast', color1: 'rb_color', color2: 'font_color'},
            {display: 'navbar_bg_top_contrast', color1: 'navbar_bg_top', color2: 'navbar_color'},
            {display: 'navbar_bg_bottom_contrast', color1: 'navbar_bg_bottom', color2: 'navbar_color'},
            {display: 'navbar_color_hover_contrast', color1: 'navbar_hover', color2: 'navbar_color_hover'},
            {display: 'navbar_hover_contrast', color1: 'navbar_color_hover', color2: 'navbar_hover'},
            {display: 'nav_side_bgcolor_contrast', color1: 'nav_side_bgcolor', color2: 'navbar_color'},
            {display: 'nav_sub_bg_color_contrast', color1: 'nav_sub_bg_color', color2: 'nav_sub_font_color'},
            {display: 'nav_sub_font_color_contrast', color1: 'nav_sub_font_color', color2: 'nav_sub_bg_color'},
            {display: 'top_content_bgcolor_contrast', color1: 'top_content_bgcolor', color2: 'top_color'},
            {display: 'top_side_bgcolor_contrast', color1: 'top_side_bgcolor', color2: 'top_color'},
            {display: 'middle_content_bgcolor_contrast', color1: 'middle_content_bgcolor', color2: 'middle_color'},
            {display: 'middle_side_bgcolor_contrast', color1: 'middle_side_bgcolor', color2: 'middle_color'},
            {display: 'bottom_content_bgcolor_contrast', color1: 'bottom_content_bgcolor', color2: 'bottom_color'},
            {display: 'bottom_side_bgcolor_contrast', color1: 'bottom_side_bgcolor', color2: 'bottom_color'},
            {display: 'footer_content_bgcolor_contrast', color1: 'footer_content_bgcolor', color2: 'footer_color'},
            {display: 'footer_side_bgcolor_contrast', color1: 'footer_side_bgcolor', color2: 'footer_color'},
            {display: 'bt_bg_color_leftBlock_contrast', color1: 'bt_bg_color_leftBlock', color2: 'bt_text_leftBlock'},
            {display: 'bt_text_leftBlock_contrast', color1: 'bt_text_leftBlock', color2: 'bt_bg_color_leftBlock'},
            {display: 'bt_bg_color_rightBlock_contrast', color1: 'bt_bg_color_rightBlock', color2: 'bt_text_rightBlock'},
            {display: 'bt_text_rightBlock_contrast', color1: 'bt_text_rightBlock', color2: 'bt_bg_color_rightBlock'},
            {display: 'bt_bg_color_centerBlock_contrast', color1: 'bt_bg_color_centerBlock', color2: 'bt_text_centerBlock'},
            {display: 'bt_text_centerBlock_contrast', color1: 'bt_text_centerBlock', color2: 'bt_bg_color_centerBlock'},
            {display: 'bt_bg_color_centerLeftBlock_contrast', color1: 'bt_bg_color_centerLeftBlock', color2: 'bt_text_centerLeftBlock'},
            {display: 'bt_text_centerLeftBlock_contrast', color1: 'bt_text_centerLeftBlock', color2: 'bt_bg_color_centerLeftBlock'},
            {display: 'bt_bg_color_centerRightBlock_contrast', color1: 'bt_bg_color_centerRightBlock', color2: 'bt_text_centerRightBlock'},
            {display: 'bt_text_centerRightBlock_contrast', color1: 'bt_text_centerRightBlock', color2: 'bt_bg_color_centerRightBlock'},
            {display: 'bt_bg_color_centerBottomBlock_contrast', color1: 'bt_bg_color_centerBottomBlock', color2: 'bt_text_centerBottomBlock'},
            {display: 'bt_text_centerBottomBlock_contrast', color1: 'bt_text_centerBottomBlock', color2: 'bt_bg_color_centerBottomBlock'},
            {display: 'bt_bg_color_centerBottomLeftBlock_contrast', color1: 'bt_bg_color_centerBottomLeftBlock', color2: 'bt_text_centerBottomLeftBlock'},
            {display: 'bt_text_centerBottomLeftBlock_contrast', color1: 'bt_text_centerBottomLeftBlock', color2: 'bt_bg_color_centerBottomLeftBlock'},
            {display: 'bt_bg_color_centerBottomRightBlock_contrast', color1: 'bt_bg_color_centerBottomRightBlock', color2: 'bt_text_centerBottomRightBlock'},
            {display: 'bt_text_centerBottomRightBlock_contrast', color1: 'bt_text_centerBottomRightBlock', color2: 'bt_bg_color_centerBottomRightBlock'},
            {display: 'bt_bg_color_footerCenterBlock_contrast', color1: 'bt_bg_color_footerCenterBlock', color2: 'bt_text_footerCenterBlock'},
            {display: 'bt_text_footerCenterBlock_contrast', color1: 'bt_text_footerCenterBlock', color2: 'bt_bg_color_footerCenterBlock'},
            {display: 'bt_bg_color_footerLeftBlock_contrast', color1: 'bt_bg_color_footerLeftBlock', color2: 'bt_text_footerLeftBlock'},
            {display: 'bt_text_footerLeftBlock_contrast', color1: 'bt_text_footerLeftBlock', color2: 'bt_bg_color_footerLeftBlock'},
            {display: 'bt_bg_color_footerRightBlock_contrast', color1: 'bt_bg_color_footerRightBlock', color2: 'bt_text_footerRightBlock'},
            {display: 'bt_text_footerRightBlock_contrast', color1: 'bt_text_footerRightBlock', color2: 'bt_bg_color_footerRightBlock'},
            {display: 'back_to_top_contrast', color1: 'back_to_top', color2: 'back_to_top_txt'},
            {display: 'back_to_top_txt_contrast', color1: 'back_to_top_txt', color2: 'back_to_top'},
            {display: 'font_color_contrast', color1: 'font_color', color2: 'base_color'},
            {display: 'link_color_contrast', color1: 'link_color', color2: 'base_color'},
            {display: 'hover_color_contrast', color1: 'hover_color', color2: 'base_color'}
        ]);

        // 確保頁面完全加載後再計算對比度
        setTimeout(function() {
            if (typeof updateAllContrastRatios === 'function') {
                updateAllContrastRatios();
            }
        }, 100);
    }
});
</script>