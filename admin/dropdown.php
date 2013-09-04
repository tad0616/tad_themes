<?php
//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2011-12-31
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "tad_themes_adm_dropdown_tpl.html";
include_once "header.php";
include_once "../function.php";

/*-----------function區--------------*/
//tad_themes_menu編輯表單
function tad_themes_menu_form($of_level="0",$menuid=""){
	global $xoopsDB;

	//抓取預設值
	if(!empty($menuid)){
		$DBV=get_tad_themes_menu($menuid);
	}else{
		$DBV=array();
	}

	//預設值設定

	$menuid=(!isset($DBV['menuid']))?$menuid:$DBV['menuid'];
	$of_level=(!isset($DBV['of_level']))?$of_level:$DBV['of_level'];
	$position=(!isset($DBV['position']))?get_max_sort($of_level):$DBV['position'];
	$itemname=(!isset($DBV['itemname']))?"":$DBV['itemname'];
	$itemurl=(!isset($DBV['itemurl']))?"":$DBV['itemurl'];
	$membersonly=(!isset($DBV['membersonly']))?"":$DBV['membersonly'];
	$status=(!isset($DBV['status']))?"":$DBV['status'];
	$target=(!isset($DBV['target']))?"":$DBV['target'];
	$mainmenu=(!isset($DBV['mainmenu']))?"":$DBV['mainmenu'];
	$icon=(!isset($DBV['icon']))?"":$DBV['icon'];

	$op=(empty($menuid))?"insert_tad_themes_menu":"update_tad_themes_menu";
	//$op="replace_tad_themes_menu";
	$main="
  <form action='{$_SERVER['PHP_SELF']}' method='post' id='myForm'>
	<input type='text' name='position' size='3' value='{$position}' class='span1'>
	";

	if(!empty($menuid)){
		$main.="<select name='of_level'>
		<option value=''>"._MA_TADTHEMES_ROOT."</option>
		".get_tad_all_menu("","",$of_level,$menuid,"1")."</select>";
		$size=15;
		$url_size=30;
	}else{
    $main.="<input type='hidden' name='of_level' value='{$of_level}'>";
		$size=20;
		$url_size=40;
	}

	$main.="
	"._MA_TADTHEMES_ITEMNAME._TAD_FOR."
  <input type='text' name='itemname' size='{$size}' value='{$itemname}' class='span2'>
	"._MA_TADTHEMES_ITEMURL._TAD_FOR."
	<input type='text' name='itemurl' size='{$url_size}' value='{$itemurl}' class='span4'>
  <select name='target' class='span1'>
  <option value='_self'></option>
  <option value='_blank' ".chk($target,"_blank",0,'selected').">"._MA_TADTHEMES_TARGET_BLANK."</option>
  </select>
	<input type='hidden' name='menuid' value='{$menuid}'>
	<input type='hidden' name='op' value='{$op}'>
  <input type='submit' value='"._TAD_SAVE."'>
  </form>";



	return $main;
}

//自動取得新排序
function get_max_sort($of_level=""){
	global $xoopsDB,$xoopsModule;
	$sql = "select max(position) from ".$xoopsDB->prefix("tad_themes_menu")." where of_level='$of_level'";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	list($sort)=$xoopsDB->fetchRow($result);
	return ++$sort;
}


//新增資料到tad_themes_menu中
function insert_tad_themes_menu(){
	global $xoopsDB;
	$sql = "insert into ".$xoopsDB->prefix("tad_themes_menu")." (`of_level`,`position`,`itemname`,`itemurl`,`membersonly`,`status`,`mainmenu`,`target`,`icon`) values('{$_POST['of_level']}','{$_POST['position']}','{$_POST['itemname']}','{$_POST['itemurl']}','0','1',0,'{$_POST['target']}','{$_POST['icon']}')";
	$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	//取得最後新增資料的流水編號
	$menuid=$xoopsDB->getInsertId();
	return $menuid;
}

//列出所有tad_themes_menu資料
function list_tad_themes_menu($add_of_level="",$menuid=""){
	global $xoopsDB , $xoopsModule , $xoopsTpl;

	$all=get_tad_level_menu("","",$menuid,"",$add_of_level);

  $op = (!isset($_REQUEST['op']))? "":$_REQUEST['op'];
  $option="";
	if($op=="add_tad_themes_menu" or $op=="modify_tad_themes_menu" or empty($all)){
		if($add_of_level==0 and $op=="add_tad_themes_menu"){
      $col_left=4;
			$option="<tr><td style='padding-left:{$col_left}px;' colspan=2;>".tad_themes_menu_form($add_of_level)."</td></tr>";
		}
	}


	$all=(empty($all))?"<tr><td colspan=2>".tad_themes_menu_form()."</td></tr>":$all;

  $jquery=get_jquery(true);

  $xoopsTpl->assign('jquery',$jquery);
  $xoopsTpl->assign('all',$all);
  $xoopsTpl->assign('option',$option);
  $xoopsTpl->assign('add_item',sprintf(_MA_TADTHEMES_ADDITEM,_MA_TADTHEMES_ROOT));

}


