<?php
    include 'db_connect.php';
    session_start();

    $buyerID = $_GET['buyer_id'];
?>

<?php
    if (!isset($_SESSION['username'])) {
?>
    <script>
        window.history.back();
    </script>
<?php
    }
?>

<?php
    if (isset($_POST['save'])) {
        $Username = $_POST['uname'];
        $Password = $_POST['password'];
        $Fname = $_POST['fname'];
        $Lname = $_POST['lname'];
        $Street = $_POST['street'];
        $AptNo = $_POST['aptno'];
        $City = $_POST['city'];
        $State = $_POST['state'];
        $ZipCode = $_POST['zipcode'];
        $Email = $_POST['email'];
        $PhoneNo = $_POST['phoneno'];
        $AccountNo = $_POST['accountno'];
        $AccountType = $_POST['accounttype'];
        $query2 = "UPDATE Buyer 
        SET Username = '$Username', Password = '$Password', Fname = '$Fname', Lname = '$Lname', Street = '$Street', AptNo = $AptNo, City = '$City', State = '$State', ZipCode = '$ZipCode', Email = '$Email', PhoneNo = '$PhoneNo'
        WHERE BuyerID = $buyerID;";
        $result2 = mysqli_query($con, $query2);

        $query3 = "UPDATE Accounts
        SET AccountNo = '$AccountNo', AccountType = '$AccountType'
        WHERE BuyerID = $buyerID;";
        $result3 = mysqli_query($con, $query3);
        if ($result2 == true && $result3 == true) {
            $_SESSION['username'] = $Username;
?>
    <script>
        alert("Update was successful");
    </script>
<?php
        } else {  
?>
    <script>
        alert("Update was not successful");
    </script>
<?php
        }
    }
?>

