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
	$stmt = $db->prepare(
		"SELECT song.id, song.name, IFNULL(singer.name, 'Неизвестен') singer_name, IFNULL(author.name, 'Неизвестен') author_name, song.txt, song.translation_txt, song.video
		FROM song
			LEFT JOIN singer ON singer.id = song.singer_id
			LEFT JOIN author ON author.id = song.author_id
		WHERE song.id = ?");
	$stmt->execute(array($_GET['id']));
	if(!($row = $stmt->fetch())) 
		die("Песня не найдена");
?>
<html>
 <head>
  <meta charset="utf-8">
  <title><?=$row['name'] ?></title>
  <script type="text/javascript" src="jquery-1.10.1.min.js"></script>
 </head>
 <body>
   <a href="index.php">Список песен</a><br>
    <b><?=$row['name'] ?></b><br>
	Исполнитель: <?=$row['singer_name'] ?><br>
	Автор слов: <?=$row['author_name'] ?><br><br>
	Ссылка на видео: <a href="<?=$row['video'] ?>"><?=$row['video'] ?></a><br><br>
    <table border=1>
    <tr><td><b>Текст:</b></td><td><b>Перевод:</b></td></tr>
    <tr><td><?=str_replace("\n", "<br>", $row['txt']) ?></td><td><?=str_replace("\n", "<br>", $row['translation_txt']) ?></td>
	</table>
 </body>
</html>
