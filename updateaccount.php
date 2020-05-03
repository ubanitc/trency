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
     $dpname = $_POST['acctno'];
     $phoneno = $_POST['bank'];
 

$sql = $pdo->prepare('UPDATE users SET acctno=:body, bank=:phone WHERE id = :id');

 $postss = $sql->execute(['id'=>$userid,'body'=>$dpname, 'phone'=>$phoneno]); 
 header("location:http://trencynews.herokuapp.com/profile.php");  
 } 

}else{
        header('location:http://trencynews.herokuapp.com/login.php');
    }
?>

       <?php require("./inc/header.html");?>

<form action="updateaccount.php" method="post">

<div class="container">
      <div class="card">
          <div class="card-body">

            <center>
        
            <h4>Edit Account Details</h4>
        </center>
    

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="dpname">Account Number</label>
      <input type="text" name="acctno"class="form-control" value="<?php echo ucwords($user->acctno)?>">
    </div>
    <div class="form-group col-md-6">
      <label for="phone">Bank</label>
      <input type="text" name="bank" value="<?php echo ucwords($user->bank)?>" class="form-control" >
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
