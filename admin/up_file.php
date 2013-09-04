<?php
//設定模組目錄名稱
define("_MODDIR","tad_themes");

//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2008-12-15
// $Id:$
// ------------------------------------------------------------------------- //

/*
需有 class/multiple-file-upload、upload、lytebox

include_once("up_file.php");

表單：
 enctype='multipart/form-data'

<script src='".TADTOOLS_URL."/multiple-file-upload/jquery.js'></script>
<script src='".TADTOOLS_URL."/multiple-file-upload/jquery.MultiFile.js'></script>
<input type='file' name='upfile[]' class='multi' maxlength='1' accept='gif|jpg|png|GIF|JPG|PNG'>".list_del_file("news_sn",$news_sn)."

儲存：upload_file($upfile,$col_name,$col_sn,width);

顯示：show_files($upfile,$col_name,$col_sn,true,false,false,false);  //是否縮圖,顯示模式 filename、num,顯示描述,顯示下載次數

單一相片：get_pic_file($upfile,$col_name="",$col_sn="",$sort="",$showkind="images")

刪除：del_files($files_sn,$col_name,$col_sn);

檔案數量：get_file_amount($col_name="",$col_sn="");

種類：img,file
資料表：
CREATE TABLE `files_center` (
  `files_sn` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '檔案流水號',
  `col_name` varchar(255) NOT NULL COMMENT '欄位名稱',
  `col_sn` smallint(5) unsigned NOT NULL COMMENT '欄位編號',
  `sort` smallint(5) unsigned NOT NULL COMMENT '排序',
  `kind` enum('img','file') NOT NULL COMMENT '檔案種類',
  `file_name` varchar(255) NOT NULL COMMENT '檔案名稱',
  `file_type` varchar(255) NOT NULL COMMENT '檔案類型',
  `file_size` int(10) unsigned NOT NULL COMMENT '檔案大小',
  `description` text NOT NULL COMMENT '檔案說明',
  `counter` mediumint(8) unsigned NOT NULL COMMENT '下載人次',
  PRIMARY KEY (`files_sn`)
) COMMENT='檔案資料表';
*/

//檔案中心實體位置
define("_FILES_CENTER_DIR",XOOPS_ROOT_PATH."/uploads/"._MODDIR."/{$xoopsConfig['theme_set']}/file");
define("_FILES_CENTER_URL",XOOPS_URL."/uploads/"._MODDIR."/{$xoopsConfig['theme_set']}/file");
//檔案中心圖片實體位置
define("_FILES_CENTER_IMAGE_DIR",XOOPS_ROOT_PATH."/uploads/"._MODDIR."/{$xoopsConfig['theme_set']}");
define("_FILES_CENTER_IMAGE_URL",XOOPS_URL."/uploads/"._MODDIR."/{$xoopsConfig['theme_set']}");
//檔案中心縮圖實體位置
define("_FILES_CENTER_THUMB_DIR",XOOPS_ROOT_PATH."/uploads/"._MODDIR."/{$xoopsConfig['theme_set']}/thumbs");
define("_FILES_CENTER_THUMB_URL",XOOPS_URL."/uploads/"._MODDIR."/{$xoopsConfig['theme_set']}/thumbs");



