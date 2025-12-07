<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Member;
use App\Models\Publication;
use App\Models\Gallery;
use App\Models\News;

class MemberController extends Controller
{
    protected $memberModel;
    protected $publicationModel;
    protected $galleryModel;
    protected $newsModel;

    public function __construct()
    {
        $this->memberModel = $this->loadModel(Member::class);
        $this->publicationModel = $this->loadModel(Publication::class);
        $this->galleryModel = $this->loadModel(Gallery::class);
        $this->newsModel = $this->loadModel(News::class);
    }

    public function show($id)
    {
        $member = $this->memberModel->getMemberById($id);

        if (!$member) {
            $this->redirect('/about'); // Or 404
            return;
        }

        // Fetch related APPROVED content
        $publications = $this->publicationModel->getApprovedPublicationsByAuthor($id);
        $news = $this->newsModel->getApprovedNewsByAuthor($id);
        $gallery = $this->galleryModel->getApprovedPhotosByUploader($id);

        return $this->view('member_detail', [
            'member' => $member,
            'publications' => $publications,
            'news' => $news,
            'gallery' => $gallery,
            'pageTitle' => 'Profil Anggota - ' . $member['nama_lengkap'],
            'layout' => false
        ]);
    }
}
