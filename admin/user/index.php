<?php 
$user_result = $conn->query("SELECT * FROM users where id ='".$_settings->userdata('id')."'");
if ($user_result && $user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();
    foreach($user as $k => $v) {
        $meta[$k] = $v;
    }
} else {
    // Handle case where no user is found
    echo "User not found.";
    // You might want to consider redirecting the user or displaying an appropriate message.
}
?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
    <div class="card-body">
        <div class="container-fluid">
            <div id="msg"></div>
            <form action="" id="manage-user">  
                <input type="hidden" name="id" value="<?php echo $_settings->userdata('id') ?>">
                <div class="form-group">
                    <label for="name">First Name</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>" required maxlength="15" pattern="[A-Za-z]+" title="Only alphabetic characters are allowed">
                </div>
                <div class="form-group">
                    <label for="name">Last Name</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>" required maxlength="15" pattern="[A-Za-z]+" title="Only alphabetic characters are allowed">
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required autocomplete="off" maxlength="10" pattern="[A-Za-z0-9]+" title="Only alphabetic and numeric characters are allowed">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo isset($meta['email']) ? $meta['email']: '' ?>" required maxlength="35" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" value="" required maxlength="6" autocomplete="off">
                    <small><i>Leave this blank if you don't want to change the password.</i></small>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Avatar</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
                <div class="form-group d-flex justify-content-center">
                    <img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
                </div>
            </form>
        </div>
    </div>
    <div class="card-footer">
        <div class="col-md-12">
            <div class="row">
                <button class="btn btn-sm btn-primary" form="manage-user">Update</button>
            </div>
        </div>
    </div>
</div>
<style>
    img#cimg{
        height: 15vh;
        width: 15vh;
        object-fit: cover;
        border-radius: 100% 100%;
    }
</style>
<script>
    function displayImg(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cimg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#manage-user').submit(function (e) {
        e.preventDefault();
        var _this = $(this);
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var username = $('#username').val();
        var email = $('#email').val();

        // Regular expressions for validation
        var nameRegex = /^[A-Za-z]+$/;
        var usernameRegex = /^[A-Za-z0-9]+$/;

        // Validation checks
        if (!nameRegex.test(firstname) || !nameRegex.test(lastname)) {
            $('#msg').html('<div class="alert alert-danger">First name and last name should contain only alphabetic characters.</div>');
            $("html, body").animate({ scrollTop: 0 }, "fast");
            return;
        }
        if (!usernameRegex.test(username)) {
            $('#msg').html('<div class="alert alert-danger">Username should contain only alphabetic and numeric characters.</div>');
            $("html, body").animate({ scrollTop: 0 }, "fast");
            return;
        }
        if (username.length > 10) {
            $('#msg').html('<div class="alert alert-danger">Username should not exceed 10 characters.</div>');
            $("html, body").animate({ scrollTop: 0 }, "fast");
            return;
        }

        $.ajax({
            url: _base_url_ + 'classes/Users.php?f=save',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function (resp) {
                if (resp == 1) {
                    location.reload();
                } else {
                    $('#msg').html('<div class="alert alert-danger">Username already exists</div>');
                }
            }
        });
    });
</script>
