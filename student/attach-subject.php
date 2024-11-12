<?php 
include '../root/functions.php';
session_start();
checkUserSessionIsActive();
guard();

$pageTitle = "Attach Subject to Student";  
include('../root/header.php');

// Check if a valid student ID is provided
if (!isset($_GET['id'])) {
    header("Location: register.php");
    exit();
}

$studentID = $_GET['id'];
$studentIndex = getSelectedStudentIndex($studentID);
if ($studentIndex === null) {
    header("Location: register.php");
    exit();
}

$studentData = $_SESSION['student_data'][$studentIndex];
$errorArray = [];

// Initialize attached subjects if not set
if (!isset($studentData['attached_subjects'])) {
    $studentData['attached_subjects'] = [];
}

// Handle subject attachment
if (isset($_POST['attachSubject'])) {
    $selectedSubjects = $_POST['subjects'] ?? [];

    if (empty($selectedSubjects)) {
        $errorArray[] = "Please select at least one subject to attach.";
    } else {
        foreach ($selectedSubjects as $subjectCode) {
            // Avoid duplicate attachments
            if (!in_array($subjectCode, $studentData['attached_subjects'])) {
                $studentData['attached_subjects'][] = $subjectCode;
            }
        }
        $_SESSION['student_data'][$studentIndex] = $studentData;
    }
}
?>

<div class="container my-5">
    <?php if (!empty($errorArray)) : ?>
        <?= displayErrors($errorArray) ?>
    <?php endif; ?>
    <h2>Attach Subject to <?= htmlspecialchars($studentData['first_name'] . ' ' . $studentData['last_name']) ?></h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../root/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Attach Subject</li>
        </ol>
    </nav>

    <!-- Subject Selection Form -->
    <div class="card p-3 mb-4">
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Select Subjects</label>
                <div>
                    <?php 
                    // Filter out subjects already attached
                    $availableSubjects = array_filter($_SESSION['subject_data'], function($subject) use ($studentData) {
                        return !in_array($subject['subject_code'], $studentData['attached_subjects']);
                    });
                    
                    // Display available subjects for selection
                    if (empty($availableSubjects)) {
                        echo "<p>No subjects available to attach.</p>";
                    } else {
                        foreach ($availableSubjects as $subject) : ?>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="subjects[]" value="<?= htmlspecialchars($subject['subject_code']) ?>">
                                <label class="form-check-label">
                                    <?= htmlspecialchars($subject['subject_name']) ?>
                                </label>
                            </div>
                        <?php endforeach; 
                    } ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="attachSubject">Attach Subjects</button>
        </form>
    </div>

    <!-- Display Attached Subjects -->
    <div class="card p-3">
        <h5 class="card-title">Attached Subjects</h5>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Subject Code</th>
                    <th scope="col">Subject Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($studentData['attached_subjects'])) : ?>
                    <tr>
                        <td colspan="3" class="text-center">No subjects attached.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($studentData['attached_subjects'] as $subjectCode) : ?>
                        <?php
                        // Retrieve subject details based on code
                        $subject = array_filter($_SESSION['subject_data'], function($s) use ($subjectCode) {
                            return $s['subject_code'] === $subjectCode;
                        });
                        $subject = reset($subject);
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($subject['subject_code']) ?></td>
                            <td><?= htmlspecialchars($subject['subject_name']) ?></td>
                            <td><a href="detach-subject.php?code=<?= htmlspecialchars($subjectCode) ?>&student_id=<?= htmlspecialchars($studentID) ?>" class="btn btn-info btn-sm">Detach Subject</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>



<?php include('../root/footer.php'); ?>
