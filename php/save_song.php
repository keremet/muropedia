<?php
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
include('connect.php');

$stmt = $db->prepare("INSERT INTO song(name, singer_id, author_id, txt, translation_txt, member_id)values(?, ?, ?, ?, ?, ?)");
if( $stmt->execute(array($_POST['name'], (0 == $_POST['singer']) ? null : $_POST['singer'], (0 == $_POST['author']) ? null : $_POST['author'], $_POST['txt'], $_POST['translation_txt'], $_SESSION['uid'])) ) {
	header( 'Location: ./song.php?id='.$db->lastInsertId() );
} else {
	http_response_code(500);
	$errInfo = $stmt->errorInfo();
	echo implode($errInfo, ",");
}
?>
