<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background: #f5f5f5;
        }

        h2 {
            margin-bottom: 0;
        }

        .total {
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>

<body>

    <h2>Invoice</h2>
    <p>No: <strong>INV-<?= str_pad($order['id'], 5, "0", STR_PAD_LEFT) ?></strong></p>
    <p>Tanggal: <?= date("d/m/Y H:i", strtotime($order['created_at'])) ?></p>

    <h3>Customer</h3>
    <p>
        Nama: <?= htmlspecialchars($order['customer_name']) ?><br>
        Email: <?= htmlspecialchars($order['customer_email']) ?>
    </p>

    <h3>Detail Pesanan</h3>

    <table>
        <tr>
            <th>Produk</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>

        <?php foreach ($items as $i): ?>
            <tr>
                <td><?= htmlspecialchars($i['product_name']) ?></td>
                <td><?= $i['quantity'] ?></td>
                <td>Rp <?= number_format($i['price'], 0, ',', '.') ?></td>
                <td>Rp <?= number_format($i['subtotal'], 0, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p class="total">
        Total: Rp <?= number_format($order['total_amount'], 0, ',', '.') ?>
    </p>

</body>

</html>