<?= $template->render('Main/Layout', array(
    'title' => 'Calendar',
    'css' => array(
       '/lib/jquery/jquery-ui-1.11.1/jquery-ui.min.css',
       '/lib/fullcalendar-2.4.0/fullcalendar.css',
       '/css/main.css',
    ),
)); ?>
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Calendar</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
           <ul class="nav navbar-nav pull-right">
            <li><a href="/logout">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

      <div class="starter-template">
        <div id='calendar'></div>
      </div>

    </div><!-- /.container -->

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
