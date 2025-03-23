<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../../.Stylesheet/adminlogin.css">
    <link rel="icon" type="image/png" sizes="16x16" href="../../../.image-cabin/favicon-16x16.png">
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <title> Cabin by Royale </title>

    <script>
        function enableSubmitBtn() {
            document.getElementById("button-admin").disabled = false;
        }
    </script>

</head>
<body>
    <div class="admin-background-container">
        <img src="../../../.image-cabin/main-asset/9-asset.jpg" alt="background" class="blur">
    </div>

    <main>
            <form class="form">
                <a href="index.php">
                    <img src="../../../.image-cabin/main_logo3.png" class="admin-logo" alt="">
                </a>

                <p class="title">Welcome Back, </p>
                <p class="message"> Please sign up in order to proceed. </p>
                <label>
                    <input required="" placeholder="" type="email" class="input">
                    <span>Email:</span>
                </label>

                <label>
                    <input required="" placeholder="" type="password" class="input">
                    <span>Password:</span>
                </label>

                <div>
                    <div  data-theme="dark" class="g-recaptcha" data-sitekey="6LdvQZEqAAAAAGpH6huLS7-S8WJFL6dQLxZr8uCp" data-callback="enableSubmitBtn"></div>
                </div>

                <button class="submit" id="button-admin" disabled="disabled"> Confirm </button>
            </form>
    </main>
</body>
</html>