
<?php 
if(isset($_GET['id']) && $_GET['id'] > 0){
    $user = $conn->query("SELECT * FROM users where id ='{$_GET['id']}'");
    foreach($user->fetch_array() as $k =>$v){
        $meta[$k] = $v;
    }
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
				<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
				<div class="form-group col-6">
    <label for="name">First Name</label>
    <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>" required maxlength="15" pattern="[A-Za-z]+" title="Only alphabetic characters are allowed">
</div>
<div class="form-group col-6">
    <label for="name">Last Name</label>
    <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>" required maxlength="15" pattern="[A-Za-z]+" title="Only alphabetic characters are allowed">
</div>
<div class="form-group col-6">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required autocomplete="off" maxlength="10" pattern="[A-Za-z0-9]+" title="Only alphabetic and numeric characters are allowed">
</div>
<div class="form-group col-6">
    <label for="middlename">Middle Name</label>
    <input type="text" name="middlename" id="middlename" class="form-control" value="<?php echo isset($meta['middlename']) ? $meta['middlename']: '' ?>" required maxlength="15" pattern="[A-Za-z]+" title="Only alphabetic characters are allowed">
</div>
<div class="form-group col-6">
    <label for="email">Email</label>
    <input type="text" name="email" id="email" class="form-control" value="<?php echo isset($meta['email']) ? $meta['email']: '' ?>" required maxlength="35" autocomplete="off">
</div>
<div class="form-group col-6">
    <label for="password">Password</label>
    <input type="password" name="password" id="password" class="form-control" value="" autocomplete="off" <?php echo isset($meta['id']) ? "": 'required' ?> maxlength="6">
    <?php if(isset($_GET['id'])): ?>
    <small class="text-info"><i>Leave this blank if you dont want to change the password.</i></small>
    <?php endif; ?>
</div>

				<div class="form-group col-6">
					<label for="type">User Type</label>
					<select name="type" id="type" class="custom-select"  required>
						<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected': '' ?>>Administrator</option>
						<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected': '' ?>>Staff</option>
					</select>
				</div>
				<div class="form-group col-6">
					<label for="" class="control-label">Avatar</label>
					<div class="custom-file">
		              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
		              <label class="custom-file-label" for="customFile">Choose file</label>
		            </div>
				</div>
				<div class="form-group col-6 d-flex justify-content-center">
					<img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary mr-2" form="manage-user">Save</button>
					<a class="btn btn-sm btn-secondary" href="./?page=user/list">Cancel</a>
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
    $(function(){
        $('.select2').select2({
            width:'resolve'
        })
    })

    function displayImg(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cimg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#manage-user').submit(function(e){
        e.preventDefault();
        var _this = $(this);
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var middlename = $('#middlename').val();
        var username = $('#username').val();

        // Regular expressions for validation
        var nameRegex = /^[A-Za-z]+$/;
        var usernameRegex = /^[A-Za-z0-9]+$/;

        // Validation checks
        if (!nameRegex.test(firstname) || !nameRegex.test(lastname) || !nameRegex.test(middlename)) {
            $('#msg').html('<div class="alert alert-danger">First name, last name, and middle name should contain only alphabetic characters.</div>');
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
            success: function(resp){
                if(resp == 1){
                    location.href = './?page=user/list';
                } else {
                    $('#msg').html('<div class="alert alert-danger">Username already exists</div>');
                    $("html, body").animate({ scrollTop: 0 }, "fast");
                }
            }
        });
    });
</script>

