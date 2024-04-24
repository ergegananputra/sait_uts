<!doctype html>
<html lang="en">
    <head>
        <title>PSAIT</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>

        <br>

        <h1 style="text-align: center;">Mengubah Data Nilai Perkuliahan Mahasiswa</h1>

        <br>

        <?php
            include '../utils/import_helper.php';

            $route = new Route();
            $update = $route->perkuliahan->updateDo;

            $nim = $_GET[PerkuliahanModel::NIM];
            $kode_mk = $_GET[PerkuliahanModel::KODE_MK];

            // Get mahasiswa

            $url_mhs = APIConfig::MAHASISWA_ENDPOINT . "?nim=" . $nim;

            $curl_mhs = curl_init();
            curl_setopt($curl_mhs, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_mhs, CURLOPT_URL, $url_mhs);

            $res_mhs = curl_exec($curl_mhs);
            $json_mhs = json_decode($res_mhs, true);

            curl_close($curl_mhs);
            
            // Get matakuliah

            $url_mk = APIConfig::MATAKULIAH_ENDPOINT . "?kode_mk=" . $kode_mk;

            $curl_mk = curl_init();
            curl_setopt($curl_mk, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_mk, CURLOPT_URL, $url_mk);

            $res_mk = curl_exec($curl_mk);
            $json_mk = json_decode($res_mk, true);

            curl_close($curl_mk);

            // Get nilai

            $nama = $json_mhs['data'][0][MahasiswaModel::NAMA];
            $nama_mk = $json_mk['data'][0][MatakuliahModel::NAMA_MK];
            $update = $route->perkuliahan->updateDo;

        ?>

        <div class="container">
            <div class="row">
                <div class="col">
                    <form action="<?php echo $update; ?>" method="POST">
                        <div class="mb-3">
                            <h3>Nama : <?php echo $nama; ?></h3>
                        </div>
                        <div class="mb-3">
                            <h3>Matakuliah : <?php echo $nama_mk; ?></h3>
                        </div>

                        <input type="hidden" name="nim" value="<?php echo $nim; ?>">
                        <input type="hidden" name="kode_mk" value="<?php echo $kode_mk; ?>">

                        <div class="mb-3">
                            <label for="nilai" class="form-label">Nilai</label>
                            <input type="text" class="form-control" id="nilai" name="nilai" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href=<?php echo $route->main->index ?> class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
