-------------------------cara buat role baru-------------------------------
pastikan di database, tabel login, kolom role, ada username dengan role yang baru
masuk controller/content/
copy folder default
rename ke nama role
buka isi folder nya
buka page.php
isi array dengan nama nama page yang mau diisi
save
masuk ke view/main/require/navbar
copy folder default
rename ke nama role
buka isi folder nya
navbar.php merupakan pengaturan lebih lanjut mengenai state navbar dan isi navbarnya
home merupakan halaman home, dan content merupakan halmaan selain halaman home, pengaturan lebih lanjut, coba sendiri
############
masuk ke folder view/main/role
copy folder default
rename folder default ke nama role
terdapat home.php yang merupakan halaman homepage
---------------------------------------------------------------------------

-------------------------cara buat halaman baru----------------------------
masuk ke view/main/role
tentukan role mana yang ingin ditambahkan halamannya
buat file baru dengan format seperti yang terdapat di view/main/default/deafult.php
masuk ke controller/content/
masuk ke role yang ingin anda tambahkan halamannya
buka page.php
tambahkan array
save
halaman anda terdapat pada index.php?p=~~~~
---------------------------------------------------------------------------

-------------------------cara mengganti nama title navbar----------------------
masuk ke folder view/main/role
tentukan role apa yang ingin diganti
buka file php yang ingin diganti 
ganti title navbar nya di $navbar_1
save

##########NOTE############
PADA VARIABEL $state_navbar menunjukkan pada halaman apa navbar tersebut ditampilkan
pada setiap halaman terdapat 2 jenis default, yaitu:
-home -> untuk halaman home
-content -> untuk setiap halaman selain home dan lainnya
anda juga dapat menambahkan jenis title navbar, yaitu di bagian view/main/require/navbar/
copy folder default yang berada di folder default
kembali ke view/main/require/navbar/ pilih role nya 
paste
rename folder menjadi nama navbar yang akan di deklarasi
buka navbar.php yang didalamnya untuk lebih custom

##########################
-------------------------------------------------------------------------