<!DOCTYPE HTML>
<html lang="zh">
	<head>
		<title>NyaaStats 玩家数据查询</title>
	 <meta name="Description" content="Kedama Stats Search">
 <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
  <style>
	* {font-family: "微软雅黑"}
		</style>
	<script src='https://www.recaptcha.net/recaptcha/api.js'></script>
  <script type="text/javascript">
    function recaptcha_callback(){
      $('.btn').click();
    }
</script>
</head>
<body>
	<div class="container">
	<br>
	<h1 class="text-center">NyaaStats 玩家数据查询</h1>
	<br>
	<form method="post">
  <div class="form-group">
    <label>请输入用户名</label>
    <input type="text" class="form-control" name="post" placeholder="Enter username">
    <small id="emailHelp" class="form-text text-muted">&nbsp;不区分大小写</small>
    <br>
    <label>选择服务器</label>
    <select class="form-control" name="select">
        <option value="kedamapost">毛玉线圈物语</option>
        <option value="nyaapost">Nyaacat 喵窝</option>
      </select>
      <br>
      
<span style="font-size:14px;">    <div class="g-recaptcha" data-callback="recaptcha_callback" data-sitekey="Your_Site_Key"></div></span>  

      <br>
  <button type="submit" class="btn btn-primary">提交</button>
  </div>
</form>
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
'secret' => 'Your_Site_Key',          
'response' => $_POST["g-recaptcha-response"]    );  
  $recaptcha_json_result = send_post('https://www.recaptcha.net/recaptcha/api/siteverify', $post_data);     
 $recaptcha_result = json_decode($recaptcha_json_result,true);     
?>  

	<?php
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
    $nyaaurl=("https://i.nyaa.cat/static/data/$id/stats.json");
    $nyaajson= file_get_contents($nyaaurl);
    $dkjson=json_decode($nyaajson,true);}
    $ban=json_decode($dkjson['data']['banned']);
    $total = (json_decode($dkjson['stats']['minecraft:mined/minecraft:emerald_ore']) + json_decode($dkjson['stats']['minecraft:mined/minecraft:coal_ore']) + json_decode($dkjson['stats']['minecraft:mined/minecraft:iron_ore']) + json_decode($dkjson['stats']['minecraft:mined/minecraft:gold_ore']) + json_decode($dkjson['stats']['minecraft:mined/minecraft:redstone_ore']) + json_decode($dkjson['stats']['minecraft:mined/minecraft:diamond_ore']));
    $diamond_ch = (json_decode($dkjson['stats']['minecraft:mined/minecraft:diamond_ore']) / $total) * 100;
    $coal_diamond = (json_decode($dkjson['stats']['minecraft:mined/minecraft:diamond_ore']) / json_decode($dkjson['stats']['minecraft:mined/minecraft:coal_ore'])) * 100 ;
    $iron_diamond = (json_decode($dkjson['stats']['minecraft:mined/minecraft:diamond_ore']) / json_decode($dkjson['stats']['minecraft:mined/minecraft:iron_ore'])) * 100 ;
    $diamond_stone = (json_decode($dkjson['stats']['minecraft:mined/minecraft:diamond_ore']) / json_decode($dkjson['stats']['minecraft:mined/minecraft:stone'])) * 100 ;
    $ore_stone = ($total / json_decode($dkjson['stats']['minecraft:mined/minecraft:stone'])) * 100 ;
  }
    else { $ban="notpass"; echo '<div class="alert alert-danger alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>等等！</strong>请确认您不是机器人</div>';}}
    ?>
  </div>

