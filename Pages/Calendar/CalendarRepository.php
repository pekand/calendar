<?php

namespace Pages\Calendar;

use Core\Service;

/*
    Calendar sql repository
*/
class CalendarRepository extends Service
{

    public function loadEvents($start, $end)
    {
        $db = $this->container->get('Database');

        $result = $db->query("
          SELECT
            'event' as typ,
            a.id,
            a.event_begin,
            a.event_end,
            a.name,
            a.tags,
            a.note,
            '#809FFF' as color
          FROM
            calendar a
          WHERE
            :start <= a.event_begin and a.event_end <= :end;
        ", array(
            ":start"=>$start,
            ":end"=>$end
        ));

        $events = array();
        if(is_array($result))foreach($result as $value)
        {
            $events[] = array(
                'id' => $value['id'],
                'title' => $value['name'],
                'start' => date("Y-m-d H:i:s",strtotime($value['event_begin'])),
                'end' => date("Y-m-d H:i:s",strtotime($value['event_end'])),
                'allDay'=> false,
                'color' => $value['color'],
                'event_type' => $value['typ'],
                'textColor'=> '#000000',
                'description' => $value['note'],
            );
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
            a.event_begin,
            a.event_end,
            a.name,
            a.tags,
            a.note,
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
                'title' => $value['name'],
                'start' => date("Y-m-d H:i:s",strtotime($value['event_begin'])),
                'end' => date("Y-m-d H:i:s",strtotime($value['event_end'])),
                'allDay'=> false,
                'color' => $value['color'],
                'event_type' => $value['typ'],
                'textColor'=> '#000000',
                'description' => $value['note'],
                'tags' => $value['tags'],
            );
        }

        return $event;
    }

    public function insertEvent($start, $end, $title, $tags, $note, $allDay)
    {
        $db = $this->container->get('Database');

        $result = $db->query("
          INSERT INTO calendar (event_begin, event_end, name, tags, note)
          VALUES
            (:start, :end, :title, :tags, :note)
            ", array(
                ":start"=>$start,
                ":end"=>$end,
                ":title"=>$title,
                ":tags"=>$tags,
                ":note"=>$note,
            )
        );

        return $db->lastId();
    }

    public function updateEvent($id, $start, $end, $title, $tags, $note)
    {
        $db = $this->container->get('Database');

        $result = $db->query("
          UPDATE calendar
          SET
            event_begin=:start,
            event_end=:end,
            name=:title,
            tags=:tags,
            note=:note
          WHERE id = :id;
            ", array(
                ":id"=>$id,
                ":start"=>$start,
                ":end"=>$end,
                ":title"=>$title,
                ":tags"=>$tags,
                ":note"=>$note,
            )
        );

        return $id;
    }

    public function deleteEvent($id)
    {
        $db = $this->container->get('Database');

        $result = $db->query("
          DELETE FROM calendar
          WHERE id = :id
            ", array(
                ":id"=>$id
            )
        );

        return $id;
    }

    public function copyEvent($id)
    {
        $db = $this->container->get('Database');

        $result = $db->query("
            INSERT INTO calendar (event_begin, event_end, name, tags, note)
            SELECT event_begin, event_end, name, tags, note FROM calendar
            WHERE id = :id
            ", array(
                ":id"=>$id
            )
        );

        return $db->lastId();
    }

    public function moveEvent($id, $delta)
    {
        $db = $this->container->get('Database');

        $result = $db->query("
            UPDATE calendar
            SET
            event_begin = event_begin + INTERVAL :delta1 MINUTE,
            event_end= event_end + INTERVAL :delta2 MINUTE
            WHERE id = :id
            ", array(
                ":id"=>$id,
                ":delta1"=>$delta+0,
                ":delta2"=>$delta+0
            )
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
            )
        );

        return $id;
    }
}
