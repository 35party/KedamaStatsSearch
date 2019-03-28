<!DOCTYPE HTML>
<html lang="zh">
	<head>
		<title>Kedama数据查询</title>
	 <meta name="Description" content="Kedama Stats Search">
 <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
	* {font-family: "微软雅黑"}
		</style>
</head>
<body>
	<div class="container">
	<br>
	<h1>Kedama数据查询</h1>
	<form method="post">
  <div class="form-group">
    <label>请输入用户名</label>
    <input type="text" class="form-control" name="post" placeholder="Enter username">
    <small id="emailHelp" class="form-text text-muted">&nbsp;不区分大小写</small>
  </div>
  <button type="submit" class="btn btn-primary">提交</button>
</form>
  </div>
	<br>
	<?php
if(!empty($_POST["post"])){
$mcapiurl="https://api.mojang.com/users/profiles/minecraft/".$_POST["post"];
$mcjson= file_get_contents($mcapiurl);
$djson=json_decode($mcjson);
$id=($djson->id);
$kedamaurl=("https://stats.craft.moe/static/data/$id/stats.json");
$kedamajson= file_get_contents($kedamaurl);
$dkjson=json_decode($kedamajson,true);}?>
    <div class="container">
  <p></p>
  <div id="accordion">
    <div class="card">
      <div class="card-header">
        <a class="card-link" data-toggle="collapse" href="#collapseOne">
          玩家信息
        </a>
      </div>
      <div id="collapseOne" class="collapse show" data-parent="#accordion">
        <div class="card-body">
         <table class="table-striped table-bordered" width="100%">
<tr><td><?php echo '玩家名:'.json_decode(json_encode($dkjson['data']['playername']));?></td></tr>
<tr><td><?php echo 'UUID:'.json_decode(json_encode($dkjson['data']['uuid'])); ?> </td></tr>
<tr><td><?php echo '是否被ban:'.json_decode(json_encode($dkjson['data']['ban'])); ?> </td></tr>
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
          <table class="table-striped table-bordered" width="100%">
<tr><td><?php echo '河豚:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:pufferfish']); ?> </td></tr>
<tr><td><?php echo '骷髅:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:skeleton']); ?> </td></tr>
<tr><td><?php echo '卫道士:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:vindicator']); ?> </td></tr>
<tr><td><?php echo '闹鬼:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:vex']); ?> </td></tr>
<tr><td><?php echo '流髑:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:stray']); ?> </td></tr>
<tr><td><?php echo '史莱姆:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:slime']); ?> </td></tr>
<tr><td><?php echo '爬行者:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:creeper']); ?> </td></tr>
<tr><td><?php echo '末影螨:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:endermite']); ?> </td></tr>
<tr><td><?php echo '玩家:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:player']); ?> </td></tr>
<tr><td><?php echo '末影人:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:enderman']); ?> </td></tr>
<tr><td><?php echo '幻翼:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:phantom']); ?> </td></tr>
	</table>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
          捡起物品次数
        </a>
      </div>
      <div id="collapseThree" class="collapse" data-parent="#accordion">
        <div class="card-body">
          <table class="table-striped table-bordered" width="100%">
