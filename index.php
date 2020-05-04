<?php
session_start();

require("./db.php");
if(isset($_SESSION['userid'])){
        $userid = $_SESSION['userid'];
        
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id= ?');
        $stmt->execute([$userid]);
        $user = $stmt->fetch();
        if($user){
            $message= 'your role is a guest';
        }

    }


     
                
                
                
                
                
                
                
?>
<?php require("./inc/header.html");?>

<div class="container">
      <div class="card rounded-lg bg-light mb-3">
        <div class="card-header">

        <?php if(isset($message)){
            ?>
         <h5>Welcome <?php echo $user->dpname ?></h5>
        </div>
                <?php if( $user->acctno === "" or $user->bank === '') { ?>
                
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Update Account Details</strong> Your account details are not set <a href="./updateaccount.php"><button class="btn btn-success" style="float:right;">Update Account</button></a>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
                <?php } ?>

            <?php }else{ ?>

        
          <h5>Welcome Guest</h5>
        <?php } ?>
        

                    <?php if(isset($_SESSION['paymentsuccess'])){?>
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
  <strong>Your Account is Now Active</strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
                    <?php } ?>
                    <?php if(isset($_SESSION['paymentfail'])){?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Account Activation Failed</strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>                    <?php } ?>

          <?php if(isset($message)){
            ?>
<!--          <h5>This is a super secret content for only logged in people</h5> -->
            <?php   if($user->status === 'inactive'){?>
                    <div class="card mb-2">
                        <div class="card-body">

         <p>Your Account is Inactive: </p><a href="./initialize.php"><button class="btn btn-primary">Activate Account</button></a>
         </div>
         </div>
            <?php }?>
        <?php }else{?>
<!--           <h4>Please Login/register to unlock all contents</h4> -->
        <?php } ?>
        <?php 
            $stmt = $pdo->query("SELECT * FROM users WHERE status ='active' ");
            $act = $stmt->fetchAll();
            $tham = $stmt->rowCount();
                        



        ?>
      </div>
      <div class="container mb-2">
      <div class="card">
          <div class="card-body ">
                <p>Number of Registered Users: <?php echo $tham ?> </p>
          </div>
      </div>
      </div>
    </div>

    <div class="container">
<div class="d-flex bd-highlight mb-3" style="height:70px">
  <div class="p-2 flex-fill bd-highlight border border-primary mr-2">Ad Space</div>
  </div>
</div>
    <?php
    
            $stmt = $pdo->query("SELECT * FROM posts ORDER BY id DESC");
            $posts = $stmt->fetchAll(); ?>
            <div class="container">
<div class="card rounded-lg">
    <div class="card-header text-center">
            <strong>NEWS</strong>
    </div>
    <div class="card-body text-center">
           <?php foreach($posts as $post){?>
                
              <strong>  <a href="/post.php?id=<?php echo $post->id ?>" >>><?php echo $post->post_title."<<<br>"?></a> </strong>

            <?php }?>
</div>
</div>
</div>


<?php require("./inc/footer.html");?>


<script src="./bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
  <script src="./bootstrap-4.4.1-dist/js/bootstrap.bundle.min.js"></script>
