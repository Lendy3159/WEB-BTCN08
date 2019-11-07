<?php
require_once 'init.php';
 ?>

<?php include 'header.php'; ?>
<h1>Đăng ký</h1>
<?php if(isset( $_POST['displayName']) && isset($_POST['email']) && isset($_POST['password'])): ?>
<?php
    $displayName = $_POST['displayName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $success=false;
    $user=findUserByEmail($email);

    if(!$user)
    {
        $newUserID =registerUsers($displayName,$email,$password);
        //$_SESSION['userID']= $newUserID;
        $success=true;
    }
?>
<?php if($success): ?>
<div class="alert alert-success" role="alert" >
    Vui lòng check mail để kích hoạt tài khoản
</div>
<?php else: ?>
<div class="alert alert-danger" role="alert" >
    Đăng ký thất bại
</div>
<?php endif; ?>
<?php else : ?>
<form action="register.php" method="POST">

    <div class="form-group"> 
        <label for="displayName">Tên đăng ký</label>
        <input type="text" class="form-control" id="displayName" name="displayName" placeholder="Tên đăng ký">
    </div>
    <div class="form-group"> 
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="abc@gmail.com">
    </div>

    <div class="form-group"> 
        <label for="password">Mật khẩu</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu">
    </div>
    <button type="submit" class="btn btn-primary">Đăng ký</button>

</form>
<?php endif; ?>
<?php include 'footer.php';?>