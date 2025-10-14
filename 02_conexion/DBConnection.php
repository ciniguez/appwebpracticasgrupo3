<?php
/**
 * DBConnection - Simple mysqli wrapper for connecting and performing CRUD with prepared statements.
 *
 * Usage:
 *   $db = new DBConnection('localhost', 'root', '', 'mundo');
 *   $rows = $db->fetchAll('SELECT * FROM CONTINENTE WHERE CONT_ID > ?', [1]);
 */
class DBConnection {
    /** @var mysqli */
    private $mysqli;

    public function __construct(){
        $host = 'localhost';
        $user = 'root'; 
        $pass = '';
        $db = 'mundo'; 
        $port = 3306;
        $charset = 'utf8mb4'; 
        $this->mysqli = new mysqli($host, $user, $pass, $db, $port);
        if ($this->mysqli->connect_errno) {
            throw new RuntimeException("MySQL connection error ({$this->mysqli->connect_errno}): {$this->mysqli->connect_error}");
        }
        if (!$this->mysqli->set_charset($charset)) {
            throw new RuntimeException('Error setting charset: ' . $this->mysqli->error);
        }
    }

    /** Run a raw query (no prepared statement). Throws on error. */
    public function query(string $sql){
        $res = $this->mysqli->query($sql);
        if ($res === false) {
            throw new RuntimeException('Query error: ' . $this->mysqli->error);
        }
        return $res;
    }

    /** Build mysqli bind types from PHP values. */
    private function buildTypes(array $params): string {
        $types = '';
        foreach ($params as $p) {
            if (is_int($p)) $types .= 'i';
            elseif (is_float($p) || is_double($p)) $types .= 'd';
            else $types .= 's';
        }
        return $types;
    }

    /** Bind params to statement (using references as required by bind_param). */
    private function stmtBindParams(mysqli_stmt $stmt, array $params){
        if (empty($params)) return;
        $types = $this->buildTypes($params);
        // mysqli::bind_param requires parameters by reference
        $refs = [];
        $refs[] = & $types;
        foreach ($params as $key => $value) {
            $refs[] = & $params[$key];
        }
        call_user_func_array([$stmt, 'bind_param'], $refs);
    }

    /** Execute a prepared SELECT and return all rows as associative arrays. */
    public function fetchAll(string $sql, array $params = []): array {
        $stmt = $this->mysqli->prepare($sql);
        if ($stmt === false) throw new RuntimeException('Prepare failed: ' . $this->mysqli->error);
        $this->stmtBindParams($stmt, $params);
        if (!$stmt->execute()) {
            $err = $stmt->error;
            $stmt->close();
            throw new RuntimeException('Execute failed: ' . $err);
        }
        $result = $stmt->get_result();
        if ($result === false) {
            $stmt->close();
            return [];
        }
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }

    /** Execute a prepared SELECT and return the first row or null. */
    public function fetchOne(string $sql, array $params = []){
        $rows = $this->fetchAll($sql, $params);
        return count($rows) ? $rows[0] : null;
    }

    /** Execute INSERT/UPDATE/DELETE prepared statement. Returns array with affected_rows and insert_id. */
    public function execute(string $sql, array $params = []): array {
        $stmt = $this->mysqli->prepare($sql);
        if ($stmt === false) throw new RuntimeException('Prepare failed: ' . $this->mysqli->error);
        $this->stmtBindParams($stmt, $params);
        if (!$stmt->execute()) {
            $err = $stmt->error;
            $stmt->close();
            throw new RuntimeException('Execute failed: ' . $err);
        }
        $affected = $stmt->affected_rows;
        // insert id comes from mysqli object
        $insertId = $this->mysqli->insert_id;
        $stmt->close();
        return ['affected_rows' => $affected, 'insert_id' => $insertId];
    }

    /** Convenience insert - $data is assoc array column => value. Returns insert id. */
    public function insert(string $table, array $data){
        if (empty($data)) throw new InvalidArgumentException('No data provided for insert');
        $cols = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO `$table` ($cols) VALUES ($placeholders)";
        $params = array_values($data);
        $res = $this->execute($sql, $params);
        return $res['insert_id'];
    }

    /** Convenience update - $data assoc, $where is SQL fragment with ? placeholders, $whereParams are values for the WHERE. Returns affected rows. */
    public function update(string $table, array $data, string $where, array $whereParams = []){
        if (empty($data)) throw new InvalidArgumentException('No data provided for update');
        $sets = [];
        foreach (array_keys($data) as $col) $sets[] = "$col = ?";
        $sql = "UPDATE `$table` SET " . implode(', ', $sets) . " WHERE " . $where;
        $params = array_merge(array_values($data), $whereParams);
        $res = $this->execute($sql, $params);
        return $res['affected_rows'];
    }

    /** Convenience delete - $where is SQL fragment with ? placeholders. Returns affected rows. */
    public function delete(string $table, string $where, array $whereParams = []){
        $sql = "DELETE FROM `$table` WHERE " . $where;
        $res = $this->execute($sql, $whereParams);
        return $res['affected_rows'];
    }

    public function beginTransaction(){ $this->mysqli->begin_transaction(); }
    public function commit(){ $this->mysqli->commit(); }
    public function rollback(){ $this->mysqli->rollback(); }

    public function close(){ $this->mysqli->close(); }
}

?>
