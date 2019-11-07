<?php
require_once 'init.php';

if(!$currentUser)
{
    header('Location:index.php');
    exit();
}

$content=$_POST['content'];
if(!empty(trim($content)))
{
    createPost($currentUser['id'],$content);
}
header('Location:index.php');