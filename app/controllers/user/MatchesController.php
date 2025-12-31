<?php

namespace App\controllers\user;

use App\core\Controller;
use App\helpers\Auth;
use App\helpers\Pagination;
use App\models\Profile;
use App\models\UserMatches;

class MatchesController extends Controller
{
    public function index()
    {
        Auth::requireRole([2]);

        $constants = require APPROOT . '/config/constants.php';
        $user_id = $_SESSION['user_id'];
        $profile_complete = $_SESSION['profile_complete'] ?? 0;
        $profileModel = new Profile();
        $myprofile = $profileModel->getprofilebyid($user_id, $user_id);
        if ($myprofile) {
            $mygender = $myprofile['gender'];
            $gender = ($mygender == 1) ? 2 : 1;
        } else {
            $gender = null;
        }
        $matchesModel = new UserMatches();
        $total = $matchesModel->countprofiles($user_id, $gender);
        $pagination = Pagination::pagination($total, 6);
        $profiles = $matchesModel->getprofiles($user_id, $gender, $pagination['limit'], $pagination['offset']);
        $this->view('profile/matches', [
            'profiles' => $profiles,
            'profile_complete' => $profile_complete,
            'constants' => $constants,
            'pagination' => $pagination
        ]);
    }

    public function filter()
    {
        Auth::checkLogin();
        $constants = require APPROOT . '/config/constants.php';
        $heights = $constants['heights'] ?? [];
        $religions = $constants['religions'] ?? [];
        $educations = $constants['educations'] ?? [];
        $professions = $constants['professions'] ?? [];
        $filters = $_POST ?? [];

        $user_id = $_SESSION['user_id'];
        $page = $filters['page'] ?? 1;
        $limit = 3;
        $offset = ($page - 1) * $limit;
        $profileModel = new UserMatches();
        $total = $profileModel->countFilteredProfiles($user_id, $filters);
        $pagination = Pagination::pagination($total, $limit, $page);
        $profiles = $profileModel->filterProfiles($user_id, $filters, $limit, $offset);
        require APPROOT . '/views/profile/profilelist.php';
    }
}
