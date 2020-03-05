<h2><{$smarty.const._MA_TADTHEMES_MANAGER}></h2>
<input type="hidden" name="theme_name" value="<{$theme_name}>">
<input type="hidden" name="theme_id" value="<{$theme_id}>">
<table class="table" style="width: auto;">
    <tr>
        <td colspan=2>
            <input name="theme_config_name" class="form-control" placeholder="<{$smarty.const._MA_TADTHEMES_CONFIG_NAME}>" list="theme_config_list">

            <datalist id="theme_config_list">
                <{foreach from=$theme_config_list item=title}>
                    <option value="<{$title}>">
                <{/foreach}>
            </datalist>
        </td>
        <td>
            <button type="submit" name="op" value="save_config" class="btn btn-info"><{$smarty.const._MA_TADTHEMES_SAVE}></button>
        </td>
    </tr>
    <{foreach from=$theme_config_list key=date item=title}>
        <tr>
            <td><{$title}></td>
            <td style="font-size:11px;"><{$date}></td>
            <td>
                <a href="javascript:delete_theme_config('<{$title}>')" class="btn btn-sm btn-xs btn-danger"><{$smarty.const._TAD_DEL}></a>
                <a href="main.php?op=download_zip&theme_config_name=<{$title}>&theme_id=<{$theme_id}>&theme_name=<{$theme_name}>" class="btn btn-sm btn-xs btn-success"><{$smarty.const._MA_TADTHEMES_DOWNLOAD}></a>
                <a href="main.php?op=apply_config&theme_config_name=<{$title}>&theme_id=<{$theme_id}>&theme_name=<{$theme_name}>" class="btn btn-sm btn-xs btn-info"><{$smarty.const._MA_TADTHEMES_APPLY}></a>
            </td>
        </tr>
    <{/foreach}>
    <tr>
        <td colspan=2>
            <input type="file" class="form-control" name="config_zip">
        </td>
        <td>
            <button type="submit" name="op" value="import_config" class="btn btn-success"><{$smarty.const._MA_TADTHEMES_IMPORT}></button>
        </td>
    </tr>
</table>
