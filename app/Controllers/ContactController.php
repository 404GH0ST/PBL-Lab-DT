<?php

namespace App\Controllers;

use Core\Controller;
use Core\Mailer;
use App\Models\Contact;

class ContactController extends Controller
{
    private $contactModel;
    private $mailer;

    public function __construct()
    {
        $this->contactModel = $this->loadModel(Contact::class);
        $this->mailer = new Mailer();
    }

    public function index()
    {
        return $this->view('contact', [
            'title' => 'Contact Us - Lab Data Technology',
            'layout' => 'layouts/main',
            'pageTitle' => 'Hubungi Kami'
        ]);
    }

    public function send()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $organization = $_POST['organization'];
        $message = $_POST['message'] ?? '-';

        // Embed Image
        // Assuming path is relative to public/ or absolute path in system
        $logoPath = __DIR__ . '/../../public/assets/images/dt-logo-white.png';
        $cid = 'logo_dt';

        if (file_exists($logoPath)) {
            $this->mailer->addEmbeddedImage($logoPath, $cid);
        }

        // Kirim email ke owner
        $this->mailer->send(
            "lab.datatech@gmail.com",
            "Pesan Kontak Baru - $name",
            $this->templateOwner($name, $email, $organization, $message, $cid)
        );

        // Reset mailer addresses (not strictly needed if send() clears them, but safest)
        // Re-embed image for second email
        if (file_exists($logoPath)) {
            $this->mailer->addEmbeddedImage($logoPath, $cid);
        }

        // Kirim copy ke user
        $this->mailer->send(
            $email,
            "Terima kasih telah menghubungi kami!",
            $this->templateUser($name, $organization, $message, $cid)
        );

        // Redirect atau return response
        $_SESSION['flash_success'] = 'Pesan berhasil dikirim!';
        header("Location: /contact"); // Redirect back to contact page
        exit();
    }

    private function templateOwner($name, $email, $organization, $message, $cid)
    {
        return "
    <div style='font-family: Arial, sans-serif; background: #f7f9fb; padding: 30px;'>
        <div style='max-width:600px; margin: auto; background: #ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.05);'>
            
            <div style='background:#7ABA54; padding:20px; text-align:center; color:white;'>
                <img src='cid:$cid' alt='Logo' style='margin-bottom:10px; height: 50px;'>
                <h2 style='margin:0; font-size:22px;'>Pesan Kontak Baru</h2>
            </div>

            <div style='padding:25px; color:#333;'>
                <p><strong>Nama:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Organisasi:</strong> $organization</p>
                <p><strong>Pesan:</strong><br>$message</p>
            </div>

            <div style='background:#f1f3f7; padding:15px; text-align:center; font-size:12px; color:#777;'>
                Ini adalah notifikasi otomatis dari sistem Lab Data Technology.
            </div>
        </div>
    </div>
    ";
    }

    private function templateUser($name, $organization, $message, $cid)
    {
        return "
    <div style='font-family: Arial, sans-serif; background:#f9fafc; padding:30px;'>
        <div style='max-width:600px; margin:auto; background:white; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.05);'>
            
            <div style='background:#7ABA54; padding:20px 20px 25px; text-align:center; color:white;'>
                <img src='cid:$cid' alt='Logo' style='margin-bottom:10px; height: 50px;'>
                <h2 style='margin:0; font-size:22px;'>Terima Kasih!</h2>
            </div>

            <div style='padding:25px; color:#333;'>
                <p>Halo <strong>$name</strong>,</p>
                <p>Terima kasih telah menghubungi kami! Berikut adalah salinan pesan yang Anda kirim:</p>

                <p><strong>Organisasi:</strong> $organization</p>
                <p><strong>Pesan:</strong><br>$message</p>

                <br>
                <a href='http://localhost:8001' style='display:inline-block; padding:12px 20px; background:#7ABA54; color:white; text-decoration:none; border-radius:8px;'>
                    Kunjungi Website Kami
                </a>

                <br><br>
                <p style='color:#666;'>Kami akan segera membalas pesan Anda.</p>
            </div>

            <div style='background:#f1f3f7; padding:15px; text-align:center; font-size:12px; color:#777;'>
                © " . date('Y') . " Lab Data Technology. All rights reserved.
            </div>

        </div>
    </div>
    ";
    }
}