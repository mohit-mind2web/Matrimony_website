<?php

namespace App\controllers\user;

use App\core\Controller;
use App\models\Profile;
use App\Helpers\Auth;

class ProfilecreateController extends Controller
{
    //getting from options 
    private function getdata(array $extra = [])
    {
        $constants = require APPROOT . '/config/constants.php';

        return array_merge([
            'religions'   => $constants['religions'],
            'educations'  => $constants['educations'],
            'professions' => $constants['professions'],
            'heights'     => $constants['heights'],
            'genders'     => $constants['genders'],
        ], $extra);
    }


    //function to view profile craete form
    public function index()
    {
        $this->view(
            'profile/profilecreation',
            $this->getdata()
        );
    }


    //function to save profile details to dsahboard
    public function profile()
    {
        $constants = require APPROOT . '/config/constants.php';

        $allowedReligions   = array_keys($constants['religions']);
        $allowedEducations  = array_keys($constants['educations']);
        $allowedProfessions = array_keys($constants['professions']);
        $user_id = $_SESSION['user_id'];
        $profileModel = new Profile();
        $mobile     = $_POST['number'];
        $dob        = $_POST['dob'];
        $gender = $_POST['gender_id'];
        $religion   = $_POST['religion_id'];
        $height     = $_POST['height_id'];
        $education  = $_POST['education_id'];
        $profession = $_POST['profession_id'];
        $city       = $_POST['city'];
        $aboutme    = $_POST['about_me'];
        $photoName = null;
        if (!empty($_FILES['profile_photo']['name'])) {

            $photoName = time() . '_' . $_FILES['profile_photo']['name'];

            move_uploaded_file(
                $_FILES['profile_photo']['tmp_name'],
                APPROOT . '/../public/uploads/' . $photoName
            );
        }
        $errors = [];
        if ($mobile === '') {
            $errors['number'] = 'Mobile number is required';
        } elseif (!preg_match('/^[6-9]\d{9}$/', $mobile)) {
            $errors['number'] = 'Enter valid 10-digit mobile number';
        }


        if ($dob === '') {
            $errors['dob'] = 'Date of birth is required';
        } else {
            $dobDate = new \DateTime($dob);
            $age = (new \DateTime())->diff($dobDate)->y;
            if ($age < 18) {
                $errors['dob'] = 'Age must be 18 or above';
            }
        }

        if ($gender === '') {
            $errors['gender'] = 'Gender is required';
        } elseif (!array_key_exists($gender, $constants['genders'])) {
            $errors['gender'] = 'Invalid gender selected';
        }

        if ($religion === '') {
            $errors['religion'] = 'Religion is required';
        } elseif (!in_array((int)$religion, $allowedReligions, true)) {
            $errors['religion'] = 'Invalid religion selected';
        }

        if ($education === '') {
            $errors['education'] = 'Education is required';
        } elseif (!in_array((int)$education, $allowedEducations, true)) {
            $errors['education'] = 'Invalid education selected';
        }

        if ($profession === '') {
            $errors['profession'] = 'Profession is required';
        } elseif (!in_array((int)$profession, $allowedProfessions, true)) {
            $errors['profession'] = 'Invalid profession selected';
        }

        if ($height === '') {
            $errors['height'] = 'Height is required';
        } elseif (!array_key_exists($height, $constants['heights'])) {
            $errors['height'] = 'Invalid height selected';
        }

        if ($city === '') {
            $errors['city'] = 'City is required';
        } elseif (strlen($city) < 3 || strlen($city) > 50) {
            $errors['city'] = 'City must be between 3 and 50 characters';
        }


        if ($aboutme !== '' && strlen($aboutme) > 500) {
            $errors['about_me'] = 'About Me should not exceed 500 characters';
        }

        if (!empty($_FILES['profile_photo']['name'])) {

            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            $fileType = $_FILES['profile_photo']['type'];
            $fileSize = $_FILES['profile_photo']['size'];

            if (!in_array($fileType, $allowedTypes)) {
                $errors['profile_photo'] = 'Only JPG and PNG images allowed';
            }

            if ($fileSize > 2 * 1024 * 1024) {
                $errors['profile_photo'] = 'Image size must be less than 2MB';
            }
        }
        if (!empty($errors)) {
            $this->view('profile/profilecreation', $this->getdata(['errors' => $errors]));
            return;
        }
        $data = [
            'user_id'      => $user_id,
            'profile_photo' => $photoName,
            'mobileno'     => $mobile,
            'dob'          => $dobDate->format('Y-m-d'),
            'gender' => (int)$gender,
            'religion_id'  => (int)$religion,
            'height_id'    => $height,
            'education_id' => (int)$education,
            'profession_id' => (int)$profession,
            'city'         => $city,
            'about_me'     => $aboutme
        ];


        if ($profileModel->saveprofile($data)) {
            $profileModel->markProfileCompleted($user_id);
            $_SESSION['profile_complete'] = 1;
            header("Location: /user/matches");
            exit;
        }
    }
}
