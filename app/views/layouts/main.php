<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo !empty($data['title']) ? $data['title'] . ' - ' . SITENAME : SITENAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/animations.css">
    
    <!-- Favicon -->
    <link rel="icon" href="<?php echo ASSETS_URL; ?>/images/favicon.ico">
    
    <!-- Additional CSS -->
    <?php if (isset($data['extraCSS'])): ?>
        <?php echo $data['extraCSS']; ?>
    <?php endif; ?>
</head>
<body>
    <!-- Header -->
    <?php require APPROOT . '/views/layouts/header.php'; ?>
    
    <!-- Main Content -->
    <main>
        <?php include APPROOT . '/views/' . $view . '.php'; ?>
    </main>
    
    <!-- Footer -->
    <?php require APPROOT . '/views/layouts/footer.php'; ?>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Custom JS -->
    <script src="<?php echo ASSETS_URL; ?>/js/main.js"></script>
    <script src="<?php echo ASSETS_URL; ?>/js/animations.js"></script>
    <script src="<?php echo ASSETS_URL; ?>/js/validation.js"></script>
    
    <!-- Additional JS -->
    <?php if (isset($data['extraJS'])): ?>
        <?php echo $data['extraJS']; ?>
    <?php endif; ?>
</body>
</html>