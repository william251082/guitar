<?php
defined('_JEXEC') or die;
?>

<!--output the list-->
<div class="guitar<?php echo $moduleclass_sfx; ?>">
    <?php
    foreach ($data as $class => $item) {
        if ($class == "items") {
            foreach ($item as $itm) {
//                var_dump($item);die;
                echo "<div>".$itm->linkitem."</div>";
            }
            continue;
        }
        ?>
        <div class="<?php echo $class; ?>"><?php echo $item; ?></div>
        <?php
    }
    ?>

<!--    <!--output the song-->-->
<!--<div class="guitar--><?php //echo $moduleclass_sfx; ?><!--">-->
<!--    --><?php
//    foreach ($data as $class => $item) {
//
//        if ($class == "item") {
//            echo "<h4>".$item->album."</h4>";
//            echo "<div>".$item->song."</div>";
//            continue;
//        }
//
//        ?>
<!--        <div class="--><?php //echo $class; ?><!--">--><?php //echo $item; ?><!--</div>-->
<!--        --><?php
//    }
//    ?>
<!--</div>-->

