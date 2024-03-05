<?php

$db = Database::instance();

get();

if (!isset($_GET['noteId']))
    error(400);

$noteId = $_GET["noteId"];

$note = $db->get("SELECT `title`,`description`,`noteColor`, DATE_FORMAT(`editedTime`, '%e %M %Y') AS editedTime FROM `notes` WHERE `id` = ?",[$noteId]);

if ($note == null)
    error(404);

echo json_encode(["note"=>$note]);