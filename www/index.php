<?php include __DIR__ . '/../api/includes.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <?php include __DIR__ . '/../templates/headers/head.php'; ?>

    <link rel="stylesheet" href="/css/pages/index.css" />
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar/navbar.php';

    $query = $_GET["q"] ?? null;
    $reply = $_GET["reply"] ?? "none";
    $order = ($_GET["order"] ?? "desc") == "desc" ? true : false;

    ?>
    <form action="" method="GET">
        <div class="search">
            <div class="search-group">
                <input type="text" name="q" placeholder="Search something..." value="<?= $_GET["q"] ?? "" ?>" />
                <div class="radio-selector">
                    <div class="radio-group">
                        <input type="radio" name="order" value="desc" id="desc" <?= $order ? "checked" : "" ?> />
                        <label for="desc">Newest</label>
                    </div>
                    <div class="radio-group">
                        <input type="radio" name="order" value="asc" id="asc" <?= $order ? "" : "checked" ?> />
                        <label for="asc">Oldest</label>
                    </div>
                </div>
            </div>
            <button type="submit">Search</button>
        </div>
    </form>

    <?php

    $posts = Post::get_all(
        $query,
        null,
        null,
        $reply,
        null,
        25,
        0,
        $order
    );

    if ($posts === 500) {
        echo "<h1 class='error'>Internal server error</h1>";
    } else if (count($posts) == 0) {
        echo "<h1 class='error'>No posts found</h1>";
    } else {
        if ($reply !== "none") {
            $post = Post::get($reply);

            if ($post === 500)
                echo "<h1 class='error'>Internal server error</h1>";
            else if ($post === 404)
                echo "<h1 class='error'>Origin post not found</h1>";
            else {
                include __DIR__ . '/../templates/post/post.php';
                echo "<h1 class='title'>Replies</h1>";
            }
        }

        foreach ($posts as $post) {
            include __DIR__ . '/../templates/post/post.php';
        }
    }
    ?>

    <?php include __DIR__ . '/../templates/forms/postform.php'; ?>
</body>

</html>