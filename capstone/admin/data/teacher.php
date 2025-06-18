<?php

function getFilteredTeachers($conn, $sort_by = 'teacher_id', $search_key = '') {
    $allowed_sort_columns = ['teacher_id', 'fname', 'lname', 'username', 'email_address', 'phone_number', 'position'];
    if (!in_array($sort_by, $allowed_sort_columns)) {
        $sort_by = 'teacher_id';
    }

    $sql = "SELECT teacher_id, fname, lname, username, email_address, phone_number, position, address, employee_number, date_of_birth, qualification, gender, subject, class FROM teachers";

    if (!empty($search_key)) {
        $sql .= " WHERE fname LIKE ? OR lname LIKE ? OR email_address LIKE ?";
    }

    $sql .= " ORDER BY $sort_by";

    $stmt = $conn->prepare($sql);

    $params = [];
    if (!empty($search_key)) {
        $params[] = "%$search_key%";
        $params[] = "%$search_key%";
        $params[] = "%$search_key%";
    }

    $stmt->execute($params);

    if ($stmt->rowCount() >= 1) {
        return $stmt->fetchAll();
    } else {
        return [];
    }
}

function getAllTeachers($conn) {
    // Fetch both first and last names
    $sql = "SELECT teacher_id, fname, lname FROM teachers";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll();
    } else {
        return [];
    }
}

function removeTeacher($teacher_id, $conn) {
    $sql = "DELETE FROM teachers WHERE teacher_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$teacher_id]);

    return $stmt->rowCount() > 0;
}

function unameIsUnique($uname, $conn) {
    $sql = "SELECT * FROM teachers WHERE username = ?"; // Correct column name
    $stmt = $conn->prepare($sql);
    $stmt->execute([$uname]);

    return $stmt->rowCount() === 0; // Returns true if no rows are found (unique)
}

function getSubjectNameById($subject_id, $conn) {
    $sql = "SELECT subject FROM subjects WHERE subject_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$subject_id]);

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        return $row['subject'];
    } else {
        return "N/A"; // Return N/A if the subject ID is not found
    }
}
function getTeacherById($teacher_id, $conn) {
    $sql = "SELECT * FROM teachers WHERE teacher_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$teacher_id]);

    if ($stmt->rowCount() > 0) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        return 0; // Return 0 if no teacher is found
    }
}