//上傳圖檔，$col_name=對應欄位名稱,$col_sn=對應欄位編號,$種類：img,file,$sort=圖片排序,$files_sn="更新編號"
function upload_file($upfile='upfile',$col_name="",$col_sn="",$main_width="",$sort="",$thumb_width="90",$files_sn="",$desc=null){
  global $xoopsDB,$xoopsUser,$xoopsModule;

  //引入上傳物件
  include_once TADTOOLS_PATH."/upload/class.upload.php";

  //取消上傳時間限制
  set_time_limit(0);
  //設置上傳大小
  ini_set('memory_limit', '80M');
  
  //儲存檔案描述
  if(!empty($_POST['save_description'])){
    foreach($_POST['save_description'] as $save_files_sn=>$desc){
      save_description($save_files_sn,$desc);
    }
  }

  //刪除勾選檔案
  if(!empty($_POST['del_file'])){
    foreach($_POST['del_file'] as $del_files_sn){
      del_files($del_files_sn);
    }
  }

  $files = array();
  foreach ($_FILES[$upfile] as $k => $l) {
    foreach ($l as $i => $v) {
      if (!array_key_exists($i, $files)){
        $files[$i] = array();
      }
      $files[$i][$k] = $v;
    }
  }

  foreach ($files as $file) {
    //先刪除舊檔
    if(!empty($files_sn)){
      del_files($files_sn);
    }else{
      //del_files(null,$col_name,$col_sn,$sort);
    }

    //自動排序
    if(empty($sort)){
      $sort=auto_sort($col_name,$col_sn);
    }

    //取得檔案
    $file_handle = new upload($file,"zh_TW");

    if ($file_handle->uploaded) {
      //取得副檔名
      $ext=strtolower($file_handle->file_src_name_ext);
      //判斷檔案種類
      if($ext=="jpg" or $ext=="jpeg" or $ext=="png" or $ext=="gif"){
        $kind="img";
      }else{
        $kind="file";
      }

      $file_handle->file_safe_name = false;
      $file_handle->file_overwrite = true;
      //$file_handle->file_new_name_body   = "{$col_name}_{$col_sn}_{$sort}";

      //若是圖片才縮圖
      if($kind=="img" and !empty($main_width)){
        if($file_handle->image_src_x > $main_width){
          $file_handle->image_resize         = true;
          $file_handle->image_x              = $main_width;
          $file_handle->image_ratio_y         = true;
        }
      }
      $path=($kind=="img")?_FILES_CENTER_IMAGE_DIR."/{$upfile}":_FILES_CENTER_DIR."/{$upfile}";
      $file_handle->process($path);
      $file_handle->auto_create_dir = true;

      //若是圖片才製作小縮圖
      if($kind=="img"){
        $file_handle->file_safe_name = false;
        $file_handle->file_overwrite = true;
        //$file_handle->file_new_name_body   = "{$col_name}_{$col_sn}_{$sort}";
        if($file_handle->image_src_x > $thumb_width){
          $file_handle->image_resize         = true;
          $file_handle->image_x              = $thumb_width;
          $file_handle->image_ratio_y         = true;
        }
        $file_handle->process(_FILES_CENTER_IMAGE_DIR."/{$upfile}/thumbs");
        $file_handle->auto_create_dir = true;
      }

      //上傳檔案
      if ($file_handle->processed) {
        $file_handle->clean();
        //$file_name="{$col_name}_{$col_sn}_{$sort}.{$ext}";
        $file_name=$file['name'];
        $description=empty($desc)?$file['name']:$desc;

        if(empty($files_sn)){
          $sql = "insert into ".$xoopsDB->prefix(""._MODDIR."_files_center")." (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`) values('$col_name','$col_sn','$sort','{$kind}','{$file_name}','{$file['type']}','{$file['size']}','{$description}')";
          $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
        }else{
          $sql = "replace into ".$xoopsDB->prefix(""._MODDIR."_files_center")." (`files_sn`,`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`) values('{$files_sn}','$col_name','$col_sn','$sort','{$kind}','{$file_name}','{$file['type']}','{$file['size']}','{$description}')";
          $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
        }
      } else {
        redirect_header($_SERVER['PHP_SELF'],3, "Error:".$file_handle->error);
      }
    }
    $sort="";
  }
}



