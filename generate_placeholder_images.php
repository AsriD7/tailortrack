<?php
/**
 * Generate placeholder images untuk TailorTrack seeder
 * Jalankan: php generate_placeholder_images.php
 */

$basePath = __DIR__ . '/storage/app/public';

// Buat direktori jika belum ada
$dirs = ['tailor-profiles', 'portfolios'];
foreach ($dirs as $dir) {
    if (!is_dir("$basePath/$dir")) {
        mkdir("$basePath/$dir", 0775, true);
        echo "Created directory: $basePath/$dir\n";
    }
}

/**
 * Generate avatar image dengan inisial dan warna gradient
 */
function generateAvatarImage(string $initials, string $filename, array $colorTop, array $colorBottom): void
{
    $size = 200;
    $img  = imagecreatetruecolor($size, $size);

    // Gambar gradient vertikal
    for ($y = 0; $y < $size; $y++) {
        $r = (int)($colorTop[0] + ($colorBottom[0] - $colorTop[0]) * $y / $size);
        $g = (int)($colorTop[1] + ($colorBottom[1] - $colorTop[1]) * $y / $size);
        $b = (int)($colorTop[2] + ($colorBottom[2] - $colorTop[2]) * $y / $size);
        $color = imagecolorallocate($img, $r, $g, $b);
        imageline($img, 0, $y, $size, $y, $color);
    }

    // Rounded corner mask (simulasi dengan lingkaran di sudut)
    $white = imagecolorallocate($img, 255, 255, 255);
    imagecolortransparent($img, $white);

    // Tulis inisial di tengah
    $textColor = imagecolorallocate($img, 255, 255, 255);
    $fontSize  = 5; // font bawaan PHP

    // Hitung posisi text di tengah
    $textWidth  = strlen($initials) * imagefontwidth($fontSize);
    $textHeight = imagefontheight($fontSize);
    $x          = (int)(($size - $textWidth) / 2);
    $y          = (int)(($size - $textHeight) / 2);

    imagestring($img, $fontSize, $x, $y, $initials, $textColor);

    imagejpeg($img, $filename, 90);
    imagedestroy($img);

    echo "Generated: $filename\n";
}

/**
 * Generate portfolio placeholder image dengan motif kain
 */
function generatePortfolioImage(string $filename, string $title, string $category, array $color1, array $color2): void
{
    $width  = 400;
    $height = 300;
    $img    = imagecreatetruecolor($width, $height);

    // Background gradient diagonal
    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            $t = ($x + $y) / ($width + $height);
            $r = (int)($color1[0] + ($color2[0] - $color1[0]) * $t);
            $g = (int)($color1[1] + ($color2[1] - $color1[1]) * $t);
            $b = (int)($color1[2] + ($color2[2] - $color1[2]) * $t);
            imagesetpixel($img, $x, $y, imagecolorallocate($img, $r, $g, $b));
        }
    }

    // Gambar pola grid dekoratif
    $lineColor = imagecolorallocatealpha($img, 255, 255, 255, 100);
    for ($i = 0; $i < $width; $i += 30) {
        imageline($img, $i, 0, $i, $height, imagecolorallocate($img, 255, 255, 255));
    }
    for ($i = 0; $i < $height; $i += 30) {
        imageline($img, 0, $i, $width, $i, imagecolorallocate($img, 255, 255, 255));
    }

    // Overlay gelap di bawah untuk text
    $darkOverlay = imagecolorallocate($img, 0, 0, 0);
    imagefilledrectangle($img, 0, $height - 80, $width, $height, imagecolorallocate($img, 30, 30, 60));

    // Tulis judul dan kategori
    $textColor     = imagecolorallocate($img, 255, 255, 255);
    $subtitleColor = imagecolorallocate($img, 200, 200, 255);

    $titleStr = strlen($title) > 30 ? substr($title, 0, 27) . '...' : $title;
    imagestring($img, 4, 15, $height - 65, $titleStr, $textColor);
    imagestring($img, 3, 15, $height - 40, $category, $subtitleColor);

    // Ikon gambar dekoratif di tengah
    $iconColor = imagecolorallocate($img, 255, 255, 255);
    imagearc($img, (int)($width / 2) - 30, (int)($height / 2) - 30, 60, 60, 0, 360, $iconColor);
    imageline($img, (int)($width / 2) - 60, (int)($height / 2) + 10, (int)($width / 2) - 20, (int)($height / 2) - 10, $iconColor);
    imageline($img, (int)($width / 2) - 20, (int)($height / 2) - 10, (int)($width / 2) + 20, (int)($height / 2), $iconColor);
    imageline($img, (int)($width / 2) + 20, (int)($height / 2), (int)($width / 2) + 60, (int)($height / 2) - 30, $iconColor);

    imagejpeg($img, $filename, 90);
    imagedestroy($img);

    echo "Generated: $filename\n";
}

