<?php
    // Penentuan lokasi file untuk data bandara asal, bandara tujuan, dan data penerbangan
    $bandaraAsalFile = 'data/bandara-asal.json'; // Lokasi file JSON untuk data bandara asal
    $bandaraTujuanFile = 'data/bandara-tujuan.json'; // Lokasi file JSON untuk data bandara tujuan
    $dataFile = 'data/data.json'; // Lokasi file JSON untuk menyimpan data penerbangan

    // Membaca file JSON yang berisi informasi bandara asal dan mengubahnya menjadi array PHP menggunakan json_decode
    $bandaraAsal = json_decode(file_get_contents($bandaraAsalFile), true);

    // Membaca file JSON yang berisi informasi bandara tujuan dan mengubahnya menjadi array PHP menggunakan json_decode
    $bandaraTujuan = json_decode(file_get_contents($bandaraTujuanFile), true);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Penerbangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><strong>Pendaftaran Rute Penerbangan</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <!-- Form -->
    <div class="container px-5 my-5">
        <div class="card w-75 mx-auto">
            <div class="card-body">
                <form id="contactForm" action="proses.php" method="POST">
                    <!-- Input untuk nama maskapai -->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="namaMaskapai" name="maskapai" type="text" placeholder="Nama maskapai" required />
                        <label for="namaMaskapai">Nama maskapai</label>
                        <div class="invalid-feedback">Nama maskapai is required.</div>
                    </div>

                    <!-- Dropdown untuk memilih bandara asal -->
                    <div class="form-floating mb-3">
                        <select class="form-select" id="bandara_asal" name="bandara_asal" required>
                            <option value="">Pilih bandara</option>
                            <?php
                            // Looping untuk menampilkan opsi bandara asal dari data yang diperoleh dari $bandaraAsal
                            foreach ($bandaraAsal as $bandara) :
                            ?>
                                <option value="<?= $bandara['bandara'] ?>"><?= $bandara['bandara'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="bandara_asal">Bandara Asal</label>
                    </div>

                    <!-- Dropdown untuk memilih bandara tujuan -->
                    <div class="form-floating mb-3">
                        <select class="form-select" id="bandara_tujuan" name="bandara_tujuan" required>
                            <option value="">Pilih bandara</option>
                            <?php
                            // Looping untuk menampilkan opsi bandara tujuan dari data yang diperoleh dari $bandaraTujuan
                            foreach ($bandaraTujuan as $bandara) :
                            ?>
                                <option value="<?= $bandara['bandara'] ?>"><?= $bandara['bandara'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="bandara_tujuan">Bandara Tujuan</label>
                    </div>

                    <!-- Input untuk harga tiket -->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="hargaTiket" name="harga_tiket" type="number" step="0.01" placeholder="Harga Tiket" required />
                        <label for="hargaTiket">Harga Tiket</label>
                        <div class="invalid-feedback">Harga Tiket is required.</div>
                    </div>

                    <!-- Tombol submit untuk mengirimkan form -->
                    <div class="d-grid">
                        <button class="btn btn-primary btn-lg" id="submitButton" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container mb-5">
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
                    // Pastikan file data.json ada dan dapat dibaca
                    if (file_exists($dataFile)) {
                        // Membaca file JSON yang berisi informasi data penerbangan dan mengubahnya menjadi array PHP menggunakan json_decode
                        $datas = json_decode(file_get_contents($dataFile), true);
                        if ($datas) {
                            foreach ($datas as $penerbangan) {
                                echo '<tr>';
                                echo '<td>' . $penerbangan['maskapai'] . '</td>';
                                echo '<td>' . $penerbangan['bandaraAsal'] . '</td>';
                                echo '<td>' . $penerbangan['bandaraTujuan'] . '</td>';
                                echo '<td>' . $penerbangan['hargaTiket'] . '</td>';
                                echo '<td>' . $penerbangan['pajak'] . '</td>';
                                echo '<td>' . $penerbangan['totalHarga'] . '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="6" class="text-center">Tidak ada data rute penerbangan.</td></tr>';
                        }
                    } else {
                        echo '<tr><td colspan="6" class="text-center">File data.json tidak ditemukan.</td></tr>';
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
