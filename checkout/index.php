<?php

include '../utility/util.php';

session_start();
$con = open_connection();
setlocale(LC_MONETARY, 'en_US');

$stmt = $con->prepare('SELECT ppt.product_id, ppt.product_name, ppt.image_path, ppt.price, ppt.stock, t.tag_name FROM (SELECT p.product_id as product_id, p.product_name as product_name, p.image_path as image_path, p.price as price, p.stock as stock, pt.tag_id as tag_id FROM products p INNER JOIN product_tags pt ON p.product_tags_id = pt.product_tags_id) ppt INNER JOIN tags t ON ppt.tag_id = t.tag_id');
$stmt->execute();
$result = $stmt->get_result();

$products = array();
while ($product = $result->fetch_assoc()) {
    if (isSet($products[$product['product_id']])) {
        array_push($products[$product['product_id']]['tag_names'], $product['tag_name']);
    } else {
        $products[$product['product_id']] = array(
            'product_name' => $product['product_name'],
            'image_path' => $product['image_path'],
            'price' => $product['price'],
            'stock' => $product['stock'],
            'tag_names' => array($product['tag_name'])
        );
    }
}
echo '<script>console.log('.json_encode($products, JSON_HEX_TAG).');</script>';

$loggedin = !!isset($_SESSION['loggedin']);
// $stmt = $con->prepare('SELECT activation_code FROM accounts WHERE id = ?');
// $stmt->bind_param('i', $_SESSION['id']);
// $stmt->execute();
// $stmt->bind_result($activation_code);
// $stmt->fetch();
// $stmt->close();

$stmt->close();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <link rel='icon' type='image/png' href='media/favicon.png' />
        <link rel='manifest' href='manifest.json' />
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        
        <title>Professor Hua's Store</title>
        <link href='style/custom.css' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div class='d-flex flex-column'>
            <div class='navbar'>
                <div class='container'>
                    <div class='d-flex align-items-center'>
                        <img style='height:5rem;' src='media/hua_logo.png' alt='' />
                        <div class='navbar-links'>
                            <div class='searchbar'>
                                <input placeholder='fuzzy search' class='search-input' />
                                <button class='search-button'>
                                    <img style='height:1.5rem;' src='media/search.png' alt='' />
                                </button>
                            </div>
                            <!-- <div class='profile-link'>
                                <div class='top'>Welcome</div>
                                <a href='login' class='bottom'>Sign In/Up</a>
                            </div> -->
                           
                            <?php
                                if ($loggedin) {
                            ?>
                                <div class='profile-link'>
                                    <div class='top'>Welcome</div>
                                    <a href='login' class='bottom'>
                                        <?php echo ucfirst($_SESSION['username']); ?>
                                    </a>
                                </div>
                            <?php
                                } else {
                            ?>
                                <div class='dropdown'>
                                    <div class='profile-link'>
                                        <div class='top'>Welcome</div>
                                        <div class='bottom'>Sign In/Up</div>
                                    </div>
                                    <div class='dropdown-content'>
                                        <a href='/authentication/login'>Sign In</a>
                                        <a href='/authentication/signup'>Sign Up</a>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                            <a href='../cart/index'>
                                <div class='cart'>
                                    <img style='height:4rem;' src='media/cart.png' alt='' />
                                    <div class='cart-display'>
                                        <div class='top'>$200.00</div>
                                        <div class='bottom'>1 item</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class='container'>
                <div class='card-group'>
                    <?php
                        foreach ($products as $product) {
                    ?>
                        <div class='card'>
                            <div class='card-image'>
                                <img src=<?php echo '"'.$product['image_path'].'"'; ?> alt=<?php echo '"'.$product['product_name'].'"'; ?> />
                            </div>
                            <div class='card-body'>
                                <h1>Super Duper Plushy</h1>
                                <div>
                                    <div class='chip'><?php echo implode('</div><div class="chip">', $product['tag_names']); ?></div>
                                </div>
                                <div class='price'><?php echo money_format('%n', $product['price']); ?></div>
                            </div>
                            <div class='coupon'>
                                <div class='tag'>Coupon</div>
                                <div class='expiration'>Expires in 3 days 11 hrs</div>
                            </div>
                            <button>Add to Cart</button>
                        </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
