<?php
// tagalog time...

// kunin ang lahat ng item sa database
$sql = "SELECT * FROM account";
// iexecute ang query
$result = mysqli_query($conn, $sql);

// kung may laman ang result
if (mysqli_num_rows($result) > 0) {

    // check kung merong account.json sa dump folder
    if (!file_exists('../../dump/account.json')) {
        // delete ang account.json
        mkdir('../../dump/account.json', 0777, true);
    }

    // gawin ang result na array
    $output = array();

    // ilagay ang result sa array
    while ($row = mysqli_fetch_assoc($result)) {
        $output[] = $row;
    }

    // gumawa ng account.json sa dump folder
    $fp = fopen('../../dump/account.json', 'w');
    // ilagay ang output sa account.json
    fwrite($fp, json_encode($output));
    // isara ang account.json
    fclose($fp);

    // yun lang and I THANK YOU!
}
?>