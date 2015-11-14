<div id="<?=$uid?>_dialog" title="Event" style='display:none;' >
  <div><input type='hidden' id='<?=$uid?>_eventid' value='<?=$id?>' /></div>
  <div><input type='text' id='<?=$uid?>_eventname' style='width:100%;' placeholder='Názov' value='<?=$name?>' /></div>
  <div><input type='text' id='<?=$uid?>_eventtags' style='width:100%;margin-top:10px;' placeholder='Tagy' value='<?=$tags?>' /></div>
  <div>
    <div style='float:left;' >
      <input type='text' id='<?=$uid?>_eventstart' style='width:200px;margin-top:10px;margin-right:10px;' placeholder='Začiatok' value='<?=$start?>' />
    </div>
    <div style='float:left;' >
      <input type='text' id='<?=$uid?>_eventend' style='width:200px;margin-top:10px;' placeholder='Koniec' value='<?=$end?>' />
    </div>
    <div style='clear:both;' ></div>
  </div>
  <div style='width:100%;margin-top:10px;' ><textarea  id='<?=$uid?>_eventnote' style='width:100%;height:250px;'><?=$note?></textarea></div>
<script type="text/javascript" >
  $(document).ready(function() {
  $( "#<?=$uid?>_dialog" ).dialog({  // DIALOG
    resizable: true,
    height:600,
    width:600,
    modal: false,
    buttons: {
        "delete": function() {

          var data=new Object();
          data.id = '<?=$id?>';

          if (confirm("Are you sure?"))
          {
            var this_dialog = this;
            $.ajax({  // GET EVENT WINDOW with ajax
              async:false,
              type: 'POST',
              url:"/calendar/delete-event",
              data:data,
              success:function(res){
                try{
                  var result = JSON.parse(res);
                  $( this_dialog ).dialog( "close" );
                }catch(e){
                  //alert(res);
                }
              }
            });
          }

          calendar.fullCalendar( 'refetchEvents' );

          return true; // make the event "stick"
        },
        "ok": function() {
          var start = $('#<?=$uid?>_eventstart').val();
          var end = $('#<?=$uid?>_eventend').val();
          var allDay = false;

          saveevent('<?=$uid?>', start, end, allDay);
          $( this ).dialog( "close" );
          calendar.fullCalendar( 'refetchEvents' );
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
