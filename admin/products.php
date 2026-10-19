<?php
require_once '../config/config.php';require_admin();$pdo=db();
if(isset($_GET['delete'])){$id=(int)$_GET['delete'];$pdo->prepare("DELETE FROM products WHERE id=?")->execute([$id]);header('Location: products.php');exit;}
if($_SERVER['REQUEST_METHOD']==='POST'){
 $id=(int)($_POST['id']??0);$name=trim($_POST['name']);$cat=(int)$_POST['category_id'];$price=(float)$_POST['price'];$stock=(int)$_POST['stock'];$desc=trim($_POST['description']);$feat=isset($_POST['is_featured'])?1:0;
 if($id){$st=$pdo->prepare("UPDATE products SET category_id=?,name=?,price=?,stock=?,description=?,is_featured=? WHERE id=?");$st->execute([$cat,$name,$price,$stock,$desc,$feat,$id]);}
 else{$st=$pdo->prepare("INSERT INTO products(category_id,name,price,stock,description,is_featured) VALUES(?,?,?,?,?,?)");$st->execute([$cat,$name,$price,$stock,$desc,$feat]);}
 header('Location: products.php');exit;
}
$edit=null;if(isset($_GET['edit'])){$st=$pdo->prepare("SELECT * FROM products WHERE id=?");$st->execute([(int)$_GET['edit']]);$edit=$st->fetch();}
$products=$pdo->query("SELECT p.*,c.name category_name FROM products p JOIN categories c ON c.id=p.category_id ORDER BY p.id DESC")->fetchAll();$cats=$pdo->query("SELECT * FROM categories")->fetchAll();
$page_title='Quản lý sản phẩm';require '../includes/header.php';
?>
<section class="container section"><div class="admin-top"><div><p class="eyebrow">PRODUCTS</p><h1>Quản lý sản phẩm</h1></div><a class="btn btn-outline" href="index.php">← Dashboard</a></div>
<div class="admin-form"><h2><?=$edit?'Sửa sản phẩm':'Thêm sản phẩm'?></h2><form method="post" class="form-grid"><input type="hidden" name="id" value="<?=$edit['id']??0?>"><input name="name" placeholder="Tên sản phẩm" value="<?=e($edit['name']??'')?>" required><select name="category_id"><?php foreach($cats as $c):?><option value="<?=$c['id']?>" <?=isset($edit)&&$edit['category_id']==$c['id']?'selected':''?>><?=e($c['name'])?></option><?php endforeach;?></select><input type="number" name="price" placeholder="Giá" value="<?=$edit['price']??''?>" required><input type="number" name="stock" placeholder="Tồn kho" value="<?=$edit['stock']??''?>" required><textarea name="description" placeholder="Mô tả"><?=e($edit['description']??'')?></textarea><label><input type="checkbox" name="is_featured" <?=!empty($edit['is_featured'])?'checked':''?>> Nổi bật</label><button class="btn btn-dark">Lưu sản phẩm</button></form></div>
<div class="table-wrap"><table><tr><th>ID</th><th>Sản phẩm</th><th>Danh mục</th><th>Giá</th><th>Tồn</th><th>Thao tác</th></tr><?php foreach($products as $p):?><tr><td><?=$p['id']?></td><td><?=e($p['name'])?></td><td><?=e($p['category_name'])?></td><td><?=money($p['price'])?></td><td><?=$p['stock']?></td><td><a href="?edit=<?=$p['id']?>">Sửa</a> · <a onclick="return confirm('Xóa sản phẩm này?')" href="?delete=<?=$p['id']?>">Xóa</a></td></tr><?php endforeach;?></table></div></section>
<?php require '../includes/footer.php'; ?>
