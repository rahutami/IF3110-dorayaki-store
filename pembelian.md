# Pembelian

## Fitur Pembelian Dorayaki
Sama seperti admin, user dapat:
- [] Mengurangi stok varian dorayaki.
- [] Ketika akan melakukan pembelian, stok perlu diperbarui secara **real-time** menggunakan AJAX.
Perbedaannya dengan admin:
- [] User hanya dapat mengurangi stok, admin dapat menambah.
- [] Pada user, perlu ditampilkan total biaya yang harus dibayarkan, sedangkan pada admin tidak.

## Halaman Pengubahan Stok / Pembelian Dorayaki
- [x] Pada halaman ini pengguna dapat memilih jumlah pengubahan stok / pembelian varian dorayaki
- [x] Pengguna tidak dapat melakukan pengurangan stok / pembelian varian dorayaki melebihi banyak varian dorayaki yang tersedia.
- [x] Jika pengguna login sebagai user, perubahan total harga ditampilkan secara **real-time** sesuai dengan perubahan jumlah pembelian varian dorayaki. 
- [] Sedangkan, jika sebagai admin tidak perlu menampilkan total harga.
- [x] Pastikan setelah proses pengubahan stok, ketersediaan varian dorayaki berubah sesuai yang diinginkan.
