<?php
require_once('./vendor/autoload.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function detectPage()
{
    $uri = $_SERVER['REQUEST_URI'];
    $parts = explode('/', $uri);
    $fileName = $parts[count($parts)-1];
    $parts = explode('.', $fileName);
    $page = $parts[0];
    return $page;
}
function  findUserByEmail($email)
{
    global $db ;
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ? ");
    $stmt->execute(array($email));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function  findUserByID($id)
{
    global $db ;
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ? ");
    $stmt->execute(array($id));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateUserPassword($id,$password)
{
    global $db ;
    $hashPassword=password_hash($password,PASSWORD_DEFAULT);
    $stmt =$db->prepare("UPDATE users set Password= ? Where id= ?");
    return $stmt->execute(array($hashPassword,$id));
}

function registerUsers($displayName,$email,$password)
{
    global $db, $BASE_URL;
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $code = generateRandomString(16);
    $stmt = $db->prepare("INSERT INTO users (displayName,email,Password,status,code) VALUES (?, ?, ?, ?, ?) ");
    $stmt->execute(array($displayName, $email, $hashPassword, 0, $code));
    $id =$db->lastInsertId();
    sendEmail($email, $displayName, 'Kích hoạt tài khoản', "Mã kích hoạt tài khoản của bạn là : <a href=\"$BASE_URL/active-acount.php?code=$code\">$BASE_URL/active-acount.php?code=$code</a>");
    return $id;
   
}

function updateUserProfile($id,$displayName)
{
    global $db;
    $stmt =$db->prepare("UPDATE users set displayName = ? Where id= ?");
    return $stmt->execute(array($displayName,$id));
}

function resizeImage($filename, $max_width, $max_height)
{
  list($orig_width, $orig_height) = getimagesize($filename);

  $width = $orig_width;
  $height = $orig_height;

  # taller
  if ($height > $max_height) {
      $width = ($max_height / $height) * $width;
      $height = $max_height;
  }

  # wider
  if ($width > $max_width) {
      $height = ($max_width / $width) * $height;
      $width = $max_width;
  }

  $image_p = imagecreatetruecolor($width, $height);

  $image = imagecreatefromjpeg($filename);

  imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);

  return $image_p;
}


function getNewFeeds(){
    global $db;
    $stmt = $db->query("SELECT p.*, u.displayName FROM posts AS p JOIN users AS u ON p.userId = u.id ORDER BY createdAt DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function createPost($userId, $content){
    global $db;
    $stmt = $db->prepare("INSERT INTO posts (content, userId) VALUES (? ,? )");
    $stmt->execute(array($content, $userId));
}


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
  function sendEmail($to, $name, $subject, $content) {
    global $EMAIL_FROM, $EMAIL_NAME, $EMAIL_PASSWORD;
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
    //Server settings
    $mail->isSMTP();                                            // Send using SMTP
    $mail->CharSet    = 'UTF-8';
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $EMAIL_FROM;                     // SMTP username
    $mail->Password   = $EMAIL_PASSWORD;                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to
    //Recipients
    $mail->setFrom($EMAIL_FROM, $EMAIL_NAME);
    $mail->addAddress($to, $name);     // Add a recipient
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $content;
    // $mail->AltBody = $content;
    $mail->send();
  }
  function activateUser($code) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE code = ? AND status = ?");
    $stmt->execute(array($code, 0));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && $user['code'] == $code) {
      $stmt = $db->prepare("UPDATE users SET code = ?, status = ? WHERE id = ?");
      $stmt->execute(array('', 1, $user['id']));
      return true;
    }
    return false;
  }
