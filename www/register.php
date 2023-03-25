<?php include __DIR__ . '/../api/includes.php';

if ($_AUTH !== null) {
    header('Location: /');
    die();
}

if (isset($_POST['action']) && $_POST['action'] === 'register') {
    $handle = $_POST['handle'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($handle === null || $email === null || $password === null) {
        $error = 'Missing required fields';
    } else {
        $user = User::get($handle);

        if ($user === 500) {
            $error = 'Internal server error';
        } else if ($user !== 404) {
            $error = 'User already exists';
        } else {
            $passwordhash = Cypher::hash($password);
            $user = User::create($handle, $email, $passwordhash);

            if ($user === 500) {
                $error = 'Internal server error';
            } else {
                $session = Session::create(
                    $user->handle,
                    $_SERVER['REMOTE_ADDR'],
                    $_SERVER['HTTP_USER_AGENT'],
                    true
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
            <h1>Register</h1>

            <hr>

            <input type="hidden" name="action" value="register">

            <div class="input-group">
                <label for="handle"><b>Username</b></label>
                <input type="text" placeholder="Enter username" name="handle" required>
            </div>

            <div class="input-group">
                <label for="email"><b>Email</b></label>
                <input type="email" placeholder="Enter email" name="email" required>
            </div>

            <div class="input-group">
                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>
            </div>

            <hr>

            <button type="submit">Register</button>

            <p>Already have an account? <a href="/login">Login</a></p>

            <?php if (isset($error)) { ?>
                <p class="error"><?= $error ?></p>
            <?php } ?>
        </div>
</body>

</html>