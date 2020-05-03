<?php
        session_start();

if(isset($_SESSION['userid'])){
        require("./db.php");
        $userid = $_SESSION['userid'];
  }else{
        header("location:https://trencynews.herokuapp.com/login.php");
    }

$curl = curl_init();
$reference = isset($_GET['reference']) ? $_GET['reference'] : '';
if(!$reference){
  die('No reference supplied');
}

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => [
    "accept: application/json",
    "authorization: Bearer sk_test_900aa5799bda7a5aa26ad6e203efd93369d15d0b",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
    // there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response);

if(!$tranx->status){
  // there was an error from the API
  die('API returned error: ' . $tranx->message);
}

if('success' == $tranx->data->status){
  // transaction was successful...
  // please check other things like whether you already gave value for this ref
  // if the email matches the customer who owns the product etc
  // Give value
  
        


        
       $stmt = $pdo->query("UPDATE users SET status='active' WHERE id=$userid");
        $_SESSION['paymentsuccess'] = "Your Payment Was Succesfull and Your Account is now Acitve";
       
         header('location:https://trencynews.herokuapp.com/');

        



    
   
    
  
}
else{
        $_SESSION['paymentfail'] = "Your Payment Was not Succesful";

    header('location: https://trencynews.herokuapp.com/');
}




