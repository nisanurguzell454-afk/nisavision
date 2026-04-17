import sys
import os
from PIL import Image, ImageDraw, ImageFont, ImageOps, ImageFilter, ImageEnhance

def tasarim_yap(dosya_adi, mesaj, stil, filtre):
    try:
        # 1. DOSYA KONTROLÜ
        if not os.path.exists(dosya_adi):
            print(f"Hata: {dosya_adi} bulunamadi.")
            return

        # 2. RESMİ AÇ VE FİLTRE UYGULA
        # Filtreleme için önce RGB modunda açıyoruz
        img = Image.open(dosya_adi).convert("RGB")
        
        if filtre == "grayscale":
            img = ImageOps.grayscale(img).convert("RGB")
        elif filtre == "sepia":
            # Sepya (Eskitme) efekti matrisi
            width, height = img.size
            pixels = img.load()
            for x in range(width):
                for y in range(height):
                    r, g, b = pixels[x, y]
                    tr = int(0.393 * r + 0.769 * g + 0.189 * b)
                    tg = int(0.349 * r + 0.686 * g + 0.168 * b)
                    tb = int(0.272 * r + 0.534 * g + 0.131 * b)
                    pixels[x, y] = (min(tr, 255), min(tg, 255), min(tb, 255))
        elif filtre == "blur":
            img = img.filter(ImageFilter.GaussianBlur(radius=3))
        elif filtre == "bright":
            enhancer = ImageEnhance.Brightness(img)
            img = enhancer.enhance(1.4)

        # 3. YAZI İŞLEMLERİ İÇİN RGBA MODUNA GEÇ
        resim = img.convert("RGBA")
        width, height = resim.size
        
        # Yazı için şeffaf bir katman oluştur
        txt_katmani = Image.new("RGBA", resim.size, (255, 255, 255, 0))
        cizici = ImageDraw.Draw(txt_katmani)
        
        # Dinamik Font Ayarı
        font_size = int(height * 0.08)
        try:
            # Windows'ta standart olan Arial'i kullanıyoruz
            yazi_tipi = ImageFont.truetype("arial.ttf", font_size)
        except:
            yazi_tipi = ImageFont.load_default()

        # Yazıyı ortalamak için genişlik hesaplama
        w = cizici.textlength(mesaj, font=yazi_tipi)
        konum = ((width - w) / 2, height - int(height * 0.18))

        # 4. STİL UYGULAMA
        if stil == "modern":
            # Alt kısma siyah şeffaf banner
            cizici.rectangle([0, height-int(height*0.25), width, height], fill=(0, 0, 0, 160))
            cizici.text(konum, mesaj, font=yazi_tipi, fill=(255, 255, 255, 255))
            
        elif stil == "neon":
            # Parlayan pembe efekt (Neon)
            # Gölge/Parlama katmanı
            cizici.text((konum[0]+3, konum[1]+3), mesaj, font=yazi_tipi, fill=(255, 20, 147, 150))
            # Ana yazı
            cizici.text(konum, mesaj, font=yazi_tipi, fill=(255, 105, 180, 255))
            
        elif stil == "minimal":
            # Sade beyaz yazı, hafif siyah gölgeyle okunabilirliği artırılmış
            cizici.text((konum[0]+2, konum[1]+2), mesaj, font=yazi_tipi, fill=(0, 0, 0, 100))
            cizici.text(konum, mesaj, font=yazi_tipi, fill="white")

        # 5. BİRLEŞTİR VE KAYDET
        sonuc = Image.alpha_composite(resim, txt_katmani)
        cikti_adi = "PRO_TASARIM_" + dosya_adi
        
        # Sonuç resmini RGB olarak kaydet (JPG/PNG uyumluluğu için)
        sonuc.convert("RGB").save(cikti_adi)
        print(f"Basarili: {cikti_adi}")

    except Exception as e:
        print(f"Hata detayi: {e}")

# Komut satırı argümanlarını oku
if __name__ == "__main__":
    # PHP'den gelen: [0:dosya_adi, 1:resim, 2:mesaj, 3:stil, 4:filtre]
    if len(sys.argv) > 4:
        tasarim_yap(sys.argv[1], sys.argv[2], sys.argv[3], sys.argv[4])
    else:
        print("Hata: Eksik parametre gönderildi.")