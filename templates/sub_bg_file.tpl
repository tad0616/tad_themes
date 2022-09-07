<div class="alert alert-success">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group row mb-3">
                <label class="col-sm-4 col-form-label text-sm-right control-label">
                    <{$config.text}>
                </label>
                <div class="col-sm-8">
                    <{$config.form}>
                </div>
            </div>
            <div class="form-group row mb-3">
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