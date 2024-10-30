<{if $config.type=="bg_file"}>
    <{include file="$xoops_rootpath/modules/tad_themes/templates/sub_bg_file.tpl"}>
<{elseif $config.type=="custom_zone"}>
    <{include file="$xoops_rootpath/modules/tad_themes/templates/sub_custom_zone.tpl"}>
<{else}>
    <div class="form-group row mb-3">
        <label class="col-sm-2 col-form-label text-sm-right text-sm-end control-label">
            <{$config.text}>
        </label>
        <div class="col-sm-5">
            <{if $config.type=="text"}>
                <input type="text" name="<{$config.name}>" value="<{$config.value}>" class="form-control">
            <{elseif $config.type=="color"}>
                <div class="input-group">
                    <input type="text" name="<{$config.name}>" id="<{$config.name}>" value="<{$config.value}>" class="form-control color-picker"  data-hex="true">
                </div>
            <{elseif $config.type=="array"}>
                <textarea name="<{$config.name}>" class="form-control" rows=4 style="font-size:0.8em;"><{$config.value}></textarea>
            <{elseif $config.type=="textarea"}>
                <textarea name="<{$config.name}>" class="form-control" rows=4 style="font-size:0.8em;"><{$config.value}></textarea>
            <{elseif $config.type=="yesno"}>
                <div class="form-check form-check-inline radio-inline">
                    <label class="form-check-label" for="<{$config.name}>1">
                        <input class="form-check-input" type="radio" name="<{$config.name}>" id="<{$config.name}>1" value="1" <{if $config.value|default:'1'=='1'}>checked="checked"<{/if}>>
                        <{$smarty.const._YES}>
                    </label>
                </div>
                <div class="form-check form-check-inline radio-inline">
                    <label class="form-check-label" for="<{$config.name}>0">
                        <input class="form-check-input" type="radio" name="<{$config.name}>" id="<{$config.name}>0" value="0" <{if $config.value|default:''=='0'}>checked="checked"<{/if}>>
                        <{$smarty.const._NO}>
                    </label>
                </div>
            <{elseif $config.type=="radio"}>
                <{foreach from=$config.options key=val item=opt}>
                    <div class="form-check form-check-inline radio-inline">
                        <label class="form-check-label" for="<{$config.name}>_<{$val|default:''}>">
                            <input class="form-check-input" type="radio" name="<{$config.name}>" id="<{$config.name}>_<{$val|default:''}>" value="<{$val|default:''}>" <{if $config.value==$val}>checked<{/if}>>
                            <{$opt|default:''}>
                        </label>
                    </div>
                <{/foreach}>
            <{elseif $config.type=="checkbox"}>
                <{foreach from=$config.options key=val item=opt}>
                    <div class="form-check form-check-inline checkbox-inline">
                        <label class="form-check-label" for="<{$config.name}>_<{$val|default:''}>">
                            <input class="form-check-input" type="checkbox" name="<{$config.name}>[]" id="<{$config.name}>_<{$val|default:''}>" value="<{$val|default:''}>" <{if $config.value|is_array && $val|in_array:$config.value}>checked<{/if}>>
                            <{$opt|default:''}>
                        </label>
                        <{if $val=='block'}>
                            <{assign var="conf_name" value=$config.name}>
                            <select name="<{$config.name}>_bid" style="border: 1px solid #acacac">
                                <option value="" <{if $bid == ""}>selected<{/if}>></option>
                                <{foreach from=$blocks key=mod_name item=mod_blocks}>
                                    <optgroup label="<{$mod_name|default:''}>">
                                        <{foreach from=$mod_blocks key=bid item=block}>
                                            <option value="<{$bid|default:''}>" <{if $bid == $config.bid}>selected<{/if}>>
                                                <{if $block.name|strpos:$smarty.const._MA_TADTHEMES_BLOCKS_CUSTOM !== false}>
                                                    <{$block.title}><{$block.name|replace:$smarty.const._MA_TADTHEMES_BLOCKS_CUSTOM:''}>
                                                <{elseif $block.title|strpos:$block.name !== false}>
                                                    <{$block.name}>
                                                <{else}>
                                                    <{$block.name}> (<{$block.title}>)
                                                <{/if}>
                                            </option>
                                        <{/foreach}>
                                    </optgroup>
                                <{/foreach}>
                            </select>
                            <{if $config.bid|default:false}>
                                <{if $adv_bids|is_array && $config.bid|in_array:$adv_bids}>
                                    <a href="<{$xoops|default:''}>/modules/tad_blocks/index.php?op=block_form&bid=<{$config.bid}>" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>  <{$smarty.const._TAD_EDIT}></a>
                                <{else}>
                                    <a href="<{$xoops|default:''}>/modules/system/admin.php?fct=blocksadmin&op=edit&bid=<{$config.bid}>" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>  <{$smarty.const._TAD_EDIT}></a>
                                <{/if}>
                            <{/if}>
                        <{/if}>
                    </div>
                <{/foreach}>
            <{elseif $config.type=="select"}>
                <select name="<{$config.name}>" id="<{$config.name}>" class="form-control">
                    <{foreach from=$config.options key=val item=opt}>
                        <option value="<{$val|default:''}>" <{if $config.value==$val}>selected<{/if}>><{$opt|default:''}></option>
                    <{/foreach}>
                </select>
            <{elseif $config.type=="selectpicker"}>
                <select name="<{$config.name}>" id="<{$config.name}>" class="form-control selectpicker">
                    <{foreach from=$config.options key=val item=opt}>
                        <option data-content="<img src='<{$config.images.$val}>'> <{$opt|default:''}>" value="<{$val|default:''}>" <{if $config.value==$val}>selected<{/if}>></option>
                    <{/foreach}>
                </select>
            <{elseif $config.type=="file"}>
                <{$config.form}>
            <{elseif $config.type=="padding_margin"}>
                <div class="input-group">
                    <div class="input-group-prepend input-group-addon">
                        <span class="input-group-text"><{$smarty.const._MA_TADTHEMES_TOPSIDE}></span>
                    </div>
                    <input type="text" name="<{$config.name}>_mt" class="form-control" value="<{$config.mt}>">
                    <div class="input-group-prepend input-group-addon">
                        <span class="input-group-text"><{$smarty.const._MA_TADTHEMES_PADDING}></span>
                    </div>
                    <input type="text" name="<{$config.name}>" class="form-control" value="<{$config.value}>">
                    <div class="input-group-prepend input-group-addon">
                        <span class="input-group-text"><{$smarty.const._MA_TADTHEMES_BOTTOMSIDE}></span>
                    </div>
                    <input type="text" name="<{$config.name}>_mb" class="form-control" value="<{$config.mb}>">
                </div>
            <{/if}>
        </div>
        <div class="col-sm-5">
            <{if $config.type=="file"}>
                <{include file="$xoops_rootpath/modules/tad_themes/templates/sub_thumbs.tpl"}>
            <{else}>
                <div class="alert alert-info"><{$config.desc}></div>
            <{/if}>
        </div>
    </div>
<{/if}>