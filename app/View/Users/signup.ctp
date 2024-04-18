<div class="container d-flex justify-content-center align-items-center vh-100">
    <?= $this->Form->create('User', ['url' => '/signup', 'style' => 'border: solid black 1px; border-radius: 25px; box-shadow: 5px 5px skyblue;', 'class' => 'p-5']) ?>
    <legend>Register</legend>

    <div class="mb-3">
        <?= $this->Form->input('name', [
            'class' => 'form-control',
            'label' => [
                'text' => 'name',
                'class' => 'form-label text-capitalize'
            ]
        ]); ?>
    </div>
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
    <div class="mb-3">
        <?= $this->Form->input('confirm-password', [
            'class' => 'form-control', 'type' => 'password',
            'label' => [
                'text' => 'confirm password',
                'class' => 'form-label text-capitalize'
            ]
        ]); ?>
    </div>
    <div class="mb-3 d-flex justify-content-center align-items-center" style="gap: 0 20px;">
        <?= $this->Form->submit('Register', [
            'class' => 'btn btn-sm btn-primary'
        ]); ?>
        <div>

            <a href="<?= Router::url('/login') ?>">Sign In</a>
        </div>
    </div>
    <?= $this->Form->end() ?>

</div>
<?= $this->Html->script('jquery') ?>
<?= $this->Html->script('sweetalert') ?>
<script>
    $(document).ready(function() {
        <?php
        if (isset($_SESSION['registered'])) {
            $href = Router::url('/directlogin');
            echo "Swal.fire({
                        title: 'Thank you for registering',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Back to homepage',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '$href';
                        }
                    });";
            $_SESSION['direct'] = $_SESSION['registered']['email'];
            unset($_SESSION['registered']);
        } else {
            if (isset($_SESSION['direct'])) {
                unset($_SESSION['direct']);
            }
        }
        ?>
    })
</script>