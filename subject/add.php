<?php 
include '../root/functions.php';
session_start(); // Ensure session is started
checkUserSessionIsActive();

?>

<?php 
$pageTitle = "Add Subject";  
include('../root/header.php');

$errorArray = [];
$code = "";
$name = "";

if (!isset($_SESSION['subject_data'])) {
    $_SESSION['subject_data'] = [];
}

if (isset($_POST['addButton'])) {
    $code = $_POST['subCode'];
    $name = $_POST['subName'];
    
    $errorArray = validateSubjectData([
        'subject_code' => $code,
        'subject_name' => $name
    ]);

    if (empty($errorArray)) {
        $duplicateErrors = checkDuplicateSubjectData([
            'subject_code' => $code,
            'subject_name' => $name
        ]);

        if (!empty($duplicateErrors)) {
            $errorArray = array_merge($errorArray, $duplicateErrors);
        }
    }

    if (empty($errorArray)) {
        $_SESSION['subject_data'][] = ['subject_code' => $code, 'subject_name' => $name];
        $code = ""; 
        $name = ""; 
    }
}
?>

<!-- Display errors if there are any -->
<div class="container my-5">
    <?php
        if (!empty($errorArray)) {
            echo displayErrors($errorArray);
        }
    ?>
    <h2>Add a New Subject</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../root/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Subject</li>
        </ol>
    </nav>

    <div class="card p-3 mb-4">
        <form method="post">       
            <div class="mb-3">
                <label for="subjectCode" class="form-label">Subject Code</label>
                <input type="text" name="subCode" class="form-control" id="subjectCode" placeholder="Enter Subject Code" value="<?= htmlspecialchars($code) ?>">
            </div>
            <div class="mb-3">
                <label for="subjectName" class="form-label">Subject Name</label>
                <input type="text" name="subName" class="form-control" id="subjectName" placeholder="Enter Subject Name" value="<?= htmlspecialchars($name) ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="addButton">Add Subject</button>
            <button type="reset" class="btn btn-secondary">Clear</button>
        </form>
    </div>

    <div class="card p-3">
        <h5 class="card-title">Subject List</h5>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Subject Code</th>
                    <th scope="col">Subject Name</th>
                    <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($_SESSION['subject_data'])) : ?>
                    <tr>
                        <td colspan="3" class="text-center">No subject found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($_SESSION['subject_data'] as $subject): ?>
                        <tr>
                            <td><?= htmlspecialchars($subject['subject_code']) ?></td>
                            <td><?= htmlspecialchars($subject['subject_name']) ?></td>
                            <td>
                                <a href="edit.php?code=<?= urlencode($subject['subject_code']) ?>" class="btn btn-info btn-sm">Edit</a>
                                <a href="delete.php?code=<?= urlencode($subject['subject_code']) ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../root/footer.php'); ?>
