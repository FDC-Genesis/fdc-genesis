<div class="container">
    <h1 class="mb-5">
        New Message
    </h1>

    <div style="width: 400px;">
        <div class="d-flex justify-content-between mb-3">
            <label for="to">To:</label>
            <select id="to" class="ch" data-placeholder="Search for recipent...">
                <option value=""></option>
            </select>
        </div>
        <div class="d-flex justify-content-between">
            <label for="message">Message:</label>
            <div>
                <textarea id="message" cols="35" rows="10" style="resize: none;" class="form-control mb-5"></textarea>
                <button class="btn btn-sm btn-dark" id="send">Send</button>
            </div>
        </div>
    </div>

</div>


<?= $this->Html->script('jquery') ?>
<?= $this->Html->script('sweetalert') ?>
<?= $this->Html->script('choosen') ?>

<script>
    $(document).ready(function() {
        $("#to").chosen({
            width: "300px"
        });

        const id = '<?= $id ?>';

        const getcontacts = (id) => {
            let option = "";
            $.getJSON(`<?= Router::url('/getcontacts') ?>?id=${id}`, function(data) {
                // console.log(data);
                if (data.length > 0) {
                    data.forEach((ele) => {
                        option +=
                            `
                                <option value="${ele['User'].id}">${ele['User'].name}</option>
                            `;
                    });
                    $("#to").append(option);
                    $("#to").trigger('chosen:updated');
                }
            });
        }
        getcontacts(id);

        $("#send").click(function() {
            const chars = '123456789qwertyuiopasdfghjklzxcvbnm'.split('');

            const countchars = $("#message").val().split('').reduce((count, ele) => {
                if (chars.includes(ele.toLowerCase())) {
                    count++;
                    return count;
                }
            }, 0);
            if ($("#to").val() !== '' && countchars > 0) {
                // alert('hello');
                $.post(`<?= Router::url(['controller' => 'messages', 'action' => 'sendmessage']) ?>`, {
                    Message: {
                        sender: id,
                        receiver: $("#to").val(),
                        content: $("#message").val()
                    }
                }, function(data) {
                    // console.log(data);
                    if (data[0] !== 'error') {
                        window.location.href = '<?= Router::url('/messages') ?>';
                    }
                }, 'json');
            }
        });
    });
</script>