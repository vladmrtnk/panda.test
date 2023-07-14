<?php require_once APP_ROOT . '/views/parts/header.php'; ?>

    <main class="container">
        <div class="d-flex justify-content-center">
            <form class="w-50 p-5 border rounded" method="POST" action="<?= URL_ROOT . '/register' ?>">

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control <?= \App\Components\Message::hasErrors(INVALID_EMAIL) ? 'is-invalid' : ''?>" name="email" id="email" aria-describedby="emailHelp" value="<?= \App\Components\FormData::getOldData('email') ?? '' ?>">
                    <?= \App\Components\Message::show(INVALID_EMAIL); ?>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control <?= \App\Components\Message::hasErrors(INVALID_PASSWORDS) ? 'is-invalid' : ''?>" name="password" id="password">
                </div>

                <div class="mb-3">
                    <label for="second_password" class="form-label">Repeat Password</label>
                    <input type="password" class="form-control <?= \App\Components\Message::hasErrors(INVALID_PASSWORDS) ? 'is-invalid' : ''?>" name="second_password" id="second_password">
                    <?= \App\Components\Message::show(INVALID_PASSWORDS); ?>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </main>

<?php require_once APP_ROOT . '/views/parts/footer.php' ?>