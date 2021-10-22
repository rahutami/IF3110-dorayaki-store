# SPEK HALAMAN REGISTER 
Shafira
Fitur: Autentikasi + Pembelian dorayaki
Halaman: Login, Register  + pengubahan stok/pembelian dorayaki

- [x] Pengguna dapat mendaftarkan akun baru jika belum login atau sudah logout. 
- [x] Pada halaman ini, pengguna mendaftarkan diri dengan username yang unik. 
- [x] Pengguna tidak dapat mendaftar sebagai admin, karena admin ditambahkan secara manual pada basis data. 
    - Note: default -> admin nya 0

- [x] Pengecekan keunikan nilai field dilakukan menggunakan AJAX. 
    - [x] Jika unik, border field akan berwarna hijau. 
    - [x] Jika tidak unik, akan muncul pesan error pada form. 

- [x] Validasi lain yang dilakukan pada sisi klien pada halaman ini adalah:
    - [x] Email memiliki format email standar seperti “example@example.com”.
        - Note: udah pake type="email" biasa bukan pake regex
    - [x] Username hanya menerima kombinasi alphabet, angka, dan underscore.
- [x] Setelah semua nilai field sudah diisi dan valid, pengguna dapat mendaftarkan akun barunya.
    - Note: mending pake alert atau ??? 
- [x] Jika akun berhasil didaftarkan, pengguna langsung diarahkan ke Halaman Dashboard. 
- [x] Mekanisme cookie sama dengan Halaman Login.



