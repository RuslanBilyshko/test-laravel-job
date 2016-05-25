<?php namespace App\Http\Controllers;


use Carbon\Carbon;


class Date {

	private static $tz = 'Europe/Kiev';
	private static $currDate;

	private static function setParseCurrDate()
	{
		self::$currDate = Carbon::parse(Carbon::now(self::$tz));
	}

	public static function currentTimestampDate()
	{
		self::setParseCurrDate();
		return self::$currDate->timestamp;
	}

  public static function getDate($field)
  {
		return Carbon::createFromTimestamp($field)->format('d.m.Y');
  }

  public static function getTime($field)
  {
		$dt = Carbon::createFromTimestamp($field);
		$hour = $dt->hour;
		$minute = $dt->minute;
		if($hour < 10)
			$hour = '0'.$dt->hour;

		if($minute < 10)
			$minute = '0'.$dt->minute;

		$time = $hour.":".$minute;
		return $time;
  }

	public static function getDateTime($field)
	{
		return self::getDate($field).' '.self::getTime($field);
	}

	public static function dateOfBirth($timestamp)
	{

	}

  /**
   * Обрабатывает элементи массива с ключами date and time
   * из формата timestamp в удобочетаемый формат   *
   * @param $array
   * @param bool $flag (true = для двумерных массивов, false = для одномерных, по-умолчанию)
   * @return mixed
   */
  public static function handlerDateTime($array, $flag = false)
  {
		if($flag)
		{
			for($i = 0; $i < count($array); $i++)
			{
				if(isset($array[$i]->date))
					$array[$i]->date = self::getDate($array[$i]->date);

				if(isset($array[$i]->created))
					$array[$i]->created = self::getDate($array[$i]->created);

				if(isset($array[$i]->update))
					$array[$i]->update = self::getDate($array[$i]->update);

				if(isset($array[$i]->time))
					$array[$i]->time = self::getTime($array[$i]->time);
			}
		}
		else
		{
			foreach($array as $key => $value)
			{
				if($key == 'date')
					$array->$key = self::getDate($value);

				if($key == 'created')
					$array->$key = self::getDate($value);

				if($key == 'update')
					$array->$key = self::getDate($value);

				if($key == 'time')
					$array->$key = self::getTime($value);
			}
		}

		return $array;
  }

  /**
   * Генерирует данные для поля типа SELECT с выбором времени
   * Интервал по умолчанию 30 мин.
   * В ключах записано колличество секунд для обьединения с основной датой
   * @param int $leftHour
   * @param int $rightHour
   * @param int $intervalMinute
   */
  public static function dataForTimeSelectField($leftHour = 10, $rightHour = 19,$intervalMinute = 30)
  {
	for($i = $leftHour; $i <= $rightHour; $i++)
	{
	  $key = (60*60*$i);
	  $key2 = (60*60*$i) + (60*$intervalMinute);

	  $data[$key] = $i.':00';
	  $data[$key2] = $i.':30';
	}

	return $data;
  }
  
}