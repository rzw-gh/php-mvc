<?php

require App\Config::HEADER;
?>

<div style="display: block">
    <h1>Hello World!</h1>
    <a href="?id=1">click to see magic!</a>

    <?php if ($params['id'] != 0) { ?>
        <p>your ID param is: <?= $params['id'] ?></p>
    <?php } ?>
</div>

<?php require App\Config::FOOTER ?>

<script>// Start writing your JS codes</script>