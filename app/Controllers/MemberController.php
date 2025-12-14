<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Member;
use App\Models\Publication;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Contact;

class MemberController extends Controller
{
    protected $memberModel;
    protected $publicationModel;
    protected $galleryModel;
    protected $newsModel;
    protected $contactModel;

    public function __construct()
    {
        $this->memberModel = $this->loadModel(Member::class);
        $this->publicationModel = $this->loadModel(Publication::class);
        $this->galleryModel = $this->loadModel(Gallery::class);
        $this->newsModel = $this->loadModel(News::class);
        $this->contactModel = $this->loadModel(Contact::class);
    }

    public function show($id)
    {
        $member = $this->memberModel->getMemberById($id);

        if (!$member) {
            $this->redirect('/about'); // Or 404
            return;
        }

        // Fetch related APPROVED content
        $keyword = $_GET['search'] ?? null;

        if ($keyword) {
            $publications = $this->publicationModel->searchApprovedPublicationsByAuthor($id, $keyword);
            $news = $this->newsModel->searchApprovedNewsByAuthor($id, $keyword);
            $gallery = $this->galleryModel->searchApprovedPhotosByUploader($id, $keyword);
        } else {
            $publications = $this->publicationModel->getApprovedPublicationsByAuthor($id);
            $news = $this->newsModel->getApprovedNewsByAuthor($id);
            $gallery = $this->galleryModel->getApprovedPhotosByUploader($id);
        }

        $infoLab = $this->contactModel->getApprovedContactInfo();

        return $this->view('member_detail', [
            'infoLab' => $infoLab,
            'member' => $member,
            'publications' => $publications,
            'news' => $news,
            'gallery' => $gallery,
            'keyword' => $keyword,
            'pageTitle' => 'Profil Anggota - ' . $member['nama_lengkap'],
            'layout' => false
        ]);
    }
}