<div class="container">
<?php //$mjstats = file_get_contents("https://status.mojang.com/check"); 
//$dmjstats = json_decode($mjstats,true);
//$mjarray = array();
//foreach ($dmjstats as $key => $valves){
//  foreach ($valves as $k => $v){
//    $mjarray [$k] = $v;
//  }
//}
//$emjarray = json_encode($mjarray,true);
//Check mojang status. Not finished.
?>
  <div id="accordion">
    <div class="card">
      <div class="card-header">
        <a class="collapsed card-link" data-toggle="collapse" href="#collapseOne">
          玩家信息
        </a>
      </div>
      <div id="collapseOne" class="collapse show" data-parent="#accordion">
        <div class="card-body">
        
         <table class="table-bordered" width="100%"> 
          <tr><td height="30px">玩家名:<?php echo json_decode(json_encode($dkjson['data']['playername']));?></td></tr>
          <tr><td height="30px">UUID:<?php echo json_decode(json_encode($dkjson['data']['uuid'])); ?> </td></tr>
          <tr><td height="30px">加入服务器时间:<?php $join = json_decode(json_encode($dkjson['data']['time_start'])); if(!empty($join)){echo date('Y-m-d H:i:s', $join / 1000);} ?> </td></tr>
          <tr><td height="30px">上次在线时间:<?php $seen = json_decode(json_encode($dkjson['data']['time_last'])); if(!empty($seen)){echo date('Y-m-d H:i:s', $seen / 1000);} ?> </td></tr>
          <tr><td height="30px">是否被ban:<?php if($ban != "notpass"){ if(!empty($_POST["post"])){ echo $ban ? '是':'否'; }}?> </td></tr>
          <tr><td height="30px">数据更新时间:<?php $update = json_decode(json_encode($dkjson['data']['lastUpdate'])); if(!empty($update)){echo date('Y-m-d H:i:s', $update / 1000);} ?> </td></tr>
          </table>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <a class="collapsed card-link" data-toggle="collapse" href="#collapseO">
          成就信息
        </a>
      </div>
      <div id="collapseO" class="collapse" data-parent="#accordion">
        <div class="card-body">
         <table class="table-bordered" width="100%">

         <tr><td height="30px">Minecraft</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/root']['criteria']['crafting_table'],true),true));?></td></tr>
         <tr><td height="30px">石器时代</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_stone']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_stone']['criteria']['get_stone'],true),true));?></td></tr>
         <tr><td height="30px">获得升级</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/upgrade_tools']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/upgrade_tools']['criteria']['stone_pickaxe'],true),true));?></td></tr>
         <tr><td height="30px">来硬的</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/smelt_iron']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/smelt_iron']['criteria']['iron'],true),true));?></td></tr>
         <tr><td height="30px">整装上阵</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/obtain_armor']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/obtain_armor']['criteria']['iron_chestplate'],true),true));?></td></tr>
         <tr><td height="30px">热腾腾的</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/lava_bucket']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/lava_bucket']['criteria']['lava_bucket'],true),true));?></td></tr>
         <tr><td height="30px">这不是铁镐么</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/iron_tools']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/iron_tools']['criteria']['iron_pickaxe'],true),true));?></td></tr>
         <tr><td height="30px">抱歉，今天不行</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/deflect_arrow']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/deflect_arrow']['criteria']['deflected_projectile'],true),true));?></td></tr>
         <tr><td height="30px">冰桶挑战</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/form_obsidian']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/form_obsidian']['criteria']['obsidian'],true),true));?></td></tr>
         <tr><td height="30px">钻石！</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_diamond']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/mine_diamond']['criteria']['diamond'],true),true));?></td></tr>
         <tr><td height="30px">我们需要再深入些</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_nether']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_nether']['criteria']['entered_nether'],true),true));?></td></tr>
         <tr><td height="30px">用钻石包裹我</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/shiny_gear']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/shiny_gear']['criteria']['diamond_boots'],true),true));?></td></tr>
         <tr><td height="30px">附魔师</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enchant_item']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/enchant_item']['criteria']['enchanted_item'],true),true));?></td></tr>
         <tr><td height="30px">僵尸科医生</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/cure_zombie_villager']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/cure_zombie_villager']['criteria']['cured_zombie'],true),true));?></td></tr>
         <tr><td height="30px">隔墙有眼</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/follow_ender_eye']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/follow_ender_eye']['criteria']['in_stronghold'],true),true));?></td></tr>
         <tr><td height="30px">结束了？</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_end']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:story/enter_the_end']['criteria']['entered_end'],true),true));?></td></tr>
         <tr><td height="30px">下界</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/root']['criteria']['entered_nether'],true),true));?></td></tr>
         <tr><td height="30px">子空间泡泡</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/fast_travel']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/fast_travel']['criteria']['travelled'],true),true));?></td></tr>
         <tr><td height="30px">可怕的要塞</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/find_fortress']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/find_fortress']['criteria']['fortress'],true),true));?></td></tr>
         <tr><td height="30px">见鬼去吧</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/return_to_sender']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/return_to_sender']['criteria']['killed_ghast'],true),true));?></td></tr>
         <tr><td height="30px">与火共舞</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/obtain_blaze_rod']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/obtain_blaze_rod']['criteria']['blaze_rod'],true),true));?></td></tr>
         <tr><td height="30px">诡异又可怕的骷髅</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/get_wither_skull']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/get_wither_skull']['criteria']['wither_skull'],true),true));?></td></tr>
         <tr><td height="30px">不稳定的同盟</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/uneasy_alliance']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/uneasy_alliance']['criteria']['killed_ghast'],true),true));?></td></tr>
         <tr><td height="30px">本地的酿造厂</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/brew_potion']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/brew_potion']['criteria']['potion'],true),true));?></td></tr>
         <tr><td height="30px">凋零山庄</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/summon_wither']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/summon_wither']['criteria']['summoned'],true),true));?></td></tr>
         <tr><td height="30px">狂乱的鸡尾酒</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_potions']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_potions']['criteria']['all_effects'],true),true));?></td></tr>
         <tr><td height="30px">带信标回家</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_beacon']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_beacon']['criteria']['beacon'],true),true));?></td></tr>
         <tr><td height="30px">为什么会变成这样呢？</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_effects']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/all_effects']['criteria']['all_effects'],true),true));?></td></tr>
         <tr><td height="30px">信标工程师</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_full_beacon']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:nether/create_full_beacon']['criteria']['beacon'],true),true));?></td></tr>
         <tr><td height="30px">末地</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/root']['criteria']['entered_end'],true),true));?></td></tr>
         <tr><td height="30px">解放末地</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/kill_dragon']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/kill_dragon']['criteria']['killed_dragon'],true),true));?></td></tr>
         <tr><td height="30px">下一世代</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_egg']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_egg']['criteria']['dragon_egg'],true),true));?></td></tr>
         <tr><td height="30px">结束了...再一次...</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/respawn_dragon']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/respawn_dragon']['criteria']['summoned_dragon'],true),true));?></td></tr>
         <tr><td height="30px">你需要来点薄荷糖</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_breath']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/dragon_breath']['criteria']['dragon_breath'],true),true));?></td></tr>
         <tr><td height="30px">在游戏尽头的城市</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/find_end_city']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/find_end_city']['criteria']['in_city'],true),true));?></td></tr>
         <tr><td height="30px">天空即为极限</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/elytra']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/elytra']['criteria']['elytra'],true),true));?></td></tr>
         <tr><td height="30px">这上面的风景不错</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:end/levitate']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:end/levitate']['criteria']['levitated'],true),true));?></td></tr>
         <tr><td height="30px">冒险</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/root']['criteria']['killed_something'],true),true));?></td></tr>
         <tr><td height="30px">怪物猎人</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_a_mob']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_a_mob']['criteria']['minecraft:zombie'],true),true));?></td></tr>
         <tr><td height="30px">这交易不错！</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/trade']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/trade']['criteria']['traded'],true),true));?></td></tr>
         <tr><td height="30px">甜蜜的梦</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sleep_in_bed']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sleep_in_bed']['criteria']['slept_in_bed'],true),true));?></td></tr>
         <tr><td height="30px">抖包袱</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/throw_trident']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/throw_trident']['criteria']['shot_trident'],true),true));?></td></tr>
         <tr><td height="30px">瞄准目标</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/shoot_arrow']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/shoot_arrow']['criteria']['shot_arrow'],true),true));?></td></tr>
         <tr><td height="30px">怪物狩猎完成</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/kill_all_mobs']['done'])))){ echo "时间无法确定"; } ?></td></tr>
         <tr><td height="30px">超越生死</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/totem_of_undying']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/totem_of_undying']['criteria']['used_totem'],true),true));?></td></tr>
         <tr><td height="30px">招募援兵</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/summon_iron_golem']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/summon_iron_golem']['criteria']['summoned_golem'],true),true));?></td></tr>
         <tr><td height="30px">探索的时光</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/adventuring_time']['done'])))){ echo "时间无法确定"; } ?> </td></tr>
         <tr><td height="30px">不战而栗</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/very_very_frightening']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/very_very_frightening']['criteria']['struck_villager'],true),true));?></td></tr>
         <tr><td height="30px">狙击手间的对决</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sniper_duel']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:adventure/sniper_duel']['criteria']['killed_skeleton'],true),true));?></td></tr>
         <tr><td height="30px">农牧业</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/root']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/root']['criteria']['consumed_item'],true),true));?></td></tr>
         <tr><td height="30px">我从哪儿来？</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/breed_an_animal']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/breed_an_animal']['criteria']['bred'],true),true));?></td></tr>
         <tr><td height="30px">永恒的伙伴</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tame_an_animal']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tame_an_animal']['criteria']['tamed_animal'],true),true));?></td></tr>
         <tr><td height="30px">开荒垦地</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/plant_seed']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/plant_seed']['criteria']['wheat'],true),true));?></td></tr>
         <tr><td height="30px">腥味十足的生意</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/fishy_business']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/fishy_business']['criteria']['cod'],true),true));?></td></tr>
         <tr><td height="30px">成双成对</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/bred_all_animals']['done'])))){ echo "时间无法确定"; } ?> </td></tr>
         <tr><td height="30px">均衡饮食</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/balanced_diet']['done'])))){ echo "时间无法确定"; } ?></td></tr>
         <tr><td height="30px">终极奉献</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/break_diamond_hoe']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/break_diamond_hoe']['criteria']['broke_hoe'],true),true));?></td></tr>
         <tr><td height="30px">战术性钓鱼</td><td height="30px"><?php if(!empty(json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tactical_fishing']['done'])))){ echo "已完成"; }else{ echo "未完成"; };?></td><td height="30px"><?php print_r (json_decode(json_encode($dkjson['advancements']['minecraft:husbandry/tactical_fishing']['criteria']['pufferfish_bucket'],true),true));?></td></tr>
         
          </table>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <a class="collapsed card-link" data-toggle="collapse" href="#collapseT">
        <span style="color:red">矿透筛查(实验性)</span>
      </a>
      </div>
      <div id="collapseT" class="collapse" data-parent="#accordion">
        <div class="card-body">
          <table class="table-bordered" width="100%">
          <tr><td height="30px"><?php echo '挖掘的石头:'.json_decode($dkjson['stats']['minecraft:mined/minecraft:stone']); ?> </td></tr>
          <tr><td height="30px"><?php echo '挖掘的煤矿石:'.json_decode($dkjson['stats']['minecraft:mined/minecraft:coal_ore']); ?> </td></tr>
          <tr><td height="30px"><?php echo '挖掘的铁矿石:'.json_decode($dkjson['stats']['minecraft:mined/minecraft:iron_ore']); ?> </td></tr>
          <tr><td height="30px"><?php echo '挖掘的金矿石:'.json_decode($dkjson['stats']['minecraft:mined/minecraft:gold_ore']); ?> </td></tr>
          <tr><td height="30px"><?php echo '挖掘的红石矿石:'.json_decode($dkjson['stats']['minecraft:mined/minecraft:redstone_ore']); ?> </td></tr>
          <tr><td height="30px"><?php echo '挖掘的绿宝石矿石:'.json_decode($dkjson['stats']['minecraft:mined/minecraft:emerald_ore']); ?> </td></tr>
          <tr><td height="30px"><?php echo '挖掘的钻石矿石:'.json_decode($dkjson['stats']['minecraft:mined/minecraft:diamond_ore']); ?> </td></tr>
          <tr><td height="30px">总挖矿数量:<?php echo $total; ?></td></tr>
          <tr><td height="30px">钻石在所有矿石中所占比例:<?php if(!empty(json_decode($recaptcha_result['success']))){echo $diamond_ch.'%';}?></td></tr>
          <tr><td height="30px">钻石占煤的比例:<?php if(!empty(json_decode($recaptcha_result['success']))){echo $coal_diamond.'%';} ?></td></tr>
          <tr><td height="30px">钻石占铁的比例:<?php if(!empty(json_decode($recaptcha_result['success']))){echo $iron_diamond.'%';} ?></td></tr>
          <tr><td height="30px">钻石占石头的比例:<?php if(!empty(json_decode($recaptcha_result['success']))){echo $diamond_stone.'%';} ?></td></tr>
          <tr><td height="30px">矿物占石头的比例:<?php if(!empty(json_decode($recaptcha_result['success']))){echo $ore_stone.'%';} ?></td></tr>
          <tr><td height="30px"><b>注:以上数据均不包含下界石英数量</b></td></tr>
    	</table>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <a class="collapsed card-link" data-toggle="collapse" href="#collapseN">
          统计信息
        </a>
      </div>
      <div id="collapseN" class="collapse" data-parent="#accordion">
        <div class="card-body">
         <table class="table-bordered" width="100%">
         <tr><td height="30px"><?php echo '游戏退出次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:leave_game']); ?> </td></tr>
         <tr><td height="30px"><?php echo '游戏时间(分钟):'.json_decode($dkjson['stats']['minecraft:custom/minecraft:play_one_minute']); ?> </td></tr>
         <tr><td height="30px"><?php echo '上次死亡时间:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:time_since_death']); ?> </td></tr>
         <tr><td height="30px"><?php echo '潜行时间	:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:sneak_time']); ?> </td></tr>
         <tr><td height="30px"><?php echo '行走距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:walk_one_cm']); ?> </td></tr>
         <tr><td height="30px"><?php echo '潜行距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:crouch_one_cm']); ?> </td></tr>
         <tr><td height="30px"><?php echo '疾跑距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:sprint_one_cm']); ?> </td></tr>
         <tr><td height="30px"><?php echo '游泳距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:swim_one_cm']); ?> </td></tr>
         <tr><td height="30px"><?php echo '掉落高度:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:fall_one_cm']); ?> </td></tr>
         <tr><td height="30px"><?php echo '攀爬高度:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:climb_one_cm']); ?> </td></tr>
         <tr><td height="30px"><?php echo '飞行距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:fly_one_cm']); ?> </td></tr>
         <tr><td height="30px"><?php echo '水下移动距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:walk_on_water_one_cm']); ?> </td></tr>
         <tr><td height="30px"><?php echo '坐矿车移动距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:minecart_one_cm']); ?> </td></tr>
         <tr><td height="30px"><?php echo '坐船移动距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:boat_one_cm']); ?> </td></tr>
         <tr><td height="30px"><?php echo '骑马移动距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:horse_one_cm']); ?> </td></tr>
         <tr><td height="30px"><?php echo '鞘翅飞行距离:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:aviate_one_cm']); ?> </td></tr>
         <tr><td height="30px"><?php echo '跳跃次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:jump']); ?> </td></tr>
         <tr><td height="30px"><?php echo '造成伤害:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:damage_dealt']); ?> </td></tr>
         <tr><td height="30px"><?php echo '受到伤害:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:damage_taken']); ?> </td></tr>
         <tr><td height="30px"><?php echo '总死亡次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:deaths']); ?> </td></tr>
         <tr><td height="30px"><?php echo '生物击杀次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:mob_kills']); ?> </td></tr>
         <tr><td height="30px"><?php echo '玩家击杀次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:player_kills']); ?> </td></tr>
         <tr><td height="30px"><?php echo '物品掉落次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:drop']); ?> </td></tr>
         <tr><td height="30px"><?php echo '物品附魔次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:enchant_item']); ?> </td></tr>
         <tr><td height="30px"><?php echo '生物繁殖次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:animals_bred']); ?> </td></tr>
         <tr><td height="30px"><?php echo '捕鱼次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:fish_caught']); ?> </td></tr>
         <tr><td height="30px"><?php echo '村民对话次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:talked_to_villager']); ?> </td></tr>
         <tr><td height="30px"><?php echo '村民交易次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:traded_with_villager']); ?> </td></tr>
         <tr><td height="30px"><?php echo '吃掉的蛋糕片数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:eat_cake_slice']); ?> </td></tr>
         <tr><td height="30px"><?php echo '炼药锅装水次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:fill_cauldron']); ?> </td></tr>
         <tr><td height="30px"><?php echo '炼药锅取水次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:use_cauldron']); ?> </td></tr>
         <tr><td height="30px"><?php echo '酿造台互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_brewingstand']); ?> </td></tr>
         <tr><td height="30px"><?php echo '信标互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_beacon']); ?> </td></tr>
         <tr><td height="30px"><?php echo '工作台互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_crafting_table']); ?> </td></tr>
         <tr><td height="30px"><?php echo '熔炉互动次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:interact_with_furnace']); ?> </td></tr>
         <tr><td height="30px"><?php echo '搜查发射器次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:inspect_dispenser']); ?> </td></tr>
         <tr><td height="30px"><?php echo '搜查投掷器次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:inspect_dropper']); ?> </td></tr>
         <tr><td height="30px"><?php echo '搜查漏斗次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:inspect_hopper']); ?> </td></tr>
         <tr><td height="30px"><?php echo '打开箱子次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:open_chest']); ?> </td></tr>
         <tr><td height="30px"><?php echo '陷阱箱触发次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:trigger_trapped_chest']); ?> </td></tr>
         <tr><td height="30px"><?php echo '打开末影箱次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:open_enderchest']); ?> </td></tr>
         <tr><td height="30px"><?php echo '音符盒播放次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:play_noteblock']); ?> </td></tr>
         <tr><td height="30px"><?php echo '音符盒调整次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:tune_noteblock']); ?> </td></tr>
         <tr><td height="30px"><?php echo '盆栽种植次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:pot_flower']); ?> </td></tr>
         <tr><td height="30px"><?php echo '播放唱片次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:play_record']); ?> </td></tr>
         <tr><td height="30px"><?php echo '躺在床上的次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:sleep_in_bed']); ?> </td></tr>
         <tr><td height="30px"><?php echo '打开潜影盒次数:'.json_decode($dkjson['stats']['minecraft:custom/minecraft:open_shulker_box']); ?> </td></tr>
          </table>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
        被杀死次数
      </a>
      </div>
      <div id="collapseTwo" class="collapse" data-parent="#accordion">
        <div class="card-body">
          <table class="table-bordered" width="100%">
    <tr><td height="30px"><?php echo '烈焰人:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:blaze']); ?> </td></tr>
    <tr><td height="30px"><?php echo '洞穴蜘蛛:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:cave_spider']); ?> </td></tr>
    <tr><td height="30px"><?php echo '爬行者:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:creeper']); ?> </td></tr>
    <tr><td height="30px"><?php echo '溺尸:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:drowned']); ?> </td></tr>
    <tr><td height="30px"><?php echo '远古守卫者:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:elder_guardian']); ?> </td></tr>
    <tr><td height="30px"><?php echo '末影龙:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:ender_dragon']); ?> </td></tr>
    <tr><td height="30px"><?php echo '末影人:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:enderman']); ?> </td></tr>
    <tr><td height="30px"><?php echo '末影螨:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:endermite']); ?> </td></tr>
    <tr><td height="30px"><?php echo '唤魔者:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:evoker']); ?> </td></tr>
    <tr><td height="30px"><?php echo '恶魂:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:ghast']); ?> </td></tr>
    <tr><td height="30px"><?php echo '守卫者:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:guardian']); ?> </td></tr>
    <tr><td height="30px"><?php echo '尸壳:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:husk']); ?> </td></tr>
    <tr><td height="30px"><?php echo '幻术师:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:illusioner']); ?> </td></tr>
    <tr><td height="30px"><?php echo '岩浆怪:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:magma_cube']); ?> </td></tr>
    <tr><td height="30px"><?php echo '幻翼:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:phantom']); ?> </td></tr>
    <tr><td height="30px"><?php echo '河豚:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:pufferfish']); ?> </td></tr>
    <tr><td height="30px"><?php echo '潜影贝:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:shulker']); ?> </td></tr>
    <tr><td height="30px"><?php echo '蠹虫:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:silverfish']); ?> </td></tr>
    <tr><td height="30px"><?php echo '骷髅:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:skeleton']); ?> </td></tr>
    <tr><td height="30px"><?php echo '史莱姆:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:slime']); ?> </td></tr>
    <tr><td height="30px"><?php echo '蜘蛛:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:spider']); ?> </td></tr>
    <tr><td height="30px"><?php echo '流浪者:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:stray']); ?> </td></tr>
    <tr><td height="30px"><?php echo '恼鬼:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:vex']); ?> </td></tr>
    <tr><td height="30px"><?php echo '卫道士:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:vindicator']); ?> </td></tr>
    <tr><td height="30px"><?php echo '女巫:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:witch']); ?> </td></tr>
    <tr><td height="30px"><?php echo '凋零:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:wither']); ?> </td></tr>
    <tr><td height="30px"><?php echo '凋零骷髅:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:wither_skeleton']); ?> </td></tr>
    <tr><td height="30px"><?php echo '僵尸:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:zombie']); ?> </td></tr>
    <tr><td height="30px"><?php echo '僵尸猪人:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:zombie_pigman']); ?> </td></tr>
    <tr><td height="30px"><?php echo '僵尸村民:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:zombie_villager']); ?> </td></tr>
    <tr><td height="30px"><?php echo '羊驼:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:llama']); ?> </td></tr>
    <tr><td height="30px"><?php echo '北极熊:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:polar_bear']); ?> </td></tr>
    <tr><td height="30px"><?php echo '狼:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:wolf']); ?> </td></tr>
    <tr><td height="30px"><?php echo '玩家:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:player']); ?> </td></tr>
	</table>
        </div>
      </div>
    </div>
  </div>
  <br>
  	<?php
	if(!empty($_POST["post"])){
	if(!empty(json_decode($recaptcha_result['success'])))
	{
    if(!empty($_POST["select"]) && !empty($_POST["post"]) && $_POST["select"] == 'kedamapost'){
    echo '<a class="btn btn-primary" href="'.$kedamaurl.'">Raw数据下载</a>';}
    if(!empty($_POST["select"]) && !empty($_POST["post"]) && $_POST["select"] == 'nyaapost'){
    echo '<a class="btn btn-primary" href="'.$nyaaurl.'">Raw数据下载</a>';}
    }} ?>
  </div>
  <footer>
	<br><br><br>
	<div class="container">
<small class="form-text text-muted text-center">Data Sources: <a href="https://api.mojang.com">Mojang Public API</a> & <a href="https://stats.craft.moe">NyaaStats️</a></small>
<small class="form-text text-muted text-center">前往 <a href="https://craft.moe">毛玉线圈物语</a> 服务器</small>

<br>
  <small class="form-text text-muted text-center">&copy;2017-2019 blingwang.cn All Rights Reserved.</small>
 <small class="form-text text-muted text-center">Made by BlingWang with ❤️</small>
<br><br>

		</div>
	</footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
</html>