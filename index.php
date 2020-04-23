<?php

include './utility/util.php';

session_start();

$loggedin = !!isset($_SESSION['loggedin']);

$con = open_connection();

$stmt = $con->prepare('SELECT ppt.product_id, ppt.product_name, ppt.image_path, ppt.price, ppt.stock, t.tag_name, c.coupon_id, c.discount, c.expires_on, c.created_on
FROM (SELECT p.product_id as product_id, p.product_name as product_name, p.image_path as image_path, p.price as price, p.stock as stock, pt.tag_id as tag_id 
     FROM products p 
     INNER JOIN product_tags pt ON p.product_tags_id = pt.product_tags_id) ppt
INNER JOIN tags t ON ppt.tag_id = t.tag_id
INNER JOIN coupons c ON ppt.product_id = c.product_id');

$stmt->execute();
$result = $stmt->get_result();

// merges query results
$products = array();
while ($product = $result->fetch_assoc()) {
    if (isSet($products[$product['product_id']])) {
        array_push($products[$product['product_id']]['tag_names'], $product['tag_name']);
    } else {
        $products[$product['product_id']] = array(
            'product_id' => $product['product_id'],
            'product_name' => $product['product_name'],
            'image_path' => $product['image_path'],
            'price' => $product['price'],
            'stock' => $product['stock'],
            'tag_names' => array($product['tag_name']),
            'coupon_id' => $product['coupon_id'],
            'discount' => $product['discount'],
            'expires_on' => $product['expires_on'],
            'created_on' => $product['created_on']
        );
    }
}

$stmt->close();

if (isset($_SESSION['id'])) {
    $stmt = $con->prepare('SELECT * FROM orders WHERE user_id = ? AND completed = 0');
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();    
    $_SESSION['product'] = $products[$order['product_id']];
    $stmt->close();
    
    $stmt = $con->prepare('SELECT address_1, address_2, zip, city, `state` FROM users WHERE user_id = ?');
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $_SESSION['address_1'] = $result['address_1'];
    $_SESSION['address_2'] = $result['address_2'];
    $_SESSION['zip'] = $result['zip'];
    $_SESSION['city'] = $result['city'];
    $_SESSION['state'] = $result['state'];
    $stmt->close();
}

echo '<script>console.log('.json_encode($_SESSION, JSON_HEX_TAG).');</script>';
echo '<script>console.log('.json_encode($products, JSON_HEX_TAG).');</script>';

if (isset($_POST['product_id'])) {
    $_SESSION['product'] = $products[$_POST['product_id']];
}

function similarSearch($item) {
    return !!preg_match('/'.$_POST['search'].'/i', $item['product_name']);
}

if (isset($_POST['search'])) {
    $products = array_filter($products, 'similarSearch');
}

$_POST = array();



?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <link rel='icon' type='image/png' href='./media/favicon.png' />
        <link rel='manifest' href='./manifest.json' />
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        
        <title>Professor Hua's Store</title>
        <link href='./style/custom.css' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div class='d-flex flex-column'>
            <div class='navbar'>
                <div class='container'>
                    <div class='d-flex align-items-center'>
                        <img class='navbar-logo' src='media/hua_logo.png' alt='' />
                        <div class='navbar-links'>
                            <div class='searchbar'>
                                <form method='post' class='d-flex justify-content-end align-items-center w-100' style='margin:0;'>
                                    <input placeholder='exact match search' name='search' class='search-input' autocomplete='off' />
                                    <button type='submit' class='search-button'>
                                        <img style='height:1.5rem;' src='media/search.png' alt='' />
                                    </button>
                                </form>
                            </div>
                        
                            <div class='dropdown'>
                                <div class='profile-link'>
                                    <div class='top'>Welcome</div>
                                    <div class='bottom'>
                                        <?php echo ($loggedin ? ucfirst($_SESSION['username']) : 'Sign In/Up');  ?>
                                    </div>
                                </div>
                                <div class='dropdown-content'>
                                    <div class='d-flex d-md-none'>
                                        <?php if (isset($_SESSION['product'])) { ?>
                                            <?php if ($loggedin) { ?>
                                                <form method='post' action='./calls/add_to_cart.php' style='margin:0;'>
                                            <?php } else { ?>
                                                <a href='./auth/signin.php' style='text-decoration:none;'>
                                            <?php } ?>
                                                <button type='submit' class='cart'>
                                                    <img style='height:4rem;' src='./media/cart.png' alt='' />
                                                    <?php if (isset($_SESSION['product'])) { ?>
                                                        <input type='hidden' name='coupon_id' value=<?php echo '"'.$_SESSION['product']['coupon_id'].'"'; ?> />
                                                        <input type='hidden' name='product_id' value=<?php echo '"'.$_SESSION['product']['product_id'].'"'; ?> />
                                                        <input type='hidden' name='user_id' value=<?php echo '"'.$_SESSION['id'].'"'; ?> />
                                                        <div class='cart-display'>
                                                            <div class='top'><?php echo '$'.number_format($_SESSION['product']['price'], 2); ?></div>
                                                            <div class='bottom'>1 item</div>
                                                        </div>
                                                    <?php } ?>
                                                </button>
                                        <?php
                                                echo ($loggedin ? '</form>' : '</a>');
                                            }
                                        ?>
                                    </div>

                                    <?php if ($loggedin) { ?>
                                        <a href='./main/profile.php'>Profile</a>
                                        <a href='./calls/logout.php'>Sign out</a>
                                    <?php } else { ?>
                                        <a href='./auth/signin.php'>Sign In</a>
                                        <a href='./auth/signup.php'>Sign Up</a>
                                    <?php } ?>
                                </div>
                            </div>
                            
                            <?php if (isset($_SESSION['product'])) { ?>
                                <?php if ($loggedin) { ?>
                                    <form method='post' action='./calls/add_to_cart.php' style='margin:0;'>
                                <?php } else { ?>
                                    <a href='./auth/signin.php' style='text-decoration:none;'>
                                <?php } ?>
                            <?php } ?>
                                    <button type='submit' class='cart d-none d-md-flex'>
                                        <img style='height:4rem;' src='./media/cart.png' alt='' />
                                        <?php if (isset($_SESSION['product'])) { ?>
                                            <input type='hidden' name='coupon_id' value=<?php echo '"'.$_SESSION['product']['coupon_id'].'"'; ?> />
                                            <input type='hidden' name='product_id' value=<?php echo '"'.$_SESSION['product']['product_id'].'"'; ?> />
                                            <input type='hidden' name='user_id' value=<?php echo '"'.$_SESSION['id'].'"'; ?> />
                                            <div class='cart-display'>
                                                <div class='top'><?php echo '$'.number_format($_SESSION['product']['price'], 2); ?></div>
                                                <div class='bottom'>1 item</div>
                                            </div>
                                        <?php } ?>
                                    </button>
                            <?php if (isset($_SESSION['product'])) { ?>
                                <?php echo ($loggedin ? '</form>' : '</a>'); ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class='container'>
                <div class='card-group'>
                    <?php
                        foreach ($products as $index=>$product) {
                        // foreach ($products as $product) {
                    ?>
                        <div class='card'>

                            <div class='card-body'>
                                <div class='card-image'>
                                    <img src=<?php echo '"'.$product['image_path'].'"'; ?> alt=<?php echo '"'.$product['product_name'].'"'; ?> />
                                </div>
                                <h1><?php echo $product['product_name']; ?></h1>
                                <div>
                                    <div class='chip'><?php echo implode('</div><div class="chip">', $product['tag_names']); ?></div>
                                </div>
                                <div class='price'><?php echo '$'.number_format($product['price'], 2); ?></div>
                            </div>

                            <div class='card-footer'>
                                <?php if($products[$index]['discount'] != 0) {?>
                                    <div class='coupon'>
                                        <div class='tag'> Savings <?php echo '$'.number_format($product['discount'], 2); ?></div>
                                        <div class='expiration'> Expires in <?php
                                            $start = new DateTime();
                                            $end = new DateTime($product['expires_on']);
                                            $diff = $start->diff($end);
                                            echo $diff->format('%d days');
                                        ?> </div>
                                    </div>
                                <?php } ?>

                                <form method='post' style='margin:0;'>
                                    <!-- hidden inputs contain the user and product IDs need for form submission> -->
                                    <button type='submit' name='product_id' value=<?php echo '"'.$product['product_id'].'"'; ?> >Add to Cart</button>
                                </form>
                            </div>

                        </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>