<?php
require_once __DIR__ . '/DB.php';

class Memberships
{
    private $db;
    private $tiers = [
        'basic' => 0,
        'silver' => 2000,
        'gold' => 10000,
        'platinum' => 30000
    ];

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function ensureMembership($userId)
    {
        if (!is_numeric($userId) || $userId <= 0)
            return false;

        $stmt = $this->db->prepare("SELECT id FROM memberships WHERE user_id = ?");
        $stmt->execute([$userId]);
        if (!$stmt->fetch()) {
            $stmt2 = $this->db->prepare("
                INSERT INTO memberships (user_id, tier, points, updated_at)
                VALUES (?, 'basic', 0, NOW())
            ");
            return $stmt2->execute([$userId]);
        }
        return true;
    }

    public function get($userId)
    {
        if (!is_numeric($userId) || $userId <= 0)
            return false;

        $stmt = $this->db->prepare("SELECT * FROM memberships WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addPoints($userId, $points)
    {
        $points = max(0, (int) $points);
        if (!$this->ensureMembership($userId))
            return false;

        $stmt = $this->db->prepare("
            UPDATE memberships
            SET points = points + ?, updated_at = NOW()
            WHERE user_id = ?
        ");
        $result = $stmt->execute([$points, $userId]);
        if ($result)
            $this->recalculateTier($userId);
        return $result;
    }

    public function deductPoints($userId, $points)
    {
        $points = max(0, (int) $points);
        if (!$this->ensureMembership($userId))
            return false;

        $stmt = $this->db->prepare("
            UPDATE memberships
            SET points = GREATEST(points - ?, 0), updated_at = NOW()
            WHERE user_id = ?
        ");
        $result = $stmt->execute([$points, $userId]);
        if ($result)
            $this->recalculateTier($userId);
        return $result;
    }

    public function recalculateTier($userId)
    {
        $data = $this->get($userId);
        if (!$data)
            return;

        $points = (int) $data['points'];
        $newTier = 'basic';

        // Urutkan tier dari tertinggi
        $tiersSorted = $this->tiers;
        arsort($tiersSorted);

        foreach ($tiersSorted as $tier => $minPoints) {
            if ($points >= $minPoints) {
                $newTier = $tier;
                break;
            }
        }

        if ($newTier !== $data['tier']) {
            $stmt = $this->db->prepare("
                UPDATE memberships
                SET tier = ?, updated_at = NOW()
                WHERE user_id = ?
            ");
            $stmt->execute([$newTier, $userId]);
        }
    }

    public function redeemReward($userId, $rewardId)
    {
        // Validasi dasar
        if (
            !is_numeric($userId) || $userId <= 0 ||
            !is_numeric($rewardId) || $rewardId <= 0
        ) {
            return ['error' => 'ID tidak valid'];
        }

        $this->ensureMembership($userId);

        // Mulai transaksi
        $this->db->beginTransaction();
        try {
            // Ambil reward dengan lock
            $stmt = $this->db->prepare("
                SELECT * FROM rewards 
                WHERE id = ? AND deleted_at IS NULL
                FOR UPDATE
            ");
            $stmt->execute([$rewardId]);
            $reward = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$reward) {
                throw new Exception('Reward tidak tersedia');
            }

            // Cek cooldown (5 menit)
            $lastRedeem = $this->db->prepare("
                SELECT redeemed_at FROM reward_redemptions 
                WHERE user_id = ? 
                ORDER BY redeemed_at DESC 
                LIMIT 1
            ");
            $lastRedeem->execute([$userId]);
            $last = $lastRedeem->fetch();

            if ($last && strtotime($last['redeemed_at']) > time() - 300) {
                throw new Exception("Silakan tunggu 5 menit sebelum redeem lagi");
            }

            // Ambil data membership dengan lock
            $memStmt = $this->db->prepare("
                SELECT points FROM memberships 
                WHERE user_id = ? 
                FOR UPDATE
            ");
            $memStmt->execute([$userId]);
            $membership = $memStmt->fetch(PDO::FETCH_ASSOC);

            if (!$membership || $membership['points'] < $reward['points_required']) {
                throw new Exception('Poin tidak cukup');
            }

            // Deduct points
            $this->deductPoints($userId, $reward['points_required']);

            // Buat record redeem
            $stmt2 = $this->db->prepare("
                INSERT INTO reward_redemptions (user_id, reward_id, redeemed_at)
                VALUES (?,?,NOW())
            ");
            $stmt2->execute([$userId, $rewardId]);

            // Kirim notifikasi ke admin
            $this->sendAdminNotification($userId, $reward['name']);

            $this->db->commit();
            return ['success' => true];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['error' => $e->getMessage()];
        }
    }

    private function sendAdminNotification($userId, $rewardName)
    {
        $adminStmt = $this->db->prepare("
            SELECT id FROM users WHERE role = 'admin' LIMIT 1
        ");
        $adminStmt->execute();
        $admin = $adminStmt->fetch();

        if ($admin) {
            $notifStmt = $this->db->prepare("
                INSERT INTO notifications (user_id, message, is_read, created_at)
                VALUES (?, ?, 0, NOW())
            ");
            $message = "User ID $userId baru saja redeem: $rewardName";
            $notifStmt->execute([$admin['id'], $message]);
        }
    }
}