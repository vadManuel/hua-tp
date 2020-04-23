<?php

include '../utility/util.php';

session_start();
$con = open_connection();
setlocale(LC_MONETARY, 'en_US');


// get the product_id for the cart item we're looking for
$stmt = $con->prepare('SELECT products.product_id
                        from products
                        INNER JOIN orders on orders.product_id = products.product_id
                        WHERE orders.user_id = ? and orders.completed = 0;');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();

// if there is nothing to show, show nothing
if($result->num_rows > 0 ){

    while($item = $result->fetch_assoc()){
        $cart = $item['product_id'];
    }

    // gets the data for the product cards
    $stmt = $con->prepare('SELECT ppt.product_id, ppt.product_name, ppt.image_path, ppt.price, ppt.stock, t.tag_name, c.discount
    FROM 
        (SELECT p.product_id as product_id, p.product_name as product_name, p.image_path as image_path, p.price as price, p.stock as stock, pt.tag_id as tag_id 
        FROM products p 
        INNER JOIN product_tags pt ON p.product_tags_id = pt.product_tags_id) 
        ppt INNER JOIN tags t ON ppt.tag_id = t.tag_id
        INNER JOIN coupons c on ppt.product_id = c.product_id
    WHERE ppt.product_id = ?');
    $stmt->bind_param('i', $cart);
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
                'discount' => $product['discount'],
                'stock' => $product['stock'],
                'tag_names' => array($product['tag_name'])
            );
        }
    }

    echo '<script>console.log('.json_encode($products, JSON_HEX_TAG).');</script>';

} else {
    

}

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
        <link rel='icon' type='image/png' href='./media/favicon.png' />
        <link rel='manifest' href='../manifest.json' />
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        
        <title>Professor Hua's Store</title>
        <link href='../../style/custom.css' rel='stylesheet' type='text/css'>
    </head>
    
    <body>
        <div class='d-flex flex-column'>
            <div class='navbar'>
                <div class='container'>
                    <div class='d-flex align-items-center'>
                        <a href="..">
                            <img style='height:5rem;' src='./media/hua_logo.png' alt='' />
                        </a>
                        <div class='navbar-links'>
                            
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
                                        <a href='../authentication/login'>Sign In</a>
                                        <a href='../authentication/signup'>Sign Up</a>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                            <a href='../cart'>
                                <div class='cart'>
                                    <img style='height:4rem;' src='./media/cart.png' alt='' />
                                </div>
                            </a>
                        </div>
                    </div>
                <div class = 'justify-content-center' >
                    <div class='page-header'>Checkout</div>
                    <! -- list items in cart here>

                </div>
                </div>
            </div>
            
            <div class='container'>
                <div class='card-group'>
                    <?php
                        foreach ($products as $index=>$product) {
                    ?>
            
                        <div class='card'>

                            <div class='card-image'>
                                <img src=<?php echo '"'.$product['image_path'].'"'; ?> alt=<?php echo '"'.$product['product_name'].'"'; ?> />
                            </div>
                            <div class='card-body'>

                                <h1><?php echo $product['product_name']; ?></h1>

                                <div>
                                    <div class='chip'><?php echo implode('</div><div class="chip">', $product['tag_names']); ?></div>
                                </div>

                                <div class='price'><?php echo money_format('%n', $product['price']); ?>$</div>

                            </div>  
                            
                            
                        </div>
                     
                        <div class='card'>
                        
                            
                            <div><?php echo money_format('%n', $product['price']); ?>$</div>
                            <div><?php echo money_format('%n', $product['discount']); ?>$</div>
              
                            <h1>Total</h1>
                            <div><?php echo money_format('%n', ($product['price'] - $product['discount'])); ?>$</div>
                            
                        </div>
                        
                        <div class='card'>
                            
                            <h1>Enter Payment Information</h1>
                            
                            <form method="post" action="../utility/complete_order.php">
                                <input type="hidden" id="user_id" name="user_id" value=<?php echo $_SESSION['id']?> />
                                
                                <label for="name">Name on Card:</label><br>
                                <input type="text" id="name" name="name" required><br>
                                
                                <label for="card_number">Card Number:</label><br>
                                <input type="text" id="card_number" name="card_number" required><br>
                                
                                <label for="security_code">Security Code:</label><br>
                                <input type="text" id="security_code" name="security_code" required><br>
                                
                                <label for="expriration">Expriration Date</label><br>
                                <input type="text" id="expriration" name="expriration" required><br>
                                
                                <button type="submit">Submit Order</button>
                                
                            </form>
                            
                        </div>
                     
                     <?php } ?>                
                </div>
            </div>
            
            
        </div>
    </body>
</html>
