<?php error_reporting(0); ?>
<!DOCTYPE HTML>
<html lang="zh">
	<head>
    <title>NyaaStats 玩家数据查询</title>
	<meta name="Description" content="毛玉线圈物语 & Nyaacats 喵窝 玩家数据查询">
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<style>
		.hheader{
			text-align: center;
		}
		.footer{
			font-size: 0.9rem;
		}
	</style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
	<script src='https://www.recaptcha.net/recaptcha/api.js'></script>
  <script>
  $(document).ready(function(){
    $('.ui.dropdown').dropdown();
    $('.ui.accordion').accordion();
});
  </script>
  <script>
  function login(){
$('.ui.form')
  .form({
    fields: {
      post: {
        rules: [
          {
            type : 'empty',
            prompt : '请输入玩家 ID!'
          }
        ]
    }}})}
  </script>
      <script>
 $(document).ready(function () {
 	setTimeout(function(){
  $('#box')
  .transition({
    animation  : 'fade down',
    duration   : '0.5s',
    onComplete : function() {
    }
  });
 	}, 3000);
 	});
</script>
</head>
<body><br>
<div class="ui container">
<?php
 function check($url){
    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 10);
    curl_exec($handle);
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    if($httpCode == 200) {
      return true;
    }else{
        return false;
    }
    curl_close($handle);
 }
 $url="https://stats.craft.moe/data/players.json";
 if(check($url)==true){
     echo '<div id="box">
<br>
<div class="ui floating positive message">
<div class="header">已连接至服务器</div>
<div id="times">三秒后自动关闭</div>
</div>
</div>';
 }else{
     echo '<div id="box">
<br>
<div class="ui floating negative message">
<div class="header">无法连接服务器</div>
<div id="times">三秒后自动关闭</div>
</div>
</div>';
 }
?>
<h1 class="hheader">NyaaStats 玩家数据查询</h1>
  <?php
function send_post($url, $post_data)  
{  
    $postdata = http_build_query($post_data);  
    $options = array(  
        'http' => array(  
            'method' => 'POST',  
            'header' => 'Content-type:application/x-www-form-urlencoded',  
            'content' => $postdata,  
            'timeout' => 15 * 60 // 超时时间（单位:s）  
        )  
    );  
    $context = stream_context_create($options);  
    $result = file_get_contents($url, false, $context);  
    return $result;  
}  
              
