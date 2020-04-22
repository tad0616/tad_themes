<{if $config.type=="bg_file"}>
<div class="alert alert-success">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label text-sm-right control-label">
                    <{$config.text}>
                </label>
                <div class="col-sm-8">
                        <{$config.form}>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label text-sm-right control-label">
                    <{$config.text}><{$smarty.const._MA_TADTHEMES_BG_ATTR}>
                </label>
                <div class="col-sm-3">
                    <select name="<{$config.name}>_repeat" id="<{$config.name}>_repeat" class="form-control">
                        <{foreach from=$config.options.repeat key=val item=opt}>
                            <option value="<{$val}>" <{if $config.repeat==$val}>selected<{/if}>><{$opt}></option>
                        <{/foreach}>
                    </select>
                </div>
                <div class="col-sm-2">
                    <select name="<{$config.name}>_position" id="<{$config.name}>_position" class="form-control">
                        <{foreach from=$config.options.position key=val item=opt}>
                            <option value="<{$val}>" <{if $config.position==$val}>selected<{/if}>><{$opt}></option>
                        <{/foreach}>
                    </select>
                </div>
                <div class="col-sm-3">
                    <select name="<{$config.name}>_size" id="<{$config.name}>_size" class="form-control">
                        <{foreach from=$config.options.size key=val item=opt}>
                            <option value="<{$val}>" <{if $config.size==$val}>selected<{/if}>><{$opt}></option>
                        <{/foreach}>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_thumbs.tpl"}>
        </div>
    </div>
</div>
<{else}>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label text-sm-right control-label">
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
                <div class="form-check form-check-inline radio-inline">
                    <label class="form-check-label" for="<{$config.name}>1">
                        <input class="form-check-input" type="radio" name="<{$config.name}>" id="<{$config.name}>1" value="1" <{if $config.value==1}>checked<{/if}>>
                        <{$smarty.const._YES}>
                    </label>
                </div>
                <div class="form-check form-check-inline radio-inline">
                    <label class="form-check-label" for="<{$config.name}>0">
                        <input class="form-check-input" type="radio" name="<{$config.name}>" id="<{$config.name}>0" value="0" <{if $config.value==0}>checked<{/if}>>
                        <{$smarty.const._NO}>
                    </label>
                </div>
            <{elseif $config.type=="radio"}>
                <{foreach from=$config.options key=val item=opt}>
                    <div class="form-check form-check-inline radio-inline">
                        <label class="form-check-label" for="<{$config.name}>_<{$val}>">
                            <input class="form-check-input" type="radio" name="<{$config.name}>" id="<{$config.name}>_<{$val}>" value="<{$val}>" <{if $config.value==$val}>checked<{/if}>>
                            <{$opt}>
                        </label>
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
                <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_thumbs.tpl"}>
            <{else}>
                <div class="alert alert-info"><{$config.desc}></div>
            <{/if}>
        </div>
    </div>
<{/if}>