//匯入圖檔
function import_file($file_name='',$col_name="",$col_sn="",$main_width="",$thumb_width="90"){
  global $xoopsDB,$xoopsUser,$xoopsModule,$xoopsConfig;
//die($file_name);
  //取消上傳時間限制
  set_time_limit(0);
  //設置上傳大小
  ini_set('memory_limit', '80M');
  //取得檔名
  $file=basename($file_name);

  $path=XOOPS_ROOT_PATH."/uploads/"._MODDIR."/{$xoopsConfig['theme_set']}/{$col_name}";
  $import_file="{$path}/{$file}";
  $thumb_name=XOOPS_ROOT_PATH."/uploads/"._MODDIR."/{$xoopsConfig['theme_set']}/{$col_name}/thumbs/{$file}";

  //自動排序
  $sort=auto_sort($col_name,$col_sn);
  //取得附檔
  $ext=strtolower(strrchr($file, "."));

  //判斷檔案種類
  if($ext==".jpg" or $ext==".jpeg" or $ext==".png" or $ext==".gif"){
    $kind="img";
  }else{
    $kind="file";
  }
  $type=mime_content_type($file_name);
  $size=filesize($file_name);

//做縮圖
  if(!empty($main_width))thumbnail($file_name,$import_file,$type,$main_width);
  if(!empty($thumb_width)){
    thumbnail($file_name,$thumb_name,$type,$thumb_width);
  }
  //匯入資料庫
  $sql = "insert into ".$xoopsDB->prefix(""._MODDIR."_files_center")." (`col_name`,`col_sn`,`sort`,`kind`,`file_name`,`file_type`,`file_size`,`description`) values('$col_name','$col_sn','$sort','{$kind}','{$file}','{$type}','{$size}','{$file}')";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
}



//做縮圖
function thumbnail($filename="",$thumb_name="",$type="image/jpeg",$width="120"){

	ini_set('memory_limit', '50M');
	// Get new sizes
	list($old_width, $old_height) = getimagesize($filename);
  if($old_width > $width){
  	$percent=($old_width>$old_height)?round($width/$old_width,2):round($width/$old_height,2);

  	$newwidth = ($old_width>$old_height)?$width:$old_width * $percent;
  	$newheight = ($old_width>$old_height)?$old_height * $percent:$width;

  	// Load
  	$thumb = imagecreatetruecolor($newwidth, $newheight);
  	if($type=="image/jpeg" or $type=="image/jpg" or $type=="image/pjpg" or $type=="image/pjpeg"){
  		$source = imagecreatefromjpeg($filename);
  		$type="image/jpeg";
  	}elseif($type=="image/png"){
  		$source = imagecreatefrompng($filename);
  		$type="image/png";
  	}elseif($type=="image/gif"){
  		$source = imagecreatefromgif($filename);
  		$type="image/gif";
  	}

  	// Resize
  	imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $old_width, $old_height);

    header("Content-type: $type");
  	if($type=="image/jpeg"){
  	 imagejpeg($thumb,$thumb_name);
  	}elseif($type=="image/png"){
  	 imagepng($thumb,$thumb_name);
  	}elseif($type=="image/gif"){
  	 imagegif($thumb,$thumb_name);
  	}
  	return;
  	exit;
	}else{
    copy($filename,$thumb_name);
  }
}

//加入實體檔案說明
function save_description($files_sn="",$desc=""){
  global $xoopsDB,$xoopsUser;

	$myts =& MyTextSanitizer::getInstance();
	$desc=$myts->addSlashes($desc);
	
  $sql = "update ".$xoopsDB->prefix(""._MODDIR."_files_center")." set description='$desc' where `files_sn`='{$files_sn}'";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error()."<br>".$sql);
}

//刪除實體檔案
function del_files($files_sn="",$col_name="",$col_sn="",$sort=""){
    global $xoopsDB,$xoopsUser;

    if(!empty($files_sn)){
        $del_what="`files_sn`='{$files_sn}'";
    }elseif(!empty($col_name) and !empty($col_sn)){
      $and_sort=(empty($sort))?"":"and `sort`='{$sort}'";
        $del_what="`col_name`='{$col_name}' and `col_sn`='{$col_sn}' $and_sort";
    }

    $sql = "select * from ".$xoopsDB->prefix(""._MODDIR."_files_center")." where $del_what";
    $result=$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error()."<br>".$sql);

     while(list($files_sn,$col_name,$col_sn,$sort,$kind,$file_name,$file_type,$file_size,$description)=$xoopsDB->fetchRow($result)){

       $del_sql = "delete  from ".$xoopsDB->prefix(""._MODDIR."_files_center")." where files_sn='{$files_sn}'";
         $xoopsDB->queryF($del_sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

        if($kind=="img"){
            unlink(_FILES_CENTER_IMAGE_DIR."/{$col_name}/$file_name");
            unlink(_FILES_CENTER_IMAGE_DIR."/{$col_name}/thumbs/$file_name");
        }else{
            unlink(_FILES_CENTER_DIR."/$file_name");
        }
    }
}

