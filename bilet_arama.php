<html>
<head>
    <title>Bilet Ara</title>
    <style>
        body { 
		background-color: #FFFF99; 
		font-family: Arial; 
		color: black; 
		}
        .form { 
		background-color: #CCCCCC; 
		border: 1px solid black; 
		padding: 10px; 
		width: 400px; 
		margin: 20px auto; 
		}
        .sonuclar { 
		width: 400px; 
		margin: 20px auto; 
		}
        .sefer { 
		background-color: white; 
		border: 1px solid black; 
		padding: 10px; 
		}
        a { 
		background-color: green; 
		color: black; 
		padding: 5px; 
		}
    </style>
</head>
<body>
<h2>Bilet Arama</h2>

<?php
$baglanti = mysqli_connect("localhost", "root", "", "otobus");
?>

<div class="form">
<form method="get">
Nereden: <input type="text" name="nereden" required><br>
Nereye: <input type="text" name="nereye" required><br>
Tarih: <input type="date" name="tarih" value="2025-05-30" required><br>
<input type="submit" value="Ara"><br>
</form>
</div>

<?php
if (isset($_GET['nereden'], $_GET['nereye'], $_GET['tarih'])) {
    $sonuclar = mysqli_query($baglanti, "SELECT s.sefer_id, s.nereden, s.nereye, s.tarih, s.kalkis_saat, o.firma, o.kapasite 
                                        FROM sefer s JOIN otobus o ON s.otobus_id = o.otobus_id 
                                        WHERE s.nereden = '$_GET[nereden]' AND s.nereye = '$_GET[nereye]' AND s.tarih = '$_GET[tarih]'");
    if (mysqli_num_rows($sonuclar) > 0) {
        echo "<div class='sonuclar'>";
        while ($satir = mysqli_fetch_assoc($sonuclar)) {
            $sorgu = mysqli_query($baglanti, "SELECT COUNT(*) as sayi FROM yolcu y JOIN rezervasyon r ON y.rezervasyon_id = r.rezervasyon_id 
                                             WHERE r.sefer_id = {$satir['sefer_id']} AND r.durum != 'iptal'");
            $bos_koltuk = $satir['kapasite'] - mysqli_fetch_assoc($sorgu)['sayi'];
            echo "<div class='sefer'>
                  Firma: $satir[firma]<br>
                  Rota: $satir[nereden] -> $satir[nereye]<br>
                  Tarih: $satir[tarih] Saat: $satir[kalkis_saat]<br>
                  Boş Koltuk: $bos_koltuk<br><br>
                  <a href='koltuk_secimi.php?sefer_id=$satir[sefer_id]'>Koltuk Seç</a>
                  </div>";
        }
        echo "</div>";
    } else {
        echo "<div style='background-color: red; color: black; padding: 10px; text-align: center;'>Sefer bulunamadi!</div>";
    }
}
?>
</body>
</html>