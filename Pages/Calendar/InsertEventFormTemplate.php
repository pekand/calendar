<div id="<?=$uid?>_dialog" title="Event" style='display:none;' >
  <div><input type='hidden' id='<?=$uid?>_eventid' /></div>
  <div><input type='text' id='<?=$uid?>_eventname' style='width:100%;' placeholder='Názov' /></div>
  <div><input type='text' id='<?=$uid?>_eventtags' style='width:100%;margin-top:10px;' placeholder='Tagy' /></div>
  <div>
    <div style='float:left;' >
      <input type='text' id='<?=$uid?>_eventstart' style='width:200px;margin-top:10px;margin-right:10px;' placeholder='Začiatok' value='<?=$start?>' />
    </div>
    <div style='float:left;' >
      <input type='text' id='<?=$uid?>_eventend' style='width:200px;margin-top:10px;' placeholder='Koniec' value='<?=$end?>' />
    </div>
    <div style='clear:both;' ></div>
  </div>
  <div style='width:100%;margin-top:10px;' ><textarea  id='<?=$uid?>_eventnote' style='width:100%;height:250px;' ></textarea></div>
<script type="text/javascript" >
  $(document).ready(function() {
  $( "#<?=$uid?>_dialog" ).dialog({  // DIALOG
    resizable: true,
    height:600,
    width:600,
    modal: false,
    buttons: {
        "ok": function() {
          var start = $('#<?=$uid?>_eventstart').val();
          var end = $('#<?=$uid?>_eventend').val();
          var allDay = false;

          addevent('<?=$uid?>', start, end, allDay);

          calendar.fullCalendar( 'rerenderEvents' );
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
    },
    close:function(){
      $('#<?=$uid?>_dialog').remove();
    }
  });
  //calendar.fullCalendar('unselect');
});</script></div>
