<?php
function displayPortfolio($result){
    ?>
    <section class= 'portfolio-summary'>
    <h3>Portfolio Summary</h3>
        <?php foreach ($result as $row){?>
        <div class='record-count'>
            <h4>Companies</h4>
            <p><?=$row['countRecords']?>
        </div>

        <div class='number-of-shares'>
        <h4># Shares</h4>
        <p><?=$row['numOfShares']?></p>
        </div>
        
        <div class='total-value'>
        <h4>Total Value</h4>
        <p><?=number_format($row['totalValue'])?></p>
        </div>
        
      </section>
        <section class="portfolio-details">
        <h3> Portfolio Details</h3>
        <table>
            <thead>
                <tr>
                    <th>Symbol</th>
                    <th>Name</th>
                    <th>Sector</th>
                    <th>Amount</th>
                    <th>Value</th>
                </tr>
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


$sql2 = "SELECT 
COUNT(portfolio.userId) AS countRecords,
SUM(portfolio.amount) AS numOfShares,
SUM(portfolio.amount * history.close) AS totalValue
FROM portfolio 

JOIN (SELECT symbol, MAX(date) AS latest_date
FROM history
GROUP BY symbol) latest 
ON latest.symbol = portfolio.symbol  

JOIN history 
    ON portfolio.id = history.id
WHERE portfolio.userId = ?";

$statement = $conn->prepare($sql2);
if ($button_pressed){
$statement->bindValue(1, $_POST['view_portfolio']);
$statement->execute();
$result2 = $statement->fetchAll();
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
            <li><a href="apiTester.php">APIs</a></li>r
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
            displayPortfolio($result2);
            ?>
        

        <?php } ?>
        
        
    </section>
    

    </section>
    </main>
    </table>

</body>
</html>