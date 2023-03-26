<?php if ($_AUTH !== null) { ?>

    <div class="post-button" onclick="publish(null)">
        <h1>+</h1>
    </div>

    <div class="post-form hidden">
        <form action="/actions/publish.php" method="POST">
            <div class="modal">
                <input type="hidden" name="action" value="publish" />
                <input type="hidden" name="reply-id" value="" id="reply-id" />

                <h1>Publish</h1>

                <textarea name="content" placeholder="What's on your mind?"></textarea>

                <div class="input-group">
                    <label for="file">Add an image:</label>
                    <input type="file" name="file" id="file" />
                </div>

                <div class="submit-group">
                    <button type="submit">Post</button>
                    <button type="button" class="button cancel">Cancel</button>
                </div>
            </div>
        </form>
    </div>

<?php } ?>