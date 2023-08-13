<?php
    include 'db_connect.php';
    // include 'navbar.php';
    $passwordIncorrect = false;

    if ($_POST) {
        $password = $_POST['password'];

        if (strcmp($password, "1234") == 0) {
            header("location: admin_dashboard.php");
        } else {
            $passwordIncorrect = true;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

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
            /* outline: 2px solid green; */
            box-sizing: border-box;
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
            color: inherit;
        }

        body {
            height: 100vh;
            /* background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), URL(auction-banner.jpg); */
            background-size: 100%;
            background-repeat: no-repeat;
        }

        .log-alert {
            display: flex;
            justify-content: center;
            align-items: center;

            position: absolute;

            width: 100%;
            
            /* height: 100%; */
            padding: 1rem;

            font-size: 1.5rem;
        }
        
        .log-alert-success {
            background-color: lightgreen;
            color: green;
        }

        .log-alert-error {
            background-color: orangered;
            color: maroon;
        }

        .log-container {
            display: flex;
            justify-content: center;
            align-items: center;

            height: 100%;
            width: 100%;
        }

        .log-sub-container {
            padding: 1rem;
            background-color: #443B6C;
            /* background-image: linear-gradient(#1E68B6, #6CBCE3); */

            border-radius: 0.5rem;
            box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2);

        }

        .log-sub-2-container-1 {
            display: flex;
            justify-content: center;
            padding: 1rem;
        }

        .log-sub-2-container-1 h1 {
            color: #6CBCE3;
            font-size: 2rem;
            font-weight: 400;
        }
        .log-sub-2-container-2 {
            padding: 1rem;
        }
        .log-input-container {
            display: flex;
            justify-content: center;
            align-items: center;

            padding: 1rem;
        }

        .row {
            display: flex;
            height: 3rem;

            border-radius: 0.5rem;
            overflow: hidden;
            outline: 2px solid #6CBCE3;
        }

        .log-container {
            display: flex;
            justify-content: center;
            align-items: center;

            height: 100%;
            width: 100%;
        }

        .log-sub-container {
            padding: 1rem;
            background-color: #C4D5E7;
            /* background-image: linear-gradient(#1E68B6, #6CBCE3); */

            border-radius: 0.5rem;
            box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2);
        }

        .log-sub-2-container-1 {
            display: flex;
            justify-content: center;
            padding: 1rem;
        }

        .log-sub-2-container-1 h1 {
            color: #1E68B6;
            font-size: 2rem;
            font-weight: 400;
        }

        .log-sub-2-container-2 {
            padding: 1rem;
        }

        .log-input-container {
            display: flex;
            justify-content: center;
            align-items: center;

            padding: 1rem;
        }

        .row {
            display: flex;
            height: 3rem;

            border-radius: 0.5rem;
            overflow: hidden;
            outline: 2px solid #6CBCE3;
        }

        .log-input-container input {
            padding-left: 1rem;
            color: #1B1A38;
            font-size: 1.5rem;
            border: none;
            background-color: transparent;
        }

        .log-input-container input:focus {
            outline: none;
        }

        .log-input-container input::placeholder {
            color: gray;
        }

        .log-input-container i {
            display: flex;
            justify-content: center;
            align-items: center;

            background-color: #6CBCE3;
            /* padding: 0.6rem 0.7rem; */
            height: 100%;
            width: 3rem;

            font-size: 1.5rem;
            color: #1E68B6;
        }

        .log-sub-2-container-3 {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1rem;
        }

        .log-button-container {
            padding: 1rem 2rem;
            width: 100%;
        }

        .log-button-container button {
            /* background-image: linear-gradient(90deg, #6CBCE3, #1E68B6); */
            background-color: #443B6C;
            padding: 0.5rem 1rem;
            width: 100%;
            color: #C4D5E7;
            font-size: 1.5rem;

            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2);

            transition: scale 200ms ease-out;
        }
        
        .log-button-container button:active {
            /* scale: 0.95; */
            /* color: lightgray; */
            box-shadow: inset 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2);
        }
        .log-forgot {
            display: flex;
            justify-content: center;
            padding-bottom: 1rem;
            color: #C4D5E7;

        }

        .log-forgot p a {
            color: #6CBCE3;
            text-decoration: none;
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
            <div class="account-container">
                <a href="http://localhost/apna-Project/login.php"><p><i class="fa-solid fa-right-to-bracket" style="padding: 0;"></i> Member Login</p></a>
            </div>
        </div>
    </header>
    <?php if ($passwordIncorrect == true) { ?>
    <div class="log-alert log-alert-error">
        <p>Password is incorrect.</p>
    </div>
    <?php } ?>
    <div class="log-container">
        <div class="log-sub-container" >
            <div class="log-sub-2-container-1">
                <h1>Admin Login</h1>
            </div>
            <form class="log-sub-2-container-2" method="POST" action="admin_login.php">
                
                <div class="log-input-container">
                    <div class="row">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" id="" placeholder="Password" required>
                    </div>
                </div>
                <div class="log-button-container">
                    <button type="submit">Login</button>
                </div>
                <div class="log-forgot">
                    <!-- <p>Forgot Password? <a href="">Click Here</a></p> -->
                </div>
            </form>
            <!-- <div class="log-sub-2-container-3">
            </div> -->

        </div>
    </div>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        function toggleModal () {
            const biddingBackDrop = document.querySelector(".bidding-form-container");
            biddingBackDrop.classList.toggle("bidding-form-activate");
        };
    </script>
</body>
</html>