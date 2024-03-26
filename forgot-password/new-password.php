<?php require_once "controllerUserData.php"; ?>
<?php 
$email = $_SESSION['email'];
if($email == false){
 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create a New Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form id="change-password-form" action="controllerUserData.php" method="POST" autocomplete="off">
                    <h2 class="text-center">New Password</h2>
                    <?php 
                    if(isset($_SESSION['info'])){
                        ?>
                        <div class="alert alert-success text-center">
                            <?php echo $_SESSION['info']; ?>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if(count($errors) > 0){
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <input class="form-control" type="hidden" name="email" value="<?php  echo $email ?>">

                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control" type="password" id="new_password" name="new_password" placeholder="Create new password" required maxlength="6">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required maxlength="6">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input class="form-control button" type="submit" name="change-password" value="Change">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("toggleNewPassword").addEventListener("click", function () {
            togglePasswordVisibility("new_password", "toggleNewPassword");
        });

        document.getElementById("toggleConfirmPassword").addEventListener("click", function () {
            togglePasswordVisibility("confirm_password", "toggleConfirmPassword");
        });

        function togglePasswordVisibility(passwordFieldId, buttonId) {
            var passwordField = document.getElementById(passwordFieldId);
            var buttonIcon = document.querySelector("#" + buttonId + " i");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                buttonIcon.classList.remove("fa-eye");
                buttonIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                buttonIcon.classList.remove("fa-eye-slash");
                buttonIcon.classList.add("fa-eye");
            }
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("change-password-form").addEventListener("submit", function (event) {
                var newPassword = document.getElementById("new_password").value;
                var confirmPassword = document.getElementById("confirm_password").value;

                if (newPassword !== confirmPassword) {
                    alert("Password and Confirm Password do not match!");
                    event.preventDefault();
                }
            });
        });
    </script>

</body>
</html>
