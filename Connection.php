<?php

	class Connection {

		const SERVER = "185.201.11.170";
		const USER = "u775772700_used_clothing";
		const PASSWORD = "used2Clothing";
		const DATABASE = "u775772700_used_clothing";

		private $_mysqli;

        function __construct() {
            date_default_timezone_set('America/Mexico_City');
            setlocale(LC_MONETARY, 'en_ES');

            $this->_mysqli = new mysqli(self::SERVER, self::USER,
                    self::PASSWORD, self::DATABASE);
			if ($this->_mysqli->connect_errno) {
				echo 'Conexión Fallida : ' . $this->_mysqli->connect_error;
				exit();
			}
		}

        public function __destruct() {
            $this->_mysqli->close();
		}
		
		public function select(string $query): ?mysqli_result {
			return $this->sentence($query);
		}

		public function insert(string $query): bool {
			return $this->sentence($query);
		}

		public function delete(string $query): bool {
			return $this->sentence($query);
		}

		public function update(string $query): bool {
			return $this->sentence($query);
		}

        private function sentence(string $query) {
			return $this->_mysqli->query($query);
        }
	}