<?php require APPROOT . '/views/layouts/main.php'; ?>

<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="page-title"><?php echo $data['title']; ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>" class="text-white">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Cars</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Car Listing Section -->
<section class="car-listing-section py-5">
    <div class="container">
        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="filter-card sticky-top" style="top: 20px;">
                    <div class="filter-header">
                        <h4 class="filter-title">Search & Filters</h4>
                    </div>
                    <div class="filter-body">
                        <form action="<?php echo URLROOT; ?>/car" method="GET" id="filter-form">
                            <!-- Dates -->
                            <div class="filter-section">
                                <h5 class="filter-section-title">Dates</h5>
                                <div class="mb-3">
                                    <label for="pickup_date" class="form-label">Pickup Date</label>
                                    <input type="date" class="form-control" id="pickup_date" name="pickup_date" value="<?php echo $data['pickup_date']; ?>" min="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="return_date" class="form-label">Return Date</label>
                                    <input type="date" class="form-control" id="return_date" name="return_date" value="<?php echo $data['return_date']; ?>" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                                </div>
                            </div>
                            
                            <!-- Search -->
                            <div class="filter-section">
                                <h5 class="filter-section-title">Search</h5>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search..." name="search" value="<?php echo $data['filters']['search']; ?>">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Brand Filter -->
                            <div class="filter-section">
                                <h5 class="filter-section-title">Brand</h5>
                                <div class="mb-3">
                                    <select class="form-select" name="brand" id="brand">
                                        <option value="">All Brands</option>
                                        <?php foreach($data['brands'] as $brand): ?>
                                            <option value="<?php echo $brand['brand']; ?>" <?php echo ($data['filters']['brand'] == $brand['brand']) ? 'selected' : ''; ?>>
                                                <?php echo $brand['brand']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Price Range -->
                            <div class="filter-section">
                                <h5 class="filter-section-title">Price Range</h5>
                                <div class="mb-3">
                                    <label for="price-range" class="form-label">Max Price: <span id="price-value"><?php echo !empty($data['filters']['max_price']) ? number_format($data['filters']['max_price']) : '2,000,000'; ?> VND</span></label>
                                    <input type="range" class="form-range" min="100000" max="2000000" step="100000" id="price-range" name="max_price" value="<?php echo !empty($data['filters']['max_price']) ? $data['filters']['max_price'] : '2000000'; ?>">
                                </div>
                            </div>
                            
                            <!-- Seats Filter -->
                            <div class="filter-section">
                                <h5 class="filter-section-title">Seats</h5>
                                <div class="mb-3">
                                    <select class="form-select" name="seats" id="seats">
                                        <option value="">Any Seats</option>
                                        <option value="2" <?php echo ($data['filters']['seats'] == '2') ? 'selected' : ''; ?>>2 Seats</option>
                                        <option value="4" <?php echo ($data['filters']['seats'] == '4') ? 'selected' : ''; ?>>4 Seats</option>
                                        <option value="5" <?php echo ($data['filters']['seats'] == '5') ? 'selected' : ''; ?>>5 Seats</option>
                                        <option value="7" <?php echo ($data['filters']['seats'] == '7') ? 'selected' : ''; ?>>7 Seats</option>
                                        <option value="8" <?php echo ($data['filters']['seats'] == '8') ? 'selected' : ''; ?>>8+ Seats</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Transmission Filter -->
                            <div class="filter-section">
                                <h5 class="filter-section-title">Transmission</h5>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="transmission" id="transmission-all" value="" <?php echo empty($data['filters']['transmission']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="transmission-all">
                                            All
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="transmission" id="transmission-auto" value="auto" <?php echo ($data['filters']['transmission'] == 'auto') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="transmission-auto">
                                            Automatic
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="transmission" id="transmission-manual" value="manual" <?php echo ($data['filters']['transmission'] == 'manual') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="transmission-manual">
                                            Manual
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Apply Filters Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Apply Filters</button>
                                <a href="<?php echo URLROOT; ?>/car" class="btn btn-outline-secondary">Reset Filters</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Car Listing -->
            <div class="col-lg-9">
                <!-- Sort Options -->
                <div class="sort-options mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0"><strong><?php echo $data['pagination']['total_records']; ?></strong> cars found</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="sort-by" class="me-2">Sort by:</label>
                            <select class="form-select form-select-sm" id="sort-by" name="sort">
                                <option value="price-asc">Price: Low to High</option>
                                <option value="price-desc">Price: High to Low</option>
                                <option value="name-asc">Name: A to Z</option>
                                <option value="name-desc">Name: Z to A</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Cars Grid -->
                <div class="row car-list">
                    <?php if(empty($data['cars'])): ?>
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i> No cars found matching your criteria. Please try different filters.
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach($data['cars'] as $car): ?>
                            <div class="col-md-6 col-lg-4 mb-4 animate-on-scroll" data-animation="fadeInUp" 
                                 data-brand="<?php echo $car['brand']; ?>" 
                                 data-price="<?php echo $car['price_per_day']; ?>"
                                 data-name="<?php echo $car['brand'] . ' ' . $car['model']; ?>">
                                <div class="car-card">
                                    <div class="car-image">
                                        <img src="<?php echo !empty($car['image']) ? URLROOT . '/uploads/cars/' . $car['image'] : ASSETS_URL . '/images/car-placeholder.jpg'; ?>" alt="<?php echo $car['brand'] . ' ' . $car['model']; ?>">
                                    </div>
                                    <div class="car-body">
                                        <h5 class="car-title"><?php echo $car['brand'] . ' ' . $car['model']; ?></h5>
                                        <div class="car-price mb-3"><?php echo number_format($car['price_per_day']); ?> VND/day</div>
                                        <div class="car-features mb-3">
                                            <span class="car-feature"><i class="fas fa-calendar"></i> <?php echo $car['year']; ?></span>
                                            <span class="car-feature"><i class="fas fa-user"></i> <?php echo $car['seats']; ?> Seats</span>
                                            <span class="car-feature"><i class="fas fa-cog"></i> <?php echo $car['transmission'] == 'auto' ? 'Auto' : 'Manual'; ?></span>
                                        </div>
                                        <div class="car-status mb-3">
                                            <?php if($car['status'] == 'available'): ?>
                                                <span class="status-available">Available</span>
                                            <?php elseif($car['status'] == 'maintenance'): ?>
                                                <span class="status-maintenance">Maintenance</span>
                                            <?php else: ?>
                                                <span class="status-rented">Rented</span>
                                            <?php endif; ?>
                                        </div>
                                        <a href="<?php echo URLROOT; ?>/car/details/<?php echo $car['id']; ?><?php echo (!empty($data['pickup_date']) && !empty($data['return_date'])) ? '?pickup_date=' . $data['pickup_date'] . '&return_date=' . $data['return_date'] : ''; ?>" class="btn btn-primary w-100">View Details</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <!-- Pagination -->
                <?php if($data['pagination']['total_pages'] > 1): ?>
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php if($data['pagination']['page'] > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo URLROOT; ?>/car?page=<?php echo $data['pagination']['page'] - 1; ?>&search=<?php echo $data['filters']['search']; ?>&brand=<?php echo $data['filters']['brand']; ?>&transmission=<?php echo $data['filters']['transmission']; ?>&seats=<?php echo $data['filters']['seats']; ?>&max_price=<?php echo $data['filters']['max_price']; ?>&pickup_date=<?php echo $data['pickup_date']; ?>&return_date=<?php echo $data['return_date']; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for($i = 1; $i <= $data['pagination']['total_pages']; $i++): ?>
                                <li class="page-item <?php echo ($i == $data['pagination']['page']) ? 'active' : ''; ?>">
                                    <a class="page-link" href="<?php echo URLROOT; ?>/car?page=<?php echo $i; ?>&search=<?php echo $data['filters']['search']; ?>&brand=<?php echo $data['filters']['brand']; ?>&transmission=<?php echo $data['filters']['transmission']; ?>&seats=<?php echo $data['filters']['seats']; ?>&max_price=<?php echo $data['filters']['max_price']; ?>&pickup_date=<?php echo $data['pickup_date']; ?>&return_date=<?php echo $data['return_date']; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if($data['pagination']['page'] < $data['pagination']['total_pages']): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo URLROOT; ?>/car?page=<?php echo $data['pagination']['page'] + 1; ?>&search=<?php echo $data['filters']['search']; ?>&brand=<?php echo $data['filters']['brand']; ?>&transmission=<?php echo $data['filters']['transmission']; ?>&seats=<?php echo $data['filters']['seats']; ?>&max_price=<?php echo $data['filters']['max_price']; ?>&pickup_date=<?php echo $data['pickup_date']; ?>&return_date=<?php echo $data['return_date']; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Extra JavaScript for Car Filtering -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update price range value display
        const priceRange = document.getElementById('price-range');
        const priceValue = document.getElementById('price-value');
        
        if (priceRange && priceValue) {
            priceRange.addEventListener('input', function() {
                priceValue.textContent = parseInt(priceRange.value).toLocaleString() + ' VND';
            });
        }
        
        // Handle sort change
        const sortSelect = document.getElementById('sort-by');
        
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const sortBy = sortSelect.value;
                const carCards = document.querySelectorAll('.car-list > div');
                const carList = document.querySelector('.car-list');
                
                // Convert NodeList to Array for sorting
                const carArray = Array.from(carCards);
                
                carArray.sort(function(a, b) {
                    if (sortBy === 'price-asc') {
                        return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                    } else if (sortBy === 'price-desc') {
                        return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                    } else if (sortBy === 'name-asc') {
                        return a.dataset.name.localeCompare(b.dataset.name);
                    } else if (sortBy === 'name-desc') {
                        return b.dataset.name.localeCompare(a.dataset.name);
                    }
                    return 0;
                });
                
                // Remove all cars from DOM
                carCards.forEach(function(car) {
                    car.remove();
                });
                
                // Append sorted cars back to the DOM
                carArray.forEach(function(car) {
                    carList.appendChild(car);
                });
            });
        }
    });
</script>