<?php
    $serverName = 'servername.com.br, port';
    $connectionOptions = array(
        'database' => 'DATABASE_NAME',
        'uid' => 'username',
        'pwd' => 'password'
    );

    // Establishes the connection
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn === false) {
        die(formatErrors(sqlsrv_errors()));
    }

    // Select Query
    $tsql = 'select @@version as version;';

    // Executes the query
    $stmt = sqlsrv_query($conn, $tsql);

    // Error handling
    if ($stmt === false) {
        die(formatErrors(sqlsrv_errors()));
    }
?>

<h2>Connection established with Sql Server!</h2>
<h3>Sql Server Version:</h3>

<?php
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    echo $row['version'] . PHP_EOL;

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);

    function formatErrors($errors)
    {
        // Display errors
        echo 'Error information: <br/>';
        foreach ($errors as $error) {
            echo 'SQLSTATE: ' . $error['SQLSTATE'] . '<br/>';
            echo 'Code: ' . $error['code'] . '<br/>';
            echo 'Message: ' . $error['message'] . '<br/>';
        }
    }
?>
