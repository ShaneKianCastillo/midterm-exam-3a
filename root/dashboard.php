<?php 

    include 'functions.php';
    checkUserSessionIsActive();
    guard();
   
?>

<?php 
    $pageTitle = "Dashboard";  
    include('header.php');
?>

    <div class="container my-5">
        <form method="post">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Welcome to the System: <?php echo $_SESSION['emailtxt']; ?></h2>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </form>     
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add a Subject</h5>
                        <p class="card-text">This section allows you to add a new subject in the system. Click the button below to proceed with the adding process.</p>
                        <a href="../subject/add.php" class="btn btn-primary">Add Subject</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Register a Student</h5>
                        <p class="card-text">This section allows you to register a new student in the system. Click the button below to proceed with the registration process.</p>
                        <a href="../student/register.php" class="btn btn-primary">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include('footer.php'); ?>
