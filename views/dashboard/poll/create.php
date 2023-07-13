<?php require_once APP_ROOT . '/views/parts/header.php' ?>

    <main class="container">
        <div class="d-flex justify-content-center">
            <form class="w-75 p-5 border rounded" method="POST" enctype="multipart/form-data" action="<?php echo URL_ROOT . '/dashboard/poll' ?>">

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input name="title" type="text" class="form-control <?php echo \App\Components\Message::hasErrors(INVALID_POLL_TITLE) ? 'is-invalid' : ''?>" id="title" placeholder="Input the title of poll" value="<?php echo \App\Components\FormData::getOldData('title') ?? '' ?>" required>
                    <?php echo \App\Components\Message::show(INVALID_POLL_TITLE); ?>
                </div>

                <div id="questions">
                    <div class="mb-3 p-3 border rounded question" data-question-id="1">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-3">
                                <label for="title" class="form-label">Question</label>
                                <button class="btn btn-danger remove-question">x</button>
                            </div>
                            <input name="questions[1][title]" type="text" class="form-control" placeholder="Input the question">
                        </div>

                        <p>Answers:</p>

                        <div class="mb-3" id="answers-q-1">
                            <div class="d-flex gap-1 mb-2 answer" data-answer-id="1">
                                <input type="text" name="questions[1][answers][]" class="form-control" placeholder="Input the variant of answer">
                                <button class="btn btn-danger remove-answer">x</button>
                            </div>
                            <div class="d-flex gap-1 mb-2 answer" data-answer-id="2">
                                <input type="text" name="questions[1][answers][]" class="form-control" placeholder="Input the variant of answer">
                                <button class="btn btn-danger remove-answer">x</button>
                            </div>
                        </div>

                        <button class="btn btn-secondary" id="add-answer">Add answer</button>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button class="btn btn-secondary" id="add-question">Add question</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </main>

<?php require_once APP_ROOT . '/views/parts/footer.php' ?>