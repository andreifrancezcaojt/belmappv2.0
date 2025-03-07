<?php
session_name('admin_session');
session_start();
include_once('../../includes/dbcon.php');

if(isset($_GET['email'])){
  $email = $_GET['email'];
  $password = md5($_GET['password']);

  $q = mysqli_query($conn, "INSERT INTO tbl_admin (email, password) VALUES ('$email','$password')");

  if($q){
    echo '<h5 class="text-center">Admin Added Successfully!</h5>';
  }else{
    echo mysqli_error($conn);
  }
}
?>

<div class="container">

<h2>New Admin Account</h2>

    <form>
      <div class="mb-3 mt-3" id="add_admin">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password">
      </div>
      <div> 
        <center>
            <a href="javascript:void(0);" class="btn btn-success btn-sm text-center" onclick="add_admin()">Add account</a>
        </center>
      </div>
    </form>

</div>

