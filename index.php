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
         <h5>Welcome <?php echo ucwords($user->dpname) ?></h5>
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
      <div class="card">
          <div class="card-text pt-2 pl-2">
                <p>Number of Registered Users: <?php echo $tham ?> </p>
      </div>
    </div>
</div>
    <div class="container">
<div class="d-flex bd-highlight mb-3" style="height:70px">
  <div class="p-2 flex-fill bd-highlight border border-primary mr-2">Ad Space</div>
  </div>
</div>
<div class="container">
    <?php
    
            


try {

    // Find out how many items are in the table
    $total = $pdo->query('
        SELECT
            COUNT(*)
        FROM
            posts
    ')->fetchColumn();

    // How many items to list per page
    $limit = 3;

    // How many pages will there be
    $pages = ceil($total / $limit);

    // What page are we currently on?
    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default'   => 1,
            'min_range' => 1,
        ),
    )));

    // Calculate the offset for the query
    $offset = ($page - 1)  * $limit;

    // Some information to display to the user
    $start = $offset + 1;
    $end = min(($offset + $limit), $total);

    // The "back" link
   

    // Prepare the paged query
    $stmt = $pdo->prepare('
        SELECT
            *
        FROM
            posts
        ORDER BY
            id DESC
        LIMIT
            :limit
        OFFSET
            :offset
    ');

    // Bind the query params
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    // Do we have any results?
    if ($stmt->rowCount() > 0) {
        // Define how we want to fetch the results
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $iterator = new IteratorIterator($stmt); ?>

        <!-- Display the results -->
        <div class="card rounded-lg">
            <div class="card-header text-center">
                <strong>NEWS</strong>
            </div>
            <div class="card-body text-center">
                
       <?php foreach ($iterator as $row) {
           
           $stmt = $pdo->query("SELECT * FROM posts ORDER BY id DESC");

            $posts = $stmt->fetchAll();
           
           
           ?>
          
                
              <strong >  <a href="/post.php?id=<?php echo $row['id'] ?>" ><p class="mb-2">><?php echo $row['post_title']."<<<br>"?></p></a> </strong>

            

              <?php }?>
            </div>
        </div>
    <?php } else {
        echo '<p>No results could be displayed.</p>';
    }?>
    <div class="card-footer text-center">

<?php

    for($x=1; $x <= $pages; $x++){?>
    <a href="?page=<?php echo $x ?>">(<?php echo $x?>)</a>
   <?php }?>
   </div>
<?php 
} catch (Exception $e) {
    echo '<p>', $e->getMessage(), '</p>';
}
?>
<!-- end pagination -->
<!-- end pagination -->
<!-- end pagination -->
<!-- end pagination -->
</div>


<?php require("./inc/footer.html");?>


<script src="./bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
  <script src="./bootstrap-4.4.1-dist/js/bootstrap.bundle.min.js"></script>
