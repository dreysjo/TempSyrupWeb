<?php
include('database.php');
if (isset($_POST['add_product'])) {
    $p_name = $_POST['p_name'];
    $p_price = $_POST['p_price'];
    $p_price_box = $_POST['p_price_box'];
    $p_image = $_FILES['p_image']['name'];
    $p_image_tmp = $_FILES['p_image']['tmp_name'];
    $p_image_folder = 'uploaded_img/' . $p_image;

    $query = "INSERT INTO `product`(`product_name`, `price_unit`,`price_box, `image`) VALUES ('$p_name','$p_price','$p_price_box','$p_image')";
    $insert = mysqli_query($conn, $query) or die('query failed');

    if ($insert) {
        move_uploaded_file($p_image_tmp, $p_image_folder);
        $message[] = 'product added!';
        header('location:admin_page.php');
    } else {
        $message[] = 'could not add the product';
        header('location:admin_page.php');
    };
};

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_query = mysqli_query($conn, "DELETE FROM `product` WHERE id = $delete_id ") or die('query failed');
    if ($delete_query) {
        header('location:admin_page.php');
        $message[] = 'product has been deleted';
    } else {
        header('location:admin_page.php');
        $message[] = 'product could not be deleted';
    };
};

if (isset($_POST['update_product'])) {
    $update_p_id = $_POST['update_p_id'];
    $update_p_name = $_POST['update_p_name'];
    $update_p_price = $_POST['update_p_price'];
    $update_p_price_box = $_POST['update_p_price_box'];
    $update_p_image = $_FILES['update_p_image']['name'];
    $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
    $update_p_image_folder = 'uploaded_img/' . $update_p_image;

    $update_query = mysqli_query($conn, "UPDATE `product` SET product_name = '$update_p_name', price_unit = '$update_p_price',price_box = '$update_p_price_box' image = '$update_p_image' WHERE id = '$update_p_id'");

    if ($update_query) {
        move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
        $message[] = 'product updated succesfully';
        header('location:edit_page.php');
    } else {
        $message[] = 'product could not be updated';
        header('location:edit_page.php');
    }
}

?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />
    <link rel="stylesheet" href="css/stylee.css">
    </link>
</head>
<?php include ('header.php')?>
<body>
<div class="container">
        <section>
            <form action="" method="POST" class="add-product-form" enctype="multipart/form-data" autocomplete="off">
                <h3>add new product</h3>
                <input type="text" name="p_name" placeholder="enter the product name" class="box" required>
                <input type="text" name="p_price" placeholder="enter the product price" min="0" class="box" required>
                <input type="text" name="p_price_box" placeholder="enter the product price" min="0" class="box" required>
                <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg, image/jfif" class="box">
                <input type="submit" name="add_product" value="add product" class="btn">
            </form>
        </section>

        <section class="display-product-table">

            <table>
                <thead>
                    <th>product image</th>
                    <th>product name</th>
                    <th>product price/unit</th>
                    <th>product price/box</th>
                    <th>action</th>
                </thead>
                <tbody>
                    <?php

                    $select_products = mysqli_query($conn, "SELECT * FROM `product`");
                    if (mysqli_num_rows($select_products) > 0) {
                        while ($row = mysqli_fetch_assoc($select_products)) {
                    ?>

                            <tr>
                                <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                                <td><?php echo $row['product_name']; ?></td>
                                <td>Rp.<?php echo $row['price_unit']; ?>,-/unit</td>
                                <td>Rp.<?php echo $row['price_box']; ?>,-/box</td>
                                <td>
                                    <a href="edit_page.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> delete </a>
                                    <a href="edit_page.php?edit=<?php echo $row['id']; ?>" class="option-btn"> <i class="fas fa-edit"></i> update </a>
                                </td>
                            </tr>

                    <?php
                        };
                    } else {
                        echo "<div class='empty'>no product added</div>";
                    };
                    ?>
                </tbody>
            </table>

        </section>

        <section class="edit-form-container">

            <?php

            if (isset($_GET['edit'])) {
                $edit_id = $_GET['edit'];
                $edit_query = mysqli_query($conn, "SELECT * FROM `product` WHERE id = $edit_id");
                if (mysqli_num_rows($edit_query) > 0) {
                    while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
            ?>

                        <form action="" method="post" enctype="multipart/form-data">
                            <img src="uploaded_img/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
                            <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
                            <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['product_name']; ?>">
                            <input type="text min="0" class="box" required name="update_p_price" value="<?php echo $fetch_edit['price_unit']; ?>">
                            <input type="text min="0" class="box" required name="update_p_price_box" value="<?php echo $fetch_edit['price_unit_box']; ?>">
                            <input type="file" class="box" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">
                            <input type="submit" value="update the prodcut" name="update_product" class="btn">
                            <a href="edit_page.php"><input type="button" value="cancel" id="close-edit" class="option-btn"></a>
                        </form>

            <?php
                    };
                };
                echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
            };
            ?>

        </section>
    </div>
    <script src="js/edit_js.js"></script>
</body>

</html>