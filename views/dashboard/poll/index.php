<?php require_once APP_ROOT . '/views/parts/header.php' ?>

    <main class="container">
        <div class="row mb-2">
            <div class="mb-3 d-flex justify-content-between">
                <h3>My polls:</h3>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Published</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Handle</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($polls)): ?>
                <?php foreach ($polls as $poll): ?>
                <tr>
                    <th scope="row"><?= $poll['id'] ?></th>
                    <td><?= $poll['title'] ?></td>
                    <td><?= $poll['published'] ?></td>
                    <td><?= $poll['created_at'] ?></td>
                    <td>
                        <?php if(!$poll['published']): ?>
                        <button name="id" value="<?= $poll['id'] ?>" class="btn btn-primary" form="publish_form">Publish</button>
                        <?php endif; ?>
                        <a href="<?= URL_ROOT . '/dashboard/poll/' . $poll['id'] . '/delete' ?>" class="btn btn-danger">Remove</a>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </main>

<form class="d-none" action="<?= URL_ROOT . '/dashboard/poll/publish' ?>" method="POST" id="publish_form"></form>

<?php require_once APP_ROOT . '/views/parts/footer.php' ?>