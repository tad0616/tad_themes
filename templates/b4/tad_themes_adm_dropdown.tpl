<style>
    li{list-style:none;}
</style>

<script type="text/javascript">
    function delete_tad_themes_menu_func(menuid){
        var sure = window.confirm("<{$smarty.const._TAD_DEL_CONFIRM}>");
        if (!sure)  return;
        location.href="dropdown.php?op=delete_tad_themes_menu&menuid=" + menuid;
    }

    function delete_tad_themes_pic(del_type , menuid){
        var sure = window.confirm("<{$smarty.const._TAD_DEL_CONFIRM}>");
        if (!sure)  return;
        location.href="dropdown.php?op=del_pic&type=" + del_type + "&menuid=" + menuid;
    }
</script>

<p>
    <a href="dropdown.php?op=import" class="btn btn-info"><{$smarty.const._MA_TADTHEMES_IMPORT_MENU}></a>
    <a href="#" onclick="jQuery('#tbl').treetable('expandAll'); return false;" class="btn btn-success">Expand all</a>
    <a href="#" onclick="jQuery('#tbl').treetable('collapseAll'); return false;" class="btn btn-warning">Collapse all</a>
</p>

<table id="tbl" class="table table-condensed" style="width:auto;">
    <tr data-tt-id="0" id="node-_0">
        <td colspan=2 >
            <a href="dropdown.php?op=add_tad_themes_menu&of_level=0" class="edit_dropdown" data-fancybox-type="iframe"  style="letter-spacing: 0em; font-size: 20px;">
            <{$add_item}>
            <i class="fa fa-plus-circle text-success" aria-hidden="true" title="<{$add_item}>" style="font-size:24px;margin:0px 10px;"></i></a>
        </td>
    <tr>
    <{if $all}>
        <tbody class="sort">
            <{$all}>
            <{$option}>
        </tbody>
    <{/if}>
</table>
<p id="save_msg"></p>