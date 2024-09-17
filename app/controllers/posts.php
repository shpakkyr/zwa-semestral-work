<?php
/**
 * Set the error reporting and display settings.
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Variables for course details.
 */
$name = '';
$category = '';
$creator = '';
$title = '';
$content = '';
$benefit1 = '';
$benefit2 = '';
$benefit3 = '';
$errMsg = '';
$categoryErr = '';
$nameErr = '';
$creatorErr = '';
$titleErr = '';
$overviewErr = '';
$benefit1Err = '';
$benefit2Err = '';
$benefit3Err = '';


/**
 * Check if multiple fields are empty.
 *
 * @param string $name
 * @param string $creator
 * @param string $title
 * @param string $content
 * @param string $benefit1
 * @param string $benefit2
 * @param string $benefit3
 * @param string $category
 *
 * @return bool
 */
function isEmpty($name, $creator, $title, $content, $benefit1, $benefit2, $benefit3, $category) : bool
{
    if($name === '' || $creator === '' || $title === '' || $content === '' || $benefit1 === '' || $benefit2 === '' || $benefit3 === '' || $category === '' || $category === '-')
    {
        return true;
    }
    return false;
}

/**
 * Check the length of multiple fields and set corresponding error messages.
 *
 * @param string $name
 * @param string $creator
 * @param string $title
 * @param string $content
 * @param string $benefit1
 * @param string $benefit2
 * @param string $benefit3
 * @param string $category
 */
function lengthCheck($name, $creator, $title, $content, $benefit1, $benefit2, $benefit3, $category) : void
{
    global $nameErr, $creatorErr, $titleErr, $overviewErr, $benefit1Err, $benefit2Err, $benefit3Err, $categoryErr;

    if(strlen($name) < 10)
    {
        $nameErr = "Name must be at least 10 chars long!";
    }
    elseif(strlen($name) > 30)
    {
        $nameErr = "Name must be less than 30 chars!";
    }
    if(strlen($creator) < 10)
    {
        $creatorErr = "Creator field must be at least 10 chars long!";
    }
    elseif(strlen($creator) > 30)
    {
        $creatorErr = "Creator field must be less than 30 chars!";
    }
    if(strlen($title) < 10)
    {
        $titleErr = "Title must be at least 10 chars long!";
    }
    elseif(strlen($title) > 30)
    {
        $titleErr = "Title must be less than 30 chars!";
    }
    if(strlen($content) < 50)
    {
        $overviewErr = "Description must be at least 50 chars long!";
    }
    elseif(strlen($content) > 999)
    {
        $overviewErr = "Description must be less than 1000 chars!";
    }
    if(strlen($benefit1) < 10)
    {
        $benefit1Err = "Benefit must be at least 10 chars long!";
    }
    elseif(strlen($benefit1) > 30)
    {
        $benefit1Err = "Benefit must be less than 30 chars!";
    }
    if(strlen($benefit2) < 10)
    {
        $benefit2Err = "Benefit must be at least 10 chars long!";
    }
    elseif(strlen($benefit2) > 30)
    {
        $benefit2Err = "Benefit must be less than 30 chars!";
    }
    if(strlen($benefit3) < 10)
    {
        $benefit3Err = "Benefit must be at least 10 chars long!";
    }
    elseif(strlen($benefit3) > 30)
    {
        $benefit3Err = "Benefit must be less than 30 chars!";
    }
    if($category === '-')
    {
        $categoryErr = "Choose your category!";
    }
}

/**
 * Check if fields have valid lengths.
 *
 * @param string $name
 * @param string $creator
 * @param string $title
 * @param string $content
 * @param string $benefit1
 * @param string $benefit2
 * @param string $benefit3
 * @param string $category
 *
 * @return bool
 */
function fixCheck($name, $creator, $title, $content, $benefit1, $benefit2, $benefit3, $category) : bool
{

    if(strlen($name) < 10)
    {
        return false;
    }
    elseif(strlen($name) > 30)
    {
        return false;
    }
    if(strlen($creator) < 10)
    {
        return false;
    }
    elseif(strlen($creator) > 30)
    {
        return false;
    }
    if(strlen($title) < 10)
    {
        return false;
    }
    elseif(strlen($title) > 30)
    {
        return false;
    }
    if(strlen($content) < 50)
    {
        return false;
    }
    elseif(strlen($content) > 999)
    {
        return false;
    }
    if(strlen($benefit1) < 10)
    {
        return false;
    }
    elseif(strlen($benefit1) > 30)
    {
        return false;
    }
    if(strlen($benefit2) < 10)
    {
        return false;
    }
    elseif(strlen($benefit2) > 30)
    {
        return false;
    }
    if(strlen($benefit3) < 10)
    {
        return false;
    }
    elseif(strlen($benefit3) > 30)
    {
        return false;
    }
    if($category === '-')
    {
        return false;
    }
    return true;
}


