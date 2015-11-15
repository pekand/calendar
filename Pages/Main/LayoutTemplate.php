<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <title><?= @$title ?></title>
  <link rel="icon" type="image/png" href="/img/clock.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="/lib/bootstrap-3.3.5/css/bootstrap.min.css">
<?php
    if (isset($css))
        foreach ($css as $style) {
            echo '<link rel="stylesheet" type="text/css" href="'.$style.'">';
        }
?>
</head>
<body>
