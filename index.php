<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Penerbangan</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.html">Pendaftaran</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Form -->
    <div class="container px-5 my-5">
      <div class="card w-75 mx-auto">
        <div class="card-body">
          <form id="contactForm" data-sb-form-api-token="API_TOKEN">
            <div class="form-floating mb-3">
              <input class="form-control" id="namaMaskapai" type="text" placeholder="Nama maskapai" data-sb-validations="required" />
              <label for="namaMaskapai">Nama maskapai</label>
              <div class="invalid-feedback" data-sb-feedback="namaMaskapai:required">Nama maskapai is required.</div>
            </div>
            <div class="form-floating mb-3">
              <select class="form-select" id="bandaraAsal" aria-label="Bandara Asal" name="bandaraAsal">
                <option value="Pilih bandara"></option>
                <?php

                $json = file_get_contents('bandara-asal.json');
                $data = json_decode($json, true);

                foreach ($data as $item) {
                  echo '<option value="' . $item['bandara'] . '">' . $item['bandara'] . '</option>';
                }
                ?>

              </select>
              <label for="bandaraAsal">Bandara Asal</label>
            </div>
            <div class="form-floating mb-3">
              <select class="form-select" id="bandaraTujuan" aria-label="Bandara Tujuan">
                <option value="Pilih bandara"></option>
                <?php

                $json = file_get_contents('bandara-tujuan.json');
                $data = json_decode($json, true);

                foreach ($data as $item) {
                  echo '<option value="' . $item['bandara'] . '">' . $item['bandara'] . '</option>';
                }
                ?>
              </select>
              <label for="bandaraTujuan">Bandara Tujuan</label>
            </div>
            <div class="form-floating mb-3">
              <input class="form-control" id="hargaTiket" type="text" placeholder="Harga Tiket" data-sb-validations="required" />
              <label for="hargaTiket">Harga Tiket</label>
              <div class="invalid-feedback" data-sb-feedback="hargaTiket:required">Harga Tiket is required.</div>
            </div>

            <div class="d-none" id="submitSuccessMessage">
              <div class="text-center mb-3">
                <div class="fw-bolder">Form submission successful!</div>
                <p>To activate this form, sign up at</p>
                <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
              </div>
            </div>
            <div class="d-none" id="submitErrorMessage">
              <div class="text-center text-danger mb-3">Error sending message!</div>
            </div>
            <div class="d-grid">
              <button class="btn btn-primary btn-lg disabled" id="submitButton" type="submit">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th scope="col">Nama Maskapai</th>
              <th scope="col">Asal Penerbangan</th>
              <th scope="col">Tujuan Penerbangan</th>
              <th scope="col">Harga Tiket</th>
              <th scope="col">Pajak</th>
              <th scope="col">Total Harga</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($data as $data) {
              echo '<tr>';
              echo '<td>' . $data['namaMaskapai'] . '</td>';
              echo '<td>' . $data['bandaraAsal'] . '</td>';
              echo '<td>' . $data['bandaraTujuan'] . '</td>';
              echo '<td>' . $data['hargaTiket'] . '</td>';
              echo '<td>' . $data['pajak'] . '</td>';
              echo '<td>' . $data['totalHarga'] . '</td>';
              echo '</tr>';
            }
            ?>
          </tbody>
        </table>
      </div>

    </div>

  <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>