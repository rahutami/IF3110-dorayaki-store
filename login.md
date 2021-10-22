# SPEK HALAMAN LOGIN 

- [x] Halaman pertama yang ditampilkan jika pengguna belum login atau sudah logout adalah halaman Login. 
- [x] Pengguna dapat melakukan login sebagai user atau admin. 
- [x] Lakukan enkripsi pada password pengguna, algoritma yang digunakan dibebaskan.

- [x] Identitas pengguna yang sudah login akan disimpan sebagai cookie dalam browser. 
- [x] Cookie menyimpan data pengguna dalam bentuk string dengan panjang tertentu. 
- [x] Untuk mengetahui pengguna mana yang sedang login, string tersebut dapat dilihat di basis data. 
- [x] Identitas tersebut tidak boleh disimpan sebagai parameter HTTP GET.

- [] Jika cookie ini tidak ada, maka pengguna dianggap belum login dan aplikasi akan selalu mengarahkan (redirect) pengguna ke halaman ini, meskipun pengguna membuka halaman yang lain. Masa berlaku cookie dibebaskan.

- [] Tiap user punya identitas gitu, di database, random aja
