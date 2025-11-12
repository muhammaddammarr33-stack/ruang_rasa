<?php
// app/controllers/ProfileController.php
// require_once __DIR__ . '/../models/User.php';
// require_once __DIR__ . '/../helpers/SecurityHelper.php';

// class ProfileController
// {
//     private $userModel;
//     public function __construct()
//     {
//         $this->userModel = new User();
//         if (session_status() === PHP_SESSION_NONE)
//             session_start();
//         SecurityHelper::startCsrf();
//     }

//     public function index()
//     {
//         if (!isset($_SESSION['user']))
//             header("Location: ?page=login");
//         $user = $this->userModel->findById($_SESSION['user']['id']);
//         include __DIR__ . '/../views/profile/index.php';
//     }

//     public function update()
//     {
//         try {
//             if (!SecurityHelper::checkCsrf($_POST['csrf_token'] ?? ''))
//                 throw new Exception("Invalid CSRF token");
//             $userId = $_SESSION['user']['id'];
//             $name = SecurityHelper::sanitize($_POST['name'] ?? '');
//             $phone = SecurityHelper::sanitize($_POST['phone'] ?? '');
//             $address = SecurityHelper::sanitize($_POST['address'] ?? '');

//             $profileImage = null;
//             if (!empty($_FILES['profile_image']['tmp_name'])) {
//                 $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
//                 $allow = ['jpg', 'jpeg', 'png', 'gif'];
//                 if (!in_array(strtolower($ext), $allow))
//                     throw new Exception("Format gambar tidak diizinkan.");
//                 $filename = 'profile_' . $userId . '_' . time() . '.' . $ext;
//                 $dst = __DIR__ . '/../../public/uploads/profile/' . $filename;
//                 if (!is_dir(dirname($dst)))
//                     mkdir(dirname($dst), 0755, true);
//                 move_uploaded_file($_FILES['profile_image']['tmp_name'], $dst);
//                 $profileImage = 'uploads/profile/' . $filename;
//             }

//             $this->userModel->updateProfile($userId, $name, $phone, $address, $profileImage);
//             // refresh session
//             $_SESSION['user'] = $this->userModel->findById($userId);
//             $_SESSION['success'] = "Profil berhasil diperbarui.";
//             header("Location: ?page=profile");
//         } catch (Exception $e) {
//             $_SESSION['error'] = $e->getMessage();
//             header("Location: ?page=profile");
//         }
//     }
// }
