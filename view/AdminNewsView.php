
<div class="clearfix"></div>
<h1 class="page-title">Add News</h1>
<div class="clearfix"></div>
<style>
.padding-10{
    padding: 10px;
}
</style>
<div class="row">
    <div class="col-12">

        <form class="form-cnt" id="addnews-form" onsubmit="return false">
            <input type="text" class="form-input" id="title" name="title" placeholder="Title" required>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-9" style="margin-right: 10px;">
                    <textarea name="content" id="content" rows="8" cols="80" placeholder="Description" required></textarea>
                </div>
                <div  onclick="document.getElementById('image').click();" class="col-3" style="cursor: pointer;">
                    <div class="box box-shadow full-height">
                        <div class="image-box">
                            <i class="fa fa-plus fa-4x"></i><br>
                            <span id="addimagetext">Add Image</span>
                        </div>
                    </div>
                </div>
            </div>
            <input type="file" id="image" name="image" accept="image/png, image/jpeg" style="display:none" required>
            <div class="clearfix"></div>
            <button type="submit" name="button" class="btn btn-darkblue btn-lg">Publish</button>
        </form>

    </div>
</div>

<div class="clearfix"></div>
<h1 class="page-title">News</h1>
<div class="clearfix"></div>

<?php echo $tableBody; ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#image").change(function (e){
            $("#addimagetext").html("Selected <span style='color:red;'>"+e.target.files[0].name+"</span>");
        });

        $("#addnews-form").submit(function (e){
            let title = $("#title").val();
            let content = $("#content").val();
            if ($('#image').get(0).files.length === 0) {
                alertify.error("You haven't selected any image, please select an image");
                return;
            }
            if(title == "" || title.length < 5){
                alertify.error("You need to write a title or the title needs to be longer than 5 characters");
                return;
            }
            if(content == "" || content.length < 6){
                alertify.error("You need to write the content of the article. The article needs to be more than 6 characters");
                return;
            }

            var fd = new FormData();
            var files = $('#image')[0].files[0];
            fd.append('file',files);
            fd.append('title', title);
            fd.append('content', content);
            $.ajax({
                url: 'News/add',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response.success == true){
                        alertify.success(response.description);
                        $('[open="News"').click();
                    }else if(response.success = false){
                        alertify.error(response.description);
                    }else{
                        alertify.error("Some unexpected error happened. Please try again later.");
                    }
                },
            });
            e.preventDefault();
        });


        $("[delete]").click(function() {
            let id = this.getAttribute("delete");
            var cnfrm = confirm("Are you sure you want to delete this news");
            if(cnfrm == true){
                $.post("News/delete", "id="+id, function (data) {
                    if (data.success === true) {
                        alertify.success(data.description);
                        $('[open="News"').click();
                    } else if (data.success === false) {
                        alertify.error(data.description);

                    } else {
                        alertify.error("Some unexcepted error happened. Please try again later");

                    }
                });
            }
        });
    });
</script>
