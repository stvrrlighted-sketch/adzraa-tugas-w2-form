<?php
/** @var array $hasil */
$tampilan = [
    ['user', 'Nama', e($hasil['nama'])],
    ['mail', 'Email', e($hasil['email'])],
    ['users', 'Jenis Kelamin', e($hasil['jenis_kelamin'])],
    ['pin', 'Alamat', nl2br(e($hasil['alamat']))],
    ['phone', 'Nomor Telepon', e($hasil['telepon'])],
];
?>
<div class="popup-latar" id="popup" role="dialog" aria-modal="true" aria-labelledby="popup-judul" data-durasi="<?= DURASI_POPUP_DETIK * 1000 ?>">
    <div class="popup">
        <button type="button" class="popup-tutup" data-tutup aria-label="Tutup popup"><?= ikon('silang') ?></button>
        <h2 id="popup-judul"><?= ikon('centang', 26) ?> Data berhasil dikirim</h2>
        <p class="popup-keterangan">Berikut data yang Anda masukkan.</p>
        <div>
            <?php foreach ($tampilan as [$namaIkon, $judul, $isi]): ?>
                <div class="baris">
                    <?= ikon($namaIkon) ?>
                    <div>
                        <span class="judul"><?= $judul ?></span>
                        <div class="isi"><?= $isi ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="tombol tombol-penuh" data-tutup>Tutup</button>
        <div class="popup-waktu" aria-hidden="true"><span style="animation-duration: <?= DURASI_POPUP_DETIK ?>s"></span></div>
    </div>
</div>
