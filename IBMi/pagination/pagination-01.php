<?php
/*
 * A quick example of pagination on the IBM i using the example SP_CUST DB2
 * table in Zend Server.
 *
 * There is room for improvement in this code, to prevent people from fiddling
 * too much with the $_GET parameters and breaking the logic of page size and
 * page number, and other opportunities for best practices and refactoring,
 * but that is for subsequent versions.
 *
 * To run this example, place the "pagination" directory on your server under
 * document root and visit pagination-01.php in the browser.

 * Javascript libraries can also be used to quickly page within a dataset kept in
 * the browser.
 *
 * The expressions like this:
 * ($pageNumber - 1 < 0) ? 0 : ($pageNumber - 1) * $pageSize;
 * makes use of the ternary operator:
 * http://php.net/manual/en/language.operators.comparison.php#language.operators.comparison.ternary
 *
 * HTML entity reference for the &raquo; stuff
 * http://dev.w3.org/html5/html-author/charref*
 */

readfile(__DIR__ . '/header.html');

$db_options = [
'i5_lib'    => 'ZENDSVR6',
'i5_naming' => DB2_I5_NAMING_OFF,
'DB2_ATTR_CASE' => DB2_CASE_UPPER,
];

$pageSize = 20;
$pageNumber = 1;
$numRecords = 0;

$columnList = 'CUST_ID, COMPANY, FIRSTNAME, LASTNAME, ADDRESS, ADDR2, CITY, STATE, ZIP, COUNTRY, PHONE, FAX';
if (isset($_GET['page'])) {
    $pageNumber = (integer) $_GET['page'];
}
if (isset($_GET['pagesize'])) {
    $pageSize = (integer) $_GET['pagesize'];
}

$offset = ($pageNumber - 1 < 0) ? 0 : ($pageNumber - 1) * $pageSize + 1;
$endingRow = $pageSize * $pageNumber;

//Leaving this echo here so you can see the what's going on:
// echo "pageNumber $pageNumber / pageSize $pageSize<br>offset $offset / endingRow $endingRow<br>";

try {
    $db = db2_connect('', '', '', $db_options);
    if (!$db) {
        throw new Exception('DB2 Connection Error: ' . db2_conn_error() . ' ' . db2_conn_errormsg());
    }
    // Add your appropriate filtering logic to the where clause
    $queryString = "SELECT $columnList FROM"
        . " (select row_number() over (order by CUST_ID) as rowid, $columnList from SP_CUST) as t"
        . " where t.rowid between $offset and $endingRow";

    $statement = db2_prepare($db, $queryString);
    if (false === $statement) {
        throw new Exception('DB2 Prepare Error: ' . db2_stmt_error() . ' ' . db2_stmt_errormsg());
    }
    if (false === db2_execute($statement)) {
        throw new Exception('DB2 Execute Error' . db2_stmt_error($statement) . ' ' . db2_stmt_errormsg($statement));
    }

    // If you don't need to total number of records available, you can skip this logic
    // and remove the display of '(n total records)' in displayTableHeader()
    // Getting count is faster than you think for large numbers of rows.
    // It is much faster than counting the number of records actually returned.
    // APPLY the same FILTERING (where clause) to this COUNT query as above, except for the
    // "where rowid between" of course!!!
    $countStatement = db2_prepare($db, 'SELECT count(*) as numRecords FROM SP_CUST');
    if (false === $countStatement) {
        throw new Exception('DB2 Prepare Error: ' . db2_stmt_error() . ' ' . db2_stmt_errormsg());
    }
    if (false === db2_execute($countStatement)) {
        throw new Exception('DB2 Execute Error' . db2_stmt_error($statement) . ' ' . db2_stmt_errormsg($statement));
    }
    if ($row = db2_fetch_assoc($countStatement)) {
        $numRecords = $row['NUMRECORDS'];
        $pageTotal = (integer) ceil($numRecords / $pageSize);
    }

    if ($numRecords) {
        displayTableHeader($pageNumber, $pageTotal, $numRecords);
        while ($row = db2_fetch_assoc($statement)) {
            displayTableRow($row);
        }
        displayTableFooter();
        displayPageNavigation($pageNumber, $pageTotal, $numRecords);
    }
} catch (Exception $e) {
    echo '<p class="error">', $e->getMessage(), 'Line: ', $e->getLine(), '<p>';
}

