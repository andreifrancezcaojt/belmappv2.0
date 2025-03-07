<?php
session_name('admin_session');
session_start();
include_once('../../includes/dbcon.php');

$email = $_SESSION['email'];
echo $email;

$pass = get("SELECT password from tbl_admin where email = '$email'");
$id = get("SELECT id from tbl_admin where email = '$email'");

if(isset($_POST['accId'])){

    $accId = $_POST['accId'];
    $email = $_POST['email'];
    $newPass = md5($_POST['password']);

    echo $accId .'<b>'. $email .'<br>'. $newPass;

    mysqli_query($conn, "UPDATE tbl_admin SET email = '$email', password = '$newPass' WHERE id = '$accId'");
}   

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
</head>
<body>
    <div class="container">
    <div class="card border-dark mb-3" style="max-width: 38rem;">
  <div class="card-header">Header</div>
  <div class="card-body text-primary">
  <form>
  <div class="form-group row">
    <input type="hidden" id="accId" value="<?php echo $id; ?>">
    <label for="email" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-10">
      <input type="text"  class="form-control" id="email" value="<?php echo $email;?>">
    </div><br><br>
  </div>
  <div class="form-group row">
    <label for="password" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="password" placeholder="Password" value="<?php echo $pass?>">
    </div>
    
  </div>
  <div style="margin-left: 518px; margin-top: 20px;">
    <a class="btn btn-success btn-sm" href="javascript:void(0)" onclick="edit_account();">Save</a>
  </div>
</form>
  </div>
    </div>
</body>
</html>