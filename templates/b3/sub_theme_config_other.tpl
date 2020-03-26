<div class="form-group">
    <label class="col-sm-2 control-label">
        <{$config.text}>
    </label>
    <div class="col-sm-5">
        <{if $config.type=="text"}>
            <input type="text" name="<{$config.name}>" value="<{$config.value}>" data-toggle="tooltip" title="<{$config.default}>" class="form-control">
        <{elseif $config.type=="color"}>
            <input type="text" name="<{$config.name}>" id="<{$config.name}>" value="<{$config.value}>" data-toggle="tooltip" title="<{$config.default}>" class="form-control color-picker" data-hex="true" >
        <{elseif $config.type=="array"}>
            <textarea name="<{$config.name}>" class="form-control" rows=4 style="font-size:0.8em;" data-toggle="tooltip" title="<{$config.default}>"><{$config.value}></textarea>
        <{elseif $config.type=="textarea"}>
            <textarea name="<{$config.name}>" class="form-control" rows=4 style="font-size:0.8em;" data-toggle="tooltip" title="<{$config.default}>"><{$config.value}></textarea>
        <{elseif $config.type=="yesno"}>
            <label class="radio-inline">
                <input type="radio" name="<{$config.name}>" id="<{$config.name}>1" value="1" <{if $config.value==1}>checked<{/if}> ><{$smarty.const._YES}>
            </label>
            <label class="radio-inline">
                <input type="radio" name="<{$config.name}>" id="<{$config.name}>0" value="0" <{if $config.value==0}>checked<{/if}> ><{$smarty.const._NO}>
            </label>
        <{elseif $config.type=="file"}>
            <{$config.form}>
        <{/if}>
    </div>
    <div class="col-sm-5">
        <{if $config.type=="file"}>
            <{if $config.list}>
                <div class="thumb_div">
                    <label for="<{$config.name}>0" class="thumb_none" >
                    <input type="radio" name="<{$config.name}>" id="<{$config.name}>0" value="" <{if $config.value==""}>checked<{/if}>>
                    <{$smarty.const._MA_TADTHEMES_NONE}>
                    </label>
                </div>

                <{if $config.default}>
                    <div class="thumb_div">
                        <label for="<{$config.name}>" class="thumb_label" style="background-image: url('<{$config.default}>'), url('../images/t.gif');" >
                        <input type="radio" name="<{$config.name}>" id="<{$config.name}><{$file.files_sn}>" value="<{$config.default}>"  <{if $config.value==$config.default}>checked<{/if}>>
                        </label>
                        <label style="font-size:11px;">
                            <{$smarty.const._MA_TADTHEMES_DEFAULT}>
                        </label>
                    </div>
                <{/if}>

                <{foreach from=$config.list item=file}>
                    <div class="thumb_div">
                        <label for="<{$config.name}><{$file.files_sn}>" class="thumb_label" style="background-image: url('<{$file.tb_path}>'), url('../images/t.gif');" >
                            <input type="radio" name="<{$config.name}>" id="<{$config.name}><{$file.files_sn}>" value="<{$file.file_name}>" onChange="$('.del_<{$config.name}>').show(); $('#del_<{$config.name}><{$file.files_sn}>').hide();" <{if $config.value==$file.file_name}>checked<{/if}>>
                        </label>
                        <label class="del_<{$config.name}>" style="font-size:11px;" id="del_<{$config.name}><{$file.files_sn}>">
                            <input type="checkbox" value="<{$file.files_sn}>" name="del_file[<{$file.files_sn}>]"> <{$smarty.const._TAD_DEL}>
                        </label>
                    </div>
                <{/foreach}>
                <div style="clear:both;"></div>
            <{/if}>
        <{else}>
            <div class="alert alert-info"><{$config.desc}></div>
        <{/if}>
    </div>
</div>