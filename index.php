<!DOCTYPE HTML>
<html lang="zh">
	<head>
		<title>Kedama数据查询</title>
	 <meta name="Description" content="Kedama Stats Search">
 <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
  <form name="form1" method="post">
		<a>用户名:</a>
		<input type="text" name="post" size="20">
	<input name="submit" type="submit" id="submit" value="查询"/>
</form>
<?php
//echo $_POST["post"];
//if(!empty($_POST["post"])){
//$mcapiurl = json_decode(file_get_contents("https://api.mojang.com/users/profiles/minecraft/" . $_POST["post"]), true);
//echo "id=" . $mcapiurl["id"];
//echo "<br><br>用户名=" . $mcapiurl["name"];
//}
if(!empty($_POST["post"])){
$mcapiurl="https://api.mojang.com/users/profiles/minecraft/".$_POST["post"];
$mcjson= file_get_contents($mcapiurl);
$djson=json_decode($mcjson);
//var_dump($djson);
//echo('id='.$djson->id);
$id=($djson->id);
//echo $id;
//echo('<br><br>用户名='.$djson->name);
$kedamaurl=("https://stats.craft.moe/static/data/$id/stats.json");
//echo $kedamaurl;
$kedamajson= file_get_contents($kedamaurl);
//echo $kedamajson;
$dkjson=json_decode($kedamajson,true);
//var_dump($dkjson);
echo '玩家名:'.json_decode(json_encode($dkjson['data']['playername']));
echo '<br>UUID:'.json_decode(json_encode($dkjson['data']['uuid']));
echo '<br>是否被ban:'.json_decode(json_encode($dkjson['data']['ban']));
//echo '<table><td>';  
echo '<br><p>被杀死次数</p>';
echo '河豚:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:pufferfish']);
echo '<br>骷髅:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:skeleton']);
echo '<br>卫道士:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:vindicator']);
echo '<br>闹鬼:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:vex']);
echo '<br>流髑:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:stray']);
echo '<br>史莱姆:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:slime']);
echo '<br>爬行者:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:creeper']);
echo '<br>末影螨:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:endermite']);
echo '<br>玩家:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:player']);
echo '<br>末影人:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:enderman']);
echo '<br>幻翼:'.json_decode($dkjson['stats']['minecraft:killed_by/minecraft:phantom']);
//echo '</td><td>';
echo '<p>捡起物品次数</p>';
echo '<br>栓绳:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:lead']);
echo '<br>石头半砖:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stone_slab']);
echo '<br>附魔书:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:enchanted_book']);
echo '<br>唱片_Cat:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:music_disc_cat']);
echo '<br>线:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:string']);
echo '<br>河豚:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:pufferfish']);
echo '<br>失活的气泡珊瑚扇:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dead_bubble_coral_fan']);
echo '<br>角珊瑚方块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:horn_coral_block']);
echo '<br>钻石矿:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:diamond_ore']);
echo '<br>云杉木压力板:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:spruce_pressure_plate']);
echo '<br>唱片机:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:jukebox']);
echo '<br>金质压力板:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:golden_chestplate']);
echo '<br>炼药锅:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cauldron']);
echo '<br>橙色床:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:orange_bed']);
echo '<br>石剑:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stone_sword']);
echo '<br>鹿角珊瑚扇:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:horn_coral_fan']);
echo '<br>红色郁金香:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:red_tulip']);
echo '<br>雕刻过的南瓜:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:carved_pumpkin']);
echo '<br>末地烛:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:end_rod']);
echo '<br>红色郁金香:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:red_tulip']);
echo '<br>萤石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:glowstone']);
echo '<br>书架:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:bookshelf']);
echo '<br>白色陶瓦:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:white_terracotta']);
echo '<br>烈焰棒:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:blaze_rod']);
echo '<br>铁栏杆:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:iron_bars']);
echo '<br>雪球:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:snowball']);
echo '<br>海绵:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:sponge']);
echo '<br>烤牛排:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:cooked_beef']);
echo '<br>羽毛:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:feather']);
echo '<br>水桶:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:water_bucket']);
echo '<br>燧石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:flint']);
echo '<br>兔纸:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:rabbit']);
echo '<br>去皮云杉原木:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:stripped_spruce_log']);
echo '<br>棕色蘑菇方块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:brown_mushroom_block']);
echo '<br>失活的火珊瑚扇:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dead_fire_coral_fan']);
echo '<br>铁锄头:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:iron_hoe']);
echo '<br>蓝色陶瓦:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:blue_terracotta']);
echo '<br>拉杆:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:lever']);
echo '<br>花岗岩:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:granite']);
echo '<br>金马铠:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:golden_horse_armor']);
echo '<br>南瓜灯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:jack_o_lantern']);
echo '<br>浅灰色地毯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:light_gray_carpet']);
echo '<br>钻石稿:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:diamond_pickaxe']);
echo '<br>品红色带釉陶瓦:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:magenta_glazed_terracotta']);
echo '<br>黏土球:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:clay_ball']);
echo '<br>皮革护腿:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:leather_leggings']);
echo '<br>红石灯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:redstone_lamp']);
echo '<br>龙首:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:dragon_head']);
echo '<br>紫珀块:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:purpur_block']);
echo '<br>鞘翅:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:elytra']);
echo '<br>打火石:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:flint_and_steel']);
echo '<br>白色地毯:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:white_carpet']);
echo '<br>白色染色玻璃:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:white_stained_glass']);
echo '<br>铁铲子:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:iron_shovel']);
echo '<br>玻璃板:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:glass_pane']);
echo '<br>丛林树苗:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:jungle_sapling']);
echo '<br>虞美人:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:poppy']);
echo '<br>云杉半砖:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:spruce_slab']);
echo '<br>矿车:'.json_decode($dkjson['stats']['minecraft:picked_up/minecraft:minecart']);

//echo '</table>';
}
?>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>