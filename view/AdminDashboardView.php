<div class="clearfix"></div>
<h1 class="page-title">Dashboard</h1>
<div class="clearfix"></div>

<div class="row">
    <div class="col-4 p-2">
        <div class="box box-success">
            <h3 class="text-white text-bold">Total Clicks</h3>
            <span class="text-white text-bold">All time</span>
            <h2 class="text-white text-bold"><?php echo $clicks; ?></h2>
        </div>
    </div>

    <div class="col-4 p-2">
        <div class="box box-blue">
            <h3 class="text-white text-bold">Visitors Today</h3>
            <span class="text-white text-bold">All time</span>
            <h2 class="text-white text-bold"><?php echo $users; ?></h2>
        </div>
    </div>

    <div class="col-4 p-2">
        <div class="box box-purple">
            <h3 class="text-white text-bold">Registered Users</h3>
            <span class="text-white text-bold">All Time</span>
            <h2 class="text-white text-bold"><?php echo $registered_users?></h2>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<h1 class="page-title">Tickets</h1>
<div class="clearfix"></div>

<div id="tableDiv">

    <table id="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Gender</th>
            <th>Country</th>
            <th>Message</th>
            <th>Reply</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (isset($tableBody)) echo $tableBody
        ?>
        </tbody>
    </table>

    <div id="reply-modal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <form id="reply-form">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Reply to: <span id="email"></span></h2>
                </div>
                <div class="modal-body">
                    <p style="color:red" id="error-message"></p>
                    <br/>
                    <p><b>Full name:</b> <span id="full-name"></span></p>
                    <p><b>Sex:</b> <span id="sex"></span></p>
                    <p><b>Message:</b> <span id="message"></span></p>
                    <br/>
                    <div class="form-cnt">
                        <input type="hidden" id="reply-id" name="reply-id"/>
                        <input type="hidden" name="reply-email" id="email-input"/>
                        <input name="reply_subject" placeholder="Subject"/>
                        <textarea name="reply_message" placeholder="Your message here"></textarea>
                    </div>
                    <br/>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-blue">Reply</button>
                </div>
            </form>

        </div>

    </div>

</div>

<div class="clearfix"></div>
<h1 class="page-title">Audits</h1>
<div class="clearfix"></div>
<div style="overflow-y: scroll; border:1px solid black; padding: 5px; height:150px; border-radius: 5px; margin-bottom: 25px;">
<?php
foreach($audits as $audit){
    echo $audit.'<hr>';
}
?>
</div>
<script>
    $(document).ready(function () {

        let data = <?php echo $json; ?>;

        function getArray(id) {
            for (let i = 0; i < data.length; i++) {
                if (data[i]["id"] == id) {
                    return data[i];
                }
            }
            return null;
        }

        $("[reply]").click(function () {
            let id = this.getAttribute("reply");

            let item = getArray(id);

            if (item != null) {
                $("#message").html(item["message"]);
                $("#email").html(item["email"]);
                $("#full-name").html(item["name"])
                $("#sex").html(item["sex"])
                $("#reply-id").val(id)
                $("#email-input").val(item["email"]);
            }

            $("#reply-modal").css("display", "block");
        });

        $("#reply-form").submit(function (e) {
            let data = $(this).serialize();
            $("#error-message").html("");
            $.post("AdminDashboard", data, function (data) {
                if (data.success === true) {
                    $("#error-message").css("color", "green").html("Reply sent successfully").delay(1000, function () {
                        $(".modal").hide();
                        $(".active").click().trigger();
                    });

                } else if (data.success === false) {
                    $("#error-message").html("There was an error while sending your reply");
                } else {
                    $("#error-message").html("There was an unexpected error while sending your reply");
                }
            });
            e.preventDefault();
        })

        $(".close").click(function () {
            $(".modal").hide();
        })

        $('#table').DataTable();

        $("[delete]").click(function (){
            var r = confirm("Are you sure you want to delete this contact?");
            if(r == true){
           var attrb = this.getAttribute("delete");
            $.post("contact/delete", "id="+attrb, function (data) {
                if (data.success === true) {
                    alertify.success(data.description);
                    this.html('<i class="fa fa-check"></i> Deleted');
                    this.removeClass('btn-danger');
                    this.addClass('btn-success');
                    this.prop('disabled', true);
                } else if (data.success === false) {
                    alertify.error(data.description);
                    this.html('<i class="fa fa-times"></i> Error');
                    this.prop('disabled', true);
                } else {
                    alertify.error("Unknown error happened!");
                    this.html('<i class="fa fa-times"></i> Error');
                    this.prop('disabled', true);
                }
            });
            e.preventDefault();
            }

        });
    });


</script>
