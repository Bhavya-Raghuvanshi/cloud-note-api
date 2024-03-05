<?php
Authorize::forRoles();
$req = post();

$claims = Authorize::claims();
$db = Database::instance();

$userId = $claims["id"];

if (!isset($req->imageName) || !isset($req->image))
{
    error(400);
}

$imageName = $req->imageName;
$image = $req->image;
$decodedImage = base64_decode($image);

$userProfile = $db->get(
    "SELECT `avatarFileName` FROM `userProfiles` WHERE `userId` = ?",
    [$userId]
);

$avatarUploads = "public/uploads/avatars";
$filePath = pathOf("$avatarUploads/$imageName");


file_put_contents($filePath,$decodedImage);   

if ($userProfile->avatarFileName != null)
    unlink(pathOf("$avatarUploads/{$userProfile->avatarFileName}"));

$db->execute(
    "UPDATE `userProfiles` SET `avatarFileName` = ? WHERE `userId` = ?",
    [$imageName, $userId]
);