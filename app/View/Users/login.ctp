<div class="container d-flex justify-content-center align-items-center vh-100">
    <?= $this->Form->create('User', ['url' => '/login', 'style' => 'border: solid black 1px; border-radius: 25px; box-shadow: 5px 5px skyblue;', 'class' => 'p-5']) ?>
    <?php
    if (isset($_SESSION['validationErrors'])) {
    ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($_SESSION['validationErrors'] as $errors) {
                    foreach ($errors as $error) {
                        echo "<li>$error</li>";
                    }
                } ?>
            </ul>
        </div>
    <?php
        unset($_SESSION['validationErrors']);
    }
    ?>
    <legend>Login</legend>
    <div class="mb-3">
        <?= $this->Form->input('email', [
            'class' => 'form-control',
            'label' => [
                'text' => 'email',
                'class' => 'form-label text-capitalize'
            ]
        ]); ?>
    </div>
    <div class="mb-3">
        <?= $this->Form->input('password', [
            'class' => 'form-control', 'type' => 'password',
            'label' => [
                'text' => 'password',
                'class' => 'form-label text-capitalize'
            ]
        ]); ?>
    </div>
    <div class="mb-3 d-flex justify-content-center align-items-center" style="gap: 0 20px;">
        <?= $this->Form->submit('Login', [
            'class' => 'btn btn-sm btn-primary'
        ]); ?>
        <div>

            <a href="<?= Router::url('/signup') ?>">Register</a>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>