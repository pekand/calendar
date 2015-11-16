<div  class="container" >
  <div id="<?=$uid?>_dialog" title="Event" style='display:none;' class="row">
        <div class="col-sm-12">
                <form>
                    <input type='hidden' id='<?=$uid?>_eventid' />
                    <div class="form-group">
                        <input type='text' id='<?=$uid?>_eventname' style='width:100%;' placeholder='Name' class="form-control error" />
                    </div>
                    <div class="form-group">
                          <input type='text' id='<?=$uid?>_eventtags' style='width:100%;margin-top:10px;' placeholder='Tags' class="form-control" />
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                            <input type='text' id='<?=$uid?>_eventstart'  placeholder='Start' value='<?=htmlspecialchars($start)?>' class="form-control input-sm" />
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type='text' id='<?=$uid?>_eventend' placeholder='End' value='<?=htmlspecialchars($end)?>' class="form-control input-sm" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                          <textarea  id='<?=$uid?>_eventnote' class="form-control" style="height: 280px;"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="checkbox-inline"><input type='checkbox' id='<?=$uid?>_eventallday' />Whole day</label>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select id='<?=$uid?>_repeatevent' >
                                    <option value="0">None</option>
                                    <option value="1">Daily</option>
                                    <option value="2">Per week</option>
                                    <option value="3">Monthly</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>
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

          var status = addevent('<?=$uid?>', start, end, allDay);

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
});</script>
