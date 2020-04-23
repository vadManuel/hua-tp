<?php

include '../utility/util.php';

session_start();

$loggedin = !!isset($_SESSION['loggedin']);
if (!isset($_SESSION['product']) || !$loggedin) {
    header('Location: ../');
}


$con = open_connection();

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
        <link rel='icon' type='image/png' href='../media/favicon.png' />
        <link rel='manifest' href='../manifest.json' />
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        
        <title>Checkout</title>
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
                            <!-- <div class='searchbar'>
                                <input placeholder='fuzzy search' class='search-input' />
                                <button class='search-button'>
                                    <img style='height:1.5rem;' src='../media/search.png' alt='' />
                                </button>
                            </div> -->
                            <!-- <div class='profile-link'>
                                <div class='top'>Welcome</div>
                                <a href='login' class='bottom'>Sign In/Up</a>
                            </div> -->
                           
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
                                        <a href='../main/profile'>Profile</a>
                                        <a href='../calls/logout'>Sign out</a>
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
                                        <a href='../auth/login'>Sign In</a>
                                        <a href='../auth/signup'>Sign Up</a>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class='container'>
                <div style='
                    display: flex;
                    flex-wrap: wrap;
                    padding: 5px;
                '>
                    <div style='
                        background-color: rgb(243,243,245);
                        border-radius: 5px;
                        display:flex;
                        flex-grow:2;
                        flex-wrap:wrap;
                        margin:5px;
                    '>
                        <div style='display:flex;justify-content:center;align-items:center;flex-grow:1;'>
                            <img style='height:200px;max-width:100%;' src=<?php echo '"'.$_SESSION['product']['image_path'].'"'; ?> alt=<?php echo '"'.$_SESSION['product']['product_name'].'"'; ?> />
                        </div>
                        <div style='min-height:200px;display:flex;flex-direction:column;justify-content:space-between;flex-grow:2;'>
                            <div class='card-body' style='padding:0;margin-top:5px;'>
                                <div style='font-weight:bold;font-size:1.5rem;margin-left:.15rem;padding-bottom:.2rem;'><?php echo $_SESSION['product']['product_name']; ?></div>
                                <div>
                                    <div class='chip'><?php echo implode('</div><div class="chip">', $_SESSION['product']['tag_names']); ?></div>
                                </div>
                                <div class='price' style='font-weight:bold;font-size:1.2rem;margin-left:.15rem;'><?php echo '$'.number_format($_SESSION['product']['price'], 2); ?></div>
                            </div>
                            <div class='coupon'>
                                <div class='tag'>Coupon</div>
                                <div class='expiration'>Expires in 3 days 11 hrs</div>
                            </div>
                        </div>
                    </div>
                    <div class='gotoend' style='
                        background-color: rgb(243,243,245);
                        border-radius: 5px;
                        display:flex;
                        flex-direction:column;
                        justify-content:space-between;
                        flex-grow:1;
                        margin:5px;
                        padding:5px;
                    '>
                        <table style='flex-grow:1;margin:5px;'>
                            <tr>
                                <th colspan='2' style='text-align:left;'>Your Order Total</th>
                            </tr>
                            <tr><th colspan='2' style='border-bottom:1px solid gray;'></th></tr>
                            <tr>
                                <td>Subtotal</td>
                                <td><?php echo '$'.number_format($_SESSION['product']['price'], 2); ?></td>
                            </tr>
                            <tr>
                                <td>Shipping</td>
                                <td>FREE</td>
                            </tr>
                            <tr>
                                <td>Estimated Tax</td>
                                <td><?php echo '$'.number_format($_SESSION['product']['price']*.065, 2); ?></td>
                            </tr>
                            <tr><th colspan='2' style='border-bottom:1px solid gray;'></th></tr>
                            <tr>
                                <td>Total</td>
                                <td><?php echo '$'.number_format($_SESSION['product']['price']*1.065, 2); ?></td>
                            </tr>
                        </table>
                        <div style='display:flex;flex-direction:column;justify-content:flex-end;margin:5px;'>
                            <p style='font-size:.2rem;padding-left:.15rem'>
                                By placing your order, you agree to Hua.com's privacy notice, conditions of use and all of the terms found here.
                            </p>
                            <button style='
                                flex-grow:1;
                                background-color:coral;
                                color:rgb(243,243,245);
                                height: 1.75rem;
                                line-height: 1.75rem;
                                font-size: .8rem;
                                border: none;
                                border-radius: 5px;
                            '>
                                Place Your Order
                            </button>
                        </div>
                    </div>
                    <div style='flex-basis:100%;'></div>
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
                            <div style='font-weight:bold;font-size:1.1rem;margin-left:.15rem;'>Delivery Address</div>
                        </div>
                        <div style='flex-basis:100%;'></div>
                        <div style='
                            display:flex;
                            margin:5px;
                            flex-grow:1;
                        '>
                            <div class='inputfield'>
                                <div>Street Address</div>
                                <input />
                            </div>
                        </div>
                        <div style='
                            display:flex;
                            margin:5px;
                            flex-grow:1;
                        '>
                            <div class='inputfield'>
                                <div>Address Line 2</div>
                                <input />
                            </div>
                        </div>
                        <div style='flex-basis:100%;'></div>
                        <div style='
                            display:flex;
                            margin:5px;
                            flex-grow:6;
                        '>
                            <div class='inputfield'>
                                <div>City</div>
                                <input />
                            </div>
                        </div>
                        <div style='
                            display:flex;
                            margin:5px;
                            flex-grow:1;
                        '>
                            <div class='inputfield'>
                                <div>State</div>
                                <input />
                            </div>
                        </div>
                        <div style='
                            display:flex;
                            margin:5px;
                            flex-grow:1;
                        '>
                            <div class='inputfield'>
                                <div>Zip Code</div>
                                <input />
                            </div>
                        </div>
                    </div>
                    <div style='flex-basis:100%;'></div>
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
                            <div style='font-weight:bold;font-size:1.1rem;margin-left:.15rem;'>Payment</div>
                        </div>
                        <div style='flex-basis:100%;'></div>
                        <div style='
                            display:flex;
                            margin:5px;
                            flex-grow:1;
                        '>
                            <div class='inputfield'>
                                <div>Card Name</div>
                                <input />
                            </div>
                        </div>
                        <div style='
                            display:flex;
                            margin:5px;
                            flex-grow:1;
                        '>
                            <div class='inputfield'>
                                <div>Card Number</div>
                                <input />
                            </div>
                        </div>
                        <div style='flex-basis:100%;'></div>
                        <div style='
                            display:flex;
                            margin:5px;
                            flex-grow:2;
                        '>
                            <div class='inputfield'>
                                <div>Expires</div>
                                <input id='dateinput' type='text' />
                            </div>
                        </div>
                        <div style='
                            display:flex;
                            margin:5px;
                            flex-grow:1;
                        '>
                            <div class='inputfield'>
                                <div>CVV</div>
                                <input id='cvv' />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<script>
    let element = document.getElementById('dateinput');
    let cvv = document.getElementById('cvv');
    element.onchange = handleChange;

    function handleChange(e) {
        let match = e.target.value.match(/^(\d{0,2})(?:[-/\\]?)(\d{0,4})/);
        if (match[1].length !== 0) {
            let formatted = `${match[1].padStart(2, '0')}/${match[2].length === 2 ? '20'+match[2] : match[2] }`;
            element.value = formatted;
        }
    }
</script>