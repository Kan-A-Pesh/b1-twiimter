<article class="post">
    <div class="header">
        <img src="<?= parseMedia($post->author->avatar_path) ?? "/img/icon.png" ?>" alt="Avatar" width="40" />
        <a href="/profile/<?= $post->author->handle ?>">
            <h1>
                <?= $post->author->display_name ?>
            </h1>
            <span class="handle">
                @<?= $post->author->handle ?>
            </span>
        </a>
        <span class="date">
            <?= $post->created_at->format('d/m/Y') ?>
        </span>
    </div>
    <div class="content">
        <p>
            <?= parseText($post->content) ?>
        </p>
        <?php if (!empty($post->media_paths)) : ?>
            <img src="<?= parseMedia($post->media_paths[0]) ?>" alt="Media" />
        <?php endif; ?>
    </div>
    <div class="actions">
        <div class="input-group">
            <?php if ($_AUTH !== null) : ?>
                <form action="/actions/like.php" method="POST">
                    <input type="hidden" name="action" value="like" />
                    <input type="hidden" name="post_id" value="<?= $post->id ?>" />
                    <input type="submit" value="<?= Post::is_liked($post->id, $post->author->handle) ? "Unlike" : "Like" ?>" />
                </form>
            <?php endif; ?>
            <?= $post->likes ?> likes
        </div>

        <div class="input-group">
            <?php if ($_AUTH !== null) : ?>
                <input type="submit" value="Reply" onclick="publish('<?= $post->id ?>')" />
            <?php endif; ?>
            <a href="/?reply=<?= $post->id ?>"><?= count(Post::get_all(replyTo: $post->id)) ?> replies</a>
        </div>

        <?= $post->views ?> views

        <?php if ($_AUTH !== null && $_AUTH["user"]->handle === $post->author->handle) : ?>
            <div class="input-group">
                <form action="/actions/delete.php" method="POST">
                    <input type="hidden" name="action" value="delete" />
                    <input type="hidden" name="post_id" value="<?= $post->id ?>" />
                    <input type="submit" value="Delete" />
                </form>
            </div>
        <?php endif; ?>
    </div>
</article>