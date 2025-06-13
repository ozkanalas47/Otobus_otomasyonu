<html>
<head>
    <title>Ödeme</title>
    <style>
        body { 
		background-color: #FFFF99; 
		font-family: Arial; color: 
		}
        .form { 
		background-color: #FFFFFF; 
		border: 1px solid black; 
		padding: 10px; width: 300px; 
		margin: 20px auto; 
		}
        table { 
		border: 1px solid black; 
		margin: 10px auto; 
		}
        td { 
		padding: 5px; 
		border: 1px solid black; 
		}
    </style>
</head>
<body>
<h2>Ödeme</h2>

<?php
$baglanti = mysqli_connect("localhost", "root", "", "otobus");
$sefer_id = $_POST['sefer_id'];
$sorgu = mysqli_query($baglanti, "SELECT s.*, o.firma, y.ad, y.koltuk_no FROM sefer s 
                                 JOIN otobus o ON s.otobus_id = o.otobus_id 
                                 JOIN yolcu y ON s.sefer_id = y.rezervasyon_id 
                                 WHERE s.sefer_id = $sefer_id");
$sefer = mysqli_fetch_assoc($sorgu);

if (isset($_POST['odeme_tamamlama'])) {
    $kart_no = $_POST['kart_no'];
    $tarih = $_POST['tarih'];
    $cvv = $_POST['cvv'];
    if (strlen($kart_no) == 16 && $cvv >= 100 && $cvv <= 999) {
        $sorgu = mysqli_query($baglanti, "INSERT INTO rezervasyon (sefer_id, tarih, tutar, durum, odeme_tipi, odeme_durumu) 
                                         VALUES ($sefer_id, NOW(), $sefer[ucret], 'beklemede', 'kredi_karti', 'beklemede')");
        if ($sorgu) {
            $rezervasyon_id = mysqli_insert_id($baglanti);
            $sorgu = mysqli_query($baglanti, "INSERT INTO yolcu (rezervasyon_id, ad, cinsiyet, telefon, koltuk_no, koltuk_durum) 
                                             VALUES ($rezervasyon_id, '$sefer[ad]', '$_POST[cinsiyet]', '$_POST[telefon]', '$sefer[koltuk_no]', 'rezerve')");
            if ($sorgu) {
                echo "Ödeme başarılı! Rezervasyon tamamlandı.<br>
                      Rezervasyon No: $rezervasyon_id<br>
                      Bu numarayı saklayınız.<br>";
            } else {
                echo "Yolcu bilgileri kaydedilemedi!<br>";
            }
        } else {
            echo "Rezervasyon oluşturulamadı!<br>";
        }
    } else {
        echo "Kart bilgileri hatalı! Kart numarası 16 haneli, CVV 3 haneli olmalıdır.<br>";
    }
}
?>

<div class="form">
<table>
<tr><td>Firma</td><td><?php echo $sefer['firma']; ?></td></tr>
<tr><td>Rota</td><td><?php echo "$sefer[nereden] -> $sefer[nereye]"; ?></td></tr>
<tr><td>Tarih</td><td><?php echo $sefer['tarih']; ?></td></tr>
<tr><td>Saat</td><td><?php echo $sefer['kalkis_saat']; ?></td></tr>
<tr><td>Tutar</td><td><?php echo $sefer['ucret']; ?> TL</td></tr>
</table><br>
<form method="post">
<input type="hidden" name="sefer_id" value="<?php echo $sefer_id; ?>"><br>
<input type="hidden" name="cinsiyet" value="<?php echo $_POST['cinsiyet']; ?>"><br>
<input type="hidden" name="telefon" value="<?php echo $_POST['telefon']; ?>"><br>
Kart Numarası: <input type="text" name="kart_no" required><br>
Son Kullanma Tarihi: <input type="date" name="tarih" value="2025-05-30" required><br>
CVV: <input type="number" name="cvv" required><br>
<input type="submit" name="odeme_tamamlama" value="Ödemeyi Tamamla"><br>
</form>
</div>
</body>
</html>