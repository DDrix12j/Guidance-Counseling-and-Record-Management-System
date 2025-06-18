<?php  

// All Messages (Excludes Archived Messages)
function getAllMessages($conn){
   $sql = "SELECT * FROM message WHERE is_archived = 0 ORDER BY message_id DESC";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() >= 1) {
     $messages = $stmt->fetchAll();
     return $messages;
   } else {
    return 0;
   }
}

// Archived Messages
function getArchivedMessages($conn) {
    $sql = "SELECT * FROM message WHERE is_archived = 1 ORDER BY message_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}