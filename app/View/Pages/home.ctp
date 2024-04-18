<div class="container">
	<nav class="nav mt-3">
		<li class="nav-item">
			<a class="nav-link active" href="<?= Router::url('/') ?>">Profile</a>
		</li>
		<li class="nav-item">
			<a class="nav-link disabled text-capitalize" href="<?= Router::url('/edit') ?>" tabindex="-1" aria-disabled="true">edit profile</a>
		</li>
		<li class="nav-item">
			<a class="nav-link disabled" href="<?= Router::url('/messages') ?>" tabindex="-1" aria-disabled="true">Messages</a>
		</li>
		<li class="nav-item">
			<a href="<?= Router::url('/logout') ?>" class="nav-link text-danger">Logout</a>
		</li>
	</nav>
	<div>
		<section>
			<legend>User Profile</legend>
			<div class="row mb-5">
				<div class="col-md-6">
					<img id="profileimg" src="" alt="" height="200" width="200">
				</div>
				<div class="col-md-6">
					<p id="name" class="h5 mb-4"></p>
					<p>Gender: <span id="gender"></span></p>
					<p>Birthdate: <span id="birthdate"></span></p>
					<p>Joined: <span id="joined_date"></span></p>
					<p>Last Login: <span id="last_login"></span></p>
				</div>
			</div>
			<div class="row d-flex flex-column justify-content-start w-25">
				<label for="hobby">Hobby</label>
				<textarea id="hobby" cols="40" rows="7" readonly style="resize:none;"></textarea>
			</div>
		</section>
	</div>
</div>
<?= $this->Html->script('jquery') ?>
<?= $this->Html->script('sweetalert') ?>
<?= $this->Html->script('datepicker') ?>
<script>
	const months = {
		'01': 'January',
		'02': 'February',
		'03': 'March',
		'04': 'April',
		'05': 'May',
		'06': 'June',
		'07': 'July',
		'08': 'August',
		'09': 'September',
		'10': 'October',
		'11': 'November',
		'12': 'December'
	};
	const datearrange = (date) => {
		let [y, m, d] = date.split('-');
		return `${months[m]} ${d}, ${y}`;
	}
	const timearrange = (time) => {
		let [h, i, s] = time.split(':');
		if (Number(h) > 11) {
			return `${Number(h) - 12}pm`;
		} else {
			return `${Number(h) === 0 ? '12':h}am`;
		}
	}
	const dateformatter = (datetime) => {
		let [d, t] = datetime.split(" ");
		// console.log(d);
		return `${datearrange(d)} ${timearrange(t)}`;
	}
	const getUserData = (id) => {
		$.getJSON(`<?= Router::url('/getuser') ?>?id=${id}`, function(data) {
			console.log(data);
			$("#name").html(data.name);
			$("#gender").html(data.gender === null ? 'Not set' : gender[data.gender]);
			$("#birthdate").html(data.birthdate === null ? 'Not set' : datearrange(data.birthdate));
			$("#joined_date").html(dateformatter(data.joined_date));
			$("#last_login").html(dateformatter(data.last_login));
			$("#hobby").val(data.hobby === null ? 'Not set' : data.hobby);
			$("#profileimg").attr('src', `./img/${data.img_name === null ? 'default.jpg' : data.img_name}`);
		});
	}
	const gender = {
		'm': 'Male',
		'f': 'Female'
	};

	$(document).ready(function() {
		const id = '<?= $id ?>';

		getUserData(id);

	});
</script>