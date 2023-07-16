<?php require_once APP_ROOT . '/views/parts/header.php' ?>

    <main class="container">
        <div class="row mb-2">
            <div class="mb-3 d-flex justify-content-between">
                <?php /** @var \App\Models\Poll $poll */ ?>
                <h3><?= $poll->title ?></h3>
                <div>
                    <a href="<?= URL_ROOT . '/dashboard/poll/create' ?>" class="btn btn-primary">Create poll</a>
                </div>
            </div>

            <form action="<?= URL_ROOT . '/dashboard/poll/' . $poll->id . '/store' ?>" method="POST">
                <?php foreach($poll->getQuestions() as $questionId => $question): ?>
                <h5><?= $question['title'] ?></h5>
                <?php foreach($question['answers'] as $answerId => $answer): ?>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="<?= $questionId ?>" value="<?= $answerId ?>" id="answer-<?= $answerId ?>">
                    <label class="form-check-label" for="answer-<?= $answerId ?>">
                        <?= $answer['title'] ?>
                    </label>
                </div>
                <?php endforeach; endforeach; ?>

                <button class="btn btn-primary" type="submit">Submit</button>
            </form>
        </div>
    </main>

<?php require_once APP_ROOT . '/views/parts/footer.php' ?>