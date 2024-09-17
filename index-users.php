<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'app/database/db.php';
require 'app/controllers/user.php';

$users = selectAll('user');

$page = isset($_GET['page']) && $_GET['page'] !== '' && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$perPage = 6;
$totalCourses = count($users);
$totalPages = ceil($totalCourses / $perPage);
$offset = $perPage * ($page -1);
if($offset >= 0)
{
    $users = selectAllLimitOffset('user', $perPage, $offset, 'id_user', 'DESC');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin user</title>
    <link rel="stylesheet" href="frontend/css/header-footer.css">
    <link rel="stylesheet" href="frontend/css/course-list.css">
    <link rel="icon" type="image/x-icon" href="frontend/img/black.png">
</head>
<body>
<?php include 'app/include/header.php'; ?>
<?php if(isset($_SESSION['admin']) && $_SESSION['admin'] === 1): ?>
    <span><?=$errMsg?></span>
    <div class="container">
        <div class="sidebar">
            <a href="index-posts.php">Courses</a>
            <a href="index-users.php">Users</a>
        </div>
        <div class="container-content">
            <?php if($offset >= 0 && count($users) > 0): ?>
            <div class="container-table">
                <table class="user-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id_user']; ?></td>
                            <td><?= htmlspecialchars($user['username']); ?></td>
                            <td><?= $user['email']; ?></td>
                            <td>
                                <a class="edit-button" href="edit-users.php?id=<?= $user['id_user']; ?>">Edit</a>
                                <a class="delete-button" href="edit-users.php?delete-id=<?= $user['id_user']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>

            <?php if($offset >= 0 && count($users) > 0): ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++):?>
                        <a href="?page=<?= $i; ?>" <?= $page == $i ? 'class="active"' : ''; ?>><?= $i; ?></a>
                    <?php endfor; ?>

                </div>
            <?php else: ?>
                <div class="container-empty">
                    <h2>No users were found!</h2>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <div class="container-empty">
        <h2>You have no access to this page!</h2>
    </div>
<?php endif; ?>

<?php include 'app/include/footer.php'; ?>
</body>
</html>
