<?php include __DIR__ . '/../api/includes.php';

if ($_AUTH !== null) {
    header('Location: /');
    die();
}

if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $handle = $_POST['handle'] ?? null;
    $password = $_POST['password'] ?? null;
    $remember = $_POST['remember'] ?? null;

    if ($handle === null || $password === null) {
        $error = 'Invalid username or password';
    } else {
        $user = User::get($handle);

        if ($user === 500) {
            $error = 'Internal server error';
        } else if ($user === 404) {
            $error = 'Invalid username or password';
        } else {
            if (!Cypher::verify($password, $user->get_password_hash())) {
                $error = 'Invalid username or password';
            } else {
                $session = Session::create(
                    $user->handle,
                    $_SERVER['REMOTE_ADDR'],
                    $_SERVER['HTTP_USER_AGENT'],
                    $remember === 'on'
                );

                if ($session === 500) {
                    $error = 'Internal server error';
                } else {
                    setcookie(
                        'session_id',
                        $session->getId(),
                        $session->expires_at->getTimestamp(),
                        '/',
                        '',
                        true,
                        true
                    );
                }

                header('Location: /');
                die();
            }
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <?php include __DIR__ . '/../templates/headers/head.php'; ?>

    <link rel="stylesheet" href="/css/pages/login.css">
</head>

<body>
    <?php include __DIR__ . '/../templates/navbar/navbar.php'; ?>

    <form action="" method="POST">
        <div class="modal">
            <h1>Login</h1>

            <hr>

            <input type="hidden" name="action" value="login">

            <div class="input-group">
                <label for="handle"><b>Username</b></label>
                <input type="text" placeholder="Enter username" name="handle" required>
            </div>

            <div class="input-group">
                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>
            </div>

            <hr>

            <div class="input-check">
                <input type="checkbox" checked="checked" name="remember">
                <label for="remember">Remember me</label>
            </div>

            <button type="submit">Login</button>

            <p>Don't have an account? <a href="/register">Register</a>.</p>

            <?php if (isset($error)) { ?>
                <p class="error"><?= $error ?></p>
            <?php } ?>
        </div>
</body>

</html>