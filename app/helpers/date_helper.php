<?php
/**
 * Date Helper Functions
 */

/**
 * Format date to readable format
 *
 * @param string $date Date string
 * @param string $format Format (default: 'd M Y')
 * @return string Formatted date
 */
function formatDate($date, $format = 'd M Y') {
    if (empty($date)) {
        return '';
    }
    
    $dateTime = new DateTime($date);
    return $dateTime->format($format);
}

/**
 * Format date and time
 *
 * @param string $date Date string
 * @param string $format Format (default: 'd M Y H:i')
 * @return string Formatted date and time
 */
function formatDateTime($date, $format = 'd M Y H:i') {
    if (empty($date)) {
        return '';
    }
    
    $dateTime = new DateTime($date);
    return $dateTime->format($format);
}

/**
 * Get time elapsed from date (e.g. "2 days ago")
 *
 * @param string $date Date string
 * @return string Elapsed time
 */
function timeElapsed($date) {
    if (empty($date)) {
        return '';
    }
    
    $dateTime = new DateTime($date);
    $now = new DateTime();
    $interval = $now->diff($dateTime);
    
    if ($interval->y >= 1) {
        return $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
    } else if ($interval->m >= 1) {
        return $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
    } else if ($interval->d >= 1) {
        return $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
    } else if ($interval->h >= 1) {
        return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
    } else if ($interval->i >= 1) {
        return $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
    } else {
        return 'just now';
    }
}

/**
 * Calculate number of days between two dates
 *
 * @param string $startDate Start date string
 * @param string $endDate End date string
 * @return int Number of days
 */
function calculateDaysBetween($startDate, $endDate) {
    if (empty($startDate) || empty($endDate)) {
        return 0;
    }
    
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $interval = $start->diff($end);
    
    return $interval->days;
}

/**
 * Check if date is in the past
 *
 * @param string $date Date string
 * @return bool
 */
function dateIsPast($date) {
    if (empty($date)) {
        return false;
    }
    
    $dateTime = new DateTime($date);
    $now = new DateTime();
    
    return $dateTime < $now;
}

/**
 * Check if date is in the future
 *
 * @param string $date Date string
 * @return bool
 */
function dateIsFuture($date) {
    if (empty($date)) {
        return false;
    }
    
    $dateTime = new DateTime($date);
    $now = new DateTime();
    
    return $dateTime > $now;
}

/**
 * Get dates between two dates as an array
 *
 * @param string $startDate Start date string
 * @param string $endDate End date string
 * @param string $format Format (default: 'Y-m-d')
 * @return array Array of dates
 */
function getDateRange($startDate, $endDate, $format = 'Y-m-d') {
    if (empty($startDate) || empty($endDate)) {
        return [];
    }
    
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $interval = new DateInterval('P1D'); // 1 day interval
    
    // Create period iterator
    $period = new DatePeriod($start, $interval, $end);
    
    // Generate array of dates
    $dates = [];
    foreach ($period as $date) {
        $dates[] = $date->format($format);
    }
    
    // Add the end date
    $dates[] = $end->format($format);
    
    return $dates;
}

/**
 * Validate date format
 *
 * @param string $date Date string
 * @param string $format Format (default: 'Y-m-d')
 * @return bool
 */
function validateDate($date, $format = 'Y-m-d') {
    if (empty($date)) {
        return false;
    }
    
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}