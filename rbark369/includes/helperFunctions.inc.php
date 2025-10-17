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
        <p><?="$".number_format($row['totalValue'])?></p>
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
                    echo "<td>$" . number_format($row['value'], 2) . "</td>";
                    echo "</tr>";
                }?>
            </thead>
        </table>
        </section>
        <?php } 
}