<div class="clearfix"></div>
<h1 class="page-title">Clients</h1>
<div class="clearfix"></div>

<div id="tableDiv">

    <table id="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Username</th>
            <th>Role</th>
            <th>Reply</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if(isset($tableBody)) echo $tableBody?>
        </tbody>
    </table>
</div>

<div id="edit-modal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <form id="user-form">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2>Edit User <span id="name"></span></h2>
            </div>
            <div class="modal-body">
                <p style="color:red" id="error-message"></p>
                <br/>

                <div class="form-cnt">
                    <input type="text" id="fullName" name="fullName" placeholder="Full Name"/>
                    <input type="hidden" id="id" name="id"/>
                    <input type="text" id="email" name="email" placeholder="E-mail"/>
                    <input type="text" id="username" name="username" placeholder="Username"/>
                    <select name="privilege" id="privilage">
                        <option value="0">Administrator</option>
                        <option value="1">User</option>
                    </select>
                    <input type="password" id="password" name="password" placeholder="Password"/>

                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-blue">Edit</button>
            </div>
        </form>

    </div>

</div>
<script>
    $(document).ready(function () {
        let data = <?php echo $json; ?>;
        $('#table').DataTable();
        $(".close").click(function (){
            $("#edit-modal").hide();
        });
        function getArray(id) {
            for (let i = 0; i < data.length; i++) {
                if (data[i]["id"] == id) {
                    return data[i];
                }
            }
            return null;
        }
        $("[edit]").click(function () {
            let id = this.getAttribute("edit");
            let item = getArray(id);
            if (item != null) {
                $("#fullName").val(item["full_name"]);
                $("#id").val(item["id"]);
                $("#name").html(item["full_name"]);
                $("#email").val(item["email"]);
                $("#username").val(item["username"]);
                $('#privilage option[value='+item["role"]+']').attr('selected','selected');
            }

            $("#edit-modal").css("display", "block");
        });

        $("#user-form").submit(function (e) {
            let data = $(this).serialize();
            $("#error-message").html("");
            $.post("user/edit", data, function (data) {
                if (data.success === true) {
                    $("#error-message").css("color", "green").html("Reply sent successfully").delay(1000, function () {
                        $(".modal").hide();
                        $(".active").click().trigger();
                    });

                } else if (data.success === false) {
                    $("#error-message").html(data.description);
                } else {
                    $("#error-message").html("There was an unexpected error while editing the user");
                }
            });
            e.preventDefault();
        })
        $("[delete]").click(function (){
           let id = this.getAttribute("delete");
           let cnfrm = confirm("Are you sure you want to delete this user?");
           if(cnfrm == true){
               $.post("user/delete", "id="+id, function (data) {
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
                       alertify.error("Some unexcepted error happened. Please try again later");
                       this.html('<i class="fa fa-times"></i> Error');
                       this.prop('disabled', true);
                   }
               });
           }
        });
    });

</script>