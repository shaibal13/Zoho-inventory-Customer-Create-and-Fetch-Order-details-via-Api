

<?php
include 'header.php';
?>


<?php 

function retreieveOrders($order_id){
   $client_id='1000.AXIVSP9ZQ6XDCAGB48AU3XW44DGR9Z';
   $client_secret='d51de5191a93d1c85fb31fce6fbd76069b1ea7873a';
   
   $code='1000.fdf883f6c018be1f5fa1cda508b32f8e.2c57e158f3d951792de543cb181f3989';
   $base_url = 'https://accounts.zoho.com';
   $token_url = $base_url . '/oauth/v2/token?grant_type=authorization_code&client_id='. $client_id . '&client_secret='. $client_secret . '&redirect_uri=http://localhost&code=' . $code;
   
  
     $generateToken=json_decode(generateRefreshToken($token_url), true);
     
     $access_token=$generateToken['access_token'];
     $refresh_token=$generateToken['refresh_token'];
   
     
     $access_token_url = $base_url .  '/oauth/v2/token?refresh_token='.$refresh_token.'&client_id='.$client_id.'&client_secret='.$client_secret .'&grant_type=refresh_token';
     $url_order='https://inventory.zoho.com/api/v1/salesorders/'.$order_id.'?organization_id=778671151'; //778671151 my organisation id .Replace it with yours.
     $access_token_new = json_decode(generateAccessToken($access_token_url), true); 
    
     $access_token=$access_token_new['access_token'];

     $header = array(
        'Authorization: Zoho-oauthtoken ' . $access_token,
        'Content-Type: application/json'
      );
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $url_order);
   
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
      $result = curl_exec($ch);
      curl_close($ch);
      return $result;
     
     
}

     function generateRefreshToken($url){
      
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result ;
       
      }   

    function generateAccessToken($url){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
  

?>

<section class="content home">
    <div class="container-fluid">
		<div class="block-header mt-3 ml-3">
			<h1>A ZOHO TEST(Using Self Client for now)</h1>
		</div>
		<div class="row clearfix">
        
			<div class="col-sm-12 col-lg-12 col-xl-9">
                
				<div class="card" id="Accordions">
                <div class="header">
                <h4>Order</h4>
                </div>
					<div class="body">
                    <form action="" method="post">
                    <div class="form-group">
                        <label for="formFile" class="form-label mt-0">Order Id:</label>
                        <input class="form-control" type="text" name="order_id" placeholder="Order Id" required>
                    </div>
                   
                    <div class="form-group">
                        <button type="submit" class="btn-primary pull-right"> Submit</button>
                    </div>
                        </form>
						
</div>
</div>
</div>
</div>

</div>
<?php

if(isset($_POST['order_id'])) {
   
    $data=json_decode(retreieveOrders($_POST['order_id']),true) ;
?>
<div class="row clearfix">
        
        <div class="col-sm-12 col-lg-12 col-xl-9">
            
            <div class="card" id="Accordions">
            <div class="header">
            <h4>Order Details</h4>
            </div>
                <div class="body">
              <?php print_r($data); ?>
                    
</div>
</div>
</div>
</div>
<?php }

include 'footer.php';
?>