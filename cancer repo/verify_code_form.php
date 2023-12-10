<?php 

$recipientEmail = isset($_GET['data']) ? $_GET['data'] : '';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
    <link rel="stylesheet" type="text/css" href="vendors/styles/stylelogin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
    function moveToNext(currentInput, nextInputId) {
    if (currentInput.value.length >= 1) {
        var nextInput = document.getElementById(nextInputId);
        if (nextInput) {
            nextInput.focus();
        }
    }
}

    </script>
    <title>Cancer Repo</title>
</head>
<body>
  <div class="wrapper">
    <div class="container main">
        <div class="row">
            <div class="col-md-6 side-image factor">
                <div class="input-box">
                   
                    <header>Two Factor Authentication</header>
                    <p>We sent a code to <span><?php echo $recipientEmail; ?></span></p>
                    <div class="input-field">
                        <form class="factor" action="verify_code.php" method="post">
                            <input type="text" name="code1" maxlength="1" pattern="\d" oninput="moveToNext(this, 'input2')">
                            <input type="text" name="code2" maxlength="1" pattern="\d" id="input2" oninput="moveToNext(this, 'input3')">
                            <input type="text" name="code3" maxlength="1" pattern="\d" id="input3" oninput="moveToNext(this, 'input4')">
                            <input type="text" name="code4" maxlength="1" pattern="\d" id="input4" oninput="moveToNext(this, 'input5')">
                            <input type="text" name="code5" maxlength="1" pattern="\d" id="input5" oninput="moveToNext(this, 'input5')">
    
                            <input type="hidden" name="recipientEmail" value="<?php echo isset($_POST['recipientEmail']) ? htmlspecialchars($_POST['recipientEmail']) : htmlspecialchars($recipientEmail); ?>">

                     </div> 
                    <div class="input-field">
                         
                         <input type="submit" class="submit" value="Reset Password">
                    </div> 
                    <p class="resend">Didn’t receive an email? <a href="#">Click Resend</a></p>
                    <div class="backsgnin">
                        <a href="index.php"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; Back To Login</a>
                       </div>
 
                 </div>  
                 </form>   
                <!-------------      image     ------------->
                
            </div>

            <div class="col-md-6 right forgot">
                <div class="logo forgot">
                    <img src="vendors/images/2FA_img.png" alt="">
                </div>
                <div class="top_logo forgot">
                    <img src="vendors/images/login_logo_img.png" alt="">
                </div>
               
            </div>
        </div>
    </div>
</div>
</body>
</html>