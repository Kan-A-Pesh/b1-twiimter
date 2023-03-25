<?php include __DIR__ . '/../api/includes.php';

if ($_AUTH === null) {
    header('Location: /login');
    die();
}

$user = $_AUTH["user"];

if (isset($_POST["action"]) && $_POST["action"] === "update") {
    $username = $_POST["display_name"];
    $biography = $_POST["bio"];
    $email = $_POST["email"];

    $avatar = $_FILES["avatar"] ?? null;
    $banner = $_FILES["banner"] ?? null;

    $avatar_path = null;
    $banner_path = null;

    if (isset($avatar) && $avatar["error"] === 0) {
        $avatar_base64 = base64_encode(file_get_contents($avatar["tmp_name"]));
        $avatar_ext = pathinfo($avatar["name"], PATHINFO_EXTENSION);
        $avatar_base64 = "data:image/$avatar_ext;base64,$avatar_base64";

        $avatar_media = new Media($avatar_base64, $avatar_ext);
        $avatar_snowflake = MediaSnowflake::generate($avatar_ext);

        $avatar_media->save($avatar_snowflake->toFile());
        $avatar_path = $avatar_snowflake->toString();
    }

    if (isset($banner) && $banner["error"] === 0) {
        $banner_base64 = base64_encode(file_get_contents($banner["tmp_name"]));
        $banner_ext = pathinfo($banner["name"], PATHINFO_EXTENSION);
        $banner_base64 = "data:image/$banner_ext;base64,$banner_base64";

        $banner_media = new Media($banner_base64, $banner_ext);
        $banner_snowflake = MediaSnowflake::generate($banner_ext);

        $banner_media->save($banner_snowflake->toFile());
        $banner_path = $banner_snowflake->toString();
    }

    $result = User::update(
        $user->handle,
        $username,
        $email,
        null,
        $biography,
        $avatar_path,
        $banner_path
    );

    if ($result === 404) {
        $error = 'User not found';
    } else if ($result === 409) {
        $error = 'Username or email already taken';
    } else if ($result === 500) {
        $error = 'Internal server error';
    } else {
        header('Location: /profile');
        die();
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <?php include __DIR__ . '/../templates/headers/head.php'; ?>

    <link rel="stylesheet" href="/css/pages/profile.css" />
    <link rel="stylesheet" href="/css/pages/settings.css" />
</head>

<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="update" />
        <?php include __DIR__ . '/../templates/navbar/navbar.php'; ?>

        <?php if (isset($error)) : ?>
            <h1 class="error"><?= $error ?></h1>
            <?php die(); ?>
        <?php endif; ?>

        <div class="banner">
            <img src="<?= parseMedia($user->banner_path) ?? "/img/pearl.png" ?>" alt="Banner" />
        </div>
        <input type="file" name="banner" id="banner" accept="image/*" />

        <div class="avatar">
            <img src="<?= parseMedia($user->avatar_path) ?? "/img/icon.png" ?>" alt="Avatar" width="120" />
            <input type="file" name="avatar" id="avatar" accept="image/*" />
        </div>

        <div class="info">
            <div class="input-group">
                <label for="handle">Handle</label>
                <input type="text" name="handle" id="handle" value="<?= $user->handle ?>" readonly disabled />
            </div>
            <div class="input-group">
                <label for="display_name">Username</label>
                <input type="text" name="display_name" id="display_name" value="<?= $user->display_name ?>" placeholder="How should we call you?" />
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?= $user->email ?>" placeholder="How should we contact you?" />
            </div>
        </div>
        <div class="bio">
            <div class="input-group">
                <label for="bio">Biography</label>
                <textarea name="bio" id="bio" cols="30" rows="10" placeholder="What's on your mind?"><?= $user->biography ?></textarea>
            </div>
        </div>

        <div class="confirm-group">
            <button type="submit">Save</button>
            <a class="button" href="/profile">Cancel</a>
        </div>
    </form>
</body>

</html>