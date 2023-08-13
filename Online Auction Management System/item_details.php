<?php
    include 'db_connect.php';

    if (session_status() === PHP_SESSION_NONE) {

        session_start(); 
    }
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $query4 = "SELECT * FROM `Buyer` WHERE `Username` = '$username';";
        $result4 = mysqli_query($con, $query4);
        $row4 = mysqli_fetch_assoc($result4);
    
        $buyerID = $row4['BuyerID'];
    }
    $itemID = $_GET['item_id'];
    $accountNoInvalid = false;
    $lessThanMinBidAmount = false;
    $auctionOver = false;
?>

<?php
    $query7 = "SELECT * FROM `Items` 
    WHERE `ItemID` = '$itemID';";
    $result7 = mysqli_query($con, $query7);
    $row7 = mysqli_fetch_assoc($result7);

    date_default_timezone_set('Asia/Kolkata');
    $now = new DateTime();

    if ($now > (new datetime($row7['AuctionEnd']))) {
        $auctionOver = true;
        $query8 = "UPDATE Bids 
        SET WinStatus = 'Yes'
        WHERE BidID = (
            SELECT * FROM (
                SELECT BidID FROM Bids b1
                WHERE b1.ItemID = $itemID AND b1.BidAmount = (
                    SELECT MAX(BidAmount) FROM Bids b2
                    WHERE b2.ItemID = $itemID
                )
            ) AS b
        );";
        mysqli_query($con, $query8);
    } else {
        $auctionOver = false;
        $query8 = "UPDATE Bids 
        SET WinStatus = 'No'
        WHERE BidID = (
            SELECT * FROM (
                SELECT BidID FROM Bids b1
                WHERE b1.ItemID = $itemID AND b1.BidAmount = (
                    SELECT MAX(BidAmount) FROM Bids b2
                    WHERE b2.ItemID = $itemID
                )
            ) AS b
        );";
        mysqli_query($con, $query8);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item page</title>

    <!-- Font Awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&family=DM+Serif+Display&family=Kaushan+Script&family=Merienda:wght@700&family=Rammetto+One&display=swap" rel="stylesheet">

    <style>
        * {
            /* outline: 2px solid green; */
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        ::-webkit-scrollbar {
            width: 1rem;
        }
        
        ::-webkit-scrollbar-track {
            background-color: #C4D5E7;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #443B6C;
            border: 1px solid #C4D5E7;
            border-radius: 0.5rem;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #4d427a;
            border-radius: 0.5rem;
        }

        header {
            background-color: #6CBCE3;
            box-shadow: 0 0 2rem rgba(0, 0, 0, 0.15);
            font-weight: 600;
        }

        .banner-image {
            position: absolute;
            width: 100%;
            z-index: -1;
        }

        .banner-image img {
            width: 100%;
        }

        .banner-container {
            padding: 1rem 4rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: #1E68B6;
            font-family: 'Rammetto One', cursive;
            font-size: 2rem;
            font-weight: 400;
        }

        .banner-container .account-container {
            display: flex;
            align-items: center;
            /* gap: 1rem; */

            position: relative;

            background-color: #C4D5E7;
            /* padding: 1rem; */
            
            border-radius: 1rem;

            font-size: 1.2rem;

            /* overflow: hidden; */
        }
        
        .banner-container .account-container i, .banner-container .account-container p {
            border-radius: 1rem;
            padding: 1rem;
            transition: background-color 200ms ease-out;
        }
        
        .banner-container .account-container i:hover, .banner-container .account-container p:hover {
            /* border-radius: 1rem; */
            background-color: #eee;
        }

        .banner-container .account-container .fa-bell {
            border-top-left-radius: 1rem;
            border-bottom-left-radius: 1rem;
        }
        .banner-container .account-container .fa-chevron-down {
            border-radius: 1rem;
            transition: transform 200ms ease-out;
        }

        .rotate-arrow {
            transform: rotate(180deg);
        }
        
        .banner-container .account-container a {
            padding: 0;
            /* height: 95%; */
            text-decoration: none;
            /* margin: -2px; */
        }

        .banner-container .account-container a:visited {
            color: #1B1A38;
        }
        
        .updates-container {
            position: absolute;
            min-width: 150%;
            min-height: 100%;
            top: -140%;
            right: 20%;
            background-color: #C4D5E7;

            border-radius: 0.5rem;
            overflow: hidden;

            z-index: 1;
            scale: 0;
            opacity: 0;
            transition: scale 200ms ease-out,
            top 200ms ease-out,
            right 200ms ease-out,
            opacity 200ms ease-out;
        }

        .activate-updates {
            top: 0;
            right: calc(100% + 1rem);
            scale: 1;
            opacity: 1;
        }

        .updates-container p {
            font-size: 1rem;
            font-weight: 400;
        }

        .updates-container .updates-header {
            font-size: 1.2;
            font-weight: 600;
        }

        .account-menu {
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            min-width: 100%;
            min-height: 100%;
            top: 30%;
            right: -35%;

            padding: 0.5rem;
            background-color: #C4D5E7;

            border-radius: 0.5rem;

            scale: 0;
            opacity: 0;
            transition: scale 200ms ease-out,
            top 200ms ease-out,
            right 200ms ease-out,
            opacity 200ms ease-out;
        }

        .activate-account {
            scale: 1;
            top: calc(100% + 1rem);
            right: 0;
            opacity: 1;
        }

        .account-menu button {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 1.5rem;
            background-color: #443B6C;
            border-radius: 0.5rem;

            font-size: 1rem;
            color: white;

            transition: background-color 200ms ease-out;
        }

        .account-menu button:hover {
            background-color: #4d427a;
        }

        .account-menu button:active {
            background-color: #3e3562;
        }

        .account-menu button i {
            color: white;
            padding: 0 !important;
        }

        .account-menu button i:hover {
            background-color: inherit !important;
        }
        
        hr {
            border: 0;
            height: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        nav {
            display: flex;
            justify-content: center;

            font-size: 1rem;
            gap: 1rem;
        }

        nav a:visited {
            color: inherit;
        }

        nav * {
            padding: 2rem;
            /* margin: 0 1rem; */
            transition: color 200ms ease-out;
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }


        nav * span {
            position: absolute;
            top: calc(100% - 2px);
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #1E68B6;
            transform: translateX(-100%);

            transition: transform 200ms ease-out;
        }

        nav *:hover span {
            transform: translateX(0%);
        }

        nav a:hover {
            color: #1E68B6;
        }

        nav .icon {
            display: flex;
        }

        nav .icon::before {
            display: inline-block;
            
            /* line-height: 1em; */
            margin-right: 0.5rem;
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            font-size: 1em;
        }

        .home::before {
            content: "\f015";
        }

        .login::before {
            content: "\f2f6";
        }

        .signup::before {
            content: "\f234";
        }

        .logout::before {
            content: "\f2f5";
        }

        .about::before {
            content: "\f05a";
        }

        .contact::before {
            content: "\f0e0";
        }

        body {
            /* height: 100vh; */
            background-image: url("data:image/svg+xml,<svg id='patternId' width='100%' height='100%' xmlns='http://www.w3.org/2000/svg'><defs><pattern id='a' patternUnits='userSpaceOnUse' width='50.41' height='87' patternTransform='scale(4) rotate(15)'><rect x='0' y='0' width='100%' height='100%' fill='hsla(0,0%,100%,1)'/><path d='M25.3 87L12.74 65.25m0 14.5h-25.12m75.18 0H37.68M33.5 87l25.28-43.5m-50.23 29l4.19 7.25L16.92 87h-33.48m33.48 0h16.75-8.37zM8.55 72.5L16.92 58m50.06 29h-83.54m79.53-50.75L50.4 14.5M37.85 65.24L50.41 43.5m0 29l12.56-21.75m-50.24-14.5h25.12zM33.66 29l4.2 7.25 4.18 7.25M33.67 58H16.92l-4.18-7.25M-8.2 72.5l20.92-36.25L33.66 0m25.12 72.5H42.04l-4.19-7.26L33.67 58l4.18-7.24 4.19-7.25M33.67 29l8.37-14.5h16.74m0 29H8.38m29.47 7.25H12.74M50.4 43.5L37.85 21.75m-.17 58L25.12 58M12.73 36.25L.18 14.5M0 43.5l-12.55-21.75M24.95 29l12.9-21.75M12.4 21.75L25.2 0M12.56 7.25h-25.12m75.53 0H37.85M58.78 43.5L33.66 0h33.5m-83.9 0h83.89M33.32 29H16.57l-4.18-7.25-4.2-7.25m.18 29H-8.37M-16.74 0h33.48l-4.18 7.25-4.18 7.25H-8.37m8.38 58l12.73-21.75m-25.3 14.5L0 43.5m-8.37-29l21.1 36.25 20.94 36.24M8.37 72.5H-8.36'  stroke-width='0.5' stroke='hsla(200, 68%, 66%, 1)' fill='none'/></pattern></defs><rect width='800%' height='800%' transform='translate(0,0)' fill='url(%23a)'/></svg>");
            
            background-color: #eee;
            /* background-repeat: no-repeat; */
            /* background-position: center center; */
            /* background-color: #927748; */
        }

        .item-container {
            padding: 0 10%;
            margin: 5% 0;
        }

        .item-sub-container {
            display: flex;
            flex-direction: column;

            position: relative;
            padding: 1rem;
            gap: 1rem;
            background-color: #C4D5E7;

            border-radius: 0.5rem;

            box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2);
        } 
        
        .item-sub-sub-container-1 {
            display: flex;
            /* padding: 0 10%; */
            /*   background-color: #6CBCE3; */
            /*   padding: 1rem; */
            gap: 1rem;

            /*   border-radius: 0.5rem; */

            /*   box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2); */
        }

        .item-sub-sub-container-1 > div {
            background-color: #C4D5E7;
            width: 50%;

            border-radius: 0.5rem;

            /* box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2); */
        }

        .image-wrapper {
            /* padding: 1rem; */
            overflow: hidden;
        }

        .image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .info {
            padding: 1rem;
            gap: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .info > p[ptype='winner'] {
            background-color: #443B6C;
            padding: 1rem;
            border-radius: 0.5rem;
            color: #C4D5E7;
            font-size: 1.2rem;
            text-align: center;
        }

        .info .title {
            color: #1E68B6;
            font-weight: 600;
            font-size: 2.5rem;
        }

        .info div {
            display: flex;
            justify-content: space-between;
        }

        .info div div {
            display: block;
            color: #1B1A38;
            font-weight: 600;
            outline: 2px dashed #1B1A38;
            /* width: 50%; */
            background-color: #C4D5E7;
            border-radius: 0.5rem;

            /* box-shadow: inset 0 0 0.4rem rgba(0, 0, 0, 0.2), 0 0 0.4rem rgba(0, 0, 0, 0.2); */

            /* box-shadow: 0 0 0.4rem rgba(0, 0, 0, 0.2); */

            padding: 1rem;
        }

        .info div div .price {
            font-size: 2rem;
            /* font-size: 1.5rem; */
            font-weight: 600;
            color: #443B6C;
        }

        /* .info hr {
            border: 0;
            height: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        } */

        .info button {
            font-size: 1.5rem;
            /* margin: 1rem; */

            width: calc(50% - 2.5vw);

            /* font-size: 1rem; */
            color: white;
            background-color: #1E68B6;
            border: none;
            border-radius: 0.5rem;
            /* box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2), inset 0 0.3rem 0.4rem rgba(255, 255, 255, 0.2); */
            box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2);

            padding: 1rem;

            transition: background-color 200ms ease-out;
        }
        
        .info button:active {
            /* scale: 0.98; */
            background-color: #443B6C;
            box-shadow: inset 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2);
        }

        .item-sub-sub-container-2 {
            display: flex;
            gap: 1rem;
        }

        .item-sub-sub-container-2 > div {
            color: #1B1A38;
            font-weight: 600;
            background-color: #C4D5E7;
            width: 50%;

            display: flex;
            justify-content: center;
            /* align-items: center; */
            flex-direction: column;

            padding: 1rem;

            border-radius: 0.5rem;

            /* box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2); */
        }

        .item-sub-sub-container-2 div .time {
            color: #1E68B6;
            font-size: 2rem;
            font-weight: 600;
        }

        .item-sub-sub-container-2 div .condition {
            color: #443B6C;
            font-size: 2rem;
            font-weight: 600;
        }


        .bidding-form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1;
            width: 100%;
            height: 100vh;
            transform: translateY(-100%);

            transition: transform 500ms ease-out;
        }
        
        .bidding-form-backdrop {
            position: absolute;
            z-index: -1;
            height: 100%;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .bidding-form-activate {
            display: flex;
            transform: translateY(0%);
        }

        .bidding-form {
            padding: 2rem;
            /* margin-left: -1rem; */
            /* position: relative; */
            left: 50%;
            /* transform: translateX(-50%); */
            width: 50%;
            background-color: #C4D5E7;
            /* box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2), inset 0 0.3rem 0.4rem rgba(255, 255, 255, 0.2); */
            box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2);

            border-radius: 1rem;
        }

        .bidding-form .bid-alert {
            display: flex;
            justify-content: center;
            align-items: center;

            /* position: absolute; */

            width: 100%;
            
            /* height: 100%; */
            padding: 1rem;

            font-size: 1.5rem;
        }

        .bidding-form .bid-alert-success {
            background-color: lightgreen;
            color: green;
        }

        .bidding-form .bid-alert-error {
            background-color: orangered;
            color: maroon;
        }

        .bidding-form .row {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .bid-input-container {
            padding: 0.7rem 0;
        }


        .bid-input-container p {
            padding: 0.5rem 0;
            color: #1E68B6;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .bid-input-container input, .bid-input-container select, .bid-input-container option {
            color: #1B1A38;
            font-size: 1rem;
            padding: 0.5rem 0.5rem;
            width: 100%;
            border: 2px solid #6CBCE3;
            /* outline: 2px solid #1E68B6; */
            border-radius: 0.3rem;
            background-color: transparent;
        }

        .bid-input-container input:focus, .bid-input-container select:focus {
            outline: none;
        }

        .bid-input-container input::placeholder {
            color: gray;
        }

        .bid-button-container {
            display: flex;
            justify-content: center;

            padding: 1rem 0rem;
            width: 100%;
        }

        .bid-button-container button {
            display: flex;
            justify-content: center;
            align-items: center;
            color: #eee;
            /* width: 30%; */
            font-size: 1.5rem;
            /* font-weight: 600; */
            padding: 1rem 2rem;
            /* margin: 1rem; */

            border: none;
            border-radius: 0.5rem;
            /* background-image: linear-gradient(90deg, #6CBCE3, #C4D5E7); */
            /* background-image: linear-gradient(90deg, #6CBCE3, #1E68B6); */
            background-color: #443B6C;
            
            /* box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2), inset 0 0.3rem 0.4rem rgba(255, 255, 255, 0.2); */
            box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2);

            transition: background-color 200ms ease-out;
        }

        .bid-button-container button i {
            /* margin: 0 0px; */
            font-size: 1rem;
        }
        
        .bid-button-container button:active {
            /* scale: 0.95; */
            /* color: lightgray; */
            background-color: #3e3562;
            box-shadow: inset 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2);
        }

    </style>
