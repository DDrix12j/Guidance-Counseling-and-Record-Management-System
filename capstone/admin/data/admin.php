<?php 

function adminPasswordVerify($admin_pass, $conn, $admin_id){
   $sql = "SELECT * FROM admin
           WHERE admin_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$admin_id]);

   if ($stmt->rowCount() == 1) {
     $admin = $stmt->fetch();
     $pass  = $admin['password'];

     if (password_verify($admin_pass, $pass)) {
         return 1;
     }else {
         return 0;
     }
   }else {
    return 0;
   }
}

function getAllAdmins($conn) {
    $sql = "SELECT * FROM admin";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getAdminById($admin_id, $conn) {
    $sql = "SELECT * FROM admin WHERE admin_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$admin_id]);
    return $stmt->fetch();
}

function removeAdmin($admin_id, $conn) {
    $sql = "DELETE FROM admin WHERE admin_id=?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([$admin_id]);
}

function unameIsUnique($uname, $conn, $admin_id = 0) {
    $sql = "SELECT * FROM admin WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$uname]);
    if ($stmt->rowCount() > 0) {
        $admin = $stmt->fetch();
        if ($admin_id != 0 && $admin['admin_id'] == $admin_id) {
            return true;
        }
        return false;
    }
    return true;
}
?>