//取得檔案 $kind=images（大圖）,thumb（小圖），$mode=link（完整連結）or array（路徑陣列）
function get_file($upfile="",$col_name="",$col_sn="",$sort=""){
    global $xoopsDB,$xoopsUser,$xoopsModule;


    $and_sort=(!empty($sort))?" and `sort`='{$sort}'":"";

    $sql = "select * from ".$xoopsDB->prefix(""._MODDIR."_files_center")." where `col_name`='{$col_name}' and `col_sn`='{$col_sn}' $and_sort order by sort";


     $result=$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
     while($all=$xoopsDB->fetchArray($result)){
      //以下會產生這些變數： $files_sn, $col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description
    foreach($all as $k=>$v){
      $$k=$v;
    }

    $files[$files_sn]['kind']=$kind;
    $files[$files_sn]['sort']=$sort;
    $files[$files_sn]['file_name']=$file_name;
    $files[$files_sn]['file_type']=$file_type;
    $files[$files_sn]['file_size']=$file_size;
    $files[$files_sn]['counter']=$counter;
    $files[$files_sn]['description']=$description;

    if($kind=="img"){
      $pic_name=(file_exists(_FILES_CENTER_IMAGE_DIR."/{$upfile}/{$file_name}"))?_FILES_CENTER_IMAGE_URL."/{$upfile}/{$file_name}":TADTOOLS_URL."/multiple-file-upload/no_thumb.gif";
            $thumb_pic=(file_exists(_FILES_CENTER_IMAGE_DIR."/{$upfile}/thumbs/{$file_name}"))?_FILES_CENTER_IMAGE_DIR."/{$upfile}/thumbs/{$file_name}":TADTOOLS_URL."/multiple-file-upload/no_thumb.gif";


            $files[$files_sn]['link']="<a href='{$_SERVER['PHP_SELF']}?fop=dl&files_sn=$files_sn' title='{$description}' rel='lytebox'><img src='{$pic_name}' alt='{$description}' title='{$description}' rel='lytebox'></a>";
            $files[$files_sn]['path']=$pic_name;
            $files[$files_sn]['url']="<a href='{$_SERVER['PHP_SELF']}?fop=dl&files_sn=$files_sn' title='{$description}' target='_blank'>{$description}</a>";

            //$files[$files_sn]['tb_link']="<a href='"._FILES_CENTER_IMAGE_URL."/{$file_name}' title='{$description}' rel='lytebox'><img src='"._FILES_CENTER_THUMB_URL."/{$file_name}' alt='{$description}' title='{$description}'></a>";


            $files[$files_sn]['tb_link']="<a href='{$_SERVER['PHP_SELF']}?fop=dl&files_sn=$files_sn' title='{$description}' rel='lytebox'><img src='$thumb_pic' alt='{$description}' title='{$description}'></a>";
            $files[$files_sn]['tb_path']=$thumb_pic;
            $files[$files_sn]['tb_url']="<a href='{$_SERVER['PHP_SELF']}?fop=dl&files_sn=$files_sn' title='{$description}' rel='lytebox'>{$description}</a>";
        }else{
            //$files[$files_sn]['link']="<a href='"._FILES_CENTER_URL."/{$file_name}'>{$description}</a>";
            $files[$files_sn]['link']="<a href='{$_SERVER['PHP_SELF']}?fop=dl&files_sn=$files_sn'>{$description}</a>";
            $files[$files_sn]['path']="{$_SERVER['PHP_SELF']}?fop=dl&files_sn=$files_sn";
        }
    }
    return $files;
}

