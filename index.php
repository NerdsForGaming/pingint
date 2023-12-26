<!DOCTYPE html>
<html>
<head>
    <title>Server Ping Test</title>
</head>
<body>
    <h1>Server Ping Test</h1>
    <form method="get">
        <label for="ip">Enter IP address to ping:</label>
        <input type="text" id="ip" name="ip" required>
        <button type="submit">Ping</button>
    </form>

    <?php
    if (isset($_GET['ip'])) {
        $ip = $_GET['ip'];

        // Perform ping using system command
        $pingResult = exec("ping -c 4 $ip"); // Sends 4 ICMP echo requests

        // Extracting average time from ping result
        preg_match('/time=([\d.]+) ms/', $pingResult, $matches);
        
        if (isset($matches[1])) {
            $responseTime = $matches[1];
            echo "<p>Average Ping to $ip: $responseTime ms</p>";
        } else {
            echo "<p>Failed to ping $ip.</p>";
        }
    }
    ?>
</body>
</html>
