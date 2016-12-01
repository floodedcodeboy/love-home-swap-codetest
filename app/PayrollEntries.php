<?php

namespace App;

use Carbon\Carbon;

class PayrollEntries
{
    private $year;
    private $months = 12;
    private $expense_dates = [1, 15];

    //
    public function __construct($year)
    {
        $this->year = $year;
    }

    public function getDatesForYear()
    {
        // get salary dates
        $salary_dates = $this->getSalaryDates();
        $expenses_dates = $this->getExpenseDates();

        $dates['month name'] = ['first expenses date', 'second expenses date', 'salaray date'];


        for ($i = 1; $i <= $this->months; $i++)
        {
            $monthName = \DateTime::createFromFormat('!m', $i)->format('F');
            $dates[$monthName] = [$expenses_dates[$i][0], $expenses_dates[$i][1], $salary_dates[$i]];
        }

        return $dates;
    }

    public function getSalaryDates()
    {
        $salary_dates = [];
        for ($i = 1; $i <= $this->months; $i++)
        {
            $ldom = $this->getDaysInMonth($this->year, $i);
            // checks if day is on a weekend and returns the correct day
            $pay_day = $this->getWeekDay($this->year, $i, $ldom);

            $salary_dates[$i] = $pay_day;
        }

        return $salary_dates;
    }

    public function getDaysInMonth($year, $month)
    {
        $dt = Carbon::createFromDate($year, $month, 1);
        return $dt->daysInMonth;
    }

    public function getWeekDay($year, $month, $day, $type = 'salary')
    {
        $dt = Carbon::createFromDate($year, $month, $day);
        if ($dt->isWeekend())
        {
            // pick the last weekday
            if ($type === 'salary')
                return Carbon::parse('last weekday ' . $year.'-'.$month.'-'.$day)->toDateString();
            else
                return Carbon::parse('next monday ' . $year.'-'.$month.'-'.$day)->toDateString();
        }
        return $dt->toDateString();
    }


    public function getExpenseDates()
    {
        $expense_dates = [];

        for ($i =1; $i <= $this->months; $i++)
        {
            $expenses_for_month = [];
            foreach ($this->expense_dates as $pay_date)
            {
                $expense_day = $this->getWeekDay($this->year, $i, $pay_date, 'expenses');
                $expenses_for_month[] = $expense_day;
            }

            $expense_dates[$i] = $expenses_for_month;
        }

        return $expense_dates;
    }

}
