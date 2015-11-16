<?php

namespace Pages\Calendar;

use Core\Service;

/*
    Calendar sql repository
*/
class CalendarRepository extends Service
{
    public function loadEvents($start, $end, $userId)
    {
        $db = $this->container->get('Database');

        $result = $db->query(
            "SELECT
            'event' as typ,
            a.id,
            a.user_id,
            a.event_begin,
            a.event_end,
            a.name,
            a.tags,
            a.note,
            a.allDay,
            a.repeatEvent,
            '#809FFF' as color
          FROM
            calendar a
          WHERE
            (:start <= a.event_begin and
            a.event_end <= :end) or
            (repeatEvent is not null and repeatEvent>0);
        ", array(
            ":start"=>$start,
            ":end"=>$end,
        ));

        $events = array();
        if(is_array($result))foreach($result as $value)
        {
            $event = array(
                'id' => $value['id'],
                'title' => $value['name'],
                'start' => date("Y-m-d H:i:s",strtotime($value['event_begin'])),
                'end' => date("Y-m-d H:i:s",strtotime($value['event_end'])),
                'allDay'=> $value['allDay'] == 1 ? true : false,
                'color' => ($value['user_id'] == $userId) ? $value['color'] : '#809F00',
                'event_type' => $value['typ'],
                'textColor'=> '#000000',
                'description' => $value['note'],
                'editable' => ($value['user_id'] == $userId),
                'repeatEvent' => $value['repeatEvent'],
            );

            $events[] = $event;

            if ($value['repeatEvent']>0) {
                $currentStart = $value['event_begin'];
                $currentEnd = $value['event_end'];


                $add = " +1 day";
                switch ($value['repeatEvent']) {
                    case 1:
                        $add = " +1 day";
                        break;
                    case 2:
                        $add = " +1 day";
                        break;
                    case 3:
                        $add = " +1 months";
                        break;
                }

                $i=0;
                while (strtotime($currentStart) < strtotime($end)) {

                        $currentStart = date('Y-m-d H:i:s', strtotime($currentStart . $add));
                        $currentEnd  = date('Y-m-d H:i:s', strtotime($currentEnd . $add));
                        $event['start'] = $currentStart;
                        $event['end']  = $currentEnd;

                        $events[] = $event;
                        $i++;
                        if ($i>100) {
                            break;
                        }
                }
            }

        }

        return $events;
    }

    public function getEvent($id)
    {
        $db = $this->container->get('Database');

        $result = $db->query("
          SELECT
            'event' as typ,
            a.id,
            a.user_id,
            a.event_begin,
            a.event_end,
            a.name,
            a.tags,
            a.note,
            a.allDay,
            a.repeatEvent,
            '#809FFF' as color
          FROM
            calendar a
          WHERE
            a.id = :id
          LIMIT 1
        ", array(
            ":id"=>$id
        ));

        $event = array();
        if(is_array($result))
        {
            $value = $result[0];
            $event= array(
                'id' => $value['id'],
                'user_id' => $value['user_id'],
                'title' => $value['name'],
                'start' => date("Y-m-d H:i:s",strtotime($value['event_begin'])),
                'end' => date("Y-m-d H:i:s",strtotime($value['event_end'])),
                'allDay'=> $value['allDay'] == 1 ? true : false,
                'color' => $value['color'],
                'event_type' => $value['typ'],
                'textColor'=> '#000000',
                'description' => $value['note'],
                'tags' => $value['tags'],
                'repeatEvent' => $value['repeatEvent'],
            );
        }

        return $event;
    }

    public function insertEvent($user_id, $start, $end, $title, $tags, $note, $allDay, $repeatEvent)
    {
        $db = $this->container->get('Database');

        $result = $db->query("
          INSERT INTO calendar (user_id, event_begin, event_end, name, tags, note, allDay, repeatEvent)
          VALUES
            (:user_id, :start, :end, :title, :tags, :note, :allDay, :repeatEvent)
            ", array(
                ":user_id"=>$user_id,
                ":start"=>$start,
                ":end"=>$end,
                ":title"=>$title,
                ":tags"=>$tags,
                ":note"=>$note,
                ":allDay"=>$allDay ? '1' : '0',
                ":repeatEvent"=>$repeatEvent,
            ),
            false
        );

        return $db->lastId();
    }

    public function updateEvent($id, $user_id, $start, $end, $title, $tags, $note, $allDay, $repeatEvent)
    {
        $db = $this->container->get('Database');

        $result = $db->query("
          UPDATE calendar
          SET
            event_begin=:start,
            event_end=:end,
            name=:title,
            tags=:tags,
            note=:note,
            allDay=:allDay,
            repeatEvent=:repeatEvent
          WHERE
            id = :id and
            user_id = :user_id
            ", array(
                ":id"=>$id,
                ":user_id"=>$user_id,
                ":start"=>$start,
                ":end"=>$end,
                ":title"=>$title,
                ":tags"=>$tags,
                ":note"=>$note,
                ":allDay"=>$allDay ? '1' : '0',
                ":repeatEvent"=>$repeatEvent,
            ),
            false
        );

        return $id;
    }

    public function deleteEvent($id)
    {
        $db = $this->container->get('Database');

        $result = $db->query("
          DELETE FROM calendar
          WHERE id = :id
            ",
            array(
                ":id"=>$id
            ),
            false
        );

        return $id;
    }

    public function copyEvent($id, $delta, $allDay)
    {
        $db = $this->container->get('Database');

        $result = $db->query("
            INSERT INTO calendar (event_begin, event_end, name, tags, note, allDay)
            SELECT event_begin + INTERVAL :delta1 MINUTE, event_end+ INTERVAL :delta2 MINUTE, name, tags, note, :allDay FROM calendar
            WHERE id = :id
            ", array(
                ":id"=>$id,
                ":delta1"=>$delta+0,
                ":delta2"=>$delta+0,
                ":allDay"=>$allDay
            ),
            false
        );

        return $db->lastId();
    }

    public function moveEvent($id, $delta, $allDay)
    {
        $db = $this->container->get('Database');

        $result = $db->query("
            UPDATE calendar
            SET
                event_begin = event_begin + INTERVAL :delta1 MINUTE,
                event_end= event_end + INTERVAL :delta2 MINUTE,
                allDay=:allDay
            WHERE id = :id
            ", array(
                ":id"=>$id,
                ":delta1"=>$delta+0,
                ":delta2"=>$delta+0,
                ":allDay"=>$allDay
            ),
            false
        );

        return $id;
    }

    public function resizeEvent($id, $delta)
    {
        $db = $this->container->get('Database');

        $result = $db->query("
            UPDATE calendar
            SET
                event_end= event_end + INTERVAL :delta MINUTE
            WHERE id = :id
            ", array(
                ":id"=>$id,
                ":delta"=>$delta+0
            ),
            false
        );

        return $id;
    }
}
