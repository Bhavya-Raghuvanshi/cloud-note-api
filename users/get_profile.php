<?php

Authorize::forRoles();

get();

$claims = Authorize::claims();
$db = Database::instance();

$userId = $claims["id"];
$email = $claims["email"];

$profile = $db->get("SELECT `name`, `occupation`, `about`, `contact`, `location`,`avatarFileName` FROM `userProfiles` WHERE `userId` = ?", [$userId]);



echo json_encode(["profile" => $profile , "email" => $email]);
