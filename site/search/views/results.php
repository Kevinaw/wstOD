    <form action="/site/search/index.php" method="post">
    <table style="width:100%">
    <tr valign=top>
      <td >
            <?php
                include 'views/get_listings_table.php';
            ?>
      </td>
<?php
    if(!isset($_REQUEST["affiliate"])){
        print '<td style="width:175px;">';
        $limit=5;
        include $_SERVER['DOCUMENT_ROOT']."/includes/affiliates.inc";
        print '</td>';
    }
?>
      </tr>
      </table>
    </div>


