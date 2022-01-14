<?php 
    $actual_link = "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
    $token = "ljNTdKmx805GSm1kUDy4FI1";
    $actual_script = "api.php";
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
<link rel="stylesheet" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    <?php
        echo 'var file = "'.$actual_script."\";\n";
        echo 'var token = "'.$token."\";\n";
        // echo 'var script_adres  = "'.$actual_link.'";';
    ?>

</script>
<script src="calc.js"></script>
</head>
<body>
<h3>CalculatorAJAX</h3>
<div style="font-size: 26px;" id="container">
    <div style="float: left;"><span style="margin-right: 10px;">x:</span><input type="text" id='x' value='10.11'/></div>
    <div style="float: left;"><span style="margin-right: 10px; margin-left: 10px;">y:</span><input type="text" id='y' value='3.33'/> </div>
    <div style="clear:both;"></div>

    <div>
        Result: <span id='result'></span><span id='error'></span>
    </div>

    <div>
        <button id="multiply">*</button>
        <button id="divide">/</button>
        <button id="add">+</button>
        <button id="sub">-</button>
        <button id="test">All results</button>

    </div>

</div>
</body>
</html>
