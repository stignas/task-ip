<?php

namespace App\Services;

class DriverExpenseService
{
    public function calculateDriverExpenses(array $drivers, array $expenses)
    {
        $result = [];
        $counter = 0;
        $result['Expenses'] = $expenses;
        $result['Expenses']['total'] = number_format(array_sum($result['Expenses']), 2, '.','');

        foreach ($expenses as $expenseType => $expenseAmount) {
            $halfExpense = $expenseAmount / 2;
            $halfExpenseRoundUp = number_format(round($halfExpense, 2), 2, '.', '');
            $halfExpenseRoundDown = number_format(round($halfExpense, 2, PHP_ROUND_HALF_DOWN), 2, '.', '');

            if ($halfExpense != number_format($halfExpense, 2)) {
                $counter++;
                if ($counter % 2 != 0) {
                    $result[$drivers[0]][$expenseType] = $halfExpenseRoundUp;
                    $result[$drivers[1]][$expenseType] = $halfExpenseRoundDown;
                } else {
                    $result[$drivers[0]][$expenseType] = $halfExpenseRoundDown;
                    $result[$drivers[1]][$expenseType] = $halfExpenseRoundUp;
                }
            } else {
                $result[$drivers[0]][$expenseType] = number_format($halfExpense, 2, '.', '');
                $result[$drivers[1]][$expenseType] = number_format($halfExpense, 2, '.', '');
            }
        }

        // Totals
        $result[$drivers[0]]['total'] = number_format(array_sum($result[$drivers[0]]), 2,'.','');
        $result[$drivers[1]]['total'] = number_format(array_sum($result[$drivers[1]]), 2,'.','');
        return $result;
    }
}
