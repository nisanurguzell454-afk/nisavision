<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>NisaVision PRO</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #fff5f8; text-align: center; padding: 20px; }
        .container { background: white; padding: 30px; border-radius: 20px; display: inline-block; border: 2px solid #ffb6c1; width: 450px; box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        h2 { color: #ff69b4; margin-bottom: 5px; }
        input, select { width: 90%; padding: 12px; margin: 8px 0; border-radius: 10px; border: 1px solid #ddd; }
        button { width: 95%; padding: 15px; background: linear-gradient(to right, #ff69b4, #ff1493); color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: bold; margin-top: 10px; }
        .gallery { margin-top: 40px; display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; width: 90%; margin-left: auto; margin-right: auto; }
        .card { background: white; padding: 10px; border-radius: 15px; box-shadow: 0 5px 10px rgba(0,0,0,0.1); border: 1px solid #ffb6c1; }
        .card img { width: 200px; height: 150px; object-fit: cover; border-radius: 10px; }
        .delete-btn { display: block; margin-top: 8px; color: #ff0000; text-decoration: none; font-size: 13px; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h2>✨ NisaVision PRO</h2>
    <p style="color: #888; font-size: 14px;">Görsel Tasarım ve Yönetim Paneli</p>
    
    <form action="islem.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="resim" required>
        <input type="text" name="mesaj" placeholder="Resim üzerine mesajınız..." required>
        
        <select name="stil">
            <option value="modern">Modern Stil</option>
            <option value="neon">Neon Stil</option>
            <option value="minimal">Minimal Stil</option>
        </select>
        
        <select name="filtre">
            <option value="none">Filtre Yok</option>
            <option value="grayscale">Siyah-Beyaz</option>
            <option value="sepia">Sepya</option>
            <option value="blur">Bulanık</option>
        </select>
        
        <button type="submit">Tasarımı Oluştur 🚀</button>
    </form>
</div>

<div class="gallery">
    <?php
    // Klasördeki PRO_TASARIM_ ile başlayan resimleri listele
    $resimler = glob("PRO_TASARIM_*.{jpg,png,jpeg}", GLOB_BRACE);
    
    if($resimler) {
        foreach($resimler as $r) {
            echo '<div class="card">';
            echo '<img src="'.$r.'">';
            // SİLME LİNKİ: islem.php'ye dosya yolunu gönderir
            echo '<a href="islem.php?sil='.$r.'" class="delete-btn" onclick="return confirm(\'Silmek istediğine emin misin?\')">🗑️ SİL</a>';
            echo '</div>';
        }
    } else {
        echo '<p style="color:#888;">Henüz kayıtlı bir tasarım yok.</p>';
    }
    ?>
</div>

<footer style="margin-top: 50px; color: #ffb6c1;">
    Nisa Nur Güzel | 2026 Erzurum 🎓
</footer>

</body>
</html>