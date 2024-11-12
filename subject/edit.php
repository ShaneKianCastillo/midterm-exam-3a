<?php
include '../root/functions.php';
checkUserSessionIsActive();
guard();

// Redirect if no subject code is provided
if (!isset($_GET['code'])) {
    header("Location: add.php");
    exit();
}

$subjectCode = $_GET['code'];
$index = getSelectedSubjectIndex($subjectCode);
if ($index === null) {
    header("Location: add.php");
    exit();
}

$subjectData = $_SESSION['subject_data'][$index];
$errorArray = [];

// Handle form submission for updating the subject
if (isset($_POST['updateSubject'])) {
    $newCode = $_POST['subCode'];
    $newName = $_POST['subName'];

    // Validate the updated subject data
    $errorArray = validateSubjectData([
        'subject_code' => $newCode,
        'subject_name' => $newName
    ]);

    if (empty($errorArray)) {
        // Update the session data with the new details
        $_SESSION['subject_data'][$index]['subject_code'] = $newCode;
        $_SESSION['subject_data'][$index]['subject_name'] = $newName;
        header("Location: add.php");
        exit();
    }
}

$pageTitle = "Edit Subject";
include('../root/header.php');
?>

<div class="container my-5">
    <?php if (!empty($errorArray)): ?>
        <?= displayErrors($errorArray) ?>
    <?php endif; ?>
    <h2>Edit Subject Details</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../root/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="add.php">Add Subject</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Subject</li>
        </ol>
    </nav>

    <div class="card p-3 mb-4">
        <form method="post">
            <div class="mb-3">
                <label for="subCode" class="form-label">Subject Code</label>
                <input type="text" name="subCode" class="form-control" id="subCode" value="<?= htmlspecialchars($subjectData['subject_code']) ?>">
            </div>
            <div class="mb-3">
                <label for="subName" class="form-label">Subject Name</label>
                <input type="text" name="subName" class="form-control" id="subName" value="<?= htmlspecialchars($subjectData['subject_name']) ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="updateSubject">Update Subject</button>
        </form>
    </div>
</div>

<?php include('../root/footer.php'); ?>
