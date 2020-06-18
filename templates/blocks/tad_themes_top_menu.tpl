<style >
ul#tad_themes_top_navigation {
  position: fixed;
  margin: 0px;
  padding: 0px;
  top: 0px;
  right: 10px;
  list-style: none;
  z-index:999999;
  width:<{$block.width}>px;
}
ul#tad_themes_top_navigation li {
  width: 103px;
  display:inline;
  float:left;
}
ul#tad_themes_top_navigation li a {
  display: block;
  float:left;
  margin-top: -2px;
  width: 100px;
  height: 25px;
  background-color:#E7F2F9;
  background-repeat:no-repeat;
  background-position:50% 10px;
  border:1px solid #BDDCEF;
  -moz-border-radius:0px 0px 10px 10px;
  -webkit-border-bottom-right-radius: 10px;
  -webkit-border-bottom-left-radius: 10px;
  -khtml-border-bottom-right-radius: 10px;
  -khtml-border-bottom-left-radius: 10px;
  text-decoration:none;
  text-align:center;
  padding-top:80px;
  opacity: 0.9;
  filter:progid:DXImageTransform.Microsoft.Alpha(opacity=90);
}
ul#tad_themes_top_navigation li a:hover{
  background-color:#CAE3F2;
}
ul#tad_themes_top_navigation li a span{
  letter-spacing:2px;
  font-size: 0.68em;
  color:#60ACD8;
  text-shadow: 0 -1px 1px #fff;
}
</style>


<ul id="tad_themes_top_navigation">
  <li><a href="<{$xoops_url}>" style="background-image: url(<{$xoops_url}>/modules/tad_themes/images/home.png);"><span>Home</span></a></li>
  <{foreach from=$block.menu item=menu}>
    <li><a href="<{$menu.itemurl}>" target="<{$menu.target}>" style="background-image: url(<{$menu.icon}>);"><span><{$menu.itemname}></span></a></li>
  <{/foreach}>
</ul>

<script type="text/javascript">
    $(function() {
        var d=300;
        $('#tad_themes_top_navigation a').each(function(){
            $(this).stop().animate({
                'marginTop':'-80px'
            },d+=150);
        });

        $('#tad_themes_top_navigation > li').hover(
        function () {
            $('a',$(this)).stop().animate({
                'marginTop':'-2px'
            },200);
        },
        function () {
            $('a',$(this)).stop().animate({
                'marginTop':'-80px'
            },200);
        }
    );
    });
</script>