</head>

<body>
<header>
        <div class="banner-image">
            <img src="auction-banner.jpg" alt="">
        </div>
        <div class="banner-container">
            <h1 class="logo">AuctioNet</h1>
            <?php
                if (isset($_SESSION['username'])) { 
            ?>
            <div class="account-container">
                <div class="updates-container">
                    <p class="updates-header">Your Recent Bids</p>
                    <?php
                        $query3 = "SELECT BidID, Bids.ItemID, Name, BidAmount, BidTime, WinStatus
                        FROM Bids, Items
                        WHERE Items.ItemID = Bids.ItemID AND Bids.BuyerID = $buyerID
                        ORDER BY BidID DESC LIMIT 3;";
                        $result3 = mysqli_query($con, $query3);
                        if (mysqli_num_rows($result3) > 0) {
                            while ($row3 = mysqli_fetch_assoc($result3)) {
                    ?>
                    <hr>
                    <p>₹<?php echo $row3['BidAmount']; ?> on <?php echo $row3['Name']; ?></p>
                    <?php 
                            }
                        } else {
                    ?>
                    <p>No records found</p>
                    <?php
                        }
                    ?>
                </div>
                <i class="fa-regular fa-bell"></i>
                <a href="http://localhost/apna-Project/buyer_account.php?buyer_id=<?php echo $buyerID; ?>"><p> <?php echo $_SESSION['username']; ?> </p></a>
                <i class="fa-solid fa-chevron-down"></i>
                <div class="account-menu">
                    <a href="http://localhost/apna-Project/logout.php"><button><i class="fa-solid fa-right-to-bracket"></i>Logout</button></a>
                </div>
            </div>
            <?php } else { ?>
            <div class="account-container">
                <a href="http://localhost/apna-Project/login.php"><p><i class="fa-solid fa-right-to-bracket" style="padding: 0;"></i> Login required</p></a>
            </div>
            <?php } ?>
        </div>
        <hr>
        <nav>
            <a href="http://localhost/apna-Project/index.php" class="icon home"><span></span>Home</a>

            <?php         
                if (isset($_SESSION['username'])) { 
            ?>
            <a href="http://localhost/Apna-Project/logout.php" class="icon logout"><span></span>Log out</a>
            <?php 
                } else { 
            ?>
            <a href="http://localhost/Apna-Project/login.php" class="icon login"><span></span>Login</a>
            <a href="http://localhost/Apna-Project/signup.php" class="icon signup"><span></span>Sign Up</a>
            <?php 
                } 
            ?>
            <a href="http://localhost/Apna-Project/about_us.php" class="icon about"><span></span>About Us</a>
            <a href="http://localhost/Apna-Project/contact_us.php" class="icon contact"><span></span>Contact Us</a>
        </nav>
    </header>
    <?php
        if (isset($_POST['registerbid'])) {
            $accountNo = $_POST['accountno'];
            $bidAmount = $_POST['bidamount'];
    
            $query4 = "SELECT * FROM `Buyer` WHERE `Username` = '$username';";
            $result4 = mysqli_query($con, $query4);
            $row4 = mysqli_fetch_assoc($result4);
            $buyerID = $row4['BuyerID'];
    
            $query4 = "SELECT * FROM Accounts WHERE AccountNo = '$accountNo' AND BuyerID = '$buyerID';";
            $result4 = mysqli_query($con, $query4);
            $row4 = mysqli_fetch_assoc($result4);
            // var_dump($row4);
    
            if ($row4 > 0) {
                $query5 = "SELECT * FROM Bids 
                WHERE ItemID = $itemID AND BidAmount = (
                    SELECT MAX(BidAmount) FROM Bids 
                    WHERE ItemID = $itemID 
                );";
                $result5 = mysqli_query($con, $query5);
                $row5 = mysqli_fetch_assoc($result5);
                $minBidAmount = 0;
                if ($row5 > 0) {
                    $minBidAmount = $row5['BidAmount'];
                }
                if ($bidAmount > $minBidAmount) {
                    $query5 = "INSERT INTO Bids (ItemID, BuyerID, BidAmount, BidTime) VALUES ($itemID, $buyerID, $bidAmount, now());";
                    $result5 = mysqli_query($con, $query5);
                    if ($result5 == true) {
                        $bidSuccess = true;
                    } else {
                        $bidSuccess = false;
                    }
                } else {
                    $lessThanMinBidAmount = true;
                }
            } else {
                $accountNoInvalid = true;
            }
        }
    ?>

    <?php
        if (isset($_SESSION['username'])) { 
    ?>
    <section class="bidding-form-container <?php if (isset($_POST['registerbid'])) { echo 'bidding-form-activate';  } ?>">
        <div class="bidding-form-backdrop" onclick="toggleModal()">
    
        </div>
        <form action="item_details.php?item_id=<?php echo $itemID ?>" method="post" class="bidding-form">
            <?php if ($accountNoInvalid == true) { ?>
            <div class="bid-alert bid-alert-error">
                <p>Account Number is invalid.</p>
                <?php echo $accountNoInvalid; ?>
            </div>
            <?php } ?>

            <?php if ($lessThanMinBidAmount == true) { ?>
            <div class="bid-alert bid-alert-error">
                <p>Your bid is less than current bid amount.</p>
                <?php echo $lessThanMinBidAmount; ?>
            </div>
            <?php } ?>

            <?php if (!isset($bidSuccess)) { ?>

            <?php } else { ?>
                <?php if ($bidSuccess == true) { ?>
                <div class="bid-alert bid-alert-success">
                    <p>Bid was registered.</p>
                </div>
                <?php } elseif ($bidSuccess == false) { ?>
                <div class="bid-alert bid-alert-error">
                    <p>Bid was not registered.</p>
                </div>
                <?php } ?>
            <?php } ?>
            <?php
                $query2 = "SELECT * FROM `Buyer` WHERE `Username` = '$username';";
                $result2 = mysqli_query($con, $query2);
                $row2 = mysqli_fetch_assoc($result2);
                $buyerID = $row2['BuyerID'];
                // var_dump($row2);
            ?>
            <div class="row">
                <div class="bid-input-container">
                    <p>First name: </p>
                    <input type="text" name="fname" id="" value="<?php echo $row2['Fname']; ?>" readonly>
                </div>
                <div class="bid-input-container">
                    <p>Last name: </p>
                    <input type="text" name="lname" id="" value="<?php echo $row2['Lname']; ?>" readonly>
                </div>
            </div>
            <div class="row">
                <div class="bid-input-container">
                    <p>Email: </p>
                    <input type="email" name="email" id="" value="<?php echo $row2['Email']; ?>" readonly>
                </div>
                <div class="bid-input-container">
                    <p>Phone number: </p>
                    <input type="number" name="phoneno" id="" value="<?php echo $row2['PhoneNo']; ?>" readonly>
                </div>
            </div>
            <?php
                $query3 = "SELECT * FROM `Items` WHERE `ItemID` = '$itemID';";
                $result3 = mysqli_query($con, $query3);
                $row3 = mysqli_fetch_assoc($result3);
                // var_dump($row3);
            ?>
            <div class="row">
                <div class="bid-input-container">
                    <p>Item name :</p>
                    <input type="email" name="email" id="" value="<?php echo $row3['Name']; ?>" readonly>
                </div>
                <div class="bid-input-container">
                    <p>Item Description :</p>
                    <input type="text" name="phoneno" id="" value="<?php echo $row3['Description']; ?>" readonly>
                </div>
            </div>
            <div class="row">
                <div class="bid-input-container">
                    <p>Item Condition :</p>
                    <input type="text" name="email" id="" value="<?php echo $row3['Item_Condition']; ?>" readonly>
                </div>
                <div class="bid-input-container">
                    <p>Category :</p>
                    <input type="text" name="phoneno" id="" value="<?php echo $row3['Category']; ?>" readonly>
                </div>
            </div>
            <div class="row">
                <div class="bid-input-container">
                    <p>Account Number :</p>
                    <input type="number" name="accountno" id="" value="" placeholder="Enter bank account number" required>
                </div>
                <div class="bid-input-container">
                    <p>Bid Amount :</p>
                    <input type="number" name="bidamount" id="" value="" placeholder="Enter the bid amount" required>
                </div>
            </div>
            <div class="row">
                <div class="bid-button-container">
                    <button type="submit" name="registerbid">Register Bid</button>
                </div>
            </div>
        </form>
    </section>
    <?php 
        } 
    ?>

    <section class="item-container">
        <div class="item-sub-container">
            <?php
                $query1 = "SELECT * FROM `Items` 
                WHERE `ItemID` = '$itemID';";
                $result1 = mysqli_query($con, $query1);
                $row1 = mysqli_fetch_assoc($result1);
                // var_dump($row1);
                $currentPrice = "₹".$row1['StartBidAmount'];

                $query6 = "SELECT * FROM Bids 
                WHERE ItemID = $itemID AND BidAmount = (
                    SELECT MAX(BidAmount) FROM Bids 
                    WHERE ItemID = $itemID 
                );";
                $result6 = mysqli_query($con, $query6);
                $row6 = mysqli_fetch_assoc($result6);

                if ($row6 > 0) {
                    $currentPrice = "₹".$row6['BidAmount'];
                }

                $yourBidAmount = 'None';

                if (isset($_SESSION['username'])) { 
                    $query6 = "SELECT * FROM Bids 
                    WHERE `BuyerID` = $buyerID AND `ItemID` = $itemID AND `BidAmount` = (
                        SELECT MAX(BidAmount) FROM Bids 
                        WHERE `BuyerID` = $buyerID AND `ItemID` = $itemID
                    );";
                    $result6 = mysqli_query($con, $query6);
                    $row6 = mysqli_fetch_assoc($result6);
                    if ($row6 > 0) {
                        $yourBidAmount = "₹".$row6['BidAmount'];
                    }
                }

            ?>
            <div class="item-sub-sub-container-1">
                <div class="image-wrapper">
                    <img src="<?php echo $row1['Photo']; ?>" alt="">
                </div>
                <div class="info">
                    <H3 class="title"><?php echo $row1['Name']; ?></H3>
                    <p class="description"><?php echo $row1['Description']; ?></p>

                    <div>
                        <div>
                            <p>Current Auction Price :</p>
                            <p class="price"><?php echo $currentPrice; ?></p>
                        </div>
                        <div>
                            <p>Your Bid Amount :</p>
                            <p class="price"><?php echo $yourBidAmount; ?></p>
                        </div>
                    </div>
                    <hr>
                    <?php 
                        if ($auctionOver == true) { 
                            $query9 = "SELECT * FROM Bids WHERE ItemID = $itemID AND Winstatus = 'Yes';";
                            $result9 = mysqli_query($con, $query9);
                            $row9 = mysqli_fetch_assoc($result9);

                            if ($row9 > 0) {
                                $winnerBuyerID = $row9['BuyerID'];
                                $query9 = "SELECT * FROM Buyer WHERE BuyerID = $winnerBuyerID;";
                                $result9 = mysqli_query($con, $query9);
                                $row9 = mysqli_fetch_assoc($result9);
                            
                    ?>
                            <p ptype="winner">The winner of this auction is <?php echo $row9['Fname']." "; echo $row9['Lname']; ?></p>
                    <?php   } else { ?>
                            <p ptype="winner">Item was not sold</p>
                    <?php   } ?>
                    <?php
                        } else { 
                            if (isset($_SESSION['username'])) {
                                if (new DateTime() < new DateTime($row1['AuctionStart'])) {
                    ?>
                                <button type="submit" id="bid-btn" onclick="alert('Auction will begin soon.');">BID</button>
                    <?php
                                } else {
                    ?>
                                <button type="submit" id="bid-btn" onclick="toggleModal()">BID</button>
                    <?php
                                }
                            } else {
                    ?>
                                <button type="submit" id="bid-btn" onclick="alert('Please login to continue bidding.');">BID</button>
                    <?php
                            }
                    ?>
                    <?php } ?>
                </div>
            </div>
            <div class="item-sub-sub-container-2">
                <div>
                    <p>Auction Start Time :</p>
                    <p class="time"><?php echo (new DateTime($row1['AuctionStart']))->format("d/m/Y"); ?></p>
                </div>
                <div>
                    <p>Auction End Date :</p>
                    <p class="time"><?php echo (new DateTime($row1['AuctionEnd']))->format("d/m/Y"); ?></p>
                </div>
                <div>
                    <p>Auction time left :</p>
                    <p class="time" id="time">
                        <script>
                            // Set the date we're counting down to
                            var countDownDate = new Date("<?php echo $row1['AuctionEnd']; ?>").getTime();

                            // Update the count down every 1 second
                            var x = setInterval(function() {

                                // Get today's date and time
                                var now = new Date().getTime();

                                // Find the distance between now and the count down date
                                var distance = countDownDate - now;

                                // Time calculations for days, hours, minutes and seconds
                                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                // Display the result in the element with id="demo"
                                document.getElementById("time").innerHTML = days + "d " + hours + "h "
                                + minutes + "m " + seconds + "s ";

                                // If the count down is finished, write some text
                                if (distance < 0) {
                                    clearInterval(x);
                                    document.getElementById("time").innerHTML = "EXPIRED";
                                }
                            }, 1000);
                        </script>
                    </p>
                </div>
                <div>
                    <p>Item Condition :</p>
                    <p class="condition"><?php echo $row1['Item_Condition']; ?></p>
                </div>
            </div>
        </div>
    </section>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        function toggleModal () {
            const biddingBackDrop = document.querySelector(".bidding-form-container");
            biddingBackDrop.classList.toggle("bidding-form-activate");
        };

        const updatesMenu = document.querySelector(".updates-container");
        const bell = document.querySelector(".fa-bell");
        bell.addEventListener("click", () => {
            updatesMenu.classList.toggle("activate-updates");
        });

        const arrow = document.querySelector(".fa-chevron-down");
        const accountMenu = document.querySelector(".account-menu");
        arrow.addEventListener("click", () => {
            arrow.classList.toggle("rotate-arrow");
            accountMenu.classList.toggle("activate-account");
        });
    </script>
</body>

</html>