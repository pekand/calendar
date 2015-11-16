      var clickedevent = null;
      var calendar = null;
      var ctrlpressed = false;

      var shift = function () {
          shifted = false;
          shift.reset = function () {
              this.shifted = false;
          }
      }

      $(document).ready(function() {

        $(document).keydown(function (e) { // catch shift key
            if (e.keyCode == 16) {
                shift.shifted = true;
            } else {
                shift.shifted = false;
            }
        }).keyup(function (e) {
            shift.shifted = false;
        });

        calendar = $('#calendar').fullCalendar({  // FULL CALENDAR OBJECT
          editable: true,
          firstDay:1,
          height: window.innerHeight - 80,
          events: "/calendar/load-events",
          defaultView: mode,
          defaultDate: cdate,
          selectable: true,
          selectHelper: true,
          timeFormat: 'H:mm { - HH:mm}',
          axisFormat: 'HH:mm',
          columnFormat:{month: 'ddd', week: 'dd ddd', day: 'dddd M/d'},
          format:"yyyy.MM.dd",
          aspectRatio: 1.35,
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          titleFormat: {
            month:'MMMM YYYY', // September 2009
            week: 'MMM D YYYY', // Sep 13 2009
            day:  'MMMM D YYYY'  // September 8 2009
          },
          select: function(start, end, jsEvent, view) {  // CREATE INSERT EVENT

            var data=new Object();
            data.start = start.format();
            data.end = end.format();

            $.ajax({  // GET EVENT WINDOW with ajax
              async:false,
              type: 'POST',
              url:"/calendar/insert-event-form",
              data:data,
              success:function(result){
                $('body').append(result);
              }
            });

          },
          eventClick: function(event, jsEvent, view) { // OPEN EVENT DBCLICK

            if(event.event_type == 'event' && event.editable == true) {
              var data=new Object();
              data.id = event.id;
              $.ajax({  // GET EVENT WINDOW with ajax
                async:false,
                type: 'POST',
                url:"/calendar/edit-event-form",
                data:data,
                success:function(result){
                  clickedevent = event;
                  $('body').append(result);
                }
              });
            }

          },
          eventResize: function(event, delta, revertFunc, jsEvent, ui, view) { // EVENT RESIZE
              var data=new Object();
              data.id = event.id;
              data.delta = delta.asMinutes();

              $.ajax({  // resize event
                async:false,
                type: 'POST',
                url:"/calendar/resize-event",
                data:data,
                success:function(result){
                }
              });
          },
          eventDrop: function(event, delta, revertFunc, jsEvent, ui, view) { // MOVE EVENT
            var data=new Object();
            data.id = event.id;;
            data.allDay = event.allDay ? '1' : '0';
            data.delta = delta.asMinutes();

            if (shift.shifted) {
                $.ajax({  // copy event
                  async:false,
                  type: 'POST',
                  url:"/calendar/copy-event",
                  data:data,
                  success:function(res){
                      try{
                        var result = JSON.parse(res);
                      }catch(e){
                          alert(res);
                      }
                      calendar.fullCalendar( 'rerenderEvents' );

                  }
                });
            } else {
              $.ajax({  // move event
                async:false,
                type: 'POST',
                url:"/calendar/move-event",
                data:data,
                success:function(result){
                }
              });
            }
          },
          eventRender: function(event, element)
          {
              element.find('.fc-event-title').append("<br/>" + $('<div/>').text(event.description).html());
          },
          viewRender: function(view, element) {
            var selsected_date = view.start.format();

            if (selsected_date==moment().format('YYYY-MM-DD')) {
                selsected_date='today';
            }
            window.history.pushState('', '', '/calendar/'+view.name+'/'+selsected_date);
          }
        });

        window.onresize = function(event) {
            $('#calendar').fullCalendar('option', 'height', window.innerHeight - 80);
        };

      });

    function addevent(uid, start, end, isAllDay)
    {

        var title = $('#'+uid+'_eventname').val();
        var note =  $('#'+uid+'_eventnote').val();
        var tags = $('#'+uid+'_eventtags').val();
        var allDay = $('#'+uid+'_eventallday').is(':checked') ? '1' : '0';
        var repeatEvent = $('#'+uid+'_repeatevent').val();

        jQuery.post(
            '/calendar/insert-event',
            {
                title: title,
                start: start,
                end: end,
                note: note,
                tags: tags,
                allDay: allDay,
                repeatEvent: repeatEvent
            },
            function(res) {
              try
              {
                calendar.fullCalendar('renderEvent',
                  {
                    id:res.id,
                    event_type:res.event_type,
                    title: res.title,
                    description: res.description,
                    start: res.start,
                    end: res.end,
                    allDay: res.allDay,
                    color: res.color,
                    editable: true,
                    startEditable: true,
                    durationEditable: true
                  }
                );
              }
              catch(e)
              {
                alert(data);
              }
            }
        );
    }

    function saveevent(uid, start, end, isAllDay)
    {
        var id = $('#'+uid+'_eventid').val();
        var title = $('#'+uid+'_eventname').val();
        var note = $('#'+uid+'_eventnote').val();
        var tags = $('#'+uid+'_eventtags').val();
        var allDay = $('#'+uid+'_eventallday').is(':checked') ? '1' : '0';
        var repeatEvent = $('#'+uid+'_repeatevent').val();

        if (title) {
          jQuery.post(
              '/calendar/save-event',
              {
                  id:id,
                  title: title,
                  start: start,
                  end: end,
                  note: note,
                  tags: tags,
                  allDay: allDay,
                  repeatEvent: repeatEvent
              },
              function(res) {
                try
                {
                  clickedevent.title = res.title;
                  clickedevent.description = res.description;
                  clickedevent.start = res.start;
                  clickedevent.end = res.end;

                  calendar.fullCalendar('updateEvent', clickedevent);
                }
                catch(e)
                {
                  alert(data);
                }
              }
          );
        }
    }
