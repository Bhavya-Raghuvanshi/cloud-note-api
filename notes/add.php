<?php

Authorize::forRoles();

$db = Database::instance();

$req = post();

if(!isset($req->title) || !isset($req->description))
    error(400);

$claims = Authorize::claims();
$userId = $claims['id'];

$title = $req->title;
$description = $req->description;
$noteColor = $req->noteColor;
 
$db->execute("INSERT INTO `notes` (`userId`,`title`, `description`,`noteColor`) VALUES (?, ?, ?, ?)",[$userId, $title, $description, $noteColor]);

$noteId = $db->lastInsertId();

$note = $db->get("SELECT `id`,`title`,`description`,`noteColor`, DATE_FORMAT(`createTime`, '%e %M %Y') AS createTime FROM `notes` WHERE `id` = ?",[$noteId]);
 
echo json_encode(["note"=>$note]);

