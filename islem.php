<?php
// 1. HATALARI GÖSTER (Neyin yanlış olduğunu anlamak için)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. SİLME MEKANİZMASI
if (isset($_GET['sil'])) {
    $dosya = $_GET['sil'];
    if (file_exists($dosya) && strpos($dosya, 'PRO_TASARIM_') === 0) {
        unlink($dosya);
    }
    header("Location: index.php");
    exit;
}

// 3. TASARIM OLUŞTURMA MEKANİZMASI
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["resim"])) {
    
    $mesaj = $_POST['mesaj'];
    $stil = $_POST['stil'];
    $filtre = $_POST['filtre'];
    
    $dosya_adi = basename($_FILES["resim"]["name"]);
    
    if (move_uploaded_file($_FILES["resim"]["tmp_name"], $dosya_adi)) {
        
        // Python'u çalıştır
        $komut = "python tasarim.py " . 
                 escapeshellarg($dosya_adi) . " " . 
                 escapeshellarg($mesaj) . " " . 
                 escapeshellarg($stil) . " " . 
                 escapeshellarg($filtre);
        
        shell_exec($komut);
        
        // Sonuç sayfasına gitmek yerine direkt ana sayfaya (galeriye) dönelim 
        // Böylece yeni tasarımı anında galeride görürsün
        header("Location: index.php");
        exit;
        
    } else {
        echo "Resim yükleme hatası!";
    }
}
?>