<!DOCTYPE html>

<html>

    <head>

        <!-- http://getbootstrap.com/ -->
        <link href="/css/bootstrap.min.css" rel="stylesheet"/>

        <link href="/css/styles.css" rel="stylesheet"/>

        <?php if (isset($title)): ?>
            <title>Health+: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>Health+</title>
        <?php endif ?>

        <!-- https://jquery.com/ -->
        <script src="/js/jquery-1.11.3.min.js"></script>

        <!-- http://getbootstrap.com/ -->
        <script src="/js/bootstrap.min.js"></script>

        <script src="/js/scripts.js"></script>

    </head>

    <body>

        <div class="container">

            <div id="top" name = "top">
                <div>
                    <a href="/"><img alt="Health+" src="/img/logo.png"/></a>
                </div>
                <?php if (!empty($_SESSION["id"])): ?>
                    <div class="menu-wrap">
                        <nav class="menu">
                            <ul class="clearfix" class="nav nav-pills">
                                <li><a href="index.php">Home</a></li>
                                <li>
                                    <a href="food_log.php">Food Log <span class="arrow">&#9660;</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="food_log.php">All Food</a></li>
                                        <li><a href="nutrition.php">Food History</a></li>
                                    </ul>
                                </li>
                                <li><a href="search.php">Search</a></li>
                                <li><a href="recommendations.php">Recommendations</a></li>
                                <li><a href="help.php">Help</a></li>
                                <li>
                                    <a href="/">My Account <span class="arrow">&#9660;</span></a>
                                    <ul class="sub-menu">
                                        <li><a href="change_password.php">Change Password</a></li>
                                        <li><a href="logout.php">Log Out of <?= $_SESSION["username"]?></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                <?php endif ?>
            </div>

            <div id="middle">
            <span id = "warning" class = "error"></span>
