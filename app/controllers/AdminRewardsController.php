<?php
// app/controllers/AdminRewardsController.php
require_once __DIR__ . '/../models/Rewards.php';

class AdminRewardsController
{
    private $model;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: ?page=login");
            exit;
        }
        $this->model = new Rewards();
    }

    public function index()
    {
        $rewards = $this->model->all();
        include __DIR__ . '/../views/admin/rewards/index.php';
    }

    public function form()
    {
        $reward = null;
        if (!empty($_GET['id'])) {
            $reward = $this->model->find((int) $_GET['id']);
        }
        include __DIR__ . '/../views/admin/rewards/form.php';
    }

    public function store()
    {
        $name = trim($_POST['name'] ?? '');
        $points_required = (int) ($_POST['points_required'] ?? 0);
        $description = trim($_POST['description'] ?? '');

        if (!$name) {
            $_SESSION['error'] = "Nama reward wajib diisi.";
            header("Location: ?page=admin_rewards_form");
            exit;
        }

        $this->model->create([
            'name' => $name,
            'points_required' => $points_required,
            'description' => $description
        ]);

        $_SESSION['success'] = "Reward berhasil dibuat.";
        header("Location: ?page=admin_rewards");
    }

    public function update()
    {
        $id = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $points_required = (int) ($_POST['points_required'] ?? 0);
        $description = trim($_POST['description'] ?? '');

        if (!$id || !$name) {
            $_SESSION['error'] = "Input tidak valid.";
            header("Location: ?page=admin_rewards");
            exit;
        }

        $this->model->update($id, [
            'name' => $name,
            'points_required' => $points_required,
            'description' => $description
        ]);

        $_SESSION['success'] = "Reward berhasil diupdate.";
        header("Location: ?page=admin_rewards");
    }

    public function destroy()
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id) {
            $this->model->delete($id);
            $_SESSION['success'] = "Reward dihapus.";
        }
        header("Location: ?page=admin_rewards");
    }
}
