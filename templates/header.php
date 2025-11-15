<?php
// header.php - Header hoàn chỉnh cho TechHub Vietnam (PHP + CSS nhúng luôn, không cần file CSS riêng)
// Dễ copy-paste vào bất kỳ dự án PHP nào (pure PHP, không cần framework)

session_start(); // Nếu dùng session để lưu giỏ hàng

// Lấy số lượng giỏ hàng (có thể từ session hoặc DB)
$cartCount = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;

// Tiêu đề trang (có thể set từ trang con: $pageTitle = "Trang chủ"; )
$pageTitle = $pageTitle ?? 'TechHub Vietnam';

// Menu chính
$menuItems = [
    ['label' => 'Trang chủ',     'url' => '/index.php'],
    ['label' => 'Điện thoại',    'url' => '/category/phones.php'],
    ['label' => 'Laptop',        'url' => '/category/laptops.php'],
    ['label' => 'Phụ kiện',      'url' => '/category/accessories.php'],
    ['label' => 'Khuyến mãi',    'url' => '/promo.php'],
    ['label' => 'Liên hệ',       'url' => '/contact.php'],
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- CSS nhúng trực tiếp (Tailwind-like + custom) -->
    <style>
        :root {
            --background: #f9fafb;
            --foreground: #1f2937;
            --primary: #3b82f6;
            --primary-foreground: #ffffff;
            --border: #e5e7eb;
            --muted: #f3f4f6;
            --muted-foreground: #6b7280;
            --accent: #f59e0b;
            --accent-foreground: #1f2937;
        }
        body { font-family: system-ui, -apple-system, sans-serif; margin:0; background:var(--background); color:var(--foreground); }
        a { text-decoration:none; }
        .container { max-width:1280px; margin:auto; padding:0 1rem; }
        @media (min-width:640px) {.container { padding:0 1.5rem; }}
        @media (min-width:1024px){.container { padding:0 2rem; }}
        
        /* Flex & Grid */
        .flex { display:flex; }
        .flex-col { flex-direction:column; }
        .items-center { align-items:center; }
        .justify-between { justify-content:space-between; }
        .gap-4 > * + * { margin-left:1rem; }
        .gap-6 > * + * { margin-left:1.5rem; }
        .space-x-8 > * + * { margin-left:2rem; }
        
        /* Text */
        .text-xl { font-size:1.25rem; line-height:1.75rem; }
        .text-2xl { font-size:1.5rem; line-height:2rem; }
        .font-bold { font-weight:700; }
        .text-primary { color:var(--primary); }
        .text-foreground { color:var(--foreground); }
        .hover\:text-primary:hover { color:var(--primary); }
        
        /* Background & Border */
        .bg-white { background:#fff; }
        .bg-primary { background:var(--primary); }
        .text-primary-foreground { color:var(--primary-foreground); }
        .border-b { border-bottom:1px solid var(--border); }
        
        /* Position */
        .sticky { position:sticky; }
        .top-0 { top:0; }
        .z-50 { z-index:50; }
        
        /* Button & Input */
        .btn-primary {
            background:var(--primary); color:var(--primary-foreground);
            padding:0.75rem 1.5rem; border-radius:0.5rem; font-weight:600;
            transition:all .2s; display:inline-flex; align-items:center; gap:0.5rem;
        }
        .btn-primary:hover { opacity:0.9; }
        input[type="search"] {
            padding:0.5rem 1rem; border:1px solid var(--border);
            border-radius:0.5rem; outline:none; width:220px;
        }
        input[type="search"]:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(59,130,246,.3); }
        
        /* Cart badge */
        .cart-badge {
            position:absolute; top:-8px; right:-8px;
            background:var(--accent); color:var(--accent-foreground);
            font-size:0.75rem; font-weight:bold; border-radius:999px;
            min-width:20px; height:20px; display:flex;
            align-items:center; justify-content:center;
        }
        
        /* Mobile menu */
        #mobile-menu { display:none; background:#fff; border-top:1px solid var(--border); padding:1rem 0; }
        #mobile-menu a { display:block; padding:0.75rem 1rem; }
        @media (max-width:767px) {
            .desktop-menu { display:none; }
            #mobile-menu.open { display:block; }
            .search-desktop { display:none; }
        }
        @media (min-width:768px) {
            .mobile-toggle { display:none; }
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

<!-- HEADER -->
<header class="bg-white border-b sticky top-0 z-50">
    <div class="container py-4 flex items-center justify-between">
        
        <!-- Logo -->
        <a href="/index.php" class="text-2xl font-bold text-primary">TechHub VN</a>
        
        <!-- Desktop Menu -->
        <nav class="desktop-menu space-x-8">
            <?php foreach ($menuItems as $item): ?>
                <a href="<?php echo $item['url']; ?>" class="text-foreground hover:text-primary transition font-medium">
                    <?php echo $item['label']; ?>
                </a>
            <?php endforeach; ?>
        </nav>
        
        <!-- Right Icons + Search -->
        <div class="flex items-center gap-6">
            
            <!-- Desktop Search -->
            <form action="/search.php" class="search-desktop">
                <input type="search" name="q" placeholder="Tìm kiếm sản phẩm..." required>
            </form>
            
            <!-- User -->
            <a href="/account/login.php" class="text-foreground hover:text-primary text-xl">
                <i class="far fa-user"></i>
            </a>
            
            <!-- Wishlist -->
            <a href="/wishlist.php" class="text-foreground hover:text-primary text-xl">
                <i class="far fa-heart"></i>
            </a>
            
            <!-- Cart -->
            <a href="/cart.php" class="relative text-foreground hover:text-primary text-xl">
                <i class="fas fa-shopping-cart"></i>
                <?php if ($cartCount > 0): ?>
                    <span class="cart-badge"><?php echo $cartCount; ?></span>
                <?php endif; ?>
            </a>
            
            <!-- Mobile Menu Toggle -->
            <button id="mobile-toggle" class="mobile-toggle text-2xl">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <nav id="mobile-menu">
        <?php foreach ($menuItems as $item): ?>
            <a href="<?php echo $item['url']; ?>" class="block px-4 py-3 hover:bg-gray-100">
                <?php echo $item['label']; ?>
            </a>
        <?php endforeach; ?>
        <div class="px-4 pt-3">
            <form action="/search.php">
                <input type="search" name="q" placeholder="Tìm kiếm..." class="w-full" required>
            </form>
        </div>
    </nav>
</header>

<!-- JS cho mobile menu (nhúng luôn) -->
<script>
    document.getElementById('mobile-toggle').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('open');
    });
</script>

<!-- Nội dung trang bắt đầu từ đây -->
<main class="flex-1 container py-8">
    <!-- Trang con sẽ include hoặc echo nội dung tại đây -->