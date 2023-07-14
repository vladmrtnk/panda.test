<?php require_once APP_ROOT . '/views/parts/header.php'; ?>

    <main class="container">
        <div class="d-flex justify-content-center">
            <form class="w-50 p-5 border rounded" method="POST" action="<?= URL_ROOT . '/login' ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Email address</label>
                    <input type="email" class="form-control <?= \App\Components\Message::hasErrors() ? 'is-invalid' : ''?>" name="email" id="name" aria-describedby="emailHelp" value="<?= \App\Components\FormData::getOldData('email') ?? '' ?>">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control <?= \App\Components\Message::hasErrors() ? 'is-invalid' : ''?>" name="password" id="password">
                    <?= \App\Components\Message::show(SIGN_IN_ERROR); ?>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </main>

<?php require_once APP_ROOT . '/views/parts/footer.php' ?>