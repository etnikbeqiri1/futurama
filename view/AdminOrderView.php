<div class="clearfix"></div>
<h1 class="page-title">Orders</h1>
<div class="clearfix"></div>
<div id="tableDiv">

    <table id="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Project name</th>
            <th>Order Product</th>
            <th>Order Client</th>
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


<script>
    $(document).ready(function () {
        $('#table').DataTable();
        $("[delete]").click(function (){
            var r = confirm("Are you sure you want to delete this order ?");
            if(r == true) {
                let id = this.getAttribute("delete");
                $.post("Orders/delete", "id="+id, function (data) {
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
    });

</script>