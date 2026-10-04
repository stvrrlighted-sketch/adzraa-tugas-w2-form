<?php
declare(strict_types=1);

require __DIR__ . '/includes/konfigurasi.php';
require __DIR__ . '/includes/ikon.php';
require __DIR__ . '/includes/helper.php';
require __DIR__ . '/includes/validasi.php';

$nilai = array_fill_keys(KOLOM, '');
$error = [];
$hasil = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nilai = bersihkanInput($_POST);
    $error = validasiForm($nilai);

    if (!$error) {
        $hasil = $nilai;
        $nilai = array_fill_keys(KOLOM, '');
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulir Data Pengguna</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/popup.js" defer></script>
</head>
<body>
<main>
    <header>
        <span class="lencana"><?= ikon('clipboard', 28) ?></span>
        <div>
            <h1>Formulir Data Pengguna</h1>
            <p>Kolom bertanda <span class="wajib" aria-hidden="true">*</span> wajib diisi. Tekan Submit setelah selesai.</p>
        </div>
    </header>

    <form method="post" action="index.php" novalidate>
        <div class="kolom">
            <label for="nama"><?= ikon('user') ?> <span>Nama<?= tandaWajib() ?></span></label>
            <input type="text" id="nama" name="nama" maxlength="60" autocomplete="name" placeholder="Nama lengkap Anda" value="<?= e($nilai['nama']) ?>" required<?= atributError($error, 'nama') ?>>
            <?= pesanError($error, 'nama') ?>
        </div>

        <div class="kolom">
            <label for="email"><?= ikon('mail') ?> <span>Email<?= tandaWajib() ?></span></label>
            <input type="email" id="email" name="email" maxlength="100" autocomplete="email" placeholder="nama@email.com" value="<?= e($nilai['email']) ?>" required<?= atributError($error, 'email') ?>>
            <?= pesanError($error, 'email') ?>
        </div>

        <fieldset class="kolom">
            <legend><?= ikon('users') ?> <span>Jenis Kelamin<?= tandaWajib() ?></span></legend>
            <div class="pilihan">
                <?php foreach (OPSI_JENIS_KELAMIN as $indeks => $opsi): ?>
                    <label>
                        <input type="radio" name="jenis_kelamin" value="<?= e($opsi) ?>"<?= $nilai['jenis_kelamin'] === $opsi ? ' checked' : '' ?><?= $indeks === 0 ? ' required' : '' ?><?= atributError($error, 'jenis_kelamin') ?>>
                        <span><?= e($opsi) ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
            <?= pesanError($error, 'jenis_kelamin') ?>
        </fieldset>

        <div class="kolom">
            <label for="alamat"><?= ikon('pin') ?> <span>Alamat<?= tandaWajib() ?></span></label>
            <textarea id="alamat" name="alamat" maxlength="255" autocomplete="street-address" placeholder="Jalan, nomor, kelurahan, kota" required<?= atributError($error, 'alamat') ?>><?= e($nilai['alamat']) ?></textarea>
            <?= pesanError($error, 'alamat') ?>
        </div>

        <div class="kolom">
            <label for="telepon"><?= ikon('phone') ?> <span>Nomor Telepon<?= tandaWajib() ?></span></label>
            <input type="tel" id="telepon" name="telepon" maxlength="20" inputmode="tel" autocomplete="tel" placeholder="08XX-XXXX-XXXX" value="<?= e($nilai['telepon']) ?>" required<?= atributError($error, 'telepon') ?>>
            <?= pesanError($error, 'telepon') ?>
        </div>

        <div class="aksi">
            <button type="submit" class="tombol"><?= ikon('kirim') ?> Submit</button>
            <a class="tombol tombol-sekunder" href="index.php"><?= ikon('ulang') ?> Kosongkan form</a>
        </div>
    </form>
</main>

<?php if ($hasil): ?>
    <?php require __DIR__ . '/includes/popup.php'; ?>
<?php endif; ?>
</body>
</html>
