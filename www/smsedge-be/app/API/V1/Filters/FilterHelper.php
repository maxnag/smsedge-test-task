<?php

namespace App\API\V1\Filters;


/**
 * Filters
 *
 * @package    filters
 * @subpackage validation
 * @author     Maxim Nagaychenko
 * @copyright  (c) 2013 SPDFL Nagaychenko M.V.
 * @license
 */
class FilterHelper
{

    /**
     * Transform date from dd.mm.YYYY HH:ii:ss to YYYY-mm-dd HH:ii:ss
     * or dd.mm.YYYY to YYYY-mm-dd
     *
     * @param string $value
     *
     * @return string
     */
    public function changeDate($value): string
    {
        if (!empty($value)) {
            if (strpos($value, ' ')) {
                list($date, $time) = explode(' ', $value);
                list($day, $month, $year) = explode('.', $date);
            } else {
                $time = '';
                list($day, $month, $year) = explode('.', $value);
            }

            return trim($year . '-' . $month . '-' . $day . ' ' . $time);
        }

        return $value;
    }

    /**
     * Transform date
     *
     * @param string $date
     * @param string $pattern
     * @return string
     */
    public function timestamp2human($date, $pattern = 'd.m.Y H:i'): string
    {
        if (empty($date)) {
            return $date;
        }

        $dt = new \DateTime($date);

        return $dt->format($pattern);
    }

    /**
     * Filtration with regexp replacing
     *
     * @param string $value
     * @param string $match_pattern
     * @param string $replacement
     *
     * @return string
     */
    public function replace($value, $match_pattern = '', $replacement = ''): string
    {
        if (!empty($value) && !empty($match_pattern)) {
            return preg_replace($match_pattern, $replacement, $value);
        }

        return $value;
    }
}