<?php
$result = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['search']) && !empty($_POST['search'])) {
    $query['search'] = $_POST['search'];
  }
  if (isset($_POST['startDate']) && !empty($_POST['startDate'])) {
    $query['startDate'] = $_POST['startDate'];
  }


  $send_parameters =  http_build_query($_POST);
  // $url = "https://api.rezdy-staging.com/v1/products?apiKey=5f4b36ff169047a4a5682cba7e07fea4&".$send_parameters;
  $url = "https://api.rezdy-staging.com/v1/products/marketplace?apiKey=69f708868ddc45eaa1f9b9fad1ddeba5&offset=" . rand(1, 20) . "&limit=20&" . $send_parameters;
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
  // echo $response;
  if ($response) {
    $result = json_decode($response)->products;
  }
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

</head>

<body>
  <div class="container py-3">
    <section class="form-section mb-4">
      <h5 class="fw-bold text-center mb-3">Rezdy Version</h5>
      <form id="myForm" method="post" action="" class="border rounded-3 mx-auto p-3 p-md-4" style="max-width: 700px;">
        <div class="row g-3">
          <div class="col-sm-6">
            <div class="form-group">
              <label class="form-label" for="adults">Adults (18-80):</label>
              <input type="text" class="form-control py-2" id="adults" placeholder="Min: 1, Max: 6" name="adults" pattern="[1-6]{1,6}" maxlength="1" title="Please enter number 1 to 6" required/>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label class="form-label" for="infants">Children (3-17):</label>
              <input type="text" class="form-control py-2" id="children" placeholder="Min: 0, Max: 6" name="children" pattern="[0-6]{1,6}" maxlength="1" title="Please enter number 0 to 6" />
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label class="form-label" for="infants">Infant (0-2):</label>
              <input type="text" class="form-control py-2" id="infants" placeholder="Min: 0, Max: 1" name="infants" pattern="[0-1]{1,1}" maxlength="1" title="Please enter number 0 to 1" />
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label class="form-label" for="children">Date:</label>
              <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control py-2" id="date" placeholder="Date" name="startDate" />
            </div>
          </div>
        </div>

        <div class="btn-wrapper mt-3">
          <button id="search" type="submit search" name="search" class="btn btn-primary px-3">
            Search
          </button>
          <button disabled id="searching" type="submit search" name="search" class="btn btn-primary px-3 d-none">
            Searching...
          </button>
        </div>
      </form>
    </section>

    <section class="result-section <?php echo count($result) < 1 ? 'd-none' : '' ?>">
      <h5 class="fw-bold text-center mb-3">Search Result</h5>

      <div class="row g-3 g-md-4">
        <?php foreach ($result as $key => $value) { ?>
          <div class="col-sm-6 col-md-4 col-xl-3">
            <a href="details.php?q=<?php echo $value->productCode; ?>&<?php echo $send_parameters; ?>" class="btn-link text-decoration-none">
              <div class="card">
                <img class="img-fluid" alt="" style="height: 225px; width: 100%; display: block;" src="<?php echo count($value->images) ? $value->images[0]->thumbnailUrl : 'no_image.png' ?>">
                <div class="card-body">
                  <h5 class="text-truncate"><?php echo $value->name; ?></h5>
                  <div class="description text-truncate text-muted mb-2">
                    <?php echo $value->shortDescription; ?>
                  </div>
                  <div class="item-price fw-medium text-capitalize">
                    from <span><del>$100</del></span>
                    <span>$<?php echo $value->priceOptions[0]->price; ?></span>
                  </div>
                </div>
              </div>
            </a>
          </div>
        <?php
        }
        ?>
      </div>
    </section>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
    $("#myForm").submit(function(event) {
      $('#search').addClass('d-none');
      $('#searching').removeClass('d-none');
    });
  });
</script>

</html>