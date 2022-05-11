<?php
session_start();
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=digishop', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sku="";
$name="";
$price="";
$availability="";
$discount="";
$image="";
$errors= array();

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $sku = htmlspecialchars($_POST["sku"]);
    $name = htmlspecialchars($_POST["name"]);
    $price = htmlspecialchars($_POST["price"]);
    $availability = htmlspecialchars($_POST["availability"]);
    $discount = htmlspecialchars($_POST["discount"]);
    $image = !empty($_FILES["image"]["name"])? $_FILES["image"]["name"] : "" ;

   
    if (!is_dir('images')) {
        mkdir('images', 0777);
    }
    
    if (!empty($_FILES["image"]["name"])) {
        $tempDir = $_FILES["image"]["tmp_name"];
        $randDir = "images/" . uniqid();
        $endDir = $randDir . "/" . $_FILES["image"]["name"];
    
        mkdir($randDir);
    
        move_uploaded_file($tempDir, $endDir);
    }

    if(empty($sku)) {
      $errors[] = "SKU is required!";
  }

  if(empty($name)) {
      $errors[] = "Name is required!";
  }

  if(empty($price)) {
      $errors[] = "Price is required!";
  }
        
      
      
      

    //Creo una insert filtrando i campi con bindValue
    if(empty($errors)){
    $statment= $pdo->prepare("INSERT INTO products (sku, name, price,availability,discount,image) VALUES (:sku, :name, :price, :availability,:discount,:image)");

    $statment->bindValue(':sku', $sku);
    $statment->bindValue(':name', $name);
    $statment->bindValue(':price', $price);
    $statment->bindValue(':availability', $availability);
    $statment->bindValue(':discount', $discount);
    $statment->bindValue(':image', $endDir);

    $statment->execute();
    $_SESSION["new_creation"] = "A new product with SKU:" . $sku . " was created!";

header("location: index.php");

  } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once "views/head.php" ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php include_once "views/navbar.php" ?>

<main>
<div class="container my-5">
    <h2>Create Product</h2>

    <?php if(!empty($errors)):?>
            <div class="alert alert-danger" role="alert">
              <?php foreach ($errors as $error) :?>
                <div><?php echo $error?></div>
              <?php endforeach;?>
           </div>
         <?php endif;?>

         <form action="create.php" method="post" enctype="multipart/form-data">
         <div class="form-group">
         <label for="sku">SKU:</label>
         <input type="text" class="form-control" id="sku" name="sku" placeholder="Enter SKU" value="<?php echo $sku?>">
        </div>
        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?php echo $name?>">
        </div>
        <div class="form-group">
            <label class="form-check-label" for="price">Product Price</label>
            <input type="number" min="0" step="0.01" class="form-control" name="price" id="price" placeholder="Enter Price" value="<?php echo $price?>">
        </div>

        <div class="form-group">
            <label class="form-check-label" for="availability">Product Availability</label>
            <input type="number" min="0" step="1" class="form-control" name="availability" id="availability" placeholder="Enter Availability" value="<?php echo $availability?>">
        </div>

        <div class="form-group">
            <label class="form-check-label" for="discount">Product Discount</label>
            <input type="number" min="0" max="100" step="1" class="form-control" name="discount" id="discount" placeholder="Enter Discount" value="<?php echo $discount?>">
        </div>

        <div class="form-group">
            <label class="form-check-label" for="image">Product Image</label>
            <input type="file" class="form-control" name="image" id="image" >
        </div>


        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

   
</div>

</main>



<?php include_once "views/footer.php" ?>

  
<?php include_once "views/scripts.php" ?>
</body>
</html>