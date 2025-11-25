<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chat Konsultasi | Ruang Rasa</title>

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
            padding: 1rem 0;
        }

        #chat-box {
            height: 400px;
            overflow-y: auto;
            background: #fafafa;
            padding: 16px;
            border-radius: 16px;
            margin-bottom: 16px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .message {
            margin-bottom: 12px;
            padding: 10px 14px;
            border-radius: 16px;
            max-width: 70%;
            font-size: 0.95rem;
            line-height: 1.4;
            position: relative;
        }

        .sent {
            background: var(--soft-blue);
            color: white;
            margin-left: auto;
            border-bottom-right-radius: 4px;
        }

        .received {
            background: var(--soft-peach);
            color: var(--dark-grey);
            border-bottom-left-radius: 4px;
        }

        .message strong {
            display: block;
            font-weight: 600;
            margin-bottom: 4px;
            font-size: 0.85rem;
            opacity: 0.9;
        }

        .message time {
            font-size: 0.75rem;
            opacity: 0.8;
        }

        /* Produk dalam chat */
        .product-card {
            max-width: 320px;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .product-card img {
            height: 140px;
            object-fit: cover;
            width: 100%;
        }

        .product-card .card-body {
            padding: 12px !important;
        }

        .product-card .btn {
            font-size: 0.85rem;
            padding: 6px 12px;
            border-radius: 10px;
        }

        .btn-send {
            background-color: var(--soft-blue);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.65rem 1.2rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: background-color 0.2s, transform 0.2s;
        }

        .btn-send:hover:not(:disabled) {
            background-color: #658db2;
            transform: translateY(-1px);
        }

        .btn-complete {
            background-color: var(--soft-peach);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 6px 16px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: background-color 0.2s;
        }

        .btn-complete:hover {
            background-color: #d89484;
        }

        /* Draft indicator */
        #draftIndicator {
            font-size: 0.85rem;
            color: #6c757d;
            display: none;
            margin-top: 6px;
        }

        /* Form group responsif */
        .input-group {
            max-width: 100%;
        }

        .input-group .form-control {
            border-radius: 12px 0 0 12px;
            border: 1px solid #ddd;
            padding: 0.7rem;
        }

        .input-group .btn-send {
            border-radius: 0 12px 12px 0;
            height: auto;
        }

        @media (max-width: 768px) {
            #chat-box {
                height: 350px;
                padding: 12px;
            }

            .message {
                max-width: 80%;
            }

            .product-card {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <h4 class="mb-3">💬 Konsultasi #<?= htmlspecialchars($consultation['id'], ENT_QUOTES, 'UTF-8') ?></h4>

        <div id="chat-box" aria-live="polite" aria-relevant="additions"></div>

        <form id="chatForm" method="POST" novalidate>
            <input type="hidden" name="consultation_id" value="<?= (int) $consultation['id'] ?>">
            <div class="input-group">
                <input type="text" name="message" class="form-control" placeholder="Ketik pesan..." required
                    aria-label="Ketik pesan konsultasi">
                <button class="btn-send" type="submit" aria-label="Kirim pesan">Kirim</button>
            </div>
            <div id="draftIndicator" role="status">📝 Draft tersimpan</div>
        </form>

        <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
            <div class="mt-3">
                <select id="adminProductPicker" class="form-select" style="max-width: 300px;"
                    aria-label="Pilih produk untuk rekomendasikan">
                    <option value="">Pilih produk untuk rekomendasikan</option>
                    <?php
                    $db = DB::getInstance();
                    $products = $db->query("SELECT id, name FROM products ORDER BY name")->fetchAll();
                    foreach ($products as $p): ?>
                        <option value="<?= (int) $p['id'] ?>"><?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <?php if (($_SESSION['user']['role'] ?? '') !== 'admin'):
            $hasAdminMessage = false;
            $checkAdmin = $db->prepare("
        SELECT 1 FROM consultation_messages 
        WHERE consultation_id = ? AND sender_id != ?
        LIMIT 1
      ");
            $checkAdmin->execute([$consultation['id'], $_SESSION['user']['id']]);
            $hasAdminMessage = (bool) $checkAdmin->fetch();
            ?>
            <?php if ($hasAdminMessage): ?>
                <div class="text-center mt-3">
                    <a href="?page=complete_consultation&id=<?= (int) $consultation['id'] ?>" class="btn-complete"
                        onclick="return confirm('Apakah Anda yakin ingin menyelesaikan konsultasi ini?')"
                        aria-label="Selesai konsultasi">
                        ✔ Selesai Konsultasi
                    </a>
                </div>
            <?php else: ?>
                <div class="text-center mt-3 text-muted" style="font-size: 0.9rem;">
                    Tunggu rekomendasi dari tim kami sebelum menyelesaikan konsultasi.
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        const consultationId = <?= (int) $consultation['id'] ?>;
        const currentUserId = <?= (int) $_SESSION['user']['id'] ?>;
        const isAdmin = <?= (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') ? 'true' : 'false' ?>;
        const DRAFT_KEY = `chat_draft_${consultationId}`;

        document.addEventListener('DOMContentLoaded', () => {
            const messageInput = document.querySelector('input[name="message"]');
            if (messageInput) {
                const savedDraft = localStorage.getItem(DRAFT_KEY);
                if (savedDraft) {
                    messageInput.value = savedDraft;
                    document.getElementById('draftIndicator').style.display = 'block';
                }
            }
        });

        let draftSaveTimer;
        document.querySelector('input[name="message"]')?.addEventListener('input', function () {
            clearTimeout(draftSaveTimer);
            const message = this.value.trim();
            draftSaveTimer = setTimeout(() => {
                const indicator = document.getElementById('draftIndicator');
                if (message) {
                    localStorage.setItem(DRAFT_KEY, message);
                    indicator.style.display = 'block';
                } else {
                    localStorage.removeItem(DRAFT_KEY);
                    indicator.style.display = 'none';
                }
            }, 1000);
        });

        document.getElementById('chatForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('?page=chat_send', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        alert('Gagal mengirim pesan. Coba lagi.');
                    } else {
                        localStorage.removeItem(DRAFT_KEY);
                        this.message.value = '';
                        document.getElementById('draftIndicator').style.display = 'none';
                    }
                })
                .catch(() => {
                    alert('Kesalahan koneksi. Coba lagi.');
                });
        });

        const pusher = new Pusher('5bff370a5bd607d4280f', {
            cluster: 'ap1',
            encrypted: true
        });
        const channel = pusher.subscribe('consultation_' + consultationId);

        channel.bind('new_message', function (data) {
            addMessage(
                data.name,
                data.message,
                data.time,
                data.sender_id == currentUserId,
                data.message_type || 'text',
                data.product_id || null,
                data.product_image || null,
                data.product_price || null
            );
        });

        fetch('?page=chat_fetch&id=' + consultationId)
            .then(res => res.json())
            .then(messages => {
                messages.forEach(msg => {
                    const messageType = msg.message_type || 'text';
                    addMessage(
                        msg.name,
                        msg.message,
                        msg.created_at.substring(11, 16),
                        msg.sender_id == currentUserId,
                        messageType,
                        messageType === 'product' ? msg.product_id : null,
                        messageType === 'product' ? msg.product_image : null,
                        messageType === 'product' ? msg.product_price : null
                    );
                });
                scrollToBottom();
            });

        function addMessage(name, msg, time, isMe, messageType = 'text', productId = null, productImage = null, productPrice = null) {
            const chatBox = document.getElementById('chat-box');

            if (messageType === 'product' && productId) {
                const imageUrl = productImage || 'https://via.placeholder.com/300x150?text=No+Image';
                const priceFormatted = productPrice ? 'Rp ' + parseFloat(productPrice).toLocaleString('id-ID') : '';

                const card = document.createElement('div');
                card.className = 'product-card mb-3';
                card.innerHTML = `
          <img src="${imageUrl}" class="card-img-top" 
               onerror="this.src='https://via.placeholder.com/300x150?text=Product+Image'">
          <div class="card-body p-2">
            <h6 class="card-title mb-1">${msg}</h6>
            <p class="card-text text-danger mb-2">${priceFormatted}</p>
            <div class="d-grid gap-2">
              <button class="btn btn-sm btn-primary add-to-cart-btn" 
                      data-product-id="${productId}" style="font-size: 0.85rem;">
                ➕ Tambah ke Keranjang
              </button>
              <a href="?page=product_detail&id=${productId}" class="btn btn-sm btn-outline-secondary" style="font-size: 0.85rem;">
                Lihat Detail
              </a>
            </div>
            <small class="text-muted mt-2 d-block">
              ${isMe ? 'Anda' : name} • ${time}
            </small>
          </div>
        `;
                chatBox.appendChild(card);
            } else {
                const div = document.createElement('div');
                div.className = 'message ' + (isMe ? 'sent' : 'received');
                div.innerHTML = `
          <strong>${isMe ? 'Anda' : name}</strong>
          <span>${msg}</span>
          <time>${time}</time>
        `;
                chatBox.appendChild(div);
            }

            scrollToBottom();
        }

        function scrollToBottom() {
            const box = document.getElementById('chat-box');
            box.scrollTop = box.scrollHeight;
        }

        document.getElementById('chat-box').addEventListener('click', function (e) {
            if (e.target.classList.contains('add-to-cart-btn')) {
                const productId = e.target.getAttribute('data-product-id');
                fetch('?page=add_to_cart_ajax', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: productId })
                })
                    .then(res => res.json())
                    .then(data => {
                        alert(data.success ? '✅ ' + data.message : '❌ ' + (data.error || 'Gagal menambahkan'));
                    })
                    .catch(() => {
                        alert('❌ Gagal terhubung ke server');
                    });
            }
        });

        <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
            document.getElementById('adminProductPicker').addEventListener('change', function () {
                if (this.value) {
                    document.querySelector('input[name="message"]').value = `!produk:${this.value}`;
                    document.getElementById('chatForm').dispatchEvent(new Event('submit'));
                    this.value = '';
                }
            });
        <?php endif; ?>

        channel.bind('new_message', function (data) {
            if (data.sender_id != currentUserId) {
                const badge = document.querySelector('.consultation-badge');
                if (badge) {
                    let count = parseInt(badge.textContent) || 0;
                    badge.textContent = count + 1;
                    badge.style.display = 'inline-block';
                }
            }
        });
    </script>
</body>

</html>