//取得分類項目
function get_tad_level_menu($of_level=0,$level=0,$v="",$this_menuid="",$add_of_level="0"){
	global $xoopsDB,$xoopsUser,$xoopsModule;

	$left=$level*30;
	$font_size=16-($level*2);
	$level+=1;


  $left=(empty($left))?4:$left;

	$option="";
	$sql = "select `menuid`,`of_level`,`itemname`,`position`,`itemurl`,`status`,`mainmenu`,`target`,`icon` from ".$xoopsDB->prefix("tad_themes_menu")." where of_level='{$of_level}'  order by position";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

  $op = (!isset($_REQUEST['op']))? "":$_REQUEST['op'];
	while(list($menuid,$of_level,$itemname,$position,$itemurl,$status,$mainmenu,$target,$icon)=$xoopsDB->fetchRow($result)){

		$item=(empty($itemurl))?$itemname:"<a href='{$itemurl}'>$itemname</a>";

		$add_img=($level>=3)?"":"<a href='{$_SERVER['PHP_SELF']}?op=add_tad_themes_menu&of_level={$menuid}'><img src='../images/001_01.gif' align='absmiddle' alt='".sprintf(_MA_TADTHEMES_ADDITEM,$itemname)."' title='".sprintf(_MA_TADTHEMES_ADDITEM,$itemname)."'></a>";
		
		$status_tool=($status=='1')?"<a href='{$_SERVER['PHP_SELF']}?op=tad_themes_menu_status&menuid=$menuid&status=0' class='btn btn-mini btn-warning'>"._TAD_UNABLE."</a>":"<a href='{$_SERVER['PHP_SELF']}?op=tad_themes_menu_status&menuid=$menuid&status=1' class='btn btn-mini btn-info'>"._TAD_ENABLE."</a>";

    $status_color=($status=='1')?"":"style='background-color:#D0D0D0'";
    $status_color2=($status=='1')?"":"background-color:#D0D0D0";
    $target_icon=($target=="_blank")?"<span class='label'>"._MA_TADTHEMES_TARGET_BLANK."</span>":"";

		if($op=="modify_tad_themes_menu" and $menuid==$v){
      $item=tad_themes_menu_form("",$menuid);
	    $content="<td style='padding-left:{$left}px;$status_color2'  colspan=2>$item</td>";
		}else{
	    $content="<td style='padding-left:{$left}px;$status_color2' ><img src='".XOOPS_URL."/modules/tadtools/treeTable/images/updown_s.png' style='cursor: s-resize;margin:0px 4px;' alt='"._MA_TADTHEMES_SAVE_SORT."' title='"._MA_TADTHEMES_SAVE_SORT."'>
			<span style='font-size:{$font_size}px;'>{$item}</span>
      $target_icon
			$add_img
			</td>
			<td $status_color>
			<a href=\"javascript:delete_tad_themes_menu_func($menuid);\" class='btn btn-mini btn-danger'>"._TAD_DEL."</a>
			<a href='{$_SERVER['PHP_SELF']}?op=modify_tad_themes_menu&menuid=$menuid' class='btn btn-mini btn-success'>"._TAD_EDIT."</a>
			$status_tool
			
      </td>";
		}

		$option.="<tr id='tr_{$menuid}'>$content</tr>";



		$option.=get_tad_level_menu($menuid,$level,$v,$this_menuid,$add_of_level);

		if($add_of_level==$menuid){
		  $col_left=$level*30;
			$option.="<tr id='tr_{$menuid}'><td style='padding-left:{$col_left}px;' colspan=2;>".tad_themes_menu_form($add_of_level)."</td></tr>";
		}
	}
	return $option;
}



//以流水號取得某筆tad_themes_menu資料
function get_tad_themes_menu($menuid=""){
	global $xoopsDB;
	if(empty($menuid))return;
	$sql = "select * from ".$xoopsDB->prefix("tad_themes_menu")." where menuid='$menuid'";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$data=$xoopsDB->fetchArray($result);
	return $data;
}

//更新tad_themes_menu某一筆資料
function update_tad_themes_menu($menuid=""){
	global $xoopsDB;
	$sql = "update ".$xoopsDB->prefix("tad_themes_menu")." set  `of_level` = '{$_POST['of_level']}', `position` = '{$_POST['position']}', `itemname` = '{$_POST['itemname']}', `itemurl` = '{$_POST['itemurl']}', `membersonly` = '0', `status` = '1',`target`='{$_POST['target']}',`icon`='{$_POST['icon']}' where menuid='$menuid'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	return $menuid;
}

