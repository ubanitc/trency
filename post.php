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

require("./inc/header.html");

?>

<?php

    $id=$_GET['id'];

    $stmt = $pdo->query("SELECT * FROM posts WHERE id=$id");
    $post = $stmt->fetch();?>

                <div class="container text-center">
                            <h4><?php echo $post->post_title?></h4>
  <div class="d-flex bd-highlight mb-3" style="height:70px">
  <div class="p-2 flex-fill bd-highlight border border-primary mr-2">Ad Space</div>
  
</div>
                </div>
<div class="container">

    <div class="card rounded-lg">
        
    <div class="card-header">
            <strong><?php echo $post->post_title?></strong> posted by <strong><?php echo $post->posted_by?></strong>   <?php echo $post->time?>
    </div>
        <div class="card-body">
           <?php 
                
                echo $post->post_content;

             ?>
             <p class="mt-3">
             <iframe height="auto" width="auto"  
src="https://ww
w.youtube.com/embed/il_t1WVLNxk"> 
</iframe>
</p>
        </div>
</div>
</div>
</div>
 </div>

<div class="container text-center">
  <div class="d-flex bd-highlight mb-3" style="height:70px">
  <div class="p-2 flex-fill bd-highlight border border-primary mr-2">Ad Space</div>
 
</div>
    





















<?php require("./inc/footer.html");
 ?>
