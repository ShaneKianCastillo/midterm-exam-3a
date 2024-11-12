<?php 
    include '../root/functions.php'; 
    session_start();
    checkUserSessionIsActive(); 
    guard(); 

    // Fetch the student ID from URL parameters
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header('Location: ../root/dashboard.php'); // Redirect if no ID is provided
        exit();
    }

    // Get the student ID
    $studentID = $_GET['id'];

    // Find the index of the student in the session data
    $studentIndex = getSelectedStudentIndex($studentID);

    if ($studentIndex === null) {
        // Redirect if the student is not found in session data
        header('Location: ../root/dashboard.php');
        exit();
    }

    // Get student data for confirmation
    $student = getSelectedStudentData($studentIndex);

    // Handle the deletion
    if (isset($_POST['deleteStudent'])) {
        // Remove the student from the session
        unset($_SESSION['student_data'][$studentIndex]);

        // Re-index the session array after deletion to avoid gaps
        $_SESSION['student_data'] = array_values($_SESSION['student_data']);
        
        // Redirect to register.php after deletion
        header('Location: register.php');
        exit();
    }

    $pageTitle = "Delete Student";
    include('../root/header.php');
?>

<div class="container my-5">
    <h2>Delete a Student</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../root/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete Student</li>
        </ol>
    </nav>

    <!-- Confirmation Message -->
    <div class="card p-3 mb-4">
        <p>Are you sure you want to delete the following student record?</p>
        <ul>
            <li><strong>Student ID:</strong> <?= htmlspecialchars($student['ID']) ?></li>
            <li><strong>First Name:</strong> <?= htmlspecialchars($student['first_name']) ?></li>
            <li><strong>Last Name:</strong> <?= htmlspecialchars($student['last_name']) ?></li>
        </ul>

        <!-- Delete Confirmation Form -->
        <form method="POST">
            <button type="submit" name="deleteStudent" class="btn btn-danger">Delete Student Record</button>
            <a href="register.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php include('../root/footer.php'); ?>
