<?php
require_once __DIR__ . '/../models/Consultation.php';
require_once __DIR__ . '/../models/ConsultationSuggestion.php';
require_once __DIR__ . '/../models/ConsultationFeedback.php';

class ConsultationController
{
    private $db, $cons, $suggest, $feedback;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        // ✅ Set timezone WIB sekali di sini
        date_default_timezone_set('Asia/Jakarta');

        $this->db = DB::getInstance(); // 👈 tambahkan ini
        $this->cons = new Consultation();
        $this->suggest = new ConsultationSuggestion();
        $this->feedback = new ConsultationFeedback();
    }

    public function form()
    {
        include __DIR__ . '/../views/consultations/form.php';
    }

    public function create()
    {
        $userId = $_SESSION['user']['id'];

        $recipient = $_POST['recipient'];
        $occasion = $_POST['occasion'];
        $age_range = $_POST['age_range'];
        $interests = isset($_POST['interests']) ? json_encode($_POST['interests'], JSON_UNESCAPED_UNICODE) : '[]';
        $budget_range = $_POST['budget_range'];

        $sql = "INSERT INTO consultations 
                (user_id, recipient, occasion, age_range, interests, budget_range, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, 'submitted', NOW())";
        $this->db->prepare($sql)->execute([
            $userId,
            $recipient,
            $occasion,
            $age_range,
            $interests,
            $budget_range
        ]);

        $consultationId = $this->db->lastInsertId();

        $preferenceText = trim("$recipient $occasion $age_range " . implode(' ', json_decode($interests)));
        $this->suggest->autoSuggest($consultationId, $budget_range, $preferenceText);
        $this->cons->updateStatus($consultationId, 'suggested');

        $_SESSION['success'] = "Rekomendasi kado telah dibuat!";
        header("Location: ?page=consultations");
        exit;
    }


    public function list()
    {
        $u = $_SESSION['user'];
        $consultations = $this->cons->getByUser($u['id']);
        include __DIR__ . '/../views/consultations/list.php';
    }

    public function feedbackForm()
    {
        $id = $_GET['id'];
        $consultation = $this->cons->find($id);
        $suggestions = $this->suggest->getByConsultation($id);
        include __DIR__ . '/../views/consultations/feedback.php';
    }

    public function submitFeedback()
    {
        $id = $_GET['id'];
        $satisfaction = $_POST['satisfaction'];
        $followUp = ($satisfaction === 'unsatisfied');

        // Simpan feedback tanpa WhatsApp
        $this->feedback->create($id, $satisfaction, $followUp ? 1 : 0);

        if ($followUp) {
            // Jika tidak puas → lanjut ke chat
            $this->cons->updateStatus($id, 'in_progress');
            header("Location: ?page=consultation_chat&id=$id");
        } else {
            $this->cons->updateStatus($id, 'completed');
            $_SESSION['success'] = "Terima kasih atas feedback!";
            header("Location: ?page=consultations");
        }
        exit;
    }

    public function chatPage()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $consultationId = $_GET['id'] ?? null;
        if (!$consultationId || !isset($_SESSION['user'])) {
            header('Location: ?page=dashboard');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $isAdmin = ($_SESSION['user']['role'] ?? '') === 'admin';
        $db = DB::getInstance();

        if ($isAdmin) {
            // Admin bisa akses semua konsultasi
            $stmt = $db->prepare("
            SELECT c.*, u.name as user_name 
            FROM consultations c
            JOIN users u ON u.id = c.user_id
            WHERE c.id = ?
        ");
            $stmt->execute([$consultationId]);
        } else {
            // User biasa hanya bisa akses miliknya
            $stmt = $db->prepare("
            SELECT c.*, u.name as user_name 
            FROM consultations c
            JOIN users u ON u.id = c.user_id
            WHERE c.id = ? AND c.user_id = ?
        ");
            $stmt->execute([$consultationId, $userId]);
        }

        $consultation = $stmt->fetch();

        if (!$consultation) {
            die('Konsultasi tidak ditemukan atau tidak berhak mengakses.');
        }

        // Jika status masih 'submitted', ubah jadi 'in_progress'
        if ($consultation['status'] === 'submitted') {
            $db->prepare("UPDATE consultations SET status = 'in_progress' WHERE id = ?")
                ->execute([$consultationId]);
            $consultation['status'] = 'in_progress';
        }

        // Setelah validasi consultation
        $this->db->prepare("UPDATE consultations SET last_read_at = NOW() WHERE id = ?")
            ->execute([$consultationId]);

        require_once __DIR__ . '/../views/consultations/chat.php';
    }

    public function startDirectChat()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: ?page=login");
            exit;
        }

        $userId = $_SESSION['user']['id'];

        // Cek: apakah ada konsultasi yang BELUM SELESAI (submitted, suggested, in_progress)
        $stmt = $this->db->prepare("
        SELECT id FROM consultations 
        WHERE user_id = ? AND status != 'completed'
        ORDER BY created_at DESC LIMIT 1
    ");
        $stmt->execute([$userId]);
        $active = $stmt->fetch();

        if ($active) {
            // Lanjutkan yang belum selesai
            header("Location: ?page=consultation_chat&id=" . $active['id']);
        } else {
            // Buat baru
            $sql = "INSERT INTO consultations 
                (user_id, recipient, occasion, age_range, interests, budget_range, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, 'submitted', NOW())";
            $this->db->prepare($sql)->execute([
                $userId,
                'Konsultasi Langsung',
                'Tanpa Acara',
                '',
                '[]',
                ''
            ]);
            $consultationId = $this->db->lastInsertId();
            header("Location: ?page=consultation_chat&id=$consultationId");
        }
        exit;
    }

    public function completeConsultation()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if (!isset($_SESSION['user'])) {
            header("Location: ?page=login");
            exit;
        }

        $consultationId = $_GET['id'] ?? null;
        if (!$consultationId) {
            header("Location: ?page=consultations");
            exit;
        }

        $userId = $_SESSION['user']['id'];

        // Pastikan ini konsultasi milik user
        $stmt = $this->db->prepare("SELECT id FROM consultations WHERE id = ? AND user_id = ?");
        $stmt->execute([$consultationId, $userId]);
        if (!$stmt->fetch()) {
            $_SESSION['error'] = "Akses ditolak.";
            header("Location: ?page=consultations");
            exit;
        }

        // Update status jadi completed
        $this->db->prepare("UPDATE consultations SET status = 'completed' WHERE id = ?")
            ->execute([$consultationId]);

        $_SESSION['success'] = "✅ Konsultasi selesai! Silakan lanjut ke keranjang untuk checkout.";
        header("Location: ?page=cart");
        exit;
    }

}
