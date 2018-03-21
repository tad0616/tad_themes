<h2><{$smarty.const._MA_TADTHEMES_FONT_TOOL}></h2>
<form action="font2pic.php" method="post" role="form" class="form-horizontal" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title" class="col-sm-2 control-label"><{$smarty.const._MA_TADTHEMES_FONT_UPLOAD}></label>
        <div class="col-sm-10">
            <{$fontUpForm}>
        </div>
    </div>
    <div class="alert alert-warning"><{$smarty.const._MA_TADTHEMES_FONT_NOTE}></div>
    <input type="hidden" name="op" value="save_font">
    <button type="submit" class="btn btn-primary"><{$smarty.const._MA_TADTHEMES_FONT_SAVE}></button>
</form>