// =====================================================================
// Generate Tailor Profile Photos
// =====================================================================

$tailorAvatars = [
    ['initials' => 'LT', 'filename' => 'tailor-lina.jpg',  'top' => [99, 102, 241], 'bottom' => [124, 58, 237]],  // indigo → purple
    ['initials' => 'DM', 'filename' => 'tailor-dian.jpg',  'top' => [139, 92, 246], 'bottom' => [217, 70, 239]],  // violet → fuchsia
    ['initials' => 'RJ', 'filename' => 'tailor-rapi.jpg',  'top' => [59, 130, 246], 'bottom' => [99, 102, 241]],  // blue → indigo
];

foreach ($tailorAvatars as $avatar) {
    $filepath = "$basePath/tailor-profiles/{$avatar['filename']}";
    generateAvatarImage($avatar['initials'], $filepath, $avatar['top'], $avatar['bottom']);
}

// =====================================================================
// Generate Portfolio Placeholder Images
// =====================================================================

$portfolioImages = [
    // Lina Tailor
    ['file' => 'portfolio-kebaya-modern.jpg', 'title' => 'Kebaya Modern Pengantin', 'cat' => 'Kebaya',   'c1' => [99, 102, 241], 'c2' => [168, 85, 247]],
    ['file' => 'portfolio-batik-tulis.jpg',   'title' => 'Batik Tulis Halus',       'cat' => 'Atasan',   'c1' => [124, 58, 237], 'c2' => [99, 102, 241]],
    // Dian Modiste
    ['file' => 'portfolio-gaun-pesta.jpg',    'title' => 'Gaun Pesta Malam',        'cat' => 'Dress',    'c1' => [168, 85, 247], 'c2' => [236, 72, 153]],
    ['file' => 'portfolio-dress-casual.jpg',  'title' => 'Dress Casual Modern',     'cat' => 'Terusan',  'c1' => [217, 70, 239], 'c2' => [139, 92, 246]],
    // Rapi Jaya Tailor
    ['file' => 'portfolio-jas-formal.jpg',    'title' => 'Jas Formal Hitam',        'cat' => 'Atasan',   'c1' => [30, 64, 175],  'c2' => [99, 102, 241]],
    ['file' => 'portfolio-kemeja-batik.jpg',  'title' => 'Kemeja Batik Pria',       'cat' => 'Atasan',   'c1' => [55, 48, 163],  'c2' => [30, 64, 175]],
    ['file' => 'portfolio-setelan-jas.jpg',   'title' => 'Setelan Jas Pernikahan',  'cat' => 'Atasan',   'c1' => [79, 70, 229],  'c2' => [55, 48, 163]],
];

foreach ($portfolioImages as $p) {
    $filepath = "$basePath/portfolios/{$p['file']}";
    generatePortfolioImage($filepath, $p['title'], $p['cat'], $p['c1'], $p['c2']);
}

echo "\n✅ Semua placeholder image berhasil di-generate!\n";
echo "Sekarang jalankan: php artisan migrate:fresh --seed\n";
