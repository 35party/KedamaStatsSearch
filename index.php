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
	  <script src="https://www.recaptcha.net/recaptcha/api.js?render=your-public-key"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.111.0/build/three.min.js"></script>
	  <script src="skinview3d.min.js"></script>
    <script>
      grecaptcha.ready(function () {
        grecaptcha.execute('your-public-key', { action: 'verify' }).then(function (token) {
        var recaptchaResponse = document.getElementById('recaptchaResponse');
        recaptchaResponse.value = token;
        });
      });
    </script>
  <script>
  $(document).ready(function(){
    $('.ui.dropdown').dropdown();
    $('.ui.accordion').accordion();
});
  </script>
  <script>
  function login(){
   if( $('.ui.form').form('is valid')) {
  $('.ui.modal').modal('show');
	};
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
    }}})
  }
  </script>
  <script>
	function form(){
		$("#form").submit();
	}
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
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
      $recaptcha_url = 'https://www.recaptcha.net/recaptcha/api/siteverify';
      $recaptcha_secret = 'your-secret-key';
      $recaptcha_response = $_POST['recaptcha_response'];
      $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
      $recaptcha = json_decode($recaptcha);
    }
	if(!empty($_POST["post"])){
    if ($recaptcha->score >= 0.6)
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
    $dkjson=json_decode($kedamajson,true);
    if(preg_match("/The file or path you request could not be found by the server./",$kedamajson)){echo '
      <div class="ui floating negative message">
      <div class="header">提示</div>
      <div id="times">该玩家不存在!</div>
      </div>';}
    else{$ban=json_decode($dkjson['data']['banned']);}}
    
    if(!empty($_POST["select"]) && !empty($_POST["post"]) && $_POST["select"] == 'nyaapost'){
    $nyaaurl=("https://i.nyaa.cat/data/$id/stats.json");
    $nyaajson= file_get_contents($nyaaurl);
    $dkjson=json_decode($nyaajson,true);
    if(strlen($nyaajson) == 0) {echo '
      <div class="ui floating negative message">
      <div class="header">提示</div>
      <div id="times">该玩家不存在!</div>
      </div>';}
    else{$ban=json_decode($dkjson['data']['banned']);}}
    
    $total = (json_decode($dkjson['stats']['minecraft:mined/minecraft:emerald_ore']) + json_decode($dkjson['stats']['minecraft:mined/minecraft:coal_ore']) + json_decode($dkjson['stats']['minecraft:mined/minecraft:iron_ore']) + json_decode($dkjson['stats']['minecraft:mined/minecraft:gold_ore']) + json_decode($dkjson['stats']['minecraft:mined/minecraft:redstone_ore']) + json_decode($dkjson['stats']['minecraft:mine/minecraft:diamond_ore']));
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
  <div class="header"> <strong>等等！</strong>reCAPTCHA认为您是机器人。</div>
  <p>如果您不是的话，请<a href="rev2.php">点击这里</a>完成人机验证</a>。</p></div>';}}
    ?>
<form class="ui form" method="post" id="form">
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
  <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
  <div class="ui button" onclick="login()">提交</div>
  <div class="ui error message"></div>
  <div class="ui modal">
  <i class="close icon"></i>
  <div class="header">
    请注意
  </div>
  <div class="image content">
    <div class="description">
      <div class="ui header">本工具列出的数据仅供参考</div>
      <p>请不要在没有确凿证据的情况下使用本工具所查询到的数据举报他人。如果您同意上述使用条款，请点击"接受"按钮继续。</p>
    </div>
  </div>
  <div class="actions">
    <div class="ui black deny button">
      拒绝
    </div>
    <div class="ui positive right labeled icon button" onclick="form()">
      接受
      <i class="checkmark icon"></i>
    </div>
  </div>
</div>
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
  <tr><td>在线时长:<?php $online = json_decode(json_encode($dkjson['data']['time_lived'])); if(!empty($seen)){echo round($online / 3600,2)." h";} ?></td></tr>
  <tr><td>是否被ban:<?php if($ban != "notpass"){ if(!empty($_POST["post"])){ echo $ban ? '是':'否'; }}?> </td></tr>
  <tr><td>数据更新时间:<?php $update = json_decode(json_encode($dkjson['data']['lastUpdate'])); if(!empty($update)){echo date('Y-m-d H:i:s', $update / 1000);} ?> </td></tr>
  </table>
  </div>
  <div class="title"><i class="dropdown icon"></i>皮肤展示</div>
  <div class="content">
    <table class="ui celled table" width="100%">
    	  <tr><td><div id="skin_container"></div></td></tr>
    </table>
  </div>
  <div class="title"><i class="dropdown icon"></i>成就信息</div>
  <div class="content">
    <table class="ui celled table" width="100%">
         <tr><td width="30%">Minecraft</td><td width="30%" class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/root']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/root']['criteria']['crafting_table'],true),true));?></td></tr>
         <tr><td>石器时代</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_stone']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_stone']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_stone']['criteria']['get_stone'],true),true));?></td></tr>
         <tr><td>获得升级</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/upgrade_tools']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/upgrade_tools']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/upgrade_tools']['criteria']['stone_pickaxe'],true),true));?></td></tr>
         <tr><td>来硬的</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/smelt_iron']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/smelt_iron']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/smelt_iron']['criteria']['iron'],true),true));?></td></tr>
         <tr><td>整装上阵</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/obtain_armor']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/obtain_armor']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/obtain_armor']['criteria']['iron_chestplate'],true),true));?></td></tr>
         <tr><td>热腾腾的</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/lava_bucket']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/lava_bucket']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/lava_bucket']['criteria']['lava_bucket'],true),true));?></td></tr>
         <tr><td>这不是铁镐么</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/iron_tools']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/iron_tools']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/iron_tools']['criteria']['iron_pickaxe'],true),true));?></td></tr>
         <tr><td>不吃这套，谢谢</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/deflect_arrow']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/deflect_arrow']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/deflect_arrow']['criteria']['deflected_projectile'],true),true));?></td></tr>
         <tr><td>冰桶挑战</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/form_obsidian']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/form_obsidian']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/form_obsidian']['criteria']['obsidian'],true),true));?></td></tr>
         <tr><td>钻石！</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_diamond']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_diamond']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_diamond']['criteria']['diamond'],true),true));?></td></tr>
         <tr><td>勇往直下</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_nether']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_nether']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_nether']['criteria']['entered_nether'],true),true));?></td></tr>
         <tr><td>钻石护体</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/shiny_gear']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/shiny_gear']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/shiny_gear']['criteria']['diamond_boots'],true),true));?></td></tr>
         <tr><td>附魔师</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enchant_item']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enchant_item']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/enchant_item']['criteria']['enchanted_item'],true),true));?></td></tr>
         <tr><td>僵尸科医生</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/cure_zombie_villager']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/cure_zombie_villager']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/cure_zombie_villager']['criteria']['cured_zombie'],true),true));?></td></tr>
         <tr><td>隔墙有眼</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/follow_ender_eye']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/follow_ender_eye']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/follow_ender_eye']['criteria']['in_stronghold'],true),true));?></td></tr>
         <tr><td>结束了？</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_end']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_end']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_end']['criteria']['entered_end'],true),true));?></td></tr>
         <tr><td>下界</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/root']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/root']['criteria']['entered_nether'],true),true));?></td></tr>
         <tr><td>四维碎块</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/fast_travel']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/fast_travel']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/fast_travel']['criteria']['travelled'],true),true));?></td></tr>
         <tr><td>可怕的要塞</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/find_fortress']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/find_fortress']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/find_fortress']['criteria']['fortress'],true),true));?></td></tr>
         <tr><td>见鬼去吧</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/return_to_sender']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/return_to_sender']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/return_to_sender']['criteria']['killed_ghast'],true),true));?></td></tr>
         <tr><td>与火共舞</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/obtain_blaze_rod']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/obtain_blaze_rod']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/obtain_blaze_rod']['criteria']['blaze_rod'],true),true));?></td></tr>
         <tr><td>惊悚恐怖骷髅头</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/get_wither_skull']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/get_wither_skull']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/get_wither_skull']['criteria']['wither_skull'],true),true));?></td></tr>
         <tr><td>不稳定的同盟</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/uneasy_alliance']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/uneasy_alliance']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/uneasy_alliance']['criteria']['killed_ghast'],true),true));?></td></tr>
         <tr><td>本地的酿造厂</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/brew_potion']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/brew_potion']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/brew_potion']['criteria']['potion'],true),true));?></td></tr>
         <tr><td>凋零山庄</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/summon_wither']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/summon_wither']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/summon_wither']['criteria']['summoned'],true),true));?></td></tr>
         <tr><td>狂乱的鸡尾酒</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_potions']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_potions']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_potions']['criteria']['all_effects'],true),true));?></td></tr>
         <tr><td>带信标回家</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_beacon']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_beacon']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_beacon']['criteria']['beacon'],true),true));?></td></tr>
         <tr><td>为什么会变成这样呢？</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_effects']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_effects']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_effects']['criteria']['all_effects'],true),true));?></td></tr>
         <tr><td>信标工程师</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_full_beacon']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_full_beacon']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_full_beacon']['criteria']['beacon'],true),true));?></td></tr>
         <tr><td>末地</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/root']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/root']['criteria']['entered_end'],true),true));?></td></tr>
         <tr><td>解放末地</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/kill_dragon']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/kill_dragon']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/kill_dragon']['criteria']['killed_dragon'],true),true));?></td></tr>
         <tr><td>下一世代</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_egg']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_egg']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_egg']['criteria']['dragon_egg'],true),true));?></td></tr>
         <tr><td>结束了...再一次...</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/respawn_dragon']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/respawn_dragon']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/respawn_dragon']['criteria']['summoned_dragon'],true),true));?></td></tr>
         <tr><td>你需要来点薄荷糖</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_breath']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_breath']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_breath']['criteria']['dragon_breath'],true),true));?></td></tr>
         <tr><td>在游戏尽头的城市</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/find_end_city']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/find_end_city']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/find_end_city']['criteria']['in_city'],true),true));?></td></tr>
         <tr><td>天空即为极限</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/elytra']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/elytra']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/elytra']['criteria']['elytra'],true),true));?></td></tr>
         <tr><td>这上面的风景不错</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/levitate']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/levitate']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/levitate']['criteria']['levitated'],true),true));?></td></tr>
         <tr><td>冒险</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/root']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/root']['criteria']['killed_something'],true),true));?></td></tr>
         <tr><td>怪物猎人</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_a_mob']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_a_mob']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_a_mob']['criteria']['minecraft:zombie'],true),true));?></td></tr>
         <tr><td>成交！</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/trade']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/trade']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/trade']['criteria']['traded'],true),true));?></td></tr>
         <tr><td>胶着状态</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/honey_block_slide']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/honey_block_slide']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/honey_block_slide']['criteria']['honey_block_slide'],true),true));?></td></tr>
         <tr><td>甜蜜的梦</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sleep_in_bed']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sleep_in_bed']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sleep_in_bed']['criteria']['slept_in_bed'],true),true));?></td></tr>
         <tr><td>抖包袱</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/throw_trident']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/throw_trident']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/throw_trident']['criteria']['shot_trident'],true),true));?></td></tr>
         <tr><td>瞄准目标</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/shoot_arrow']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/shoot_arrow']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/shoot_arrow']['criteria']['shot_arrow'],true),true));?></td></tr>
         <tr><td>资深怪物猎人</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td class=""><?php echo '
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:blaze'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">烈焰人   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:blaze'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:pillager'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">掠夺者   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:pillager'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:skeleton'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">骷髅   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:skeleton'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:zombie_pigman'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">僵尸猪人   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:zombie_pigman'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:guardian'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">守卫者   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:guardian'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:vindicator'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">卫道士   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:vindicator'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:magma_cube'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">岩浆怪   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:magma_cube'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:spider'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">蜘蛛   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:spider'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:creeper'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">爬行者   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:creeper'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:slime'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">史莱姆   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:slime'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:evoker'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">唤魔者   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:evoker'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:phantom'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">幻翼   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:phantom'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:witch'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">女巫   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:witch'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:wither_skeleton'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">凋零骷髅   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:wither_skeleton'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:husk'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">尸壳   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:husk'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:shulker'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">潜影贝   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:shulker'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:cave_spider'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">洞穴蜘蛛   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:cave_spider'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:silverfish'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">蠹虫   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:silverfish'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:stray'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">流浪者   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:stray'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:enderman'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">末影人   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:enderman'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:zombie'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">僵尸   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:zombie'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:drowned'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">溺尸   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:drowned'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:zombie_villager'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">僵尸村民   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:zombie_villager'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:ravager'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">劫掠兽   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:ravager'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:ghast'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">恶魂   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['criteria']['minecraft:ghast'],true),true).'</div></div>
</div>
'; ?></td></tr>
         <tr><td>超越生死</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/totem_of_undying']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/totem_of_undying']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/totem_of_undying']['criteria']['used_totem'],true),true));?></td></tr>
         <tr><td>招募援兵</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/summon_iron_golem']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/summon_iron_golem']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/summon_iron_golem']['criteria']['summoned_golem'],true),true));?></td></tr>
         <tr><td>探索的时光</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td class=""><?php echo '
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:badlands'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">恶地   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:badlands'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:badlands_plateau'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">恶地高原   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:badlands_plateau'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:bamboo_jungle'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">竹林   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:bamboo_jungle'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:bamboo_jungle_hills'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">竹林丘陵   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:bamboo_jungle_hills'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:beach'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">沙滩   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:beach'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:birch_forest'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">桦木森林   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:birch_forest'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:birch_forest_hills'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">桦木森林丘陵   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:birch_forest_hills'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:cold_ocean'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">冷水海洋   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:cold_ocean'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:dark_forest'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">黑森林   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:dark_forest'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:deep_cold_ocean'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">冷水深海   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:deep_cold_ocean'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:deep_frozen_ocean'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">封冻深海   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:deep_frozen_ocean'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:deep_lukewarm_ocean'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">温水深海   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:deep_lukewarm_ocean'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:desert'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">沙漠   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:desert'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:desert_hills'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">沙漠丘陵   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:desert_hills'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:forest'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">森林   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:forest'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:frozen_river'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">冻河   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:frozen_river'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:giant_tree_taiga'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">巨型针叶林   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:giant_tree_taiga'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:giant_tree_taiga_hills'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">巨型针叶林丘陵   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:giant_tree_taiga_hills'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:jungle'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">丛林   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:jungle'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:jungle_edge'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">丛林边缘   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:jungle_edge'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:jungle_hills'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">丛林丘陵   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:jungle_hills'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:lukewarm_ocean'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">温水海洋   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:lukewarm_ocean'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:mountains'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">山地   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:mountains'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:mushroom_field_shore'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">蘑菇岛海岸   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:mushroom_field_shore'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:mushroom_fields'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">蘑菇岛   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:mushroom_fields'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:plains'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">草原   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:plains'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:river'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">河流   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:river'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:savanna'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">热带草原   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:savanna'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:savanna_plateau'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">热带高原   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:savanna_plateau'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:snowy_beach'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">积雪的沙滩   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:snowy_beach'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:snowy_mountains'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">雪山   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:snowy_mountains'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:snowy_taiga'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">积雪的针叶林   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:snowy_taiga'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:snowy_taiga_hills'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">积雪的针叶林丘陵   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:snowy_taiga_hills'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:snowy_tundra'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">积雪的冻原   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:snowy_tundra'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:stone_shore'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">石岸   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:stone_shore'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:swamp'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">沼泽   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:swamp'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:taiga'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">针叶林   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:taiga'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:taiga_hills'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">针叶林丘陵   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:taiga_hills'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:warm_ocean'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">暖水海洋   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:warm_ocean'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:wooded_badlands_plateau'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">繁茂的恶地高原   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:wooded_badlands_plateau'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:wooded_hills'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">繁茂的丘陵   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:wooded_hills'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:wooded_mountains'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">繁茂的山地   '.json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['criteria']['minecraft:wooded_mountains'],true),true).'</div></div>
</div>
'; ?> </td></tr>
         <tr><td>魔女审判</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/very_very_frightening']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/very_very_frightening']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/very_very_frightening']['criteria']['struck_villager'],true),true));?></td></tr>
         <tr><td>狙击手间的对决</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sniper_duel']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sniper_duel']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sniper_duel']['criteria']['killed_skeleton'],true),true));?></td></tr>
         <tr><td>扣下悬刀</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/ol_betsy']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/ol_betsy']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/ol_betsy']['criteria']['shot_crossbow'],true),true));?></td></tr>
         <tr><td>现在谁才是掠夺者？</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/whos_the_pillager_now']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/whos_the_pillager_now']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/whos_the_pillager_now']['criteria']['kill_pillager'],true),true));?></td></tr>
         <tr><td>一箭双雕</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/two_birds_one_arrow']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/two_birds_one_arrow']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/two_birds_one_arrow']['criteria']['two_birds'],true),true));?></td></tr>
         <tr><td>劲弩手</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/arbalistic']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/arbalistic']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/arbalistic']['criteria']['arbalistic'],true),true));?></td></tr>
         <tr><td>自我放逐</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/voluntary_exile']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/voluntary_exile']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/voluntary_exile']['criteria']['voluntary_exile'],true),true));?></td></tr>
         <tr><td>村庄英雄</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/hero_of_the_village']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/hero_of_the_village']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/hero_of_the_village']['criteria']['hero_of_the_village'],true),true));?></td></tr>
         <tr><td>农牧业</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/root']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/root']['criteria']['consumed_item'],true),true));?></td></tr>
         <tr><td>与蜂共舞</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/safely_harvest_honey']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/safely_harvest_honey']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/safely_harvest_honey']['criteria']['safely_harvest_honey'],true),true));?></td></tr>
         <tr><td>我从哪儿来？</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/breed_an_animal']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/breed_an_animal']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/breed_an_animal']['criteria']['bred'],true),true));?></td></tr>
         <tr><td>永恒的伙伴</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tame_an_animal']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tame_an_animal']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tame_an_animal']['criteria']['tamed_animal'],true),true));?></td></tr>
         <tr><td>举巢搬迁</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/silk_touch_nest']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/silk_touch_nest']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/silk_touch_nest']['criteria']['silk_touch_nest'],true),true));?></td></tr>
         <tr><td>开荒垦地</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/plant_seed']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/plant_seed']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/plant_seed']['criteria']['wheat'],true),true));?></td></tr>
         <tr><td>腥味十足的生意</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/fishy_business']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/fishy_business']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/fishy_business']['criteria']['cod'],true),true));?></td></tr>
         <tr><td>成双成对</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td class=""><?php echo '
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:cat'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">猫   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:cat'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:chicken'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">鸡   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:chicken'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:cow'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">牛   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:cow'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:fox'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">狐狸   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:fox'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:horse'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">马   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:horse'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:llama'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">羊驼   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:llama'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:mooshroom'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">哞菇   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:mooshroom'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:panda'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">熊猫   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:panda'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:pig'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">猪   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:pig'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:rabbit'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">兔子   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:rabbit'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:sheep'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">羊   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:sheep'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:turtle'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">海龟   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:turtle'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:wolf'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">狼   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:wolf'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:ocelot'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">豹猫   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:ocelot'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:bee'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">蜜蜂   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['criteria']['minecraft:bee'],true),true).'</div></div>
</div>
'; ?> </td></tr>
         <tr><td>百猫全书</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue	']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue	']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td class=""><?php echo '
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/british_shorthair.png'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">英国短毛猫   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/british_shorthair.png'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/all_black.png'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">黑猫   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/all_black.png'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/black.png'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">西服猫   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/black.png'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/calico.png'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">花猫   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/calico.png'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/jellie.png'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">Jellie   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/jellie.png'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/persian.png'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">波斯猫   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/persian.png'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/ragdoll.png'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">布偶猫   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/ragdoll.png'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/red.png'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">红虎斑猫   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/red.png'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/siamese.png'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">暹罗猫   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/siamese.png'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/tabby.png'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">虎斑猫   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/tabby.png'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/white.png'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">白猫   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue']['criteria']['textures/entity/cat/white.png'],true),true).'</div></div>
</div>
'; ?> </td></tr>
         <tr><td>均衡饮食</td><td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td class=""><?php echo '
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['apple'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">苹果   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['apple'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['baked_potato'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">烤马铃薯   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['baked_potato'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['beef'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">生牛肉   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['beef'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['beetroot'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">甜菜根   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['beetroot'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['beetroot_soup'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">甜菜汤   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['beetroot_soup'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['bread'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">面包   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['bread'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['carrot'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">胡萝卜   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['carrot'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['chicken'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">生鸡肉   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['chicken'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['chorus_fruit'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">紫颂果   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['chorus_fruit'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['cooked_beef'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">牛排   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['cooked_beef'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['cooked_chicken'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">熟鸡肉   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['cooked_chicken'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['cooked_cod'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">熟鳕鱼   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['cooked_cod'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['cooked_mutton'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">熟羊肉   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['cooked_mutton'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['cooked_porkchop'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">熟猪排   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['cooked_porkchop'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['cooked_rabbit'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">熟兔肉   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['cooked_rabbit'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['cooked_salmon'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">熟鲑鱼   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['cooked_salmon'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['cookie'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">曲奇   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['cookie'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['dried_kelp'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">干海带   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['dried_kelp'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['enchanted_golden_apple'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">附魔金苹果   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['enchanted_golden_apple'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['golden_apple'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">金苹果   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['golden_apple'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['golden_carrot'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">金胡萝卜   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['golden_carrot'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['melon_slice'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">西瓜片   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['melon_slice'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['mushroom_stew'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">蘑菇煲   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['mushroom_stew'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['mutton'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">生羊肉   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['mutton'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['poisonous_potato'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">毒马铃薯   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['poisonous_potato'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['porkchop'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">生猪排   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['porkchop'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['potato'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">马铃薯   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['potato'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['pufferfish'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">河豚   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['pufferfish'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['pumpkin_pie'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">南瓜派   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['pumpkin_pie'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['rabbit'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">生兔肉   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['rabbit'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['rabbit_stew'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">兔肉煲   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['rabbit_stew'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['cod'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">生鳕鱼   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['cod'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['salmon'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">生鲑鱼   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['salmon'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['rotten_flesh'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">腐肉   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['rotten_flesh'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['spider_eye'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">蜘蛛眼   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['spider_eye'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['suspicious_stew'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">迷之炖菜   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['suspicious_stew'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['sweet_berries'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">甜浆果   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['sweet_berries'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['tropical_fish'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">热带鱼   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['tropical_fish'],true),true).'</div></div>
</div>
<div class="ui list">
<div class="item">';
if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['honey_bottle'])))){echo '<i class="check icon" style="color:green"></i>';}else{echo '<i class="times icon" style="color:red"></i>';}
echo'
<div class="content">蜂蜜瓶   '.json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['criteria']['honey_bottle'],true),true).'</div></div>
</div>
'; ?></td></tr>
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
          <tr><td>钻石在所有矿石中所占比例:<?php if ($recaptcha->score >= 0.6){echo $diamond_ch.'%';}?></td></tr>
          <tr><td>钻石在所有矿石中所占比例(除去原矿放置):<?php if ($recaptcha->score >= 0.6){echo $diamond_ch_exp_used.'%';}?></td></tr>
          <tr><td>钻石占煤的比例:<?php if ($recaptcha->score >= 0.6){echo $coal_diamond.'%';} ?></td></tr>
          <tr><td>钻石占铁的比例:<?php if ($recaptcha->score >= 0.6){echo $iron_diamond.'%';} ?></td></tr>
          <tr><td>钻石占石头的比例:<?php if ($recaptcha->score >= 0.6){echo $diamond_stone.'%';} ?></td></tr>
          <tr><td>矿物占石头的比例:<?php if ($recaptcha->score >= 0.6){echo $ore_stone.'%';} ?></td></tr>
          <tr><td><b>注:以上数据均不包含下界石英数量</b></td></tr>
    	</table>
  </div>
    <div class="title"><i class="dropdown icon"></i>统计信息</div>
  <div class="content">
         <table class="ui celled table" width="100%">
         <tr><td><?php echo '游戏退出次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:leave_game']); ?> </td></tr>
         <tr><td><?php echo '游戏时间(秒):'.json_decode($dkjson['stats']['minecraft:custom/minecraft:play_one_minute']); ?> </td></tr>
         <tr><td><?php echo '上次死亡时间:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:time_since_death']); ?> </td></tr>
         <tr><td><?php echo '距离上次休息:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:time_since_rest']); ?> </td></tr>
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
         <tr><td><?php echo '骑猪移动距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:pig_one_cm']); ?> </td></tr>
         <tr><td><?php echo '骑马移动距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:horse_one_cm']); ?> </td></tr>
         <tr><td><?php echo '鞘翅飞行距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:aviate_one_cm']); ?> </td></tr>
         <tr><td><?php echo '跳跃次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:jump']); ?> </td></tr>
         <tr><td><?php echo '造成伤害:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:damage_dealt']); ?> </td></tr>
         <tr><td><?php echo '造成伤害(被吸收):'.json_decode($dkjson['stats']['minecraft:custom/minecraft:damage_dealt_absorbed']); ?> </td></tr>
         <tr><td><?php echo '造成伤害(被抵挡):'.json_decode($dkjson['stats']['minecraft:custom/minecraft:damage_dealt_resisted']); ?> </td></tr>
         <tr><td><?php echo '受到伤害:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:damage_taken']); ?> </td></tr>
         <tr><td><?php echo '吸收的伤害:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:damage_absorbed']); ?> </td></tr>
         <tr><td><?php echo '抵挡的伤害:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:damage_resisted']); ?> </td></tr>
         <tr><td><?php echo '盾牌抵挡的伤害:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:damage_blocked_by_shield']); ?> </td></tr>
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
         <tr><td><?php echo '清洗盔甲次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:clean_armor']); ?> </td></tr>
         <tr><td><?php echo '清洗旗帜次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:clean_banner']); ?> </td></tr>
         <tr><td><?php echo '清洗潜影盒次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:clean_shulker_box']); ?> </td></tr>
         <tr><td><?php echo '酿造台互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_brewingstand']); ?> </td></tr>
         <tr><td><?php echo '信标互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_beacon']); ?> </td></tr>
         <tr><td><?php echo '工作台互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_crafting_table']); ?> </td></tr>
         <tr><td><?php echo '熔炉互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_furnace']); ?> </td></tr>
         <tr><td><?php echo '高炉互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_blast_furnace']); ?> </td></tr>
         <tr><td><?php echo '营火互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_campfire']); ?> </td></tr>
         <tr><td><?php echo '制图台互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_cartography_table']); ?> </td></tr>
         <tr><td><?php echo '讲台互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_lectern']); ?> </td></tr>
         <tr><td><?php echo '织布机互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_loom']); ?> </td></tr>
         <tr><td><?php echo '烟熏炉互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_smoker']); ?> </td></tr>
         <tr><td><?php echo '切石机互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_stonecutter']); ?> </td></tr>
         <tr><td><?php echo '搜查发射器次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:inspect_dispenser']); ?> </td></tr>
         <tr><td><?php echo '搜查投掷器次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:inspect_dropper']); ?> </td></tr>
         <tr><td><?php echo '搜查漏斗次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:inspect_hopper']); ?> </td></tr>
         <tr><td><?php echo '打开箱子次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:open_chest']); ?> </td></tr>
         <tr><td><?php echo '陷阱箱触发次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:trigger_trapped_chest']); ?> </td></tr>
         <tr><td><?php echo '打开末影箱次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:open_enderchest']); ?> </td></tr>
         <tr><td><?php echo '打开木桶次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:open_barrel']); ?> </td></tr>
         <tr><td><?php echo '音符盒播放次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:play_noteblock']); ?> </td></tr>
         <tr><td><?php echo '音符盒调整次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:tune_noteblock']); ?> </td></tr>
         <tr><td><?php echo '盆栽种植次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:pot_flower']); ?> </td></tr>
         <tr><td><?php echo '播放唱片次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:play_record']); ?> </td></tr>
         <tr><td><?php echo '躺在床上的次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:sleep_in_bed']); ?> </td></tr>
         <tr><td><?php echo '打开潜影盒次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:open_shulker_box']); ?> </td></tr>
         <tr><td><?php echo '鸣钟次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:bell_ring']); ?> </td></tr>
         <tr><td><?php echo '触发袭击次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:raid_trigger']); ?> </td></tr>
         <tr><td><?php echo '袭击胜利次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:raid_win']); ?> </td></tr>
          </table>
  </div>
