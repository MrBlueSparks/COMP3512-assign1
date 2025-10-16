<?php
function displayPortfolio($result1, $result2){
    ?>
    <section class= 'portfolio-summary'>
    <h3>Portfolio Summary</h3>
        <?php foreach ($result1 as $row){?>
        <div class='record-count'>
            <h4>Companies</h4>
            <p><?=number_format($row['countRecords'])?></p>
        </div>

        <div class='number-of-shares'>
        <h4># Shares</h4>
        <p><?=number_format($row['numOfShares'])?></p>
        </div>
        
        <div class='total-value'>
        <h4>Total Value</h4>
        <p><?=number_format($row['totalValue'])?></p>
        </div>
        
      </section>
        <section class="portfolio-details">
        <h3> Portfolio Details</h3>
        <table class="portfolio-details-table">
            <thead>
                <tr>
                    <th>Symbol</th>
                    <th>Name</th>
                    <th>Sector</th>
                    <th>Amount</th>
                    <th>Value</th>
                </tr>
                <?php foreach ($result2 as $row){
                    echo "<tr>";
                    echo "<td>" . $row['symbol'] . "</td>";    
                    echo "<td>" . $row['name'] ."</td>";    
                    echo "<td>" . $row['sector'] . "</td>";
                    echo "<td>" . number_format($row['amount']) . "</td>";
                    echo "<td>" . number_format($row['value'], 2) . "</td>";
                    echo "</tr>";
                }?>
            </thead>
        </table>
        </section>
        <?php } 
}

try {
include 'includes/db.inc.php';

//Get users
$sql = "SELECT * FROM users 
ORDER BY lastname ASC";
$result = $conn->query($sql);

$button_pressed = isset($_POST['view_portfolio']);

//portfolio summary
$sql2 = "SELECT 
COUNT(portfolio.userId) AS countRecords,
SUM(portfolio.amount) AS numOfShares,
SUM(portfolio.amount * (
            SELECT history.close
            FROM history 
            WHERE history.symbol = portfolio.symbol
            ORDER BY history.date DESC
            LIMIT 1
        )) AS totalValue
FROM portfolio 


WHERE portfolio.userId = ?";

$statement = $conn->prepare($sql2);
if ($button_pressed){
$statement->bindValue(1, $_POST['view_portfolio']);
$statement->execute();
$result2 = $statement->fetchAll();
}
//portfolio details
$sql3 = "SELECT 
portfolio.symbol AS symbol,
companies.name AS name,
companies.sector AS sector,
portfolio.amount AS amount,
(portfolio.amount * history.close) AS value

FROM portfolio
JOIN companies 
ON portfolio.symbol = companies.symbol

JOIN (SELECT symbol, MAX(date) AS latest_date
FROM history
GROUP BY symbol) latest 
ON latest.symbol = portfolio.symbol

JOIN history
ON companies.symbol = history.symbol AND history.date = latest.latest_date

WHERE portfolio.userID = ?
ORDER BY companies.name";

$statement2 = $conn->prepare($sql3);
if ($button_pressed){
    $statement2 -> bindValue(1, $_POST['view_portfolio']);
    $statement2 -> execute();
    $result3 = $statement2->fetchAll();
}

}
catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}


?>
<html>
<head>
    <title>Home Page</title>
    <link rel="stylesheet" href="css/styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <nav>
        <h1> Portfolio Project</h1>
        <ul class="nav-links">
            <li><a href="company.php?symbol=A">Companies</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="apiTester.php">APIs</a></li>
        </ul>
    </nav>

    <main class= 'main-home'>
    <section class="customers">
        <table class="customers-table">
            <tr><th colspan="2">Customers</th></tr>
            <tr><th>Name</th></tr>
            <?php foreach ($result as $row){
                echo "<form method='post'>";
                echo "<tr>";
                echo "<td>" . $row['lastname'] . "," . $row['firstname']."</td>";
                echo "<td><button name='view_portfolio' value='". $row['id']. "' class='portfolio-button' type='submit'>
                View Portfolio</button>";
                echo "</tr>"; 
                echo "</form>";
            }
            ?>

        </table>

    </section>

    <section class= 'portfolio'>
        <?php if (!$button_pressed){
            echo "<h3>Please select a customer's portfolio</h3>";
        }
   
        else {
            displayPortfolio($result2, $result3);
        }
            ?>
        
    </section>
    

    </section>
    </main>
    </table>

</body>
</html>