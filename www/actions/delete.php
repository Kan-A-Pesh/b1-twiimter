<?php include __DIR__ . '/../../api/includes.php';
function dieError($message)
{
    die($message . "<br><a href='javascript:history.back()'>Go back</a>");
}

if ($_POST['action'] !== 'delete')
    dieError('Invalid action');

if ($_AUTH === null)
    dieError('You must be logged in to delete');

if (empty($_POST['post_id']))
    dieError('You must enter a post id');

$post = Post::get($_POST['post_id']);

if ($post === 500)
    dieError('An error occured while liking/unliking your post');

if ($post === 404)
    dieError('Post not found');

if ($post->author->handle !== $_AUTH["user"]->handle)
    dieError('You can only delete your own posts');

$post = Post::delete($post->id);

if ($post === 500)
    dieError('An error occured while deleting your post');

header('Location: /');
