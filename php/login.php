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
	if( isset($_POST['login']) && isset($_POST['passwd'])  ) {
		include('connect.php'); 
		$stmt = $db->prepare(
			"SELECT id
			 FROM member
			 WHERE login = ? and password = ?");
		$stmt->execute(array($_POST['login'], $_POST['passwd']));
		if( !($row = $stmt->fetch()) )
			$error_msg = "Имя пользователя или пароль неверны";
		else {
			session_start();
			header('Location: index.php');
			$_SESSION['uid'] = $row['id'];
			exit;
		}
		
	}
?>
<html><head>
	<meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
	<title>Вход</title>
</head><body>	
	 <form action="login.php" method="post">
		Логин <input id="login" name="login" size="10" type="text"><br/>
		Пароль <input id="passwd" name="passwd" size="10" type="password"><br/>
		<input type="submit" value="Вход">
		<?=$error_msg?>
	</form>
</body></html>
