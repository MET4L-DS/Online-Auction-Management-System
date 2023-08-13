<?php
    include 'db_connect.php';
    session_start();
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
        
        .banner-container .account-container a {
            padding: 0;
            /* height: 95%; */
            text-decoration: none;
            /* margin: -2px; */
        }

        body {
            /* height: 100vh; */
            background-image: url("data:image/svg+xml,<svg id='patternId' width='100%' height='100%' xmlns='http://www.w3.org/2000/svg'><defs><pattern id='a' patternUnits='userSpaceOnUse' width='50.41' height='87' patternTransform='scale(4) rotate(15)'><rect x='0' y='0' width='100%' height='100%' fill='hsla(0,0%,100%,1)'/><path d='M25.3 87L12.74 65.25m0 14.5h-25.12m75.18 0H37.68M33.5 87l25.28-43.5m-50.23 29l4.19 7.25L16.92 87h-33.48m33.48 0h16.75-8.37zM8.55 72.5L16.92 58m50.06 29h-83.54m79.53-50.75L50.4 14.5M37.85 65.24L50.41 43.5m0 29l12.56-21.75m-50.24-14.5h25.12zM33.66 29l4.2 7.25 4.18 7.25M33.67 58H16.92l-4.18-7.25M-8.2 72.5l20.92-36.25L33.66 0m25.12 72.5H42.04l-4.19-7.26L33.67 58l4.18-7.24 4.19-7.25M33.67 29l8.37-14.5h16.74m0 29H8.38m29.47 7.25H12.74M50.4 43.5L37.85 21.75m-.17 58L25.12 58M12.73 36.25L.18 14.5M0 43.5l-12.55-21.75M24.95 29l12.9-21.75M12.4 21.75L25.2 0M12.56 7.25h-25.12m75.53 0H37.85M58.78 43.5L33.66 0h33.5m-83.9 0h83.89M33.32 29H16.57l-4.18-7.25-4.2-7.25m.18 29H-8.37M-16.74 0h33.48l-4.18 7.25-4.18 7.25H-8.37m8.38 58l12.73-21.75m-25.3 14.5L0 43.5m-8.37-29l21.1 36.25 20.94 36.24M8.37 72.5H-8.36'  stroke-width='0.5' stroke='hsla(200, 68%, 66%, 1)' fill='none'/></pattern></defs><rect width='800%' height='800%' transform='translate(0,0)' fill='url(%23a)'/></svg>");

            background-color: whitesmoke;
            /* background-repeat: no-repeat; */
            /* background-position: center center; */
            /* background-color: #927748; */
        }

        .container-2 {
            padding: 0rem 10%;
            margin: 8rem 0;
            display: flex;
            justify-content: center;
            gap: 2rem;
        }

        .dashboard-tile {
            display: flex;
            flex-direction: column;
            /* justify-content: center; */
            align-items: center;
            min-width: 15rem;
            padding: 4rem 0;
            gap: 1rem;
            background-color: whitesmoke;
            border-radius: 0.5rem;
            box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2);
            font-size: 2rem;
            text-decoration: none;
            transition: transform 200ms ease-out, 
            scale 200ms ease-out;
        }

        .dashboard-tile:hover {
            transform: translateY(-0.5rem);
            scale: 1.01;
        }

        .dashboard-tile i {
            /* background-color: #C4D5E7; */
            padding: 1rem;
            border-radius: 0.5rem;
            font-size: 6rem;
            color: #1E68B6;
        }

        .dashboard-tile .number {
            color: #443B6C;
            font-weight: 600;
        }

        .dashboard-tile .title {
            color: #1E68B6;
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
            <div class="account-container">
                <a href="http://localhost/apna-Project/login.php"><p><i class="fa-solid fa-gear" style="padding: 0;"></i> Administrator</p></a>
            </div>
        </div>
    </header>
    <section class="container-2">
        <a href="http://localhost/apna-Project/admin_dashboard_users.php" class="dashboard-tile">
            <i class="fa-solid fa-user"></i>
            <p class="number">1000</p>
            <p class="title">Users</p>
        </a>
        <a href="http://localhost/apna-Project/admin_dashboard_bids.php" class="dashboard-tile">
            <i class="fa-solid fa-chart-line"></i>
            <p class="number">1000</p>
            <p class="title">Bids</p>
        </a>
        <a href="http://localhost/apna-Project/admin_dashboard_items.php" class="dashboard-tile">
            <i class="fa-solid fa-database"></i>
            <p class="number">1000</p>
            <p class="title">Items</p>
        </a>
    </section>
</body>
</html>