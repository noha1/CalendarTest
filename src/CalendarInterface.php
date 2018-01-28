<?php

namespace Calendar;

use DateTimeInterface;

interface CalendarInterface
{
    /**
     * @param DateTimeInterface $datetime
     */
    public function __construct(DateTimeInterface $datetime);

    /**
     * Get the day
     *
     * @return int
     */
    public function getDay();

    /**
     * Get the weekday (1-7, 1 = Monday)
     *
     * @return int
     */
    public function getWeekDay();

    /**
     * Get the first weekday of this month (1-7, 1 = Monday)
     *
     * @return int
     */
    public function getFirstWeekDay();

    /**
     * Get the first week of this month (18th March => 9 because March starts on week 9)
     *
     * @return int
     */
    public function getFirstWeek();

    /**
     * Get the number of days in this month
     *
     * @return int
     */
    public function getNumberOfDaysInThisMonth();

    /**
     * Get the number of days in the previous month
     *
     * @return int
     */
    public function getNumberOfDaysInPreviousMonth();

    /**
     * Get the calendar array
     *
     * @return array
     */
    public function getCalendar();
}


<?php

namespace Calendar;

use DateTimeInterface;

interface CalendarInterface
{
    /**
     * @param DateTimeInterface $datetime
     */
    public function __construct(DateTimeInterface $datetime);

    /**
     * Get the day
     *
     * @return int
     */
    public function getDay();

    /**
     * Get the weekday (1-7, 1 = Monday)
     *
     * @return int
     */
    public function getWeekDay();

    /**
     * Get the first weekday of this month (1-7, 1 = Monday)
     *
     * @return int
     */
    public function getFirstWeekDay();

    /**
     * Get the first week of this month (18th March => 9 because March starts on week 9)
     *
     * @return int
     */
    public function getFirstWeek();

    /**
     * Get the number of days in this month
     *
     * @return int
     */
    public function getNumberOfDaysInThisMonth();

    /**
     * Get the number of days in the previous month
     *
     * @return int
     */
    public function getNumberOfDaysInPreviousMonth();

    /**
     * Get the calendar array
     *
     * @return array
     */
    public function getCalendar();
}

 class Calendar implements DateTimeInterface
{
  var $local_time;
  var $cur_month;
  var $cur_year;
	var $cur_day;
	var $start_day		= 'monday';

  public function __construct(DateTimeInterface $datetime)
{
  $this->local_time= date_format($datetime, 'Y-m-j');
  $this->cur_year	=  date_format($datetime, 'Y');
  $this->cur_month	=   date_format($datetime, 'm');
  $this->cur_day =   date_format($datetime, 'j');//date("j", $this->local_time);
  //log_message('debug', "Calendar Class Initialized");
}


  /**
   * Get the day
   *
   * @return int
   */
  public function getDay(){
    	return $this->cur_day;
  }

  /**
   * Get the weekday (1-7, 1 = Monday)
   *
   * @return int
   */
  public function getWeekDay(){
    $jd = gregoriantojd($this->cur_month,$this->cur_day,$this->cur_year);
    return jddayofweek($jd,0);
  }

  /**
   * Get the first weekday of this month (1-7, 1 = Monday)
   *
   * @return int
   */
  public function getFirstWeekDay()
  {    $ym	= $this->cur_year."-". $this->cur_month;
      return strftime("%d", strtotime("first monday of ".$ym));
    }

  /**
   * Get the first week of this month (18th March => 9 because March starts on week 9)
   *
   * @return int
   */
  public function getFirstWeek()
  {
    return date('W', $this->local_time);

    }

  /**
   * Get the number of days in this month
   *
   * @return int
   */
  public function getNumberOfDaysInThisMonth(){

    $days_in_month	= array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

    		if ($month < 1 OR $month > 12)
    		{
    			return 0;
    		}

    		// Is the year a leap year?
    		if ($month == 2)
    		{
    			if ($year % 400 == 0 OR ($year % 4 == 0 AND $year % 100 != 0))
    			{
    				return 29;
    			}
    		}

    		return $days_in_month[$month - 1];  }

  /**
   * Get the number of days in the previous month
   *
   * @return int
   */
  public function getNumberOfDaysInPreviousMonth()
  {
      return date("t", mktime(0,0,0, $this->cur_month - 1));
  }


/**
* Get weeks in a month
* @return int
*
*/

function getWeeks()
    {
      $num_of_days = date("t", mktime(0,0,0,$this->cur_month,1,$this->cur_year));
      $lastday = date("t", mktime(0, 0, 0, $this->cur_month, 1, $this->cur_year));
      $no_of_weeks = 0;
      $count_weeks = 0;
      while($no_of_weeks < $lastday){
          $no_of_weeks += 7;
          $count_weeks++;
      }
return $count_weeks;
    }
  /**
   * Get the calendar array
   *
   * @return array
   */
  public function getCalendar(){
    $result = array() ;
    $iFirstWeek= $this->getFirstWeek();
    $iWeekDay= $this->getWeekDay();  //Get the week of this date
    $iDaysInThisMonth=$this->getNumberOfDaysInThisMonth(); //total numbers of this month to draw
    $iweeks= $this->getWeeks();
    $iDaysInPreviousMonth=$this->getNumberOfDaysInPreviousMonth(); //to populate the rest of the week
    //creating the array result populating the keys and another array of values.
    //where iweeks the max no for iteration and the key is the week no of month in year $iWeekDay
    $aweekdays= array(); // to do populate with the monthly days and adding the missing ones from the week b4 in case.
      /****work in progress****/
      /*function getWeekDates($date, $start_date, $end_date)
        {
            $week =  date('W', strtotime($this->local_time));
            $year =  $this->cur_year;
            $from = date("Y-m-d", strtotime("{$year}-W{$week}+1"));
            if($from < $start_date) $from = $start_date;

            $to = date("Y-m-d", strtotime("{$year}-W{$week}-6")); 
            if($to > $end_date) $to = $end_date;

        $array1 = array(
                "ssdate" => $from,
                "eedate" => $to,
        );

        return $array1;

           // echo "Start Date-->".$from."End Date -->".$to;
        }
       
    $x = 0;
    while($x < $iweeks) {

        $result[$iFirstWeek + x] = $aweekdays[x];


         $x++;
            }


    */

    return $result;
  }
}

