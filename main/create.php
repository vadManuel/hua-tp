<?php

include 'utility/util.php';
$con = open_connection();

if(isset($_POST['upload_product'])) {
    echo '<script>console.log('.json_encode($_POST, JSON_HEX_TAG).');</script>';
    echo '<script>console.log('.json_encode($_FILES, JSON_HEX_TAG).');</script>';

    $check = false;
    $products_query = 'INSERT INTO products (product_name, product_tags_id, price, stock) VALUES (?, ?, ?, ?)'; 

    if (isset($_FILES['image_name']) && $_FILES['image_name']['size'] > 0) {
        $image_path = 'uploaded_images/'.uniqid().'_'.$_FILES['image_name']['name'];

        if (move_uploaded_file($_FILES['image_name']['tmp_name'], $image_path)) {
            $check = true;
            $products_query = 'INSERT INTO products (image_path, product_name, product_tags_id, price, stock) VALUES (?, ?, ?, ?, ?)';
        } else {
            echo '<script type="text/javascript"> alert("Unable to move uploaded file! Check your folder permissions : '.$image_path.'"); </script>';
        }
    } else if (isset($_POST['image_url'])) {
        $check = true;
        $products_query = 'INSERT INTO products (image_path, product_name, product_tags_id, price, stock) VALUES (?, ?, ?, ?, ?)';
        $image_path = $_POST['image_url'];
    }

    if ($stmt = $con->prepare($products_query)) {
        $product_tags_id = uniqid();

        if ($check) {
            $stmt->bind_param('sssdi', $image_path, $_POST['product_name'], $product_tags_id, $_POST['price'], $_POST['stock']);
        } else {
            $stmt->bind_param('ssdi', $_POST['product_name'], $product_tags_id, $_POST['price'], $_POST['stock']);
        }
        $stmt->execute();
        $stmt->close();

        $product_tags_query = 'INSERT INTO product_tags (product_tags_id, tag_id) VALUES ';
        foreach ($_POST['tags'] as $tag) {
            $product_tags_query .= '("'.$product_tags_id.'",'.$tag.'), ';
        }
        $product_tags_query = substr($product_tags_query, 0, -2);

        if ($stmt = $con->prepare($product_tags_query)) {
            $stmt->execute();
            $stmt->close();
        } else {
            echo '<script type="text/javascript"> alert("Bad product_tags statement."); </script>';
        }
    } else {
        echo '<script type="text/javascript"> alert("Bad products statement."); </script>';
    }
    
} else if (isset($_POST['upload_tag'])) {
    if ($stmt = $con->prepare('INSERT INTO tags (tag_name) VALUES (?)')) {
        $stmt->bind_param('s', strtolower($_POST['tag_name']));
        $stmt->execute();
        $stmt->close();
    } else {
        echo '<script type="text/javascript"> alert("Bad tags statement."); </script>';
    }
}

unset($_POST);
$_POST = array();
unset($_FILES);
$_FILES = array();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <link rel='icon' type='image/png' href='media/favicon.png' />
    <link rel='manifest' href='manifest.json' />
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    
    <title>Create Products and Tags</title>
    <link href='style/custom.css' rel='stylesheet' type='text/css'>
</head>
<body>

<!-- Tag Upload -->
<form method='post'>
  <table style='width:300px;'>
    <tr>
      <th colspan='4'>Tag</th>
    </tr>
    <tr>
      <td colspan='3'><input class='w-100' type='text' name='tag_name' Required></td>
      <td><input class='w-100' type='submit' name='upload_tag' value='Upload'></td>			
    </tr>
  </table>
</form>

<!-- Product Upload -->
<form method='post' enctype='multipart/form-data'>
  <table>
    <tr>
      <th colspan='4'>Product</th>
    </tr>
    <tr>
      <td colspan='2'><input class='w-100' type='text' name='product_name' placeholder='Product Name' Required></td>
      <td><input class='w-100' type='text' name='price' placeholder='Price' Required></td>
      <td><input class='w-100' type='number' name='stock' placeholder='Stock' Required></td>
    </tr>
    <tr>
        <td colspan='4'>
            <table>
                <?php
                    $stmt = $con->prepare('SELECT * FROM tags');
                    $stmt->execute();
                    $result = $stmt->get_result();

                    $j = 0;
                    while($j < $result->num_rows) {
                ?>
                    <tr>
                        <?php
                            $i = 0;
                            while ($i < 8) {
                                if ($tag = $result->fetch_assoc()) {
                        ?>
                                    <td>
                                        <input type='checkbox' name='tags[]' value=<?php echo '"'.$tag['tag_id'].'"'; ?> id=<?php echo '"'.$tag['tag_id'].'"'; ?>>
                                        <label for=<?php echo '"'.$tag['tag_id'].'"'; ?>> <?php echo $tag['tag_name']; ?></label>
                                    </td>
                        <?php
                                }
                                $i++;$j++;
                            }
                        ?>
                    </tr>
                <?php
                    }
                ?>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan='2'><input class='w-100' type='file' name='image_name'></td>
        <td colspan='2'><input class='w-l100' type='text' name='image_url' placeholder='Image URL'></td>
    </tr>
    <tr>
        <td colspan='3'></td>
        <td><input class='w-100' type='submit' name='upload_product' value='Upload'></td>			
    </tr>
  </table>
</form>

<h2>All Records</h2>

<table border="2">
  <tr>
    <td>Sr.No.</td>
    <td>Name</td>
    <td>Images</td>
  </tr>

<?php

$records = mysqli_query($con, 'SELECT * FROM images'); // fetch data from database

while($data = mysqli_fetch_array($records)) {
?>
  <tr>
    <td><?php echo $data['image_id']; ?></td>
    <td><?php echo $data['file_path']; ?></td>
    <td><img src="<?php echo $data['file_path']; ?>" alt='nope' width="100" height="100"></td>
  </tr>
<?php } ?>

</table>

<?php mysqli_close($con); ?>

</body>
</html>