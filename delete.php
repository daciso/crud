<?php 
session_start();

$active_sku = !empty($_GET["sku"]) ? htmlspecialchars($_GET["sku"]) : "";

if(empty($active_sku)){
   header("Localtion: index.php");
   exit;
}
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=digishop', 'root', '');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stats = $pdo->prepare('DELETE FROM products WHERE sku = :active_sku');
$stats->bindValue(':active_sku', $active_sku);
$stats->execute();

$_SESSION["delete_product"] = "A product with sku $active_sku was deleted!"; 

header("Location: index.php");

?>

<!DOCTYPE html>
<html lang="en"> :
   <body>
      <?php include_once "views/head.php" ?>
      <main>
      <?php if(!empty($_SESSION["delete_product"])):?>

      <?php endif;?>
      <div class="alert alert-success" role="alert">
      <?php echo $_SESSION["delete_product"];?>
      </div>
      </main>

   
   



<?php include_once "views/footer.php"?>
<?php include_once "views/scripts.php"?>
</body>
</html>