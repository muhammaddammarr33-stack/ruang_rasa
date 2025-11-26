<?php
require_once __DIR__ . '/../models/Consultation.php';
require_once __DIR__ . '/../models/ConsultationSuggestion.php';
require_once __DIR__ . '/../models/ConsultationFeedback.php';
require_once __DIR__ . '/../models/DB.php';

class AdminConsultationController
{
    private $cons, $suggest, $feedback;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }

        $this->cons = new Consultation();
        $this->suggest = new ConsultationSuggestion();
        $this->feedback = new ConsultationFeedback();
    }

    public function index()
    {
        $consultations = $this->cons->getAll();
        include __DIR__ . '/../views/admin/consultations/index.php';
    }

    public function detail()
    {
        $id = $_GET['id'];
        $consultation = $this->cons->find($id);
        $suggestions = $this->suggest->getByConsultation($id);
        $feedback = $this->feedback->getByConsultation($id);

        include __DIR__ . '/../views/admin/consultations/detail.php';
    }

    /* =========================
       AUTO AI SUGGESTION
       ========================= */
    public function aiSuggest()
    {
        $id = $_GET['id'];
        $consultation = $this->cons->find($id); // Ambil SEMUA kolom

        $result = $this->suggest->autoSuggest($id, $consultation);
        $this->cons->updateStatus($id, 'suggested');

        $_SESSION['success'] = "✅ Rekomendasi AI berhasil dibuat!";
        header("Location: ?page=admin_consultation_detail&id=$id");
        exit;
    }

    /* =========================
       SAVE MANUAL SUGGESTION
       ========================= */
    public function suggestForm()
    {
        $id = $_GET['id'];

        // FIX PENTING!
        $consultationId = $id;

        $db = DB::getInstance();
        $products = $db->query("SELECT id,name,price FROM products")->fetchAll();

        include __DIR__ . '/../views/consultations/suggest.php';
    }


    public function saveSuggestion()
    {
        $id = $_GET['id'];
        $this->suggest->create($id, $_POST['product_id'], $_POST['reason']);
        $this->cons->updateStatus($id, 'suggested');

        $_SESSION['success'] = "Rekomendasi manual disimpan!";
        header("Location: ?page=admin_consultation_detail&id=$id");
    }

    /* =========================
       MARK AS DONE
       ========================= */
    public function markDone()
    {
        $id = $_GET['id'];
        $this->cons->updateStatus($id, 'completed');

        $_SESSION['success'] = "Konsultasi ditandai selesai.";
        header("Location: ?page=admin_consultation_detail&id=$id");
    }

}
