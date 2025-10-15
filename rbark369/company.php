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
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Company Info</title>
    <link rel="stylesheet" href="css/styles.css">
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
    <table>
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
                <th> Financials: </th>
                <td><?php echo htmlspecialchars($row['financials']); ?></td>
    
                <table>
                    <?php
                    $financials = json_decode($row['financials'], true);
                    echo "<tr><th>Years: </th><td>" . number_format($financials['years']) . "</td></tr>";
                    echo "<tr><th>Revenue: </th><td>$financials[revenue]</td></tr>";
                    echo "<tr><th>Earnings:</th> <td>$financials[earnings]</td></tr>";
                    echo "<tr><th>Assets:</th> <td>$financials[assets]</td></tr>";
                    echo "<tr><th>Earnings:</th> <td>$financials[liabilities]</td></tr>";
                    ?>
                </table>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class= company-data> 
    <table class="history-table">
        <tr><th colspan=5> History (3M) </th></tr>
        <tr>
            <th> Date </th>
            <th> Volume</td>
            <th> Open</th>
            <th> Close</th>
            <th> High </th>
            <th> Low </th>
        </tr>
        <tr>
        <?php foreach ($result2 as $row2): ?>
    
            <td><?php echo htmlspecialchars($row2['date']); ?></td>
            <td><?php echo htmlspecialchars($row2['volume']); ?></td>
            <td><?php echo htmlspecialchars($row2['open']); ?></td>
            <td><?php echo htmlspecialchars($row2['close']); ?></td>
            <td><?php echo htmlspecialchars($row2['high']); ?></td>
            <td><?php echo htmlspecialchars($row2['low']); ?></td>
            
        </tr>
        <?php endforeach; ?>
    </table>

    <section class= company-info>
        <div>History High</div>
        <div>History Low</div>
        <div> Total Volume</div>
        <div> Average Volume</div>
    </section>
    </div>

</body>
</html>