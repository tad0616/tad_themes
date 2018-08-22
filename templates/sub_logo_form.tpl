<h2><{$smarty.const._MA_TADTHEMES_LOGO_DESIGN}></h2>
<{if $fonts}>
    <form action="font2pic.php" id="myForm" method="post" role="form" class="form-horizontal">
        <div class="form-group">
            <label for="title" class="col-sm-2 control-label"><{$smarty.const._MA_TADTHEMES_LOGO_INPUT_TEXT}></label>
            <div class="col-sm-10">
                <input type="text" class="form-control validate[required]" name="title" id="title" placeholder="<{$smarty.const._MA_TADTHEMES_LOGO_INPUT_TEXT}>" value="<{$title}>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><{$smarty.const._MA_TADTHEMES_LOGO_TEXT_COLOR}></label>
            <div class="col-sm-4">
                <input type="text" name="color" class="form-control" value="#<{$color}>" id="font_color" data-text="hidden" data-hex="true" style="height: 42px;">
            </div>
            <label class="col-sm-2 control-label"><{$smarty.const._MA_TADTHEMES_LOGO_BORDER_COLOR}></label>
            <div class="col-sm-4">
                <input type="text" name="border_color" class="form-control" value="#<{$border_color}>" id="border_color" data-text="hidden" data-hex="true" style="height: 42px;">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label"><{$smarty.const._MA_TADTHEMES_LOGO_TEXT_SIZE}></label>
            <div class="col-sm-4">
                <input type="text" class="form-control validate[required]" name="size" id="size" placeholder="<{$smarty.const._MA_TADTHEMES_LOGO_TEXT_SIZE}>" value="<{$size}>">
            </div>
            <label class="col-sm-2 control-label"><{$smarty.const._MA_TADTHEMES_LOGO_BORDER_SIZE}></label>
            <div class="col-sm-4">
                <input type="text" class="form-control validate[required]" name="border_size" id="border_size" placeholder="<{$smarty.const._MA_TADTHEMES_LOGO_BORDER_SIZE}>" value="<{$border_size}>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label"><{$smarty.const._MA_TADTHEMES_LOGO_SELECT_FONT}></label>
            <div class="col-sm-10">
                <{foreach from=$fonts key=file_sn item=font}>
                    <label class="radio-inline">
                        <input class="validate[required]" type="radio" name="font_file_sn" value="<{$file_sn}>" <{if $font_file_sn==$file_sn}>checked<{/if}>>
                        <{$font.description}>
                    </label>
                <{/foreach}>
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

<{if $pic}>
    <form action="font2pic.php" method="post" role="form" class="form-horizontal">
        <div class="text-center" style="margin: 30px auto;">
            <span style="background: url('../images/t.gif'); display: inline-block;">
                <img src="<{$pic}>" alt="logo">
            </span>
            <input type="hidden" name="op" value="save_pic">
            <input type="hidden" name="title" value="<{$title}>">
            <input type="hidden" name="size" value="<{$size}>">
            <input type="hidden" name="border_size" value="<{$border_size}>">
            <input type="hidden" name="color" value="<{$color}>">
            <input type="hidden" name="border_color" value="<{$border_color}>">
            <input type="hidden" name="font_file_sn" value="<{$font_file_sn}>">
            <input type="hidden" name="name" value="<{$name}>">
            <button type="submit" class="btn btn-success"><{$smarty.const._MA_TADTHEMES_LOGO_SAVE_PIC}></button>
        </div>
    </form>
<{/if}>

<{if $logos}>
    <script>
        function change_css(){
            $('#demo').css('background-color',$('#bg_color').val());
        }
    </script>

    <div class="text-right">
            <{$smarty.const._MA_TADTHEMES_LOGO_DEMO_BGCOLOR}><input type="text" id="bg_color" value="#3c3c3c" data-text="hidden" data-hex="true" style="height: 42px;" onChange="change_css();">
    </div>

    <div id="demo" style="background-color: #3c3c3c;padding:10px; ">
        <{foreach from=$logos item=logo}>
            <span style="display: inline-block;">
                <a href="javascript:del_logo('<{$logo}>')"><img src="../images/delete.png" alt="del"></a>    
                <img src="<{$xoops_url}>/uploads/logo/<{$logo}>" alt="<{$xoops_url}>/uploads/logo/<{$logo}>" title="<{$xoops_url}>/uploads/logo/<{$logo}>">
            </span>
        <{/foreach}>
    </div>
<{/if}>