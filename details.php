<?php
$result = "";
if (isset($_GET["q"]) && !empty($_GET["q"])) {
  $productDode = $_GET["q"];
  $url = "https://api.rezdy-staging.com/v1/products/" . $productDode . "?apiKey=69f708868ddc45eaa1f9b9fad1ddeba5";
  // $url = "https://api.rezdy-staging.com/v1/products/PPNMRD?apiKey=69f708868ddc45eaa1f9b9fad1ddeba5";
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  $response = curl_exec($curl);
  if (curl_errno($curl)) {
    echo 'Curl error: ' . curl_error($curl);
  }
  curl_close($curl);
  if ($response) {
    $result = json_decode($response)->product;
  }
} else {
  echo "invalid product code";
  exit;
}
$adultprice = 0;
$childprice = 0;
$infantsprice = 0;
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
    .booking-wrapper .info:not(:last-child) {
      border-right: 1px solid #dee2e6;
    }
  </style>
</head>

<body>
  <div class="detail-page pb-3">
    <section class="img-section mb-4">
      <div class="row g-2">
        <div class="banner-wrapper">
          <img src="<?php echo count($result->images) ? $result->images[0]->largeSizeUrl : 'no_image.png' ?>" alt="" class="w-100 img-fluid object-fit-cover" style="height: 40vh;">
        </div>
      </div>
    </section>

    <section class="details-section">
      <div class="container">
        <div class="row g-3 g-md-4">
          <div class="col-lg-7">
            <div class="left-info">
              <h4><?php echo $result->name; ?></h4>
              <h5 class="mt-4">Prodict Type</h5>
              <div class="discription">
                <?php echo $result->productType; ?>
              </div>

              <h5 class="mt-4">Prodict Code</h5>
              <div class="discription">
                <?php echo $result->productCode; ?>
              </div>

              <h5 class="mt-4">Description</h5>
              <div class="discription">
                <?php echo $result->description; ?>
              </div>

              <h5 class="mt-4">Prices</h5>
              <div class="discription">
                <?php foreach ($result->priceOptions as $key => $value) { 
                  $adultprice = $value->price;
                  if($value->label == 'Child') $childprice = $value->price;
                  if($value->label == 'Infant') $infantsprice = $value->price;
                  ?>
                  <?php echo $value->label; ?>:- $<?php echo $value->price; ?><br />
                <?php }  ?>
              </div>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="right-info">
              <section class="form-section mb-4">
                <form id="myForm" method="post" class="border rounded-3 mx-auto p-3 p-md-4" style="max-width: 700px;">
                  <div class="row g-3">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="form-label" for="adults">Adults (18-80):</label>
                        <input type="text" class="form-control py-2" id="adults" placeholder="Min: 1, Max: 6" name="adults" pattern="[1-6]{1,6}" maxlength="1" title="Please enter number 1 to 6" value="<?php echo $_GET['adults'] ?>" required />
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="form-label" for="infants">Children (3-17):</label>
                        <input type="text" class="form-control py-2" id="children" placeholder="Min: 0, Max: 6" name="children" pattern="[0-6]{1,6}" maxlength="1" title="Please enter number 0 to 6" value="<?php echo $_GET['children'] ?>" />
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="form-label" for="infants">Infant (0-2):</label>
                        <input type="text" class="form-control py-2" id="infants" placeholder="Min: 0, Max: 1" name="infants" pattern="[0-1]{1,1}" maxlength="1" title="Please enter number 0 to 1" value="<?php echo $_GET['infants'] ?>" />
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label class="form-label" for="children">Date:</label>
                        <input type="date" class="form-control py-2" id="date" placeholder="Date" name="date" value="<?php echo $_GET['startDate'] ?>" />
                      </div>
                    </div>
                  </div>
                  <input type="hidden" id="productCode" value="<?php echo $result->productCode ?>" />
                  <input type="hidden" id="adultprice" value="<?php echo $adultprice; ?>" />
                  <input type="hidden" id="childprice" value="<?php echo $childprice; ?>" />
                  <input type="hidden" id="infantsprice" value="<?php echo $infantsprice; ?>" />
              </section>
              <section class="booking-section mb-4">
                <div class="booking-wrapper d-flex border" id="seatAvailable">
                </div>
              </section>
              <button type="submit" id="checkAvaialbe" class="btn btn-primary py-2 w-100 checkAvailable">Check Availability</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
    $("#checkAvaialbe").on('click', function(event) {
      let adult = $('#adults').val();

      if (adult == '' || adult == 0 || adult > 6) {
        console.log($('#myForm').validate());
      }

      let children = $('#children').val();
      let infants = $('#infants').val();
      let adultprice = $('#adultprice').val();
      let childprice = $('#childprice').val();
      let infantsprice = $('#infantsprice').val();
      let date = $('#date').val();
      let queryString = `adult=${adult}&children=${children}&infants=${infants}&date=${date}&adultprice=${adultprice}&childprice=${childprice}&infantsprice=${infantsprice}`;
      $('#choosenDate').html(date);
      $('#checkAvaialbe').html('Checking...');
      $('#checkAvaialbe').attr('disabled', true);
      $.ajax({
        type: "POST",
        data: {
          productCode: $('#productCode').val(),
          startTime: date
        },
        url: 'checkAvailability.php',
        success: function(response) {
          let availability = '';
          if (response) {

            response.forEach(el => {
              availability += `<div class="info flex-fill">
              <div class="value fw-medium text-capitalize border-bottom p-2">${el.date}</div>
              ${el.seat > 0 ? `<a href="checkout.php?${queryString}" class="btn-link"><div class="value text-capitalize p-2">Book Now <br />${el.seat} Available</div></a>` : `<div class="value text-capitalize p-2">${el.seat} Available</div>`}
            </div>`;
            });

            $('#seatAvailable').html(availability);
          }
          $('#checkAvaialbe').addClass('d-none');
          $('#checkAvaialbe').html('Check Availability');
          $('#checkAvaialbe').attr('disabled', false);
        }
      });
    });

    $("#date").on('change', function(event) {
      $('#checkAvaialbe').removeClass('d-none');
      $('#seatAvailable').html('');
    });
  });
</script>

</html>