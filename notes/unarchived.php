<?php

$req = post();

$db = Database::instance();


if (!isset($req->unarchivedIds))
    error(400);

$unarchivedIds = $req->unarchivedIds;
 


$setOfQuestionMarks = [];

foreach($unarchivedIds as $unarchivedId)
{
    array_push($setOfQuestionMarks,"?");    
}

$questionMark = join(",",$setOfQuestionMarks);
 
$recycledNotes = $db->execute("UPDATE `notes` SET `isArchived` = 0 WHERE `id` IN ($questionMark)", $unarchivedIds);