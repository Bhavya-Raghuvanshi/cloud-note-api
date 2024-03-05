<?php

Authorize::forRoles();

get();

$db = Database::instance();

$claims = Authorize::claims();
$userId = $claims['id'];
 
$allNotes = $db->getAll("SELECT `id`,`title`,`description`,`noteColor`, DATE_FORMAT(`createTime`, '%e %M %Y') AS createTime FROM `notes` WHERE `userId` = $userId AND `isDeleted` = 0 AND `isArchived` = 0 AND `preArchived` = 0");

echo json_encode($allNotes);
