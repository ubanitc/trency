<?php
require("./db.php");

if(isset($_POST['register'])){
    $dpname = strtolower(filter_var($_POST['dpname'],FILTER_SANITIZE_STRING));
    $phoneno = strtolower(filter_var($_POST['phoneno'],FILTER_SANITIZE_STRING));
    $username = strtolower(filter_var($_POST['username'],FILTER_SANITIZE_STRING));
    $refids = strtolower(filter_var($_POST['refid'],FILTER_SANITIZE_STRING));
    $useremail = strtolower(filter_var($_POST['useremail'],FILTER_SANITIZE_EMAIL));
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
    $passwordhashed = password_hash($password,PASSWORD_DEFAULT);
    
    if(filter_var($useremail,FILTER_VALIDATE_EMAIL)){
        $sql= "SELECT * FROM users WHERE email= :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email'=>$useremail]);
        $totalusers = $stmt->rowCount();
        
        $sql= "SELECT * FROM users WHERE name= :username ";
        $stmt = $pdo->prepare($sql);
        $beat = $stmt->execute(['username'=>$username]);
        $totalusers1 = $stmt->rowCount();
        
        if($totalusers > 0 ){
            $emailtaken = "This email has already been taken<br>";
            
            
        }
                elseif($totalusers1 > 0){
                    $nametaken = "This Username has already been taken<br>";
                    
                    
                }
        elseif((strlen($phoneno))!= 10 ){
            $incorrectphoneno = "Please use the +234 format";
        }
        
        else{
            $sql= "INSERT INTO users (dpname,name, email, password,phoneno,refferedme) VALUES (:dpname,:name,:email,:password,:phoneno,:refferedme)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['dpname'=>$dpname,'name'=>$username,'email'=>$useremail,'password'=>$passwordhashed,'phoneno'=>$phoneno,'refferedme'=>$refids]);
            
            




        
            header("location:http://trencynews.herokuapp.com/login.php");
        }
    }
    
    
}

?>
<?php require("./inc/header.html");?>

<div class="container" >
    <div class="card">
        <div class="card-header  bg-light mb-3">
            Register
        </div>
        <div class="card-body">
            <form action="register.php" method="post">
                <div class="form-group">
                                        <label for="dpname">Full Name</label>

                            <input type="text" name="dpname" class="form-control" required value="<?php if(isset($dpname)){echo $dpname;} ?>">
                </div>
                <div class="form-group">
                    <?php if(isset($nametaken)){ ?>
                        <p style="color: red;"> <?php echo $nametaken ?></p>
                        <?php } ?>
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" required value="<?php if(isset($username)){echo $username;} ?>">
                    </div>
                    <div class="form-group">
                        <?php if(isset($emailtaken)){ ?>
                            <p style="color: red;"> <?php echo $emailtaken ?></p>
                            <?php } ?>
                            <label for="useremail">Email</label>
                            <input type="email" name="useremail" class="form-control" required value="<?php if(isset($useremail)){echo $useremail;} ?>">
                        </div>
                        <div class="form-group">
                            <?php if(isset($incorrectphoneno)){ ?>
                            <p style="color: red;"> <?php echo $incorrectphoneno ?></p>
                            <?php } ?>
                                        <label for="phoneno">Phone Number</label>

<div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text">+234</div>
                                        </div>
                                        <input type="number" name="phoneno" class="form-control" required value="<?php if(isset($phoneno)){echo $phoneno;} ?>">
                                    </div>                </div>
          
            <div class="form-group">
                <label for="password">password</label>
                <input input type="password" class="form-control" name="password" minlength="8" required required title="Password must be a minimum of 7 characters" value="<?php if(isset($password)){echo $password;} ?>">
            </div>
            <div class="form-group">
                <label for="refid">Refferal ID</label>
                <input type="text" name="refid" class="form-control" value="<?php if(isset($_GET['refid'])){echo $_GET['refid'];}elseif(isset($refids)){
                    echo $refids;
                }else{echo "None";}  ?>" readonly>
            </div>
            <button type="submit" name="register" class="btn btn-primary">Register</button>
        </form>
    </div>
</div>
</div>


<?php require("./inc/footer.html");?>

<script src="./bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
<script src="./bootstrap-4.4.1-dist/js/bootstrap.bundle.min.js"></script>



