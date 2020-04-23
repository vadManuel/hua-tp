<?php

include '../utility/util.php';

session_start();

$loggedin = !!isset($_SESSION['loggedin']);
if (!isset($_SESSION['product']) || !$loggedin) {
    header('Location: ../');
}

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
                            <div class='dropdown'>
                                <div class='profile-link'>
                                    <div class='top'>Welcome</div>
                                    <div class='bottom'>
                                        <?php echo ucfirst($_SESSION['username']); ?>
                                    </div>
                                </div>
                                <div class='dropdown-content'>
                                    <a href='../'>Store</a>
                                    <a href='./profile'>Profile</a>
                                    <a href='../calls/logout'>Sign out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='container'>
                <form method='post' action='../calls/complete_order.php' style='margin:0;'>
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

                                <?php if($_SESSION['product']['discount'] != 0) {?>
                                    <div class='coupon' style='flex-wrap:wrap;'>
                                        <div class='tag' style='width:13rem;'>Current Savings <?php echo '$'.number_format($_SESSION['product']['discount'], 2); ?></div>
                                        <div class='expiration'> Expires in <?php
                                            $start = new DateTime();
                                            $end = new DateTime($_SESSION['product']['created_on']);
                                            $end = $end->modify('+7 days');
                                            $diff = $start->diff($end);
                                            echo $diff->format('%d days');
                                        ?> </div>
                                    </div>
                                <?php } ?>
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
                                    <td>Savings</td>
                                    <td><?php echo '$'.number_format($_SESSION['product']['discount'], 2); ?>*</td>
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
                                    <td><?php echo '$'.number_format($_SESSION['product']['price']*1.065-$_SESSION['product']['discount'], 2); ?></td>
                                </tr>
                            </table>
                            <div style='display:flex;flex-direction:column;justify-content:flex-end;margin:5px;'>
                                <p style='font-size:.2rem;padding-left:.15rem'>
                                    *Savings shown is the current estimate, actual savings is calculated at the time of coupon expiration.</br>
                                    By placing your order, you agree to Hua.com's privacy notice, conditions of use and all of the terms found here.
                                </p>
                                <input type='hidden' name='purchase_amount' value=<?php echo '"'.number_format($_SESSION['product']['price']*1.065, 2).'"'; ?> />
                                <button name='order_id' value=<?php echo '"'.$_POST['order_id'].'"'?> style='
                                    flex-grow:1;
                                    width: 100%;
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
                                    <input required name='address_1' value=<?php echo '"'.$_SESSION['address_1'].'"'; ?> />
                                </div>
                            </div>
                            <div style='
                                display:flex;
                                margin:5px;
                                flex-grow:1;
                            '>
                                <div class='inputfield'>
                                    <div>Address Line 2</div>
                                    <input name='address_2' value=<?php echo '"'.$_SESSION['address_2'].'"'; ?> />
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
                                    <input required name='city' value=<?php echo '"'.$_SESSION['city'].'"'; ?> />
                                </div>
                            </div>
                            <div style='
                                display:flex;
                                margin:5px;
                                flex-grow:1;
                            '>
                                <div class='inputfield'>
                                    <div>State</div>
                                    <input required name='state' value=<?php echo '"'.$_SESSION['state'].'"'; ?> />
                                </div>
                            </div>
                            <div style='
                                display:flex;
                                margin:5px;
                                flex-grow:1;
                            '>
                                <div class='inputfield'>
                                    <div>Zip Code</div>
                                    <input required name='zip' value=<?php echo '"'.$_SESSION['zip'].'"'; ?> />
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
                                    <input required />
                                </div>
                            </div>
                            <div style='
                                display:flex;
                                margin:5px;
                                flex-grow:1;
                            '>
                                <div class='inputfield'>
                                    <div>Card Number</div>
                                    <input required type='password' />
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
                                    <input required id='dateinput' type='text' />
                                </div>
                            </div>
                            <div style='
                                display:flex;
                                margin:5px;
                                flex-grow:1;
                            '>
                                <div class='inputfield'>
                                    <div>CVV</div>
                                    <input required type='password' />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>

<script>
    let element = document.getElementById('dateinput');
    element.onchange = handleChange;

    function handleChange(e) {
        let match = e.target.value.match(/^(\d{0,2})(?:[-/\\]?)(\d{0,4})/);
        if (match[1].length !== 0) {
            let formatted = `${match[1].padStart(2, '0')}/${match[2].length === 2 ? '20'+match[2] : match[2] }`;
            element.value = formatted;
        }
    }
</script>