<?php
require_once 'init.php';

$posts=getNewFeeds();
 //Xử lý logic ở đây
 ?>
 <?php include 'header.php'; ?>

 <?php if($currentUser): ?>
<p>Chào mừng<strong> <?php echo $currentUser['displayName'];?> </strong>đã trở lại</p>

<form action="create-post.php" method="POST">
    <div class="form-group"> 
        <label for="content">Nội dung</label>
        <textarea class="form-control " name ="content" id="content"rows="3" ></textarea>
    </div>

    <button type="submit" class="btn btn-primary ">Đăng nội dung</button>
    
</form>

<div class="row"> 
    <?php foreach ($posts as $post): ?>
    <div class="col-sm-12">
        <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <p><?php echo $post['displayName']; ?></p>
                    <img style="width:100px;" class="card-img-top" src="avatars/<?php echo $post['userId']; ?>.jpg" alt="<?php echo $post['displayName']; ?>">
                    </h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $post['createdAt']; ?></h6>
                    <p class="card-text">
                        <?php echo $post['content']; ?>
                    </p>
                </div>
        </div>
    </div>
    <?php endforeach ?>
</div>

<?php else: ?>
<h1>chào mừng bạn đến với môn Web 1</h1>
<?php endif ?>
<?php include 'footer.php';?>