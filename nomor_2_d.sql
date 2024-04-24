SELECT m.nim, m.nama, m.alamat, m.tanggal_lahir, mk.kode_mk, mk.nama_mk, mk.sks, p.nilai
FROM perkuliahan as p
JOIN mahasiswa as m ON p.nim = m.nim
JOIN matakuliah as mk ON p.kode_mk = mk.kode_mk;