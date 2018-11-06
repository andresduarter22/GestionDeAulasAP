<html>
<head>
<link href="Style.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php
include 'FuncionCalendario.php';

$calendar = new Calendar();

echo $calendar->show();
?>
</body>
</html>
