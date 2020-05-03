<?php
session_start();
require("./db.php");

if(isset($_POST['login'])){
    $useremail = strtolower(filter_var($_POST['useremail'],FILTER_SANITIZE_EMAIL));
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);


        $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$useremail]);
        $user = $stmt->fetch();

        if(isset($user)){
            if(password_verify($password,$user->password)){
                $_SESSION['userid']=$user->id;
                header('location: http://trencynews.herokuapp.com/'); 
            }else{
                $incorrectpass ="The login Username or Password is incorrect";
            }
        }








//     if(filter_var($useremail,FILTER_VALIDATE_EMAIL)){
//         $sql= "SELECT * FROM users WHERE email= ?";
//         $stmt = $pdo->prepare($sql);
//         $stmt->execute([$useremail]);
//         $totalusers = $stmt->rowCount();

//         if($totalusers > 0){
//             $emailtaken = "This email has already been taken<br>";
//         }else{
//             $sql= "INSERT INTO users (name, email, password) VALUES (?,?,?)";
//         $stmt = $pdo->prepare($sql);
//         $stmt->execute([$username,$useremail,$passwordhashed]);
        
//         }
//     }


 }

?>
<?php require("./inc/header.html");?>

<div class="container">
      <div class="card">
        <div class="card-header  bg-light mb-3">
          Login
        </div>
        <div class="card-body">
            <?php if(isset($incorrectpass)){?>

                <p style="color:red;"><?php echo $incorrectpass?></p>

            <?php }?>
          <form action="login.php" method="post">

            
            <div class="form-group">
                
                <label for="useremail">Email</label>
                <input type="email" name="useremail" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">password</label>
            <input input type="password" class="form-control" name="password" required>

            </div>
                <button type="submit" name="login" class="btn btn-primary">Login</button>
          </form>
        </div>
      </div>
    </div>


<?php require("./inc/footer.html");?>


<script src="./bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
  <script src="./bootstrap-4.4.1-dist/js/bootstrap.bundle.min.js"></script>
