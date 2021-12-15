<div class="clearfix"></div>
<h1 class="page-title">My Profile</h1>
<div class="clearfix"></div>
    <form id="myprofile-form">
        <div class="form-cnt">
            <input type="text" id="fullName" name="fullName" placeholder="Full Name" value="<?PHP echo $user->getFullName(); ?>"/>
            <input type="text" id="email" name="email" placeholder="E-mail" value="<?PHP echo $user->getEmail();?>"/>
            <input type="text" id="username" name="username" placeholder="Username" value="<?PHP echo $user->getUsername();?>"/>
            <input type="password" id="password" name="password" placeholder="Password"/>
            <div class="clearfix"></div>
            <button type="submit" class="btn btn-blue">Save</button>
        </div>
    </form>

<script type="text/javascript">
    $(document).ready(function () {

        $("#myprofile-form").submit(function(e) {
        let data = $(this).serialize();
    $.post("MyProfile/edit", data, function (data) {
            if (data.success === true) {
               alertify.success(data.description);
            } else if (data.success === false) {
               alertify.error(data.description);
            } else {
              alertify.error("There waas an unexpected error while editing the user");
            }
        });
        e.preventDefault();
    });
    });
</script>