<div class="thumb_div">
    <label for="<{$config.name}>0" class="thumb_none">
    <input type="radio" name="<{$config.name}>" id="<{$config.name}>0" value="" <{if $config.value==""}>checked<{/if}>>
        <{$smarty.const._MA_TADTHEMES_NONE}>
    </label>
</div>

<{if $config.default}>
    <div class="thumb_div">
        <label for="<{$config.name}>" class="thumb_label" style="background-image: url('<{$xoops_url}>/themes/school2019/images/config2/<{$config.default}>'), url('../images/t.gif');" >
        <input type="radio" name="<{$config.name}>" id="<{$config.name}><{$file.files_sn}>" value="<{$config.default}>"  <{if $config.value==$config.default}>checked<{/if}>>
        </label>
        <label style="font-size: 0.678em;">
            <{$smarty.const._MA_TADTHEMES_DEFAULT}>
        </label>
    </div>
<{/if}>

<{foreach from=$config.list item=file}>
    <div class="thumb_div">
        <label for="<{$config.name}><{$file.files_sn}>" class="thumb_label" style="background-image: url('<{$file.tb_path}>'), url('../images/t.gif');" >
            <input type="radio" name="<{$config.name}>" id="<{$config.name}><{$file.files_sn}>" value="<{$file.file_name}>" onChange="$('.del_<{$config.name}>').show(); $('#del_<{$config.name}><{$file.files_sn}>').hide();" <{if $config.value==$file.file_name}>checked<{/if}>>
        </label>
        <label class="del_<{$config.name}>" style="font-size: 0.678em;" id="del_<{$config.name}><{$file.files_sn}>">
            <input type="checkbox" value="<{$file.files_sn}>" name="del_file[<{$file.files_sn}>]"> <{$smarty.const._TAD_DEL}>
        </label>
    </div>
<{/foreach}>
<div style="clear:both;"></div>