<?php

$req = post();


if (!isset($req))
    error(400);

$deletedIds = $req->deletedIds;

$db = Database::instance();


$setOfQuestionMarks = [];

foreach($deletedIds as $deletedId)
{
    array_push($setOfQuestionMarks,"?");    
}

$questionMark = join(",",$setOfQuestionMarks);

$deletedNotesIds = $db->execute("DELETE FROM `notes` WHERE `id` IN ($questionMark)",$deletedIds);
 

 