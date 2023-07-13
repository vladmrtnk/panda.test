jQuery(document).ready(function ($) {
    $(document).on('click', 'button.remove-question', function (event) {
        if ($('div.question').length > 1) {
            $(this).closest('div.question').remove();
        }

        event.preventDefault();
    });

    $(document).on('click', 'button.remove-answer', function (event) {
        if ($(this).parent().siblings().length > 1) {
            $(this).parent().remove();
        }

        event.preventDefault();
    });

    $(document).on('click', 'button#add-answer', function (event) {
        let questionId = $(this).parent().attr('data-question-id');
        let answersContainer = $(`div#answers-q-${questionId}`);
        let lastAnswerId = parseInt(answersContainer.children().last().attr('data-answer-id'));

        answersContainer.append(
            `<div class="d-flex gap-1 mb-2 answer" data-answer-id="${lastAnswerId + 1}">
                <input type="text" name="questions[${questionId}][answers][]" class="form-control" placeholder="Input the variant of answer">
                <button class="btn btn-danger remove-answer">x</button>
            </div>`
        );

        event.preventDefault();
    });

    $(document).on('click', 'button#add-question', function (event) {
        let questionsContainer = $('div#questions');
        let questionId = parseInt(questionsContainer.children().last().attr('data-question-id')) + 1;

        questionsContainer.append(
            `<div class="mb-3 p-3 border rounded question" data-question-id="${questionId}">

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-3">
                        <label for="title" class="form-label">Question</label>
                        <button class="btn btn-danger remove-question">x</button>
                    </div>
                    <input name="questions[${questionId}][title]" type="text" class="form-control" placeholder="Input the question">
                </div>

                <p>Answers:</p>

                <div class="mb-3" id="answers-q-${questionId}">
                    <div class="d-flex gap-1 mb-2 answer" data-answer-id="1">
                        <input type="text" name="questions[${questionId}][answers][]" class="form-control" placeholder="Input the variant of answer">
                        <button class="btn btn-danger remove-answer">x</button>
                    </div>
                    <div class="d-flex gap-1 mb-2 answer" data-answer-id="1">
                        <input type="text" name="questions[${questionId}][answers][]" class="form-control" placeholder="Input the variant of answer">
                        <button class="btn btn-danger remove-answer">x</button>
                    </div>
                </div>
    
                <button class="btn btn-secondary" id="add-answer">Add answer</button>
            </div>`
        );

        event.preventDefault();
    });
});