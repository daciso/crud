<?php
$errors="";
if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["search"])){
  $se=$_GET['search'];
  if (empty($se)) $errors = "DEVI CERCARE QUALCOSA!!!";
  else{
  $pdo = new PDO('mysql:host=localhost;port=3306;dbname=digishop', 'root', '');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $statement = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$se%'");
  $statement->execute();
  $products = $statement->fetchAll(PDO::FETCH_ASSOC);
}
}
else{
  
session_start();

//Inseriamo i dati del Database
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=digishop', 'root', '');

//Attiviamo gli errori
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Preparo la query 
$statement = $pdo->prepare('SELECT * FROM products ORDER BY created_at DESC');

//Eseguo la query
$statement->execute();

//Ottengo il risultato
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

//Stampo i risultati in un array

//var_dump($products);
}
//
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once "views/head.php" ?>

<body>
  <?php include_once "views/navbar.php" ?>
  <main>
    <div class="container mt-5">
    <?php if(!empty($errors)):?>
        <div class="alert alert-danger" role="alert">
        <?php echo $errors;?>
        </div>
        <?php endif;?>

    <?php if(!empty($_SESSION["new_creation"])):?>
        <div class="alert alert-success" role="alert">
        <?php echo $_SESSION["new_creation"];?>
        <?php unset($_SESSION["new_creation"]);?>
        </div>
        <?php endif;?>
        <?php if(!empty($_SESSION["delete_product"])):?>
          <div class="alert alert-danger" role="alert">
        <?php echo $_SESSION["delete_product"];?>
        <?php unset($_SESSION["delete_product"]);?>
        </div>

        <?php endif;?>

      <table class="table table-striped border">
        <thead class="bg-primary text-light">
          <tr>
            <th scope="col">SKU</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Availibility</th>
            <th scope="col">Discount</th>
            <th scope="col">Image</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (isset($products)): ?>
          <?php foreach ($products as $product) : ?>
            <tr>
              <th scope="row"><?php echo $product["sku"] ?></th>
              <td><?php echo $product["name"]; ?></td>
              <td><?php echo $product["price"] ; ?></td>
              <td><?php echo $product["availability"]; ?></td>
              <td><?php echo $product["discount"] ; ?></td>
              <td><?php if(!empty($product["image"])) : ?>
                <img class="image_list" src="<?php echo $product["image"] ?>"  alt="<?php echo $product["sku"]?> ">
                <?php endif; ?>
                </td>
           <td>
           <a class="btn btn-outline-primary btn-sm" href="update.php?sku=<?php echo $product["sku"]?>"><span><i class="fa-solid fa-pen mr-2"></i>Edit</span></a>
            <a class="btn btn-outline-danger btn-sm" href="delete.php?sku=<?php echo $product["sku"]?>"><span><i class="fa-solid fa-trash mr-2"></i></i>Delete</span></a>
           </td>
         </tr>
         <tr>
         <?php endforeach;?>
         <?php endif;?>
       </tbody>
     </table>
     </div>   

    </main>

  <?php include_once "views/footer.php" ?>

  <?php include_once "views/scripts.php" ?>
</body>

</html>