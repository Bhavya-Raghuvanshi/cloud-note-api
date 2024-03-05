<?php

$req = post();

if (!isset($req->archivedIds))
    error(400);

$archivedIds = $req->archivedIds;

$db = Database::instance();

$setOfQuestionMarks = [];

foreach($archivedIds as $archivedId)
{
    array_push($setOfQuestionMarks,"?");    
}

$questionMark = join(",",$setOfQuestionMarks);

$db->execute("UPDATE `notes` SET `isArchived` = 1 WHERE `id` IN ($questionMark)",$archivedIds);
