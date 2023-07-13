<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"></head>

    <script src="<?= URL_ROOT . '/js/jquery.js' ?>"></script>
<body>

<div class="container">
    <header class="d-flex justify-content-between py-3">

        <div class="col-md-3 text-end">
            <?php if (!isset($_SESSION[AUTHENTICATED_USER]) || !$_SESSION[AUTHENTICATED_USER]): ?>
                <a href="<?php echo URL_ROOT . '/login' ?>" class="btn btn-outline-primary me-2">Sign-in</a>
                <a href="<?php echo URL_ROOT . '/register' ?>" class="btn btn-primary">Sign-up</a>
            <?php elseif($_SESSION[AUTHENTICATED_USER]): ?>
                <a href="<?php echo URL_ROOT . '/logout' ?>" class="btn btn-outline-primary me-2">Logout</a>
            <?php endif; ?>
        </div>

    </header>
</div>