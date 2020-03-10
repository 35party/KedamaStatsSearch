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
    <script>console.log('\n' + ' %c 感谢使用 KedamaStatsSearch' + ' %c Maintained by BlingWang ' + '\n', 'color: #ffffff; background: #000000; padding:5px 0;', 'color: #ffffff; background: #000000; padding:5px 0;');</script>
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
	$('.ui.advItem').popup({inline: true, on: 'click'});
	$('h4.advTitle_parent').text('上游进度');
	$('h4.advTitle_requirements').text('完成条件');
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
<script>
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
	    console.warn("Enter提交已被禁用");
    }
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
    
    $total = (json_decode($dkjson['stats']['minecraft:mined/minecraft:emerald_ore']) + json_decode($dkjson['stats']['minecraft:mined/minecraft:coal_ore']) + json_decode($dkjson['stats']['minecraft:mined/minecraft:iron_ore']) + json_decode($dkjson['stats']['minecraft:mined/minecraft:gold_ore']) + json_decode($dkjson['stats']['minecraft:mined/minecraft:redstone_ore']) + json_decode($dkjson['stats']['minecraft:mined/minecraft:diamond_ore']));
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
         <tr><td width="30%">
			<span class="ui advItem">Minecraft</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				（无）
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在物品栏中获得工作台。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/root']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/root']['criteria']['crafting_table'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">石器时代</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				Minecraft
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在物品栏中获得圆石。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_stone']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_stone']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_stone']['criteria']['get_stone'],true),true));?></td>
		 </tr>
         <tr><td>
			<span class="ui advItem">获得升级</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				石器时代
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在物品栏中获得石镐。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/upgrade_tools']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/upgrade_tools']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/upgrade_tools']['criteria']['stone_pickaxe'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">来硬的</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				获得升级
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在物品栏中获得铁锭。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/smelt_iron']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/smelt_iron']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/smelt_iron']['criteria']['iron'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">整装上阵</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				来硬的
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在物品栏中获得任意类型的铁盔甲。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/obtain_armor']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/obtain_armor']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/obtain_armor']['criteria']['iron_chestplate'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">热腾腾的</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				来硬的
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在物品栏中获得熔岩桶。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/lava_bucket']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/lava_bucket']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/lava_bucket']['criteria']['lava_bucket'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">这不是铁镐么</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				来硬的
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在物品栏中获得铁镐。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/iron_tools']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/iron_tools']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/iron_tools']['criteria']['iron_pickaxe'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">不吃这套，谢谢</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				整装上阵
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				用盾牌弹开一个弹射物。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/deflect_arrow']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/deflect_arrow']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/deflect_arrow']['criteria']['deflected_projectile'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">冰桶挑战</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				热腾腾的
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在物品栏中获得黑曜石。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/form_obsidian']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/form_obsidian']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/form_obsidian']['criteria']['obsidian'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">钻石！</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				这不是铁镐么
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在物品栏中获得钻石。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_diamond']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_diamond']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_diamond']['criteria']['diamond'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">勇往直下</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				冰桶挑战
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				进入下界维度。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_nether']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_nether']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_nether']['criteria']['entered_nether'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">钻石护体</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				钻石！
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在物品栏中获得任意类型的钻石盔甲。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/shiny_gear']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/shiny_gear']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/shiny_gear']['criteria']['diamond_boots'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">附魔师</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				钻石！
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在附魔台里附魔一件物品。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enchant_item']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enchant_item']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/enchant_item']['criteria']['enchanted_item'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">僵尸科医生</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				民	勇往直下
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				向僵尸村民扔出喷溅型虚弱药水，并喂它吃一个金苹果。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/cure_zombie_villager']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/cure_zombie_villager']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/cure_zombie_villager']['criteria']['cured_zombie'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">隔墙有眼</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				勇往直下
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				进入末地要塞。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/follow_ender_eye']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/follow_ender_eye']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/follow_ender_eye']['criteria']['in_stronghold'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">结束了？</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				隔墙有眼
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				进入末路之地维度。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_end']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_end']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_end']['criteria']['entered_end'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">下界</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				（无）
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				进入下界维度。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/root']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/root']['criteria']['entered_nether'],true),true));?></td>
		</tr>
		<tr><td>
			<span class="ui advItem">见鬼去吧</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				下界
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				反弹恶魂的火球，杀死恶魂。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/return_to_sender']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/return_to_sender']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/return_to_sender']['criteria']['killed_ghast'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">四维碎块</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				下界
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				利用下界移动对应主世界两个点至少7000个方块的水平距离（相当于在下界移动875格）。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/fast_travel']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/fast_travel']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/fast_travel']['criteria']['travelled'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">阴森的要塞</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				下界
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				进入下界要塞。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/find_fortress']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/find_fortress']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/find_fortress']['criteria']['fortress'],true),true));?></td>
		</tr>
		<tr><td>
			<span class="ui advItem">脆弱的同盟</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				见鬼去吧
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在主世界中杀死一只恶魂（先将恶魂从下界通过地狱门带到主世界）。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/uneasy_alliance']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/uneasy_alliance']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/uneasy_alliance']['criteria']['killed_ghast'],true),true));?></td>
		</tr>
		<tr><td>
			<span class="ui advItem">惊悚恐怖骷髅头</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				阴森的要塞
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在物品栏中获得凋灵骷髅头颅。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/get_wither_skull']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/get_wither_skull']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/get_wither_skull']['criteria']['wither_skull'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">与火共舞</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				阴森的要塞
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在物品栏中获得烈焰棒。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/obtain_blaze_rod']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/obtain_blaze_rod']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/obtain_blaze_rod']['criteria']['blaze_rod'],true),true));?></td>
		</tr>
		<tr><td>
			<span class="ui advItem">凋零山庄</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				惊悚恐怖骷髅头
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				凋灵生成时玩家处于以凋灵为中心的100.9×100.9×103.5区域里。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/summon_wither']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/summon_wither']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/summon_wither']['criteria']['summoned'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">本地的酿造厂</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				与火共舞
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				从酿造台的输出栏取得药水（将药水放入酿造台再取出也可以）。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/brew_potion']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/brew_potion']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/brew_potion']['criteria']['potion'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">带信标回家</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				凋零山庄
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				当信标被激活时，处在以其为中心的20×20×14区域里。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_beacon']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_beacon']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_beacon']['criteria']['beacon'],true),true));?></td>
		</tr>
		<tr><td>
			<span class="ui advItem">狂乱的鸡尾酒</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				本地的酿造厂
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在你身上同时拥有这13种药水效果：速度、缓慢、力量、跳跃提升、生命恢复、防火、水下呼吸、隐身、夜视、虚弱、中毒、缓降、抗性提升。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_potions']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_potions']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_potions']['criteria']['all_effects'],true),true));?></td>
		</tr>
		<tr><td>
			<span class="ui advItem">信标工程师</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				带信标回家
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				当4层信标塔的的信标方块被激活时，处在以其为中心的20×20×14区域里。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_full_beacon']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_full_beacon']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_full_beacon']['criteria']['beacon'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">为什么会变成这样呢？</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				狂乱的鸡尾酒
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在你身上同时拥有这26种效果：伤害吸收、不祥之兆、失明、潮涌能量、海豚的恩惠、防火、发光、急迫、村庄英雄、饥饿、隐身、跳跃提升、飘浮、挖掘疲劳、反胃、夜视、中毒、生命恢复、抗性提升、缓降、缓慢、速度、力量、水下呼吸、虚弱、凋零。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_effects']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_effects']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_effects']['criteria']['all_effects'],true),true));?></td>
		</tr>
         
         <tr><td>
			<span class="ui advItem">末地</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				（无）
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				进入末路之地维度。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/root']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/root']['criteria']['entered_end'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">解放末地</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				末地
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				杀死末影龙。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/kill_dragon']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/kill_dragon']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/kill_dragon']['criteria']['killed_dragon'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">下一世代</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				解放末地
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在物品栏中获得龙蛋。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_egg']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_egg']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_egg']['criteria']['dragon_egg'],true),true));?></td>
		</tr>
		<tr><td>
			<span class="ui advItem">远程折跃</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				解放末地
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				扔末影珍珠、或通过其他方式进入末地折跃门。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/enter_end_gateway']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/enter_end_gateway']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/enter_end_gateway']['criteria']['enter_end_gateway'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">结束了…再一次…</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				解放末地
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				召唤末影龙。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/respawn_dragon']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/respawn_dragon']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/respawn_dragon']['criteria']['summoned_dragon'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">你需要来点薄荷糖</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				解放末地
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在物品栏中获得龙息。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_breath']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_breath']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_breath']['criteria']['dragon_breath'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">在游戏尽头的城市</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				远程折跃
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				进入末地城。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/find_end_city']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/find_end_city']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/find_end_city']['criteria']['in_city'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">天空即为极限</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				在游戏尽头的城市
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在物品栏中获得鞘翅。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/elytra']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/elytra']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/elytra']['criteria']['elytra'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">这上面的风景不错</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				在游戏尽头的城市
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				拥有飘浮状态效果，并移动垂直距离50个方块。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/levitate']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/levitate']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/levitate']['criteria']['levitated'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">冒险</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				（无）
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				杀死任意实体，或被任意实体杀死。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/root']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/root']['criteria']['killed_something'],true),true));?></td>
		</tr>
		<tr><td>
			<span class="ui advItem">自我放逐</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				冒险
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				杀死一名袭击队长。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/voluntary_exile']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/voluntary_exile']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/voluntary_exile']['criteria']['voluntary_exile'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">怪物猎人</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				冒险
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				杀死这25种‌‌生物中的一种：洞穴蜘蛛、蜘蛛、末影人、烈焰人、苦力怕、唤魔者、恶魂、守卫者、尸壳、岩浆怪、幻翼、掠夺者、劫掠兽、潜影贝、蠹虫、骷髅、史莱姆、流浪者、卫道士、女巫、凋灵骷髅、僵尸、僵尸猪人、僵尸村民、溺尸。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_a_mob']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_a_mob']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_a_mob']['criteria']['minecraft:zombie'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">成交！</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				（无）
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				成功与一名村民进行交易。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/trade']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/trade']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/trade']['criteria']['traded'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">胶着状态</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				冒险
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在空气中时水平碰撞蜂蜜块。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/honey_block_slide']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/honey_block_slide']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/honey_block_slide']['criteria']['honey_block_slide'],true),true));?></td>
		</tr>
		<tr><td>
			<span class="ui advItem">扣下悬刀</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				冒险
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				用弩射出一支箭或一支烟花火箭。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/ol_betsy']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/ol_betsy']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/ol_betsy']['criteria']['shot_crossbow'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">甜蜜的梦</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				冒险
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				在床上睡觉（即使未成功入眠也可以）。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sleep_in_bed']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sleep_in_bed']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sleep_in_bed']['criteria']['slept_in_bed'],true),true));?></td>
		</tr>
		<tr><td>
			<span class="ui advItem">村庄英雄</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				自我放逐
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				成功在一场袭击中保卫村庄。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/hero_of_the_village']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/hero_of_the_village']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/hero_of_the_village']['criteria']['hero_of_the_village'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">抖包袱</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				怪物猎人
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				往什么东西扔出三叉戟。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/throw_trident']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/throw_trident']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/throw_trident']['criteria']['shot_trident'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">瞄准目标</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				怪物猎人
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				拉弓，让箭射到实体上。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/shoot_arrow']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/shoot_arrow']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/shoot_arrow']['criteria']['shot_arrow'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">资深怪物猎人</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				怪物猎人
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				杀死所有指定的生物，详细进度及完成情况请参考右侧列表。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td class=""><?php echo '
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
         <tr><td>
			<span class="ui advItem">超越生死</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				怪物猎人
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				利用不死图腾从死亡的边缘复活。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/totem_of_undying']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/totem_of_undying']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/totem_of_undying']['criteria']['used_totem'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">招募援兵</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				成交！
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				生成一只铁傀儡。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/summon_iron_golem']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/summon_iron_golem']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/summon_iron_golem']['criteria']['summoned_golem'],true),true));?></td>
		</tr>
		<tr><td>
			<span class="ui advItem">一箭双雕</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				扣下悬刀
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				用带有贯穿附魔的弩和一支箭，一次性杀死两只幻翼。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/two_birds_one_arrow']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/two_birds_one_arrow']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/two_birds_one_arrow']['criteria']['two_birds'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">现在谁才是掠夺者？</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				扣下悬刀
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				用弩射击掠夺者。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/whos_the_pillager_now']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/whos_the_pillager_now']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/whos_the_pillager_now']['criteria']['kill_pillager'],true),true));?></td>
		</tr>
         
         <tr><td>
			<span class="ui advItem">劲弩手</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				扣下悬刀
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				使用带穿透IV的弩一箭射杀5种不同的生物。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/arbalistic']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/arbalistic']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/arbalistic']['criteria']['arbalistic'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">探索的时光</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				甜蜜的梦
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				到访所有指定的生物群系，详细进度及完成情况请参考右侧列表。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td class=""><?php echo '
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
         <tr><td>
			<span class="ui advItem">魔女审判</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				抖包袱
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				用带有引雷附魔的三叉戟产生的雷电击中村民。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/very_very_frightening']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/very_very_frightening']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/very_very_frightening']['criteria']['struck_villager'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">狙击手间的对决</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				瞄准目标
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				当玩家使用弓或三叉戟射杀一只骷髅时，与其水平距离超过50米。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sniper_duel']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sniper_duel']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sniper_duel']['criteria']['killed_skeleton'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">农牧业</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				（无）
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				吃一种能被吃下的东西。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/root']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/root']['criteria']['consumed_item'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">与蜂共舞</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				上游进度
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				将营火放在蜂巢的下面，然后使用玻璃瓶对蜂巢收集蜂蜜。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/safely_harvest_honey']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/safely_harvest_honey']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/safely_harvest_honey']['criteria']['safely_harvest_honey'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">我从哪儿来？</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				农牧业
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				繁殖一对动物。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/breed_an_animal']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/breed_an_animal']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/breed_an_animal']['criteria']['bred'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">永恒的伙伴</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				农牧业
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				驯服一只动物。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tame_an_animal']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tame_an_animal']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tame_an_animal']['criteria']['tamed_animal'],true),true));?></td>
		</tr>
		<tr><td>
			<span class="ui advItem">腥味十足的生意</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				农牧业
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				用钓鱼竿钓上一条鱼。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/fishy_business']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/fishy_business']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/fishy_business']['criteria']['cod'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">举巢搬迁</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				农牧业
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				用带有精准采集的工具移动住着3只蜜蜂的蜂巢。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/silk_touch_nest']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/silk_touch_nest']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/silk_touch_nest']['criteria']['silk_touch_nest'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">开荒垦地</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				农牧业
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				种植这5种植物中的一种：小麦、南瓜梗、西瓜梗、甜菜根、地狱疣。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/plant_seed']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/plant_seed']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/plant_seed']['criteria']['wheat'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">成双成对</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				我从哪儿来？
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				繁殖所有指定的动物，详细进度及完成情况请参考右侧列表。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td class=""><?php echo '
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
         <tr><td>
			<span class="ui advItem">百猫全书</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				永恒的伙伴	
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				驯服所有种类的猫，详细进度及完成情况请参考右侧列表。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue	']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/complete_catalogue	']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td class=""><?php echo '
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
		<tr><td>
			<span class="ui advItem">战术性钓鱼</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				腥味十足的生意
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				对着水中生物形式的鱼使用水桶，获得鱼桶。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tactical_fishing']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tactical_fishing']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tactical_fishing']['criteria']['pufferfish_bucket'],true),true));?></td>
		</tr>
         <tr><td>
			<span class="ui advItem">均衡饮食</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				开荒垦地
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				食用所有指定的食物，详细进度及完成情况请参考右侧列表。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td class=""><?php echo '
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
         <tr><td>
			<span class="ui advItem">终极奉献</span>
			<div class="ui flowing popup transition top left hidden"><div class="ui two column divided equal height center aligned grid"><div class="column"><h4 class="ui header advTitle_parent"></h4>
				开垦荒地
			</div><div class="column"><h4 class="ui header advTitle_requirements"></h4>
				用光一把钻石锄的所有耐久，使其损毁。
			</div></div></div></td>
			<td class="<?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/break_diamond_hoe']['done'])))){ echo "positive"; }else{ echo "negative"; };?>"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/break_diamond_hoe']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/break_diamond_hoe']['criteria']['broke_hoe'],true),true));?></td>
		</tr>
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
		skinUrl: "<?php if(!empty($_POST["post"])){echo "https://crafatar.com/skins/". json_decode(json_encode($dkjson['data']['uuid']));} else {echo "fallback.png";} //fallback可以使用任何皮肤 ?>"
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