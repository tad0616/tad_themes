<script type="text/javascript">
    $(document).ready(function(){

        $('select.selectpicker').selectpicker();
        change_css();
        preview_img("bg","<{$bg_img}>");

        <{if $logo_position=="page"}>
            $("#logo_place_setup").hide();
        <{else}>
            $("#logo_place_setup").show();
        <{/if}>
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

    <{$chang_css}>


    function delete_tad_themes_config(theme_id){
        var sure = window.confirm("<{$smarty.const._MA_TADTHEMES_DEL_CONFIRM}>");
        if (!sure)  return;
        location.href="main.php?op=delete_tad_themes&theme_id=" + theme_id;
    }
</script>

<div class="container-fluid">
    <form action="main.php" method="post" id="myForm" enctype="multipart/form-data" role="form">
        <div class="row">
            <div class="col-sm-8">
                <h1>
                    <{$theme_name}><{$smarty.const._MA_TAD_THEMES_FORM}>

                    <a href="javascript:delete_tad_themes_config(<{$theme_id}>)" class="btn btn-danger"><{$smarty.const._MA_TADTHEMES_TO_DEFAULT}></a>
                    <a href="main.php?op=import_config_form&theme_name=<{$theme_name}>&theme_id=<{$theme_id}>" class="btn btn-primary"><{$smarty.const._MA_TADTHEMES_IMPORT}></a>
                    <a href="main.php?op=export_config&theme_id=<{$theme_id}>" class="btn btn-success"><{$smarty.const._MA_TADTHEMES_EXPORT}></a>
                </h1>
                <div class="alert alert-info">
                    <{$smarty.const._MA_TADTHEMES_CHANGE_KIND_DESC}>
                </div>

                <{if $theme_change}>
                    <{foreach from=$theme_kind_arr item=kind}>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="theme_kind" id="theme_kind" value="<{$kind}>" <{if $theme_kind==$kind}>checked<{/if}>>
                            <label class="form-check-label" for="theme_kind">
                                <{$kind}>
                                <{$theme_kind_txt_arr.$kind}>
                            </label>
                        </div>
                    <{/foreach}>

                    <input type="hidden" name="old_theme_kind" value="<{$theme_kind}>">
                <{else}>
                    <p style="margin: 20px 0px;">
                        <{$theme_kind}><{$theme_kind_txt}>
                        <input type="hidden" name="theme_kind" value="<{$theme_kind}>">
                    </p>
                <{/if}>

                <div id="themeTab">
                    <ul class="resp-tabs-list tab_identifier_parent">
                        <{if $config_tabs.1}>
                            <li><{$smarty.const._MA_TADTHEMES_THEME_BASE}></li>
                        <{/if}>

                        <{if $config_tabs.2}>
                            <li><{$smarty.const._MA_TADTHEMES_BG_IMG}></li>
                        <{/if}>

                        <{if $config_tabs.3}>
                            <li><{$smarty.const._MA_TAD_THEMES_HEAD}></li>
                        <{/if}>

                        <{if $config_tabs.4}>
                            <li><{$smarty.const._MA_TADTHEMES_LOGO_IMG}></li>
                        <{/if}>

                        <{if $config_tabs.5}>
                            <li><{$smarty.const._MA_TADTHEMES_BLOCK_TITLE}></li>
                        <{/if}>

                        <{if $config_tabs.6}>
                            <li><{$smarty.const._MA_TADTHEMES_NAVBAR}></li>
                        <{/if}>

                        <{if $config2}>
                            <li><{$smarty.const._MA_TADTHEMES_CONFIG2}></li>
                        <{/if}>
                        
                    </ul>

                    <div class="resp-tabs-container tab_identifier_parent">
                        <{if $config_tabs.1}>
                            <div>
                                <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_config_1.tpl"}>
                            </div>
                        <{else}>
                            <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_no_config_1.tpl"}>
                        <{/if}>

                        <{if $config_tabs.2}>
                            <div>
                                <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_config_2.tpl"}>
                            </div>
                        <{else}>
                            <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_no_config_2.tpl"}>
                        <{/if}>

                        <{if $config_tabs.3}>
                            <div>
                                <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_config_3.tpl"}>
                            </div>
                        <{else}>
                            <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_no_config_3.tpl"}>
                        <{/if}>

                        <{if $config_tabs.4}>
                        <div>
                            <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_config_4.tpl"}>
                        </div>
                        <{else}>
                            <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_no_config_4.tpl"}>
                        <{/if}>

                        <{if $config_tabs.5}>
                            <div>
                                <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_config_5.tpl"}>
                            </div>
                        <{else}>
                            <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_no_config_5.tpl"}>
                        <{/if}>

                        <{if $config_tabs.6}>
                            <div>
                                <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_config_6.tpl"}>
                            </div>
                        <{else}>
                            <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_no_config_6.tpl"}>
                        <{/if}>

                        <!--額外設定-->
                        <{if $config2}>
                            <div>
                                <input type="hidden" name="config2[]" value="config2">
                                <{foreach from=$config2 item=config}>
                                    <{includeq file="$xoops_rootpath/modules/tad_themes/templates/sub_theme_config_other.tpl"}>
                                <{/foreach}>
                                <a href="main.php?op=export_config2&theme_id=<{$theme_id}>&type=config2" class="btn btn-info"><{$smarty.const._MA_TADTHEMES_EXPORT2|sprintf:'config2'}></a>
                            </div>
                        <{/if}>
                        
                    </div>
                </div>
            </div>

        <div class="col-sm-4">
            <!--預覽-->
            <div id='preview_zone'>
                <div id='theme_demo' style='border:1px solid gray;background-color:white;margin:0px auto;'>
                    <div id='theme_head' style='border:1px solid #E0E0E0;background-color:#F0F0F0;margin:4px auto 2px auto;font-size:11px;text-align:center;'><{$smarty.const._MA_TAD_THEMES_HEAD}></div>
                    <div id='left_block' style='border:1px solid #E0E0E0;background-color:#99CCFF;font-size:11px;text-align:center;'></div>
                    <div id='center_block' style='border:1px solid #E0E0E0;background-color:#CCFF66;font-size:11px;text-align:center;'></div>
                    <div id='right_block' style='border:1px solid #E0E0E0;background-color:#FFCC66;font-size:11px;text-align:center;'></div>
                    <div id='theme_foot' style='clear:both;border:1px solid #E0E0E0;height:30px;line-height:30px;background-color:#F0F0F0;margin:4px auto;font-size:11px;text-align:center;'><{$smarty.const._MA_TAD_THEMES_FOOT}></div>
                </div>
            </div>

            <div class="text-center" style="margin: 30px auto;">
                <!--中左區塊寬度-->
                <input type="hidden" name="clb_width" value="<{$clb_width}>" id="clb_width" >
                <!--中右區塊寬度-->
                <input type="hidden" name="crb_width" value="<{$crb_width}>" id="crb_width" >
                <input type="hidden" name="theme_id" value="<{$theme_id}>">
                <input type="hidden" name="theme_name" value="<{$theme_name}>">

                <!--佈景圖片寬度-->
                <input type="hidden" name="op" value="<{$op}>">
                <button type="submit" class="btn btn-primary btn-lg btn-block"><{$smarty.const._TAD_SAVE}></button>
            </div>

            <div class="alert alert-info">
                <{if $theme_kind!="bootstrap" and $theme_kind!="bootstrap3" and $theme_kind!="bootstrap4"}>
                    <{$smarty.const._MA_TADTHEMES_NOTICE}>
                <{/if}>
                <{$smarty.const._MA_TADTHEMES_NOTICE2}>
            </div>

        </div>
        </div>
    </form>
</div>
