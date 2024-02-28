<?php
$totalAmount = 0;

$adults = '';
if(!empty($_GET['adult'])){
	$totalAdult = $_GET['adult']*$_GET['adultprice'];
	$adults = 'Adults ('. $_GET['adult'] . 'x' . $_GET['adultprice'] . ') =' . '$' . $totalAdult;
	$totalAmount += $totalAdult;
}

$children = '';
if(!empty($_GET['children'])){
	$totalChildren = $_GET['children']*$_GET['childprice'];
	$children = 'Children ('. $_GET['children'] . 'x' . $_GET['childprice'] . ') =' . '$' . $totalChildren;
	$totalAmount += $totalChildren;
}

$infants = '';
if(!empty($_GET['infants'])){
	$totalInfants = $_GET['infants']*$_GET['infantsprice='];
	$infants = 'Infants ('. $_GET['infants'] . 'x' . $_GET['infantsprice'] . ') =' . '$' . $totalInfants;
	$totalAmount += $totalInfants;
}

$minimun = $totalAmount*0.2;

function randomName()
{
	$firstname = array(
		'Johnathon',
		'Anthony',
		'Erasmo',
		'Raleigh',
		'Nancie',
		'Tama',
		'Camellia',
		'Augustine',
		'Christeen',
		'Luz',
		'Diego',
		'Lyndia',
		'Thomas',
		'Georgianna',
		'Leigha',
		'Alejandro',
		'Marquis',
		'Joan',
		'Stephania',
		'Elroy',
		'Zonia',
		'Buffy',
		'Sharie',
		'Blythe',
		'Gaylene',
		'Elida',
		'Randy',
		'Margarete',
		'Margarett',
		'Dion',
		'Tomi',
		'Arden',
		'Clora',
		'Laine',
		'Becki',
		'Margherita',
		'Bong',
		'Jeanice',
		'Qiana',
		'Lawanda',
		'Rebecka',
		'Maribel',
		'Tami',
		'Yuri',
		'Michele',
		'Rubi',
		'Larisa',
		'Lloyd',
		'Tyisha',
		'Samatha',
	);

	$lastname = array(
		'Mischke',
		'Serna',
		'Pingree',
		'Mcnaught',
		'Pepper',
		'Schildgen',
		'Mongold',
		'Wrona',
		'Geddes',
		'Lanz',
		'Fetzer',
		'Schroeder',
		'Block',
		'Mayoral',
		'Fleishman',
		'Roberie',
		'Latson',
		'Lupo',
		'Motsinger',
		'Drews',
		'Coby',
		'Redner',
		'Culton',
		'Howe',
		'Stoval',
		'Michaud',
		'Mote',
		'Menjivar',
		'Wiers',
		'Paris',
		'Grisby',
		'Noren',
		'Damron',
		'Kazmierczak',
		'Haslett',
		'Guillemette',
		'Buresh',
		'Center',
		'Kucera',
		'Catt',
		'Badon',
		'Grumbles',
		'Antes',
		'Byron',
		'Volkman',
		'Klemp',
		'Pekar',
		'Pecora',
		'Schewe',
		'Ramage',
	);

	$name = $firstname[rand(0, count($firstname) - 1)];
	$name .= ' ';
	$name .= $lastname[rand(0, count($lastname) - 1)];

	return $name;
}

function generateTransactionId($length = 10)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$timestamp = time();
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	$transactionId = $timestamp . $randomString;
	return $transactionId;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Boking</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

	<style type="text/css">
		 .stripe-button-el {
			width: 100% !important;
		}
	</style>
</head>

<body>
	<div class="container py-3">
		<section class="form-section mb-4">
			<h5 class="fw-bold text-center mb-3">Booking Details</h5>
			<form id="myForm" method="post" action="" class="border rounded-3 mx-auto p-3 p-md-4" style="max-width: 500px;">
				<div class="row g-3">
					<div class="col-12">
						<div class="form-group">
							<label class="form-label fw-medium" for="name">Name</label>
							<input type="text" class="form-control py-2" id="name" name="name" autocomplete="off" value="<?php echo randomName(); ?>" disabled />
						</div>
					</div>

					<div class="col-12">
						<div class="form-group">
							<label class="form-label fw-medium" for="bookingid">Booking id</label>
							<input type="text" class="form-control py-2" id="bookingid" name="bookingid" autocomplete="off" value="<?php echo generateTransactionId(); ?>" disabled />
						</div>
					</div>

					<div class="col-12">
						<div class="form-group">
							<label class="form-label fw-medium" for="phone">Phone Number</label>
							<input type="text" class="form-control py-2" id="phone" name="phone" autocomplete="off" />
						</div>
					</div>

					<div class="col-12">
						<div class="form-group">
							<div class="mb-1"><?php echo $adults; ?></div>
							<div class="mb-1"><?php echo $children;?></div>
							<div class="mb-1"><?php echo $infants;?></div>
							<div class="fw-medium mb-1">Total Amount: $<?php echo $totalAmount; ?></div>
						</div>
					</div>

					<div class="col-6">
						<div class="form-group">
							<label class="form-label fw-medium" for="bookingid">
							20% Deposit ($<?php echo $minimun; ?>)</label>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
						<script id="checkout" src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="pk_test_51KW8A8ItvA6u4On8YM6AE95ytcqBr0LeRBEEFw4f5MDQPTDBWVt2TAWXhfynCn7NUVwaGc2eP431DNCkmfMaB0AF00firEVJ58" data-image="" data-name="Test Booking" data-description="Demo Transaction" data-amount="<?php echo $minimun; ?>00"></script>
						</div>
					</div>

					<div class="col-6">
						<div class="form-group">
							<label class="form-label fw-medium" for="bookingid">
							Full Amount ($<?php echo $totalAmount; ?>)</label>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
						<script id="checkout" src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="pk_test_51KW8A8ItvA6u4On8YM6AE95ytcqBr0LeRBEEFw4f5MDQPTDBWVt2TAWXhfynCn7NUVwaGc2eP431DNCkmfMaB0AF00firEVJ58" data-image="" data-name="Test Booking" data-description="Demo Transaction" data-amount="<?php echo $totalAmount; ?>00"></script>
						</div>
					</div>
				</div>
			</form>
		</section>
	</div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
    $("#checkout").click(function(event) {
		event.preventDefault();
      console.log('vasfda');
    });
  });
</script>

<script>
$(document).ready(function(){
    $('#checkout-button').click(function(){
        // Open the Stripe Checkout modal
        // $('.stripe-button').click();
    });
});
</script>
</html>