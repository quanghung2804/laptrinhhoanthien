<?php
require_once '../config/config.php';
if(is_admin()){header('Location:index.php');exit;}
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $u=trim($_POST['username']??'');$p=$_POST['password']??'';
    $st=db()->prepare("SELECT * FROM admins WHERE username=? AND password_hash=?");$st->execute([$u,hash('sha256',$p)]);$a=$st->fetch();
    if($a){$_SESSION['admin_id']=$a['id'];$_SESSION['admin_name']=$a['full_name'];header('Location:index.php');exit;}
    $error='Sai tài khoản hoặc mật khẩu.';
}
$page_title='Đăng nhập quản trị';require '../includes/header.php';
?>
<section class="container section narrow"><div class="admin-login"><p class="eyebrow">ADMIN PANEL</p><h1>Đăng nhập</h1><?php if($error):?><div class="alert"><?=$error?></div><?php endif;?><form method="post" class="checkout-form"><input name="username" placeholder="Tài khoản" required><input type="password" name="password" placeholder="Mật khẩu" required><button class="btn btn-dark">Đăng nhập</button></form><p class="muted">Demo: admin / admin123</p></div></section>
<?php require '../includes/footer.php'; ?>
