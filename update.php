<?php
session_start();

$active_sku = !empty($_GET["sku"]) ? htmlspecialchars($_GET["sku"]) : null;

if (empty($active_sku)) {
    header("Location: index.php");
    exit;
}

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=digishop', 'root', '');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stats = $pdo->prepare('SELECT * FROM products WHERE sku = :active_sku');
$stats->bindValue(':active_sku', $active_sku);
$stats->execute();

$product = $stats->fetch(PDO::FETCH_ASSOC);


$active_name = $product["name"];
$active_price = $product["price"];
$active_availability = $product["availability"];
$active_discount = $product["discount"];
$active_image = $product["image"];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = array();
    $sku_product = htmlspecialchars($_POST["sku-product"]);
    $name_product = htmlspecialchars($_POST["name-product"]);
    $price_product = htmlspecialchars($_POST["price-product"]);
    $availability = htmlspecialchars($_POST["disponibility"]);
    $discount = htmlspecialchars($_POST["discount-product"]);
    $image = $_FILES["image-product"]["name"];
    

    if (!is_dir('images')) {
        mkdir('images', 0777);
    }

    if (!empty($image)) {
        $tempdirectory = $_FILES["image-product"]["tmp_name"];
        $randomdirectry = "images/" . uniqid();
        $endirectory = $randomdirectry . "/" . $_FILES["image-product"]["name"];
        mkdir($randomdirectry);
        move_uploaded_file($tempdirectory, $endirectory);
    } else {
        $endirectory = $active_image;
    }

    if (empty($sku_product)) {
        $errors[] = "SKU is required!";
    }
    if (empty($name_product)) {
        $errors[] = "Name is required!";
    }
    if (empty($price)) {
        $errors[] = "Price is required!";
    }

        $statement = $pdo->prepare('UPDATE products SET sku = :sku, name = :name, price = :price, availability = :availability, discount= :discount, image= :image
        WHERE sku = :active_sku');

        $statement->bindValue(':sku', $sku_product);
        $statement->bindValue(':name', $name_product);
        $statement->bindValue(':price', $price_product);
        $statement->bindValue(':availability', $availability);
        $statement->bindValue(':discount', $discount);
        $statement->bindValue(':image', $endirectory);
        $statement->bindValue(':active_sku', $active_sku);
        $statement->execute();

        $_SESSION["update_product"] = "Il prodotto $sku_product è stato modificato!"; 
        header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once "views/head.php" ?>


<main>

<?php include_once "views/navbar.php" ?>
    <div class="container my-5 text-center">
        <h2>Update Product: <strong><?php echo $product["sku"]?></strong></h2>
        <h3>Product Image</h3>
        <?php if (!empty($product["image"])) : ?>
            <img src="<?php echo $product["image"] ?>" alt="<?php echo $product["sku"] ?>" class="imgsrc">
        <?php endif; ?>
        <form  method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="sku-product">Sku:</label>
                <input type="text" class="form-control" id="sku-product" name="sku-product" value="<?php echo $active_sku ?>">
            </div>
            <div class="form-group">
                <label for="name-product">Name:</label>
                <input type="text" class="form-control" id="name-product" name="name-product" value="<?php echo $active_name ?>">
            </div>
            <div class="form-group">
                <label for="price-product">Price:</label>
                <input type="number" min="1" class="form-control" id="price-product" name="price-product" value="<?php echo $active_price ?>">
            </div>
            <div class="form-group">
                <label for="disponibility">Availability:</label>
                <input type="text" class="form-control" id="disponibility" name="disponibility" value="<?php echo $active_availability ?>">
            </div>
            <div class="form-group">
                <label for="discount-product">Discount:</label>
                <input type="text" class="form-control" id="discount-product" name="discount-product" value="<?php echo $active_discount ?>">
            </div>
            <div class="form-group">
                <label for="image-product">Image:</label>
                <input type="file" class="form-control" id="image-product" name="image-product" value="<?php echo $active_image ?>">
            </div>

            <button type="submit" class="btn btn-primary py-2" style="width:700px;">Save Settings</button>
        </form>
    </div>
</main>
<?php include_once "views/footer.php"?>
<?php include_once "views/scripts.php"?>
</body>

</html>