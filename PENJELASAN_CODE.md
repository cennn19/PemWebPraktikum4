# Penjelasan Kode Website Desa Jalatrang

Dokumen ini menjelaskan file sumber milik aplikasi, tanggung jawab tiap file, dan hubungan antarbagian. Komentar singkat di bagian atas file inti juga menjelaskan tujuan file tersebut langsung di kode.

## Gambaran alur aplikasi

1. [public/index.php](./public/index.php) menerima request dan menyerahkannya ke Laravel. Konfigurasi aplikasi dan route dimuat melalui [bootstrap/app.php](./bootstrap/app.php).
2. [routes/web.php](./routes/web.php) mengarahkan `/` ke `/berita`, lalu menghubungkan halaman daftar, detail, dan pengiriman komentar ke `BeritaController`.
3. `BeritaController@index` mengambil berita beserta kategori, menerapkan filter pencarian/kategori dari query string, lalu menampilkan daftar berpaginasi.
4. `BeritaController@show` menerima berita berdasarkan slug, mencatat satu kunjungan per berita dalam session, mengambil berita lain dan komentar, lalu menyiapkan soal captcha.
5. Blade menampilkan data: `berita/index.blade.php` untuk daftar dan `berita/show.blade.php` untuk detail, komentar, serta berita terkait. Keduanya memakai kerangka `layouts/app.blade.php`.
6. Form komentar mengirim `POST` dengan token CSRF. Controller memvalidasi input dan jawaban captcha sebelum menyimpan komentar melalui relasi Eloquent berita-komentar.
7. Migration membentuk struktur basis data; seeder menambahkan kategori dan berita contoh.

## Hubungan Routes, Controller, Model, View, dan Migration

Kelima bagian bekerja berurutan: **Route menerima URL dan memilih Controller; Controller memakai Model untuk membaca atau mengubah data; Model berinteraksi dengan tabel yang strukturnya dibuat oleh Migration; Controller mengirim hasilnya ke View untuk ditampilkan.** Saat pengunjung mengirim form, alurnya berjalan kembali dari Route menuju Controller, lalu Model menyimpan data.

### Hubungan file pada halaman daftar berita

1. **Route** — [routes/web.php](./routes/web.php) mendefinisikan `GET /berita` dan mengarahkannya ke `BeritaController@index`.
2. **Controller** — [BeritaController.php](./app/Http/Controllers/BeritaController.php) meminta berita beserta kategori, menerapkan filter, mengurutkan, dan membagi hasil menjadi beberapa halaman.
3. **Model** — [Berita.php](./app/Models/Berita.php) mengambil rekaman berita dan menyediakan scope filter; [Kategori.php](./app/Models/Kategori.php) mewakili kategori. Relasi `kategori` membuat kategori berita dapat dimuat bersama.
4. **Migration** — [migration kategori](./database/migrations/2026_10_05_022656_create_kategoris_table.php) membuat tabel kategori dan [migration berita](./database/migrations/2026_10_05_022657_create_beritas_table.php) membuat tabel berita serta foreign key `kategori_id`.
5. **View** — [index.blade.php](./resources/views/berita/index.blade.php) menerima data yang disiapkan controller, lalu menampilkan filter, kartu artikel, dan paginasi. View daftar menggunakan [layout app](./resources/views/layouts/app.blade.php) untuk kerangka bersama.

### Hubungan file pada halaman detail berita

1. **Route** — [routes/web.php](./routes/web.php) mendefinisikan `GET /berita/{berita}` dan mengarahkannya ke `BeritaController@show`.
2. **Model binding** — Parameter `{berita}` dicari oleh Laravel menggunakan model [Berita.php](./app/Models/Berita.php). Method `getRouteKeyName()` menentukan bahwa pencarian URL memakai `slug`, bukan ID.
3. **Controller** — `BeritaController@show` menambah hitungan kunjungan (maksimal sekali per berita per session), mengambil berita terkait dan komentar, serta menyiapkan angka captcha.
4. **Model dan Migration** — Model `Berita`, `Kategori`, dan `Komentar` menyediakan data dan relasi. Tabel-tabelnya dibentuk oleh migration berita, kategori, dan [migration komentar](./database/migrations/2026_10_05_030920_create_komentars_table.php). Migration komentar menetapkan foreign key `berita_id` ke berita.
5. **View** — [show.blade.php](./resources/views/berita/show.blade.php) menampilkan isi artikel, kategori, komentar, berita terkait, dan form komentar menggunakan data dari controller.

