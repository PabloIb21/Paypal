<?php

if(!isset($_POST['producto'], $_POST['precio'])){
    exit("Hubo un error");
}

require 'config.php';

$producto = htmlspecialchars($_POST['producto']);
$precio = htmlspecialchars($_POST['precio']);
$precio = (int) $precio;
$envio = 5;
$total = $precio + $envio;

$compra = new \PayPal\Api\Payer();
$compra->setPaymentMethod('paypal');

$articulo = new \PayPal\Api\Item();
$articulo->setName($producto)
        ->setCurrency('MXN')
        ->setQuantity(1)
        ->setPrice($precio);

$listaArticulos = new \PayPal\Api\ItemList();
$listaArticulos->setItems(array($articulo));

$detalles = new \PayPal\Api\Details();
$detalles->setShipping($envio)
        ->setSubtotal($precio);

$cantidad = new \PayPal\Api\Amount();
$cantidad->setCurrency('MXN')
        ->setTotal($total)
        ->setDetails($detalles);

$transaccion = new \PayPal\Api\Transaction();
$transaccion->setAmount($cantidad)
            ->setItemList($listaArticulos)
            ->setDescription('Pago ')
            ->setInvoiceNumber(uniqid());

$redireccionar = new \PayPal\Api\RedirectUrls();
$redireccionar->setReturnUrl(URL_SITIO . '/pago_finalizado.php?exito=true')
            ->setCancelUrl(URL_SITIO . '/pago_finalizado.php?exito=false');

$pago = new \PayPal\Api\Payment();
$pago->setIntent('sale')
    ->setPayer($compra)
    ->setRedirectUrls($redireccionar)
    ->setTransactions(array($transaccion));

try {
    $pago->create($apiContext);
}catch(\PayPal\Exception\PayPalConnectionException $ex) { 
    echo '<pre>';
    print_r(json_encode($ex->getData()));
    exit;
    echo '</pre>';
}

$aprobado = $pago->getApprovalLink();

header("Location: $aprobado");

?>
