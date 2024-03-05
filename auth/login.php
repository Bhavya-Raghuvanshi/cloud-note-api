<?php

    $req = post();
    
    if (!isset($req->email) || !isset($req->password))
        error(400);

    $email = $req->email;
    $password = $req->password;

    if (!Validator::email($email))
        error(400, ["Email is invalid"]);

    $db = Database::instance();
    $user = $db->get("SELECT `id`, `passwordHash` FROM `users` WHERE `email` = ?", [$email]);

    if ($user == null)
        error(401, ["Email or password is wrong"]);

    $passwordHashInDb = $user->passwordHash;
    if (!PasswordUtils::verify($password, $passwordHashInDb))
        error(401, ["Email or password is wrong"]);

    $tokenPayload = ["id" => $user->id, "email" => $email];
    $accessToken = JwtUtils::generateAccessToken($tokenPayload);

    echo json_encode([
        "accessToken" => $accessToken
    ]);
