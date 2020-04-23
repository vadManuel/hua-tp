<?php

include './utility/util.php';

session_start();

$loggedin = !!isset($_SESSION['loggedin']);

$con = open_connection();

$stmt = $con->prepare('SELECT ppt.product_id, ppt.product_name, ppt.image_path, ppt.price, ppt.stock, t.tag_name, c.discount, c.expires_on
FROM 
	(SELECT p.product_id as product_id, p.product_name as product_name, p.image_path as image_path, p.price as price, p.stock as stock, pt.tag_id as tag_id 
     FROM products p 
     INNER JOIN product_tags pt ON p.product_tags_id = pt.product_tags_id) 
ppt INNER JOIN tags t ON ppt.tag_id = t.tag_id
INNER JOIN coupons c on ppt.product_id = c.product_id');

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
            'discount' => $product['discount'],
            'expires_on' => $product['expires_on'],
            'tag_names' => array($product['tag_name'])
        );
    }
}

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

$stmt->close();

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
                    <form method='post' class='d-flex align-items-center'>
                        <img class='navbar-logo' src='media/hua_logo.png' alt='' />
                        <div class='navbar-links'>
                            <div class='searchbar'>
                                <input placeholder='exact match search' name='search' class='search-input' autocomplete='off' />
                                <button type='submit' class='search-button'>
                                    <img style='height:1.5rem;' src='media/search.png' alt='' />
                                </button>
                            </div>
                        
                            <?php
                                if ($loggedin) {
                            ?>
                                <div class='dropdown'>
                                    <div class='profile-link'>
                                        <div class='top'>Welcome</div>
                                        <a href='login' class='bottom'>
                                            <?php echo ucfirst($_SESSION['username']); ?>
                                        </a>
                                    </div>
                                    <div class='dropdown-content'>
                                        <?php if (isset($_SESSION['product'])) { ?>
                                            <a href=<?php echo '"'.($loggedin ? './checkout' : './auth/signin.php').'"'; ?> class='d-block d-md-none' style='text-decoration:none'>
                                                <div class='cart'>
                                                    <img style='height:4rem;' src='./media/cart.png' alt='' />
                                                    <?php if (isset($_SESSION['product'])) { ?>
                                                        <div class='cart-display'>
                                                            <div class='top'><?php echo '$'.number_format($_SESSION['product']['price'], 2); ?></div>
                                                            <div class='bottom'>1 item</div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </a>
                                        <?php } ?>
                                        <a href='./main/profile.php'>Profile</a>
                                        <a href='./calls/logout.php'>Sign out</a>
                                    </div>
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
                                        <?php if (isset($_SESSION['product'])) { ?>
                                            <a href=<?php echo '"'.($loggedin ? './checkout' : './auth/signin.php').'"'; ?> class='d-block d-md-none' style='text-decoration:none'>
                                                <div class='cart'>
                                                    <img style='height:4rem;' src='./media/cart.png' alt='' />
                                                    <?php if (isset($_SESSION['product'])) { ?>
                                                        <div class='cart-display'>
                                                            <div class='top'><?php echo '$'.number_format($_SESSION['product']['price'], 2); ?></div>
                                                            <div class='bottom'>1 item</div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </a>
                                        <?php } ?>
                                        <a href='./authentication/signin.php'>Sign In</a>
                                        <a href='./authentication/signup.php'>Sign Up</a>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                            <?php if (isset($_SESSION['product'])) { ?>
                                <a href=<?php echo '"'.($loggedin ? './checkout' : './authentication/signin.php').'"'; ?> class='d-none d-md-block'  style='text-decoration:none'>
                            <?php } ?>
                                    <div class='cart'>
                                        <img style='height:4rem;' src='./media/cart.png' alt='' />
                                        <?php if (isset($_SESSION['product'])) { ?>
                                            <div class='cart-display'>
                                                <div class='top'><?php echo '$'.number_format($_SESSION['product']['price'], 2); ?></div>
                                                <div class='bottom'>1 item</div>
                                            </div>
                                        <?php } ?>
                                    </div>
                            <?php if (isset($_SESSION['product'])) { ?>
                                </a>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
            <div class='container'>
                <div class='card-group'>
                    <?php
                        // foreach ($products as $index=>$product) {
                        foreach ($products as $product) {
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
                            <?php if($products[$index]['discount'] != 0) {?>
                                <div class='coupon'>
                                    <div class='tag'> - <?php echo " ".$product['discount'], " "; ?>$</div>
                                    <div class='expiration'> Expires on: <?php echo " ".$product['expires_on']; ?> </div>
                                </div>
                            <?php } ?>

                            <div class='card-footer'>
                                <?php if($products[$index]['discount'] != 0) {?>
                                    <div class='coupon'>
                                        <div class='tag'> - <?php echo " ".$product['discount'], " "; ?>$</div>
                                        <div class='expiration'> Expires on: <?php echo " ".$product['expires_on']; ?> </div>
                                    </div>
                                <?php } ?>

                                <form method="post" action="../utility/add_to_cart.php">
                                    <!-- hidden inputs contain the user and product IDs need for form submission> -->
                                    <input type="hidden" id="product_id" name="product_id" value=<?php echo $index?> />
                                    <input type="hidden" id="user_id" name="user_id" value=<?php echo $_SESSION['id']?> />
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