<?php 
namespace App\helpers;
class Pagination {
    public static function pagination($total,$limit=3,$pageParam = 'page'){
       $page = isset($_GET[$pageParam]) && $_GET[$pageParam] > 0? (int)$_GET[$pageParam]: 1;
        $offset = ($page - 1) * $limit;
        $totalpages=ceil($total/$limit);
        return[
            'page'=>$page,
            'offset'=>$offset,
            'totalpages'=>$totalpages,
            'limit'=>$limit,
            'pageParam'=>$pageParam
        ];
    }
}