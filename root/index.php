<?php 

    
    session_start(); 
    $pageTitle = "Log In";

    
    include 'functions.php';
    checkUserSessionIsActive();

    $email = "";
    $errorArray = [];
    



    if (isset($_POST['loginButton'])) {
        $email = htmlspecialchars(stripslashes(trim($_POST['emailtxt'])));
        $password = $_POST['passwordtxt'];
        
        $errorArray = validateLoginCredentials($email, $password);

        if (empty($errorArray)) {
            session_start();  
            $_SESSION['emailtxt'] = $email;  
            header("Location: dashboard.php");  
            exit();
        }
    }

?>

<?php 
    $pageTitle = "Login";  
    include('header.php');
?>

<?php 
    echo displayErrorsLogin($errorArray); 
?>

    <div class="container d-flex align-items-center justify-content-center vh-100" id="DashboardForm">
        <div class="card p-4" style="max-width: 400px; width: 100%;">
            <h2 class="text-center mb-4">Login</h2>
            <form method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="text" class="form-control" name="emailtxt" id="email" placeholder="Enter email" value="<?php echo htmlspecialchars($email); ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="passwordtxt" id="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary w-100" name="loginButton">Login</button>
            </form>
        </div>
    </div>

<?php include('footer.php'); ?>