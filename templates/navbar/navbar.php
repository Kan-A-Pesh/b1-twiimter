<nav>
    <a href="/">
        <img src="/img/icon.png" alt="icon" width="50" height="50">
    </a>

    <div class="buttons">
        <?php if ($_AUTH === null) : ?>
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        <?php else : ?>
            <a href="/logout">Logout</a>
            <a href="/profile">Profile</a>
        <?php endif; ?>
    </div>
</nav>