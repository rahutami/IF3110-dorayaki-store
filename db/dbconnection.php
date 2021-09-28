<?php
class DBConnection {
    private $db;

    public function connect() {
        if ($this->db == null) {
            $this->db = new \PDO("sqlite:db/dorayakistore.db");
        }
        $this->initTables();

        return $this->db;
    }

    public function initTables(){
        $this->db->exec("CREATE TABLE IF NOT EXISTS dorayaki (
                    id INTEGER AUTO_INCREMENT PRIMARY KEY NOT NULL,
                    name VARCHAR(100) NOT NULL,
                    amount INTEGER NOT NULL,
                    price INTEGER NOT NULL,
                    description TEXT NOT NULL DEFAULT 'Tidak ada deskripsi',
                    img_path VARCHAR(312) DEFAULT NULL
                    );",);
        
        $this->db->exec("CREATE TABLE IF NOT EXISTS user (
                    id INTEGER AUTO_INCREMENT PRIMARY KEY NOT NULL,
                    name VARCHAR(50) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    email VARCHAR(75) NOT NULL,
                    admin SMALLINT NOT NULL DEFAULT 0
                    );");
    }
}
?>