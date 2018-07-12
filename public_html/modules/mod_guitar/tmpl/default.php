<?php
defined('_JEXEC') or die;
?>

<!--output the list-->
<div class="guitar<?php echo $moduleclass_sfx; ?>">
    <?php
    foreach ($data as $class => $item) {
        if ($class == "items") {
            foreach ($item as $itm) {
                echo "<div>".$itm."</div>";
            }
            continue;
        }
        ?>
        <div class="<?php echo $class; ?>"><?php echo $item; ?></div>
        <?php
    }
    ?>

    <!--output the song-->
