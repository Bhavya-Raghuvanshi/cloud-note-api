<?php

Authorize::forRoles();

$req = post();

$db = Database::instance();

if (!isset($req->restoredIds))
    error(400);

$restoredIds = $req->restoredIds;

$claims = Authorize::claims();
$userId = $claims['id'];

$setOfQuestionMarks = [];

foreach($restoredIds as $restoredId)
{
    array_push($setOfQuestionMarks,"?");    
}

$questionMark = join(",",$setOfQuestionMarks);

$preArchivedNotesIds = $db->getAll("SELECT `id`,`preArchived` FROM `notes` WHERE `userId` = $userId AND `id` IN ($questionMark)",$restoredIds);

$preArchivedNotes = [];
$recycledNotes = [];

foreach ($preArchivedNotesIds as $preArchivedNotesId) 
{
    if($preArchivedNotesId->preArchived == 1)
    {
        array_push($preArchivedNotes,$preArchivedNotesId->id);
    }
    if($preArchivedNotesId->preArchived == 0)
    {
        array_push($recycledNotes,$preArchivedNotesId->id);
    }
}


if (!empty($preArchivedNotes)) 
{
    $preArchivedIds = implode(',', $preArchivedNotes);
 
    $db->execute("UPDATE `notes` SET `isArchived` = 1 , `isDeleted` = 0 , `preArchived` = 0 WHERE `id` IN ($preArchivedIds)");
}

if (!empty($recycledNotes)) 
{
    $recycledIds = implode(',', $recycledNotes);

    $db->execute("UPDATE `notes` SET `isDeleted` = 0 WHERE `id` IN ($recycledIds)");
}
