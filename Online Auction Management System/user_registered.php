<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>
<style>

    /* #1E68B6 */
    /* #C4D5E7 */
    /* #6CBCE3 */
    /* #1B1A38 */
    /* #443B6C */

    * {
        padding: 0;
        margin: 0;
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

    body {
        height: 100vh;
        background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), URL(auction-banner.jpg);
        background-size: 100%;
        background-repeat: no-repeat;
    }

    .upper-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        width: 100%;
    }

    .dialog {
        display: flex;
        flex-direction: column;
        align-items: center;

        background-image: linear-gradient(#C4D5E7, #6CBCE3);
        padding: 3rem 0;

        border-radius: 1rem;
        box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2);

    }

    .fa-regular {
        padding: 1rem;

        color: #1E68B6;
        font-size: 10rem;
    }

    .dialog h2 {
        padding: 1rem;

        color: #1E68B6;
        font-size: 2.5rem;


    }

    .dialog p {
        background-color: #C4D5E7;
        width: 70%;
        padding: 1rem;

        color: #1E68B6;
        font-size: 1.5rem;
        text-align: center;

        border-radius: 1rem;
        box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2);
    }
    .login-container {
        padding: 1rem;
    }

    .dialog a {
        text-decoration: none;

        cursor: pointer;
    }

    .dialog a button {
        padding: 1rem 2rem;
        background-color: #443B6C;

        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.3rem 0.4rem rgba(0, 0, 0, 0.2);
        
        color: #C4D5E7;
        font-size: 1.5rem;

        cursor: pointer;
        transition: scale 200ms ease-out;
    }

    .dialog a button:hover {
        scale: 1.05;
    }
    
    .dialog a button:active {
        scale: 0.95;
        color: lightgray;
    }
</style>
<body>
    <div class="upper-container">
        <div class="dialog">
            <i class="fa-regular fa-circle-check"></i>
            <h2>Registration Successful!</h2>
            <p>Congratulations, your account has been created successfully.</p>
            <div class="login-container">
                <a href="http://localhost/Apna-Project/login.php"><button type="button">Go to Login</button></a>
            </div>
        </div>
    </div>
</body>
</html>