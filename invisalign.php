<?php

$start_date = '20170101';
$trays_total = 38;
$interval = '2W'; // e.g. 2W = 2 weeks; 10D = 10 days

$trays = [];

for($i = 1; $i <= $trays_total; $i++)
{
  $trays[$i]['start'] = Datetime::createFromFormat('Ymd', $start_date)->format('Ymd');
  $trays[$i]['end'] = Datetime::createFromFormat('Ymd', $start_date)->add(new DateInterval('P1D'))->format('Ymd');
  $trays[$i]['percent'] = round(((100/$trays_total)*$i)-(100/$trays_total));

  $start_date = Datetime::createFromFormat('Ymd', $start_date)->add(new DateInterval('P'.$interval))->format('Ymd');
}


echo "
BEGIN:VCALENDAR\n
PRODID:-//Google Inc//Google Calendar 70.9054//EN\n
VERSION:2.0\n
CALSCALE:GREGORIAN\n
METHOD:PUBLISH\n
X-WR-TIMEZONE:UTC\n\n";

foreach($trays as $number => $tray)
{
  echo "
  BEGIN:VEVENT\n
  DTSTART;VALUE=DATE:".$tray['start']."\n
  DTEND;VALUE=DATE:".$tray['end']."\n
  DTSTAMP:20170523T095508Z\n
  X-GOOGLE-CALENDAR-CONTENT-TITLE:".$number." of ".$trays_total." (".$tray['percent']."%)\n
  CLASS:PRIVATE\n
  CREATED:20070517T000000Z\n
  LAST-MODIFIED:20070517T000000Z\n
  SEQUENCE:0\n
  STATUS:CONFIRMED\n
  SUMMARY: Invisalign ".$number." of ".$trays_total." (".$tray['percent']."%)\n
  TRANSP:OPAQUE\n
  END:VEVENT\n\n
  ";
}

echo "END:VCALENDAR";