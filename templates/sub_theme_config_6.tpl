<!--navbar-->
<div class="row">
    <{if $enable.navbar_pos=="1" or $enable.navbar_bg_top=="1" or  $enable.navbar_bg_bottom=="1" or $enable.navbar_hover=="1"}>
        <div class="col-sm-6">
            <!--導覽工具列位置-->
            <{if $enable.navbar_pos=="1"}>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION}></label>
                    <div class="col-sm-8">
                        <select name="navbar_pos" id="navbar_pos" class="form-control <{$validate.navbar_pos}>">
                            <option value="navbar-fixed-top" <{if $navbar_pos=="navbar-fixed-top"}>selected<{/if}>>
                            <{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION_1}></option>
                            <option value="navbar-fixed-bottom" <{if $navbar_pos=="navbar-fixed-bottom"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION_2}></option>
                            <option value="navbar-static-top" <{if $navbar_pos=="navbar-static-top"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION_3}></option>
                            <option value="navbar-static-bottom" <{if $navbar_pos=="navbar-static-bottom"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION_6}></option>
                            <option value="default" <{if $navbar_pos=="default"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION_4}></option>
                            <option value="not-use" <{if $navbar_pos=="not-use"}>selected<{/if}>><{$smarty.const._MA_TADTHEMES_NAVBAR_POSITION_5}></option>
                        </select>
                    </div>
                </div>
            <{else}>
                <input type="hidden" name="navbar_pos" id="navbar_pos" value="<{$navbar_pos}>">
            <{/if}>

            <!--導覽工具列 漸層顏色(top) -->
            <{if $enable.navbar_bg_top=="1"}>
                <div class="form-group">
                    <label class="col-sm-4 control-label">                        
                        <{$smarty.const._MA_TADTHEMES_NAVBAR_BG_COLOR}>
                    </label>
                    <div class="col-sm-8">
                        <div class="input-group">                         
                            <input type="text" name="navbar_bg_top" id="navbar_bg_top" value="<{$navbar_bg_top}>" class="form-control <{$validate.navbar_bg_top}>" data-text="hidden" data-hex="true" style="height: 42px;">    
                            <{if $enable.navbar_bg_bottom=="1"}>            
                                <span class="input-group-addon"><{$smarty.const._MA_TADTHEMES_NAVBAR_CHANGE}></span> 
                                <input type="text" name="navbar_bg_bottom" id="navbar_bg_bottom" value="<{$navbar_bg_bottom}>" class="form-control <{$validate.navbar_bg_bottom}>" data-text="hidden" data-hex="true" style="height: 42px;">                            
                            <{else}>
                                <input type="hidden" name="navbar_bg_bottom" id="navbar_bg_bottom" value="<{$navbar_bg_bottom}>">
                            <{/if}>
                        </div>
                    </div>
                </div>
            <{else}>
                <input type="hidden" name="navbar_bg_top" id="navbar_bg_top" value="<{$navbar_bg_top}>">
            <{/if}>
                
            <!--導覽工具列 滑鼠移過顏色-->
            <{if $enable.navbar_color_hover=="1"}>
                <div class="form-group">
                    <label class="col-sm-4 control-label">                    
                        <{$smarty.const._MA_TADTHEMES_NAVBAR_COLOR_HOVER}>
                    </label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" name="navbar_color_hover" id="navbar_color_hover" value="<{$navbar_color_hover}>" class="form-control <{$validate.navbar_color_hover}>" data-text="hidden" data-hex="true" style="height: 42px;">   
                                            
                            <{if $enable.navbar_hover=="1"}> 
                                <span class="input-group-addon"><{$smarty.const._MA_TADTHEMES_NAVBAR_HOVER_COLOR}></span>                             
                                <input type="text" name="navbar_hover" id="navbar_hover" value="<{$navbar_hover}>" class="form-control <{$validate.navbar_hover}>" data-text="hidden" data-hex="true" style="height: 42px;">
                            <{else}>
                                <input type="hidden" name="navbar_hover" id="navbar_hover" value="<{$navbar_hover}>">
                            <{/if}>
                        </div>
                    </div>
                </div>
            <{else}>
                <input type="hidden" name="navbar_color_hover" id="navbar_color_hover" value="<{$navbar_color_hover}>">
            <{/if}>
        </div>
    <{else}>
        <input type="hidden" id="navbar_pos" name="navbar_pos" value="<{$navbar_pos}>">
        <input type="hidden" id="navbar_bg_top" name="navbar_bg_top" value="<{$navbar_bg_top}>">
        <input type="hidden" id="navbar_bg_bottom" name="navbar_bg_bottom" value="<{$navbar_bg_bottom}>">
        <input type="hidden" id="navbar_hover" name="navbar_hover" value="<{$navbar_hover}>">
    <{/if}>

    <div class="col-sm-6">
        <!--導覽工具列 文字顏色-->
        <{if $enable.navbar_color=="1"}>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    
                    <{$smarty.const._MA_TADTHEMES_NAVBAR_COLOR}>
                </label>
                <div class="col-sm-8">
                    <input type="text" name="navbar_color" id="navbar_color" value="<{$navbar_color}>" class="form-control <{$validate.navbar_color}>" data-text="hidden" data-hex="true" style="height: 42px;">
                </div>
            </div>
        <{else}>
            <input type="hidden" name="navbar_color" id="navbar_color" value="<{$navbar_color}>">
        <{/if}>


        <!--導覽工具列 文字大小-->
        <{if $enable.navbar_px=="1"}>
            <div class="form-group">
                <label class="col-sm-4 control-label">                    
                    <{$smarty.const._MA_TADTHEMES_NAVBAR_FONT_SIZE}>
                </label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <{$navbar_font_size_input}>                    
                        <span class="input-group-addon">%</span> 
                    </div>
                </div>
            </div>
        <{else}>
            <{$navbar_font_size_hidden}>
        <{/if}>
        


        <!--導覽工具列 圖示顏色-->
        <{if $enable.navbar_icon=="1"}>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    
                    <{$smarty.const._MA_TADTHEMES_NAVBAR_ICON_COLOR}>
                </label>
                <div class="col-sm-8">
                    <label for="navbar_icon_white">
                        <input type="radio" name="navbar_icon" id="navbar_icon_white" value="icon-white" <{if $navbar_icon=="icon-white"}>checked<{/if}>>
                        <{$smarty.const._MA_TADTHEMES_NAVBAR_ICON_WHITE}>
                    </label>
                    <label for="navbar_icon_black">
                        <input type="radio" name="navbar_icon" id="navbar_icon_black" value="" <{if $navbar_icon==""}>checked<{/if}>>
                        <{$smarty.const._MA_TADTHEMES_NAVBAR_ICON_BLACK}>
                    </label>
                </div>
            </div>
        <{else}>
            <input type="hidden" name="navbar_icon" id="navbar_icon" value="<{$navbar_icon}>">
        <{/if}>
            
    

        <!--導覽工具列 導覽選項上下距離-->
        <{if $enable.navbar_py=="1"}>
            <div class="form-group">
                <label class="col-sm-4 control-label">
                    
                    <{$smarty.const._MA_TADTHEMES_NAVBAR_PY}>
                </label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <{$navbar_py_input}>                    
                        <span class="input-group-addon">px</span> 
                    </div>
                </div>
                <{if $enable.navbar_px=="1"}>
                
                <label class="col-sm-2 control-label">                    
                    <{$smarty.const._MA_TADTHEMES_NAVBAR_PX}>
                </label>
                <div class="col-sm-3">
                    <div class="input-group">
                        <{$navbar_px_input}>                    
                        <span class="input-group-addon">px</span> 
                    </div>
                </div>
                <{else}>
                    <{$navbar_px_hidden}>
                <{/if}>
            </div>
        <{else}>
            <{$navbar_py_hidden}>
        <{/if}>
        


    </div>
