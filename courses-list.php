<?php
    require 'app/database/db.php';

    $category = isset($_GET['category']) ? $_GET['category'] : '';
    if ($category) {
        $posts = selectAllWhere('posts', ['category' => $category]);
    } else {
        $posts = selectAll('posts');
    }

    $page = isset($_GET['page']) && $_GET['page'] !== '' && is_numeric($_GET['page']) ? $_GET['page'] : 1;
    $perPage = 2;
    $totalCourses = count($posts);
    $totalPages = ceil($totalCourses / $perPage);
    $offset = $perPage * ($page -1);
    if($offset >= 0)
    {
        $posts = selectAllLimitOffset('posts', $perPage, $offset, 'id_course', 'DESC', $category);
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Courses</title>
    <link rel="stylesheet" href="frontend/css/header-footer.css">
    <link rel="stylesheet" href="frontend/css/course-list.css">
    <link rel="icon" type="image/x-icon" href="frontend/img/black.png">
</head>
<body>
<?php include 'app/include/header.php'; ?>

<div class="courses-pagination">
    <?php if($offset >= 0 && count($posts) > 0): ?>
    <div class="courses-container">
        <?php foreach ($posts as $key => $post): ?>
            <div class="course">
                <a href="course.php?id_course=<?= $post['id_course']; ?>">
                    <img src="uploads/<?php echo $post['img']; ?>" alt="Course 1">
                    <h3><?=htmlspecialchars($post['name']);?></h3>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if($offset >= 0 && count($posts) > 0): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++):?>
            <a href="?page=<?= $i; ?>&category=<?= $category; ?>" <?= $page == $i ? 'class="active"' : ''; ?>><?= $i; ?></a>
        <?php endfor; ?>

    </div>
    <?php else: ?>
        <div class="container-empty">
            <h2>No courses were found!</h2>
        </div>
    <?php endif; ?>
</div>
<?php include 'app/include/footer.php'; ?>
</body>
</html>
