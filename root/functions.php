<?php 

function getUsers() {
    return [
        "email1@email.com" => "password",
        "email2@email.com" => "password",
        "email3@email.com" => "password",
        "email4@email.com" => "password",
        "email5@email.com" => "password"
    ];
}

function validateLoginCredentials($email, $password) {
    $errorArray = [];
    $users = getUsers(); 

    if (empty($email)) {
        $errorArray['email'] = 'Email Address is required!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorArray['email'] = 'Email Address is invalid!';
    }

    if (empty($password)) {
        $errorArray['password'] = 'Password is required!';
    }

    if (empty($errorArray)) {
        if (!checkLoginCredentials($email, $password, $users)) {
            $errorArray['credentials'] = 'Incorrect email or password!';
        }
    }

    return $errorArray;
}

function checkLoginCredentials($email, $password, $users) {
    return isset($users[$email]) && $users[$email] === $password;
}

function checkUserSessionIsActive() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); 
    }
}

function guard($redirectPage = 'dashboard.php') {
    if (empty($_SESSION['emailtxt']) && basename($_SERVER['PHP_SELF']) != $redirectPage) {
        header("Location: $redirectPage"); 
        exit;
    }
}
function displayErrors($errors) {
    if (empty($errors)) {
        return ''; 
    }

    $output = '
    <div class="alert alert-danger alert-dismissible fade show mx-auto my-5" style="margin-bottom: 20px;" role="alert">
        <strong>System Errors:</strong> Please correct the following errors.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <hr>
        <ul>';

    foreach ($errors as $error) {
        $output .= '<li>' . htmlspecialchars($error) . '</li>';
    }
    $output .= '</ul></div>';

    return $output;
}

function displayErrorsLogin($errors) {
    if (empty($errors)) {
        return ''; 
    }
    
    $output = '
    <div class="alert alert-danger alert-dismissible fade show mx-auto my-2" style="max-width: 600px; margin-bottom: 20px;" role="alert">
        <strong>System Errors:</strong> Please correct the following errors.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <hr>
        <ul>';

    foreach ($errors as $error) {
        $output .= '<li>' . htmlspecialchars($error) . '</li>';
    }
    $output .= '</ul></div>';

    return $output;
}

function renderErrorsToView($error) {
    if (empty($error)) {
        return null;
    }

    return '
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        ' . htmlspecialchars($error) . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}

function getBaseURL() {
    return 'http://dct-ccs-midterm.test/';
}


// for subjects

function validateSubjectData($subject_data) {
    $errorArray = [];

    if (empty($subject_data['subject_code'])) {
        $errorArray['subject_code'] = 'Subject code is required!';
    }

    if (empty($subject_data['subject_name'])) {
        $errorArray['subject_name'] = 'Subject name is required!';
    }
    return $errorArray;
}

function checkDuplicateSubjectData($subject_data) {
    $errors = [];

    // Check for duplicate subject code or name
    foreach ($_SESSION['subject_data'] as $existing_subject) {
        if ($existing_subject['subject_code'] == $subject_data['subject_code']) {
            $errors[] = "A subject with this code already exists.";
        }
        if ($existing_subject['subject_name'] == $subject_data['subject_name']) {
            $errors[] = "A subject with this name already exists.";
        }
    }

    return $errors;
}

// For students

function validateStudentData($student_data) {
    $errorArray = [];

    if (empty($student_data['ID'])) {
        $errorArray['ID'] = 'Student ID is required!';
    }

    if (empty($student_data['first_name'])) {
        $errorArray['first_name'] = 'First name is required!';
    }

    if (empty($student_data['last_name'])) {
        $errorArray['last_name'] = 'Last name is required!';
    }

    return $errorArray;
}

function checkDuplicateStudentData($student_data) {
    $errors = [];

    // Check for duplicate student ID, first name, or last name
    foreach ($_SESSION['student_data'] as $existing_student) {
        if ($existing_student['ID'] == $student_data['ID']) {
            $errors[] = "A student with this ID already exists.";
        }
        
    }

    return $errors;
}

function getSelectedStudentIndex($studentID) {
    if (!isset($_SESSION['student_data'])) {
        return null;
    }

    foreach ($_SESSION['student_data'] as $index => $student) {
        if ($student['ID'] == $studentID) {
            return $index;
        }
    }

    return null;
}

function getSelectedStudentData($index) {
    if (isset($_SESSION['student_data'][$index])) {
        return $_SESSION['student_data'][$index];
    }
    return null;
}

function getSelectedSubjectIndex($subject_code) {
    if (!isset($_SESSION['subject_data'])) {
        return null;
    }
    foreach ($_SESSION['subject_data'] as $index => $subject) {
        if ($subject['subject_code'] === $subject_code) {
            return $index;
        }
    }
    return null;
}







?>