//取得單一圖片 $kind=images（大圖）,thumb（小圖）
function get_pic_file($upfile="",$col_name="",$col_sn="",$sort="",$showkind="images"){
    global $xoopsDB,$xoopsUser,$xoopsModule;

    $and_sort=(!empty($sort))?" and `sort`='{$sort}'":"";

    $sql = "select * from ".$xoopsDB->prefix(""._MODDIR."_files_center")." where `col_name`='{$col_name}' and `col_sn`='{$col_sn}' $and_sort order by sort limit 0,1";


     $result=$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
     while($all=$xoopsDB->fetchArray($result)){
      //以下會產生這些變數： $files_sn, $col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description
    foreach($all as $k=>$v){
      $$k=$v;
    }

    if($showkind=="thumb"){
      $files=(file_exists(_FILES_CENTER_IMAGE_DIR."/{$upfile}/thumbs/{$file_name}"))?_FILES_CENTER_IMAGE_DIR."/{$upfile}/thumbs/{$file_name}":"";
    }else{
      $files=(file_exists(_FILES_CENTER_IMAGE_DIR."/{$upfile}/{$file_name}"))?_FILES_CENTER_IMAGE_URL."/{$upfile}/{$file_name}":"";
    }

  }
  return $files;
}



//取得檔案數
function get_file_amount($col_name="",$col_sn=""){
    global $xoopsDB,$xoopsUser,$xoopsModule;

    $sql = "select count(*) from ".$xoopsDB->prefix(""._MODDIR."_files_center")." where `col_name`='{$col_name}' and `col_sn`='{$col_sn}'";

    $result=$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
    list($amount)=$xoopsDB->fetchRow($result);
    return $amount;
}

//列出可刪除檔案
function list_del_file($col_name="",$col_sn="",$show_edit=false){
    global $xoopsDB,$xoopsUser,$xoopsModule;

  $all_file="";

    $sql = "select * from ".$xoopsDB->prefix(""._MODDIR."_files_center")." where `col_name`='{$col_name}' and `col_sn`='{$col_sn}' order by sort";

     $result=$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
     while($all=$xoopsDB->fetchArray($result)){
      //以下會產生這些變數： $files_sn, $col_name, $col_sn, $sort, $kind, $file_name, $file_type, $file_size, $description
      foreach($all as $k=>$v){
        $$k=$v;
      }
      
      $fileidname=str_replace('.','',$file_name);

      if($show_edit){
        $all_file.="
        <tr>
          <td style='width:100px'><input type='checkbox' name='del_file[$files_sn]' value='{$files_sn}'>$file_name</td>
          <td rowspan=2><textarea name='save_description[$files_sn]'>$description</textarea></td>
        </tr>
        <tr>
          <td><img src='"._FILES_CENTER_IMAGE_URL."/{$col_name}/thumbs/{$file_name}'></td>
        </tr>";
      }else{
        $all_file.="
        <div style='float:left;width:90px;height:120px;margin:4px;overflow:hidden;'>
          <div style='width:90px;height:16px;line-height:16px;white-space:nowrap;overflow:hidden;'>
          <input type='checkbox' name='del_file[]' value='{$files_sn}'>$description</div>
          <img src='"._FILES_CENTER_IMAGE_URL."/{$col_name}/thumbs/{$file_name}' style='margin-top:4px;' >
        </div>";
      }
    }

    if(empty($all_file))return;
    $files="";
    if($show_edit){
      $files.="<div><div style='margin-bottom:7px;'>"._MA_TADTHEMES_SELECT_TO_DEL."</div><table>$all_file</table></div>";
    }else{
      $files.="<div><div style='margin-bottom:7px;'>"._MA_TADTHEMES_SELECT_TO_DEL."</div>$all_file</div>";
    }

    return $files;
}

