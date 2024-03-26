<?php 
session_start();
require "connection.php";
$email = "";
$errors = array();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';


//if user signup button

    //if user click continue button in forgot password form
    if (isset($_POST['check-email'])) {
       $email = mysqli_real_escape_string($con, $_POST['email']);
        $check_email = "SELECT * FROM users WHERE EMAIL ='$email'";
        $run_sql = mysqli_query($con, $check_email);
        if(mysqli_num_rows($run_sql) > 0){
            $code = rand(999999, 111111);
            $insert_code = "UPDATE users SET CODE = $code WHERE EMAIL = '$email'";
            $run_query =  mysqli_query($con, $insert_code);
            if($run_query){
                $subject = "Password Reset Code";
                $message = "Your password reset code is $code";
                $sender = "From: traineeacc8055@gmail.com";
                if(send_mail($email, $subject, $message, $sender)){
                    $info = "We've sent a password reset otp to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    header('location: reset-code.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Failed while sending code!";
                }
            }else{
                $errors['db-error'] = "Something went wrong!";
            }
        }else{
            $errors['email'] = "This email address does not exist!";
        }
        
    }

     //if user click check reset otp button
     if(isset($_POST['check-reset-otp'])){
        $_SESSION['info'] = "";
        $otp_code = mysqli_real_escape_string($con, $_POST['otp']);
        $check_code = "SELECT * FROM users WHERE CODE = $otp_code";
        $code_res = mysqli_query($con, $check_code);
        if(mysqli_num_rows($code_res) > 0){
            $fetch_data = mysqli_fetch_assoc($code_res);
            $email = $fetch_data['email'];
            $_SESSION['email'] = $email;
            $info = "Please create a new password that you don't use on any other site.";
            $_SESSION['info'] = $info;
            header('location: new-password.php?email='.$email);
            exit();
        }else{
            $errors['otp-error'] = "You've entered incorrect code!";
        }
    }

     
    if(isset($_POST['change-password'])){
        $_SESSION['info'] = "";
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Check if passwords match
        if($new_password !== $confirm_password){
            $errors['password'] = "Confirm password not matched!";
        } else {
            $code = 0;
            $email = $_POST['email'];
            $encpass = md5($new_password); // Hash the new password
    
            // Prepare and execute SQL query to update password
            $update_pass = "UPDATE users SET CODE = NULL, PASSWORD = '$encpass' WHERE EMAIL = '$email'";
            $update_result =  mysqli_query($con, $update_pass);
           
            
            // Check if password update was successful
         if($update_result){
              $info = "Your password changed. Now you can login with your new password.";
               $_SESSION['info'] = $info;
               header('Location: password-changed.php');
               exit(); // Terminate script execution after redirection
           } else {
               $errors['db-error'] = "Failed to change your password!";
           }
       }
    }

    

    if(isset($_POST['login-now'])){
        header('Location: ../index.php');
    }


function send_mail($sender,$subject,$message)
{

$mail = new PHPMailer();
$mail->IsSMTP();

$mail->SMTPDebug  = 0;  
$mail->SMTPAuth   = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port       = 587;
$mail->Host       = "smtp.gmail.com";
//$mail->Host       = "smtp.mail.yahoo.com";
$mail->Username   = "traineeacc8055@gmail.com";
$mail->Password   = "swgn lkck twcm mwzm";

$mail->IsHTML(true);
$mail->AddAddress($sender, "recipient-name");
$mail->SetFrom("traineeacc8055@gmail.com", "Forgot Password Code");
//$mail->AddReplyTo("reply-to-email", "reply-to-name");
//$mail->AddCC("cc-recipient-email", "cc-recipient-name");
$mail->Subject = $subject;
$content = $message;

$mail->MsgHTML($content); 
if(!$mail->Send()) {
  //echo "Error while sending Email.";
  //var_dump($mail);
  return false;
} else {
  //echo "Email sent successfully";
  return true;
}

}
?>