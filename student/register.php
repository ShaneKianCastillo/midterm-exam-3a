<?php 
    include '../root/functions.php';
    checkUserSessionIsActive();
    
?>

<?php 
    $pageTitle = "Register Student";  
    include('../root/header.php');

    $errorArray = [];
    $studID = "";
    $firstName = "";
    $lastName = "";

    if (!isset($_SESSION['student_data'])) {
        $_SESSION['student_data'] = [];
    }

    // Handle form submission
    if (isset($_POST['addStud'])) {
        $studID = $_POST['studID'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        
        // Validate student data
        $errorArray = validateStudentData([
            'ID' => $studID,
            'first_name' => $firstName,
            'last_name' => $lastName
        ]);

        // Check for duplicates if no validation errors
        if (empty($errorArray)) {
            $duplicateErrors = checkDuplicateStudentData([
                'ID' => $studID,
                'first_name' => $firstName,
                'last_name' => $lastName
            ]);

            if (!empty($duplicateErrors)) {
                $errorArray = array_merge($errorArray, $duplicateErrors);
            }
        }

        // Add student if there are no errors
        if (empty($errorArray)) {
            $_SESSION['student_data'][] = [
                'ID' => $studID,
                'first_name' => $firstName,
                'last_name' => $lastName
            ];
            // Clear form fields after successful submission
            $studID = ""; 
            $firstName = ""; 
            $lastName = ""; 
        }
    }
?>

<div class="container my-5">
    <?php
        // Display errors if there are any
        if (!empty($errorArray)) {
            echo displayErrors($errorArray);
        }
    ?>
    <h2>Register a New Student</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../root/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Register Student</li>
        </ol>
    </nav>

    <!-- Form to Register a New Student -->
    <div class="card p-3 mb-4">
        <form method="post">
            <div class="mb-3">
                <label for="studentID" class="form-label">Student ID</label>
                <input type="text" name="studID" class="form-control" id="studentID" placeholder="Enter Student ID" value="<?= htmlspecialchars($studID) ?>">
            </div>
            <div class="mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" name="firstName" class="form-control" id="firstName" placeholder="Enter First Name" value="<?= htmlspecialchars($firstName) ?>">
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" name="lastName" class="form-control" id="lastName" placeholder="Enter Last Name" value="<?= htmlspecialchars($lastName) ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="addStud">Add Student</button>
        </form>
    </div>

    <!-- Display the Student List -->
    <div class="card p-3">
        <h5 class="card-title">Student List</h5>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Student ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($_SESSION['student_data'])) : ?>
                    <tr>
                        <td colspan="4" class="text-center">No student records found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($_SESSION['student_data'] as $student): ?>
                        <tr>
                            <td><?= htmlspecialchars($student['ID']) ?></td>
                            <td><?= htmlspecialchars($student['first_name']) ?></td>
                            <td><?= htmlspecialchars($student['last_name']) ?></td>
                            <td>
                            <a href="edit.php?id=<?= htmlspecialchars($student['ID']) ?>" class="btn btn-info btn-sm">Edit</a>
                            <a href="delete.php?id=<?= htmlspecialchars($student['ID']) ?>" class="btn btn-danger btn-sm">Delete</a>
                            <a href="attach-subject.php?id=<?= htmlspecialchars($student['ID']) ?>" class="btn btn-primary btn-sm">Attach Subject</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../root/footer.php'); ?>
