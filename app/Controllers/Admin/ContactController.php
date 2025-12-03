<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Contact;


class ContactController extends Controller
{
    protected $contactModel;

    public function __construct()
    {
        $this->contactModel = $this->loadModel(Contact::class);
    }

    public function index()
    {
        $contact = $this->contactModel->getContactInfo();

        return $this->view('admin/contact/index', [
            'contact' => $contact,
            'pageTitle' => 'Contact Information',
            'layout' => 'layouts/admin'
        ]);
    }

    public function update()
    {
        $data = $_POST;
        $this->contactModel->updateContactInfo($data);
        $this->redirect('/admin/contact?success=updated');
    }
}
