<?php
session_start();
require 'connection.php';

/**
 * Function for more comfortable printing of data using pre tags.
 *
 * @param mixed $value The value to be printed.
 *
 * @return void
 */
function tt($value)
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    exit();
}

/**
 * Function to check for errors after executing a database query.
 *
 * @param PDOStatement $query The executed PDOStatement.
 *
 * @return bool Returns true if there are no errors, otherwise exits the script.
 */
function dbErrorCheck($query)
{
    $errInfo = $query->errorInfo();
    if($errInfo[0] !== PDO::ERR_NONE)
    {
        echo "PDO Error: " . $errInfo[0] . "<br>";
        echo "SQLSTATE Error: " . $errInfo[1] . "<br>";
        echo "Driver Error: " . $errInfo[2] . "<br>";
        exit();
    }
    return true;
}

/**
 * <p>Function selects one from table with parameters</p>
 *
 * @param string $table The name of the table to select from.
 * @param array $param An associative array of parameters for the WHERE clause.
 *
 * @return mixed|null Returns the selected record as an associative array or null if not found.
 */
function selectOne($table, $param)
{
    global $connection;

    $sql = "SELECT * FROM $table";
    $params = [];
    if (!empty($param)) {
        $whereClause = [];
        foreach ($param as $key => $value) {
            $whereClause[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        $sql .= " WHERE " . implode(" AND ", $whereClause);
    }

    $sql .= " LIMIT 1";

    $query = $connection->prepare($sql);
    $query->execute($params);
    dbErrorCheck($query);
    return $query->fetch();
}


/**
 * Function to select all records from a table.
 *
 * @param string $table The name of the table to select from.
 *
 * @return array Returns an array containing all records from the specified table.
 */
function selectAll($table)
{
    global $connection;

    $sql = "SELECT * FROM $table";
    $query = $connection->prepare($sql);
    $query->execute();
    dbErrorCheck($query);
    return $query->fetchAll();
}

/**
 * Function to select all records or count the rows in a table based on provided parameters.
 *
 * @param string $table The name of the table to select from.
 * @param array $param An associative array of parameters for the WHERE clause.
 * @param int $count If set to 1, the function returns the count of rows instead of the records.
 *
 * @return array|int Returns an array containing all records from the specified table or the count of rows.
 */
function selectAllWhere($table, $param, $count = 0)
{
    global $connection;

    $sql = "SELECT * FROM $table";
    $params = [];
    if ($count == 1) {
        $sql = "SELECT COUNT(id_course) FROM $table";
    }
    if (!empty($param)) {
        $whereClause = [];
        foreach ($param as $key => $value) {
            $whereClause[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        $sql .= " WHERE " . implode(" AND ", $whereClause);
    }

    $query = $connection->prepare($sql);
    $query->execute($params);
    dbErrorCheck($query);

    if ($count > 0) {
        return $query->fetchColumn();
    } else {
        return $query->fetchAll();
    }
}


/**
 * Function for pagination - selects a limited number of records from a table with optional filtering.
 *
 * @param string $table The name of the table to select from.
 * @param int $limit The number of records to retrieve.
 * @param int $offset The starting offset for retrieving records.
 * @param string $orderBy The column to order by.
 * @param string $order The order direction ('ASC' or 'DESC').
 * @param string $category Optional category filter.
 * @param string $id_user Optional user ID filter.
 *
 * @return array Returns an array containing the selected records.
 */
function selectAllLimitOffset($table, $limit, $offset, $orderBy, $order, $category = '', $id_user = '')
{
    global $connection;

    $sql = "SELECT * FROM $table";
    $params = [];
    if ($category !== '') {
        $sql .= " WHERE category = :category";
        $params[':category'] = $category;
    } elseif ($id_user !== '') {
        $sql .= " WHERE id_user = :id_user";
        $params[':id_user'] = $id_user;
    }
    $sql .= " ORDER BY $orderBy $order LIMIT $limit OFFSET $offset";

    $query = $connection->prepare($sql);
    $query->execute($params);
    dbErrorCheck($query);
    return $query->fetchAll();
}

/**
 * Function to insert a new record into the specified table.
 *
 * @param string $table The name of the table to insert into.
 * @param array $params An associative array of column names and values to be inserted.
 *
 * @return int Returns the last inserted ID.
 */
function insert($table, $params) {
    global $connection;

    $columns = implode(', ', array_keys($params));
    $values = ':' . implode(', :', array_keys($params));
    $sql = "INSERT INTO $table ($columns) VALUES ($values)";

    $stmt = $connection->prepare($sql);

    foreach ($params as $key => &$value) {
        $stmt->bindValue(":$key", $value);
    }

    $stmt->execute();

    if ($stmt->errorCode() !== '00000') {
        $errorInfo = $stmt->errorInfo();
        echo "Error: " . $errorInfo[2];
    }

    return $connection->lastInsertId();
}


/**
 * Function to update records in the specified table based on the provided parameters.
 *
 * @param string $table The name of the table to update.
 * @param array $params An associative array of column names and values to be updated.
 * @param int $id The value of the primary key for the WHERE clause.
 * @param string $id_db The name of the primary key column.
 *
 * @return int Returns the number of affected rows.
 */
function update($table, $params, $id, $id_db)
{
    global $connection;

    $columns = '';
    foreach ($params as $key => $value) {
        $columns .= "$key=:$key, ";
    }
    $columns = rtrim($columns, ', ');

    $sql = "UPDATE $table SET $columns WHERE $id_db = :id";

    $query = $connection->prepare($sql);

    // Bind parameters
    foreach ($params as $key => &$value) {
        $query->bindParam(":$key", $value);
    }
    $query->bindParam(":id", $id);

    // Execute the statement
    $query->execute();

    // Check for errors
    if ($query->errorCode() !== '00000') {
        $errorInfo = $query->errorInfo();
        echo "Error: " . $errorInfo[2];
    }

    return $query->rowCount();
}

/**
 * Function to delete records from the specified table based on the provided parameters.
 *
 * @param string $table The name of the table to delete from.
 * @param int $id The value of the primary key for the WHERE clause.
 * @param string $idAttribute The name of the primary key column.
 *
 * @return int Returns the number of affected rows.
 */
function delete($table, $id, $idAttribute)
{
    global $connection;

    $sql = "DELETE FROM $table WHERE $idAttribute = $id";

    $query = $connection->prepare($sql);

    $query->execute();

    if ($query->errorCode() !== '00000') {
        $errorInfo = $query->errorInfo();
        echo "Error: " . $errorInfo[2];
    }

    return $query->rowCount();
}

