<!-- app/views/user/orders.php -->
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Riwayat Pesanan | Ruang Rasa</title>

  <!-- Google Fonts: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    :root {
      --off-white: #F5F5EC;
      --soft-blue: #79A1BF;
      --soft-peach: #E7A494;
      --dark-grey: #343D46;
    }

    body {
      background-color: var(--off-white);
      font-family: 'Poppins', sans-serif;
      color: var(--dark-grey);
      padding: 1.5rem 0;
    }

    .orders-header {
      font-weight: 700;
      font-size: 1.8rem;
      margin-bottom: 1.5rem;
      color: var(--dark-grey);
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .orders-card {
      background: white;
      border-radius: 18px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
      padding: 1.75rem;
    }

    .order-table {
      border-collapse: separate;
      border-spacing: 0;
      border-radius: 12px;
      overflow: hidden;
      width: 100%;
    }

    .order-table thead th {
      background-color: #f9fafc;
      font-weight: 600;
      color: var(--dark-grey);
      padding: 1rem;
    }

    .order-table tbody td {
      padding: 1.1rem 1rem;
      vertical-align: middle;
      border-bottom: 1px solid #f0f0f0;
    }

    .order-table tbody tr:last-child td {
      border-bottom: none;
    }

    /* Status badge */
    .status-badge {
      padding: 0.45rem 1rem;
      border-radius: 14px;
      font-weight: 600;
      font-size: 0.95rem;
      display: inline-block;
    }

    .status-waiting,
    .status-processing,
    .status-shipped,
    .status-pending {
      background-color: rgba(121, 161, 191, 0.15);
      color: var(--soft-blue);
    }

    .status-completed {
      background-color: rgba(231, 164, 148, 0.25);
      color: var(--soft-peach);
    }

    .status-cancelled {
      background-color: rgba(239, 68, 68, 0.1);
      color: #e74c3c;
    }

    /* Tombol aksi */
    .btn-detail,
    .btn-invoice {
      background-color: transparent;
      color: var(--soft-blue);
      border: 1px solid var(--soft-blue);
      border-radius: 10px;
      padding: 0.45rem 0.8rem;
      font-weight: 600;
      font-size: 0.85rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      transition: all 0.2s;
    }

    .btn-detail:hover,
    .btn-invoice:hover {
      background-color: var(--soft-blue);
      color: white;
    }

    .personalization-preview {
      font-size: 0.85rem;
      background: rgba(121, 161, 191, 0.05);
      padding: 0.6rem;
      border-radius: 10px;
      margin-top: 0.5rem;
    }

    .personalization-preview b {
      color: var(--dark-grey);
      display: block;
      margin-bottom: 0.2rem;
    }

    .breadcrumb {
      background: transparent;
      padding: 0;
      margin-bottom: 1.5rem;
    }

    .breadcrumb a {
      color: var(--soft-blue);
      text-decoration: none;
    }

    .empty-state {
      background: white;
      border-radius: 18px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      padding: 2.5rem 1.5rem;
      text-align: center;
    }

    .btn-browse {
      background-color: var(--soft-blue);
      color: white;
      border: none;
      border-radius: 12px;
      padding: 0.75rem 1.5rem;
      font-weight: 600;
      text-decoration: none;
      display: inline-block;
      transition: background-color 0.2s;
    }

    .btn-browse:hover {
      background-color: #658db2;
    }

    /* ——— Mobile Responsive ——— */
    @media (max-width: 768px) {
      .order-table thead {
        display: none;
      }

      .order-table,
      .order-table tbody,
      .order-table tr,
      .order-table td {
        display: block;
        width: 100%;
      }

      .order-table tr {
        margin-bottom: 1.25rem;
        padding: 1.25rem;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      }

      .order-table td {
        display: flex;
        justify-content: space-between;
        padding: 0.6rem 0 !important;
        border: none;
        flex-wrap: wrap;
      }

      .order-table td:before {
        content: attr(data-label) ": ";
        font-weight: 600;
        color: var(--dark-grey);
        flex: 0 0 110px;
        margin-right: 0.5rem;
      }

      .order-table td:last-child {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
        padding-top: 1rem !important;
      }

      .order-table td:last-child:before {
        content: "Aksi:";
      }

      .btn-detail,
      .btn-invoice {
        width: 100%;
        justify-content: center;
      }
    }
  </style>
</head>

<body>
  <div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="?page=landing">Beranda</a></li>
        <li class="breadcrumb-item active" aria-current="page">Riwayat Pesanan</li>
      </ol>
    </nav>

    <h1 class="orders-header">
      <i class="fas fa-shopping-bag" aria-hidden="true"></i> Riwayat Pesanan Saya
    </h1>

    <?php if (!empty($orders)): ?>
          <div class="orders-card">
            <table class="order-table">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Status</th>
                  <th scope="col">Metode</th>
                  <th scope="col">Total</th>
                  <th scope="col">Personalisasi</th>
                  <th scope="col">Aksi</th>
                  <th scope="col">Resi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($orders as $o): ?>
                      <tr>
                        <td data-label="ID">#<?= (int) $o['id'] ?></td>
                        <td data-label="Tanggal"><?= htmlspecialchars(date('d M Y', strtotime($o['created_at'])), ENT_QUOTES, 'UTF-8') ?></td>
                        <td data-label="Status">
                          <?php
                          $status = $o['order_status'] ?? 'pending';
                          $statusClass = match ($status) {
                              'completed' => 'status-completed',
                              'cancelled' => 'status-cancelled',
                              'waiting', 'pending', 'processing', 'shipped' => 'status-' . $status,
                              default => 'status-pending'
                          };
                          ?>
                          <span class="status-badge <?= htmlspecialchars($statusClass, ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars(ucfirst($status), ENT_QUOTES, 'UTF-8') ?>
                          </span>
                        </td>
                        <td data-label="Metode"><?= htmlspecialchars(ucfirst($o['payment_method'] ?? '–'), ENT_QUOTES, 'UTF-8') ?></td>
                        <td data-label="Total">Rp <?= number_format((int) $o['total_amount'], 0, ',', '.') ?></td>
                        <td data-label="Personalisasi">
                          <?php
                          $customList = $customOrdersByOrder[$o['id']] ?? [];
                          if (!empty($customList)):
                              ?>
                                <div class="personalization-preview">
                                  <?php foreach ($customList as $co): ?>
                                        <div>
                                          <b><?= htmlspecialchars($co['product_name'] ?? 'Produk', ENT_QUOTES, 'UTF-8') ?>:</b>
                                          "<?= htmlspecialchars($co['custom_text'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        </div>
                                  <?php endforeach; ?>
                                </div>
                          <?php endif; ?>
                        </td>
                        <td data-label="Aksi">
                          <a href="?page=order_detail&id=<?= (int) $o['id'] ?>" class="btn-detail" aria-label="Lihat detail pesanan #<?= (int) $o['id'] ?>">
                            <i class="fas fa-eye" aria-hidden="true"></i> Detail
                          </a>
                        </td>
                        <td data-label="Resi">
                          <a href="?page=invoice&id=<?= (int) $o['id'] ?>" target="_blank" class="btn-invoice" aria-label="Download invoice pesanan #<?= (int) $o['id'] ?>">
                            Download Invoice
                          </a>
                        </td>
                      </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
    <?php else: ?>
          <div class="empty-state">
            <i class="fas fa-shopping-bag fa-2x text-muted mb-3" aria-hidden="true"></i>
            <p class="text-muted">Belum ada pesanan.</p>
            <a href="?page=products" class="btn-browse" aria-label="Jelajahi kado spesial">
              Jelajahi Kado Spesial
            </a>
          </div>
    <?php endif; ?>
  </div>
</body>

</html>