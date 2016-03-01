<div id="footer" style="z-index: 99;" class="row text-center">
    <?php
    if(!isset($footerButtons)) $footerButtons = [];
    foreach($footerButtons as $button){
        echo '<div class="icon" style="display:inline-block; padding:10px; padding-right:18px; padding-left:18px;">';
        echo '<a onclick="runEvent(\''.$button.'\')">';
        echo '<img src="images/'.$button.'.png" style="width:40px;" />';
        echo '<p style="color:white; font-weight: bold;">'.$button.'</p>';
        echo '</a></div>';
    }
    ?>
</div>