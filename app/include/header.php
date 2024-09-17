<header>
    <nav class="header-links">
        <a href="index.php">
            <img class="logo" src="frontend/img/black.png" alt="">
        </a>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li>
                <a href="courses-list.php?page=1">Courses &#9662;</a>
                <ul class="dropdown-content">
                    <li><a href="courses-list.php?page=1">All</a></li>
                    <li><a href="courses-list.php?page=1&category=Fitness">Fitness</a></li>
                    <li><a href="courses-list.php?page=1&category=Body-building">Body-building</a></li>
                    <li><a href="courses-list.php?page=1&category=Cross-fit">Cross fit</a></li>
                    <li><a href="courses-list.php?page=1&category=Active">Active</a></li>
                </ul>
            </li>
            <li><a href="about.php">About us</a></li>
        </ul>
    </nav>
    <?php if (isset($_SESSION['id_user'])): ?>
            <ul class="profile">
                <li>
                    <a href="#" class="profile-username"><?php echo htmlspecialchars($_SESSION['username']); ?> &#9662;</a>
                    <ul class="dropdown-cont">
                        <?php if ((int)$_SESSION['admin'] === 1):?>
                            <li><a href="index-posts.php">Admin panel</a></li>
                        <?php endif; ?>
                        <li><a href="my-courses.php">My courses</a></li>
                        <li><a href="create-course.php">Create course</a></li>
                        <li><a href="change-password.php">Change password</a></li>
                        <li><a href="logout.php">Log out</a></li>
                    </ul>
                </li>
            </ul>
    <?php else: ?>
        <div class="authentication">
            <a href="signup.php">Sign up</a>
            <a href="login.php">Login</a>
        </div>
    <?php endif; ?>
</header>