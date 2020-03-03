<h2><{$smarty.const._MA_TADTHEMES_MANAGER}></h2>
<form action="main.php" method="post" role="form" class="form-horizontal" enctype="multipart/form-data">
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
                <input type="hidden" name="theme_name" value="<{$theme_name}>">
                <input type="hidden" name="theme_id" value="<{$theme_id}>">
                <input type="hidden" name="op" value="save_config">
                <button type="submit" class="btn btn-primary"><{$smarty.const._MA_TADTHEMES_SAVE}></button>
            </td>
        </tr>
        <{foreach from=$theme_config_list key=date item=title}>
            <tr>
                <td><{$title}></td>
                <td><{$date}></td>
                <td>
                    <a href="javascript:delete_theme_config('<{$title}>')" class="btn btn-sm btn-danger">刪除</a>
                    <a href="main.php?op=download_zip&theme_config_name=<{$title}>&theme_id=<{$theme_id}>&theme_name=<{$theme_name}>" class="btn btn-sm btn-success">下載</a>
                    <a href="main.php?op=apply_config&theme_config_name=<{$title}>&theme_id=<{$theme_id}>&theme_name=<{$theme_name}>" class="btn btn-sm btn-primary">套用</a>
                </td>
            </tr>
        <{/foreach}>
    </table>
</form>