</div>


<div class="row">
    <div class="col-sm-5">
        <{if $enable.navbar_img=="1"}>
            <div class="row">
                <!-- 上傳navbar_img圖-->
                <label class="col-sm-4 control-label">
                    <{$smarty.const._MA_TAD_THEMES_UPLOAD}><{$smarty.const._MA_TADTHEMES_NAVBAR_IMG}>
                </label>
                <div class="col-sm-8">
                    <{$upform_navbar_img}>
                </div>
            </div>
        <{else}>
            <input type="hidden" name="navbar_img" id="navbar_img" value="<{$navbar_img}>">
        <{/if}>

    </div>

    <{if $enable.navbar_img=="1"}>
        <div class="col-sm-7">
            <!-- 選擇預設導覽列navbar_img圖-->
            <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                <label for="navbar_img0" style="width:60px; height:60px;border:1px dotted gray;" >
                <input type="radio" name="navbar_img" id="navbar_img0" onChange="$('.del_img_box').show();" value="" <{if $navbar_img==""}>checked<{/if}>>
                <{$smarty.const._MA_TADTHEMES_NONE}><{$smarty.const._MA_TADTHEMES_NAVBAR_IMG}>
                </label>
            </div>

            <{if $all_navbar_img}>
                <{foreach from=$all_navbar_img item=navbarbg}>
                    <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                        <label for="navbar_img<{$navbarbg.files_sn}>" style="width:60px; height:60px; background:#000000 url(<{$navbarbg.tb_path}>);background-repeat:no-repeat;background-position:left center;border:1px solid gray;" >
                            <input type="radio" name="navbar_img" id="navbar_img<{$navbarbg.files_sn}>" onChange="$('.del_img_box').show(); $('#del_img<{$navbarbg.files_sn}>').hide();" value="<{$navbarbg.path}>" <{if $navbar_img==$navbarbg.path}>checked<{/if}>>
                        </label>
                        <label class="del_img_box" style="font-size:11px;"  id="del_img<{$navbarbg.files_sn}>">
                            <input type="checkbox" value="<{$navbarbg.files_sn}>" name="del_file[<{$navbarbg.files_sn}>]"> <{$smarty.const._TAD_DEL}>
                        </label>
                    </div>
                <{/foreach}>
            <{/if}>

        </div>
    <{/if}>
