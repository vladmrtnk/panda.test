<?php require_once APP_ROOT . '/views/parts/header.php' ?>

    <main class="container">
        <div class="row mb-2">
            <div class="mb-3 d-flex justify-content-between">
                <h3>Polls:</h3>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Votes</th>
                    <th scope="col">Handle</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($polls)): ?>
                <?php /** @var array $polls */ ?>
                <?php foreach ($polls as $poll): ?>
                <tr>
                    <th scope="row"><?= $poll['title'] ?></th>
                    <td><?= $poll['created_at'] ?></td>
                    <td><?= $poll['votes'] ?></td>
                    <td><a href="<?= URL_ROOT . '/dashboard/poll/vote/' . $poll['id'] ?>" class="btn btn-primary">Vote</a></td>
                </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </main>

<?php require_once APP_ROOT . '/views/parts/footer.php' ?>