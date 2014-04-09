<?php
//區塊主函式 (vertical_menu)
function vertical_menu($options){
  global $xoopsDB;
  include_once XOOPS_ROOT_PATH."/modules/tadtools/tad_function.php";
  $in=empty($options[0])?"status='1' and of_level=0":"menuid in({$options[0]})";
  //$menu=explode(",",$options[0]);
  $sql = "select `menuid`,`itemname`,`itemurl`,`target`,`icon` from ".$xoopsDB->prefix("tad_themes_menu")." where $in order by position";
  $result = $xoopsDB->query($sql);
  $menu="";

  $dir=XOOPS_ROOT_PATH."/uploads/tad_themes/menu_icons";
  $url=XOOPS_URL."/uploads/tad_themes/menu_icons";
  $i=1;
  while(list($menuid,$itemname,$itemurl,$target,$bootstrap_icon)=$xoopsDB->fetchRow($result)){
    if(empty($itemname) or empty($itemurl))continue;

    $menu[$i]['itemname']=$itemname;
    $menu[$i]['itemurl']=$itemurl;
    $menu[$i]['target']=$target;
    $menu[$i]['bootstrap_icon']=$bootstrap_icon;
    $menu[$i]['color']=genColorCodeFromText($menuid);
    $icon="";
    if(file_exists($dir."/".$menuid."_64.png")){
      $icon="{$url}/{$menuid}_64.png";
    }

    $menu[$menuid]['icon']=$icon;
    $i++;
  }
  $block['menu']=$menu;
  $block['jquery']=get_jquery();
  $block['pin']=$options[1];
  //die(var_dump($block));
  return $block;
}

//區塊編輯函式 (tad_themes_top_menu_edit)
function vertical_menu_edit($options){

  $block_menu_options=block_menu_options($options[0]);

  $checked1=$options[1]==1?"checked":"";
  $checked0=$options[1]==0?"checked":"";

  $form="
  {$block_menu_options['js']}
  {$block_menu_options['form']}
  <INPUT type='hidden' name='options[0]' id='bb' value='{$options[0]}'><br>
  <label>"._MB_TADTHEMES_PIN_MENU."</label>
  <input type='radio' name='options[1]' id='pin1' value='1' $checked1>"._YES."
  <input type='radio' name='options[1]' id='pin0' value='0' $checked0>"._NO."
  ";

  return $form;
}


//取得所有類別標題
if(!function_exists("block_menu_options")){
  function block_menu_options($selected=""){
    global $xoopsDB;

    if(!empty($selected)){
      $sc=explode(",",$selected);
    }

    $js="<script>
    function bbv(){
      i=0;
      var arr = new Array();";

      $sql = "select menuid,itemname,status,of_level from ".$xoopsDB->prefix("tad_themes_menu")." order by position";
      $result = $xoopsDB->query($sql);
      $option="";
      while(list($menuid,$itemname,$status,$of_level)=$xoopsDB->fetchRow($result)){

        $js.="if(document.getElementById('c{$menuid}').checked){
         arr[i] = document.getElementById('c{$menuid}').value;
         i++;
        }";
        $ckecked=(in_array($menuid,$sc))?"checked":"";
        $color=$of_level=='0'?"blue":"black";
        $color=$status=='1'?$color:"gray";
        $option.="
        <span style='white-space:nowrap;'>
          <label for='c{$menuid}' style='color:$color'>
          <input type='checkbox' id='c{$menuid}' value='{$menuid}' class='bbv' onChange=bbv() $ckecked>
          $itemname
          </label>
        </span> ";
      }

      $js.="document.getElementById('bb').value=arr.join(',');
    }
    </script>";

    $main['js']=$js;
    $main['form']=$option;
    return $main;
  }
}

/*
* Outputs a color (#000000) based Text input
*
* @param $text String of text
* @param $min_brightness Integer between 0 and 100
* @param $spec Integer between 2-10, determines how unique each color will be
*/

function genColorCodeFromText($text,$min_brightness=100,$spec=10)
{
  // Check inputs
  if(!is_int($min_brightness)) throw new Exception("$min_brightness is not an integer");
  if(!is_int($spec)) throw new Exception("$spec is not an integer");
  if($spec < 2 or $spec > 10) throw new Exception("$spec is out of range");
  if($min_brightness < 0 or $min_brightness > 255) throw new Exception("$min_brightness is out of range");
  $hash = md5($text); //Gen hash of text
  $colors = array();
  for($i=0;$i<3;$i++)
  $colors[$i] = max(array(round(((hexdec(substr($hash,$spec*$i,$spec)))/hexdec(str_pad('',$spec,'F')))*255),$min_brightness)); //convert hash into 3 decimal values between 0 and 255
  if($min_brightness > 0) //only check brightness requirements if min_brightness is about 100
  while( array_sum($colors)/3 < $min_brightness ) //loop until brightness is above or equal to min_brightness
  for($i=0;$i<3;$i++)
  $colors[$i] += 10;  //increase each color by 10
  $output = '';
  for($i=0;$i<3;$i++)
  $output .= str_pad(dechex($colors[$i]),2,0,STR_PAD_LEFT); //convert each color to hex and append to output
  return '#'.$output;
}
?>
