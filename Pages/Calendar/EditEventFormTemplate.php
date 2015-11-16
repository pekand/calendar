<div  class="container" >
  <div id="<?=$uid?>_dialog" title="Event" style='display:none;' class="row">
        <div class="col-sm-12">
                <form>
                    <input type='hidden' id='<?=$uid?>_eventid' value='<?=htmlspecialchars($id)?>' />
                    <div class="form-group">
                        <input type='text' id='<?=$uid?>_eventname' style='width:100%;' placeholder='Name' class="form-control error" value='<?=htmlspecialchars($name, ENT_QUOTES, false)?>' />
                    </div>
                    <div class="form-group">
                          <input type='text' id='<?=$uid?>_eventtags' style='width:100%;margin-top:10px;' placeholder='Tags' class="form-control" value='<?=htmlspecialchars($tags, ENT_QUOTES, false)?>' />
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                            <input type='text' id='<?=$uid?>_eventstart'  placeholder='Start' value='<?=$start?>' class="form-control input-sm" value='<?=htmlspecialchars($start)?>' />
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type='text' id='<?=$uid?>_eventend' placeholder='End' value='<?=$end?>' class="form-control input-sm" value='<?=htmlspecialchars($end)?>' />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                          <textarea  id='<?=$uid?>_eventnote' class="form-control" style="height: 280px;"><?=htmlspecialchars($note)?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="checkbox-inline"><input type='checkbox' id='<?=$uid?>_eventallday' <?= $allDay ? 'checked': '' ?> />Whole day</label>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select id='<?=$uid?>_repeatevent' >
                                    <option value="0" >None</option>
                                    <option value="1" <?=($repeatEvent==1)?'selected':''?>>Daily</option>
                                    <option value="2" <?=($repeatEvent==2)?'selected':''?>>Per week</option>
                                    <option value="3" <?=($repeatEvent==3)?'selected':''?>>Monthly</option>
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
});</script>
