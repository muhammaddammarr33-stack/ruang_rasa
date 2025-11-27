<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../models/Order.php';

use Dompdf\Dompdf;

class InvoiceController
{
    private $order;

    public function __construct()
    {
        $this->order = new Order();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function generate()
    {
        if (!isset($_GET['id'])) {
            die("Order ID tidak valid.");
        }

        $orderId = (int) $_GET['id'];
        $data = $this->order->getInvoiceData($orderId);

        if (!$data) {
            die("Order tidak ditemukan.");
        }

        $order = $data['order'];
        $items = $data['items'];

        // ambil HTML template
        ob_start();
        include __DIR__ . '/../views/invoice/template.php';
        $html = ob_get_clean();

        // DomPDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // path output
        $fileName = "INV-" . str_pad($orderId, 5, '0', STR_PAD_LEFT) . ".pdf";
        $filePath = __DIR__ . "/../../public/invoices/" . $fileName;

        // simpan PDF
        file_put_contents($filePath, $dompdf->output());

        // tampilkan ke browser
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=$fileName");
        echo $dompdf->output();
    }
}
