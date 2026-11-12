<?php

class Rekening
{
    private string $nomor;
    private string $pemilik;
    private float $saldo = 0.0;
    private array $riwayat = [];

    public function __construct(string $nomor, string $pemilik)
    {
        $this->nomor = $nomor;
        $this->pemilik = $pemilik;
    }

    private function catatRiwayat(
        string $jenis,
        float $jumlah,
        string $keterangan
    ): void {
        $this->riwayat[] = [
            'waktu' => date('Y-m-d H:i:s'),
            'jenis' => $jenis,
            'jumlah' => $jumlah,
            'keterangan' => $keterangan
        ];
    }

    public function setor(float $jumlah): bool
    {
        if ($jumlah <= 0) {
            return false;
        }

        $this->saldo += $jumlah;
        $this->catatRiwayat('setor', $jumlah, 'Setoran uang');
        return true;
    }

    public function tarik(float $jumlah): bool
    {
        if ($jumlah <= 0 || $jumlah > $this->saldo) {
            return false;
        }

        $this->saldo -= $jumlah;
        $this->catatRiwayat('tarik', $jumlah, 'Penarikan uang');
        return true;
    }

    public function transfer(Rekening $tujuan, float $jumlah): bool
    {
        if ($jumlah <= 0 || $jumlah > $this->saldo || $tujuan === $this) {
            return false;
        }

        $this->saldo -= $jumlah;
        $tujuan->saldo += $jumlah;

        $this->catatRiwayat(
            'transfer keluar',
            $jumlah,
            'Transfer ke ' . $tujuan->getPemilik()
        );

        $tujuan->catatRiwayat(
            'transfer masuk',
            $jumlah,
            'Transfer dari ' . $this->getPemilik()
        );

        return true;
    }

    public function getSaldo(): float
    {
        return $this->saldo;
    }

    public function getRiwayat(): array
    {
        return $this->riwayat;
    }

    public function getNomor(): string
    {
        return $this->nomor;
    }

    public function getPemilik(): string
    {
        return $this->pemilik;
    }
}
