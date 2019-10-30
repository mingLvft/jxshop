<?php if (!defined('THINK_PATH')) exit();?>﻿<!--
	大佬js里面的东西就不要动了，这样就可以了 js是移植别人的缺一不可
-->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>爱迦叶的老段提醒您：您访问的网页出错啦！- 404.life</title>
		<meta name="description" content="Some ideas for modern button styles and effects" />
		<meta name="keywords" content="button, effect, hover, style, inspiration, web design" />
		<meta name="author" content="Codrops" />
		<link href="/Public/Empty/img/15.0904011.ico" mce_href="favicon.ico" rel="shortcut icon" type="img/15.0904011.ico" />
		<script type="text/javascript" src="/Public/Empty/js/jquery.min.js"></script>
		<script type="text/javascript" src="/Public/Empty/js/jquery.beattext.js"></script>
		<script type="text/javascript" src="/Public/Empty/js/easying.js"></script>
		
		<link rel="stylesheet" href="/Public/Empty/css/style.css" />
		<link rel="stylesheet" href="/Public/Empty/css/button.css" />
		<link rel="stylesheet" href="/Public/Empty/css/reset.css"  />
				  <script type="text/javascript">
  		var system ={};  
    	var p = navigator.platform;       
        system.win = p.indexOf("Win") == 0;  
        system.mac = p.indexOf("Mac") == 0;  
       system.x11 = (p == "X11") || (p.indexOf("Linux") == 0);     
       if(system.win||system.mac||system.xll)else{  //如果是手机,跳转到
              window.location.href="m/index.html";  
        }
 </script>
		<script type="text/javascript">
			$(document).ready(function() {
		$('p#roloadText').beatText({isAuth:true,beatHeight:"1em",isRotate:false,upTime:100,downTime:100});
		});
		</script>
	</head>
	<body>
		
		<div class="logo" id="a" onclick="a();" title="点击我有惊喜！">
				<img src="/Public/Empty/img/20171216094159_QaLXP.jpeg">
			</div>
			<br /><br />
			<div class="container">
		<p id="roloadText">404！网页君找不到这个网页了哦...</p>
	</div>

		<div class="box bg-1">
				<button class="button button--antiman button--round-l button--text-medium" onclick="location.href='http://jxshop.com/Admin/Index/index.html'"><span>返回首页</span></button>
	</div>
	</div>
	<div class="body_buttom">
		
			
<audio autoplay loop id="music">
<source src="/Public/Empty/music/music.mp3" type="audio/mpeg">
</audio>
<script>   
   function a(){
     var audio = document.getElementById('music'); 
     if(audio.paused){                 
         audio.play();//audio.play();// 播放  
     }
     else{
          audio.pause();// 暂停
     } 
   }
</script>
	</body>
</html>