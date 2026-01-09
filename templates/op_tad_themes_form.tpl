<script type="text/javascript">
    $(document).ready(function(){

        $('select.selectpicker').selectpicker();
        change_css();
        preview_img("bg","<{$bg_img|default:''}>");

        <{if $logo_position=="page"}>
            $("#logo_place_setup").hide();
        <{else}>
            $("#logo_place_setup").show();
        <{/if}>
        $("#save_theme_config").sticky({topSpacing:0 , zIndex: 150});
    });

    function logo_place_setup(logo_position){
        if(logo_position=="page"){
            $("#logo_place_setup").hide();
        }else{
            $("#logo_place_setup").show();
        }
    }

    function preview_img(kind,imgSrc){
        var newimgSrc=imgSrc.replace(kind+"/", kind+"/thumbs/");
        var newImg = new Image();
        newImg.src = imgSrc;
        var height = newImg.height * 1;
        if(height > 90){
            $("#preview_zone").css("background-image","url("+newimgSrc+")");
        }else{
            $("#preview_zone").css("background-image","url("+imgSrc+")");
        }
    }

    <{$chang_css|default:''}>
</script>

<form action="main.php" method="post" class="my-3">
    <div class="row">
        <div class="col-auto">
            <div class="input-group">
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text"><{$smarty.const._MA_TADTHEMES_CHANGE}></span>
                </div>
                <select name="xoops_theme_select" id="xoops_theme_select" class="form-control form-select">
                    <option value=""></option>
                    <{foreach from=$school_themes item=school_theme_name}>
                        <option value="<{$school_theme_name|default:''}>"><{$school_theme_name|default:''}></option>
                    <{/foreach}>
                </select>
                <div class="input-group-append input-group-btn">
                    <button type="submit" name="op" value="change_theme" class="btn btn-primary">切換</button>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <{if $theme_set!=$theme_name}>
                <{$smarty.const._MA_TADTHEMES_CHANGE_DESC|sprintf:$theme_set:$theme_set_id:$theme_set:$theme_name:$theme_name:$theme_name}>
            <{/if}>
        </div>

    </div>
</form>