### Hubungan file saat komentar dikirim

1. **View/form** — Form pada [show.blade.php](./resources/views/berita/show.blade.php) mengirim `POST` ke route `berita.komentar` dan menyertakan token CSRF.
2. **Route** — [routes/web.php](./routes/web.php) meneruskan request ke `BeritaController@komentar`; berita pada URL tetap di-resolve menggunakan slug.
3. **Controller** — [BeritaController.php](./app/Http/Controllers/BeritaController.php) memvalidasi nama, email, nomor HP, pesan, serta jawaban captcha. Jika valid, controller meminta relasi komentar milik berita untuk membuat rekaman baru, lalu mengarahkan pengunjung kembali ke bagian komentar.
4. **Model** — [Berita.php](./app/Models/Berita.php) memiliki relasi `komentar()`, yang membuat komentar tersimpan dengan `berita_id` berita tersebut. [Komentar.php](./app/Models/Komentar.php) merepresentasikan rekaman komentar.
5. **Migration** — [migration komentar](./database/migrations/2026_10_05_030920_create_komentars_table.php) menyediakan tabel dan kolom komentar serta foreign key ke tabel berita. Saat halaman detail dimuat lagi, controller mengambil komentar melalui relasi Model dan View menampilkannya.

**Intinya:** Route menentukan *request masuk ke mana*; Controller mengatur *alur dan keputusan*; Model menjadi *representasi data serta relasi*; Migration menentukan *bentuk tabel dan constraint database*; View menentukan *bagaimana data disajikan dan bagaimana pengguna mengirim input*.

## File aplikasi dan fungsi masing-masing

### Backend, model, dan routing

| File | Penjelasan |
|---|---|
| [app/Http/Controllers/Controller.php](./app/Http/Controllers/Controller.php) | Kelas dasar controller Laravel yang dapat digunakan bersama oleh controller aplikasi. |
| [app/Http/Controllers/BeritaController.php](./app/Http/Controllers/BeritaController.php) | Pengatur alur utama berita. Menyediakan daftar/filter/paginasi, detail artikel dan hitungan view, captcha, validasi, serta penyimpanan komentar. |
| [app/Models/Berita.php](./app/Models/Berita.php) | Model tabel `berita`; menentukan kolom yang dapat diisi, konversi JSON tag dan tanggal, relasi kategori/komentar, route key berupa slug, dan scope filter pencarian. |
| [app/Models/Kategori.php](./app/Models/Kategori.php) | Model tabel `kategori` dan relasi satu-ke-banyak menuju berita. |
| [app/Models/Komentar.php](./app/Models/Komentar.php) | Model tabel `komentar` dan relasi balik menuju berita. |
| [app/Models/User.php](./app/Models/User.php) | Model autentikasi bawaan Laravel, termasuk atribut yang dapat diisi/disembunyikan, factory, notifikasi, dan cast password. Belum dipakai untuk autentikasi halaman berita. |
| [app/Providers/AppServiceProvider.php](./app/Providers/AppServiceProvider.php) | Tempat mendaftarkan atau menyiapkan layanan global aplikasi; hook `register` dan `boot` saat ini belum berisi konfigurasi khusus. |
| [routes/web.php](./routes/web.php) | Route halaman web: redirect halaman awal, daftar berita, detail berita berdasarkan slug model, dan endpoint POST komentar. |
| [routes/console.php](./routes/console.php) | Contoh pendaftaran perintah Artisan `inspire`; tidak termasuk alur halaman web. |

### Tampilan dan aset frontend

| File | Penjelasan |
|---|---|
| [resources/views/layouts/app.blade.php](./resources/views/layouts/app.blade.php) | Kerangka tampilan bersama. Mengatur HTML dasar, judul, navigasi/header/footer, bagian konten, serta gaya visual situs. |
| [resources/views/berita/index.blade.php](./resources/views/berita/index.blade.php) | Halaman daftar berita: form pencarian dan kategori, kartu berita, tag, tanggal, jumlah view, dan link paginasi/detail. |
| [resources/views/berita/show.blade.php](./resources/views/berita/show.blade.php) | Halaman artikel: metadata, isi yang di-escape sebelum ditampilkan, tag, tombol berbagi, form komentar dan captcha, daftar komentar, berita terkait, serta penghitung karakter komentar di browser. |
| [resources/views/welcome.blade.php](./resources/views/welcome.blade.php) | Halaman sambutan bawaan Laravel. Route utama saat ini mengarahkan pengunjung ke halaman berita, sehingga view ini tidak menjadi halaman utama yang aktif. |
| [resources/css/app.css](./resources/css/app.css) | Titik masuk CSS Vite. Mengimpor Tailwind dan menentukan sumber template serta font tema. Tampilan utama saat ini banyak diatur melalui kerangka Blade. |
| [resources/js/app.js](./resources/js/app.js) | Titik masuk JavaScript Vite; saat ini hanya placeholder. Penghitung karakter komentar masih ditulis langsung pada view detail. |

