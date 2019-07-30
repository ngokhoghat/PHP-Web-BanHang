<?php
include 'module/connect.php';
?>
<?php 
include 'module/';
$connect = mysqli_query();

?>

<?php

function menu($parent_id = 0, $dem = 0)
{
    global $conn;
    $cate_child = array();
    $query_db_mn = 'SELECT * FROM category where parent_id =' . $parent_id;
    $category_mn = mysqli_query($conn, $query_db_mn);
    while ($categorys_mn = mysqli_fetch_array($category_mn, MYSQLI_ASSOC)) {
        $cate_child[] = $categorys_mn;
    }

    if ($cate_child) {
        $a = 0;
        if($a == 0){
            echo '<span>';
        }
        foreach ($cate_child as $key => $item) {
            echo '<a href="">' . $item['name']. '</a>';
            menu($item['id'], ++$dem);
            if($item['parent_id'] = 0){
                $a = 0;
            }else{
                $a = 1;
            }
        }
        echo '</span>';
    }
}

?>
<?php menu(); ?>
