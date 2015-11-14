<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <title><?= @$title ?></title>
  <link rel="icon" type="image/png" href="/img/clock.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<?php
    if (isset($css))
        foreach ($css as $style) {
            echo '<link rel="stylesheet" type="text/css" href="'.$style.'">';
        }
?>
  <?= @$head ?>
</head>
<body>
