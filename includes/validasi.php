<?php
declare(strict_types=1);

function bersihkanInput(array $kiriman): array
{
    $nilai = [];
    foreach (KOLOM as $kolom) {
        $nilai[$kolom] = is_string($kiriman[$kolom] ?? null) ? $kiriman[$kolom] : '';
    }

    foreach (['nama', 'email', 'telepon'] as $kolom) {
        $nilai[$kolom] = trim((string) preg_replace('/\s+/u', ' ', $nilai[$kolom]));
    }
    $nilai['alamat'] = trim(str_replace("\r\n", "\n", $nilai['alamat']));

    return $nilai;
}

function validasiForm(array $nilai): array
{
    $error = [];

    if ($nilai['nama'] === '') {
        $error['nama'] = 'Nama wajib diisi.';
    } elseif (mb_strlen($nilai['nama']) < 3) {
        $error['nama'] = 'Nama minimal 3 karakter.';
    } elseif (mb_strlen($nilai['nama']) > 60) {
        $error['nama'] = 'Nama maksimal 60 karakter.';
    } elseif (!preg_match('/^[\p{L}\s.\'-]+$/u', $nilai['nama'])) {
        $error['nama'] = 'Nama hanya boleh berisi huruf, spasi, titik, apostrof, dan tanda hubung.';
    }

    if ($nilai['email'] === '') {
        $error['email'] = 'Email wajib diisi.';
    } elseif (mb_strlen($nilai['email']) > 100 || !filter_var($nilai['email'], FILTER_VALIDATE_EMAIL)) {
        $error['email'] = 'Format email tidak valid. Contoh: nama@email.com';
    }

    if (!in_array($nilai['jenis_kelamin'], OPSI_JENIS_KELAMIN, true)) {
        $error['jenis_kelamin'] = 'Pilih salah satu jenis kelamin.';
    }

    if ($nilai['alamat'] === '') {
        $error['alamat'] = 'Alamat wajib diisi.';
    } elseif (mb_strlen($nilai['alamat']) < 10) {
        $error['alamat'] = 'Alamat minimal 10 karakter.';
    } elseif (mb_strlen($nilai['alamat']) > 255) {
        $error['alamat'] = 'Alamat maksimal 255 karakter.';
    }

    $teleponBersih = (string) preg_replace('/[\s-]/', '', $nilai['telepon']);
    if ($nilai['telepon'] === '') {
        $error['telepon'] = 'Nomor telepon wajib diisi.';
    } elseif (!preg_match('/^(\+62|62|0)[0-9]{8,12}$/', $teleponBersih)) {
        $error['telepon'] = 'Nomor telepon tidak valid. Contoh: 081234567890';
    }

    return $error;
}