<?php
    if (isset($_POST['confirm-yes-delete'])) {
        $query3 = "DELETE
        FROM Buyer
        WHERE BuyerID = $buyerID;";
        $result3 = mysqli_query($con, $query3);
        if ($result3 == true) {
?>
    <script>
        alert("Delete was successful");
        // Replace the current history entry with a new state object
        history.replaceState({}, "", "http://localhost/apna-Project/index.php");

        // Navigate to the new URL
        window.location.href = "http://localhost/apna-Project/logout.php";
    </script>
<?php
        } else {
?>
    <script>
        alert("Delete was not successful");
    </script>
<?php
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>

    <!-- Font Awesome cdn -->
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
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            /* outline: 2px solid green; */
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

        .confirmation-modal-bg {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;

            z-index: 2;
        }

        .confirmation-modal {
            background-color: #C4D5E7;
            padding: 2rem;

            border-radius: 0.5rem;
        }

        .confirmation-modal p {
            font-size: 1.5rem;
            color: #1E68B6;
        }

        body {    
            background-image: url("data:image/svg+xml,<svg id='patternId' width='100%' height='100%' xmlns='http://www.w3.org/2000/svg'><defs><pattern id='a' patternUnits='userSpaceOnUse' width='50.41' height='87' patternTransform='scale(4) rotate(15)'><rect x='0' y='0' width='100%' height='100%' fill='hsla(0,0%,100%,1)'/><path d='M25.3 87L12.74 65.25m0 14.5h-25.12m75.18 0H37.68M33.5 87l25.28-43.5m-50.23 29l4.19 7.25L16.92 87h-33.48m33.48 0h16.75-8.37zM8.55 72.5L16.92 58m50.06 29h-83.54m79.53-50.75L50.4 14.5M37.85 65.24L50.41 43.5m0 29l12.56-21.75m-50.24-14.5h25.12zM33.66 29l4.2 7.25 4.18 7.25M33.67 58H16.92l-4.18-7.25M-8.2 72.5l20.92-36.25L33.66 0m25.12 72.5H42.04l-4.19-7.26L33.67 58l4.18-7.24 4.19-7.25M33.67 29l8.37-14.5h16.74m0 29H8.38m29.47 7.25H12.74M50.4 43.5L37.85 21.75m-.17 58L25.12 58M12.73 36.25L.18 14.5M0 43.5l-12.55-21.75M24.95 29l12.9-21.75M12.4 21.75L25.2 0M12.56 7.25h-25.12m75.53 0H37.85M58.78 43.5L33.66 0h33.5m-83.9 0h83.89M33.32 29H16.57l-4.18-7.25-4.2-7.25m.18 29H-8.37M-16.74 0h33.48l-4.18 7.25-4.18 7.25H-8.37m8.38 58l12.73-21.75m-25.3 14.5L0 43.5m-8.37-29l21.1 36.25 20.94 36.24M8.37 72.5H-8.36'  stroke-width='0.5' stroke='hsla(200, 68%, 66%, 1)' fill='none'/></pattern></defs><rect width='800%' height='800%' transform='translate(0,0)' fill='url(%23a)'/></svg>");
            
            /* background-size: 1.5%; */
            /* background-repeat: no-repeat; */
            background-color: #eee;
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
        
        .banner-container .account-container a, .account-container a:visited {
            padding: 0;
            /* height: 95%; */
            text-decoration: none;
            /* margin: -2px; */
            color: inherit;
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

        .acc-container {
            display: flex;
            justify-content: center;
            margin: 2rem 0;
            /* align-items: center; */
            /* height: 100vh; */
        }

        .acc-sub-container {
            background-color: #C4D5E7;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2);
        }

        .acc-sub-2-container-1 h1 {
            color: #1E68B6;
        }
        
        .row {
            display: flex;
            justify-content: space-between;
            gap: 3rem;
            /* padding: 1rem 0rem; */
        }

        .row h2 {
            color: #6CBCE3;
            padding-top: 2rem;
        }
        
        .acc-input-container {
            padding: 0.7rem 0;
            width: 100%;
        }


        .acc-input-container p {
            padding: 0.5rem 0;
            color: #1E68B6;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .acc-input-container input, .acc-input-container select, .acc-input-container option {
            color: black;
            font-size: 1rem;
            padding: 0.5rem 0.5rem;
            width: 100%;
            border: 2px solid #6CBCE3;
            /* outline: 2px solid #1E68B6; */
            border-radius: 0.3rem;
            background-color: transparent;
        }

        .acc-input-container input:focus, .acc-input-container select:focus {
            outline: none;
        }

        .acc-input-container input::placeholder {
            color: gray;
        }

        .acc-input-container button {
            padding: 0.5rem 1rem;
            background-color: #443B6C;
            border-radius: 0.5rem;
            border: none;
            color: white;
            font-size: 1rem;
            /* transition: background-color 200ms ease-out; */
        }

        .acc-input-container button:hover {
            background-color: #524783;
        }

        .acc-input-container button:active {
            background-color: #3e3562;
        }

        #confirm-yes:hover, #delete-btn:hover {
            background-color: #6c3b3b;
        }

        .hide {
            display: none;
        }

        .center {
            display: flex;
            /* width: 100%; */
            justify-content: center;
            gap: 2rem;
        }

        .bid-table-container {
            width: 100%;
            padding: 1rem 0;
        }

        .bid-table {
            width: 100%;
            /* border: 2px solid #6CBCE3; */
            border-collapse: collapse;
            padding: 1rem;
        }

        .bid-table tr {
            border-bottom: 2px solid #6CBCE3;
            background-color: #C4D5E7;
            opacity: 1;
            /* background-color: #1E68B6; */
        }

        .bid-table tr:nth-child(even) {
            background-color: #bed1e6;
        }

        .bid-table tr:first-child {
            background-color: #6CBCE3;
        }

        .bid-table tr:hover {
            background-color: #c8daee;
            /* scale: 1.01; */
        }

        .bid-table tr:first-child:hover {
            background-color: #6CBCE3;
        }

        .bid-table th {
            color: #1E68B6;
        }

        .bid-table th, .bid-table td {
            padding: 1rem 2rem;
            text-align: center;
            /* border: 2px solid #6CBCE3; */
        }

        .bid-table td {
            color: #443B6C;
        }
    </style>
</head>
<body>
    <div id="modal" class="confirmation-modal-bg hide">
        <form class="confirmation-modal" action="http://localhost/apna-Project/buyer_account.php?buyer_id=<?php echo $buyerID; ?>" method="POST">
            <p>Please confirm that you want to delete your account.</p>
            <div class="row">
                <div class="acc-input-container center">
                    <button id="confirm-yes" type="submit" name="confirm-yes-delete">Yes</button>
                    <button id="confirm-no" type="button">No</button>
                </div>
            </div>
        </form>
    </div>
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
        $username = $_SESSION['username'];
        $query1 = "SELECT * FROM `Buyer` WHERE `Username` = '$username';";
        $result1 = mysqli_query($con, $query1);
        $row1 = mysqli_fetch_assoc($result1);
    ?>
    <div class="acc-container">
        <div class="acc-sub-container">
            <div class="acc-sub-2-container-1">
                <h1>Hi, <?php echo $username; ?> </h1>
            </div>
            <form class="acc-sub-2-container-2" action="http://localhost/apna-Project/buyer_account.php?buyer_id=<?php echo $buyerID; ?>" method="POST">
                <div class="row">
                    <h2>Profile</h2>
                </div>
                <div class="row">
                    <div class="acc-input-container">
                        <p>First Name</p>
                        <input type="text" name="fname" id="" value="<?php echo $row1['Fname']; ?>" placeholder="Enter your first name" required readonly>
                    </div>
                    <div class="acc-input-container">
                        <p>Last Name</p>
                        <input type="text" name="lname" id="" value="<?php echo $row1['Lname']; ?>" placeholder="Enter your last name" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="acc-input-container">
                        <p>Username</p>
                        <input type="text" name="uname" id="" value="<?php echo $row1['Username']; ?>" placeholder="Enter your username name" required readonly>
                    </div>
                    <div class="acc-input-container">
                        <p>Password</p>
                        <input type="password" name="password" id="" value="<?php echo $row1['Password']; ?>" placeholder="Enter your password" required readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="acc-input-container">
                        <p>Email</p>
                        <input type="email" name="email" id="" value="<?php echo $row1['Email']; ?>" placeholder="Enter your email" required readonly>
                    </div>
                    <div class="acc-input-container">
                        <p>Phone Number</p>
                        <input type="text" name="phoneno" id="" value="<?php echo $row1['PhoneNo']; ?>" placeholder="Enter your phone number" maxlength="10" pattern="[0-9]{10}" title="Enter 10-digit Phone Number" required readonly>
                    </div>
                </div>
                <div id="readonly-row" class="row">
                    <div class="acc-input-container">
                        <p>Address</p>
                        <input type="text" name="" id="" value='<?php echo "$row1[AptNo], $row1[Street], $row1[City] - $row1[ZipCode], $row1[State]"; ?>' readonly>
                    </div>
                </div>
                <div id="rw-row-1" class="row hide">
                    <div class="acc-input-container">
                        <p>Apartment Number</p>
                        <input type="text" name="aptno" id="" value="<?php echo $row1['AptNo']; ?>" placeholder="Enter your apartment number" required readonly>
                    </div>
                    <div class="acc-input-container">
                        <p>Street</p>
                        <input type="text" name="street" id="" value="<?php echo $row1['Street']; ?>" placeholder="Enter your street" required readonly>
                    </div>
                    <div class="acc-input-container">
                        <p>City</p>
                        <input type="text" name="city" id="" value="<?php echo $row1['City']; ?>" placeholder="Enter your city" required readonly>
                    </div>
                </div>
                <div id="rw-row-2" class="row hide">
                    <div class="acc-input-container">
                        <p>ZipCode</p>
                        <input type="text" name="zipcode" id="" value="<?php echo $row1['ZipCode']; ?>" placeholder="Enter your zipcode" required readonly>
                    </div>
                    <div class="acc-input-container">
                        <p>State</p>
                        <input type="text" name="state" id="" value="<?php echo $row1['State']; ?>" placeholder="Enter your state" required readonly>
                    </div>
                </div>
                <?php
                    $query1 = "SELECT * FROM `Accounts` WHERE `BuyerID` = $buyerID;";
                    $result1 = mysqli_query($con, $query1);
                    $row1 = mysqli_fetch_assoc($result1);
                ?>
                <div class="row">
                    <div class="acc-input-container">
                        <p>Account Number</p>
                        <input type="text" name="accountno" id="" value="<?php echo $row1['AccountNo']; ?>" placeholder="Enter your 16-digit account number" maxlength="16" pattern="[0-9]{16}" title="Enter 16-Digit account number" required readonly>
                    </div>
                    <div class="acc-input-container">
                        <p>Account Type</p>
                        <!-- <input type="text" name="accounttype" id="" placeholder="Enter account type" required> -->
                        <Select id="accounttype" name="accounttype" required disabled>
                            <option value="">Select Account Type</option>
                            <option value="Visa">Visa</option>
                            <option value="Mastercard">Mastercard</option>
                            <option value="Rupay">Rupay</option>
                            <option value="DISCOVER">DISCOVER</option>
                        </Select>
                    </div>
                    
                    <!-- Javascript code to select the AccountType -->
                    <script>
                        var selectValue = "<?php echo $row1['AccountType']; ?>";
                        var accountType = document.getElementById('accounttype');

                        // Loop through the options in the select element
                        for (var i = 0; i < accountType.options.length; i++) {
                            // If the value of the current option matches the selected value from the database
                            if (accountType.options[i].value == selectValue) {
                                // Set the selected attribute on the option
                                accountType.options[i].selected = true;
                            }
                        }
                    </script>
                </div>
                <div class="row">
                    <div class="acc-input-container">
                        <button type="button" id="edit-btn" class=""><i class="fa-regular fa-pen-to-square"></i> Edit</button>
                        <button type="button" id="cancel-btn" class="hide"><i class="fa-solid fa-xmark"></i> Cancel</button>
                        <button type="submit" name="save" id="save-btn" class="hide"><i class="fa-regular fa-floppy-disk"></i> Save</button>
                        <button type="button" name="delete" id="delete-btn" class=""><i class="fa-regular fa-trash-can"></i> Delete</button>
                    </div>
                </div>
            </form>
            <div class="acc-sub-2-container-3">
                <div class="row">
                    <h2>Bid History</h2>
                </div>
                <div class="row">
                    <div class="bid-table-container">
                        <table class="bid-table">
                            <tr>
                                <th>Bid ID</th>
                                <th>Item ID</th>
                                <th>Item Name</th>
                                <th>Bid Amount</th>
                                <th>Bid Time</th>
                                <!-- <th>Win Status</th> -->
                            </tr>
                            <?php
                                $query2 = "SELECT BidID, Bids.ItemID, Name, BidAmount, BidTime, WinStatus
                                FROM Bids, Items
                                WHERE Items.ItemID = Bids.ItemID AND Bids.BuyerID = $buyerID
                                ORDER BY BidID DESC;";
                                $result2 = mysqli_query($con, $query2);
                                if (mysqli_num_rows($result2) > 0) {
                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                            ?>
                            <tr>
                                <td><?php echo $row2['BidID']; ?></td>
                                <td><?php echo $row2['ItemID']; ?></td>
                                <td><?php echo $row2['Name']; ?></td>
                                <td>₹<?php echo $row2['BidAmount']; ?></td>
                                <td><p><?php echo (new DateTime($row2['BidTime']))->format("d M Y"); ?></p><p><?php echo (new DateTime($row2['BidTime']))->format("h:m:s A"); ?></p></td>
                                <!-- <td><?php echo $row2['WinStatus']; ?></td> -->
                            </tr>
                            <?php
                                    }
                                } else {
                            ?>
                            <tr>
                                <td colspan="5">No records found</td>
                            </tr>
                            <?php
                                }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="acc-sub-2-container-3">
                <div class="row">
                    <h2>Purchased Items</h2>
                </div>
                <div class="row">
                    <div class="bid-table-container">
                        <table class="bid-table">
                            <tr>
                                <th>Item Name</th>
                                <th>Ship Price</th>
                                <th>Ship Date</th>
                                <th>Arrival Date</th>
                                <th>Seller ID</th>
                                <!-- <th>Win Status</th> -->
                            </tr>
                            <?php
                                $query2 = "SELECT * FROM Ships, Items
                                WHERE BuyerID = $buyerID AND Ships.ItemID = Items.ItemID;";
                                $result2 = mysqli_query($con, $query2);
                                if (mysqli_num_rows($result2)) {
                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                            ?>
                            <tr>
                                <td><?php echo $row2['Name']; ?></td>
                                <td>₹<?php echo $row2['ShipPrice']; ?></td>

                                <!-- Ship Date logic -->
                                <?php
                                    date_default_timezone_set('Asia/Kolkata');
                                    $earlier = new DateTime();
                                    $later = new DateTime($row2['ShipDate']);
                                    // $abs_ship_diff = (new DateTime())->diff(new DateTime($row2['ShipDate']))->format("%ad %hh %im %ss");
                                    $abs_ship_diff = (new DateTime())->diff(new DateTime($row2['ShipDate']))->format("%ad");
                                ?>
                                <?php if (new DateTime() < new DateTime($row2['ShipDate'])) { ?>
                                <td><p>To be shipped in <?php echo $abs_ship_diff ?></p></td>
                                <?php } elseif (new DateTime() == new DateTime($row2['ShipDate'])) { ?>
                                <td><p>To be shipped today</p></td>
                                <?php } else { ?>
                                <td><p>Shipped at</p><p><?php echo (new DateTime($row2['ShipDate']))->format("d M Y"); ?></p></td>
                                <?php } ?>

                                <!-- Arrival/Delivery Date logic -->
                                <?php
                                    date_default_timezone_set('Asia/Kolkata');
                                    $earlier = new DateTime();
                                    $later = new DateTime($row2['ArrivalDate']);
                                    $abs_arrival_diff = (new DateTime())->diff(new DateTime($row2['ArrivalDate']))->format("%ad");
                                ?>
                                <?php if (new DateTime() <= new DateTime($row2['ShipDate'])) { ?>
                                <td>Not shipped</td>
                                <?php } elseif (new DateTime($row2['ShipDate']) > new DateTime() && new DateTime() <= new DateTime($row2['ArrivalDate'])) { ?>
                                <td><p>To be delivered in <?php echo $abs_arrival_diff ?></p></td>
                                <?php } elseif (new DateTime() == new DateTime($row2['ArrivalDate'])) { ?>
                                <td>To be delivered today</td>
                                <?php } else { ?>
                                <td><p>Delivered at</p><p><?php echo (new DateTime($row2['ArrivalDate']))->format("d M Y"); ?></p></td>
                                <?php } ?>

                                <td><?php echo $row2['SellerID']; ?></td>
                            </tr>
                            <?php
                                    }
                                } else {
                            ?>
                            <tr>
                                <td colspan="5">No records found</td>
                            </tr>
                            <?php
                                }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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


        // Update and Delete
        const readonlyRow = document.getElementById("readonly-row");
        const rwRow1 = document.getElementById("rw-row-1");
        const rwRow2 = document.getElementById("rw-row-2");
        const inputText = document.getElementsByTagName('input');
        const editBtn = document.getElementById('edit-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        const saveBtn = document.getElementById('save-btn');
        const deleteBtn = document.getElementById('delete-btn');
        const confirmNo = document.getElementById('confirm-no');
        const modal = document.getElementById('modal');

        editBtn.addEventListener('click', () => {
            editBtn.classList.toggle('hide');
            saveBtn.classList.toggle('hide');
            cancelBtn.classList.toggle('hide');
            deleteBtn.classList.toggle('hide');
            accountType.disabled = false;
            readonlyRow.classList.toggle('hide');
            rwRow1.classList.toggle('hide');
            rwRow2.classList.toggle('hide');
            for (let i = 0; i < inputText.length; i++) {
                const element = inputText[i];
                element.readOnly = false;
            }
        });

        saveBtn.addEventListener('click', () => {
            editBtn.classList.toggle('hide');
            saveBtn.classList.toggle('hide');
            cancelBtn.classList.toggle('hide');
            deleteBtn.classList.toggle('hide');
            readonlyRow.classList.toggle('hide');
            rwRow1.classList.toggle('hide');
            rwRow2.classList.toggle('hide');
            for (let i = 0; i < inputText.length; i++) {
                const element = inputText[i];
                element.readOnly = true;
            }
        });

        cancelBtn.addEventListener('click', () => {
            editBtn.classList.toggle('hide');
            saveBtn.classList.toggle('hide');
            cancelBtn.classList.toggle('hide');
            deleteBtn.classList.toggle('hide');
            accountType.disabled = true;
            readonlyRow.classList.toggle('hide');
            rwRow1.classList.toggle('hide');
            rwRow2.classList.toggle('hide');
            for (let i = 0; i < inputText.length; i++) {
                const element = inputText[i];
                element.readOnly = true;
            }
        });

        deleteBtn.addEventListener('click', () => {
            modal.classList.toggle('hide');
        });

        confirmNo.addEventListener('click', () => {
            modal.classList.toggle('hide');
        });

        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>