<?php
session_start();

if(isset($_SESSION['userid'])){
        require("./db.php");
        $userid = $_SESSION['userid'];
        
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id= ?');
        $stmt->execute([$userid]);
        $user = $stmt->fetch();
        if($user){
            $message= 'your role is a guest';
        }

    }else{
        header('location:http://trencynews.herokuapp.com/login.php');
    }

?>

    <?php require("./inc/header.html");?>

<div class="container">
      <div class="card">
          <div class="card-body">

            <center><img src="./images/user.svg" alt="" class="mb-3">
        
            <h4>User Profile</h4>
        </center>
    

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="dpname">Full Name</label>
      <input type="text" name="dpname"class="form-control" id="inputEmail4" value="<?php echo ucwords($user->dpname)?>" readonly>
    </div>
    <div class="form-group col-md-6">
      <label for="phone">Phone Number</label>
      <input type="text" name="phone" value="<?php echo ucwords($user->phoneno)?>" class="form-control" readonly>
    </div>
  </div>
  <center><a href="./updateinfo.php"><button type="submit" name="update1" class="btn btn-primary">Edit profile Info</button></a></center>

  <!-- <div class="form-group">
    <label for="inputAddress">Address</label>
    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
  </div> -->
  

<form action="updateaccount.php" method="POST">
      <center class="mt-3"><h4>Account Details</h4></center>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Account Number</label>
      <input type="text" class="form-control" id="inputEmail4" value="<?php echo ucwords($user->acctno)?>" readonly>
    </div>
    <div class="form-group col-md-6">
      <label for="bank">Bank</label>
      <input type="text" name="bank" value="<?php echo ucwords($user->bank)?>" class="form-control" readonly>
    </div>
  </div>
  <center><button type="submit" name="update2" class="btn btn-primary">Edit Account Info</button></center>

  <!-- <div class="form-group">
    <label for="inputAddress">Address</label>
    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
  </div> -->
  
</form>
</div>
</div>

<div class="card mt-3">

        <div class="card-body">
                <h4>Affiliate Link:</h4>
                <p>http://trencynews.herokuapp.com/register.php?refid=<?php echo $user->name?></p>
        </div>
</div>

</div>

<?php

        $stmt1 = $pdo->prepare("SELECT * FROM users WHERE refferedme=:names");
        $stmt1->execute(['names'=>$user->name]);
   $reffs = $stmt1->fetchAll();
   $rowct = $stmt1->rowCount();
        



?>

<div class="container">

<div class="card mt-3">

        <div class="card-body">
                <h4>Refferals: <?php echo $rowct?></h4>
                <?php 
                foreach($reffs as $reff){?>
            
        
                <div class="card-header mb-2">Name:<?php echo $reff->dpname;?><br>Account Status: <?php echo $reff->status;?></div>
                <?php }?>
        </div>
</div>

</div>
<?php require("./inc/footer.html");?>
