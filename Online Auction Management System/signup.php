<?php
    include("db_connect.php");

    $accountExists = false;
    $usernameExists = false;
    $success = false;

    if ($_POST) {
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

        $sql = "SELECT * FROM Buyer WHERE Username = '$Username' AND Password = '$Password'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        
        if ($row > 0) {
            $accountExists = true;
        } else {
            $sql = "SELECT * FROM Buyer WHERE Username = '$Username'";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);
            if ($row > 0) {
                $usernameExists = true;
            } else {
                $sql = "INSERT INTO `Auction`.`Buyer` (
                    `Username`, `Password`, `Fname`, `Lname`, `Street`, `AptNo`, `City`, `State`, `ZipCode`, `Email`, `PhoneNo`
                ) VALUES (
                    '$Username', '$Password', '$Fname', '$Lname', '$Street', '$AptNo', '$City', '$State', '$ZipCode', '$Email', '$PhoneNo'
                );";

                $result = mysqli_query($con, $sql);
                if ($result == true) {
                    
                    $sql = "SELECT * FROM `Buyer` WHERE `Username` = '$Username' && `Password` = '$Password'";

                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_assoc($result);

                    $id = $row['BuyerID'];

                    $sql = "INSERT INTO `Auction`.`Accounts` (
                        `AccountNo`, `AccountType`, `BuyerID`
                    ) VALUES (
                        '$AccountNo', '$AccountType', '$id'
                    );";

                    $result = mysqli_query($con, $sql);

                    if ($result == true) {
                        $success = true;
                        header("location: user_registered.php");
                    } else {
                        echo "<p>ERROR : $sql <br> $con->error</p>";
                        // echo mysqli_error($con);
                    }
                } else {
                    echo "<p>ERROR : $sql <br> $con->error</p>";
                }

            }
        }


    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration form desige 1</title>


    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <!-- googlefonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&family=DM+Serif+Display&family=Kaushan+Script&family=Merienda:wght@700&family=Rammetto+One&display=swap" rel="stylesheet">

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            /* outline: 2px solid green; */
            font-family: sans-serif;

            /* #1E68B6 */
            /* #C4D5E7 */
            /* #6CBCE3 */
            /* #1B1A38 */
            /* #443B6C */
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

        body {
            /* height: 100vh; */
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), URL(auction-banner.jpg);
            background-size: 100%;
            background-repeat: no-repeat;
        }

        .reg-alert {
            display: flex;
            justify-content: center;
            align-items: center;

            position: absolute;

            width: 100%;
            
            /* height: 100%; */
            padding: 1rem;

            font-size: 1.5rem;
        }
        .reg-alert-success {
            background-color: lightgreen;
            color: green;
        }

        .reg-alert-error {
            background-color: orangered;
            color: maroon;
        }

        .reg-container {
            display: flex;
            justify-content: center;
            align-items: center;
            /* background-color: bisque; */
            /* height: 100%; */
            padding: 8rem 13rem;
        }

        .reg-sub-1-container {
            /* height: 80%; */
            width: 100%;
            /* background-color: aquamarine; */
            display: flex;
            /* justify-content: center; */
            /* align-items: center; */
            /* padding: 1rem; */
            /* gap: 1rem; */
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2);
        }

        .reg-sub-2-container-1 {
            display: flex;
            justify-content: center;
            align-items: center;
            /* flex-direction: column; */
            /* height: 100%; */
            width: 100%;
            background-color: #6CBCE3;

            /* filter: drop-shadow(0 0.3rem 0.4rem rgba(0, 0, 0, 0.2)); */
        }
        .reg-sub-2-container-2 {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-direction: column;
            height: 100%;
            width: 100%;
            background-color: #443B6C;
        }
        
        .reg-sub-3-container-1 {
            padding-top: 2rem;
            padding-bottom: 1rem;
        }

        .reg-sub-3-container-1 h1 {
            color: #6CBCE3;
        }

        .logo {
            color: #1E68B6;
            font-family: 'Rammetto One', cursive;
            font-size: 3rem;
            font-weight: 400;

            /* height: 10.1rem; */

            padding: 3.8rem 1rem;
            background-color: #C4D5E7;
            /* border-radius: 50%; */
            /* box-shadow: 0 0rem 2rem #1E68B6; */
            /* outline: 0.5rem solid #1E68B6; */
            /* outline-offset: 0.5rem; */

            border-radius: 1rem;
            filter: drop-shadow(0 0 1rem #1E68B6);
            /* filter: drop-shadow(0 0.3rem 0.4rem rgba(0, 0, 0, 0.2)); */

            position: relative;
            z-index: 1;
        }

        .logo::before, .logo::after {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            content: '';
            font-size: 3rem;
            font-weight: 400;
            padding: 2rem;
            background-color: #C4D5E7;
            border-radius: 1rem;
            /* box-shadow: 0 0rem 2rem #1E68B6; */
            /* outline: inherit; */
            /* outline-offset: 0.5rem; */
            
            /* z-index: -1; */
        }
        
        .logo::before {
            transform: rotate(60deg);
            z-index: -3;
        }
        .logo::after {
            transform: rotate(-60deg);
            z-index: -2;
        }

        .reg-sub-3-container-2 {
            position: relative;
            overflow: hidden;
            width: 70%;
        }

        .reg-form-transition {
            transition: left 200ms ease-out;
        }

        .reg-header-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .reg-header-container h2 {
            color: #C4D5E7;
            font-size: 1.2rem;
            font-weight: 400;
        }

        .reg-form-container-1 {
            opacity: 0;
            cursor: none;
            pointer-events: none;
        }

        .reg-form-container-2 {
            width: 100%;
            top: 0;
            left: 0%;
            bottom: 0;
            position: absolute;
            padding: 0 0.5rem;
        }
        .reg-form-container-3 {
            width: 100%;
            top: 0;
            left: 120%;
            bottom: 0;
            position: absolute;
            display: flex;
            justify-content: space-between;
            flex-direction: column;
            padding: 0 0.5rem;
        }
        .reg-form-container-4 {
            width: 100%;
            top: 0;
            left: 120%;
            bottom: 0;
            position: absolute;
            display: flex;
            justify-content: space-between;
            flex-direction: column;
            padding: 0 0.5rem;
        }

        .reg-input-container {
            padding: 0.7rem 0;
        }

        .reg-input-container p {
            padding: 0.5rem 0;
            color: #C4D5E7;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .reg-input-container input, .reg-input-container select, .reg-input-container option {
            color: white;
            font-size: 1rem;
            padding: 0.5rem 0.5rem;
            width: 100%;
            border: 2px solid #6CBCE3;
            /* outline: 2px solid #1E68B6; */
            border-radius: 0.3rem;
            background-color: #443B6C;
        }

        .reg-input-container input:focus, .reg-input-container select:focus {
            outline: none;
        }

        .reg-input-container input::placeholder {
            color: #C4D5E7;
        }

        
        .reg-form-container-2 .reg-button-container {
            justify-content: end;
        }
        
        .reg-button-container {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0rem;
        }

        .reg-button-container button {
            display: flex;
            justify-content: center;
            align-items: center;
            color: #443B6C;
            width: 30%;
            font-size: 1rem;
            /* font-weight: 600; */
            padding: 0.5rem 1rem;
            /* margin: 1rem; */

            border: none;
            border-radius: 0.5rem;
            /* background-image: linear-gradient(90deg, #6CBCE3, #C4D5E7); */
            background-image: linear-gradient(90deg, #6CBCE3, #1E68B6);
            
            /* box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2); */

            transition: scale 200ms ease-out;
        }

        .reg-button-container button i {
            /* margin: 0 0px; */
            font-size: 1rem;
        }

        .reg-button-container button:hover {
            scale: 1.05;
        }
        
        .reg-button-container button:active {
            scale: 0.95;
            color: lightgray;
        }

        
        .reg-sub-3-container-3 {
            display: flex;
            padding-top: 1rem;
            padding-bottom: 2rem;
        }

        .reg-sub-3-container-3 p {
            color: #443B6C;
            font-weight: 600;
            position: relative;
            padding: 1rem 3rem;
            z-index: 10;
        }

        .reg-sub-3-container-3 .progress {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            /* background-color: #1E68B6; */
            background-image: linear-gradient(90deg, #6CBCE3, #1E68B6);
            z-index: -1;

            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
            /* box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2); */
            /* filter: drop-shadow(0 0.3rem 0.4rem rgba(0, 0, 0, 0.3)); */
        }

        .progress-transition {
            transition: width 200ms ease-out;
        }

        .reg-sub-3-container-3 .progress::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 100%;
            /* right: 0; */
            
            /* right: 0; */
            /* background-color: #1E68B6; */
            /* height: ; */
            border-style: solid;
            border-width: 1.5rem 1.5rem;
            border-left-color: #1E68B6;
            border-top-color: transparent;
            border-bottom-color: transparent;
            border-right-color: transparent;
            
        }
    </style>
</head>
<body>
    <?php if ($success == true) { ?>
    <div class="reg-alert reg-alert-success">
        <p>Success! Your account is created.</p>
    </div>
    <?php } ?>
    <?php if ($accountExists == true) { ?>
    <div class="reg-alert reg-alert-error">
        <p>Your account already exists.</p>
    </div>
    <?php } ?>
    <?php if ($usernameExists == true) { ?>
    <div class="reg-alert reg-alert-error">
        <p>Username already exists.</p>
    </div>
    <?php } ?>
    <div class="reg-container">
        <div class="reg-sub-1-container">
            <div class="reg-sub-2-container-1">
                <h1 class="logo">AuctioNet</h1>
            </div>
            <div class="reg-sub-2-container-2">
                <div class="reg-sub-3-container-1">
                    <h1>Register Yourself</h1>
                </div>
                <form class="reg-sub-3-container-2" action="signup.php" method="post">




                    <!-- Dummy form -->
                    <div class="reg-form-container-1">
                        <div class="reg-header-container">
                            <h2>Personal Details</h2>
                        </div>
                        <div class="reg-input-container">
                            <p>First Name</p>
                            <input type="text" name="" id="" placeholder="Username">
                        </div>
                        <div class="reg-input-container">
                            <p>Last Name</p>
                            <input type="text" name="" id="" placeholder="Username">
                        </div>
                        <div class="reg-input-container">
                            <p>Email</p>
                            <input type="email" name="" id="" placeholder="Username">
                        </div>
                        <div class="reg-input-container">
                            <p>Phone Number</p>
                            <input type="number" name="" id="" placeholder="Username">
                        </div>
                        <div class="reg-input-container">
                            <p>Username</p>
                            <input type="text" name="" id="" placeholder="Username">
                        </div>
                        <div class="reg-input-container">
                            <p>Password</p>
                            <input type="password" name="" id="" placeholder="Username">
                        </div>
                        <div class="reg-button-container">
                            <button>Previous</button>
                            <button type="button">Next</button>
                        </div>
                    </div>



                    <!-- Personal form -->
                    <div class="reg-form-container-2 reg-form-transition">
                        <div class="reg-header-container">
                            <h2>Personal Details</h2>
                        </div>
                        <div class="reg-input-container">
                            <p>First Name</p>
                            <input type="text" name="fname" id="" placeholder="Enter your first name" required>
                        </div>
                        <div class="reg-input-container">
                            <p>Last Name</p>
                            <input type="text" name="lname" id="" placeholder="Enter your last name">
                        </div>
                        <div class="reg-input-container">
                            <p>Email</p>
                            <input type="email" name="email" id="" placeholder="Enter your email" required>
                        </div>
                        <div class="reg-input-container">
                            <p>Phone Number</p>
                            <input type="text" name="phoneno" id="" placeholder="Enter your phone number" maxlength="10" pattern="[0-9]{10}" title="Enter 10-digit Phone Number" required>
                        </div>
                        <div class="reg-input-container">
                            <p>Username</p>
                            <input type="text" name="uname" id="" placeholder="Enter your username" required>
                        </div>
                        <div class="reg-input-container">
                            <p>Password</p>
                            <input type="password" name="password" id="" placeholder="Enter your password" required>
                        </div>
                        <div class="reg-button-container">
                            <!-- <button type="button">Previous</button> -->
                            <button type="button" id="next1">Next<i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </div>



                    <!-- Address details form -->
                    <div class="reg-form-container-3 reg-form-transition">
                        <div class="reg-header-container">
                            <h2>Address Details</h2>
                        </div>
                        <div class="reg-input-container">
                            <p>State</p>
                            <input type="text" name="state" id="" placeholder="Enter your state" required>
                        </div>
                        <div class="reg-input-container">
                            <p>City</p>
                            <input type="text" name="city" id="" placeholder="Enter your city" required>
                        </div>
                        <div class="reg-input-container">
                            <p>Street</p>
                            <input type="text" name="street" id="" placeholder="Enter your street" required>
                        </div>
                        <div class="reg-input-container">
                            <p>Apartment Number</p>
                            <input type="text" name="aptno" id="" placeholder="Enter your apartment number" pattern="[0-9]+" title="Enter Apartment Number" required>
                        </div>
                        <div class="reg-input-container">
                            <p>Zipcode</p>
                            <input type="text" name="zipcode" id="" placeholder="Enter your zipcode" required>
                        </div>
                        <div class="reg-button-container">
                            <button type="button" id="prev1"><i class="fa-solid fa-chevron-left"></i> Prev</button>
                            <button type="button" id="next2">Next<i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </div>



                    <!-- Account details form -->
                    <div class="reg-form-container-4 reg-form-transition">
                        <div class="reg-header-container">
                            <h2>Account Details</h2>
                        </div>
                        <div class="reg-input-container">
                            <p>Account Number</p>
                            <input type="text" name="accountno" id="" placeholder="Enter your 16-digit account number" maxlength="16" pattern="[0-9]{16}" title="Enter 16-Digit account number" required>
                        </div>
                        <div class="reg-input-container">
                            <p>Account Type</p>
                            <!-- <input type="text" name="accounttype" id="" placeholder="Enter account type" required> -->
                            <Select name="accounttype" required>
                                <option value="">Select Account Type</option>
                                <option value="Visa">Visa</option>
                                <option value="Mastercard">Mastercard</option>
                                <option value="Rupay">Rupay</option>
                                <option value="DISCOVER">DISCOVER</option>
                            </Select>
                        </div>
                        
                        <div class="reg-button-container">
                            <button type="button" id="prev2"><i class="fa-solid fa-chevron-left"></i> Prev</button>
                            <button type="Submit">Submit <i class='bx bxs-send'></i></button>
                        </div>
                    </div>
                </form>
                <div class="reg-sub-3-container-3">
                    <p><span class="progress progress-transition"></span>Step 1</p>
                    <p>Step 2</p>
                    <p>Step 3</p>
                </div>
            </div>

        </div>

    </div>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        const formPersonal = document.querySelector(".reg-form-container-2");
        const formAddress = document.querySelector(".reg-form-container-3");
        const formAccount = document.querySelector(".reg-form-container-4");

        const next1 = document.querySelector("#next1");
        const next2 = document.querySelector("#next2");
        const prev1 = document.querySelector("#prev1");
        const prev2 = document.querySelector("#prev2");

        const progressBar = document.querySelector(".progress");

        // next1.addEventListener("click", (event) => {
        //     event.preventDefault();
        //     // do whatever u want
        //     formPersonal.style.left = "-100%";
        //     formAddress.style.left = "0%";
        //     formAccount.style.left = "100%";
        //     console.log(next1);
        // });
        next1.addEventListener("click", () => {
            formPersonal.style.left = "-120%";
            formAddress.style.left = "0%";
            formAccount.style.left = "120%";
            progressBar.style.width = "200%";
        });
        next2.addEventListener("click", () => {
            formPersonal.style.left = "-120%";
            formAddress.style.left = "-120%";
            formAccount.style.left = "0%";
            progressBar.style.width = "300%";
        });
        prev1.addEventListener("click", () => {
            formAddress.style.left = "120%";
            formPersonal.style.left = "0%";
            formAccount.style.left = "120%";
            progressBar.style.width = "100%";
        });
        prev2.addEventListener("click", () => {
            formPersonal.style.left = "-120%";
            formAddress.style.left = "0%";
            formAccount.style.left = "120%";
            progressBar.style.width = "200%";
        });
    </script>
</body>
</html>