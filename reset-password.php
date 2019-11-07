<?php
require_once 'init.php';
 ?>

<?php include 'header.php'; ?>
<h1>Quên mật khẩu</h1>
<?php if(isset($_POST['username'])): ?>
<?php
    $username = $_POST['username'];
    $success=false;

    $user = findUserByEmail($email);

    if($user && $user['status'] ==1 && password_verify($password,$user['password']))
    {
        $success =true;
        $_SESSION['userID']=$user['id'];
    }
?>
<?php if($success): ?>
<<div class="alert alert-danger" role="alert" >
    Vui lòng kiểm tra mail để xác nhận
</div>
<?php else: ?>
<div class="alert alert-danger" role="alert" >
    Không thành công
</div>
<?php endif; ?>
<?php else : ?>
<form action="reset-password" method="POST">
    <div class="form-group"> 
        <label for="username">Email</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Tên tài khoản">
    </div>

    <button type="submit" class="btn btn-primary">Cài lại mật khẩu</button>


</form>
<?php endif; ?>
<?php include 'footer.php';?>