<? 
/*
 * This file is part of Muropedia.
 *
 * Copyright (C) 2020 - Andrey Sokolov
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, see <http://www.gnu.org/licenses/>.
 */
include('connect.php'); 
if( isset($_GET['id']) )
{
	$stmt = $db->prepare(
		"SELECT name,  singer_id, author_id, txt, translation_txt, video
		FROM song
		WHERE id = ?");
	$stmt->execute(array($_GET['id']));
	if(!($rowSong = $stmt->fetch())) 
		die("Песня не найдена");
} else
	$rowSong = array('name' => "",  'singer_id' => "", 'author_id' => "", 'txt' => "", 'translation_txt' => "", 'video' => "");
?>
<html>
 <head>
  <meta charset="utf-8">
  <title>Редактирование песни <?=$rowSong['name']?></title>
  <script type="text/javascript" src="jquery-1.10.1.min.js"></script>
 </head>
 <body>
<script>
function add_base(data_name, url)
{
	var s = prompt("Введите " + data_name, "")
	if(s == null) return
	if(s == '')
	{
		alert(data_name + ' не введено')
		return
	}
	jQuery.ajax({
		url:     url, //Адрес подгружаемой страницы
		type:     "POST", //Тип запроса
		dataType: "html", //Тип данных
		data: {
			name: s
		},
		success: function(response) { //Если все нормально
			alert(response);
		},
		error: function(response) { //Если ошибка
			alert(response);
		}
	});
}

function add_singer()  { add_base("имя исполнителя", "save_singer.php"); }
function add_author() {	add_base("имя автора", "save_author.php"); }
</script>
 <a href="index.php">Список песен</a><br>
  <form action="save_song.php" method="post">
	<?
		if( isset($_GET['id']) )
			echo "<input type='hidden' name='id' value='".$_GET['id']."'>";
	?>
	Название: <input required type="text" name="name" size="50" value="<?=$rowSong['name']?>"><br>
	Исполнитель: <select name="singer">
	<option value="0">Неизвестный</option>
	<?
		$stmt = $db->prepare("SELECT id, name FROM singer ORDER BY name");
		$stmt->execute();
		while( $row = $stmt->fetch() ) 
			echo "<option ".(($row['id'] == $rowSong['singer_id']) ? "selected ": "")."value='".$row['id']."'>".$row['name']."</option>";
	?>
	</select><input type="submit" onclick="add_singer(); return false;" value="Добавить исполнителя"><br>
	Автор слов: <select name="author">
    <option value="0">Неизвестный</option>
	<?
		$stmt = $db->prepare("SELECT id, name FROM author ORDER BY name");
		$stmt->execute();
		while( $row = $stmt->fetch() ) 
			echo "<option ".(($row['id'] == $rowSong['author_id']) ? "selected ": "")."value='".$row['id']."'>".$row['name']."</option>";
	?>
	</select><input type="submit" onclick="add_author(); return false;" value="Добавить автора"><br>
	Ссылка на видео: <input type="text" name="video" size="50" value="<?=$rowSong['video']?>"><br>
	<table>
	<tr><td><b>Текст:</b></td><td><b>Перевод:</b></td></tr>
	<tr><td><textarea rows="25" cols="45" name="txt"><?=$rowSong['txt']?></textarea></td><td><textarea rows="25" cols="45" name="translation_txt"><?=$rowSong['translation_txt']?></textarea></td>
	</table>
	<p><input type="submit" value="Отправить"></p>
	</form>
 </body>
</html>
