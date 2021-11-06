<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array =  parent::toArray($request);
        
        if($array['start_work_time'] && $array['end_work_time'] && $array['start_break_time'] && $array['end_break_time']){


            $start_work_time = new \DateTime($array['start_work_time'] . ':00');
            $end_work_time = new \DateTime($array['end_work_time'] . ':00');
            $diff_work_time = $start_work_time->diff($end_work_time);


            $start_break_time = new \DateTime($array['start_break_time'] . ':00');
            $end_break_time = new \DateTime($array['end_break_time'] . ':00');
            $diff_break_time = $start_break_time->diff($end_break_time);
            

            $array['total_work_time'] = $diff_work_time->format('%H:%I');
            $array['total_break_time'] = $diff_break_time->format('%H:%I');


            $total_work_hour = abs(explode(':', $array['total_work_time'])[0]);
            $total_work_minute = abs(explode(':', $array['total_work_time'])[1]);

            $total_break_hour = abs(explode(':', $array['total_break_time'])[0]);
            $total_break_minute = abs(explode(':', $array['total_break_time'])[1]);

            $array['total_work_hour'] = $total_work_hour;
            $array['total_work_minute'] = $total_work_minute;
            $array['total_break_hour'] = $total_break_hour;
            $array['total_break_minute'] = $total_break_minute;


            $total_work_seconds = ($total_work_hour * 60 * 60) + ($total_work_minute * 60);
            $total_break_seconds = ($total_break_hour * 60 * 60) + ($total_break_minute * 60);

            $abs_work_seconds = $total_work_seconds - $total_break_seconds;

            $abs_work_time = gmdate("H:i", $abs_work_seconds);
            $array['abs_work_time'] = $abs_work_time;

        } else {
            $array['total_work_time'] = '';
            $array['total_break_time'] = '';
            $array['total_work_hour'] = '';
            $array['total_work_minute'] = '';
            $array['total_break_hour'] = '';
            $array['total_break_minute'] = '';
            $array['abs_work_time'] = '';
        }
        




        // // Create two new DateTime-objects...
        // $date1 = new DateTime('2006-04-12T12:30:00');
        // $date2 = new DateTime('2006-04-14T11:30:00');

        // // The diff-methods returns a new DateInterval-object...
        // $diff = $date2->diff($date1);

        // // Call the format method on the DateInterval-object
        // echo $diff->format('%a Day and %h hours');


        return $array;
    }
}
