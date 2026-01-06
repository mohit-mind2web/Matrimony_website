<?php

namespace App\controllers\user;

use App\core\Controller;
use App\helpers\Auth;
use App\models\ChatModel;

class ChatController extends Controller
{
    public function chat()
    {
        Auth::requireRole([2]);

        $receiverId = (int) $_GET['id'];

        $senderId = $_SESSION['user_id'];
        $messageModel = new ChatModel();

        if (!$messageModel->isconnected($senderId, $receiverId)) {
            header("Location: /user/chatinbox");
            exit;
        }
        $messages = $messageModel->getChat($senderId, $receiverId);
        $receivername = $messageModel->getUserById($receiverId);
        // Mark as read
        $messageModel->markAsRead($receiverId, $senderId);

        $this->view('profile/chat', [
            'messages'   => $messages,
            'receiverId' => $receiverId,
            'receivername' => $receivername
        ]);
    }

    // Send message
    public function send()
    {
        Auth::requireRole([2]);
        $messageModel = new ChatModel();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $senderId   = $_SESSION['user_id'];
            $receiverId = $_POST['receiver_id'];
            $message    = trim($_POST['message']);

            if (!empty($message)) {
                $messageModel->sendMessage(
                    $senderId,
                    $receiverId,
                    $message
                );
            }

            header("Location: /user/messages?id=" . $receiverId);
            exit;
        }
    }


    //chatinbox function
    public function chatinbox()
    {
        Auth::requireRole([2]);
        $userId = $_SESSION['user_id'];
        $connectionModel = new ChatModel();
        $friends = $connectionModel->getconnections($userId);
        $this->view('profile/chatinbox', [
            'friends' => $friends
        ]);
    }
}
