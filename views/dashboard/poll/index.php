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
                    <?php if (isset($_GET['sort_by']) && isset($_GET['sort_order'])): ?>
                    <th scope="col"><a href="<?= URL_ROOT . '/dashboard/poll/?sort_by=title'?><?= $_GET['sort_by'] == 'title' && $_GET['sort_order'] == 'asc' ? '&sort_order=desc' : '&sort_order=asc' ?>">Title</a></th>
                    <th scope="col"><a href="<?= URL_ROOT . '/dashboard/poll/?sort_by=published'?><?= $_GET['sort_by'] == 'published' && $_GET['sort_order'] == 'asc' ? '&sort_order=desc' : '&sort_order=asc' ?>">Published</a></th>
                    <th scope="col"><a href="<?= URL_ROOT . '/dashboard/poll/?sort_by=created_at'?><?= $_GET['sort_by'] == 'created_at' && $_GET['sort_order'] == 'asc' ? '&sort_order=desc' : '&sort_order=asc' ?>">Created At</a></th>
                    <?php else: ?>
                    <th scope="col"><a href="<?= URL_ROOT . '/dashboard/poll/?sort_by=title&sort_order=asc' ?>">Title</a></th>
                    <th scope="col"><a href="<?= URL_ROOT . '/dashboard/poll/?sort_by=published&sort_order=asc' ?>">Published</a></th>
                    <th scope="col"><a href="<?= URL_ROOT . '/dashboard/poll/?sort_by=created_at&sort_order=asc' ?>">Created At</a></th>
                    <?php endif; ?>
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