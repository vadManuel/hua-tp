<?php

include '../utility/util.php';

session_start();

$loggedin = !!isset($_SESSION['loggedin']);
if (!$loggedin) {
    header('Location: ../');
}

$con = open_connection();

$stmt = $con->prepare('SELECT password, email FROM users WHERE user_id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare('SELECT product_id, coupon_id, discount, created_on FROM coupons');
$stmt->execute();
$result = $stmt->get_result();

// remap to use product_id as key
$coupons = array();
while ($coupon = $result->fetch_assoc()) {
    $coupons[$coupon['product_id']] = array(
        'product_id' => $coupon['product_id'], 
        'coupon_id' => $coupon['coupon_id'],
        'discount' => $coupon['discount'],
        'created_on' => $coupon['created_on']
    );
}

$stmt->close();

$stmt = $con->prepare('SELECT ppt.product_id, ppt.product_name, ppt.image_path, ppt.price, ppt.stock, t.tag_name
FROM (SELECT p.product_id as product_id, p.product_name as product_name, p.image_path as image_path, p.price as price, p.stock as stock, pt.tag_id as tag_id 
     FROM products p 
     INNER JOIN product_tags pt ON p.product_tags_id = pt.product_tags_id) ppt
INNER JOIN tags t ON ppt.tag_id = t.tag_id');

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
            'coupon_id' => $coupons[$product['product_id']]['coupon_id'],
            'discount' => $coupons[$product['product_id']]['discount'],
            'created_on' => $coupons[$product['product_id']]['created_on']
        );
    }
}

$stmt->close();

$stmt = $con->prepare('SELECT * FROM orders WHERE user_id = ? AND completed = 1');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();

$orders = array();
while ($order = $result->fetch_assoc()) {
    $orders[$order['product_id']] = array(
        'product_name' => $products[$order['product_id']]['product_name'],
        'image_path' => $products[$order['product_id']]['image_path'],
        'price' => $products[$order['product_id']]['price'],
        'discount' => $products[$order['product_id']]['discount'],
        'created_on' => $products[$order['product_id']]['created_on']
    );
}

$stmt->close();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <link rel='icon' type='image/png' href='../media/favicon.png' />
        <link rel='manifest' href='../manifest.json' />
        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title>Profile Page</title>
        <link href='../style/custom.css' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div class='d-flex flex-column'>
            <div class='navbar'>
                <div class='container'>
                    <div class='d-flex align-items-center'>
                        <a href='../' style='text-decoration:none;'>
                            <img style='height:5rem;' src='../media/hua_logo.png' alt='' />
                        </a>
                        <div class='navbar-links'>
                            <div class='dropdown'>
                                <div class='profile-link'>
                                    <div class='top'>Welcome</div>
                                    <div class='bottom'>
                                        <?php echo ucfirst($_SESSION['username']); ?>
                                    </div>
                                </div>
                                <div class='dropdown-content'>
                                    <a href='../'>Store</a>
                                    <a href='./profile.php'>Profile</a>
                                    <a href='../calls/logout.php'>Sign out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='container'>
                <div style='
                    background-color: rgb(243,243,245);
                    border-radius: 5px;
                    display:flex;
                    margin:5px 10px;
                    padding:5px;
                    flex-grow:1;
                '>
                    <div style='
                        display:flex;
                        margin:5px;
                        flex-grow:1;
                    '>
                        <div style='font-weight:bold;font-size:1.1rem;margin-left:.15rem;'>Order History</div>
                    </div>
                </div>
                <div style='
                    display: flex;
                    flex-wrap: wrap;
                    padding: 5px;
                '>
                    <?php
                        foreach ($orders as $order) {
                    ?>
                        <div style='
                            background-color: rgb(243,243,245);
                            border-radius: 5px;
                            display:flex;
                            margin:5px;
                            padding:5px;
                            flex-grow:1;
                            flex-wrap:;
                        '>
                            <div style='
                                display:flex;
                                margin:5px;
                                flex-grow:1;
                                justify-content:center;
                                align-items:center;
                            '>
                                <img style='height:128px;max-width:100%;' src=<?php echo '"'.$order['image_path'].'"'; ?> alt=<?php echo '"'.$_SESSION['product']['product_name'].'"'; ?> />
                            </div>
                        </div>
                        <div style='
                            background-color: rgb(243,243,245);
                            border-radius: 5px;
                            display:flex;
                            margin:5px;
                            padding:5px;
                            flex-grow:1;
                            flex-wrap:wrap;
                        '>
                            <div style='
                                display:flex;
                                margin:5px;
                                flex-grow:1;
                            '>
                                <div class='inputfield'>
                                    <div>Item Ordered</div>
                                    <input disabled value=<?php echo '"'.$order['product_name'].'"'; ?> />
                                </div>
                            </div>
                            <div style='
                                display:flex;
                                margin:5px;
                                flex-grow:1;
                            '>
                                <div class='inputfield'>
                                    <div>Savings</div>
                                    <input disabled value=<?php echo '"$'.number_format($order['discount'], 2).'"'; ?> />
                                </div>
                            </div>
                            <div style='flex-basis:100%;'></div>
                            <div style='
                                display:flex;
                                margin:5px;
                                flex-grow:1;
                            '>
                                <div class='inputfield'>
                                    <div>Expires In</div>
                                    <input disabled id='dateinput' type='text' value=<?php
                                            $start = new DateTime();
                                            $end = new DateTime($_SESSION['product']['created_on']);
                                            $end = $end->modify('+7 days');
                                            $diff = $start->diff($end);
                                            if ($diff <= 0) {
                                                echo '"Expired"';
                                            } else {
                                                echo '"'.$diff->format('%d days').'"';
                                            }
                                    ?> />
                                </div>
                            </div>
                            <div style='
                                display:flex;
                                margin:5px;
                                flex-grow:2;
                            '>
                                <div class='inputfield'>
                                    <div>Cost & Savings</div>
                                    <input disabled value=<?php echo '"$'.number_format($order['price'], 2).' - $'.number_format($order['discount'], 2).' = $'.number_format($order['price']-$order['discount'], 2).'"'; ?> />
                                </div>
                            </div>
                        </div>
                        <div style='flex-basis:100%;'></div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>