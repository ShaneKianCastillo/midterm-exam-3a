<?php 
    function getUsers() {
        return [
            "user1@gmail.com" => "password",
            "user2@gmail.com" => "password",
            "user3@gmail.com" => "password",
            "user4@gmail.com" => "password",
            "user5@gmail.com" => "password"
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
?>