<h2><{$smarty.const._MA_TADTHEMES_LOGO_DESIGN}></h2>
<{if $fonts|default:false}>
    <form action="font2pic.php" id="myForm" method="post" role="form" class="form-horizontal">
        <div class="form-group row mb-3">
            <label for="title" class="col-sm-2 col-form-label text-sm-right control-label"><{$smarty.const._MA_TADTHEMES_LOGO_INPUT_TEXT}></label>
            <div class="col-sm-4">
                <input type="text" class="form-control validate[required]" name="title" id="title" placeholder="<{$smarty.const._MA_TADTHEMES_LOGO_INPUT_TEXT}>" value="<{$title|default:''}>">
            </div>
            <label class="col-sm-2 col-form-label text-sm-right control-label"><{$smarty.const._MA_TADTHEMES_LOGO_SELECT_FONT}></label>
            <div class="col-sm-4">
                <select name="font_file_sn" id="font_file_sn" class="form-control">
                    <{foreach from=$fonts key=file_sn item=font name=f}>
                        <option value="<{$file_sn|default:''}>" <{if $font_file_sn==$file_sn or ($font_file_sn == 0 and $smarty.foreach.f.index == 0) }>selected<{/if}>>
                            <{$font.description}>
                        </option>
                    <{/foreach}>
                </select>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label text-sm-right control-label"><{$smarty.const._MA_TADTHEMES_LOGO_TEXT_SIZE}></label>
            <div class="col-sm-4">
                <input type="text" class="form-control validate[required]" name="size" id="size" placeholder="<{$smarty.const._MA_TADTHEMES_LOGO_TEXT_SIZE}>" value="<{$size|default:''}>">
            </div>
            <label class="col-sm-2 col-form-label text-sm-right control-label"><{$smarty.const._MA_TADTHEMES_LOGO_TEXT_COLOR}></label>
            <div class="col-sm-4">
                <div class="input-group">
                    <input type="text" name="color" id="font_color" value="#<{$color|default:''}>" class="form-control color-picker" data-hex="true">
                </div>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label text-sm-right control-label"><{$smarty.const._MA_TADTHEMES_LOGO_BORDER_SIZE}></label>
            <div class="col-sm-4">
                <input type="text" class="form-control validate[required]" name="border_size" id="border_size" placeholder="<{$smarty.const._MA_TADTHEMES_LOGO_BORDER_SIZE}>" value="<{$border_size|default:''}>">
            </div>
            <label class="col-sm-2 col-form-label text-sm-right control-label"><{$smarty.const._MA_TADTHEMES_LOGO_BORDER_COLOR}></label>
            <div class="col-sm-4">
                <div class="input-group">
                    <input type="text" name="border_color" id="border_color" value="#<{$border_color|default:''}>" class="form-control color-picker" data-hex="true">
                </div>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label text-sm-right control-label"><{$smarty.const._MA_TADTHEMES_LOGO_SHADOW_SIZE}></label>
            <div class="col-sm-4">
                <input type="text" class="form-control validate[required]" name="shadow_size" id="shadow_size" placeholder="<{$smarty.const._MA_TADTHEMES_LOGO_SHADOW_SIZE}>" value="<{$shadow_size|default:''}>">
            </div>
            <label class="col-sm-2 col-form-label text-sm-right control-label"><{$smarty.const._MA_TADTHEMES_LOGO_SHADOW_COLOR}></label>
            <div class="col-sm-4">
                <div class="input-group">
                    <input type="text" name="shadow_color" id="shadow_color" value="#<{$shadow_color|default:''}>" class="form-control color-picker" data-hex="true">
                </div>
            </div>
        </div>


        <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label text-sm-right control-label"><{$smarty.const._MA_TADTHEMES_LOGO_SHADOW_X}></label>
            <div class="col-sm-4">
                <input type="number" name="shadow_x" class="col-sm-10 form-control" value="<{$shadow_x|default:''}>" id="shadow_x">
            </div>
            <label class="col-sm-2 col-form-label text-sm-right control-label"><{$smarty.const._MA_TADTHEMES_LOGO_SHADOW_Y}></label>
            <div class="col-sm-4">
                <input type="number" name="shadow_y" class="col-sm-10 form-control" value="<{$shadow_y|default:''}>" id="shadow_y">
            </div>
        </div>


        <div class="form-group row mb-3">
            <label class="col-sm-2 col-form-label text-sm-right control-label"><{$smarty.const._MA_TADTHEMES_LOGO_MT}></label>
            <div class="col-sm-4">
                <input type="number" name="margin_top" class="col-sm-10 form-control" value="<{$margin_top|default:''}>" id="margin_top">
            </div>
            <label class="col-sm-2 col-form-label text-sm-right control-label"><{$smarty.const._MA_TADTHEMES_LOGO_MB}></label>
            <div class="col-sm-4">
                <input type="number" name="margin_bottom" class="col-sm-10 form-control" value="<{$margin_bottom|default:''}>" id="margin_bottom">
            </div>
        </div>

        <div class="text-center" style="margin: 30px auto;">
            <input type="hidden" name="op" value="mkTitlePic">
            <button type="submit" class="btn btn-primary"><{$smarty.const._MA_TADTHEMES_LOGO_MAKE_PNG}></button>
        </div>
    </form>
