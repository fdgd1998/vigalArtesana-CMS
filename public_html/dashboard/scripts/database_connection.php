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
            if ($aux = $this->conn->query($sql)) {
                $this->num_rows = $aux->num_rows;
                while ($rows = $aux->fetch_assoc()) {
                    array_push($res, $rows);
                }
            }
            return $res;
        }
    }
    // function openConnection() {
    //     require dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    //     $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
    //     $conn->set_charset("utf8");

    //     if ($conn->connect_error) {
    //         print("No se ha podido conectar a la base de datos");
    //         exit();
    //     } else {
    //         return $conn;
    //     }
    // }
    
?>