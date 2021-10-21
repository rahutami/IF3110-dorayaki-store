<?php
class DBConnection {
    private $db;

    public function connect() {
        if ($this->db == null) {
            $this->db = new PDO("sqlite:db/dorayakistore.db");
        }
        $this->initTables();
        return $this->db;
    }

    public function initTables(){
        $this->db->exec("CREATE TABLE IF NOT EXISTS dorayaki (
                    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                    name VARCHAR(100) NOT NULL,
                    amount INTEGER NOT NULL,
                    price INTEGER NOT NULL,
                    description TEXT NOT NULL DEFAULT 'Tidak ada deskripsi',
                    img_path VARCHAR(312) DEFAULT NULL
                    );",);
        
        $this->db->exec("CREATE TABLE IF NOT EXISTS user (
                    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                    name VARCHAR(50) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    email VARCHAR(75) NOT NULL,
                    admin SMALLINT NOT NULL DEFAULT 0
                    );");
        
        $this->db->exec("CREATE TABLE IF NOT EXISTS riwayat_perubahan (
                    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                    id_dorayaki INTEGER NOT NULL,
                    id_user INTEGER NOT NULL,
                    amount_changed INTEGER NOT NULL,
                    new_amount INTEGER NOT NULL,       
                    change_time DATETIME NOT NULL,     
                    FOREIGN KEY (id_dorayaki) REFERENCES dorayaki(id),
                    FOREIGN KEY (id_user) REFERENCES user(id)
                    );");
        
        $this->db->exec("CREATE TABLE IF NOT EXISTS riwayat_pembelian (
                    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                    id_dorayaki INTEGER NOT NULL,
                    id_user INTEGER NOT NULL,
                    amount INTEGER NOT NULL,     
                    total_price INTEGER NOT NULL,     
                    buy_time DATETIME NOT NULL, 
                    FOREIGN KEY (id_dorayaki) REFERENCES dorayaki(id),
                    FOREIGN KEY (id_user) REFERENCES user(id)
                    );");
    }
}
?>
