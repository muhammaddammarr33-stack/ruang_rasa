<?php
require_once __DIR__ . '/../models/Consultation.php';
require_once __DIR__ . '/../models/ConsultationSuggestion.php';
require_once __DIR__ . '/../models/ConsultationFeedback.php';
require_once __DIR__ . '/../models/DB.php';

class ConsultationController
{
    private $consultation;
    private $suggestion;
    private $feedback;

    public function __construct()
    {
        $this->consultation = new Consultation();
        $this->suggestion = new ConsultationSuggestion();
        $this->feedback = new ConsultationFeedback();
    }

    public function form()
    {
        include __DIR__ . '/../views/consultations/form.php';
    }

    public function create()
    {
        $userId = $_SESSION['user']['id'];
        $this->consultation->create($userId, $_POST['topic'], $_POST['budget'], $_POST['preference']);
        $_SESSION['success'] = "Konsultasi berhasil dikirim!";
        header("Location: ?page=consultations");
    }

    public function list()
    {
        $user = $_SESSION['user'];
        $consultations = ($user['role'] === 'admin')
            ? $this->consultation->getAll()
            : $this->consultation->getByUser($user['id']);
        include __DIR__ . '/../views/consultations/list.php';
    }

    public function suggestForm()
    {
        $consultationId = $_GET['id'];
        $db = DB::getInstance();
        $products = $db->query("SELECT id, name, price FROM products")->fetchAll();
        include __DIR__ . '/../views/consultations/suggest.php';
    }

    public function saveSuggestion()
    {
        $this->suggestion->create($_GET['id'], $_POST['product_id'], $_POST['reason']);
        $this->consultation->updateStatus($_GET['id'], 'suggested');
        $_SESSION['success'] = "Rekomendasi berhasil disimpan!";
        header("Location: ?page=admin_consultations");
    }

    public function feedbackForm()
    {
        include __DIR__ . '/../views/consultations/feedback.php';
    }

    public function submitFeedback()
    {
        $consultationId = $_GET['id'];
        $satisfaction = $_POST['satisfaction'];
        $followUp = ($satisfaction === 'unsatisfied') ? 1 : 0;
        $whatsapp = ($followUp) ? 'https://wa.me/628123456789?text=Halo%20saya%20ingin%20konsultasi%20lanjutan' : null;

        $this->feedback->create($consultationId, $satisfaction, $followUp, $whatsapp);
        $newStatus = ($satisfaction === 'satisfied') ? 'completed' : 'redirected';
        $this->consultation->updateStatus($consultationId, $newStatus);

        if ($followUp) {
            header("Location: $whatsapp");
            exit;
        } else {
            $_SESSION['success'] = "Terima kasih atas feedback Anda!";
            header("Location: ?page=consultations");
        }
    }
}
