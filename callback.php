<?php

session_start();

if(isset($_SESSION['userid'])){
        require("./db.php");
        $userid = $_SESSION['userid'];
        
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id= :id');
        $stmt->execute(['id'=>$userid]);
        $user = $stmt->fetch();
        if($user){
            $message= $user->email;
        }




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
    "authorization: Bearer sk_test_a9f8a0cae1a2315feb07f6a046d362283b16423f",
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
    // $stmt = $pdo->query("UPDATE users SET status='active WHERE id=$userid");
    // $_SESSION['paymentsuccess'] = "Your Payment Was Succesfull and Your Account is now Acitve";
  header('location: https://trencynews.herokuapp.com/paid.php');
    
  
}
else{
        $_SESSION['paymentfail'] = "Your Payment Was not Succesful";

    header('location: https://trencynews.herokuapp.com/fail.php');
}




