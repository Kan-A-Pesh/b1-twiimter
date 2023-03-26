<?php include __DIR__ . '/../../api/includes.php';
function dieError($message)
{
    die($message . "<br><a href='javascript:history.back()'>Go back</a>");
}

if ($_POST['action'] !== 'publish')
    dieError('Invalid action');

if ($_AUTH === null)
    dieError('You must be logged in to publish');

if (empty($_POST['content']))
    dieError('You must enter a content');

if (strlen($_POST['content']) > 500)
    dieError('Your content is too long');

$media_list = [];
if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === 0) {
    $file_base64 = base64_encode(file_get_contents($_FILES['image_file']["tmp_name"]));
    $file_ext = pathinfo($_FILES['image_file']["name"], PATHINFO_EXTENSION);
    $file_base64 = "data:image/$file_ext;base64,$file_base64";

    $file_media = new Media($file_base64, $file_ext);
    $file_snowflake = MediaSnowflake::generate($file_ext);

    $file_media->save($file_snowflake->toFile());
    $file_path = $file_snowflake->toString();

    $media_list[] = $file_path;
}

$reply_to = null;
if (!empty($_POST['reply-id'])) {
    $reply_to = $_POST['reply-id'];
}

$post = Post::create($_AUTH["user"]->handle, 0, $_POST['content'], $media_list, $reply_to);

if ($post === 500)
    dieError('An error occured while publishing your post');

header('Location: /');