### Database: struktur, contoh data, dan factory

| File | Penjelasan |
|---|---|
| [database/migrations/0001_01_01_000000_create_users_table.php](./database/migrations/0001_01_01_000000_create_users_table.php) | Membuat tabel pengguna, token reset password, dan session Laravel. |
| [database/migrations/0001_01_01_000001_create_cache_table.php](./database/migrations/0001_01_01_000001_create_cache_table.php) | Membuat tabel cache dan cache lock untuk penyimpanan cache berbasis database. |
| [database/migrations/0001_01_01_000002_create_jobs_table.php](./database/migrations/0001_01_01_000002_create_jobs_table.php) | Membuat tabel antrean job, batch job, dan job gagal untuk queue berbasis database. |
| [database/migrations/2026_10_05_022656_create_kategoris_table.php](./database/migrations/2026_10_05_022656_create_kategoris_table.php) | Membuat tabel `kategori` beserta kolom nama dan timestamp. |
| [database/migrations/2026_10_05_022657_create_beritas_table.php](./database/migrations/2026_10_05_022657_create_beritas_table.php) | Membuat tabel `berita`, termasuk foreign key kategori, slug unik, isi, tag JSON, tanggal, gambar, dan jumlah view. |
| [database/migrations/2026_10_05_030920_create_komentars_table.php](./database/migrations/2026_10_05_030920_create_komentars_table.php) | Membuat tabel `komentar` dengan foreign key ke berita dan data pengirim/pesan; komentar ikut terhapus jika berita dihapus. |
| [database/seeders/DatabaseSeeder.php](./database/seeders/DatabaseSeeder.php) | Seeder utama yang menjalankan seeder kategori sebelum seeder berita agar relasi kategori tersedia. |
| [database/seeders/KategoriSeeder.php](./database/seeders/KategoriSeeder.php) | Mengisi kategori awal seperti Olahraga, Pendidikan, dan Pemerintahan. |
| [database/seeders/BeritaSeeder.php](./database/seeders/BeritaSeeder.php) | Mengisi artikel contoh dan menghubungkan tiap artikel ke kategori berdasarkan nama kategori. |
| [database/factories/UserFactory.php](./database/factories/UserFactory.php) | Membuat data pengguna sintetis untuk pengujian atau seeding, termasuk variasi email belum terverifikasi. |
| [database/database.sqlite](./database/database.sqlite) | File basis data SQLite lokal; isinya data runtime, bukan kode sumber. |
| [database/.gitignore](./database/.gitignore) | Mengatur file database lokal yang tidak perlu dimasukkan ke kontrol versi. |

### Bootstrap, konfigurasi, dan pengujian

