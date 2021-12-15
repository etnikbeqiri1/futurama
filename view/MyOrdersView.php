<div class="clearfix"></div>
<h1 class="page-title">My Orders</h1>
<div class="clearfix"></div>
<button type="button" id="make-order" class="btn btn-blue">Make Order</button></td>
<div class="clearfix"></div>
<div id="tableDiv">

    <table id="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Project name</th>
            <th>Order Product</th>
            <th>Budget</th>
            <th>Status</th>
            <th>Reply</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($tableBody)) echo $tableBody ?>
        </tbody>
    </table>
</div>

<div id="edit-modal" class="modal">
    <div class="modal-content">
        <form id="make-order-form">
            <div class="modal-header">
                <span class="close">&#215;</span>
                <h2>Make Order <span id="name"></span></h2>
            </div>
            <div class="modal-body">
                <p style="color:red" id="error-message"></p>
                <br/>

                <div class="form-cnt">
                    <input type="text" name="product_name" placeholder="Product Name"/>
                    <input type="text" name="budget" placeholder="Budget Ex 100-200"/>

                    <select name="product"><?php if (isset($options)) echo $options ?></select>

                    <textarea type="text" name="description" placeholder="Description"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-blue" name="make-order" value="Order"/>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#table').DataTable();
        $("#make-order").click(function () {
            $("#edit-modal").css("display", "block");
        })

        $("#make-order-form").submit(function (e) {
            let data = $(this).serialize();

            $.post("MyOrders", data, function (data) {
                if (data.success === true) {
                    $(".active").click().trigger();
                } else if (data.success === false) {
                    $("#error-message").html("There was an error while sending your reply");
                } else {
                    $("#error-message").html("There was an unexpected error while sending your reply");
                }
            });
            e.preventDefault();
        });
        $("[delete]").click(function (){
            var r = confirm("Are you sure you want to delete this order ?");
            if(r == true) {
                let id = this.getAttribute("delete");
                $.post("MyOrders/delete", "id="+id, function (data) {
                    if (data.success === true) {
                        alertify.success(data.description);
                    } else if (data.success === false) {
                        alertify.error(data.description);
                    } else {
                        alertify.error("Unknown error happened!");
                    }
                });
            }

        });

        $("button[open]").click(function () {
            let url = this.getAttribute("open");
            console.log(url);
            $.get(url, function (data) {
                $("#container").html(data);
                $("#container").fadeIn(200);
            });
        })

        $(".close").click(function () {
            $(".modal").hide();
        })
    });

</script>