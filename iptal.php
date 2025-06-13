<html>
<head>
    <title>Rezervasyon İptali</title>
    <style>
        body { 
		background-color: #FFFF99; 
		font-family: Arial; 
		color: black; 
		text-align: center; 
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
<h2>Rezervasyon İptali</h2>

<?php
$baglanti = mysqli_connect("localhost", "root", "", "otobus");

if (isset($_POST['sorgula'])) {
    $rez_no = $_POST['rez_no'];
    $sorgu = mysqli_query($baglanti, "SELECT r.*, s.nereden, s.nereye, s.kalkis_saat, o.firma, y.ad, y.koltuk_no 
                                     FROM rezervasyon r 
                                     JOIN sefer s ON r.sefer_id = s.sefer_id 
                                     JOIN otobus o ON s.otobus_id = o.otobus_id 
                                     JOIN yolcu y ON r.rezervasyon_id = y.rezervasyon_id 
                                     WHERE r.rezervasyon_id = $rez_no");
    if (mysqli_num_rows($sorgu) > 0) {
        $rezervasyon = mysqli_fetch_assoc($sorgu);
        if ($rezervasyon['durum'] != 'iptal') {
            echo "<table>
                  <tr><td>Rezervasyon No</td><td>$rezervasyon[rezervasyon_id]</td></tr>
                  <tr><td>Firma</td><td>$rezervasyon[firma]</td></tr>
                  <tr><td>Rota</td><td>$rezervasyon[nereden] -> $rezervasyon[nereye]</td></tr>
                  <tr><td>Tarih</td><td>$rezervasyon[tarih]</td></tr>
                  <tr><td>Saat</td><td>$rezervasyon[kalkis_saat]</td></tr>
                  <tr><td>Tutar</td><td>$rezervasyon[tutar] TL</td></tr>
                  <tr><td>Durum</td><td>$rezervasyon[durum]</td></tr>
                  </table><br>
                  <form method='post'><input type='hidden' name='rez_no' value='$rez_no'>
                  <input type='submit' name='iptal_et' value='Rezervasyonu İptal Et'></form><br>";
        } else {
            echo "Bu rezervasyon zaten iptal edilmiş!<br>";
        }
    } else {
        echo "Rezervasyon bulunamadı! Lütfen doğru rezervasyon numarasını girin.<br>";
    }
}

if (isset($_POST['iptal_et'])) {
    $rez_no = $_POST['rez_no'];
    $sorgu = mysqli_query($baglanti, "UPDATE rezervasyon SET durum = 'iptal' WHERE rezervasyon_id = $rez_no");
    if ($sorgu) {
        echo "Rezervasyon başarıyla iptal edildi!<br>
              Rezervasyon No: $rez_no<br>";
    } else {
        echo "İptal işlemi sırasında hata oluştu!<br>";
    }
}
?>

<div class="form">
<form method="post">
Rezervasyon No: <input type="text" name="rez_no"><br>
<input type="submit" name="sorgula" value="Rezervasyonu Sorgula"><br>
</form>
</div>
</body>
</html>