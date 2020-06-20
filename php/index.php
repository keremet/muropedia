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
 
 session_start();
 if( "1" == $_GET['exit'] )
	$_SESSION = array();
 
 include('connect.php'); ?>
<html>
 <head>
  <meta charset="utf-8">
  <title>Список песен</title>
 </head>
 <body>
 <? if( isset($_SESSION['uid']) ) {?>
 <a href="add_song.php">Добавить песню</a> <a href="index.php?exit=1">Выход</a><br>
 <? } else {?>
 <a href="login.php">Логин</a><br>
 <?
	}
	$stmtSinger = $db->prepare("SELECT id, name FROM singer order by name");
	$stmtSong = $db->prepare("SELECT id, name FROM song WHERE singer_id = ? ORDER BY name");
	$stmtSinger->execute();
	while( $rowSinger = $stmtSinger->fetch() )  {
		echo "<b>".$rowSinger['name']."</b><br>";
		$stmtSong->execute(array($rowSinger['id']));
		while( $rowSong = $stmtSong->fetch() )  {
			echo "<a href='song.php?id=" .$rowSong['id']."'>".$rowSong['name']."</a><br>";
		}
		echo "<br>";
	}
?>
 </body>
</html>
