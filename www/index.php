<?php include __DIR__ . '/../api/includes.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <?php include __DIR__ . '/../templates/headers/head.php'; ?>

    <link rel="stylesheet" href="/css/pages/index.css" />
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar/navbar.php'; ?>
    <form action="" method="GET">
        <div class="search">
            <div class="search-group">
                <input type="text" name="q" placeholder="Search something..." value="<?= $_GET["q"] ?? "" ?>" />
                <button type="submit">Search</button>
            </div>
            <div class="radio-selector">
                <div class="radio-group">
                    <input type="radio" name="order" value="desc" id="desc" checked />
                    <label for="desc">Newest</label>
                </div>
                <div class="radio-group">
                    <input type="radio" name="order" value="asc" id="asc" />
                    <label for="asc">Oldest</label>
                </div>
            </div>
        </div>
    </form>

    <?php
    $query = $_GET["q"] ?? "";
    $order = ($_GET["order"] ?? "desc") == "desc" ? true : false;

    $posts = Post::get_all(
        $query,
        null,
        null,
        null,
        null,
        25,
        0,
        $order
    );

    if (count($posts) == 0) {
        echo "<h1 class='error'>No posts found</h1>";
    } else {
        foreach ($posts as $post) {
            include __DIR__ . '/../templates/post/post.php';
        }
    }
    ?>

</body>

</html>