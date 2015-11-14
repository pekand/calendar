<?= $template->render('Main/Layout', array(
    'title' => 'Calendar',
    'css' => array(
       '/lib/jquery/jquery-ui-1.11.1/jquery-ui.min.css',
       '/lib/fullcalendar-2.0.2/fullcalendar.css',
       '/lib/fullcalendar-2.0.2/fullcalendar.print.css',
    ),
    'js' => array(

    ),
)); ?>
<div id='calendar'></div>
<script type="text/javascript">
  var mode = '<?= $mode ?>';
  var cdate = '<?= $cdate ?>';
</script>
<?= $template->render('Main/Footer', array(
    'js' => array(
        '/lib/jquery/jquery-2.1.1/jquery-2.1.1.min.js',
        '/lib/jquery/jquery-ui-1.11.1/jquery-ui.min.js',
        '/lib/Moment.js-2.8.1/moment.min.js',
        '/lib/fullcalendar-2.0.2/fullcalendar.min.js',
        '/js/calendar.js'
    ),
)); ?>
