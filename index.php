<?php 
include('database.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Courses</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
<div class="row">

<?php 
$sql="select * from courses";
$result=mysqli_query($conn,$sql);

while($data=mysqli_fetch_array($result))
{?>
<div class="col-xl-4">
<form method="post" action="https://www.sandbox.paypal.com/cgi-bin/webscr">

<input type="hidden" name="business" value="sb-ue2eh27310939@business.example.com">
<input type="hidden" name="item_name" value="<?php echo $data['name'];?>">
<input type="hidden" name="item_number" value="<?php echo $data['id'];?>">
<input type="hidden" name="amount" value="<?php echo $data['price'];?>">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="return" value="http://localhost/php-practical-work/payment-gateway/paypal/success.php">
<input type="hidden" name="cancel_return" value="http://localhost/php-practical-work/payment-gateway/paypal/cancel.php">


  <div class="card" style="width:400px">
    <img class="card-img-top" src="uploads/<?php echo $data['image'];?>" alt="Card image" style="width:100%">
    <div class="card-body">
      <h4 class="card-title"><?php echo $data['name'];?></h4>
      <p class="card-text">$<?php echo $data['price'];?></p>
      <button type="submit" class="btn btn-primary">Buy Now</button>
    </div>
  </div>

</form>  
  
</div>
<?php } ?>
 
 
</div> 
</div>

</body>
</html>
