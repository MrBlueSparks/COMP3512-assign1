<html>
<head>
    <title>API Tester</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav>
        <h1> Portfolio Project</h1>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="company.php?symbol=A">Companies</a></li>
            <li><a href="apiTester.php">APIs</a></li>
        </ul>
    </nav>
    <h2>API List</h2>
    <table class="api-table">
        <tr>
            <th> URL </th>
            <th> Description </th>
        </tr>
        <tr>
            <td><a href="./api/companies.php">/api/companies.php</a></td>
            <td>Returns all the companies/stocks</td>
        </tr>
        <tr>
            <td><a href="./api/companies.php?ref=ads"> /api/companies.php?ref=ads</a></td>
            <td>Returns just a specific company/stocks</td>
        </tr>
        <tr>
            <td><a href="./api/portfolio.php?ref=8">/api/portfolio.php?ref=8</a></td>
            <td>Returns all the portfolios for a specific sample customer</td>
        </tr>
        <tr>
            <td><a href="./api/history.php?ref=ads">/api/history.php?ref=ads</a></td>
            <td>Returns the history information for a specific sample company</td>
        </tr>
    </table>


</body>

</html>