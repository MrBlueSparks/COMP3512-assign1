<?php 
//use helper file for db connection
include 'includes/db.inc.php';

try {
//fetch company info from db
$symbol = $_GET['symbol'] ?? '';

$sql = "SELECT * FROM companies WHERE symbol = ?";
$stmt = $conn->prepare($sql);
$stmt->bindValue(1, $_GET['symbol']);
$stmt->execute();
$result = $stmt->fetchAll();

//fetch company history from db
$sql2 = "SELECT * FROM history WHERE symbol = ? ORDER BY date DESC LIMIT 90";
$stmt2 = $conn->prepare($sql2);
$stmt2->bindValue(1, $_GET['symbol']);
$stmt2->execute();
$result2 = $stmt2->fetchAll();


$sql3 = "SELECT MAX(high) AS max_high, MIN(low) AS min_low, 
SUM(volume) AS total_volume, AVG(volume) AS avg_volume FROM history WHERE symbol = ?";
$stmt3 = $conn->prepare($sql3);
$stmt3->bindValue(1, $_GET['symbol']);
$stmt3->execute();
$summary = $stmt3->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<html>
<head>
    <title>Company Info</title>
    <!-- Link to CSS file with cache busting -->
    <link rel="stylesheet" href="css/styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <nav>
        <h1> Portfolio Project</h1>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="apiTester.php">APIs</a></li>
        </ul>
    </nav>
    <h1>Company Info</h1>
    <table class="company-info">
        <?php foreach ($result as $row): ?>
            <tr>
                <th> Company Name: </th>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
            </tr>
            <tr>
                <th> Symbol: </th>
                <td><?php echo htmlspecialchars($row['symbol']); ?></td>
            </tr>
            <tr>
                <th> Sector: </th>
                <td><?php echo htmlspecialchars($row['sector']); ?></td>
            </tr>
            <tr>
                <th> Subindustry: </th>
                <td><?php echo htmlspecialchars($row['subindustry']); ?></td>
            </tr>
            <tr>
                <th> Address: </th>
                <td><?php echo htmlspecialchars($row['address']); ?></td>
            </tr>
            <tr>
                <th> Exchange: </th>
                <td><?php echo htmlspecialchars($row['exchange']); ?></td>
            </tr>

            <tr>
                <th> Website: </th>
                <td><a href="<?php echo htmlspecialchars($row['website']); ?>"><?php echo htmlspecialchars($row['website']); ?></a></td>
            </tr>
            <tr>
                <th> Description: </th>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
            </tr>
            <tr>
                <th id='financial-header'> Financials: </th>
                <td> 
                <table id='financials-table'>
                    <?php
                    $jsonString = $row['financials'] ?? '';

                    if (!empty($jsonString)) {
                        $jsonString = str_replace('`', '"', $jsonString);
                    }
                    $financials = json_decode($jsonString, true);
                    
                    echo "<tr><th>Years: </th><td>" . implode(', ', $financials["years"]) . "</td></tr>";
                    echo "<tr><th>Revenue: </th><td>" . implode(', ',array_map('number_format', $financials["revenue"])) . "</td></tr>";
                    echo "<tr><th>Earnings:</th><td>" . implode(', ',array_map('number_format', $financials["earnings"])) . "</td></tr>";
                    echo "<tr><th>Assets:</th><td>" . implode(', ', array_map('number_format', $financials["assets"])) . "</td></tr>";
                    echo "<tr><th>Liabilities:</th><td>" . implode(', ', array_map('number_format', $financials["liabilities"])) . "</td></tr>";
                    ?>
                </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="company-data"> 
    <table class="history-table">
        <tr><th colspan=5> History (3M) </th></tr>
        <tr>
            <th> Date </th>
            <th> Volume</th>
            <th> Open</th>
            <th> Close</th>
            <th> High </th>
            <th> Low </th>
        </tr>
        <?php foreach ($result2 as $row2): ?>
        <tr>
            
            <td><?php echo htmlspecialchars($row2['date']); ?></td>
            <td><?php echo htmlspecialchars(number_format($row2['volume'])); ?></td>
            <td><?php echo htmlspecialchars(number_format($row2['open'], 2)); ?></td>
            <td><?php echo htmlspecialchars(number_format($row2['close'], 2)); ?></td>
            <td><?php echo htmlspecialchars(number_format($row2['high'], 2)); ?></td>
            <td><?php echo htmlspecialchars(number_format($row2['low'], 2)); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <section class="company-summary">
        <div><h3>History High</h3>
            <?php echo htmlspecialchars(number_format($summary['max_high'], 2)); ?>
        </div>
        <div><h3>History Low</h3>
            <?php echo htmlspecialchars(number_format($summary['min_low'], 2)); ?>
        </div>
        <div><h3> Total Volume</h3>
            <?php echo htmlspecialchars(number_format($summary['total_volume'])); ?>
        </div>
        <div><h3> Average Volume</h3>
            <?php echo htmlspecialchars(number_format($summary['avg_volume'], 2)); ?>
        </div>
    </section>
    </div>

</body>
</html>