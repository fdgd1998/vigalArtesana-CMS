<?php
    class DatabaseConnection {
        function __construct() {
            require dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
            // $this->conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
            try {
                $this->conn = new PDO($DSN, $DB_user, $DB_pass);
                // $this->conn->set_charset("utf8");
            } catch (PDOException $e) {
                header("Location: /errorpages/500.php");
                exit();
            }
        }

        public function query($sql) {
            $res = array();
            $aux = $this->conn->query($sql);
            if (gettype($aux) == "object") {
                $this->num_rows = $aux->rowCount();
                while ($rows = $aux->fetch(PDO::FETCH_ASSOC)) {
                    array_push($res, $rows);
                }
                return $res;
            } else {
                $this->num_rows = 0;
                return $aux;
            }
        }

        public function exec($sql) {
            return $this->conn->exec($sql);
        }

        public function transaction($sql) {
            $this->conn->beginTransaction();
            foreach ($sql as $item) {
                $this->conn->exec($item);
            }

            if ($this->conn->commit()) {
                return true;
            } else {
                $this->conn->rollBack();
                return false;
            }
        }

        public function preparedQuery($sql, $params) {
            $sth = $this->conn->prepare($sql);
            $sth->execute($params);
            return $sth->fetchAll();
        }
    }
    
?>