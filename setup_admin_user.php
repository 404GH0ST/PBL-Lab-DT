<?php

require_once __DIR__ . '/vendor/autoload.php';

use Core\Application;

// Initialize Application to load config
$app = new Application(__DIR__);

try {
    $pdo = $app->database()->getConnection();

    $username = "admin";
    $password = password_hash("admin", PASSWORD_DEFAULT);
    $role = "admin";
    $bio = "admin_dt";
    $nama_lengkap = "Admin";
    $email = "admin_dt@local.com";
    $nip_nim = "123456789";
    $foto_profil = "default_profil.png";
    $status_aktif = true;

    $stmt = $pdo->prepare("INSERT INTO anggota (username, password, role, nama_lengkap, email, nip_nim, foto_profil, status_aktif) VALUES (:username, :password, :role, :nama_lengkap, :email, :nip_nim, :foto_profil, :status_aktif)");
    $stmt->execute([
        'username' => $username,
        'password' => $password,
        'role' => $role,
        'nama_lengkap' => $nama_lengkap,
        'email' => $email,
        'nip_nim' => $nip_nim,
        'foto_profil' => $foto_profil,
        'status_aktif' => $status_aktif
    ]);

    echo "Admin user created successfully!\n";

    // for operator
    $username = "operator";
    $password = password_hash("operator", PASSWORD_DEFAULT);
    $role = "operator";
    $bio = "operator_dt";
    $nama_lengkap = "Operator";
    $email = "operator_dt@local.com";
    $nip_nim = "123456789";
    $foto_profil = "default_profil.png";
    $status_aktif = true;

    $stmt = $pdo->prepare("INSERT INTO anggota (username, password, role, nama_lengkap, email, nip_nim, foto_profil, status_aktif) VALUES (:username, :password, :role, :nama_lengkap, :email, :nip_nim, :foto_profil, :status_aktif)");
    $stmt->execute([
        'username' => $username,
        'password' => $password,
        'role' => $role,
        'nama_lengkap' => $nama_lengkap,
        'email' => $email,
        'nip_nim' => $nip_nim,
        'foto_profil' => $foto_profil,
        'status_aktif' => $status_aktif
    ]);

    echo "Operator user created successfully!\n";

} catch (\PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
