<?php
// app/models/Memberships.php
require_once __DIR__ . '/DB.php';

class Memberships
{
    private $db;

    private $tiers = [
        'basic' => 0,
        'silver' => 2000,     // contoh: total poin ≥ 2000
        'gold' => 10000,      // contoh: total poin ≥ 10000
        'platinum' => 30000   // contoh: total poin ≥ 30000
    ];

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    /* ---------------------------------------------------
     * CREATE MEMBERSHIP RECORD IF NOT EXISTS
     * --------------------------------------------------- */
    public function ensureMembership($userId)
    {
        $stmt = $this->db->prepare("SELECT id FROM memberships WHERE user_id = ?");
        $stmt->execute([$userId]);

        if (!$stmt->fetch()) {
            $stmt2 = $this->db->prepare("
                INSERT INTO memberships (user_id, tier, points, updated_at)
                VALUES (?, 'basic', 0, NOW())
            ");
            $stmt2->execute([$userId]);
        }
    }

    /* ---------------------------------------------------
     * GET USER MEMBERSHIP
     * --------------------------------------------------- */
    public function get($userId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM memberships WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* ---------------------------------------------------
     * ADD POINTS (AFTER PAYMENT SUCCESS)
     * --------------------------------------------------- */
    public function addPoints($userId, $points)
    {
        $points = (int) $points;
        $this->ensureMembership($userId);

        $stmt = $this->db->prepare("
            UPDATE memberships
            SET points = points + ?, updated_at = NOW()
            WHERE user_id = ?
        ");
        $stmt->execute([$points, $userId]);

        $this->recalculateTier($userId);
    }

    /* ---------------------------------------------------
     * DEDUCT POINTS (REDEEM OR DISCOUNT)
     * --------------------------------------------------- */
    public function deductPoints($userId, $points)
    {
        $points = (int) $points;
        $this->ensureMembership($userId);

        $stmt = $this->db->prepare("
            UPDATE memberships
            SET points = GREATEST(points - ?, 0), updated_at = NOW()
            WHERE user_id = ?
        ");
        $stmt->execute([$points, $userId]);

        $this->recalculateTier($userId);
    }

    /* ---------------------------------------------------
     * AUTO TIER CALCULATION (BASED ON POINTS)
     * --------------------------------------------------- */
    public function recalculateTier($userId)
    {
        $data = $this->get($userId);
        if (!$data)
            return;

        $points = $data['points'];
        $newTier = 'basic';

        // looping tier dari terbesar
        foreach (array_reverse($this->tiers, true) as $tier => $minPoints) {
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

    /* ---------------------------------------------------
     * REDEEM REWARD (POINT → REWARD)
     * --------------------------------------------------- */
    public function redeemReward($userId, $rewardId)
    {
        $this->ensureMembership($userId);

        // get reward
        $stmt = $this->db->prepare("SELECT * FROM rewards WHERE id = ?");
        $stmt->execute([$rewardId]);
        $reward = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reward)
            return ['error' => 'Reward tidak ditemukan'];

        // get user points
        $membership = $this->get($userId);

        if ($membership['points'] < $reward['points_required'])
            return ['error' => 'Poin tidak cukup'];

        // deduct points
        $this->deductPoints($userId, $reward['points_required']);

        // create redemption record
        $stmt2 = $this->db->prepare("
            INSERT INTO reward_redemptions (user_id, reward_id, redeemed_at)
            VALUES (?,?,NOW())
        ");
        $stmt2->execute([$userId, $rewardId]);

        return ['success' => true];
    }
}
