<?php
    include 'db_connect.php';
    session_start();

    $buyerID = $_GET['buyer_id'];

    $updateSuccess = false;
    $updateFailure = false;
?>

<?php
    if (isset($_POST['save'])) {
        $Fname = $_POST['fname'];
        $Lname = $_POST['lname'];
        $Street = $_POST['street'];
        $AptNo = $_POST['aptno'];
        $City = $_POST['city'];
        $State = $_POST['state'];
        $ZipCode = $_POST['zipcode'];
        $Email = $_POST['email'];
        $PhoneNo = $_POST['phoneno'];
        $query2 = "UPDATE Buyer 
        SET Fname = '$Fname', Lname = '$Lname', Street = '$Street', AptNo = $AptNo, City = '$City', State = '$State', ZipCode = '$ZipCode', Email = '$Email', PhoneNo = '$PhoneNo'
        WHERE BuyerID = $buyerID;";
        $result2 = mysqli_query($con, $query2);
        if ($result2 == true) {    
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
        history.replaceState({}, "", "http://localhost/apna-Project/admin_dashboard_users.php");

        // Navigate to the new URL
        window.location.href = "http://localhost/apna-Project/admin_dashboard_users.php";
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
        
        .banner-container .account-container a, .banner-container .account-container a:visited {
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

        nav * {
            padding: 2rem;
            /* margin: 0 1rem; */
            transition: color 200ms ease-out;
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }

        nav a:visited {
            color: inherit;
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

        nav *:hover {
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
    </style>
</head>
<body>
    <div id="modal" class="confirmation-modal-bg hide">
        <form class="confirmation-modal" action="http://localhost/apna-Project/admin_dashboard_users_profile.php?buyer_id=<?php echo $buyerID; ?>" method="POST">
            <p>Please confirm that you want to delete this user.</p>
            <div class="row">
                <div class="acc-input-container center">
                    <button id="confirm-yes" type="submit" name="confirm-yes-delete">Yes</button>
                    <button id="confirm-no" type="button">No</button>
                </div>
            </div>
        </form>
    </div>
    <header>
        <div class="banner-container">
            <h1 class="logo">AuctioNet</h1>
            <div class="account-container">
                <a href="http://localhost/apna-Project/admin_dashboard.php?"><p><i class="fa-solid fa-gear" style="padding: 0;"></i> Administrator</p></a>
            </div>
        </div>
    </header>
    <div class="acc-container">
        <div class="acc-sub-container">
            <?php
                $query1 = "SELECT * FROM Buyer WHERE BuyerID = $buyerID;";
                $result1 = mysqli_query($con, $query1);
                $row1 = mysqli_fetch_assoc($result1);
                if ($row1 < 1) {
            ?>
            <script>
                window.history.back();
            </script>
            <?php
                }
            ?>
            <div class="acc-sub-2-container-1">
                <h1><?php echo $row1['Username']; ?> </h1>
            </div>
            <form class="acc-sub-2-container-2" action="http://localhost/apna-Project/admin_dashboard_users_profile.php?buyer_id=<?php echo $row1['BuyerID']; ?>" method="POST">
                <div class="row">
                    <h2>Profile</h2>
                </div>
                <div class="row">
                    <div class="acc-input-container">
                        <p>First Name :</p>
                        <input type="text" name="fname" id="" value="<?php echo $row1['Fname']; ?>" placeholder="Enter your first name" required readonly>
                    </div>
                    <div class="acc-input-container">
                        <p>Last Name :</p>
                        <input type="text" name="lname" id="" value="<?php echo $row1['Lname']; ?>" placeholder="Enter your last name" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="acc-input-container">
                        <p>Email :</p>
                        <input type="email" name="email" id="" value="<?php echo $row1['Email']; ?>" placeholder="Enter your email" required readonly>
                    </div>
                    <div class="acc-input-container">
                        <p>Phone Number :</p>
                        <input type="text" name="phoneno" id="" value="<?php echo $row1['PhoneNo']; ?>" placeholder="Enter your phone number" maxlength="10" pattern="[0-9]{10}" title="Enter 10-digit Phone Number" required readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="acc-input-container">
                        <p>Apartment Number :</p>
                        <input type="text" name="aptno" id="" value='<?php echo "$row1[AptNo]"; ?>' placeholder="Enter your apartment number" required readonly>
                    </div>
                    <div class="acc-input-container">
                        <p>Street :</p>
                        <input type="text" name="street" id="" value='<?php echo "$row1[Street]"; ?>' placeholder="Enter your street" required readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="acc-input-container">
                        <p>City :</p>
                        <input type="text" name="city" id="" value='<?php echo "$row1[City]"; ?>' placeholder="Enter your city" required readonly>
                    </div>
                    <div class="acc-input-container">
                        <p>ZipCode :</p>
                        <input type="text" name="zipcode" id="" value='<?php echo "$row1[ZipCode]"; ?>' placeholder="Enter your zipcode" required readonly>
                    </div>
                    <div class="acc-input-container">
                        <p>State :</p>
                        <input type="text" name="state" id="" value='<?php echo "$row1[State]"; ?>' placeholder="Enter your state" required readonly>
                    </div>
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
        </div>
    </div>
    <script>
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