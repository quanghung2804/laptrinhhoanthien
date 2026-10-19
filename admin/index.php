<?php
require_once '../config/config.php';require_admin();$pdo=db();$page_title='Quản trị';
$products=(int)$pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();$orders=(int)$pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();$revenue=(float)$pdo->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE status<>'Đã hủy'")->fetchColumn();$customers=(int)$pdo->query("SELECT COUNT(*) FROM customers")->fetchColumn();
$recent=$pdo->query("SELECT * FROM orders ORDER BY id DESC LIMIT 8")->fetchAll();require '../includes/header.php';
?>
<section class="page-banner"><div class="container"><p class="eyebrow">ADMIN DASHBOARD</p><h1>Xin chào, <?=e($_SESSION['admin_name'])?></h1><p>Quản lý website Hưng Yến.</p></div></section>
<section class="container section"><div class="stats"><div><small>Sản phẩm</small><b><?=$products?></b></div><div><small>Đơn hàng</small><b><?=$orders?></b></div><div><small>Doanh thu</small><b><?=money($revenue)?></b></div><div><small>Khách hàng</small><b><?=$customers?></b></div></div>
<div class="admin-actions"><a class="btn btn-dark" href="products.php">Quản lý sản phẩm</a><a class="btn btn-outline" href="orders.php">Quản lý đơn hàng</a><a class="btn btn-outline" href="logout.php">Đăng xuất</a></div>
<h2>Đơn hàng gần đây</h2><div class="table-wrap"><table><tr><th>Mã</th><th>Khách hàng</th><th>Tổng</th><th>Trạng thái</th><th>Ngày</th></tr><?php foreach($recent as $o):?><tr><td>#<?=$o['id']?></td><td><?=e($o['customer_name'])?></td><td><?=money($o['total'])?></td><td><?=e($o['status'])?></td><td><?=e($o['created_at'])?></td></tr><?php endforeach;?></table></div></section>
<?php require '../includes/footer.php'; ?>
