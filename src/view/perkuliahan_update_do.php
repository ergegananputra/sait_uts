<?php

include '../utils/import_helper.php';
$route = new Route();

if(isset($_POST['submit'])) {
    $nim = $_POST['nim'];
    $kode_mk = $_POST['kode_mk'];
    $nilai = $_POST['nilai'];

    $data = array(
        'nim' => $nim,
        'kode_mk' => $kode_mk,
        'nilai' => $nilai
    );

    $url = APIConfig::PERKULIAHAN_ENDPOINT . "?nim=" . $nim . "&kode_mk=" . $kode_mk;


    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);


    $res = curl_exec($curl);

    if ($res === false) {
        echo "API request failed: " . curl_error($curl);
    } else {
        $json = json_decode($res, true);
        curl_close($curl);

        if ($json !== null && isset($json["status"]) && $json["status"] == 1) {
            header("Location: main_index.php");
        } else {
            echo "Failed to update data.";
        }
    }


    
} else {
    echo "No data submitted.";
}

?>