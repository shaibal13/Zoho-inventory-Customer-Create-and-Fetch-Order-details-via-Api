<?php 
include 'header.php';
$name=$_POST['name'];
$company_name=$_POST['company_name'];
$website=$_POST['website'];


$data=
     array('contact_name' =>$name,'company_name'=>$company_name,'website'=>$website,"contact_type"=>"customer");

      $client_id='1000.AXIVSP9ZQ6XDCAGB48AU3XW44DGR9Z';
      $client_secret='d51de5191a93d1c85fb31fce6fbd76069b1ea7873a';
      
      $code='1000.ded5f656930dd5cd920e2460b2442a4e.69580cbcbb92d5573fb45d781606bf4c';
      $base_url = 'https://accounts.zoho.com';
      $token_url = $base_url . '/oauth/v2/token?grant_type=authorization_code&client_id='. $client_id . '&client_secret='. $client_secret . '&redirect_uri=http://localhost&code=' . $code;
      
     
        $generateToken=json_decode(generateRefreshToken($token_url), true);
        
        $access_token=$generateToken['access_token'];
        $refresh_token=$generateToken['refresh_token'];
      
        
        $access_token_url = $base_url .  '/oauth/v2/token?refresh_token='.$refresh_token.'&client_id='.$client_id.'&client_secret='.$client_secret .'&grant_type=refresh_token';
        $url_customer='https://inventory.zoho.com/api/v1/contacts?organization_id=778671151'; //778671151 my organisation id .Replace it with yours.
        $access_token_new = json_decode(generateAccessToken($access_token_url), true); 
       
        $access_token=$access_token_new['access_token'];
       
        $header = array(
            'Authorization: Zoho-oauthtoken ' . $access_token,
            'Content-Type: application/json'
          );
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_URL, $url_customer);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
          curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
          $result = curl_exec($ch);
          curl_close($ch);
          $customer_data=json_decode($result,true);
        
        

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
                <h4>Customer Info</h4>
                </div>
					<div class="body">
                  
          <div class="table-responsive">
	<table class="table  border text-nowrap text-md-nowrap mg-b-0">
		<thead>
			<tr>
      <th>Contact Id</th>
				<th>Contact Name</th>
				<th>Company Name</th>
				<th>Website</th>
			
			</tr>
		</thead>
		<tbody>
			<tr >
				<td><?php echo $customer_data['contact']['contact_id']?></td>
				<td><?php echo $customer_data['contact']['contact_name']?></td>
				<td><?php echo $customer_data['contact']['company_name']?></td>
				<td><?php echo $customer_data['contact']['website']?></td>
			</tr>
		
		</tbody>
	</table>
</div>
</div>
</div>
</div>
</div>
</div>

</div>
<?php include 'footer.php'; ?>