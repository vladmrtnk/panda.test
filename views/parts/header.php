<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>poller.online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"></head>

    <script src="<?= URL_ROOT . '/js/jquery.js' ?>"></script>
<body>

<div class="container">
    <header class="d-flex justify-content-between py-3 gap-2">
        <h1><a href="<?= URL_ROOT . '/dashboard' ?>" class="link-info"><?= SITE_NAME ?></a></h1>

        <div>
            <?php if (!isset($_SESSION[AUTHENTICATED_USER]) || !$_SESSION[AUTHENTICATED_USER]): ?>
                <a href="<?= URL_ROOT . '/login' ?>" class="btn btn-outline-primary">Sign-in</a>
                <a href="<?= URL_ROOT . '/register' ?>" class="btn btn-primary">Sign-up</a>
            <?php else: ?>
                <a href="<?= URL_ROOT . '/dashboard/poll' ?>" class="btn btn-primary">My polls</a>
                <a href="<?= URL_ROOT . '/dashboard/poll/create' ?>" class="btn btn-primary">Create poll</a>
                <a href="<?= URL_ROOT . '/logout' ?>" class="btn btn-outline-primary">Logout</a>
            <?php endif; ?>
        </div>
    </header>
</div>