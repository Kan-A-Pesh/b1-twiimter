<?php include __DIR__ . '/../api/includes.php';

if (!empty($_GET["u"])) {
    $user = User::get($_GET["u"]);

    // Handle errors
    if ($user === 500) {
        die('Internal server error');
    } else if ($user === 404) {
        $error = 'User not found';
    }
} else if ($_AUTH !== null) {
    $user = $_AUTH["user"];
} else {
    $user = null;
    $error = 'User not found';
}

?>
<!DOCTYPE html>
<html>

<head>
    <?php include __DIR__ . '/../templates/headers/head.php'; ?>

    <link rel="stylesheet" href="/css/pages/profile.css" />
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar/navbar.php'; ?>

    <?php if (isset($error)) : ?>
        <h1 class="error"><?= $error ?></h1>
        <?php die(); ?>
    <?php endif; ?>

    <div class="banner">
        <img src="<?= parseMedia($user->banner_path) ?? "/img/pearl.png" ?>" alt="Banner" />
    </div>
    <div class="avatar">
        <img src="<?= parseMedia($user->avatar_path) ?? "/img/icon.png" ?>" alt="Avatar" width="120" />

    </div>
    <div class="info">
        <div class="names">
            <h1><?= $user->display_name ?></h1>
            <h2>@<?= $user->handle ?></h2>
        </div>
        <?php if ($_AUTH !== null && $_AUTH["user"]->handle === $user->handle) : ?>
            <a href="/settings" class="button">Edit profile</a>
        <?php endif; ?>
    </div>
    <?php if (!empty($user->biography)) : ?>
        <div class="bio">
            <p><?= parseText($user->biography ?? "") ?></p>
        </div>
    <?php endif; ?>
    <hr>
    <div class="posts">
        <?php
        $posts = Post::get_all(
            null,
            $user,
            null,
            null,
            null,
            25,
            0
        );

        if (count($posts) === 0) {
            echo '<h1 class="error">No posts found</h1>';
        } else {
            foreach ($posts as $post) {
                include __DIR__ . '/../templates/post/post.php';
            }
        }
        ?>
    </div>

    <?php include __DIR__ . '/../templates/forms/postform.php'; ?>
</body>

</html>