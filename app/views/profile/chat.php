<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/chat.css" />
</head>

<main>
    <section>
        <div class="chatinbox">
            <a href="/user/chatinbox">Back to Chat Inbox</a>
        </div>
        <div class="chat-container">
            <div class="chat-header">
                <h4> Chat With <?= $receivername['fullname'] ?></h4>
            </div>
            <!-- Messages -->
            <div class="chat-messages">
                <?php if (!empty($messages)): ?>
                    <?php foreach ($messages as $msg): ?>
                        <?php if ($msg['sender_id'] == $_SESSION['user_id']): ?>
                            <div class="message sent">
                                <?= htmlspecialchars($msg['message']) ?>
                                <div class="small text-light mt-1">
                                    <?= date('h:i A', strtotime($msg['created_at'])) ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="message received">
                                <?= htmlspecialchars($msg['message']) ?>
                                <div class="small text-muted mt-1">
                                    <?= date('h:i A', strtotime($msg['created_at'])) ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-muted">No messages yet</p>
                <?php endif; ?>
            </div>
            <form method="POST" action="/user/messages/send" class="chat-input d-flex">
                <input type="hidden" name="receiver_id" value="<?= $receiverId ?>">

                <input
                    type="text"
                    name="message"
                    class="form-control me-2"
                    placeholder="Type your message..."
                    required>

                <button type="submit" class="btn btn-primary">
                    Send
                </button>
            </form>

        </div>
        <section>
            <main>
                <script>
                    const chatBox = document.querySelector('.chat-messages');
                    chatBox.scrollTop = chatBox.scrollHeight;
                </script>