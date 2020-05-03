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
        header('location:login.php');
    }

?>
<?php

        $stmt1 = $pdo->prepare("SELECT * FROM users WHERE refferedme=:names and status='active'");
        $stmt1->execute(['names'=>$user->name]);
   $reffs = $stmt1->fetchAll();
   $rowct = $stmt1->rowCount();
        



?>


    <?php require("./inc/header.html");?>


        <?php if(isset($_SESSION['failurenotify'])){?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong><?php echo $_SESSION['failurenotify'];unset($_SESSION['failurenotify']) ?></strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
        <?php }?>
        <?php if(isset($_SESSION['failurenotify1'])){?>
           <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong><?php echo $_SESSION['failurenotify1'];unset($_SESSION['failurenotify1']) ?></strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
        <?php }?>
        <?php if(isset($_SESSION['successaff'])){?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong><?php echo $_SESSION['successaff'];unset($_SESSION['successaff']) ?></strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
        <?php }?>


    <?php if(isset($user)){ ?>
<div class="container">
  <div class="card" >
  <div class="card-body">
    <h4 class="card-title">Affiliate Earnings  </h4>
   <h5> Total Earnings:<p style="color:green;">&#8358;<?php $totalamount = (int)(($rowct * 1000)); echo $totalamount ?></p></h5>
    <p class="card-text">Total Paid: &#8358;<?php $totalpaid = (int)($user->totalpaid); echo $totalpaid?></p>
    <p class="card-text">Pending Withdrawal: &#8358;<?php $pending = (int)($user->pendingwithdraw); echo $pending?> </p>
    <p class="card-text">Available for Cashout: &#8358;<?php $cashout = (int)($totalamount - ($totalpaid + $pending)); echo $cashout ?> </p>
  </div>
</div>
<div class="card mt-3">
      <div class="card-body">

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Request Withdrawal</button>
  </div>
  </div>
</form>
</div>


    <?php }?>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Withdraw</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
    $limit =(int)3000;

        

          if($cashout < $limit){?>
            <p>You need a Minimum of &#8358 3,000 to Withdraw you Affiliate Earnings</p>

<?php }elseif($cashout >= $limit){?>
  <form action="withdrawal.php" method="post">
             <input class="form-control mb-4" name="withdrawsamt" type="text" placeholder="Withdrawal Amount">
             <button type="submit" class="btn btn-success" name="withdraws" >Withdraw</button>
             </form>
         <?php }?>
      </div>
     
    </div>
  </div>
</div>

<?php

  if(isset($_POST['withdraws'])){


      
    $withdrawsamt = $_POST['withdrawsamt'];
    if($withdrawsamt > $cashout){
      $failurenotify = "You can not Withdraw that Ammount";
      $_SESSION['failurenotify'] = $failurenotify;
    }elseif($withdrawsamt < $limit ){
          $failurenotify1 = "you can withdraw a minimum of &#8358 3,000";
          $_SESSION['failurenotify1'] = $failurenotify1;
    }else{
    // $putpend = (int)( $cashout - $withdrawsamt);  

    

    $nowpend = $withdrawsamt + $pending;


    $ramp = $stmt = $pdo->query("UPDATE users SET pendingwithdraw=$nowpend WHERE id=$userid");

    if($ramp){
      $successaff = "Your withdrawal was Successful";
      $_SESSION['successaff']=$successaff;
    }
    header("location:withdrawal.php");
  }

  }


?>


    
<?php require("./inc/footer.html");?>