| File | Penjelasan |
|---|---|
| [bootstrap/app.php](./bootstrap/app.php) | Menyusun aplikasi Laravel, menentukan file route web/console, endpoint health check, serta perilaku format response error. |
| [bootstrap/providers.php](./bootstrap/providers.php) | Mendaftarkan service provider aplikasi yang dimuat oleh Laravel. |
| [config/app.php](./config/app.php) | Konfigurasi umum aplikasi: nama, lingkungan, locale, timezone, key, dan provider/alias framework. |
| [config/auth.php](./config/auth.php) | Menentukan guard, provider pengguna, dan konfigurasi reset password. |
| [config/cache.php](./config/cache.php) | Menentukan driver dan pengaturan cache aplikasi. |
| [config/database.php](./config/database.php) | Menentukan koneksi database dan pengaturan migrasi. |
| [config/filesystems.php](./config/filesystems.php) | Menentukan disk penyimpanan lokal/public dan pengaturan symbolic link. |
| [config/logging.php](./config/logging.php) | Menentukan channel dan tujuan pencatatan log. |
| [config/mail.php](./config/mail.php) | Menentukan mailer dan pengaturan pengiriman email. |
| [config/queue.php](./config/queue.php) | Menentukan driver queue serta pengaturan job dan batch. |
| [config/services.php](./config/services.php) | Tempat konfigurasi kredensial/integrasi layanan pihak ketiga yang dibaca dari environment. |
| [config/session.php](./config/session.php) | Menentukan penyimpanan, durasi, cookie, dan perilaku session; session dipakai untuk captcha dan pencatatan view. |
| [tests/TestCase.php](./tests/TestCase.php) | Kelas dasar untuk test integrasi Laravel. |
| [tests/Feature/ExampleTest.php](./tests/Feature/ExampleTest.php) | Contoh feature test yang memeriksa request halaman utama menghasilkan response sukses. |
| [tests/Unit/ExampleTest.php](./tests/Unit/ExampleTest.php) | Contoh unit test sederhana bawaan untuk menunjukkan cara menjalankan PHPUnit. |
| [phpunit.xml](./phpunit.xml) | Konfigurasi PHPUnit: lokasi test, folder kode yang dianalisis, serta environment pengujian SQLite in-memory. |

### Entry point dan aset publik

| File | Penjelasan |
|---|---|
| [artisan](./artisan) | Entry point command-line Laravel untuk perintah seperti migrate, db:seed, route:list, dan test. |
| [public/index.php](./public/index.php) | Entry point HTTP publik yang mem-bootstrap aplikasi Laravel untuk setiap request web. |
| [public/.htaccess](./public/.htaccess) | Aturan Apache untuk mengarahkan request ke `index.php` dan mencegah akses langsung ke file tersembunyi. |
| [public/robots.txt](./public/robots.txt) | Petunjuk sederhana bagi crawler mesin pencari. |
| [public/foto1.jpeg](./public/foto1.jpeg), [public/foto2.jpeg](./public/foto2.jpeg) | Gambar artikel contoh yang dirujuk oleh data berita seeder. |
| [public/olahraga.jpg](./public/olahraga.jpg), [public/pendidikan.jpg](./public/pendidikan.jpg) | Aset gambar publik untuk konten situs. |
| [public/favicon.ico](./public/favicon.ico) | Ikon situs yang digunakan browser. |

### Konfigurasi proyek dan dependency

| File | Penjelasan |
|---|---|
| [composer.json](./composer.json) | Daftar dependency PHP dan perintah Composer seperti setup, development server, dan test. |
| [composer.lock](./composer.lock) | Versi pasti dependency PHP yang dipasang agar instalasi konsisten. |
| [package.json](./package.json) | Dependency frontend dan script Vite untuk development/build aset. |
| [vite.config.js](./vite.config.js) | Menghubungkan Vite dengan plugin Laravel, entry point CSS/JS, refresh browser, dan plugin Tailwind. |
| [.env.example](./.env.example) | Contoh variabel environment untuk menyiapkan konfigurasi lokal; salin sebagai `.env` lalu isi sesuai lingkungan. |
| [.env](./.env) | Konfigurasi environment lokal yang dapat berisi rahasia; jangan dibagikan atau dimasukkan ke dokumentasi publik. |
| [.editorconfig](./.editorconfig) | Menyamakan aturan dasar format file antar editor. |
| [.gitattributes](./.gitattributes) | Aturan atribut file untuk Git, termasuk normalisasi teks/line ending. |
| [.gitignore](./.gitignore) | Daftar file lokal, hasil build, cache, dan data sensitif yang diabaikan Git. |
| [.npmrc](./.npmrc) | Pengaturan perilaku npm untuk proyek. |
| [README.md](./README.md) | README template Laravel yang menjelaskan framework, dokumentasi Laravel, dan panduan kontribusi umum. |

Folder `vendor/`, cache bootstrap, hasil build, dan file di `storage/` merupakan dependency atau keluaran runtime yang dikelola framework, bukan kode fitur berita yang perlu dijelaskan satu per satu.

## Perintah yang sering digunakan

```bash
# Menjalankan aplikasi secara lokal melalui script development
composer run dev

# Menjalankan migrasi database
php artisan migrate

# Mengisi kategori dan berita contoh
php artisan db:seed

# Melihat route aplikasi
php artisan route:list

# Menjalankan test
composer test

# Membuat build aset frontend
npm run build
```
