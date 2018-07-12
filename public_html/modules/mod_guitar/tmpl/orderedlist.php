<?php
defined('_JEXEC') or die;
?>

<!--output the list-->
<div class="guitar<?php echo $moduleclass_sfx; ?>">
    <?php
    foreach ($data as $class => $item) {
        if ($class == "items") {
            echo "<ol>";
            foreach ($item as $itm) {
                echo "<li>".$itm."</li>";
            }
            echo "</ol>";
            continue;
        }
        ?>
        <div class="<?php echo $class; ?>"><?php echo $item; ?></div>
        <?php
    }
    ?>
</div>