//刪除tad_themes_menu某筆資料資料
function delete_tad_themes_menu($menuid=""){
	global $xoopsDB;
	$sql = "delete from ".$xoopsDB->prefix("tad_themes_menu")." where menuid='$menuid'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
}


//取得分類下拉選單
function get_tad_all_menu($of_level=0,$level=0,$v="",$this_menuid="",$no_self="1"){
	global $xoopsDB,$xoopsUser,$xoopsModule;

 if($level>=2)return;

	//$left=$level*10;
	$blank=str_repeat("&nbsp;",$level*3);
	$level+=1;


	$option="";
	$sql = "select `menuid`,`of_level`,`itemname` from ".$xoopsDB->prefix("tad_themes_menu")." where of_level='{$of_level}'  order by position";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

	while(list($menuid,$of_level,$itemname)=$xoopsDB->fetchRow($result)){

	  if($no_self=='1' and $this_menuid==$menuid)continue;
		$selected=($v==$menuid)?"selected":"";
		$color=($level=='1')?"#330033":"#990099";
		$option.="<option value='{$menuid}' style=color:{$color};' $selected>{$blank}{$itemname}</option>";
		$option.=get_tad_all_menu($menuid,$level,$v,$this_menuid,$no_self);
	}
	return $option;
}

//儲存排序
function save_sort(){
	global $xoopsDB;
	foreach($_POST['sort'] as $menuid=>$position){
		$sql= "update ".$xoopsDB->prefix("tad_themes_menu")." set  `position` = '{$position}' where menuid='{$menuid}'";
		$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	}
}


//自動匯入
function auto_import(){
	global $xoopsDB,$xoopsUser,$xoopsModule;

	$position=get_max_sort(0);
  $sql = "insert into ".$xoopsDB->prefix("tad_themes_menu")." (`of_level`,`position`,`itemname`,`itemurl`,`membersonly`,`status`) values(0,'{$position}','"._MA_TADTHEMES_WEB_MENU."','','0','1')";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

	//取得最後新增資料的流水編號
	$of_level=$xoopsDB->getInsertId();


	$sql = "select name,dirname from ".$xoopsDB->prefix("modules")." where isactive='1' and hasmain='1' order by weight";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

	while(list($name,$dirname)=$xoopsDB->fetchRow($result)){
	 $position=get_max_sort($of_level);
    $sql = "insert into ".$xoopsDB->prefix("tad_themes_menu")." (`of_level`,`position`,`itemname`,`itemurl`,`membersonly`,`status`) values('{$of_level}','{$position}','{$name}','".XOOPS_URL."/modules/{$dirname}/','0','1')";
  	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  }

	return;
}


function tad_themes_menu_status($menuid,$status){
	global $xoopsDB;
	$sql = "update ".$xoopsDB->prefix("tad_themes_menu")." set  `status` = '$status' where menuid='$menuid'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
}

/*-----------執行動作判斷區----------*/
$op = (!isset($_REQUEST['op']))? "":$_REQUEST['op'];
$menuid = (!isset($_REQUEST['menuid']))? "":intval($_REQUEST['menuid']);
$of_level = (!isset($_REQUEST['of_level']))? "":intval($_REQUEST['of_level']);
$status = (!isset($_REQUEST['status']))? "1":intval($_REQUEST['status']);

switch($op){

	//更新資料
	case "update_tad_themes_menu":
	update_tad_themes_menu($menuid);
	header("location: {$_SERVER['PHP_SELF']}");
	break;

	//新增資料
	case "insert_tad_themes_menu":
	insert_tad_themes_menu();
	header("location: {$_SERVER['PHP_SELF']}");
	break;


	//刪除資料
	case "delete_tad_themes_menu":
	delete_tad_themes_menu($menuid);
	header("location: {$_SERVER['PHP_SELF']}");
	break;


	//新增項目
	case "add_tad_themes_menu";
	$main=list_tad_themes_menu($of_level,$menuid);
	break;

	//儲存排序
	case "save_sort":
	save_sort();
	header("location: {$_SERVER['PHP_SELF']}");
	break;

	//修改項目
	case "modify_tad_themes_menu":
	$main=list_tad_themes_menu($of_level,$menuid);
	break;


	//修改項目
	case "import":
	auto_import();
	header("location: {$_SERVER['PHP_SELF']}");
	break;

  case "tad_themes_menu_status":
  tad_themes_menu_status($menuid,$status);
	header("location: {$_SERVER['PHP_SELF']}");
	break;

	//預設動作
	default:
	//$main=mk_menu();
	$main=list_tad_themes_menu();
	break;

}

/*-----------秀出結果區--------------*/
include_once 'footer.php';
?>