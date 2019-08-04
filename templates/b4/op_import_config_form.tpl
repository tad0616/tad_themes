<h2><{$smarty.const._MA_TADTHEMES_IMPORT}></h2>
<form action="main.php" method="post" role="form" enctype="multipart/form-data">
    <div class="form-group row">
        <div class="col-sm-12">
            <{$upform_config}>
        </div>
    </div>
    <input type="hidden" name="theme_name" value="<{$theme_name}>">
    <input type="hidden" name="op" value="import_config">
    <button type="submit" class="btn btn-primary"><{$smarty.const._MA_TADTHEMES_IMPORT}></button>
</form>