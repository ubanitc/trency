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

 if(isset($_POST['update1'])){
     $dpname = $_POST['dpname'];
     $phoneno = $_POST['phone'];
 

$sql = $pdo->prepare('UPDATE users SET dpname=:body, phoneno=:phone WHERE id = :id');

 $postss = $sql->execute(['id'=>$userid,'body'=>$dpname, 'phone'=>$phoneno]); 
 header("location:http://trencynews.herokuapp.com/profile.php");  
 } 

}else{
        header('location:http://trencynews.herokuapp.com/login.php');
    }
?>

       <?php require("./inc/header.html");?>

<form action="updateinfo.php" method="post">

<div class="container">
      <div class="card">
          <div class="card-body">

            <center>
        
            <h4>Edit Profile Info</h4>
        </center>
    

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="dpname">Full Name</label>
      <input type="text" name="dpname"class="form-control" value="<?php echo ucwords($user->dpname)?>">
    </div>
    <div class="form-group col-md-6">
      <label for="phone">Phone Number</label>
      <input type="text" name="phone" value="<?php echo ucwords($user->phoneno)?>" class="form-control" >
    </div>
  </div>
  <center><button type="submit" name="update1" class="btn btn-primary">Update Info</button></center>

  <!-- <div class="form-group">
    <label for="inputAddress">Address</label>
    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
  </div> -->
  

</div>
</div>


</div>


</form>

<?php require("./inc/footer.html");?>
