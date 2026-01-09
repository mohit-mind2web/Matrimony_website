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

                    // Always print page 1
                    $printPage(1);

                    if ($totalPages <= 5) {
                        // If few pages, show them all
                        for ($i = 2; $i < $totalPages; $i++) {
                             $printPage($i);
                        }
                    } else {
                        // Logic for many pages: 1 ... x y z ... Last
                        // We want: 1, then maybe ..., then current-1, current, current+1, then maybe ..., then Last
                        
                        $start = max(2, $currentPage - 1);
                        $end = min($totalPages - 1, $currentPage + 1);

                        if ($start > 2) {
                            $printEllipsis();
                        }

                        for ($i = $start; $i <= $end; $i++) {
                            $printPage($i);
                        }

                        if ($end < $totalPages - 1) {
                            $printEllipsis();
                        }
                    }

                    // Always print last page if total > 1
                    if ($totalPages > 1) {
                         $printPage($totalPages);
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