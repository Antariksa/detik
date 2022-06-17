Hai ! Terimakasih sudah mau review code ini. 


# Setup
1. Buka file app/Model.php 
2. Ganti setiap parameter host, dbname, username, passport sesuai environtment

# Install 
php console.php init migrate

keterangan :
1. harus terinstall mysqlnya di commandline, 
2. kalau point 1 gak bisa execute manual sql di folder "migrate/init.sql"

# CONSOLE 
php console.php ticket generate 2 1000

keterangan :
2 => event_id 
1000 => totalnya

# API 
Running : 
1. install webserver seperti biasa
2. atau cukup php -S localhost:8000 (yang penting PDO udah terinstall)
3. lansung coba pakai postman / semacamnya

List apinya : 
1. {url}
2. {url}/ticket/check
2. {url}/ticket/update

keterangan : 
1. cek postman ya buat parameternya file di "/postman_collection.json"
2. kurang lebih parameter sama kaya yang direquest

# Folder Structure :
Struktur folder nya saya niru konsep laravel. harusnya mirip-mirip

- app => disini Code Base, kode respon distandarkan dari sini semua
    - Autload.php
    - Controller.php
    - Model.php
    - Request.php 
    - Route.php 
- console => tempat seperti controller cuma buat console 
    - Init.php 
    - Ticket.php 
- controllers => controller ditaruh disini semua, nanti daftarin di routes
    - TicketController.php
- migrate => tempate migrate sql file
    - init.sql 
- models => tempat model database dan queryan berdasarkan table/model
    - Event.php
    - Ticket.php
- routes => tempat bikin routes dari controllers (khusus api)
    - api.php
- console.php => console running dari sini
- index.php => api buka running dari sini




# Kekurangan : 
1. Saya belum sempat buat login / access token
2. Migrate belum dicek dan harusnya gak perlu harus ada mysql di commandline 
3. Saya baru lanjutin malem ini jadi maximal yang saya bisa buat seperti ini
4. Kalau return message/tulisan banyak yg tidak formal mohon di maklum, udah kurang fokus bikinnya :D 


Terimakasih
Hormat saya, 
Salam
Andre Antariksa
