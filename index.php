<form name="form1" method="post">
	<table width="509" border="0">
		<tr>
			<td> 用户名:</td>
			<td><input type="text" name="post" size="20"></td>
			<td><input name="submit" type="submit" id="submit" value="查询"/></td>
		</tr>
	</table>
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
echo '<table><td>';  
echo '<p>被杀死次数</p>';
echo '河豚:'.json_decode(json_encode($dkjson['stats']['minecraft:killed_by/minecraft:pufferfish']));
echo '<br>骷髅:'.json_decode(json_encode($dkjson['stats']['minecraft:killed_by/minecraft:skeleton']));
echo '<br>卫道士:'.json_decode(json_encode($dkjson['stats']['minecraft:killed_by/minecraft:vindicator']));
echo '<br>闹鬼:'.json_decode(json_encode($dkjson['stats']['minecraft:killed_by/minecraft:vex']));
echo '<br>流髑:'.json_decode(json_encode($dkjson['stats']['minecraft:killed_by/minecraft:stray']));
echo '<br>史莱姆:'.json_decode(json_encode($dkjson['stats']['minecraft:killed_by/minecraft:slime']));
echo '<br>爬行者:'.json_decode(json_encode($dkjson['stats']['minecraft:killed_by/minecraft:creeper']));
echo '<br>末影螨:'.json_decode(json_encode($dkjson['stats']['minecraft:killed_by/minecraft:endermite']));
echo '<br>玩家:'.json_decode(json_encode($dkjson['stats']['minecraft:killed_by/minecraft:player']));
echo '<br>末影人:'.json_decode(json_encode($dkjson['stats']['minecraft:killed_by/minecraft:enderman']));
echo '<br>幻翼:'.json_decode(json_encode($dkjson['stats']['minecraft:killed_by/minecraft:phantom']));
echo '</td><td>';
echo '<p>捡起物品次数</p>';
echo '<br>栓绳:'.json_decode(json_encode($dkjson['stats']['minecraft:picked_up/minecraft:lead']));
echo '</table>';
}
?>