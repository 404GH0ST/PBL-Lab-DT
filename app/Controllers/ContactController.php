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

        // Kirim email ke owner
        $this->mailer->send(
            "lab.datatech@gmail.com",
            "New Contact Message",
            $this->templateOwner($name, $email, $organization, $message)
        );

        // Kirim copy ke user
        $this->mailer->send(
            $email,
            "Thanks for reaching out!",
            $this->templateUser($name, $organization, $message)
        );

        // Redirect atau return response
        $_SESSION['flash_success'] = 'Message sent successfully!';
        header("Location: /contact"); // Redirect back to contact page
        exit();
    }

    private function templateOwner($name, $email, $organization, $message)
    {
        return "
    <div style='font-family: Arial, sans-serif; background: #f7f9fb; padding: 30px;'>
        <div style='max-width:600px; margin: auto; background: #ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.05);'>
            
            <div style='background:#4a6cf7; padding:20px; text-align:center; color:white;'>
                <img src='/assets/images/jti.png' alt='Logo' style='margin-bottom:10px;'>
                <h2 style='margin:0; font-size:22px;'>New Contact Message</h2>
            </div>

            <div style='padding:25px; color:#333;'>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Organization:</strong> $organization</p>
                <p><strong>Message:</strong><br>$message</p>
            </div>

            <div style='background:#f1f3f7; padding:15px; text-align:center; font-size:12px; color:#777;'>
                This is an automated notification email.
            </div>
        </div>
    </div>
    ";
    }

    private function templateUser($name, $organization, $message)
    {
        return "
    <div style='font-family: Arial, sans-serif; background:#f9fafc; padding:30px;'>
        <div style='max-width:600px; margin:auto; background:white; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.05);'>
            
            <div style='background:#6a77ff; padding:20px 20px 25px; text-align:center; color:white;'>
                <img src='/assets/images/jti.png' alt='Logo' style='margin-bottom:10px;'>
                <h2 style='margin:0; font-size:22px;'>Thanks for Reaching Out!</h2>
            </div>

            <div style='padding:25px; color:#333;'>
                <p>Hi <strong>$name</strong>,</p>
                <p>Thanks for contacting us! Here's a copy of what you sent:</p>

                <p><strong>Organization:</strong> $organization</p>
                <p><strong>Your Message:</strong><br>$message</p>

                <br>
                <a href='#' style='display:inline-block; padding:12px 20px; background:#6a77ff; color:white; text-decoration:none; border-radius:8px;'>
                    Visit Our Website
                </a>

                <br><br>
                <p style='color:#666;'>We'll get back to you ASAP</p>
            </div>

            <div style='background:#f1f3f7; padding:15px; text-align:center; font-size:12px; color:#777;'>
                © " . date('Y') . " Lab DT. All rights reserved.
            </div>

        </div>
    </div>
    ";
    }
}