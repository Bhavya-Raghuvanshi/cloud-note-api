<?php

$db = Database::instance();

$req = post();

if (!isset($req->id) || !isset($req->title) || !isset($req->description) || !isset($req->noteColor))
    error(400);

$noteId = $req->id;
$title = $req->title;
$description = $req->description;
$noteColor = $req->noteColor;

$db->execute("UPDATE `notes` SET `title`= ?, `description`= ?,`noteColor`= ? WHERE `id` = ?", [$title, $description, $noteColor, $noteId]);
