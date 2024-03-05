<?php

Authorize::forRoles();
$req = post();

$claims = Authorize::claims();
$db = Database::instance();

$userId = $claims["id"];

if (!isset($req->name) ||
    !isset($req->occupation) ||
    !isset($req->about) ||
    !isset($req->contact) ||
    !isset($req->location) 
)
{
    error(400);
}

if (!Validator::mobileNumber($req->contact))
    error(400, ["Invalid mobile number"]);

$userProfile = $db->get(
    "SELECT * FROM `userProfiles` WHERE `userId` = ?",
    [$userId]
);

$query = "";
if ($userProfile == null)
{
    $query = "
        INSERT INTO 
            `userProfiles` (`name`, `occupation`, `about`, `contact`, `location`, `userId`)
        VALUES
            (?, ?, ?, ?, ?, ?)
    ";
}
else
{
    $query = "
        UPDATE `userProfiles` SET 
            `name` = ?,
            `occupation` = ?,
            `about` = ?,
            `contact` = ?,
            `location` = ?
        WHERE
            `userId` = ?
    ";
}

$params = [
    $req->name,
    $req->occupation,
    $req->about,
    $req->contact,
    $req->location,
    $userId
];

$db->execute($query, $params);