<{else}>
    <div class="alert alert-danger"><{$smarty.const._MA_TADTHEMES_LOGO_NEED_FONT}></div>
<{/if}>

<form action="font2pic.php" method="post" style="text-align:center;">
    <{if $pic|default:false}>
        <div class="text-center" style="margin: 30px auto;">
            <span style="background: url('../images/t.gif'); display: inline-block;">
                <img src="<{$pic|default:''}>" alt="logo">
            </span>
        </div>
        <input type="hidden" name="op" value="save_pic">
        <input type="hidden" name="title" value="<{$title|default:''}>">
        <input type="hidden" name="size" value="<{$size|default:''}>">
        <input type="hidden" name="border_size" value="<{$border_size|default:''}>">
        <input type="hidden" name="color" value="<{$color|default:''}>">
        <input type="hidden" name="border_color" value="<{$border_color|default:''}>">
        <input type="hidden" name="font_file_sn" value="<{$font_file_sn|default:''}>">
        <input type="hidden" name="name" value="<{$name|default:''}>">

        <div class="form-check form-check-inline checkbox-inline">
            <label class="form-check-label" for="theme_kind">
                <input class="form-check-input" type="checkbox" name="sav_to_logo" id="sav_to_logo" value="1">
            <{$smarty.const._MA_TADTHEMES_LOGO_SAVE_AS_LOGO}>
            <button type="submit" class="btn btn-success"><{$smarty.const._MA_TADTHEMES_LOGO_SAVE_PIC}></button>
            </label>
        </div>

    <{/if}>

    <{if $logos|default:false}>
        <script>
            function change_css(){
                $('#demo').css('background-color',$('#bg_color').val());
            }
        </script>

        <div class="input-group mb-2">
            <div class="input-group-prepend input-group-addon">
                <span class="input-group-text"><{$smarty.const._MA_TADTHEMES_LOGO_DEMO_BGCOLOR}></span>
            </div>

            <input type="hidden" id="bg_color" value="<{$bg_color|default:''}>" style="width:100px;"  data-hex="true" onChange="change_css();">
        </div>

        <div id="demo" style="background-color: <{$bg_color|default:''}>;padding:10px; ">
            <{foreach from=$logos item=logo}>
                <span style="display: inline-block;">
                    <a href="javascript:del_logo('<{$logo|default:''}>')"><img src="../images/delete.png" alt="del"></a>
                    <img src="<{$xoops_url}>/uploads/logo/<{$logo|default:''}>" alt="<{$xoops_url}>/uploads/logo/<{$logo|default:''}>" title="<{$xoops_url}>/uploads/logo/<{$logo|default:''}>">
                </span>
            <{/foreach}>
        </div>
    <{/if}>
</form>