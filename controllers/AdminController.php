<?php
// controllers/AdminController.php
declare(strict_types=1);

require_once __DIR__ . '/../models/Admin.php';

class AdminController
{
    public static function attemptLogin(PDO $pdo, string $username, string $password): bool
    {
        $admin = Admin::findByUsername($pdo, $username);
        if (!$admin) return false;
        if (!password_verify($password, $admin['password_hash'])) return false;
        // valid
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int)$admin['id'];
        $_SESSION['admin_user'] = $admin['username'];
        $_SESSION['admin_last_activity'] = time();
        return true;
    }

    public static function requireAuth(): void
    {
        $timeout = 60 * 60; // 1 hour
        if (empty($_SESSION['admin_id'])) {
            header('Location: login.php');
            exit;
        }
        if (isset($_SESSION['admin_last_activity']) && (time() - $_SESSION['admin_last_activity']) > $timeout) {
            // timeout
            session_unset(); session_destroy();
            header('Location: login.php'); exit;
        }
        $_SESSION['admin_last_activity'] = time();
    }
}
