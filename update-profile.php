<?php
require_once 'init.php';

if(!$currentUser)
{
    header('Location:index.php');
    exit();
}
 ?>

<?php include 'header.php'; ?>
<h1>Cập nhật thông tin cá nhân</h1>
<?php if(isset($_POST['displayName'])): ?>
<?php
    $displayName = $_POST['displayName'];
    $success=false;
    
    if($displayName !='')
    {
        updateUserProfile($currentUser['id'],$displayName);
        $success =true;
    }

   if(isset($_FILES['avatar']))
    {
        $success=false;
        $file = $_FILES['avatar'];
        $fileName =  $file['name'];
        $fileSize =  $file['size'];
        $fileTemp =  $file['tmp_name'];
       
        $filePath= './avatars/' . $currentUser['id'].'.jpg';
        $success=move_uploaded_file($fileTemp,$filePath);
        $newImage=resizeImage($filePath,400,400);
        imagejpeg($newImage,$filePath);

    }
?>

<?php if($success): ?>
<?php header('Location: index.php'); ?>
<?php else: ?>
<div class="alert alert-danger" role="alert" >
    Cập nhật thất bại.....!
</div>

<?php endif; ?>
<?php else : ?>
<form action="update-profile.php" method="POST"  enctype="multipart/form-data" >

    <div class="form-group"> 
        <label for="displayName">Họ tên</label>
        <input type="text" class="form-control" id="displayName" name="displayName" placeholder="Họ tên"
        value="<?php echo $currentUser['displayName'];?> ">
    </div>

    <div class="form-group"> 
        <label for="avatar">Ảnh đại diện</label>
        <input type="file" class="file" id="avatar" name="avatar" >
    </div>
    
    <button type="submit" class="btn btn-primary">Cập nhật</button>

</form>
<?php endif; ?>
<?php include 'footer.php';?>