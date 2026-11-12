<?php

require_once __DIR__ . '/Rekening.php';
require_once __DIR__ . '/Siswa.php';



echo "=== PENGUJIAN CLASS REKENING ===\n";

$a = new Rekening('001', 'Andi');
$b = new Rekening('002', 'Budi');

$a->setor(100000);
$b->setor(25000);

echo "Saldo awal Andi : Rp" .
    number_format($a->getSaldo(), 0, ',', '.') . "\n";

echo "Saldo awal Budi : Rp" .
    number_format($b->getSaldo(), 0, ',', '.') . "\n\n";

$hasilSetorNegatif = $a->setor(-5);
echo "Setor -5 ditolak: " .
    ($hasilSetorNegatif ? 'GAGAL' : 'BERHASIL') . "\n";

$hasilTarik = $a->tarik(200000);
echo "Tarik melebihi saldo ditolak: " .
    ($hasilTarik ? 'GAGAL' : 'BERHASIL') . "\n";

$hasilTransfer = $a->transfer($b, 30000);
echo "Transfer Rp30.000 berhasil: " .
    ($hasilTransfer ? 'YA' : 'TIDAK') . "\n";

echo "Saldo akhir Andi : Rp" .
    number_format($a->getSaldo(), 0, ',', '.') . "\n";

echo "Saldo akhir Budi : Rp" .
    number_format($b->getSaldo(), 0, ',', '.') . "\n\n";

echo "Riwayat transaksi Andi:\n";
foreach ($a->getRiwayat() as $transaksi) {
    echo "- {$transaksi['waktu']} | {$transaksi['jenis']} | Rp" .
        number_format($transaksi['jumlah'], 0, ',', '.') .
        " | {$transaksi['keterangan']}\n";
}

echo "\n=== PENGUJIAN CLASS SISWA ===\n";

$siswa = new Siswa();

$hasilNama = $siswa->setNama('  Adi  ');
echo "Set nama Adi berhasil: " .
    ($hasilNama ? 'YA' : 'TIDAK') . "\n";

$hasilNamaKosong = $siswa->setNama('   ');
echo "Nama kosong ditolak: " .
    ($hasilNamaKosong ? 'GAGAL' : 'BERHASIL') . "\n";

$hasilNilai = $siswa->setNilai(90);
echo "Set nilai 90 berhasil: " .
    ($hasilNilai ? 'YA' : 'TIDAK') . "\n";

$hasilNilai150 = $siswa->setNilai(150);
echo "Nilai 150 ditolak: " .
    ($hasilNilai150 ? 'GAGAL' : 'BERHASIL') . "\n";

echo "Nama siswa : " . $siswa->getNama() . "\n";
echo "Nilai siswa: " . $siswa->getNilai() . "\n";

echo "\n=== PENGUJIAN AKSES ILEGAL ===\n";

// Pengujian akses ilegal pertama: saldo adalah properti private.
try {
    $a->saldo = 500000;
    echo "Akses saldo tidak seharusnya berhasil.\n";
} catch (Error $e) {
    echo "Akses saldo ditolak PHP: " . $e->getMessage() . "\n";
}

// Pengujian akses ilegal kedua: nilai adalah properti private.
try {
    $siswa->nilai = 150;
    echo "Akses nilai tidak seharusnya berhasil.\n";
} catch (Error $e) {
    echo "Akses nilai ditolak PHP: " . $e->getMessage() . "\n";
}

/*
Dua contoh akses ilegal yang ditolak PHP:

1. $a->saldo = 500000;
   Error: Cannot access private property Rekening::$saldo

2. $siswa->nilai = 150;
   Error: Cannot access private property Siswa::$nilai
*/

echo "Pengujian selesai.\n";


