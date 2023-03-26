<?php include __DIR__ . '/../../api/includes.php';
function dieError($message)
{
    die($message . "<br><a href='javascript:history.back()'>Go back</a>");
}

if ($_POST['action'] !== 'like')
    dieError('Invalid action');

if ($_AUTH === null)
    dieError('You must be logged in to like/unlike');

if (empty($_POST['post_id']))
    dieError('You must enter a post id');

$post = Post::get($_POST['post_id']);

if ($post === 500)
    dieError('An error occured while liking/unliking your post');

if ($post === 404)
    dieError('Post not found');

if (Post::is_liked($post->id, $_AUTH["user"]->handle)) {
    $result = Post::unlike_post($post->id, $_AUTH["user"]->handle);
} else {
    $result = Post::like_post($post->id, $_AUTH["user"]->handle);
}

if ($result === 500)
    dieError('An error occured while liking/unliking your post');

header('Location: /');
