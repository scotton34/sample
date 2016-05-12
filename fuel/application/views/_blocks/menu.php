<?php
/*
 *  Page created by Stephen Cotton
 *  
 * 
 */
$menu = fuel_nav(array('render_type' => 'array', 'first_class' => 'first', 'last_class' => 'last', 'container_tag_id' => 'topmenu', 'container_tag_class' => 'unknown'));

?>
<div class="main-nav">
<ul id="parent-ul">
    <?php
    
    foreach ($menu as $item) {
        $ul_li_class = 'nav_child';
        if ($item === reset($menu)) {
            $class = "class='first'";
        }
        if ($item === end($menu)) {
            $class = "class='last'";
        }
        if($class != ''){
            $liclass = str_replace("class='", "class='nav_parent ", $class);
        }else{
            $liclass = "class='nav_parent'";
        }
        echo "<li {$liclass}><h5><a href='{$item["location"]}'>{$item['label']}</a></h5>";

        if (isset($item['children'])) {
            echo "<ul class='{$ul_li_class}'>";
            foreach ($item['children'] as $sub_item) {
                echo "<li><a href='{$sub_item["location"]}'>{$sub_item["label"]}</a></li>";
            }
            echo "</ul>";
        }
        echo '</li>';
        $class = '';
    }
    ?>
</ul>

</div>
    <br><br>
