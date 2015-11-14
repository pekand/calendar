<?= $template->render('Main/Layout', array(
    'title' => 'Calendar',
    'css' => array(
       '/lib/jquery/jquery-ui-1.11.1/jquery-ui.min.css',
       '/lib/fullcalendar-2.4.0/fullcalendar.css',
    ),
)); ?>
<div id='calendar'></div>
<script type="text/javascript">
  var mode = '<?= $mode ?>';
  var cdate = '<?= $cdate ?>';
</script>
<?= $template->render('Main/Footer', array(
    'js' => array(
        '/lib/jquery/jquery-ui-1.11.1/jquery-ui.min.js',
        '/lib/fullcalendar-2.4.0/lib/moment.min.js',
        '/lib/fullcalendar-2.4.0/fullcalendar.min.js',
        '/js/calendar.js'
    ),
)); ?>
