<?php
    $bandaraAsalFile = 'data/bandara-asal.json';
    $bandaraTujuanFile = 'data/bandara-tujuan.json';
    $dataFile = 'data/data.json';

    // Baca data bandara asal
    $bandaraAsal = json_decode(file_get_contents($bandaraAsalFile), true);

    // Baca data bandara tujuan
    $bandaraTujuan = json_decode(file_get_contents($bandaraTujuanFile), true);

    // Inisialisasi variabel $routes dengan array kosong
    $routes = [];

    // Proses form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $maskapai = $_POST['maskapai'];
        $bandaraAsalSelected = $_POST['bandara_asal'];
        $bandaraTujuanSelected = $_POST['bandara_tujuan'];
        $hargaTiket = floatval($_POST['harga_tiket']);

        // Ambil pajak berdasarkan bandara asal dan tujuan yang dipilih
        $pajakAsal = getPajak($bandaraAsal, $bandaraAsalSelected);
        $pajakTujuan = getPajak($bandaraTujuan, $bandaraTujuanSelected);
        $totalPajak = $pajakAsal + $pajakTujuan;
        $totalHarga = $hargaTiket + $totalPajak;

        $newRoute = [
            'maskapai' => $maskapai,
            'bandaraAsal' => $bandaraAsalSelected,
            'bandaraTujuan' => $bandaraTujuanSelected,
            'hargaTiket' => $hargaTiket,
            'pajak' => $totalPajak,
            'totalHarga' => $totalHarga
        ];

        // Simpan data ke file data.json
        $routes = json_decode(file_get_contents($dataFile), true);
        $routes[] = $newRoute;
        usort($routes, function ($route1, $route2) {
            return strcmp($route1['maskapai'], $route2['maskapai']);
        });
        file_put_contents($dataFile, json_encode($routes, JSON_PRETTY_PRINT));

        // Redirect untuk menghindari resubmission pada refresh
        header('Location: index.php');
        exit;
    }

    function getPajak($data, $bandara) {
        foreach ($data as $bandaraInfo) {
            if ($bandaraInfo['bandara'] === $bandara) {
                return $bandaraInfo['pajak'];
            }
        }
        return 0; // Default jika tidak ditemukan (seharusnya tidak terjadi dalam kasus ini)
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maskapai Penerbangan</title>
    <link rel="stylesheet" href="library/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Pendaftaran Rute Penerbangan</h1>
        <form action="index.php" method="post">
            <div class="form-group">
                <label for="maskapai">Maskapai:</label>
                <input type="text" name="maskapai" id="maskapai" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="bandara_asal">Bandara Asal:</label>
                <select name="bandara_asal" id="bandara_asal" class="form-control" required>
                    <?php foreach ($bandaraAsal as $bandara): ?>
                        <option value="<?= htmlspecialchars($bandara['bandara']) ?>"><?= htmlspecialchars($bandara['bandara']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="bandara_tujuan">Bandara Tujuan:</label>
                <select name="bandara_tujuan" id="bandara_tujuan" class="form-control" required>
                    <?php foreach ($bandaraTujuan as $bandara): ?>
                        <option value="<?= htmlspecialchars($bandara['bandara']) ?>"><?= htmlspecialchars($bandara['bandara']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="harga_tiket">Harga Tiket:</label>
                <input type="number" name="harga_tiket" id="harga_tiket" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <h2>Daftar Rute Penerbangan</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Maskapai</th>
                    <th>Bandara Asal</th>
                    <th>Bandara Tujuan</th>
                    <th>Harga Tiket</th>
                    <th>Pajak</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Pastikan file data.json ada dan dapat dibaca
                    if (file_exists($dataFile)) {
                        $datas = json_decode(file_get_contents($dataFile), true);
                        if ($datas) {
                            foreach ($datas as $penerbangan) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($penerbangan['maskapai']) . '</td>';
                                echo '<td>' . htmlspecialchars($penerbangan['bandaraAsal']) . '</td>';
                                echo '<td>' . htmlspecialchars($penerbangan['bandaraTujuan']) . '</td>';
                                echo '<td>' . htmlspecialchars($penerbangan['hargaTiket']) . '</td>';
                                echo '<td>' . htmlspecialchars($penerbangan['pajak']) . '</td>';
                                echo '<td>' . htmlspecialchars($penerbangan['totalHarga']) . '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="6">Tidak ada data rute penerbangan.</td></tr>';
                        }
                    } else {
                        echo '<tr><td colspan="6">File data.json tidak ditemukan.</td></tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
