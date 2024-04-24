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

        <h1 style="text-align: center;">Data Mahasiswa</h1>

        <br>

        <div class="container">

            <div class="row">
                <div class="col">

                    <?php
                        include '../utils/import_helper.php';

                        $route = new Route();
                    ?>

                    
                    <a href=<?php echo $route->perkuliahan->insertView ?> class="btn btn-primary">Tambah Nilai</a>
                    
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Tanggal Lahir</th>
                                <th scope="col">Kode MK</th>
                                <th scope="col">Nama MK</th>
                                <th scope="col">SKS</th>
                                <th scope="col">Nilai</th>
                                <th scope="col" colspan="2" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                                $curl = curl_init();
                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($curl, CURLOPT_URL, APIConfig::INDEX_ENDPOINT);

                                $res = curl_exec($curl);
                                $json = json_decode($res, true);

                                if ($json === null) {
                                    echo "Failed to decode JSON response.";
                                } elseif (!isset($json["data"])) {
                                    echo "API response does not include 'data' field.";
                                } else {
                                    $route = new Route();
                                
                                    foreach ($json["data"] as $baris) {
                                        $nim = $baris["nim"];
                                        $nama = $baris["nama"];
                                        $alamat = $baris["alamat"];
                                        $tanggal_lahir = $baris["tanggal_lahir"];
                                        $kode_mk = $baris["kode_mk"];
                                        $nama_mk = $baris["nama_mk"];
                                        $sks = $baris["sks"];
                                        $nilai = $baris["nilai"];

                                        $button_edit = "<a href=" . $route->perkuliahan->getUpdateViewTwoParams(PerkuliahanModel::NIM, $nim, PerkuliahanModel::KODE_MK, $kode_mk) . " class='btn btn-warning'>Edit</a>";
                                        $button_delete = "<a href=" . $route->perkuliahan->getDeleteDoTwoParams(PerkuliahanModel::NIM, $nim, PerkuliahanModel::KODE_MK, $kode_mk) . " class='btn btn-danger'>Delete</a>";

                                        $row = array(
                                            $nim, 
                                            $nama, 
                                            $alamat, 
                                            $tanggal_lahir, 
                                            $kode_mk, 
                                            $nama_mk, 
                                            $sks, 
                                            $nilai,
                                            $button_edit,
                                            $button_delete
                                        );  

                                        echo "<tr>";

                                        foreach ($row as $cell) {
                                            echo "<td>$cell</td>";
                                        }

                                        echo "<tr>";
                                    }
                                }
                
                            ?>
                        </tbody>
                    </table>
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
