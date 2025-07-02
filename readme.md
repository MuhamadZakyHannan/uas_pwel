# 📚 Bukoo - Aplikasi Web Manajemen & Distribusi eBook

**Selamat datang di Bukoo**, sebuah aplikasi web yang dirancang untuk manajemen dan distribusi eBook. Proyek ini dibangun sebagai bagian dari Ujian Akhir Semester (UAS) mata kuliah *Pemrograman Web Lanjut*.



## ✨ Fitur Utama

- **Autentikasi Pengguna**  
  Sistem login & registrasi dengan dua peran: `Admin` dan `Member`.

- **Manajemen eBook**  
  Admin dapat menambahkan, mengedit, dan menghapus koleksi eBook.

- **Koleksi Buku Digital**  
  Semua pengguna dapat menjelajahi dan membaca detail eBook yang tersedia.

- **Pencarian Live (AJAX)**  
  Fitur pencarian dinamis langsung di navbar.

- **Halaman Detail Buku**  
  Setiap eBook memiliki halaman detail khusus.

- **Pembayaran Midtrans (Simulasi via Video Demo)**  
  Fitur pembayaran Midtrans disimulasikan dalam video presentasi karena alasan keamanan kunci API.

---

## 👥 Perbedaan Peran Pengguna

### 🔐 Admin
- **Login:**  
  Username: `admin`  
  Password: `admin12345`

- **Hak Akses:**
  - Tambah eBook baru.
  - Edit eBook yang sudah ada.
  - Hapus eBook.
  - Melihat tombol “Update” dan “Hapus” di halaman koleksi.

### 👤 Member (Pengguna Biasa)
- **Login:**  
  Dapat membuat akun sendiri melalui form registrasi.

- **Hak Akses:**
  - Melihat koleksi buku dan detailnya.
  - Tidak bisa menambah, mengedit, atau menghapus eBook.

---

## 🛒 Alur Belanja & Pembayaran

### 1. **Beli Sekarang (Satu Buku)**
- Pilih buku berbayar dari halaman Koleksi.
- Klik tombol **"Beli (Rp ...)"**.
- Klik **Lanjutkan ke Pembayaran**.
- Anda akan diarahkan ke halaman pembayaran Midtrans.
- Ikuti instruksi untuk menyelesaikan transaksi.


### 2. **Keranjang Belanja (Checkout Banyak Item)**
- Masuk ke halaman detail buku dan klik **Tambah ke Keranjang**.
- Ulangi untuk buku lainnya.
- Klik ikon 🛒 (keranjang) di navbar kanan atas.
- Cek isi keranjang dan sesuaikan kuantitas/hapus item.
- Klik **Bayar Sekarang**.

---

## 🛠️ Tutorial Instalasi & Menjalankan Aplikasi

### 🔧 Prasyarat
- [XAMPP](https://www.apachefriends.org/): Web server (Apache) & Database (MySQL/MariaDB).

### 🧩 Langkah-langkah Instalasi

1. **Ekstrak & Pindahkan Proyek**
   - Ekstrak file `.zip` proyek.
   - Pindahkan folder (misal `uas_pwl-main`) ke direktori `htdocs` XAMPP Anda.  
     Contoh: `C:\xampp\htdocs\uas_pwl-main`

2. **Aktifkan XAMPP**
   - Jalankan `XAMPP Control Panel`.
   - Klik “Start” untuk service `Apache` dan `MySQL`.

3. **Impor Database**
   - Buka browser dan akses: `http://localhost/phpmyadmin/`
   - Klik **New** untuk membuat database baru:  
     Nama: `ebookapps` → klik **Create**
   - Masuk ke database `ebookapps`, klik tab **Import**.
   - Pilih file `.sql` dari folder proyek, lalu klik **Go**.
   - Tunggu hingga proses impor selesai.

4. **Jalankan Aplikasi**
   - Buka browser dan akses:  
     `http://localhost/uas_pwl-main/`(contoh)
   - Coba login sebagai admin atau registrasi sebagai member baru.

---

## ⚠️ Catatan tentang Integrasi Midtrans

Fitur pembayaran Midtrans **tidak aktif secara langsung** dalam proyek ini karena alasan keamanan:

- Midtrans membutuhkan `Client Key` dan `Server Key` yang bersifat **rahasia**.
- Untuk keamanan, bagian kode terkait Midtrans telah dinonaktifkan.
- Namun, seluruh proses checkout dan pembayaran telah **didemokan dalam video presentasi proyek**.

---

## 📂 Struktur Folder Penting

