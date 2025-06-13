<html>
<head>
    <title>Ödeme Simülasyonu</title>
    <style>
        body { 
		background-color: #FFFF99; 
		font-family: Arial; 
		color: black; 
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
<h2>Ödeme Simülasyonu</h2>

<?php
$baglanti = mysqli_connect("localhost", "root", "", "otobus");

$rezervasyon_id = $_GET['rezervasyon_id'];
$sorgu = mysqli_query($baglanti, "SELECT r.*, s.nereden, s.nereye, s.kalkis_saat, o.firma, y.ad, y.koltuk_no 
                                 FROM rezervasyon r 
                                 JOIN sefer s ON r.sefer_id = s.sefer_id 
                                 JOIN otobus o ON s.otobus_id = o.otobus_id 
                                 JOIN yolcu y ON r.rezervasyon_id = y.rezervasyon_id 
                                 WHERE r.rezervasyon_id = $rezervasyon_id");
if (mysqli_num_rows($sorgu) > 0) {
    $rezervasyon = mysqli_fetch_assoc($sorgu);
    if ($rezervasyon['odeme_durumu'] != 'tamamlandi') {
        echo "<table>
              <tr><td>Rezervasyon No</td><td>$rezervasyon[rezervasyon_id]</td></tr>
              <tr><td>Firma</td><td>$rezervasyon[firma]</td></tr>
              <tr><td>Rota</td><td>$rezervasyon[nereden] -> $rezervasyon[nereye]</td></tr>
              <tr><td>Tarih</td><td>$rezervasyon[tarih]</td></tr>
              <tr><td>Saat</td><td>$rezervasyon[kalkis_saat]</td></tr>
              <tr><td>Tutar</td><td>$rezervasyon[tutar] TL</td></tr>
              <tr><td>Durum</td><td>$rezervasyon[durum]</td></tr>
              </table><br>
              <form method='post'><input type='hidden' name='rezervasyon_id' value='$rezervasyon_id'>
              <input type='submit' name='odeme_yap' value='Ödemeyi Tamamla'></form><br>";
    } else {
        echo "Bu rezervasyon için ödeme zaten tamamlanmış!<br>";
    }
} else {
    echo "Rezervasyon bulunamadı!<br>";
}

if (isset($_POST['odeme_yap'])) {
    $rezervasyon_id = $_POST['rezervasyon_id'];
    $sorgu = mysqli_query($baglanti, "UPDATE rezervasyon SET odeme_durumu = 'tamamlandi', durum = 'onaylandi' WHERE rezervasyon_id = $rezervasyon_id");
    if ($sorgu) {
        echo "Ödeme başarılı! Rezervasyon onaylandı.<br>";
    } else {
        echo "Ödeme sırasında hata oluştu!<br>";
    }
}
?>

<div class="form">
<?php if (!isset($_GET['rezervasyon_id'])) echo "Rezervasyon ID eksik!<br>"; ?>
</div>
</body>
</html>