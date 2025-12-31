<?php 
$currentTab = $pagination['tab'] ?? null; 
?>
    <?php if ($pagination['totalpages'] > 1): ?>
        <div class="pagination">
            <nav>
                <ul>
                    <?php if ($pagination['page'] > 1): ?>
                        <li>
                            <a href="?<?= $currentTab ? "tab={$currentTab}&" : "" ?><?= $pagination['pageParam'] ?>=<?= $pagination['page'] - 1 ?>">
                                Prev
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $pagination['totalpages']; $i++): ?>
                        <li>
                            <a href="?<?= $currentTab ? "tab={$currentTab}&" : "" ?><?= $pagination['pageParam'] ?>=<?= $i ?>"
                                class="<?= $i == $pagination['page'] ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($pagination['page'] < $pagination['totalpages']): ?>
                        <li>
                            <a href="?<?= $currentTab ? "tab={$currentTab}&" : "" ?><?= $pagination['pageParam'] ?>=<?= $pagination['page'] + 1 ?>">
                                Next
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </nav>
        </div>
    <?php endif; ?>
    </ul>
    </nav>
</main>