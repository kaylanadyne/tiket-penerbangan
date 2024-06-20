<?php
    // Penentuan lokasi file untuk data bandara asal, bandara tujuan, dan data penerbangan
    $bandaraAsalFile = './data/bandara-asal.json'; // Lokasi file JSON untuk data bandara asal
    $bandaraTujuanFile = 'data/bandara-tujuan.json'; // Lokasi file JSON untuk data bandara tujuan
    $dataFile = 'data/data.json'; // Lokasi file JSON untuk menyimpan data penerbangan

    // Baca data bandara asal
    $bandaraAsal = json_decode(file_get_contents($bandaraAsalFile), true);

    // Baca data bandara tujuan
    $bandaraTujuan = json_decode(file_get_contents($bandaraTujuanFile), true);

    // Inisialisasi variabel $routes dengan array kosong
    $routes = [];

    // Proses form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Mengambil nilai dari formulir yang disubmit menggunakan metode POST
        $maskapai = $_POST['maskapai']; // Mengambil nilai maskapai dari input form
        $bandaraAsalSelected = $_POST['bandara_asal']; // Mengambil nilai bandara asal yang dipilih dari input form
        $bandaraTujuanSelected = $_POST['bandara_tujuan']; // Mengambil nilai bandara tujuan yang dipilih dari input form
        $hargaTiket = $_POST['harga_tiket']; // Mengambil nilai harga tiket dari input form


        // Menghitung pajak berdasarkan bandara asal dan tujuan yang dipilih.
        $pajakAsal = getPajak($bandaraAsal, $bandaraAsalSelected); // Mendapatkan pajak dari bandara asal yang dipilih
        $pajakTujuan = getPajak($bandaraTujuan, $bandaraTujuanSelected); // Mendapatkan pajak dari bandara tujuan yang dipilih
        $totalPajak = $pajakAsal + $pajakTujuan; // Menghitung total pajak dengan menjumlahkan pajak dari bandara asal dan tujuan

        // Menghitung total harga dengan menambahkan harga tiket dan total pajak
        $totalHarga = $hargaTiket + $totalPajak;

        // Membuat array $newRoute untuk menyimpan data baru rute penerbangan yang akan disimpan ke file data.json
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
        // Menggunakan usort untuk mengurutkan array $routes berdasarkan nama maskapai (maskapai) dari setiap elemen rute penerbangan.
        // Fungsi pembanding menggunakan strcmp untuk membandingkan nilai string dari maskapai pada dua elemen array $route1 dan $route2.
        usort($routes, function ($route1, $route2) {
            return strcmp($route1['maskapai'], $route2['maskapai']);
        });
        // Menggunakan json_encode untuk mengubah array $routes menjadi format JSON.
        file_put_contents($dataFile, json_encode($routes, JSON_PRETTY_PRINT));

    }

    // Fungsi untuk mendapatkan nilai pajak berdasarkan nama bandara dari data yang diberikan
    // $data Array yang berisi data bandara beserta informasi pajak.
    // string $bandara Nama bandara yang ingin dicari pajaknya.
    function getPajak($data, $bandara)
    {
        foreach ($data as $bandara_info) {
            if ($bandara_info['bandara'] === $bandara) {
                return $bandara_info['pajak']; // Mengembalikan nilai pajak jika nama bandara cocok
            }
        }
        return 0; // Mengembalikan nilai 0 jika tidak ditemukan data pajak untuk bandara yang dimaksud
    }

    // Melakukan redirect ke halaman index.php menggunakan header Location.
    // Ini dilakukan untuk menghindari resubmission form saat melakukan refresh pada halaman.
    // Setelah mengirim data dengan metode POST, redirect akan memuat ulang halaman index.php.
    header('Location: form.php');
    exit;
?>