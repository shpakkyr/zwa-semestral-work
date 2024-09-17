<?php
    require 'app/database/db.php';

$name = '';
$category = '';
$creator = '';
$title = '';
$content = '';
$benefit1 = '';
$benefit2 = '';
$benefit3 = '';
$img = '';

if (isset($_GET['id_course'])) {
    $courseDetails = selectOne('posts', ['id_course' => $_GET['id_course']]);

    if ($courseDetails) {
        $img = "uploads/" . $courseDetails['img'];
        $name = $courseDetails['name'];
        $category = $courseDetails['category'];
        $creator= $courseDetails['creator'];
        $title = $courseDetails['title'];
        $content = $courseDetails['description'];
        $benefit1 = $courseDetails['benefit1'];
        $benefit2 = $courseDetails['benefit2'];
        $benefit3 = $courseDetails['benefit3'];
    } else {
        header("Location: courses-list.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Course</title>
    <link rel="icon" type="image/x-icon" href="frontend/img/black.png">
    <link rel="stylesheet" href="frontend/css/header-footer.css">
	<link rel="stylesheet" href="frontend/css/course.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<body>
    <?php include("app/include/header.php"); ?>
	<section class="course-inner">
		<div class="overview">
			<img class='course-image' src="<?php echo $img; ?>" alt="">
			<div class="course-head">
				<div class="c-name">
					<h2><?=htmlspecialchars($name);?></h2>
                    <h2><?= $category; ?> category</h2>
				</div>
			</div>
			<h3>Creator:</h3>
			<div class="creator">
				<div class="creator-details">
					<h5><?=htmlspecialchars($creator);?></h5>
					<p><?=htmlspecialchars($title);?></p>
				</div>
			</div>
            <hr>
                <h3>Course Overview</h3>
                <p><?=htmlspecialchars($content);?></p>
			<hr>
			<h3>What you'll learn</h3>
			<div class="learn">
				<p><i class='fas fa-check-circle'></i><?=htmlspecialchars($benefit1);?></p>
				<p><i class='fas fa-check-circle'></i><?=htmlspecialchars($benefit2);?></p>
				<p><i class='fas fa-check-circle'></i><?=htmlspecialchars($benefit3);?></p>
			</div>
		</div>
	</section>
    <?php include("app/include/footer.php"); ?>
</body>
</html>