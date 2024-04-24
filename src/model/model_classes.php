<?php
interface ModelClasses {
    public function getEmptyData($withTimestamp = false);
    public function countAtribute($withTimestamp = false);
}

class MahasiswaModel implements ModelClasses {


    public const TABLE = "mahasiswa";
    public const NIM = "nim";
    public const NAMA = "nama";
    public const ALAMAT = "alamat";
    public const TANGGAL_LAHIR = "tanggal_lahir";

    public function getEmptyData($withTimestamp = false) {
        return ($withTimestamp) ? array(
            self::NIM => "",
            self::NAMA => "",
            self::ALAMAT => "",
            self::TANGGAL_LAHIR => date("Y-m-d")
        ) : array(
            self::NIM => "",
            self::NAMA => "",
            self::ALAMAT => "",
            self::TANGGAL_LAHIR => ""
        );
    }

    public function countAtribute($withTimestamp = false) {
        return count($this->getEmptyData($withTimestamp));
    }
}

class MatakuliahModel implements ModelClasses {
    public const TABLE = "matakuliah";
    public const KODE_MK = "kode_mk";
    public const NAMA_MK = "nama_mk";
    public const SKS = "sks";

    public function getEmptyData($withTimestamp = false) {
        return ($withTimestamp) ? array(
            self::KODE_MK => "",
            self::NAMA_MK => "",
            self::SKS => 0
        ) : array(
            self::KODE_MK => "",
            self::NAMA_MK => "",
            self::SKS => 0
        );
    }

    public function countAtribute($withTimestamp = false) {
        return count($this->getEmptyData($withTimestamp));
    }
}

class PerkuliahanModel implements ModelClasses {
    const TABLE = "perkuliahan";
    const ID_PERKULIAHAN = "id_perkuliahan";
    const NIM = "nim";
    const KODE_MK = "kode_mk";
    const NILAI = "nilai";

    public function getEmptyData($withTimestamp = false) {
        return ($withTimestamp) ? array(
            // self::ID_PERKULIAHAN => "",
            self::NIM => "",
            self::KODE_MK => "",
            self::NILAI => 0
        ) : array(
            // self::ID_PERKULIAHAN => "",
            self::NIM => "",
            self::KODE_MK => "",
            self::NILAI => 0
        );
    }

    public function countAtribute($withTimestamp = false) {
        return count($this->getEmptyData($withTimestamp));
    }
}

?>