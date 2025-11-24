<?php
// HAPUS SEMUA DEBUGGING DI ATAS
// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<style>
    /* ... CSS Anda tetap sama ... */
    .chat-container {
        max-width: 900px;
        margin: 0 auto;
        height: calc(100vh - 180px);
        display: flex;
        flex-direction: column;
        background: #f0f2f5;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .chat-header {
        background: linear-gradient(135deg, #79A1BF 0%, #5a8bc4 100%);
        color: white;
        padding: 16px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .chat-header .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #5a8bc4;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .chat-header .info h5 {
        margin: 0;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .chat-header .info p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }

    .chat-box {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        background: #f0f2f5;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .message-container {
        display: flex;
        flex-direction: column;
        max-width: 80%;
    }

    .message {
        padding: 12px 16px;
        border-radius: 18px;
        position: relative;
        word-wrap: break-word;
        line-height: 1.5;
        font-size: 14px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .message.received {
        align-self: flex-start;
        background: white;
        border-top-left-radius: 6px;
        color: #333;
    }

    .message.sent {
        align-self: flex-end;
        background: #79A1BF;
        border-top-right-radius: 6px;
        color: white;
    }

    .message-time {
        font-size: 11px;
        opacity: 0.8;
        margin-top: 4px;
        text-align: right;
    }

    .message.received .message-time {
        text-align: left;
        color: #777;
    }

    .typing-indicator {
        align-self: flex-start;
        background: white;
        border: 1px solid #e0e0e0;
        padding: 12px;
        border-radius: 18px;
        font-size: 13px;
        color: #666;
        display: none;
        max-width: fit-content;
    }

    .product-card {
        max-width: 300px;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        border: 1px solid #eee;
    }

    .product-card img {
        width: 100%;
        height: 140px;
        object-fit: cover;
    }

    .product-card .content {
        padding: 14px;
        text-align: center;
    }

    .product-card .badge {
        background: #79A1BF;
        color: white;
        font-weight: 500;
        padding: 4px 8px;
        border-radius: 12px;
        display: inline-block;
        margin-bottom: 8px;
    }

    .product-card .name {
        font-weight: 600;
        margin-bottom: 4px;
        font-size: 15px;
    }

    .product-card .price {
        color: #e63946;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .product-card .btn-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .chat-input-area {
        background: white;
        padding: 16px;
        border-top: 1px solid #e0e0e0;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .chat-input {
        flex: 1;
        position: relative;
    }

    .chat-input input {
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 24px;
        padding: 12px 20px 12px 50px;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .chat-input input:focus {
        border-color: #79A1BF;
        outline: none;
        box-shadow: 0 0 0 3px rgba(121, 161, 191, 0.2);
    }

    .chat-input .emoji-btn {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #79A1BF;
        cursor: pointer;
        font-size: 1.2rem;
    }

    .chat-actions {
        display: flex;
        gap: 8px;
    }

    .chat-actions button {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .chat-actions button.send {
        background: #79A1BF;
        color: white;
    }

    .chat-actions button:hover {
        transform: scale(1.05);
    }

    .complete-btn-container {
        text-align: center;
        margin-top: 12px;
        padding: 0 20px;
    }

    .complete-btn {
        background: #E7A494;
        color: white;
        border: none;
        border-radius: 24px;
        padding: 8px 24px;
        font-weight: 500;
        transition: all 0.2s;
        box-shadow: 0 2px 6px rgba(231, 164, 148, 0.4);
    }

    .complete-btn:hover {
        background: #e09080;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(231, 164, 148, 0.6);
    }

    /* Responsif untuk mobile */
    @media (max-width: 768px) {
        .chat-container {
            height: calc(100vh - 140px);
            margin: 0 10px;
        }

        .message-container {
            max-width: 90%;
        }
    }
</style>

<div class="chat-container">
    <div class="chat-header">
        <div class="avatar">
            <span>🎁</span>
        </div>
        <div class="info">
            <h5>Konsultasi Kado Personal</h5>
            <p>#<?= $consultation['id'] ?> • Untuk: <?= htmlspecialchars($consultation['recipient']) ?></p>
        </div>
    </div>

    <div class="chat-box" id="chat-box">
        <div class="typing-indicator" id="typingIndicator">Admin sedang mengetik...</div>
        <!-- Pesan akan muncul di sini -->
    </div>

    <form id="chatForm" method="POST" class="chat-input-area">
        <input type="hidden" name="consultation_id" value="<?= $consultation['id'] ?>">
        <div class="chat-input">
            <button type="button" class="emoji-btn" id="emojiBtn">😊</button>
            <input type="text" name="message" placeholder="Tulis pesan..." required>
        </div>
        <div class="chat-actions">
            <button type="submit" class="send">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M22 2L11 13" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </form>

    <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
        <div class="mt-2" style="padding: 0 20px;">
            <select id="adminProductPicker" class="form-select" style="border-radius: 12px; padding: 8px 16px;">
                <option value="">— Rekomendasikan Produk —</option>
                <?php
                // ✅ PERBAIKAN: Ambil produk dengan gambar dari product_images
                $db = DB::getInstance();
                $products = $db->query("
                    SELECT p.id, p.name, p.price, pi.image_path
                    FROM products p
                    LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_main = 1
                    ORDER BY p.name
                ")->fetchAll();
                foreach ($products as $p):
                    $imagePath = $p['image_path'] ?? '';
                    ?>
                    <option value="<?= $p['id'] ?>" data-image="<?= htmlspecialchars($imagePath) ?>">
                        <?= htmlspecialchars($p['name']) ?> - Rp <?= number_format($p['price'], 0, ',', '.') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endif; ?>
</div>

<?php if (($_SESSION['user']['role'] ?? '') !== 'admin'): ?>
    <div class="complete-btn-container">
        <button class="complete-btn" id="completeBtn">
            ✔ Selesai Konsultasi
        </button>
    </div>
<?php endif; ?>

<!-- Emoji Picker Modal -->
<div class="modal fade" id="emojiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Emoji</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-wrap gap-3 justify-content-center p-4" style="font-size: 1.8rem;">
                <?php
                $emojis = ['😊', '👍', '❤️', '🎉', '🤗', '🤩', '🎁', '🙏', '💯', '✨'];
                foreach ($emojis as $emoji):
                    ?>
                    <button class="btn emoji-item" data-emoji="<?= $emoji ?>"><?= $emoji ?></button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Konfigurasi global
    const consultationId = <?= (int) $consultation['id'] ?>;
    const currentUserId = <?= (int) $_SESSION['user']['id'] ?>;
    const isAdmin = <?= (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') ? 'true' : 'false' ?>;

    // Inisialisasi Pusher
    const pusher = new Pusher("5bff370a5bd607d4280f", {
        cluster: "ap1",
        encrypted: true
    });
    const channel = pusher.subscribe("consultation_" + consultationId);

    // Event listeners Pusher
    channel.bind('new_message', function (data) {
        addMessageToChat(data);
        hideTypingIndicator();
    });

    channel.bind('user_typing', function (data) {
        if (data.sender_id != currentUserId && !isAdmin) {
            showTypingIndicator();
            setTimeout(hideTypingIndicator, 3000);
        }
    });

    // Load history pesan
    fetchMessages();

    // Fungsi utility
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function showTypingIndicator() {
        document.getElementById('typingIndicator').style.display = 'block';
    }

    function hideTypingIndicator() {
        document.getElementById('typingIndicator').style.display = 'none';
    }

    function showNotification(message, type = "success") {
        const toast = document.createElement("div");
        toast.className = `toast align-items-center text-white bg-${type === "success" ? "success" : "danger"} border-0`;
        toast.setAttribute("role", "alert");
        toast.setAttribute("aria-live", "assertive");
        toast.setAttribute("aria-atomic", "true");
        toast.style = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 300px;
        `;

        toast.innerHTML = `
            <div class="d-flex w-100">
                <div class="toast-body">${escapeHtml(message)}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;

        document.body.appendChild(toast);
        const bsToast = new bootstrap.Toast(toast, { delay: 3000 });
        bsToast.show();

        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }

    // Fetch pesan lama - ✅ PERBAIKAN UTAMA
    async function fetchMessages() {
        try {
            const response = await fetch(`?page=chat_fetch&id=${consultationId}`);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const messages = await response.json();
            const chatBox = document.getElementById("chat-box");

            // Kosongkan konten lama kecuali typing indicator
            chatBox.innerHTML = '<div class="typing-indicator" id="typingIndicator">Admin sedang mengetik...</div>';

            // Render semua pesan
            messages.forEach(addMessageToChat);

            // Scroll ke bawah
            chatBox.scrollTop = chatBox.scrollHeight;
        } catch (error) {
            console.error('Error fetching messages:', error);
            showNotification("Gagal memuat riwayat chat. Coba refresh halaman.", "danger");
        }
    }

    // Tambah pesan ke chat
    function addMessageToChat(data) {
        const isMe = data.sender_id == currentUserId;
        const msgContainer = document.createElement('div');
        msgContainer.className = `message-container d-flex flex-column ${isMe ? 'align-self-end' : 'align-self-start'}`;

        let contentHTML = '';

        // Handle pesan produk
        if (data.message_type === 'product' && data.product_id) {
            const productName = escapeHtml(data.display_message || data.message);
            const imageUrl = data.product_image || 'https://via.placeholder.com/300x150?text=No+Image';
            const price = data.product_price ? `Rp ${Number(data.product_price).toLocaleString('id-ID')}` : 'Harga tidak tersedia';

            contentHTML = `
        <div class="product-card">
            <img src="${imageUrl}" alt="${productName}" onerror="this.src='https://via.placeholder.com/300x150?text=Product+Image'">
            <div class="content">
                <div class="badge">🎁 Rekomendasi Kado</div>
                <div class="name">${productName}</div>
                <div class="price">${price}</div>
                <div class="btn-group">
                    <button class="btn btn-sm add-to-cart-btn" 
                            data-product-id="${escapeHtml(data.product_id)}"
                            style="background-color: #79A1BF; color: white; border-radius: 8px;">
                        ➕ Tambah ke Keranjang
                    </button>
                    <a href="?page=product_detail&id=${escapeHtml(data.product_id)}" 
                       class="btn btn-sm btn-outline-primary" 
                       style="border-radius: 8px;">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        <div class="message-time" style="text-align: ${isMe ? 'right' : 'left'}; margin-top: 4px; font-size: 11px;">
            ${isMe ? 'Anda' : escapeHtml(data.name)} • ${escapeHtml(data.time)}
        </div>
        `;
        } else {
            // Pesan teks biasa
            const bgClass = isMe ? 'sent' : 'received';
            const messageText = data.display_message || data.message || '';
            contentHTML = `
        <div class="message ${bgClass}">
            ${escapeHtml(messageText).replace(/\n/g, '<br>')}
            <div class="message-time">${escapeHtml(data.time)}</div>
        </div>
        `;
        }

        msgContainer.innerHTML = contentHTML;
        document.getElementById("chat-box").appendChild(msgContainer);
    }

    // Event delegation
    document.getElementById("chat-box").addEventListener("click", function (e) {
        if (e.target.classList.contains("add-to-cart-btn")) {
            const productId = e.target.getAttribute("data-product-id");
            addToCart(productId, e.target);
        }
    });

    // Tambah ke keranjang
    async function addToCart(productId, button) {
        const originalText = button.innerHTML;
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span>';
        button.disabled = true;

        try {
            const response = await fetch("?page=add_to_cart_ajax", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id: productId })
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.error || "Gagal menambahkan produk");
            }

            showNotification(`✅ ${data.message}`);
        } catch (error) {
            console.error('Error:', error);
            showNotification(`❌ ${error.message}`, "danger");
        } finally {
            button.innerHTML = originalText;
            button.disabled = false;
        }
    }

    // Kirim pesan - ✅ HINDARI DUPLIKAT
    document.getElementById("chatForm").addEventListener("submit", async function (e) {
        e.preventDefault();

        const messageInput = this.message;
        const message = messageInput.value.trim();
        if (!message) return;

        // Simpan nilai asli
        const originalMessage = message;

        try {
            const formData = new FormData();
            formData.append('consultation_id', consultationId);
            formData.append('message', message);

            // Nonaktifkan input sementara
            messageInput.disabled = true;
            const submitBtn = this.querySelector('.send');
            const originalBtnHtml = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span>';
            submitBtn.disabled = true;

            const response = await fetch("?page=chat_send", {
                method: "POST",
                body: formData
            });

            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw new Error(errorData.error || `Gagal mengirim pesan`);
            }

            // Reset form
            messageInput.value = "";
        } catch (error) {
            console.error('Error sending message:', error);
            showNotification(`❌ ${error.message}`, "danger");
            messageInput.value = originalMessage; // Kembalikan pesan
        } finally {
            // Aktifkan kembali input
            messageInput.disabled = false;
            const submitBtn = this.querySelector('.send');
            submitBtn.innerHTML = originalBtnHtml;
            submitBtn.disabled = false;
            messageInput.focus();
        }
    });

    // Emoji picker
    document.getElementById('emojiBtn').addEventListener('click', function () {
        const modal = new bootstrap.Modal(document.getElementById('emojiModal'));
        modal.show();
    });

    document.querySelectorAll('.emoji-item').forEach(btn => {
        btn.addEventListener('click', function () {
            const emoji = this.getAttribute('data-emoji');
            const input = document.querySelector('input[name="message"]');
            input.value += emoji;
            input.focus();
            bootstrap.Modal.getInstance(document.getElementById('emojiModal')).hide();
        });
    });

    // Admin product picker - pastikan kirim sebagai produk
    document.getElementById('adminProductPicker').addEventListener('change', async function () {
        if (!this.value) return;

        const productId = this.value;
        const originalText = this.options[this.selectedIndex].text;

        try {
            // Nonaktifkan sementara
            this.disabled = true;
            this.options[this.selectedIndex].text = ' Mengirim...';

            // Kirim sebagai format produk
            const response = await fetch("?page=chat_send", {
                method: "POST",
                body: new URLSearchParams({
                    consultation_id: consultationId,
                    message: `!produk:${productId}`
                })
            });

            if (!response.ok) throw new Error('Gagal mengirim');

            showNotification(`✅ ${originalText} berhasil dikirim!`);
        } catch (error) {
            console.error('Error:', error);
            showNotification(`❌ ${error.message}`, "danger");
        } finally {
            this.selectedIndex = 0;
            this.options[this.selectedIndex].text = originalText;
            this.disabled = false;
        }
    });

    // Tombol selesai
    <?php if (($_SESSION['user']['role'] ?? '') !== 'admin'): ?>
        document.getElementById('completeBtn').addEventListener('click', function () {
            if (confirm('Apakah Anda yakin ingin menyelesaikan konsultasi ini? Anda bisa lanjut ke keranjang untuk checkout.')) {
                window.location.href = `?page=complete_consultation&id=<?= $consultation['id'] ?>`;
            }
        });
    <?php endif; ?>
</script>