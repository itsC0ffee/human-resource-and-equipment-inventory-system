<!-- verification_form.php -->

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

    <title>Cancer Repo</title>
</head>
<body>
  <div class="wrapper">
    <div class="container main">
        <div class="row">
            <div class="col-md-6 side-image forgot">
                 <form action="send_verification_email.php" method="post">
                <div class="input-box">
                    <header>Forgot Password</header>
                    <p>No worries, we’ll send you reset instructions</p>
                    <div class="input-field">
                         <input type="text" name="email" class="input" id="email" required="" autocomplete="off">
                         <label for="email"><i class="fa fa-envelope" aria-hidden="true"></i> Email</label> 
                     </div> 
                    <div class="input-field">
                         <input type="submit" class="submit" value="Reset Password">
                    </div> 
                    <div class="backsgnin">
                        <a href="index.php"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; Back To Login</a>
                       </div>
                    </div>  
                  
                 <!-------------      image     ------------->      
                    </div>
                    <div class="col-md-6 right forgot">
                  <div class="logo forgot">
                    <img src="vendors/images/forgot_img.png" alt="">
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>


