<?php

function verifyEmail($email)
{
    if (!Validator::email($email))
        error(400, ["Email is invalid"]);

    $db = Database::instance();
    $result = $db->get("SELECT COUNT(*) AS `count` FROM `users` WHERE `email` = ?", [$email]);

    if ($result->count > 0)
        error(409, ["This email cannot be used"]);
}

function verifyPassword($password)
{
    $passwordErrors = Validator::password($password);
    
    if (count($passwordErrors) > 0)
        error(400, $passwordErrors);
}

 
function createUser($email, $password)
{
    $db = Database::instance();


    $passwordHash = PasswordUtils::hash($password);

    $db->execute(
        "INSERT INTO `users` (`email`, `passwordHash`) VALUES (?, ?)",
        [$email, $passwordHash]);

    $userId = $db->lastInsertId();

    $db->execute("INSERT INTO `userProfiles` (`userId`) VALUES (?)",[$userId]);
}

$req = post();
if (!isset($req->email) || !isset($req->password))
    error(400);

$email = $req->email;
$password = $req->password;

verifyEmail($email);
verifyPassword($password);

createUser($email, $password);

reply(["Signed up successfully."]);