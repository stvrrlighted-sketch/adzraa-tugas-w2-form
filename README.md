# Studi Kasus 2: Formulir Data Pengguna (PHP)

Halaman web PHP dengan form input data pengguna. Setelah tombol **Submit** ditekan, data dikirim dengan method **POST**, divalidasi dan diproses oleh PHP, lalu ditampilkan kembali dalam **popup** yang menutup otomatis setelah 10 detik jika tidak ditutup.

## Struktur Proyek

```
.
├── index.php                  File utama: alur POST dan tampilan form
├── assets/
│   ├── css/style.css          Seluruh gaya tampilan
│   └── js/popup.js            Perilaku popup (tutup otomatis, tombol tutup, Esc)
├── includes/
│   ├── konfigurasi.php        Konstanta: pilihan jenis kelamin, daftar kolom, durasi popup
│   ├── ikon.php               Fungsi ikon() berisi ikon SVG inline
│   ├── helper.php             Fungsi bantu tampilan: e(), tandaWajib(), pesanError(), atributError()
│   ├── validasi.php           bersihkanInput() dan validasiForm()
│   └── popup.php              Markup popup "Data berhasil dikirim"
└── README.md
```

Jaga susunan folder ini tetap utuh saat dipindahkan, karena `index.php` memanggil file lain dengan jalur relatif.

## Cara Menjalankan

**Opsi 1: XAMPP / Laragon**
1. Salin seluruh folder proyek ke `htdocs` (XAMPP) atau `www` (Laragon), misalnya `htdocs/studi-kasus-2/`.
2. Jalankan Apache.
3. Buka `http://localhost/studi-kasus-2/index.php`.

**Opsi 2: Server bawaan PHP**
```bash
php -S localhost:8000
```
Jalankan perintah di folder yang berisi `index.php`, lalu buka `http://localhost:8000`.

Kebutuhan: PHP 8.0 atau lebih baru dengan ekstensi `mbstring` aktif (aktif secara bawaan di XAMPP).

## Field pada Form

Semua field wajib diisi dan ditandai dengan `*` merah pada labelnya.

| Field | Jenis input | Aturan validasi |
|-------|-------------|-----------------|
| Nama | `text` | 3 sampai 60 karakter, hanya huruf, spasi, titik, apostrof, dan tanda hubung |
| Email | `email` | Format email valid, maksimal 100 karakter |
| Jenis Kelamin | `radio` | Pilih salah satu: Laki-laki, Perempuan, atau Prefer not to say |
| Alamat | `textarea` | 10 sampai 255 karakter |
| Nomor Telepon | `tel` | Diawali `0`, `62`, atau `+62`, diikuti 8 sampai 12 angka (spasi dan tanda hubung diabaikan) |

## Alur Kerja

1. Halaman dibuka dengan method GET, form tampil kosong.
2. Pengguna mengisi form lalu menekan **Submit**, data dikirim ke `index.php` dengan method POST.
3. `bersihkanInput()` mengambil data dari `$_POST` dan merapikan spasi berlebih, lalu `validasiForm()` memeriksa setiap field.
4. Jika ada yang tidak valid, pesan error muncul di bawah field terkait dan isian yang sudah diketik tetap dipertahankan.
5. Jika semua valid, form dikosongkan dan popup **Data berhasil dikirim** tampil berisi data yang dimasukkan.
6. Tombol **Kosongkan form** memuat ulang `index.php` dengan form kosong.

## Perilaku Popup

- Menutup otomatis setelah **10 detik**. Batang pink di bagian bawah popup menunjukkan sisa waktu.
- Dapat ditutup lebih awal dengan tombol silang, tombol **Tutup**, tombol `Esc`, atau klik di luar popup.
- Fokus keyboard dikunci di dalam popup selama popup terbuka.
- Durasi dapat diubah lewat konstanta `DURASI_POPUP_DETIK` di `includes/konfigurasi.php`.
- Tanpa JavaScript, popup tetap tampil dan tidak menutup otomatis.

## Keamanan

- Semua nilai dari pengguna ditampilkan melalui `htmlspecialchars` (`ENT_QUOTES`, UTF-8) untuk mencegah XSS.
- Validasi dilakukan di sisi server. Atribut HTML seperti `required` dan `maxlength` hanya pelengkap kenyamanan, bukan pengaman.
- Nilai jenis kelamin dicocokkan dengan daftar yang diizinkan (`in_array` mode ketat).
- Input yang bukan teks (misalnya array pada `$_POST`) diabaikan.

## Desain Tampilan (UI/UX)

- Latar halaman putih, ikon berwarna `#ffb6c1`, dan tombol Submit berwarna pink.
- Teks pada tombol memakai warna gelap (`#4a1d29`) agar kontrasnya terbaca di atas warna pink muda.
- Tanda `*` memakai warna merah (`#b3261e`) agar jelas terlihat, karena pink terlalu pucat di atas putih.
- Cincin fokus keyboard memakai pink tua (`#d6536f`) agar terlihat jelas.
- Responsif: tombol memenuhi lebar layar pada ponsel.
- Animasi masuk popup dimatikan bagi pengguna yang mengaktifkan pengaturan kurangi gerakan (`prefers-reduced-motion`).
- Ikon diambil dari pustaka open-source [Lucide](https://lucide.dev) (lisensi ISC), lalu ditanam sebagai SVG inline sehingga halaman tidak memerlukan koneksi internet.

## Batasan

- Data tidak disimpan ke database (sesuai soal), hanya ditampilkan ulang. Jika halaman dimuat ulang (refresh) setelah submit, browser akan menawarkan pengiriman ulang form.
- Pada lingkungan pembuatan file ini PHP dan browser tidak tersedia, sehingga kode belum dijalankan langsung. Sebelum dikumpulkan, jalankan `php -l index.php` (dan untuk setiap file di `includes/`) untuk memeriksa sintaks, lalu coba semua skenario di bawah.

## Skenario Uji yang Disarankan

1. Kirim form kosong, semua field harus menampilkan pesan error.
2. Isi email tanpa tanda `@`, harus muncul pesan format email.
3. Isi nomor telepon berisi huruf, harus ditolak.
4. Isi semua field dengan benar, popup harus tampil berisi data dan menutup sendiri setelah 10 detik.
5. Tutup popup dengan tombol silang, tombol Tutup, `Esc`, dan klik di luar popup.
6. Isi nama dengan `<script>alert(1)</script>`, harus ditolak oleh validasi, dan jika masuk ke bidang lain (misalnya alamat) tetap tampil sebagai teks biasa di popup.
