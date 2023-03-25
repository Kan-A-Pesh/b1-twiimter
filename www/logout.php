<?php include __DIR__ . '/../api/includes.php';

if ($_AUTH !== null) {
    $sessId = $_AUTH["session"]->getId();
    Session::delete($sessId);
    setcookie("session_id", "", time() - 3600, "/");
}

header("Location: /");