$post_data = array(          
'secret' => 'your-secret-key',          
'response' => $_POST["g-recaptcha-response"]    );  
  $recaptcha_json_result = send_post('https://www.recaptcha.net/recaptcha/api/siteverify', $post_data);     
 $recaptcha_result = json_decode($recaptcha_json_result,true);
 
 
	if(!empty($_POST["post"])){
    if(!empty(json_decode($recaptcha_result['success'])))
	{
    if(!empty($_POST["select"]) && !empty($_POST["post"])){
    $mcapiurl="https://api.mojang.com/users/profiles/minecraft/".$_POST["post"];
    $mcjson= file_get_contents($mcapiurl);
    $djson=json_decode($mcjson);
    $id=($djson->id);}
    //多服务器支持
    if(!empty($_POST["select"]) && !empty($_POST["post"]) && $_POST["select"] == 'kedamapost'){
    $kedamaurl=("https://stats.craft.moe/data/$id/stats.json");
    $kedamajson= file_get_contents($kedamaurl);
    $dkjson=json_decode($kedamajson,true);}
    $ban=json_decode($dkjson['data']['banned']);
    
    if(!empty($_POST["select"]) && !empty($_POST["post"]) && $_POST["select"] == 'nyaapost'){
    $nyaaurl=("https://i.nyaa.cat/data/$id/stats.json");
    $nyaajson= file_get_contents($nyaaurl);
    $dkjson=json_decode($nyaajson,true);}
    $ban=json_decode($dkjson['data']['banned']);
    
    $total = (json_decode($dkjson['stats']['minecraft:mined/minecraft:emerald_ore']) + json_decode($dkjson['stats']['minecraft:mined/minecraft:coal_ore']) + json_decode($dkjson['stats']['minecraft:mined/Minecraft:iron_ore']) + json_decode($dkjson['stats']['minecraft:mined/minecraft:gold_ore']) + json_decode($dkjson['stats']['minecraft:mined/minecraft:redstone_ore']) + json_decode($dkjson['stats']['minecraft:mine/minecraft:diamond_ore']));
    $diamond_ch = (json_decode($dkjson['stats']['minecraft:mined/minecraft:diamond_ore']) / $total) * 100;
    $coal_diamond = (json_decode($dkjson['stats']['minecraft:mined/minecraft:diamond_ore']) / json_decode($dkjson['stats']['minecraft:mined/minecraft:coal_ore'])) * 100 ;
    $diamond_ch_exp_used = (json_decode($dkjson['stats']['minecraft:mined/minecraft:diamond_ore']) - json_decode($dkjson['stats']['minecraft:used/minecraft:diamond_ore'])) / $total * 100;
    $iron_diamond = (json_decode($dkjson['stats']['minecraft:mined/minecraft:diamond_ore']) / json_decode($dkjson['stats']['minecraft:mined/minecraft:iron_ore'])) * 100 ;
    $diamond_stone = (json_decode($dkjson['stats']['minecraft:mined/minecraft:diamond_ore']) / json_decode($dkjson['stats']['minecraft:mined/minecraft:stone'])) * 100 ;
    $ore_stone = ($total / json_decode($dkjson['stats']['minecraft:mined/minecraft:stone'])) * 100 ;
  }
    else { 
    $ban="notpass"; 
    echo '
    <div class="ui negative message">
  <i class="close icon"></i>
  <div class="header"> <strong>请完成人机验证！</strong></div>
  <p>如果您仍然无法完成验证，请<a href="https://bbs.craft.moe/d/817">点击这里</a>联系开发者。</p></div>';}}
    ?>
<form class="ui form" method="post">
  <div class="field">
    <label>玩家 ID</label>
    <input type="text" name="post" id="post" placeholder="Enter Player ID">
    <small>不区分大小写</small>
  </div>
  <div class="field">
  <label>选择服务器</label>
  <select class="ui dropdown fluid" name="select">
    <option value="kedamapost">毛玉线圈物语</option>
    <option value="nyaapost">Nyaacat 喵窝</option>
  </select>
  </div>
  <span style="font-size:14px;">    <div class="g-recaptcha" data-callback="recaptcha_callback" data-sitekey="your-public-key"></div></span><br>
  <button class="ui button" type="submit" onclick="login()">提交</button>
  <div class="ui error message"></div>
</form>
</div>
<br><br>
<div class="ui container">
	<div class="ui styled fluid accordion">
  <div class="active title"><i class="dropdown icon"></i>玩家信息</div>
  <div class="active content">
     <table class="ui celled table" width="100%"> 
  <tr><td>玩家名:<?php echo json_decode(json_encode($dkjson['data']['playername']));?></td></tr>
  <tr><td>UUID:<?php echo json_decode(json_encode($dkjson['data']['uuid'])); ?> </td></tr>
  <tr><td>加入服务器时间:<?php $join = json_decode(json_encode($dkjson['data']['time_start'])); if(!empty($join)){echo date('Y-m-d H:i:s', $join / 1000);} ?> </td></tr>
  <tr><td>上次在线时间:<?php $seen = json_decode(json_encode($dkjson['data']['time_last'])); if(!empty($seen)){echo date('Y-m-d H:i:s', $seen / 1000);} ?> </td></tr>
  <tr><td>是否被ban:<?php if($ban != "notpass"){ if(!empty($_POST["post"])){ echo $ban ? '是':'否'; }}?> </td></tr>
  <tr><td>数据更新时间:<?php $update = json_decode(json_encode($dkjson['data']['lastUpdate'])); if(!empty($update)){echo date('Y-m-d H:i:s', $update / 1000);} ?> </td></tr>
  </table>
  </div>
  <div class="title"><i class="dropdown icon"></i>成就信息</div>
  <div class="content">
    <table class="ui celled table" width="100%">
         <tr><td>Minecraft</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/root']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/root']['criteria']['crafting_table'],true),true));?></td></tr>
         <tr><td>石器时代</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_stone']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_stone']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_stone']['criteria']['get_stone'],true),true));?></td></tr>
         <tr><td>获得升级</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/upgrade_tools']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/upgrade_tools']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/upgrade_tools']['criteria']['stone_pickaxe'],true),true));?></td></tr>
         <tr><td>来硬的</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/smelt_iron']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/smelt_iron']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/smelt_iron']['criteria']['iron'],true),true));?></td></tr>
         <tr><td>整装上阵</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/obtain_armor']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/obtain_armor']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/obtain_armor']['criteria']['iron_chestplate'],true),true));?></td></tr>
         <tr><td>热腾腾的</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/lava_bucket']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/lava_bucket']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/lava_bucket']['criteria']['lava_bucket'],true),true));?></td></tr>
         <tr><td>这不是铁镐么</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/iron_tools']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/iron_tools']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/iron_tools']['criteria']['iron_pickaxe'],true),true));?></td></tr>
         <tr><td>抱歉，今天不行</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/deflect_arrow']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/deflect_arrow']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/deflect_arrow']['criteria']['deflected_projectile'],true),true));?></td></tr>
         <tr><td>冰桶挑战</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/form_obsidian']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/form_obsidian']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/form_obsidian']['criteria']['obsidian'],true),true));?></td></tr>
         <tr><td>钻石！</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_diamond']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_diamond']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_diamond']['criteria']['diamond'],true),true));?></td></tr>
         <tr><td>我们需要再深入些</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_nether']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_nether']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_nether']['criteria']['entered_nether'],true),true));?></td></tr>
         <tr><td>用钻石包裹我</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/shiny_gear']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/shiny_gear']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/shiny_gear']['criteria']['diamond_boots'],true),true));?></td></tr>
         <tr><td>附魔师</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enchant_item']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enchant_item']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/enchant_item']['criteria']['enchanted_item'],true),true));?></td></tr>
         <tr><td>僵尸科医生</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/cure_zombie_villager']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/cure_zombie_villager']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/cure_zombie_villager']['criteria']['cured_zombie'],true),true));?></td></tr>
         <tr><td>隔墙有眼</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/follow_ender_eye']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/follow_ender_eye']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/follow_ender_eye']['criteria']['in_stronghold'],true),true));?></td></tr>
         <tr><td>结束了？</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_end']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_end']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_end']['criteria']['entered_end'],true),true));?></td></tr>
         <tr><td>下界</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/root']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/root']['criteria']['entered_nether'],true),true));?></td></tr>
         <tr><td>子空间泡泡</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/fast_travel']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/fast_travel']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/fast_travel']['criteria']['travelled'],true),true));?></td></tr>
         <tr><td>可怕的要塞</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/find_fortress']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/find_fortress']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/find_fortress']['criteria']['fortress'],true),true));?></td></tr>
         <tr><td>见鬼去吧</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/return_to_sender']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/return_to_sender']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/return_to_sender']['criteria']['killed_ghast'],true),true));?></td></tr>
         <tr><td>与火共舞</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/obtain_blaze_rod']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/obtain_blaze_rod']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/obtain_blaze_rod']['criteria']['blaze_rod'],true),true));?></td></tr>
         <tr><td>诡异又可怕的骷髅</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/get_wither_skull']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/get_wither_skull']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/get_wither_skull']['criteria']['wither_skull'],true),true));?></td></tr>
         <tr><td>不稳定的同盟</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/uneasy_alliance']['done'])))){ echo "positive"; }else{ echo "nagative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/uneasy_alliance']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/uneasy_alliance']['criteria']['killed_ghast'],true),true));?></td></tr>
         <tr><td>本地的酿造厂</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/brew_potion']['done'])))){ echo "positive"; }else{ echo "nagative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/brew_potion']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/brew_potion']['criteria']['potion'],true),true));?></td></tr>
         <tr><td>凋零山庄</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/summon_wither']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/summon_wither']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/summon_wither']['criteria']['summoned'],true),true));?></td></tr>
         <tr><td>狂乱的鸡尾酒</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_potions']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_potions']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_potions']['criteria']['all_effects'],true),true));?></td></tr>
         <tr><td>带信标回家</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_beacon']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_beacon']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_beacon']['criteria']['beacon'],true),true));?></td></tr>
         <tr><td>为什么会变成这样呢？</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_effects']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_effects']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_effects']['criteria']['all_effects'],true),true));?></td></tr>
         <tr><td>信标工程师</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_full_beacon']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_full_beacon']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_full_beacon']['criteria']['beacon'],true),true));?></td></tr>
         <tr><td>末地</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/root']['done'])))){ echo "positive"; }else{ echo "nagative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/root']['criteria']['entered_end'],true),true));?></td></tr>
         <tr><td>解放末地</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/kill_dragon']['done'])))){ echo "positive"; }else{ echo "nagative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/kill_dragon']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/kill_dragon']['criteria']['killed_dragon'],true),true));?></td></tr>
         <tr><td>下一世代</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_egg']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_egg']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_egg']['criteria']['dragon_egg'],true),true));?></td></tr>
         <tr><td>结束了...再一次...</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/respawn_dragon']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/respawn_dragon']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/respawn_dragon']['criteria']['summoned_dragon'],true),true));?></td></tr>
         <tr><td>你需要来点薄荷糖</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_breath']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_breath']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_breath']['criteria']['dragon_breath'],true),true));?></td></tr>
         <tr><td>在游戏尽头的城市</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/find_end_city']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/find_end_city']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/find_end_city']['criteria']['in_city'],true),true));?></td></tr>
         <tr><td>天空即为极限</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/elytra']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/elytra']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/elytra']['criteria']['elytra'],true),true));?></td></tr>
         <tr><td>这上面的风景不错</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/levitate']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/levitate']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/levitate']['criteria']['levitated'],true),true));?></td></tr>
         <tr><td>冒险</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/root']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/root']['criteria']['killed_something'],true),true));?></td></tr>
         <tr><td>怪物猎人</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_a_mob']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_a_mob']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_a_mob']['criteria']['minecraft:zombie'],true),true));?></td></tr>
         <tr><td>这交易不错！</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/trade']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/trade']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/trade']['criteria']['traded'],true),true));?></td></tr>
         <tr><td>甜蜜的梦</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sleep_in_bed']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sleep_in_bed']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sleep_in_bed']['criteria']['slept_in_bed'],true),true));?></td></tr>
         <tr><td>抖包袱</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/throw_trident']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/throw_trident']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/throw_trident']['criteria']['shot_trident'],true),true));?></td></tr>
         <tr><td>瞄准目标</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/shoot_arrow']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/shoot_arrow']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/shoot_arrow']['criteria']['shot_arrow'],true),true));?></td></tr>
         <tr><td>怪物狩猎完成</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td class=""><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['done'])))){ echo "多个时间，不方便排列"; } ?></td></tr>
         <tr><td>超越生死</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/totem_of_undying']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/totem_of_undying']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/totem_of_undying']['criteria']['used_totem'],true),true));?></td></tr>
         <tr><td>招募援兵</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/summon_iron_golem']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/summon_iron_golem']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/summon_iron_golem']['criteria']['summoned_golem'],true),true));?></td></tr>
         <tr><td>探索的时光</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td class=""><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['done'])))){ echo "多个时间，不方便排列"; } ?> </td></tr>
         <tr><td>不战而栗</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/very_very_frightening']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/very_very_frightening']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/very_very_frightening']['criteria']['struck_villager'],true),true));?></td></tr>
         <tr><td>狙击手间的对决</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sniper_duel']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sniper_duel']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sniper_duel']['criteria']['killed_skeleton'],true),true));?></td></tr>
         <tr><td>扣下悬刀</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/ol_besty']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/ol_besty']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/ol_besty']['criteria']['ol_besty'],true),true));?></td></tr>
         <tr><td>现在谁才是掠夺者？</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/whos_the_pillager_now	']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/whos_the_pillager_now	']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:minecraft:adventure/whos_the_pillager_now	']['criteria']['kill_pillager'],true),true));?></td></tr>
         <tr><td>一箭双雕</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/two_birds_one_arrow']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/two_birds_one_arrow']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/two_birds_one_arrow']['criteria']['two_birds'],true),true));?></td></tr>
         <tr><td>劲弩手</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/arbalistic']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/arbalistic']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/arbalistic']['criteria']['arbalistic'],true),true));?></td></tr>
         <tr><td>自我放逐</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/voluntary_exile']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/voluntary_exile']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/voluntary_exile']['criteria']['voluntary_exile'],true),true));?></td></tr>
         <tr><td>村庄英雄</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/hero_of_the_village']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/hero_of_the_village']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/hero_of_the_village']['criteria']['hero_of_the_village'],true),true));?></td></tr>
         <tr><td>农牧业</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/root']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/root']['criteria']['consumed_item'],true),true));?></td></tr>
         <tr><td>我从哪儿来？</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/breed_an_animal']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/breed_an_animal']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/breed_an_animal']['criteria']['bred'],true),true));?></td></tr>
         <tr><td>永恒的伙伴</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tame_an_animal']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tame_an_animal']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tame_an_animal']['criteria']['tamed_animal'],true),true));?></td></tr>
         <tr><td>开荒垦地</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/plant_seed']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/plant_seed']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/plant_seed']['criteria']['wheat'],true),true));?></td></tr>
         <tr><td>腥味十足的生意</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/fishy_business']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/fishy_business']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/fishy_business']['criteria']['cod'],true),true));?></td></tr>
         <tr><td>成双成对</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td class=""><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['done'])))){ echo "多个时间，不方便排列"; } ?> </td></tr>
         <tr><td>均衡饮食</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td class=""><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['done'])))){ echo "多个时间，不方便排列"; } ?></td></tr>
         <tr><td>终极奉献</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/break_diamond_hoe']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/break_diamond_hoe']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/break_diamond_hoe']['criteria']['broke_hoe'],true),true));?></td></tr>
         <tr><td>战术性钓鱼</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tactical_fishing']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tactical_fishing']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tactical_fishing']['criteria']['pufferfish_bucket'],true),true));?></td></tr>
          </table>
  </div>
  <div class="title"><i class="dropdown icon"></i>矿透筛查</div>
  <div class="content">
 <table class="ui celled table" width="100%">
          <tr><td><?php echo '挖掘的石头:'.json_decode($dkjson['stats']['minecraft:mined/minecraft:stone']); ?> </td></tr>
          <tr><td><?php echo '挖掘的煤矿石:'.json_decode($dkjson['stats']['minecraft:mined/minecraft:coal_ore']); ?> </td></tr>
          <tr><td><?php echo '挖掘的铁矿石:'.json_decode($dkjson['stats']['minecraft:mined/minecraft:iron_ore']); ?> </td></tr>
          <tr><td><?php echo '挖掘的金矿石:'.json_decode($dkjson['stats']['minecraft:mined/minecraft:gold_ore']); ?> </td></tr>
          <tr><td><?php echo '挖掘的红石矿石:'.json_decode($dkjson['stats']['minecraft:mined/minecraft:redstone_ore']); ?> </td></tr>
          <tr><td><?php echo '挖掘的绿宝石矿石:'.json_decode($dkjson['stats']['minecraft:mined/minecraft:emerald_ore']); ?> </td></tr>
          <tr><td><?php echo '挖掘的钻石矿石:'.json_decode($dkjson['stats']['minecraft:mined/minecraft:diamond_ore']); ?> </td></tr>
          <tr><td>总挖矿数量:<?php echo $total; ?></td></tr>
          <tr><td>钻石在所有矿石中所占比例:<?php if(!empty(json_decode($recaptcha_result['success']))){echo $diamond_ch.'%';}?></td></tr>
          <tr><td>钻石在所有矿石中所占比例(除去原矿放置):<?php if(!empty(json_decode($recaptcha_result['success']))){echo $diamond_ch_exp_used.'%';}?></td></tr>
          <tr><td>钻石占煤的比例:<?php if(!empty(json_decode($recaptcha_result['success']))){echo $coal_diamond.'%';} ?></td></tr>
          <tr><td>钻石占铁的比例:<?php if(!empty(json_decode($recaptcha_result['success']))){echo $iron_diamond.'%';} ?></td></tr>
          <tr><td>钻石占石头的比例:<?php if(!empty(json_decode($recaptcha_result['success']))){echo $diamond_stone.'%';} ?></td></tr>
          <tr><td>矿物占石头的比例:<?php if(!empty(json_decode($recaptcha_result['success']))){echo $ore_stone.'%';} ?></td></tr>
          <tr><td><b>注:以上数据均不包含下界石英数量</b></td></tr>
    	</table>
  </div>
    <div class="title"><i class="dropdown icon"></i>统计信息</div>
  <div class="content">
         <table class="ui celled table" width="100%">
         <tr><td><?php echo '游戏退出次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:leave_game']); ?> </td></tr>
         <tr><td><?php echo '游戏时间(分钟):'.json_decode($dkjson['stats']['minecraft:custom/minecraft:play_one_minute']); ?> </td></tr>
         <tr><td><?php echo '上次死亡时间:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:time_since_death']); ?> </td></tr>
         <tr><td><?php echo '潜行时间	:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:sneak_time']); ?> </td></tr>
         <tr><td><?php echo '行走距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:walk_one_cm']); ?> </td></tr>
         <tr><td><?php echo '潜行距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:crouch_one_cm']); ?> </td></tr>
         <tr><td><?php echo '疾跑距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:sprint_one_cm']); ?> </td></tr>
         <tr><td><?php echo '游泳距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:swim_one_cm']); ?> </td></tr>
         <tr><td><?php echo '掉落高度:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:fall_one_cm']); ?> </td></tr>
         <tr><td><?php echo '攀爬高度:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:climb_one_cm']); ?> </td></tr>
         <tr><td><?php echo '飞行距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:fly_one_cm']); ?> </td></tr>
         <tr><td><?php echo '水下移动距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:walk_on_water_one_cm']); ?> </td></tr>
         <tr><td><?php echo '坐矿车移动距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:minecart_one_cm']); ?> </td></tr>
         <tr><td><?php echo '坐船移动距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:boat_one_cm']); ?> </td></tr>
         <tr><td><?php echo '骑马移动距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:horse_one_cm']); ?> </td></tr>
         <tr><td><?php echo '鞘翅飞行距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:aviate_one_cm']); ?> </td></tr>
         <tr><td><?php echo '跳跃次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:jump']); ?> </td></tr>
         <tr><td><?php echo '造成伤害:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:damage_dealt']); ?> </td></tr>
         <tr><td><?php echo '受到伤害:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:damage_taken']); ?> </td></tr>
         <tr><td><?php echo '总死亡次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:deaths']); ?> </td></tr>
         <tr><td><?php echo '生物击杀次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:mob_kills']); ?> </td></tr>
         <tr><td><?php echo '玩家击杀次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:player_kills']); ?> </td></tr>
         <tr><td><?php echo '物品掉落次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:drop']); ?> </td></tr>
         <tr><td><?php echo '物品附魔次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:enchant_item']); ?> </td></tr>
         <tr><td><?php echo '生物繁殖次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:animals_bred']); ?> </td></tr>
         <tr><td><?php echo '捕鱼次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:fish_caught']); ?> </td></tr>
         <tr><td><?php echo '村民对话次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:talked_to_villager']); ?> </td></tr>
         <tr><td><?php echo '村民交易次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:traded_with_villager']); ?> </td></tr>
         <tr><td><?php echo '吃掉的蛋糕片数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:eat_cake_slice']); ?> </td></tr>
         <tr><td><?php echo '炼药锅装水次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:fill_cauldron']); ?> </td></tr>
         <tr><td><?php echo '炼药锅取水次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:use_cauldron']); ?> </td></tr>
         <tr><td><?php echo '酿造台互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_brewingstand']); ?> </td></tr>
         <tr><td><?php echo '信标互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_beacon']); ?> </td></tr>
         <tr><td><?php echo '工作台互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_crafting_table']); ?> </td></tr>
         <tr><td><?php echo '熔炉互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_furnace']); ?> </td></tr>
         <tr><td><?php echo '搜查发射器次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:inspect_dispenser']); ?> </td></tr>
         <tr><td><?php echo '搜查投掷器次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:inspect_dropper']); ?> </td></tr>
         <tr><td><?php echo '搜查漏斗次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:inspect_hopper']); ?> </td></tr>
         <tr><td><?php echo '打开箱子次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:open_chest']); ?> </td></tr>
         <tr><td><?php echo '陷阱箱触发次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:trigger_trapped_chest']); ?> </td></tr>
         <tr><td><?php echo '打开末影箱次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:open_enderchest']); ?> </td></tr>
         <tr><td><?php echo '音符盒播放次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:play_noteblock']); ?> </td></tr>
         <tr><td><?php echo '音符盒调整次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:tune_noteblock']); ?> </td></tr>
         <tr><td><?php echo '盆栽种植次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:pot_flower']); ?> </td></tr>
         <tr><td><?php echo '播放唱片次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:play_record']); ?> </td></tr>
         <tr><td><?php echo '躺在床上的次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:sleep_in_bed']); ?> </td></tr>
         <tr><td><?php echo '打开潜影盒次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:open_shulker_box']); ?> </td></tr>
          </table>
  </div>
</div>	
  <br>
  	<?php
	if(!empty($_POST["post"])){
	if(!empty(json_decode($recaptcha_result['success'])))
	{
    if(!empty($_POST["select"]) && !empty($_POST["post"]) && $_POST["select"] == 'kedamapost'){
    echo '<a class="ui primary button" href="'.$kedamaurl.'">Raw数据下载</a>';}
    if(!empty($_POST["select"]) && !empty($_POST["post"]) && $_POST["select"] == 'nyaapost'){
    echo '<a class="ui primary button" href="'.$nyaaurl.'">Raw数据下载</a>';}
    }} ?>
  </div><br><br>
  <div class="ui container center aligned footer">
	<div class="container">
<p>Data Sources: <a href="https://api.mojang.com">Mojang Public API</a> & <a href="https://stats.craft.moe">NyaaStats</a></p>
<p>前往 <a href="https://craft.moe">毛玉线圈物语</a> 服务器</p>
<br>
 <p>&copy;2017-2019 blw.moe All Rights Reserved.</p>
 <p>Made by BlingWang with ❤️</sp>
<br><br>
</div>
</body>
</html>