<?php


require __DIR__ . '/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$servername = "localhost";
$username = "regoa";
$password = "Regoa123!";
$dbname = "regoa";

$order_get = $_GET['order'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 







$nombre_impresora = "EPSON TM-T20II Receipt"; 


$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);


$printer->setJustification(Printer::JUSTIFY_CENTER);


try{
	$logo = EscposImage::load("../img/redgold.jpg", false);
	$printer->bitImage($logo);
}catch(Exception $e){}



$printer->text("Plaza Binaria\nAvenida Nexxus #100 LOCAL 2B" . "\n");
$printer->text("Orden #" . $order_get . "\n");

$printer->text(date("Y-m-d H:i:s") . "\n");


$total = 0;

$sql = "select `order_clients`.*, `products`.`name` from `order_clients` inner join `products` on `order_clients`.`product_id` = `products`.`id` where `order_id` = ".$order_get." and `order_clients`.`deleted_at` is null";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

	while($row = $result->fetch_assoc()) {

		$unitario = $row["cost"]/$row["quantity"];
		$total += $row["cost"];


		$printer->setJustification(Printer::JUSTIFY_LEFT);
		$printer->text($row["quantity"] . " x " . $row["name"] ."($". $unitario.")". "\n");


		$printer->setJustification(Printer::JUSTIFY_RIGHT);
		$printer->text(' $'. $row["cost"] . "\n");

	}


} else {
	echo "0 results";
}
$conn->close();



$printer->text("--------\n");
$printer->text("TOTAL: $". $total ."\n");


$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("\nMuchas gracias por su PREFERENCIA!!");




$printer->feed(3);


$printer->cut();


$printer->pulse();


$printer->close();

header('Location: ../order/venta_publico');
?>