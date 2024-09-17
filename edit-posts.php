<?php
    require 'app/database/db.php';
    require 'app/controllers/posts.php';

    $path = 0;
    $exist = 0;
    if(isset($id)){
        $existence = selectOne('posts', ['id_course' => $id]);
        if($existence)
        {
            if($existence['id_user'] === $_SESSION['id_user']){
                $path = 1;
            }
            if($existence['id_course'] == $id)
            {
                $exist = 1;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin edit</title>
    <link rel="stylesheet" href="frontend/css/header-footer.css">
    <link rel="stylesheet" href="frontend/css/create-course.css">
    <link rel="icon" type="image/x-icon" href="frontend/img/black.png">
</head>
<body>
<?php include "app/include/header.php"; ?>

<?php if(((isset($_SESSION['admin']) && $path === 1) || (isset($_SESSION['admin']) && $_SESSION['admin'] === 1)) && $exist === 1):?>
<div class="container-create">
    <form action="edit-posts.php" method="post" enctype="multipart/form-data">
        <span><?=$errMsg?></span>
        <input name="id" type="hidden" value="<?=$id?>">
        <div class="container-block">
            <label for="course-name">Name:</label>
            <div class="container-input">
                <input type="text" name="course-name" id="course-name" value="<?= htmlspecialchars($name); ?>" placeholder="Name of course">
            </div>
            <span class="fields-error"><?= $nameErr ?></span>
        </div>
        <div class="container-block">
            <label for="category">Choose category:</label>
            <div class="container-option">
                <select name="category" id="category">
                    <option value="Fitness" <?php echo ($category === 'Fitness') ? 'selected' : ''; ?>>Fitness</option>
                    <option value="Body-building" <?php echo ($category === 'Body-building') ? 'selected' : ''; ?>>Body-building</option>
                    <option value="Cross-fit" <?php echo ($category === 'Cross-fit') ? 'selected' : ''; ?>>Cross fit</option>
                    <option value="Active" <?php echo ($category === 'Active') ? 'selected' : ''; ?>>Active</option>
                </select>
            </div>
            <span><?=$categoryErr?></span>
        </div>
        <div class="container-block">
            <label for="creator-name">Creator:</label>
            <div class="container-input">
                <input type="text" name="creator-name" id="creator-name" placeholder="Creator of course" value="<?=htmlspecialchars($creator);?>">
            </div>
            <span><?=$creatorErr?></span>
        </div>
        <div class="container-block">
            <label for="job-title">Job title:</label>
            <div class="container-input">
                <input type="text" name="job-title" id="job-title" placeholder="Title in job occupation" value="<?=htmlspecialchars($title);?>">
            </div>
            <span><?=$titleErr?></span>
        </div>
        <div class="container-block">
            <label for="course-overview">Course overview:</label>
            <div class="container-textarea">
                <textarea name="course-overview" id="course-overview" rows="10" placeholder="Description of course"><?php echo htmlspecialchars($content); ?></textarea>
            </div>
            <span><?=$overviewErr?></span>
        </div>
        <p>Benefits (mandatory):</p>
        <div class="container-block">
            <label for="course-benefits1">1:</label>
            <div class="container-input">
                <input type="text" name="course-benefits1" id="course-benefits1" placeholder="Benefits of course" value="<?=htmlspecialchars($benefit1);?>">
            </div>
            <span><?=$benefit1Err?></span>
        </div>
        <div class="container-block">
            <label for="course-benefits2">2:</label>
            <div class="container-input">
                <input type="text" name="course-benefits2" id="course-benefits2" placeholder="Benefits of course" value="<?=htmlspecialchars($benefit2);?>">
            </div>
            <span><?=$benefit2Err?></span>
        </div>
        <div class="container-block">
            <label for="course-benefits3">3:</label>
            <div class="container-input">
                <input type="text" name="course-benefits3" id="course-benefits3" placeholder="Benefits of course" value="<?=htmlspecialchars($benefit2);?>">
            </div>
            <span><?=$benefit3Err?></span>
        </div>
        <div class="container-block">
            <label for="preview-img">Preview image (upload later):</label>
            <div class="container-input">
                <input type="file" name="preview-img" id="preview-img" accept=".jpg, .jpeg, .png, .gif">
            </div>
        </div>
        <div class="container-buttons">
            <button name="edit-edit-button" id="create-button" type="submit">Edit</button>
            <button name="cancel-edit-button" id="cancel-button">Cancel</button>
        </div>
    </form>
</div>
<?php elseif($exist === 0): ?>
    <div class="container-empty">
        <h2>There is no course with this id!</h2>
    </div>
<?php else: ?>
<div class="container-empty">
    <h2>You have no access to this page!</h2>
</div>
<?php endif; ?>

<?php include("app/include/footer.php"); ?>
</body>
</html>