<div class="container-fluid">
    <form action="main.php" method="post" id="myForm" enctype="multipart/form-data" role="form" class="form-horizontal">
        <div class="row">
            <div class="col-sm-8">
                <h1>
                    <{$theme_name|default:''}><{$smarty.const._MA_TAD_THEMES_FORM}>

                    <a href="javascript:delete_tad_themes_config(<{$theme_id|default:''}>)" class="btn btn-danger"><{$smarty.const._MA_TADTHEMES_TO_DEFAULT}></a>
                </h1>
                <div class="alert alert-info">
                    <{$smarty.const._MA_TADTHEMES_CHANGE_KIND_DESC}>
                </div>

                <{if $theme_change|default:false}>
                    <{foreach from=$theme_kind_arr item=kind}>
                        <div class="form-check radio">
                            <label class="form-check-label" for="theme_kind">
                                <input class="form-check-input" type="radio" name="theme_kind" id="theme_kind" value="<{$kind|default:''}>" <{if $theme_kind==$kind}>checked<{/if}>>
                                <{$kind|default:''}>
                                <{$theme_kind_txt_arr.$kind}>
                            </label>
                        </div>
                    <{/foreach}>

                    <input type="hidden" name="old_theme_kind" value="<{$theme_kind|default:''}>">
                <{else}>
                    <p style="margin: 20px 0px;">
                        <{$theme_kind|default:''}><{$theme_kind_txt|default:''}>
                        <input type="hidden" name="theme_kind" value="<{$theme_kind|default:''}>">
                    </p>
                <{/if}>

                <div id="themeTab">
                    <ul class="resp-tabs-list tab_identifier_parent">
                        <!--頁籤-->
                        <{foreach from=$config2_files_arr key=config_file item=config}>
                            <{assign var="key" value=$config.key|default:''}>
                            <{if $config_tabs.$key|default:'' || $key|default:''==""}>
                                <{if $custom_tabs_data.$config_file|default:'' || $config.type=='config'}>
                                    <li><{$config.label}></li>
                                <{/if}>
                            <{/if}>
                        <{/foreach}>
                    </ul>

                    <div class="resp-tabs-container tab_identifier_parent">
                        <{foreach from=$config2_files_arr key=config_file item=config}>
                            <{if $custom_tabs_data.$config_file|default:false || $config.type=='config'}>
                                <{if $config.type=='config'}>
                                    <{assign var="key" value=$config.key}>
                                    <{if $config_tabs.$key|default:'' || $key|default:''==""}>
                                    <div>
                                        <{assign var="sub_theme_config" value="sub_theme_config_`$key`"}>
                                        <{include file="$xoops_rootpath/modules/tad_themes/templates/`$sub_theme_config`.tpl"}>

                                        <a href="<{$xoops_url}>/modules/tad_themes/admin/main.php?op=export_config&theme_id=<{$theme_id|default:''}>" class="btn btn-light btn-sm btn-xs text-secondary pull-right float-end mx-2">config.php</a>
                                    </div>
                                    <{else}>
                                        <{assign var="sub_theme_no_config" value="sub_theme_no_config_`$key`"}>
                                        <{include file="$xoops_rootpath/modules/tad_themes/templates/`$sub_theme_no_config`.tpl"}>
                                    <{/if}>
                                <{elseif $config.type=='config2'}>
                                    <div>
                                        <{assign var="custom_config2" value=$custom_tabs_data[$config_file]}>
                                        <input type="hidden" name="config2[]" value="<{$config_file|default:''}>">
                                        <{include file="$xoops_rootpath/modules/tad_themes/templates/`$config.tpl`.tpl"}>
                                        <a href="<{$xoops_url}>/modules/tad_themes/admin/main.php?op=export_config2&theme_id=<{$theme_id|default:''}>&config2_file=<{$config_file|default:''}>" class="btn btn-light btn-sm btn-xs text-secondary pull-right float-end mx-2"><{$config_file|default:''}>.php</a>
                                    </div>
                                <{/if}>
                            <{/if}>
                        <{/foreach}>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <!--預覽-->
                <div id='preview_zone'>
                    <div id='theme_demo' style='border:1px solid gray;background-color:white;margin:0px auto;'>
                        <div id='theme_top' style='border:1px solid #E0E0E0;background-color:#F0F0F0;margin:4px auto 2px auto;font-size: 0.678em;text-align:center;'><{$smarty.const._MA_TAD_THEMES_TOP}></div>
                        <div id='theme_head' style='border:1px solid #E0E0E0;background-color:#F0F0F0;margin:4px auto 2px auto;font-size: 0.678em;text-align:center;'><{$smarty.const._MA_TAD_THEMES_HEAD}></div>
                        <div id='left_block' style='border:1px solid #E0E0E0;background-color:#99CCFF;font-size: 0.678em;text-align:center;'></div>
                        <div id='center_block' style='border:1px solid #E0E0E0;background-color:#CCFF66;font-size: 0.678em;text-align:center;'></div>
                        <div id='right_block' style='border:1px solid #E0E0E0;background-color:#FFCC66;font-size: 0.678em;text-align:center;'></div>
                        <div id='theme_foot' style='clear:both;border:1px solid #E0E0E0;height:30px;line-height:30px;background-color:#F0F0F0;margin:4px auto;font-size: 0.678em;text-align:center;'><{$smarty.const._MA_TAD_THEMES_FOOT}></div>
                    </div>
                </div>

                <div id="save_theme_config" class="text-center d-grid gap-2" style="margin: 30px 0px;">
                    <!--中左區塊寬度-->
                    <input type="hidden" name="clb_width" value="<{$clb_width|default:''}>" id="clb_width" >
                    <!--中右區塊寬度-->
                    <input type="hidden" name="crb_width" value="<{$crb_width|default:''}>" id="crb_width" >
                    <input type="hidden" name="theme_id" value="<{$theme_id|default:''}>">
                    <input type="hidden" name="theme_name" value="<{$theme_name|default:''}>">

                    <!--佈景圖片寬度-->
                    <button type="submit" name="op" value="<{$op|default:''}>" class="btn btn-primary btn-lg btn-block border border-light border-4" style="box-shadow: 2px 2px 5px 1px rgba(0,0,0,0.5);">
                        <i class="fa fa-save" aria-hidden="true"></i> <{$smarty.const._TAD_SAVE}>
                    </button>
                </div>

                <div class="alert alert-info" style="margin: 30px 0px;">
                    <{if $theme_kind!="bootstrap" and $theme_kind!="bootstrap3" and $theme_kind!="bootstrap4" and $theme_kind!="bootstrap5"}>
                        <{$smarty.const._MA_TADTHEMES_NOTICE}>
                    <{/if}>
                    <{include file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_config_form.tpl"}>
                </div>
            </div>
        </div>
    </form>
</div>
