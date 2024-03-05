<?php

Authorize::forRoles();

$req = post();

$db = Database::instance();

if (!isset($req->recycledIds))
    error(400);

$claims = Authorize::claims();
$userId = $claims['id'];

$recycledIds = $req->recycledIds;



$setOfQuestionMarks = [];

foreach($recycledIds as $recycledId)
{
    array_push($setOfQuestionMarks,"?");    
}

$questionMark = join(",",$setOfQuestionMarks);

$archivedNotesIds = $db->getAll("SELECT `id`,`isArchived` FROM `notes` WHERE `userId` = $userId AND `id` IN ($questionMark)",$recycledIds);

$archivedNotes = [];
$unarchivedNotes = [];


foreach ($archivedNotesIds as $archivedNotesId) 
{
    if($archivedNotesId->isArchived == 1)
    {
        array_push($archivedNotes,$archivedNotesId->id);
    }
    if($archivedNotesId->isArchived == 0)
    {
        array_push($unarchivedNotes,$archivedNotesId->id);
    }
}
 
if (!empty($archivedNotes)) 
{
    $archivedIds = implode(',', $archivedNotes);

    $db->execute("UPDATE `notes` SET `isArchived` = 0 , `isDeleted` = 1 , `preArchived` = 1 WHERE `id` IN ($archivedIds)");
}

if (!empty($unarchivedNotes)) 
{
    $unarchivedIds = implode(',', $unarchivedNotes);

    $db->execute("UPDATE `notes` SET `isDeleted` = 1 WHERE `id` IN ($unarchivedIds)");
}
