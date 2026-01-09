<?php 
$currentTab = $pagination['tab'] ?? null;
// Build query string from current GET parameters, excluding the page parameter
$queryParams = $_GET;
unset($queryParams[$pagination['pageParam']]);
if ($currentTab) {
    $queryParams['tab'] = $currentTab;
}
$queryString = http_build_query($queryParams);
$queryString = $queryString ? $queryString . '&' : '';
?>
    <?php if ($pagination['totalpages'] > 1): ?>
        <div class="pagination">
            <nav>
                <ul>
                    <?php if ($pagination['page'] > 1): ?>
                        <li>
                            <a href="?<?= $queryString ?><?= $pagination['pageParam'] ?>=<?= $pagination['page'] - 1 ?>" class="ajax-pagination-link">
                                Prev
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php
                    $totalPages = $pagination['totalpages'];
                    $currentPage = $pagination['page'];
                    $printPage = function($i) use ($queryString, $pagination, $currentPage) {
                         $activeClass = $i == $currentPage ? 'active' : '';
                         $url = "?" . $queryString . "{$pagination['pageParam']}={$i}";
                         echo "<li><a href='{$url}' class='{$activeClass} ajax-pagination-link'>{$i}</a></li>";
                    };
                    
                    $printEllipsis = function() {
                         echo "<li><span>...</span></li>";
                    };

                    if ($totalPages <= 7) {
                        for ($i = 1; $i <= $totalPages; $i++) $printPage($i);
                    } else {
                        if ($currentPage < 5) {
                             for ($i = 1; $i <= 5; $i++) $printPage($i);
                             $printEllipsis();
                             $printPage($totalPages);
                        } elseif ($currentPage > $totalPages - 4) {
                             $printPage(1);
                             $printEllipsis();
                             for ($i = $totalPages - 4; $i <= $totalPages; $i++) $printPage($i);
                        } else {
                             $printPage(1);
                             $printEllipsis();
                             $printPage($currentPage - 1);
                             $printPage($currentPage);
                             $printPage($currentPage + 1);
                             $printEllipsis();
                             $printPage($totalPages);
                        }
                    }
                    ?>
                    <?php if ($pagination['page'] < $pagination['totalpages']): ?>
                        <li>
                            <a href="?<?= $queryString ?><?= $pagination['pageParam'] ?>=<?= $pagination['page'] + 1 ?>" class="ajax-pagination-link">
                                Next
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </nav>
        </div>
    <?php endif; ?>