<tr><td><?php echo '栓绳:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:lead']); ?> </td></tr>
<tr><td><?php echo '石头半砖:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stone_slab']); ?> </td></tr>
<tr><td><?php echo '附魔书:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:enchanted_book']); ?> </td></tr>
<tr><td><?php echo '唱片_cat:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:music_disc_cat']); ?> </td></tr>
<tr><td><?php echo '线:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:string']); ?> </td></tr>
<tr><td><?php echo '河豚:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:pufferfish']); ?> </td></tr>
<tr><td><?php echo '失活的气泡珊瑚扇:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dead_bubble_coral_fan']); ?> </td></tr>
<tr><td><?php echo '角珊瑚方块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:horn_coral_block']); ?> </td></tr>
<tr><td><?php echo '钻石矿:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:diamond_ore']); ?> </td></tr>
<tr><td><?php echo '云杉木压力板:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:spruce_pressure_plate']); ?> </td></tr>
<tr><td><?php echo '唱片机:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:jukebox']); ?> </td></tr>
<tr><td><?php echo '金质压力板:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:golden_chestplate']); ?> </td></tr>
<tr><td><?php echo '炼药锅:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cauldron']); ?> </td></tr>
<tr><td><?php echo '橙色床:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:orange_bed']); ?> </td></tr>
<tr><td><?php echo '石剑:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stone_sword']); ?> </td></tr>
<tr><td><?php echo '鹿角珊瑚扇:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:horn_coral_fan']); ?> </td></tr>
<tr><td><?php echo '红色郁金香:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:red_tulip']); ?> </td></tr>
<tr><td><?php echo '雕刻过的南瓜:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:carved_pumpkin']); ?> </td></tr>
<tr><td><?php echo '末地烛:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:end_rod']); ?> </td></tr>
<tr><td><?php echo '红色郁金香:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:red_tulip']); ?> </td></tr>
<tr><td><?php echo '萤石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:glowstone']); ?> </td></tr>
<tr><td><?php echo '书架:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:bookshelf']); ?> </td></tr>
<tr><td><?php echo '白色陶瓦:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:white_terracotta']); ?> </td></tr>
<tr><td><?php echo '烈焰棒:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:blaze_rod']); ?> </td></tr>
<tr><td><?php echo '铁栏杆:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:iron_bars']); ?> </td></tr>
<tr><td><?php echo '雪球:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:snowball']); ?> </td></tr>
<tr><td><?php echo '海绵:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:sponge']); ?> </td></tr>
<tr><td><?php echo '烤牛排:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cooked_beef']); ?> </td></tr>
<tr><td><?php echo '羽毛:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:feather']); ?> </td></tr>
<tr><td><?php echo '水桶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:water_bucket']); ?> </td></tr>
<tr><td><?php echo '燧石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:flint']); ?> </td></tr>
<tr><td><?php echo '兔纸肉:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:rabbit']); ?> </td></tr>
<tr><td><?php echo '去皮云杉原木:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stripped_spruce_log']); ?> </td></tr>
<tr><td><?php echo '棕色蘑菇方块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:brown_mushroom_block']); ?> </td></tr>
<tr><td><?php echo '失活的火珊瑚扇:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dead_fire_coral_fan']); ?> </td></tr>
<tr><td><?php echo '铁锄头:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:iron_hoe']); ?> </td></tr>
<tr><td><?php echo '蓝色陶瓦:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:blue_terracotta']); ?> </td></tr>
<tr><td><?php echo '拉杆:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:lever']); ?> </td></tr>
<tr><td><?php echo '花岗岩:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:granite']); ?> </td></tr>
<tr><td><?php echo '金马铠:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:golden_horse_armor']); ?> </td></tr>
<tr><td><?php echo '南瓜灯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:jack_o_lantern']); ?> </td></tr>
<tr><td><?php echo '浅灰色地毯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:light_gray_carpet']); ?> </td></tr>
<tr><td><?php echo '钻石稿:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:diamond_pickaxe']); ?> </td></tr>
<tr><td><?php echo '品红色带釉陶瓦:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:magenta_glazed_terracotta']); ?> </td></tr>
<tr><td><?php echo '黏土球:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:clay_ball']); ?> </td></tr>
<tr><td><?php echo '皮革护腿:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:leather_leggings']); ?> </td></tr>
<tr><td><?php echo '红石灯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:redstone_lamp']); ?> </td></tr>
<tr><td><?php echo '龙首:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dragon_head']); ?> </td></tr>
<tr><td><?php echo '紫珀块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:purpur_block']); ?> </td></tr>
<tr><td><?php echo '鞘翅:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:elytra']); ?> </td></tr>
<tr><td><?php echo '打火石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:flint_and_steel']); ?> </td></tr>
<tr><td><?php echo '白色地毯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:white_carpet']); ?> </td></tr>
<tr><td><?php echo '白色玻璃:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:white_stained_glass']); ?> </td></tr>
<tr><td><?php echo '铁铲子:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:iron_shovel']); ?> </td></tr>
<tr><td><?php echo '玻璃板:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:glass_pane']); ?> </td></tr>
<tr><td><?php echo '丛林树苗:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:jungle_sapling']); ?> </td></tr>
<tr><td><?php echo '虞美人:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:poppy']); ?> </td></tr>
<tr><td><?php echo '云杉半砖:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:spruce_slab']); ?> </td></tr>
<tr><td><?php echo '矿车:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:minecart']); ?> </td></tr>
<tr><td><?php echo '白桦树苗:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:birch_sapling']); ?> </td></tr>
<tr><td><?php echo '活塞:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:piston']); ?> </td></tr>
<tr><td><?php echo '钻石锄:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:diamond_hoe']); ?> </td></tr>
<tr><td><?php echo '黄绿色潜影盒:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:lime_shulker_box']); ?> </td></tr>
<tr><td><?php echo '石头:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stone']); ?> </td></tr>
<tr><td><?php echo '蒲公英黄:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dandelion_yellow']); ?> </td></tr>
<tr><td><?php echo '唱片_mellohi:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:music_disc_mellohi']); ?> </td></tr>
<tr><td><?php echo '钻石胸甲:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:diamond_chestplate']); ?> </td></tr>
<tr><td><?php echo '紫珀块台阶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:purpur_slab']); ?> </td></tr>
<tr><td><?php echo '干草块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:hay_block']); ?> </td></tr>
<tr><td><?php echo '黄色陶瓦:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:yellow_terracotta']); ?> </td></tr>
<tr><td><?php echo '不死图腾:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:totem_of_undying']); ?> </td></tr>
<tr><td><?php echo '生羊肉:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:mutton']); ?> </td></tr>
<tr><td><?php echo '铁轨:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:rail']); ?> </td></tr>
<tr><td><?php echo '骨块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:bone_block']); ?> </td></tr>
<tr><td><?php echo '滨菊:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:oxeye_daisy']); ?> </td></tr>
<tr><td><?php echo '黄色潜影盒:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:yellow_shulker_box']); ?> </td></tr>
<tr><td><?php echo '白桦树叶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:birch_leaves']); ?> </td></tr>
<tr><td><?php echo '拌线钩:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:tripwire_hook']); ?> </td></tr>
<tr><td><?php echo '丛林木栅栏:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:jungle_fence']); ?> </td></tr>
<tr><td><?php echo '紫柏块楼梯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:purpur_stairs']); ?> </td></tr>
<tr><td><?php echo '睡莲:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:lily_pad']); ?> </td></tr>
<tr><td><?php echo '纸:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:paper']); ?> </td></tr>
<tr><td><?php echo '苹果:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:apple']); ?> </td></tr>
<tr><td><?php echo '河豚桶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:pufferfish_bucket']); ?> </td></tr>
<tr><td><?php echo '橡木活板门:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:oak_fence_gate']); ?> </td></tr>
<tr><td><?php echo '石稿:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stone_pickaxe']); ?> </td></tr>
<tr><td><?php echo '铁矿石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:iron_ore']); ?> </td></tr>
<tr><td><?php echo '品红色玻璃:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:magenta_stained_glass']); ?> </td></tr>
<tr><td><?php echo '深色橡木楼梯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dark_oak_stairs']); ?> </td></tr>
<tr><td><?php echo '牛奶桶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:milk_bucket']); ?> </td></tr>
<tr><td><?php echo '亮灰色玻璃:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:light_gray_stained_glass']); ?> </td></tr>
<tr><td><?php echo '龙蛋:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dragon_egg']); ?> </td></tr>
<tr><td><?php echo '皮革帽子:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:leather_helmet']); ?> </td></tr>
<tr><td><?php echo '钻石铲子:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:diamond_shovel']); ?> </td></tr>
<tr><td><?php echo '煤矿石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:coal_ore']); ?> </td></tr>
<tr><td><?php echo '史莱姆球:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:slime_ball']); ?> </td></tr>
<tr><td><?php echo '画:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:painting']); ?> </td></tr>
<tr><td><?php echo '烤马铃薯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:baked_potato']); ?> </td></tr>
<tr><td><?php echo '漏斗:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:hopper']); ?> </td></tr>
<tr><td><?php echo '末影箱:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:ender_chest']); ?> </td></tr>
<tr><td><?php echo '地狱砖栅栏:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:nether_brick_fence']); ?> </td></tr>
<tr><td><?php echo '黄色羊毛:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:yellow_wool']); ?> </td></tr>
<tr><td><?php echo '石砖楼梯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stone_brick_stairs']); ?> </td></tr>
<tr><td><?php echo '青金石块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:lapis_block']); ?> </td></tr>
<tr><td><?php echo '失活的管珊瑚块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dead_tube_coral_block']); ?> </td></tr>
<tr><td><?php echo '经验瓶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:experience_bottle']); ?> </td></tr>
<tr><td><?php echo '红沙:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:red_sand']); ?> </td></tr>
<tr><td><?php echo '桶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:bucket']); ?> </td></tr>
<tr><td><?php echo '红石比较器:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:comparator']); ?> </td></tr>
<tr><td><?php echo '玫瑰丛:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:rose_bush']); ?> </td></tr>
<tr><td><?php echo '圆石台阶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cobblestone_slab']); ?> </td></tr>
<tr><td><?php echo '末影之眼:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:ender_eye']); ?> </td></tr>
<tr><td><?php echo '铁镐:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:iron_pickaxe']); ?> </td></tr>
<tr><td><?php echo '药箭:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:tipped_arrow']); ?> </td></tr>
<tr><td><?php echo '金合欢木栅栏:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:acacia_fence']); ?> </td></tr>
<tr><td><?php echo '白桦木活板门:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:birch_trapdoor']); ?> </td></tr>
<tr><td><?php echo '云杉木楼梯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:spruce_stairs']); ?> </td></tr>
<tr><td><?php echo '闪长岩:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:diorite']); ?> </td></tr>
<tr><td><?php echo '藤蔓:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:vine']); ?> </td></tr>
<tr><td><?php echo '腐肉:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:rotten_flesh']); ?> </td></tr>
<tr><td><?php echo '紫颂花:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:chorus_flower']); ?> </td></tr>
<tr><td><?php echo '唱片_wait:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:music_disc_wait']); ?> </td></tr>
<tr><td><?php echo '黑曜石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:obsidian']); ?> </td></tr>
<tr><td><?php echo '烈焰粉:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:blaze_powder']); ?> </td></tr>
<tr><td><?php echo '圆石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cobblestone']); ?> </td></tr>
<tr><td><?php echo '附魔台:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:enchanting_table']); ?> </td></tr>
<tr><td><?php echo '皮革胸甲:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:leather_chestplate']); ?> </td></tr>
<tr><td><?php echo '丁香:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:lilac']); ?> </td></tr>
<tr><td><?php echo '红石中继器:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:repeater']); ?> </td></tr>
<tr><td><?php echo '失活的管珊瑚扇:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dead_tube_coral_fan']); ?> </td></tr>
<tr><td><?php echo '安山岩:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:andesite']); ?> </td></tr>
<tr><td><?php echo '橙色地毯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:orange_carpet']); ?> </td></tr>
<tr><td><?php echo '金护腿:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:golden_leggings']); ?> </td></tr>
<tr><td><?php echo '信标:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:beacon']); ?> </td></tr>
<tr><td><?php echo '马铃薯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:potato']); ?> </td></tr>
<tr><td><?php echo '海晶石砖:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:prismarine_bricks']); ?> </td></tr>
<tr><td><?php echo '泥土:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dirt']); ?> </td></tr>
<tr><td><?php echo '去皮白桦木:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stripped_birch_log']); ?> </td></tr>
<tr><td><?php echo '命名牌:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:name_tag']); ?> </td></tr>
<tr><td><?php echo '牌子:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:sign']); ?> </td></tr>
<tr><td><?php echo '玻璃:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:glass']); ?> </td></tr>
<tr><td><?php echo '骨头:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:bone']); ?> </td></tr>
<tr><td><?php echo '弓:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:bow']); ?> </td></tr>
<tr><td><?php echo '小麦种子:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:wheat_seeds']); ?> </td></tr>
<tr><td><?php echo '橙色郁金香:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:orange_tulip']); ?> </td></tr>
<tr><td><?php echo '爆裂紫颂果:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:popped_chorus_fruit']); ?> </td></tr>
<tr><td><?php echo '苔石砖:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:mossy_stone_bricks']); ?> </td></tr>
<tr><td><?php echo '海晶石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:prismarine']); ?> </td></tr>
<tr><td><?php echo '淡蓝色潜影盒:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:light_blue_shulker_box']); ?> </td></tr>
<tr><td><?php echo '西瓜:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:melon']); ?> </td></tr>
<tr><td><?php echo '草方块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:grass_block']); ?> </td></tr>
<tr><td><?php echo '光灵箭:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:spectral_arrow']); ?> </td></tr>
<tr><td><?php echo '苔石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:mossy_cobblestone']); ?> </td></tr>
<tr><td><?php echo '丛林树叶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:jungle_leaves']); ?> </td></tr>
<tr><td><?php echo '黄色地毯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:yellow_carpet']); ?> </td></tr>
<tr><td><?php echo '粘液块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:slime_block']); ?> </td></tr>
<tr><td><?php echo '骨粉:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:bone_meal']); ?> </td></tr>
<tr><td><?php echo '草丛:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:grass']); ?> </td></tr>
<tr><td><?php echo '金苹果:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:golden_apple']); ?> </td></tr>
<tr><td><?php echo '绿宝石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:emerald']); ?> </td></tr>
<tr><td><?php echo '地狱岩:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:netherrack']); ?> </td></tr>
<tr><td><?php echo '紫颂果:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:chorus_fruit']); ?> </td></tr>
<tr><td><?php echo '橡树树叶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:oak_leaves']); ?> </td></tr>
<tr><td><?php echo '海豚刷怪蛋:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dolphin_spawn_egg']); ?> </td></tr>
<tr><td><?php echo '梯子:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:ladder']); ?> </td></tr>
<tr><td><?php echo '棕色蘑菇:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:brown_mushroom']); ?> </td></tr>
<tr><td><?php echo '浮冰:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:packed_ice']); ?> </td></tr>
<tr><td><?php echo '粉红色羊毛:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:pink_wool']); ?> </td></tr>
<tr><td><?php echo '盾牌:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:']); ?> </td></tr>
<tr><td><?php echo '红砖:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:brick']); ?> </td></tr>
<tr><td><?php echo '橡木活板门:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:oak_trapdoor']); ?> </td></tr>
<tr><td><?php echo '菌丝:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:mycelium']); ?> </td></tr>
<tr><td><?php echo '白桦木栅栏:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:birch_fence']); ?> </td></tr>
<tr><td><?php echo '兰花:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:blue_orchid']); ?> </td></tr>
<tr><td><?php echo '末地石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:end_stone']); ?> </td></tr>
<tr><td><?php echo '音符盒:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:note_block']); ?> </td></tr>
<tr><td><?php echo '曲奇:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cookie']); ?> </td></tr>
<tr><td><?php echo '唱片_11:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:music_disc_11']); ?> </td></tr>
<tr><td><?php echo '三叉戟:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:trident']); ?> </td></tr>
<tr><td><?php echo '淡灰色玻璃板:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:light_gray_stained_glass_pane']); ?> </td></tr>
<tr><td><?php echo '石质压力板:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stone_pressure_plate']); ?> </td></tr>
<tr><td><?php echo '红色潜影盒:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:red_shulker_box']); ?> </td></tr>
<tr><td><?php echo '南瓜派:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:pumpkin_pie']); ?> </td></tr>
<tr><td><?php echo '地狱砖块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:nether_bricks']); ?> </td></tr>
<tr><td><?php echo '黑色旗帜:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:black_banner']); ?> </td></tr>
<tr><td><?php echo '砖块楼梯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:brick_stairs']); ?> </td></tr>
<tr><td><?php echo '骷髅头颅:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:skeleton_skull']); ?> </td></tr>
<tr><td><?php echo '丛林木船:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:jungle_boat']); ?> </td></tr>
<tr><td><?php echo '深色橡木按钮:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dark_oak_button']); ?> </td></tr>
<tr><td><?php echo '金胡萝卜:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:golden_carrot']); ?> </td></tr>
<tr><td><?php echo '皮革:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:leather']); ?> </td></tr>
<tr><td><?php echo '唱片_stal:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:music_disc_stal']); ?> </td></tr>
<tr><td><?php echo '冰:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:ice']); ?> </td></tr>
<tr><td><?php echo '锁链胸甲:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:chainmail_chestplate']); ?> </td></tr>
<tr><td><?php echo '黄色床:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:yellow_bed']); ?> </td></tr>
<tr><td><?php echo '圆石墙:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cobblestone_wall']); ?> </td></tr>
<tr><td><?php echo '火药:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:gunpowder']); ?> </td></tr>
<tr><td><?php echo '熟羊肉:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cooked_mutton']); ?> </td></tr>
<tr><td><?php echo '红色地毯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:red_carpet']); ?> </td></tr>
<tr><td><?php echo '灰色地毯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:gray_carpet']); ?> </td></tr>
<tr><td><?php echo '兔子皮:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:rabbit_hide']); ?> </td></tr>
<tr><td><?php echo '铁锭:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:iron_ingot']); ?> </td></tr>
<tr><td><?php echo '熟鸡肉:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cooked_chicken']); ?> </td></tr>
<tr><td><?php echo '下界石英矿石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:nether_quartz_ore']); ?> </td></tr>
<tr><td><?php echo '石砖台阶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stone_brick_slab']); ?> </td></tr>
<tr><td><?php echo '下界石英:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:quartz']); ?> </td></tr>
<tr><td><?php echo '蒲公英:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dandelion']); ?> </td></tr>
<tr><td><?php echo '岩浆桶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:lava_bucket']); ?> </td></tr>
<tr><td><?php echo '红色旗帜:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:red_banner']); ?> </td></tr>
<tr><td><?php echo '云杉木门:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:spruce_door']); ?> </td></tr>
<tr><td><?php echo '南瓜种子:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:pumpkin_seeds']); ?> </td></tr>
<tr><td><?php echo '白色混凝土粉末:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:white_concrete_powder']); ?> </td></tr>
<tr><td><?php echo '锁链护腿:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:chainmail_leggings']); ?> </td></tr>
<tr><td><?php echo '陶瓦:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:terracotta']); ?> </td></tr>
<tr><td><?php echo '损坏的铁砧:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:damaged_anvil']); ?> </td></tr>
<tr><td><?php echo '向日葵:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:sunflower']); ?> </td></tr>
<tr><td><?php echo '木斧:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:wooden_axe']); ?> </td></tr>
<tr><td><?php echo '海草:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:seagrass']); ?> </td></tr>
<tr><td><?php echo '白桦木门:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:birch_door']); ?> </td></tr>
<tr><td><?php echo '锁链鞋子:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:chainmail_boots']); ?> </td></tr>
<tr><td><?php echo '花盆:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:flower_pot']); ?> </td></tr>
<tr><td><?php echo '爬行者的头:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:creeper_head']); ?> </td></tr>
<tr><td><?php echo '铁砧:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:anvil']); ?> </td></tr>
<tr><td><?php echo '海晶碎片:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:prismarine_shard']); ?> </td></tr>
<tr><td><?php echo '钻石剑:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:diamond_sword']); ?> </td></tr>
<tr><td><?php echo '橡木楼梯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:oak_stairs']); ?> </td></tr>
<tr><td><?php echo '白桦木按钮:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:birch_button']); ?> </td></tr>
<tr><td><?php echo '酿造台:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:brewing_stand']); ?> </td></tr>
<tr><td><?php echo '金剑:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:golden_sword']); ?> </td></tr>
<tr><td><?php echo '深色橡木活板门:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dark_oak_trapdoor']); ?> </td></tr>
<tr><td><?php echo '红色地狱砖块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:red_nether_bricks']); ?> </td></tr>
<tr><td><?php echo '甜菜:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:beetroot']); ?> </td></tr>
<tr><td><?php echo '金粒:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:gold_nugget']); ?> </td></tr>
<tr><td><?php echo '云杉木板:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:spruce_planks']); ?> </td></tr>
<tr><td><?php echo '成书:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:written_book']); ?> </td></tr>
<tr><td><?php echo '附魔金苹果:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:enchanted_golden_apple']); ?> </td></tr>
<tr><td><?php echo '西瓜片:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:melon_slice']); ?> </td></tr>
<tr><td><?php echo '煤块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:coal_block']); ?> </td></tr>
<tr><td><?php echo '深色橡木门:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dark_oak_door']); ?> </td></tr>
<tr><td><?php echo '金头盔:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:golden_helmet']); ?> </td></tr>
<tr><td><?php echo '唱片_blocks:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:music_disc_blocks']); ?> </td></tr>
<tr><td><?php echo '兔纸脚:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:rabbit_foot']); ?> </td></tr>
<tr><td><?php echo '淡蓝色羊毛:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:light_blue_wool']); ?> </td></tr>
<tr><td><?php echo '热带鱼:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:tropical_fish']); ?> </td></tr>
<tr><td><?php echo '铁块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:iron_block']); ?> </td></tr>
<tr><td><?php echo '白桦原木:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:birch_log']); ?> </td></tr>
<tr><td><?php echo '岩浆块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:magma_block']); ?> </td></tr>
<tr><td><?php echo '白桦木台阶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:birch_slab']); ?> </td></tr>
<tr><td><?php echo '铁门:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:iron_door']); ?> </td></tr>
<tr><td><?php echo '丛林原木:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:jungle_log']); ?> </td></tr>
<tr><td><?php echo '金合欢树叶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:acacia_leaves']); ?> </td></tr>
<tr><td><?php echo '地图:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:map']); ?> </td></tr>
<tr><td><?php echo '开裂的铁砧:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:chipped_anvil']); ?> </td></tr>
<tr><td><?php echo '灰色陶瓦:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:gray_terracotta']); ?> </td></tr>
<tr><td><?php echo '萤石粉:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:glowstone_dust']); ?> </td></tr>
<tr><td><?php echo '投掷器:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dropper']); ?> </td></tr>
<tr><td><?php echo '墨囊:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:ink_sac']); ?> </td></tr>
<tr><td><?php echo '陷阱箱:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:trapped_chest']); ?> </td></tr>
<tr><td><?php echo '深色橡木原木:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dark_oak_log']); ?> </td></tr>
<tr><td><?php echo '发射器:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dispenser']); ?> </td></tr>
<tr><td><?php echo '书与笔:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:writable_book']); ?> </td></tr>
<tr><td><?php echo '蓝冰:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:blue_ice']); ?> </td></tr>
<tr><td><?php echo '面板:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:bread']); ?> </td></tr>
<tr><td><?php echo '深色橡木栅栏:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dark_oak_fence']); ?> </td></tr>
<tr><td><?php echo '砖块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:bricks']); ?> </td></tr>
<tr><td><?php echo '云杉树叶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:spruce_leaves']); ?> </td></tr>
<tr><td><?php echo '工作台:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:crafting_table']); ?> </td></tr>
<tr><td><?php echo '气泡珊瑚扇:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:bubble_coral_fan']); ?> </td></tr>
<tr><td><?php echo '地狱疣:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:nether_wart']); ?> </td></tr>
<tr><td><?php echo '潮涌核心:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:conduit']); ?> </td></tr>
<tr><td><?php echo '失活的鹿角珊瑚块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dead_horn_coral_block']); ?> </td></tr>
<tr><td><?php echo '裂石砖:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cracked_stone_bricks']); ?> </td></tr>
<tr><td><?php echo '生牛肉:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:beef']); ?> </td></tr>
<tr><td><?php echo '石英楼梯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:quartz_stairs']); ?> </td></tr>
<tr><td><?php echo '箱子:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:chest']); ?> </td></tr>
<tr><td><?php echo '鸡蛋:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:egg']); ?> </td></tr>
<tr><td><?php echo '砂岩:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:sandstone']); ?> </td></tr>
<tr><td><?php echo '橡木门:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:oak_door']); ?> </td></tr>
<tr><td><?php echo '云杉木栅栏:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:spruce_fence']); ?> </td></tr>
<tr><td><?php echo '胡萝卜:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:carrot']); ?> </td></tr>
<tr><td><?php echo '红石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:redstone']); ?> </td></tr>
<tr><td><?php echo '蘑菇柄:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:mushroom_stem']); ?> </td></tr>
<tr><td><?php echo '海晶砂粒:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:prismarine_crystals']); ?> </td></tr>
<tr><td><?php echo 'TNT:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:tnt']); ?> </td></tr>
<tr><td><?php echo '熟鳕鱼:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cooked_cod']); ?> </td></tr>
<tr><td><?php echo '甜菜种子:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:beetroot_seeds']); ?> </td></tr>
<tr><td><?php echo '牡丹:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:peony']); ?> </td></tr>
<tr><td><?php echo '管珊瑚扇:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:tube_coral_fan']); ?> </td></tr>
<tr><td><?php echo '剪刀:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:shears']); ?> </td></tr>
<tr><td><?php echo '钻石靴子:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:diamond_boots']); ?> </td></tr>
<tr><td><?php echo '管珊瑚块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:tube_coral_block']); ?> </td></tr>
<tr><td><?php echo '金锭:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:gold_ingot']); ?> </td></tr>
<tr><td><?php echo '白色潜影盒:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:white_shulker_box']); ?> </td></tr>
<tr><td><?php echo '白色羊毛:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:white_wool']); ?> </td></tr>
<tr><td><?php echo '青金石矿石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:lapis_ore']); ?> </td></tr>
<tr><td><?php echo '去皮橡木原木:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stripped_oak_log']); ?> </td></tr>
<tr><td><?php echo '红色蘑菇方块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:red_mushroom_block']); ?> </td></tr>
<tr><td><?php echo '红色蘑菇:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:red_mushroom']); ?> </td></tr>
<tr><td><?php echo '地图或探险家地图:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:filled_map']); ?> </td></tr>
<tr><td><?php echo '橡木原木:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:oak_log']); ?> </td></tr>
<tr><td><?php echo '金靴子:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:golden_boots']); ?> </td></tr>
<tr><td><?php echo '白色旗帜:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:white_banner']); ?> </td></tr>
<tr><td><?php echo '白桦木压力板:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:birch_pressure_plate']); ?> </td></tr>
<tr><td><?php echo '石砖:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stone_bricks']); ?> </td></tr>
<tr><td><?php echo '海带:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:kelp']); ?> </td></tr>
<tr><td><?php echo '唱片_far:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:music_disc_far']); ?> </td></tr>
<tr><td><?php echo '玻璃瓶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:glass_bottle']); ?> </td></tr>
<tr><td><?php echo '铁剑:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:iron_sword']); ?> </td></tr>
<tr><td><?php echo '深色橡木台阶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dark_oak_slab']); ?> </td></tr>
<tr><td><?php echo '阳光探测器:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:daylight_detector']); ?> </td></tr>
<tr><td><?php echo '沙砾:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:gravel']); ?> </td></tr>
<tr><td><?php echo '白桦木楼梯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:birch_stairs']); ?> </td></tr>
<tr><td><?php echo '云杉树苗:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:spruce_sapling']); ?> </td></tr>
<tr><td><?php echo '云杉原木:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:spruce_log']); ?> </td></tr>
<tr><td><?php echo '海晶灯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:sea_lantern']); ?> </td></tr>
<tr><td><?php echo '烟花火箭:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:firework_rocket']); ?> </td></tr>
<tr><td><?php echo '石斧:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stone_axe']); ?> </td></tr>
<tr><td><?php echo '红石矿石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:redstone_ore']); ?> </td></tr>
<tr><td><?php echo '钻石斧:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:diamond_axe']); ?> </td></tr>
<tr><td><?php echo '灰色羊毛:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:gray_wool']); ?> </td></tr>
<tr><td><?php echo '橡木按钮:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:oak_button']); ?> </td></tr>
<tr><td><?php echo '去皮深色橡木原木:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stripped_dark_oak_log']); ?> </td></tr>
<tr><td><?php echo '粉红色染料:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:pink_dye']); ?> </td></tr>
<tr><td><?php echo '末影珍珠:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:ender_pearl']); ?> </td></tr>
<tr><td><?php echo '潜影壳:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:shulker_shell']); ?> </td></tr>
<tr><td><?php echo '唱片_strad:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:music_disc_strad']); ?> </td></tr>
<tr><td><?php echo '小麦:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:wheat']); ?> </td></tr>
<tr><td><?php echo '红石块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:redstone_block']); ?> </td></tr>
<tr><td><?php echo '铁活板门:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:iron_trapdoor']); ?> </td></tr>
<tr><td><?php echo '淡灰色潜影盒:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:light_gray_shulker_box']); ?> </td></tr>
<tr><td><?php echo '失活的鹿角珊瑚扇:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dead_horn_coral_fan']); ?> </td></tr>
<tr><td><?php echo '海龟蛋:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:turtle_egg']); ?> </td></tr>
<tr><td><?php echo '药水:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:potion']); ?> </td></tr>
<tr><td><?php echo '脑纹珊瑚块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:brain_coral_block']); ?> </td></tr>
<tr><td><?php echo '地狱砖块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:nether_brick']); ?> </td></tr>
<tr><td><?php echo '铁护腿:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:iron_leggings']); ?> </td></tr>
<tr><td><?php echo '盔甲架:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:armor_stand']); ?> </td></tr>
<tr><td><?php echo '粘性活塞:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:sticky_piston']); ?> </td></tr>
<tr><td><?php echo '僵尸头颅:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:zombie_head']); ?> </td></tr>
<tr><td><?php echo '粉色潜影盒:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:pink_shulker_box']); ?> </td></tr>
<tr><td><?php echo '海泡菜:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:sea_pickle']); ?> </td></tr>
<tr><td><?php echo '激活铁轨:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:activator_rail']); ?> </td></tr>
<tr><td><?php echo '深色橡木树叶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dark_oak_leaves']); ?> </td></tr>
<tr><td><?php echo '红石火把:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:redstone_torch']); ?> </td></tr>
<tr><td><?php echo '铁靴子:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:iron_boots']); ?> </td></tr>
<tr><td><?php echo '熔炉:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:furnace']); ?> </td></tr>
<tr><td><?php echo '木棒:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stick']); ?> </td></tr>
<tr><td><?php echo '橙色潜影盒:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:orange_shulker_box']); ?> </td></tr>
<tr><td><?php echo '橡木栅栏:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:oak_fence']); ?> </td></tr>
<tr><td><?php echo '火把:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:torch']); ?> </td></tr>
<tr><td><?php echo '生猪排:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:porkchop']); ?> </td></tr>
<tr><td><?php echo '雪块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:snow_block']); ?> </td></tr>
<tr><td><?php echo '干海带:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dried_kelp']); ?> </td></tr>
<tr><td><?php echo '石英块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:quartz_block']); ?> </td></tr>
<tr><td><?php echo '仙人掌:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cactus']); ?> </td></tr>
<tr><td><?php echo '火珊瑚扇:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:fire_coral_fan']); ?> </td></tr>
<tr><td><?php echo '鳕鱼:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cod']); ?> </td></tr>
<tr><td><?php echo '鹦鹉螺壳:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:nautilus_shell']); ?> </td></tr>
<tr><td><?php echo '烈焰膏:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:magma_cream']); ?> </td></tr>
<tr><td><?php echo '绿色潜影盒:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:green_shulker_box']); ?> </td></tr>
<tr><td><?php echo '青金石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:lapis_lazuli']); ?> </td></tr>
<tr><td><?php echo '皮革靴子:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:leather_boots']); ?> </td></tr>
<tr><td><?php echo '粉色旗帜:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:pink_banner']); ?> </td></tr>
<tr><td><?php echo '动力铁轨:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:powered_rail']); ?> </td></tr>
<tr><td><?php echo '橡木木板:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:oak_planks']); ?> </td></tr>
<tr><td><?php echo '石锄:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stone_hoe']); ?> </td></tr>
<tr><td><?php echo '脑纹珊瑚:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:brain_coral']); ?> </td></tr>
<tr><td><?php echo '恶魂之泪:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:ghast_tear']); ?> </td></tr>
<tr><td><?php echo '粉色玻璃:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:pink_stained_glass']); ?> </td></tr>
<tr><td><?php echo '熟猪肉:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cooked_porkchop']); ?> </td></tr>
<tr><td><?php echo '唱片_13:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:music_disc_13']); ?> </td></tr>
<tr><td><?php echo '橡木压力板:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:oak_pressure_plate']); ?> </td></tr>
<tr><td><?php echo '毒马铃薯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:poisonous_potato']); ?> </td></tr>
<tr><td><?php echo '丛林木板:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:jungle_planks']); ?> </td></tr>
<tr><td><?php echo '沙子:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:sand']); ?> </td></tr>
<tr><td><?php echo '堑质砂岩:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:chiseled_sandstone']); ?> </td></tr>
<tr><td><?php echo '潜影盒:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:shulker_box']); ?> </td></tr>
<tr><td><?php echo '橙色羊毛:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:orange_wool']); ?> </td></tr>
<tr><td><?php echo '暗海晶石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dark_prismarine']); ?> </td></tr>
<tr><td><?php echo '粘土块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:clay']); ?> </td></tr>
<tr><td><?php echo '云杉木船:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:spruce_boat']); ?> </td></tr>
<tr><td><?php echo '钻石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:diamond']); ?> </td></tr>
<tr><td><?php echo '黑色混凝土:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:black_concrete']); ?> </td></tr>
<tr><td><?php echo '白色混凝土:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:white_concrete']); ?> </td></tr>
<tr><td><?php echo '橡树树苗:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:oak_sapling']); ?> </td></tr>
<tr><td><?php echo '下界之星:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:nether_star']); ?> </td></tr>
<tr><td><?php echo '末地石砖:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:end_stone_bricks']); ?> </td></tr>
<tr><td><?php echo '滞留药水:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:lingering_potion']); ?> </td></tr>
<tr><td><?php echo '钓鱼竿:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:fishing_rod']); ?> </td></tr>
<tr><td><?php echo '可可豆:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cocoa_beans']); ?> </td></tr>
<tr><td><?php echo '木炭:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:charcoal']); ?> </td></tr>
<tr><td><?php echo '绒球葱:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:allium']); ?> </td></tr>
<tr><td><?php echo '生鸡肉:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:chicken']); ?> </td></tr>
<tr><td><?php echo '海龟壳:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:turtle_helmet']); ?> </td></tr>
<tr><td><?php echo '木稿:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:wooden_pickaxe']); ?> </td></tr>
<tr><td><?php echo '熟兔肉:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cooked_rabbit']); ?> </td></tr>
<tr><td><?php echo '金块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:gold_block']); ?> </td></tr>
<tr><td><?php echo '钻石马铠:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:diamond_horse_armor']); ?> </td></tr>
<tr><td><?php echo '龙息:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dragon_breath']); ?> </td></tr>
<tr><td><?php echo '铁斧:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:iron_axe']); ?> </td></tr>
<tr><td><?php echo '木剑:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:wooden_sword']); ?> </td></tr>
<tr><td><?php echo '物品展示框:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:item_frame']); ?> </td></tr>
<tr><td><?php echo '探测铁轨:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:detector_rail']); ?> </td></tr>
<tr><td><?php echo '橡木船:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:oak_boat']); ?> </td></tr>
<tr><td><?php echo '玩家头颅:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:player_head']); ?> </td></tr>
<tr><td><?php echo '侦测器:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:observer']); ?> </td></tr>
<tr><td><?php echo '淡灰色羊毛:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:light_gray_wool']); ?> </td></tr>
<tr><td><?php echo '蓝色潜影盒:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:blue_shulker_box']); ?> </td></tr>
<tr><td><?php echo '甘蔗:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:sugar_cane']); ?> </td></tr>
<tr><td><?php echo '云杉木活板门:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:spruce_trapdoor']); ?> </td></tr>
<tr><td><?php echo '幻翼膜:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:phantom_membrane']); ?> </td></tr>
<tr><td><?php echo '深色橡木树苗:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dark_oak_sapling']); ?> </td></tr>
<tr><td><?php echo '碗:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:bowl']); ?> </td></tr>
<tr><td><?php echo '石质按钮:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stone_button']); ?> </td></tr>
<tr><td><?php echo '品红色潜影盒:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:magenta_shulker_box']); ?> </td></tr>
<tr><td><?php echo '深色橡木木板:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dark_oak_planks']); ?> </td></tr>
<tr><td><?php echo '箭:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:arrow']); ?> </td></tr>
<tr><td><?php echo '淡蓝色玻璃板:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:light_blue_stained_glass_pane']); ?> </td></tr>
<tr><td><?php echo '丛林木楼梯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:jungle_stairs']); ?> </td></tr>
<tr><td><?php echo '鞍:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:saddle']); ?> </td></tr>
<tr><td><?php echo '湿海绵:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:wet_sponge']); ?> </td></tr>
<tr><td><?php echo '鲑鱼:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:salmon']); ?> </td></tr>
<tr><td><?php echo '切制砂岩:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cut_sandstone']); ?> </td></tr>
<tr><td><?php echo '白桦木板:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:birch_planks']); ?> </td></tr>
<tr><td><?php echo '蘑菇煲:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:mushroom_stew']); ?> </td></tr>
<tr><td><?php echo '圆石楼梯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cobblestone_stairs']); ?> </td></tr>
<tr><td><?php echo '木锄:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:wooden_hoe']); ?> </td></tr>
<tr><td><?php echo '火珊瑚块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:fire_coral_block']); ?> </td></tr>
<tr><td><?php echo '海洋之心:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:heart_of_the_sea']); ?> </td></tr>
<tr><td><?php echo '灵魂沙:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:soul_sand']); ?> </td></tr>
<tr><td><?php echo '唱片_chirp:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:music_disc_chirp']); ?> </td></tr>
<tr><td><?php echo '书:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:book']); ?> </td></tr>
<tr><td><?php echo '橡木台阶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:oak_slab']); ?> </td></tr>
<tr><td><?php echo '南瓜:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:pumpkin']); ?> </td></tr>
<tr><td><?php echo '白桦木船:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:birch_boat']); ?> </td></tr>
<tr><td><?php echo '墙上的管珊瑚扇:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:brain_coral_fan']); ?> </td></tr>
<tr><td><?php echo '白色床:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:white_bed']); ?> </td></tr>
<tr><td><?php echo '金矿石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:gold_ore']); ?> </td></tr>
<tr><td><?php echo '蜘蛛眼:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:spider_eye']); ?> </td></tr>
<tr><td><?php echo '唱片_mall:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:music_disc_mall']); ?> </td></tr>
<tr><td><?php echo '干海带块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dried_kelp_block']); ?> </td></tr>
<tr><td><?php echo '铁头盔:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:iron_helmet']); ?> </td></tr>
<tr><td><?php echo '去皮从林木:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stripped_jungle_wood']); ?> </td></tr>
<tr><td><?php echo '红色混凝土:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:red_concrete']); ?> </td></tr>
<tr><td><?php echo '煤炭:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:coal']); ?> </td></tr></table>
        </div>
      </div>
    </div>
  </div>
</div>

<footer>
	<br><br><br>
	<div class="container">
		<p>&copy;2017-2019 blingwang.cn All Rights Reserved.</p>
	</div>
	</footer>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>