readfile(__DIR__ . '/footer.html');

/**
 * Display HTML Table Heading for resultset, with caption.
 *
 * @param array   $dataRow An associative array of one row/record of data
 * @param integer $pageNumber The current page being viewed
 * @param integer $pageTotal Total number of pages available, null to not display this
 * @param integer $numRecords Total number of records meeting the search criteria
*/
function displayTableHeader($pageNumber, $pageTotal, $numRecords = null, $dataRow = array()) {
    $numRecordsString = is_null($numRecords) ? '' : " ($numRecords total records)";
    ?>
<table class="queryOutput">
  <caption>Showing ALL the THINGZ! <?php echo "Page $pageNumber of $pageTotal$numRecordsString" ?></caption>
  <tr>
<?php
    if (!empty($dataRow)) {
        $columns = array_keys($dataRow);
        foreach ($columns as $column) {
            echo '<th>' . $this->escapehtml(trim($column)) . '</th>';
        }
    } else {
?>
    <th>CUST_ID</th>
    <th>COMPANY</th>
    <th>FIRSTNAME</th>
    <th>LASTNAME</th>
    <th>ADDRESS</th>
    <th>ADDR2</th>
    <th>CITY</th>
    <th>STATE</th>
    <th>ZIP</th>
    <th>COUNTRY</th>
    <th>PHONE</th>
    <th>FAX</th>
<?php
    }
    echo '</tr>';
}

/**
 * Display HTML table row from resultset
 *
 * @param array $row Associative array of data to display in HTML table row.
 */
function displayTableRow(array $row) {
    echo '<tr>'
        , "<td>{$row['CUST_ID']}</td>"
        , "<td>{$row['COMPANY']}</td>"
        , "<td>{$row['FIRSTNAME']}</td>"
        , "<td>{$row['LASTNAME']}</td>"
        , "<td>{$row['ADDRESS']}</td>"
        , "<td>{$row['ADDR2']}</td>"
        , "<td>{$row['CITY']}</td>"
        , "<td>{$row['STATE']}</td>"
        , "<td>{$row['ZIP']}</td>"
        , "<td>{$row['COUNTRY']}</td>"
        , "<td>{$row['PHONE']}</td>"
        , "<td>{$row['FAX']}</td>"
        , '</tr>';
}

/**
 * Display HTML table footer. Currently, just the closing table element.
 */
function displayTableFooter() {
    ?></table><?php
}

/**
 * Display page navigation controls (next/prev page, first/last page)
 *
 * @param integer $pageNumber The current page being viewed
 * @param integer $pageTotal Total number of pages available
 */
function displayPageNavigation($pageNumber, $pageTotal) {
    $prevPageNumber = ($pageNumber - 1 <= 0) ? 1 : $pageNumber - 1;
    $nextPageNumber = ($pageNumber + 1 >= $pageTotal) ? $pageTotal : $pageNumber + 1;

    $pageSizeString = '';
    if (isset($_GET['pagesize'])) {
        $pageSize = (integer) $_GET['pagesize'];
        $pageSizeString = "&pagesize=$pageSize";
    }
?>
<a href="pagination.php?page=1<?php echo $pageSizeString?>" title="first page">&laquo; First Page &laquo;</a>
<a href="pagination.php?page=<?php echo $prevPageNumber, $pageSizeString?>" title="prev page">&lt; Prev Page &lt;</a>
<a href="pagination.php?page=<?php echo $nextPageNumber, $pageSizeString?>" title="next page">&gt; Next Page &gt;</a>
<a href="pagination.php?page=<?php echo $pageTotal, $pageSizeString?>" title="last page">&raquo; Last Page &raquo;</a>
<?php
}
