<div class="container">
	<nav class="nav mt-3">
		<li class="nav-item">
			<a class="nav-link disabled" tabindex="-1" href="<?= Router::url('/') ?>">Profile</a>
		</li>
		<li class="nav-item">
			<a class="nav-link disabled text-capitalize" href="<?= Router::url('/edit') ?>" tabindex="-1" aria-disabled="true">edit profile</a>
		</li>
		<li class="nav-item">
			<a class="nav-link active" href="<?= Router::url('/messages') ?>" aria-disabled="true">Messages</a>
		</li>
		<li class="nav-item">
			<a href="<?= Router::url('/logout') ?>" class="nav-link text-danger">Logout</a>
		</li>
	</nav>
	<div>
		<div class="mb-5">
			<h1>Message List</h1>
			<a href="<?= Router::url('/newmessage') ?>" class="btn btn-sm btn-secondary text-end" style="right: 0;">New Message</a>
		</div>
		<ul class="row d-flex flex-column" id="convolist">

		</ul>
	</div>
</div>
<?= $this->Html->script('jquery') ?>
<?= $this->Html->script('sweetalert') ?>
<?= $this->Html->script('bootstrap') ?>

<script>
	$(document).ready(function() {
		const id = '<?= $id ?>';
		let listoffset = 1,
			listcounter = 0,
			deleted = 0;
		const datearrange = (datetime) => {
			let [d, t] = datetime.split(' ');
			let D = d.split('-').join('/');
			let T = t.split(':').splice(0, 2).join(':');

			return `${D} ${T}`;

		}

		function getconvolist(id, lo, lc, dltd) {
			let convolist = "";
			$.getJSON(`<?= Router::url('/convolist') ?>?id=${id}&offset=${lo}&counter=${lc}&deleted=${dltd}`, function(data) {
				// console.log(data);
				listcounter = data[0];
				if (data[1].length === 0) {
					convolist =
						`
						<li style="list-style: none; border: solid gray 1px; border-radius: 25px; gap: 0 30px;" class="p-2 d-flex mb-3">
							<div class="h5 text-secondary">
								No Conversations Yet!
							</div>
						</li>
					`;
				} else {
					data[1].forEach((ele) => {
						let convowith, imgname, name, lastmessage;
						// filter out
						if (ele.m.sender === id) {
							convowith = ele.m.receiver;
							imgname = ele.UserS.simg === null ? './img/default.jpg' : `./img/${ele.UserS.simg}`;
							name = ele.UserS.sname;
							lastmessage = ele.m.content;
						} else {
							convowith = ele.m.sender;
							imgname = ele.UserR.rimg === null ? './img/default.jpg' : `./img/${ele.UserR.rimg}`;
							name = ele.UserR.rname;
							lastmessage = `You: ${ele.m.content}`;
						}

						convolist +=
							`
							<li id="convo_${convowith}" style="list-style: none; border: solid gray 1px; border-radius: 25px; gap: 0 30px;" class="p-2 d-flex mb-3">
								<div class="goto_${convowith}">
									<img src="${imgname}" height="100" width="100" style="border-radius: 50%;">
								</div>
								<div>
									<div class="text-primary h5 goto_${convowith}">${name}</div>
									<div class="mb-2 goto_${convowith}">${lastmessage}</div>
									<div class="d-flex justify-content-start align-items-center" style="gap: 0 800px;">
										<div class="text-secondary goto_${convowith}" style="font-size: 10px;">${datearrange(ele.m.date)}</div>
										<div class="text-danger text-end" id="delete_${convowith}">Delete</div>
									</div>
								</div>
							</li>
						`;
					});
					if (listoffset < listcounter) {
						convolist += `<p class="text-center" id="showlist">Show More</p>`;
					}
				}
				$("#convolist").append(convolist);
				$("p[id='showlist']").click(function() {
					$(this).remove();
					listoffset++;
					getconvolist(id, listoffset, listcounter, deleted);
				});

				$("div[class*='goto_']").click(function() {
					// alert();
					const thisclass = $(this).attr("class").split(" ");
					const result = thisclass.find(item => item.startsWith('goto_')).split("_")[1];
					if (result !== undefined) {
						window.location.href = `<?= Router::url('/messagelist') ?>/${result}`;
					}

				});
				$("div[id^='delete_']").on('click mouseover mouseleave', function(e) {
					const thisid = $(this).attr("id").split("_")[1];
					if (e.type === 'click') {
						$(`#convo_${thisid}`).addClass('customdelete');
						$.ajax({
							url: '<?= Router::url('/deleteconvo') ?>',
							method: 'POST',
							data: {
								convowith: thisid
							},
							success: function(data) {
								if (data === 'success') {
									setTimeout(() => {
										$(`#convo_${thisid}`).remove();
									}, 1500);
									deleted++;
								} else {
									setTimeout(() => {
										$(`#convo_${thisid}`).removeClass('customdelete');
									}, 1500);
								}
								// console.log(data);
							}
						});
					} else if (e.type === 'mouseover') {
						$(this).addClass('bg-dark');
					} else if (e.type === 'mouseleave') {
						$(this).removeClass('bg-dark');
					}


				});
			});
		}

		getconvolist(id, listoffset, listcounter, deleted);
	});
</script>