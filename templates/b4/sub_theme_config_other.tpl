<div class="form-group row">
    <label class="col-sm-2 col-form-label text-sm-right">
        <{$config.text}>
    </label>
    <div class="col-sm-5">
        <{if $config.type=="text"}>
            <input type="text" name="<{$config.name}>" value="<{$config.value}>" data-toggle="tooltip" title="<{$config.default}>" class="form-control">
        <{elseif $config.type=="color"}>
            <input type="text" name="<{$config.name}>" id="<{$config.name}>" value="<{$config.value}>"  data-toggle="tooltip" title="<{$config.default}>" class="form-control color-picker" data-hex="true" >
        <{elseif $config.type=="array"}>
            <textarea name="<{$config.name}>" class="form-control" rows=4 style="font-size:0.8em;" data-toggle="tooltip" title="<{$config.default}>"><{$config.value}></textarea>
        <{elseif $config.type=="textarea"}>
            <textarea name="<{$config.name}>" class="form-control" rows=4 style="font-size:0.8em;" data-toggle="tooltip" title="<{$config.default}>"><{$config.value}></textarea>
        <{elseif $config.type=="yesno"}>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="<{$config.name}>" id="<{$config.name}>1" value="1" <{if $config.value==1}>checked<{/if}>>
                <label class="form-check-label" for="<{$config.name}>1"><{$smarty.const._YES}></label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="<{$config.name}>" id="<{$config.name}>0" value="0" <{if $config.value==0}>checked<{/if}>>
                <label class="form-check-label" for="<{$config.name}>0"><{$smarty.const._NO}></label>
            </div>
        <{elseif $config.type=="radio"}>
            <{foreach from=$config.options key=val item=opt}>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="<{$config.name}>" id="<{$config.name}>_<{$val}>" value="<{$val}>" <{if $config.value==$val}>checked<{/if}>>
                    <label class="form-check-label" for="<{$config.name}>_<{$val}>"><{$opt}></label>
                </div>
            <{/foreach}>
        <{elseif $config.type=="select"}>
            <select name="<{$config.name}>" id="<{$config.name}>" class="form-control">
                <{foreach from=$config.options key=val item=opt}>
                    <option value="<{$val}>" <{if $config.value==$val}>selected<{/if}>><{$opt}></option>
                <{/foreach}>
            </select>
        <{elseif $config.type=="selectpicker"}>
            <select name="<{$config.name}>" id="<{$config.name}>" class="form-control selectpicker">
                <{foreach from=$config.options key=val item=opt}>
                    <option data-content="<img src='<{$config.images.$val}>'> <{$opt}>" value="<{$val}>" <{if $config.value==$val}>selected<{/if}>></option>
                <{/foreach}>
            </select>
        <{elseif $config.type=="file"}>
            <{$config.form}>
        <{/if}>
    </div>
    <div class="col-sm-5">
        <{if $config.type=="file"}>
            <{if $config.list}>
                <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                    <label for="<{$config.name}>0" style="width:60px; height:60px;border:1px dotted gray;" >
                    <input type="radio" name="<{$config.name}>" id="<{$config.name}>0" value="" <{if $config.value==""}>checked<{/if}>>
                    <{$smarty.const._MA_TADTHEMES_NONE}>
                    </label>
                </div>

                <{if $config.default}>
                    <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                        <label for="<{$config.name}>" style="width:60px; height:60px; background:#000000 url(<{$config.default}>);background-repeat:no-repeat;background-position:left center;border:1px solid gray;background-size: cover;" >
                        <input type="radio" name="<{$config.name}>" id="<{$config.name}><{$file.files_sn}>" value="<{$config.default}>"  <{if $config.value==$config.default}>checked<{/if}>>
                        </label>
                        <label style="font-size:11px;">
                            <{$smarty.const._MA_TADTHEMES_DEFAULT}>
                        </label>
                    </div>
                <{/if}>

                <{foreach from=$config.list item=file}>
                    <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                        <label for="<{$config.name}><{$file.files_sn}>" style="width:60px; height:60px; background:#000000 url(<{$file.tb_path}>);background-position:left center;border:1px solid gray;" >
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
