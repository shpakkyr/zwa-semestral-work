<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require 'app/database/db.php';
    require 'app/controllers/posts.php';

    $posts = selectAll('posts');

    $page = isset($_GET['page']) && $_GET['page'] !== '' && is_numeric($_GET['page']) ? $_GET['page'] : 1;
    $perPage = 2;
    $totalCourses = count($posts);
    $totalPages = ceil($totalCourses / $perPage);
    $offset = $perPage * ($page -1);
    if($offset >= 0)
    {
        $posts = selectAllLimitOffset('posts', $perPage, $offset, 'id_course', 'DESC');
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin course</title>
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
        <?php if($offset >= 0 && count($posts) > 0): ?>
        <div class="course-wrapper">
            <?php foreach ($posts as $key => $post): ?>
                <div class="content">
                    <a href="course.php?id_course=<?= $post['id_course']; ?>">
                        <img src="uploads/<?php echo $post['img']; ?>" alt="Course 1">
                        <h3><?=htmlspecialchars($post['name']);?></h3>
                    </a>
                    <div class="buttons">
                        <div class="edit-button">
                            <a href="edit-posts.php?id=<?=$post['id_course']?>">Edit</a>
                        </div>
                        <div class="delete-button">
                            <a href="edit-posts.php?delete-id=<?=$post['id_course']?>">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if($offset >= 0 && count($posts) > 0): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++):?>
                    <a href="?page=<?= $i; ?>" <?= $page == $i ? 'class="active"' : ''; ?>><?= $i; ?></a>
                <?php endfor; ?>

            </div>
        <?php else: ?>
            <div class="container-empty">
                <h2>No courses were found!</h2>
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
