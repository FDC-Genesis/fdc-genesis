<div class="container mb-5">
	<nav class="nav mt-3">
		<li class="nav-item">
			<a class="nav-link disabled" href="<?= Router::url('/') ?>" tabindex="-1">Profile</a>
		</li>
		<li class="nav-item">
			<a class="nav-link active text-capitalize" href="<?= Router::url('/edit') ?>" aria-disabled="true">edit profile</a>
		</li>
		<li class="nav-item">
			<a class="nav-link disabled" href="<?= Router::url('/messages') ?>" tabindex="-1" aria-disabled="true">Messages</a>
		</li>
		<li class="nav-item">
			<a href="<?= Router::url('/logout') ?>" class="nav-link text-danger">Logout</a>
		</li>
	</nav>
	<div>
		<form action="<?= Router::url('/updateprofile') ?>" method="post" enctype="multipart/form-data">
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
			<legend>User Profile</legend>
			<div class="row mb-3">
				<div class="col-md-6">
					<img src="" alt="" height="200" width="200" id="profileimg">
					<label for="img" class="btn btn-sm btn-outline-dark">Upload Pic</label>
					<input type="file" accept="image/*" id="img" class="form-control w-50 mt-4 d-none" name="img">
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-md-6">
					<div class="d-flex justify-content-start mb-3" style="gap: 0 30px;">
						<label for="name" class="form-label">Name: </label>
						<input type="text" name="name" id="name" class="form-control w-75">
					</div>
					<div class="d-flex justify-content-start mb-3" style="gap: 0 30px;">
						<p>Gender:</p>
						<div>
							<label for="m" class="form-label">Male</label>
							<input type="radio" name="gender" id="m" value="m">
							<label for="f" class="form-label">Female</label>
							<input type="radio" name="gender" id="f" value="f">
						</div>
					</div>
					<div class="d-flex justify-content-start mb-3" style="gap: 0 30px;">
						<label for="birthdate" class="form-label">Birthdate: </label>
						<input type="text" name="birthdate" id="birthdate" class="form-control w-25">
					</div>
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-md-6">
					<div class="d-flex justify-content-start mb-3" style="gap: 0 30px;">
						<label for="hobby" class="form-label">Hobby</label>
						<textarea id="hobby" cols="40" rows="7" style="resize:none;" name="hobby"></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
			</div>
		</form>
	</div>
</div>
<?= $this->Html->script('jquery') ?>
<?= $this->Html->script('sweetalert') ?>
<?= $this->Html->script('datepicker') ?>

<script>
	const getUserData = (id) => {
		$.getJSON(`<?= Router::url('/getuser') ?>?id=${id}`, function(data) {
			// console.log(data);
			$("#name").val(data.name);
			if (data.gender !== null) {
				$(`#${data.gender}`).prop('checked', true);
			} else {
				$("#m").prop('checked', true);
			}
			$("#birthdate").val(data.birthdate === null ? '' : rearrangedate(data.birthdate));
			$("#hobby").val(data.hobby === null ? '' : data.hobby);
			$("#profileimg").attr('src', `./img/${data.img_name === null ? 'default.jpg' : data.img_name}`);
		});
	}

	const rearrangedate = (date) => {
		let [y, m, d] = date.split('-');
		let r = [m, d, y];
		return r.join('/');

	}
	$(document).ready(function() {
		const id = '<?= $id ?>';
		$("#birthdate").datepicker();

		$("#birthdate").change(function() {
			// alert(typeof $(this).val());
		});

		getUserData(id);

		$("#img").change(function(e) {
			let val = e.target;

			if (val.files && val.files[0]) {
				let view = new FileReader();

				view.onload = function(e) {
					$('#profileimg').attr('src', e.target.result);
				};

				view.readAsDataURL(val.files[0]);
			}
		});
	});
</script>