<?php
require_once '../config/config.php';require_admin();$pdo=db();
if($_SERVER['REQUEST_METHOD']==='POST'){$st=$pdo->prepare("UPDATE orders SET status=? WHERE id=?");$st->execute([$_POST['status'],(int)$_POST['id']]);header('Location: orders.php');exit;}
$orders=$pdo->query("SELECT * FROM orders ORDER BY id DESC")->fetchAll();$page_title='Quản lý đơn hàng';require '../includes/header.php';
?>
<section class="container section"><div class="admin-top"><div><p class="eyebrow">ORDERS</p><h1>Quản lý đơn hàng</h1></div><a class="btn btn-outline" href="index.php">← Dashboard</a></div>
<div class="table-wrap"><table><tr><th>Mã</th><th>Khách hàng</th><th>SĐT</th><th>Tổng</th><th>Trạng thái</th><th>Ngày</th></tr><?php foreach($orders as $o):?><tr><td>#<?=$o['id']?></td><td><?=e($o['customer_name'])?><br><small><?=e($o['address'])?></small></td><td><?=e($o['phone'])?></td><td><?=money($o['total'])?></td><td><form method="post"><input type="hidden" name="id" value="<?=$o['id']?>"><select name="status" onchange="this.form.submit()"><?php foreach(['Mới','Đang xử lý','Đang giao','Hoàn thành','Đã hủy'] as $s):?><option <?= $o['status']===$s?'selected':''?>><?=$s?></option><?php endforeach;?></select></form></td><td><?=e($o['created_at'])?></td></tr><?php endforeach;?></table></div></section>
<?php require '../includes/footer.php'; ?>