</div>	
  <br>
  	<?php
	if(!empty($_POST["post"])){
	if ($recaptcha->score >= 0.6)
	{
    if(!empty($_POST["select"]) && !empty($_POST["post"]) && $_POST["select"] == 'kedamapost'){
    echo '<a class="ui primary button" href="'.$kedamaurl.'">Raw数据下载</a>';}
    if(!empty($_POST["select"]) && !empty($_POST["post"]) && $_POST["select"] == 'nyaapost'){
    echo '<a class="ui primary button" href="'.$nyaaurl.'">Raw数据下载</a>';}
    }} ?>
  </div><br><br>
  <div class="ui container center aligned footer">
	<div class="container">
<p>Data Sources: <a href="https://api.mojang.com">Mojang Public API</a> & <a href="https://stats.craft.moe">NyaaStats</a> & <a href="https://crafatar.com">Crafatar</a></p>
<p>前往 <a href="https://craft.moe">毛玉线圈物语</a> 服务器</p>
<br>
 <p>&copy;2017-2019 blw.moe All Rights Reserved.</p>
 <p>Made by BlingWang with ❤️</sp>
<br><br>
</div>
<script async="async">
	let skinViewer = new skinview3d.SkinViewer({
		domElement: document.getElementById("skin_container"),
		width: 250,
		height: 300,
		skinUrl: "<?php echo "https://crafatar.com/skins/". json_decode(json_encode($dkjson['data']['uuid'])); ?>"
	});
	let control = new skinview3d.createOrbitControls(skinViewer);
	skinViewer.animation = new skinview3d.CompositeAnimation();
	let walk = skinViewer.animation.add(skinview3d.WalkingAnimation);
	walk.speed = 1.5;
	control.enableRotate = true;
	control.enableZoom = false;
	let rotate = skinViewer.animation.add(skinview3d.RotatingAnimation);
</script>
</body>
</html>