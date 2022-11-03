<?php
    class DatabaseConnection {
        function __construct() {
            require dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
            $this->conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
            $this->conn->set_charset("utf8");

            if ($this->conn->connect_error) {
                $this->error = "No se ha podido conectar a la base de datos";
            }
        }

        public function query($sql) {
            $res = array();
            $aux = $this->conn->query($sql);
            if (gettype($aux) == "object") {
                $this->num_rows = $aux->num_rows;
                while ($rows = $aux->fetch_assoc()) {
                    array_push($res, $rows);
                }
                return $res;
            } else {
                $this->num_rows = 0;
                return $aux;
            }
        }

        public function transaction($sql) {
            $this->conn->begin_transaction();
            foreach ($sql as $item) {
                $this->conn->query($item);
            }

            if ($this->conn->commit()) {
                return true;
            } else {
                $this->conn->rollback();
                return false;
            }
        }
    }
    
?>