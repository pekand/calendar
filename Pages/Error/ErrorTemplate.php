<?= $template->render('Main/Layout', array(
    'title' => 'Error page',
    'css' => array(
        '/css/error.css'
    ),
    'js' => array(

    ),
)); ?>
<div id="errorstrip">
  Page not found
</div>
<?= $template->render('Main/Footer', array(
    'js' => array(
    ),
)); ?>
