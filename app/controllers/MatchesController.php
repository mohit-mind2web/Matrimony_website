<?php

namespace App\controllers;

use App\core\Controller;
use App\helpers\Auth;
use App\models\Profile;
use App\models\UserMatches;

class MatchesController extends Controller
{
    public function index()
    {
        Auth::checkLogin();

        $constants = require APPROOT . '/config/constants.php';
        $user_id = $_SESSION['user_id'];
        $profile_complete = $_SESSION['profile_complete'] ?? 0;
        $profileModel = new Profile();
        $myprofile = $profileModel->getprofilebyid($user_id);
        if ($myprofile) {
            $mygender = $myprofile['gender'];
            $gender = ($mygender == 1) ? 2 : 1;
        } else {
            $gender = null;
        }
        $matchesModel = new UserMatches();
        $profiles = $matchesModel->getprofiles($user_id, $gender);
        $this->view('profile/matches', [
            'profiles' => $profiles,
            'profile_complete' => $profile_complete,
            'constants' => $constants
        ]);
    }
}
