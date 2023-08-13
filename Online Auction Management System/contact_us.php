<?php
    include 'db_connect.php';
    session_start();
?>

<!-- Retrive BuyerID from Username -->
<?php
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query1 = "SELECT * FROM `Buyer` WHERE `Username` = '$username';";
    $result1 = mysqli_query($con, $query1);
    $row1 = mysqli_fetch_assoc($result1);
    $buyerID = $row1['BuyerID'];
}
?>

<!-- Logic for insertion on Ships table (Automatic) -->
<?php
    $query1 = "SELECT * FROM Bids WHERE WinStatus = 'Yes';";
    $result1 = mysqli_query($con, $query1);
    while($row1 = mysqli_fetch_assoc($result1)) {
        $query2 = "SELECT * FROM Ships WHERE ItemID = $row1[ItemID] AND BuyerID = $row1[BuyerID];";
        $result2 = mysqli_query($con, $query2);
        $row2 = mysqli_fetch_assoc($result2);
        if ($row2 > 0) {
            continue;
        } else {
            $query = "SELECT * FROM Items WHERE ItemID = $row1[ItemID];";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);
            $shipDay = "P".RAND(1, 5)."D";
            $shipDate = ((new DateTime($row['AuctionEnd']))->add(new DateInterval($shipDay)))->format('Y-m-d H:i:s');
            echo $shipDate;
            echo "<br/>";
            $arrivalDay = "P".RAND(6, 9)."D";
            $arrivalDate = ((new DateTime($row['AuctionEnd']))->add(new DateInterval($arrivalDay)))->format('Y-m-d H:i:s');
            echo $arrivalDate;
            $query2 = "INSERT INTO Ships (ItemID, ShipPrice, ShipDate, ArrivalDate, BuyerID, SellerID) VALUES ($row1[ItemID], $row1[BidAmount], '$shipDate', '$arrivalDate', $row1[BuyerID], $row[SellerID]);";
            mysqli_query($con, $query2);
        }
    };
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&family=DM+Serif+Display&family=Kaushan+Script&family=Merienda:wght@700&family=Rammetto+One&display=swap" rel="stylesheet">

    <style>
        /* color palette */
        /* #1E68B6 */
        /* #C4D5E7 */
        /* #6CBCE3 */
        /* #1B1A38 */
        /* #443B6C */
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            
            font-family: sans-serif;

            /* outline: 2px solid green; */
            
            color: #1B1A38;
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

        /* Header */

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

        .container-2 {
            padding: 0rem 10%;
            margin: 8rem 0;
            /* background-color: #C4D5E7; */
        }

        .container-3 {
            padding: 3rem;
            background-color: #C4D5E7;
            /* border-radius: 0.5rem; */
        }

        .container-3:first-child {
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }

        .container-3:last-child {
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
        }

        .container-3 h1 {
            font-size: 5rem;
            padding: 3rem 0;
            /* font-family: 'DM Serif Display'; */
            font-family: 'Merienda';
            /* font-family: 'Rammetto One'; */
            color: #1E68B6;
        }

        .container-3 h2 {
            font-size: 3rem;
            padding: 2rem 0;
            color: #443B6C;
        }

        .container-3 p, .container-3 pre {
            font-size: 1.5rem;
            color: #1B1A38;
            line-height: 2rem;
            margin: 2rem 0;
        }

        .container-3 p a {
            color: #1E68B6;
            text-decoration: none;
        }

        .container-3 p a:visited {
            color: #1E68B6;
        }

        #facebook {
            color: #4267B2;
        }
        
        #twitter {
            color: #00acee;
        }
        
        #instagram {
            color: #d62976;
        }

        .container-3 p a:hover {
            color: #443B6C !important;
        }
    </style>
</head>
<body>
    <header>
        <div class="banner-image">
            <!-- <img src="auction-banner.jpg" alt=""> -->
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
                    <p>$<?php echo $row3['BidAmount']; ?> on <?php echo $row3['Name']; ?></p>
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
    <section class="container-2">
        <div class="container-3">
            <h1>Contact Us</h1>
            <p>At <i>AuctioNet</i>, we're always here to help. Whether you have a question about our platform, a problem with an auction, or just want to provide some feedback, we're here to listen.</p>

            <!-- <h2>Phone Number</h2> -->

            <p>Here are some ways to get in touch with us:</p>

            <p><b>Phone:</b> +91 8638140030</p>

            <p><b>Email:</b> <a href="">support@auctionet.com</a></p>

<pre>
<b>Mail:</b> AuctioNet, Inc
Lalganesh,
Guwahati - 781034, Assam
</pre>

            <p><b>Social Media:</b> Follow us on Social Media handles such as <a href="" id="facebook">Facebook</a>, <a href="" id="twitter">Twitter</a>, <a href="" id="instagram">Instagram</a>  for the latest news, updates, and behind-the-scenes looks at <i>AuctioNet</i>.</p>

            <p>Thank you for choosing <i>AuctioNet</i>. We look forward to hearing from you soon.</p>
        </div>
    </section>
    <section class="container-2">
    </section>
<script>
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