/**
 * <p>Creates a course after passing all the validation</p>
 */
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create-button']))
{
    $name = $_POST['course-name'];
    $category = $_POST['category'];
    $creator = $_POST['creator-name'];
    $title = $_POST['job-title'];
    $content = $_POST['course-overview'];
    $benefit1 = $_POST['course-benefits1'];
    $benefit2 = $_POST['course-benefits2'];
    $benefit3 = $_POST['course-benefits3'];
    $img = $_FILES['preview-img']['name'];

    lengthCheck($name, $creator, $title, $content, $benefit1, $benefit2, $benefit3, $category);

    if(isEmpty($name, $creator, $title, $content, $benefit1, $benefit2, $benefit3, $category))
    {
        $errMsg = "Fields mustn't be empty!";
    }
    elseif(!fixCheck($name, $creator, $title, $content, $benefit1, $benefit2, $benefit3, $category))
    {
        $errMsg = "Fix the errors!";
    }
    else
    {
        $user = $_SESSION['id_user'];
        if($img !== '') {
            $target_dir = "uploads/";
            $fileExtension = pathinfo($_FILES["preview-img"]["name"], PATHINFO_EXTENSION);

            $uniqueId = uniqid("img_", true);

            $newFileName = $uniqueId . "." . $fileExtension;
            $img = $newFileName;

            $uploadDirectory = "uploads/";

            $target_file = $uploadDirectory . $newFileName;
            if (!move_uploaded_file($_FILES["preview-img"]["tmp_name"], $target_file)) {
                $errMsg = "Sorry, your file was not uploaded.";
            }
        }
        else{
            $img = "default_pic.jpeg";
        }
        $post = ['id_user' => $user, 'name' => $name, 'category' => $category, 'creator' => $creator, 'title' => $title, 'description' => $content, 'benefit1' => $benefit1,
            'benefit2' => $benefit2, 'benefit3' => $benefit3, 'img' => $img];
        $id = insert('posts', $post);
        header("location: courses-list.php");
    }
}

/**
 * <p>Redirects a user to courses list after clicking on cancel button of creation course</p>
 */
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel-button']))
{
    header("location: courses-list.php");
}

/**
 * <p>Fill the input fields after clicking on edit course button</p>
 */
if($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($_GET['id']) || isset($_GET['my-id'])))
{
    $id = 0;
    if(isset($_GET['my-id']))
    {
        $_SESSION['flag'] = 0;
        $id = $_GET['my-id'];
    }
    elseif(isset($_GET['id']))
    {
        $_SESSION['flag'] = 1;
        $id = $_GET['id'];
    }
    $post = selectOne('posts', ['id_course' => $id]);
    if(!empty($post))
    {
        $name = $post['name'];
        $category = $post['category'];
        $creator = $post['creator'];
        $title = $post['title'];
        $content = $post['description'];
        $benefit1 = $post['benefit1'];
        $benefit2 = $post['benefit2'];
        $benefit3 = $post['benefit3'];
    }
}

/**
 * <p>Deletes the course</p>
 */
if($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($_GET['delete-id']) || isset($_GET['my-delete-id'])))
{
    if(isset($_GET['delete-id']))
    {
        $id = $_GET['delete-id'];
    }
    else
    {
        $id = $_GET['my-delete-id'];
    }
    $post = selectOne('posts', ['id_course' => $id]);
    $name = $post['name'];
    delete('posts', $id, 'id_course');
    if(isset($_GET['delete-id']))
    {
        header("location: index-posts.php");
    }
    else{
        header("location: my-courses.php");
    }
}

/**
 * <p>Cancel and redirect course after my courses or admin panel</p>
 */
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel-edit-button']))
{
    if($_SESSION['flag'] === 1)
    {
        header("location: index-posts.php");
    }
    else{
        header("location: my-courses.php");
    }
}

/**
 * <p>Editing course in my courses or admin panel</p>
 */
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit-edit-button']))
{
    $id = $_POST['id'];
    $name = $_POST['course-name'];
    $category = $_POST['category'];
    $creator = $_POST['creator-name'];
    $title = $_POST['job-title'];
    $content = $_POST['course-overview'];
    $benefit1 = $_POST['course-benefits1'];
    $benefit2 = $_POST['course-benefits2'];
    $benefit3 = $_POST['course-benefits3'];
    $img = $_FILES['preview-img']['name'];

    lengthCheck($name, $creator, $title, $content, $benefit1, $benefit2, $benefit3, $category);

    if($name === '' || $creator === '' || $title === '' || $content === '' || $benefit1 === '' || $benefit2 === '' || $benefit3 === '')
    {
        $errMsg = "Field mustn't be empty!";
    }
    elseif(!fixCheck($name, $creator, $title, $content, $benefit1, $benefit2, $benefit3, $category))
    {
        $errMsg = "Fix the errors!";
    }
    else
    {
        $existence = selectOne('posts', ['id_course' => $id]);
        $user = $existence['id_user'];
        if($img !== '') {
            $target_dir = "uploads/";
            $fileExtension = pathinfo($_FILES["preview-img"]["name"], PATHINFO_EXTENSION);

            $uniqueId = uniqid("img_", true);

            $newFileName = $uniqueId . "." . $fileExtension;
            $img = $newFileName;

            $target_file = $target_dir . $newFileName;
            if (!move_uploaded_file($_FILES["preview-img"]["tmp_name"], $target_file)) {
                $errMsg = "Sorry, your file was not uploaded.";
            }
        }
        else{
            $img = "default_pic.jpeg";
        }
        $post = ['id_user' => $user, 'name' => $name, 'category' => $category, 'creator' => $creator, 'title' => $title, 'description' => $content, 'benefit1' => $benefit1,
            'benefit2' => $benefit2, 'benefit3' => $benefit3, 'img' => $img];
        update('posts', $post, $id, 'id_course');
        if($_SESSION['flag'] === 1)
        {
            header("location: index-posts.php");
        }
        else{
            header("location: my-courses.php");
        }
    }
}