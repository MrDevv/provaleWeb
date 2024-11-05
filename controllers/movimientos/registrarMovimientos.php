<?php
require_once "../../config/DataBase.php";
include_once "../../models/Movimientos.php";

$movimientosObj = new Movimientos();

$codProducto = $_POST['producto'] ?? null;
$codTipoMovimiento = $_POST['tipoMovimiento'] ?? null;
$fechaMovimiento = $_POST['fechaMovimiento'] ?? null;
$documento = $_POST['documento'] ?? null;
$cantidad = $_POST['cantidad'] ?? null;
$precioUnitario = $_POST['precioUnitario'] ?? null;

$movimientosObj->setCodProducto($codProducto);
$movimientosObj->setCodTipoMovimiento($codTipoMovimiento);
$movimientosObj->setFechaMovimiento($fechaMovimiento);
$movimientosObj->setDocumento($documento);
$movimientosObj->setCantidad($cantidad);
$movimientosObj->setPrecioUnitario($precioUnitario);


$response = $movimientosObj->guardarMovimientos();

print json_encode($response);
//print json_encode([$codProducto, $codTipoMovimiento, $fechaMovimiento, $documento, $cantidad, $precioUnitario]);