</div>


<div class="row">
    <div class="col-sm-5">

        <{if $enable.navlogo_img=="1"}>
            <div class="row">
                <!-- 上傳logo圖-->
                <label class="col-sm-4 control-label">
                    <{$smarty.const._MA_TAD_THEMES_UPLOAD}><{$smarty.const._MA_TADTHEMES_NAVLOGO_IMG}>
                </label>
                <div class="col-sm-8">
                    <{$upform_navlogo}>
                </div>
            </div>
        <{else}>
            <input type="hidden" name="navlogo_img" id="navlogo_img" value="<{$navlogo_img}>">
        <{/if}>

    </div>

    <{if $enable.navlogo_img=="1"}>
        <div class="col-sm-7">
            <!-- 選擇預設導覽列navlogo圖-->
            <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                <label for="navlogo_img0" style="width:60px; height:60px;border:1px dotted gray;" >
                <input type="radio" name="navlogo_img" id="navlogo_img0" value="" <{if $navlogo_img==""}>checked<{/if}>>
                <{$smarty.const._MA_TADTHEMES_NONE}><{$smarty.const._MA_TADTHEMES_NAVLOGO_IMG}>
                </label>
            </div>

            <{if $all_navlogo}>
                <{foreach from=$all_navlogo item=navlogo}>
                    <div style="width:60px; height:86px; display:inline-block; margin:4px;">
                        <label for="logo_img<{$navlogo.files_sn}>" style="width:60px; height:60px; background:#000000 url(<{$navlogo.tb_path}>);background-repeat:no-repeat;background-position:left center;border:1px solid gray;" >
                        <input type="radio" name="navlogo_img" id="navlogo_img<{$navlogo.files_sn}>" value="<{$navlogo.path}>" <{if $navlogo_img==$navlogo.path}>checked<{/if}>>
                        </label>
                        <label class="del_navimg_box" style="font-size:11px;"  id="del_navimg<{$navlogo.files_sn}>">
                        <input type="checkbox" value="<{$navlogo.files_sn}>" name="del_file[<{$navlogo.files_sn}>]"> <{$smarty.const._TAD_DEL}>
                        </label>
                    </div>
                <{/foreach}>
            <{/if}>

        </div>
    <{/if}>
</div>