//取得附檔或附圖$show_mode=filename、num
function show_files($upfile="",$col_name="",$col_sn="",$thumb=true,$show_mode="",$show_description=false,$show_dl=false){
    if($show_mode==""){
        $all_files="<script type='text/javascript' language='javascript' src='".TADTOOLS_URL."/lytebox/lytebox.js'></script>
    <link rel='stylesheet' href='".TADTOOLS_URL."/lytebox/lytebox.css' type='text/css' media='screen' />";
    }else{
    $all_files="";
    }
    $file_arr="";
    $file_arr=get_file($upfile,$col_name,$col_sn);
    if(empty($file_arr))return;

    if($file_arr){
      $i=1;
        foreach($file_arr as $files_sn => $file_info){

            if($show_mode=="filename"){
              if($file_info['kind']=="file"){
                    $all_files.="<div>({$i}) {$file_info['link']}</div>";
                }else{
                    $all_files.="<div>({$i}) {$file_info['url']}</div>";
                }
            }else{
              if($file_info['kind']=="file"){
                 $linkto=$file_info['path'];
                    $description=$file_info['description'];
                    $thumb_pic=TADTOOLS_URL."/multiple-file-upload/downloads.png";
                    $rel="";
                }else{
                    $linkto=$file_info['path'];
                    $description=$file_info['description'];
                    $thumb_pic=($thumb)?$file_info['tb_path']:$file_info['path'];
                    $rel="rel='lyteshow[{$col_name}_{$course_sn}]' title='{$description}'";
                }

                //描述顯示
                $show_description_txt=($show_description)?"<div style='height:40px;font-size:9pt;font-weight:normal;overflow:hidden;text-align:center;'><a href='{$linkto}' $rel style='font-size:9pt;font-weight:normal;'>{$description}</a></div>":"";

                //下載次數顯示
                $show_dl_txt=($show_dl)?"<img src='".TADTOOLS_URL."/multiple-file-upload/dl_times.gif' alt='download counter' title='download counter' align='absmiddle' hspace=4>: {$file_info['counter']}":"";

                $width=($thumb)?110:400;
                $pic_height=($thumb)?90:300;
                $height=($thumb)?100:320;
                $height+=($show_description)?30:0;

                $all_files.="<div style='border:0px solid gray;width:{$width}px;height:{$height}px;float:left;display:inline;margin:2px;'>
                    <a href='{$linkto}' $rel>
                    <div align='center' style=\"border:1px solid #CFCFCF;width:{$width}px;height:{$pic_height}px;overflow:hidden;margin:2px auto;background-image:url('{$thumb_pic}');background-repeat: no-repeat;background-position: center center;cursor:pointer;\">
                    $show_dl_txt
                    </div>
                </a>
                $show_description_txt
                </div>";
            }

      $i++;
        }
    }else{
    $all_files="";
    }
    $all_files.="<div style='clear:both;'></div>";
    return $all_files;
}

//取得單一檔案資料
function get_one_file($files_sn=""){
    global $xoopsDB,$xoopsUser,$xoopsModule;

    $sql = "select * from ".$xoopsDB->prefix(""._MODDIR."_files_center")." where `files_sn`='{$files_sn}'";

     $result=$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
     $all=$xoopsDB->fetchArray($result);
     return $all;
}

//自動編號
function auto_sort($col_name="",$col_sn=""){
    global $xoopsDB,$xoopsUser;

    $sql = "select max(sort) from ".$xoopsDB->prefix(""._MODDIR."_files_center")." where `col_name`='{$col_name}' and `col_sn`='{$col_sn}'";

     $result=$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
     list($max)=$xoopsDB->fetchRow($result);
    return ++$max;
}

//下載並新增計數器
function add_file_counter($files_sn=""){
    global $xoopsDB;

  $file=get_one_file($files_sn);
    $sql = "update ".$xoopsDB->prefix(""._MODDIR."_files_center")." set `counter`=`counter`+1 where `files_sn`='{$files_sn}'";

     $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

    if($file['kind']=="img"){
        header("location:"._FILES_CENTER_IMAGE_URL."/{$file['file_name']}");
    }else{
        header("location:"._FILES_CENTER_URL."/{$file['file_name']}");
    }
}

$fop=isset($_GET['fop'])?$_GET['fop']:"";
if($fop=="dl"){
  add_file_counter($_GET['files_sn']);
}


if(!function_exists('mime_content_type')) {

    function mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.',$filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }
}
?>