<?php
/**
 * View Helper Functions
 */

/**
 * Get current page name
 *
 * @return string
 */
function getCurrentPage() {
    $uri = $_SERVER['REQUEST_URI'];
    $path = parse_url($uri, PHP_URL_PATH);
    $path = trim(str_replace(dirname($_SERVER['SCRIPT_NAME']), '', $path), '/');
    
    if (empty($path)) {
        return 'home';
    }
    
    $parts = explode('/', $path);
    return $parts[0];
}

/**
 * Check if current page matches given page
 *
 * @param string $page Page name
 * @return bool
 */
function isCurrentPage($page) {
    return getCurrentPage() === $page;
}

/**
 * Set active class if current page matches given page
 *
 * @param string $page Page name
 * @param string $class CSS class (default: 'active')
 * @return string
 */
function setActiveClass($page, $class = 'active') {
    return isCurrentPage($page) ? $class : '';
}

/**
 * Truncate text to a certain length
 *
 * @param string $text Text to truncate
 * @param int $length Maximum length
 * @param string $append Text to append if truncated (default: '...')
 * @return string
 */
function truncateText($text, $length = 100, $append = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    
    $text = substr($text, 0, $length);
    $text = substr($text, 0, strrpos($text, ' '));
    
    return $text . $append;
}

/**
 * Generate pagination links
 *
 * @param int $currentPage Current page number
 * @param int $totalPages Total number of pages
 * @param string $baseUrl Base URL for pagination links
 * @param array $params Additional URL parameters
 * @return string
 */
function generatePagination($currentPage, $totalPages, $baseUrl, $params = []) {
    if ($totalPages <= 1) {
        return '';
    }
    
    // Build query string from params
    $queryString = '';
    if (!empty($params)) {
        $queryParams = [];
        foreach ($params as $key => $value) {
            if ($key !== 'page' && $value !== '') {
                $queryParams[] = urlencode($key) . '=' . urlencode($value);
            }
        }
        if (!empty($queryParams)) {
            $queryString = '&' . implode('&', $queryParams);
        }
    }
    
    $output = '<nav aria-label="Page navigation">';
    $output .= '<ul class="pagination justify-content-center">';
    
    // Previous button
    if ($currentPage > 1) {
        $output .= '<li class="page-item">';
        $output .= '<a class="page-link" href="' . $baseUrl . '?page=' . ($currentPage - 1) . $queryString . '" aria-label="Previous">';
        $output .= '<span aria-hidden="true">&laquo;</span>';
        $output .= '</a>';
        $output .= '</li>';
    } else {
        $output .= '<li class="page-item disabled">';
        $output .= '<a class="page-link" href="#" aria-label="Previous">';
        $output .= '<span aria-hidden="true">&laquo;</span>';
        $output .= '</a>';
        $output .= '</li>';
    }
    
    // Page numbers
    $startPage = max(1, $currentPage - 2);
    $endPage = min($totalPages, $currentPage + 2);
    
    // Ensure we always show 5 pages when possible
    if ($endPage - $startPage < 4) {
        if ($startPage > 1) {
            $startPage = max(1, $endPage - 4);
        } else {
            $endPage = min($totalPages, $startPage + 4);
        }
    }
    
    // First page link if not in range
    if ($startPage > 1) {
        $output .= '<li class="page-item">';
        $output .= '<a class="page-link" href="' . $baseUrl . '?page=1' . $queryString . '">1</a>';
        $output .= '</li>';
        
        if ($startPage > 2) {
            $output .= '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
        }
    }
    
    // Page links
    for ($i = $startPage; $i <= $endPage; $i++) {
        $output .= '<li class="page-item' . ($i == $currentPage ? ' active' : '') . '">';
        $output .= '<a class="page-link" href="' . $baseUrl . '?page=' . $i . $queryString . '">' . $i . '</a>';
        $output .= '</li>';
    }
    
    // Last page link if not in range
    if ($endPage < $totalPages) {
        if ($endPage < $totalPages - 1) {
            $output .= '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
        }
        
        $output .= '<li class="page-item">';
        $output .= '<a class="page-link" href="' . $baseUrl . '?page=' . $totalPages . $queryString . '">' . $totalPages . '</a>';
        $output .= '</li>';
    }
    
    // Next button
    if ($currentPage < $totalPages) {
        $output .= '<li class="page-item">';
        $output .= '<a class="page-link" href="' . $baseUrl . '?page=' . ($currentPage + 1) . $queryString . '" aria-label="Next">';
        $output .= '<span aria-hidden="true">&raquo;</span>';
        $output .= '</a>';
        $output .= '</li>';
    } else {
        $output .= '<li class="page-item disabled">';
        $output .= '<a class="page-link" href="#" aria-label="Next">';
        $output .= '<span aria-hidden="true">&raquo;</span>';
        $output .= '</a>';
        $output .= '</li>';
    }
    
    $output .= '</ul>';
    $output .= '</nav>';
    
    return $output;
}

/**
 * Display star rating
 *
 * @param float $rating Rating value (0-5)
 * @param bool $showEmpty Show empty stars (default: true)
 * @param string $fullStar Full star icon (default: '<i class="fas fa-star"></i>')
 * @param string $halfStar Half star icon (default: '<i class="fas fa-star-half-alt"></i>')
 * @param string $emptyStar Empty star icon (default: '<i class="far fa-star"></i>')
 * @return string
 */
function displayStarRating($rating, $showEmpty = true, $fullStar = '<i class="fas fa-star"></i>', $halfStar = '<i class="fas fa-star-half-alt"></i>', $emptyStar = '<i class="far fa-star"></i>') {
    $rating = min(5, max(0, $rating));
    $output = '<div class="rating">';
    
    $fullStars = floor($rating);
    $halfStars = ceil($rating - $fullStars);
    $emptyStars = 5 - $fullStars - $halfStars;
    
    // Full stars
    for ($i = 0; $i < $fullStars; $i++) {
        $output .= $fullStar;
    }
    
    // Half stars
    for ($i = 0; $i < $halfStars; $i++) {
        $output .= $halfStar;
    }
    
    // Empty stars
    if ($showEmpty) {
        for ($i = 0; $i < $emptyStars; $i++) {
            $output .= $emptyStar;
        }
    }
    
    $output .= '</div>';
    
    return $output;
}

/**
 * Check if a URL contains a specific string
 *
 * @param string $needle String to search for
 * @return bool
 */
function urlContains($needle) {
    return strpos($_SERVER['REQUEST_URI'], $needle) !== false;
}

/**
 * Get the current full URL
 *
 * @return string
 */
function getCurrentUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

/**
 * Generate breadcrumbs
 *
 * @param array $items Breadcrumb items [label => url]
 * @return string
 */
function generateBreadcrumbs($items) {
    $output = '<nav aria-label="breadcrumb">';
    $output .= '<ol class="breadcrumb">';
    
    $i = 0;
    $count = count($items);
    
    foreach ($items as $label => $url) {
        $i++;
        
        if ($i === $count) {
            // Last item (active)
            $output .= '<li class="breadcrumb-item active" aria-current="page">' . $label . '</li>';
        } else {
            // Other items
            $output .= '<li class="breadcrumb-item"><a href="' . $url . '">' . $label . '</a></li>';
        }
    }
    
    $output .= '</ol>';
    $output .= '</nav>';
    
    return $output;
}