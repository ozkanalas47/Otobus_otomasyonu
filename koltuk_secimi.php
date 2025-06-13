<html>
<head>
    <title>Koltuk Secimi</title>
    <style>
        body {
            background-color: #FFFF99;
            font-family: Arial;
            color: black;
        }
        .container {
            background-color: #FFFFFF;
            border: 1px solid black;
            padding: 10px;
            width: 400px;
            margin: 20px auto;
        }
        table {
            border: 1px solid black;
            margin: 10px auto;
        }
        td {
            padding: 10px;
            border: 1px solid black;
        }
        .available {
            background-color: green;
            color: black;
        }
        .reserved {
            background-color: gray;
            color: black;
        }
    </style>
</head>
<body>
<h2>Koltuk Secimi</h2>

<?php
$baglanti = mysqli_connect("localhost", "root", "", "otobus");

if (isset($_GET['sefer_id'])) {
    $sorgu = mysqli_query($baglanti, "SELECT s.sefer_id, s.nereden, s.nereye, s.tarih, s.ucret, o.kapasite 
                                     FROM sefer s JOIN otobus o ON s.otobus_id = o.otobus_id 
                                     WHERE s.sefer_id = $_GET[sefer_id]");
    $satir = mysqli_fetch_assoc($sorgu);
    if (!$satir) die("Sefer bulunamadi!");
}

$sorgu = mysqli_query($baglanti, "SELECT koltuk_no FROM yolcu y JOIN rezervasyon r ON y.rezervasyon_id = r.rezervasyon_id 
                                 WHERE r.sefer_id = $_GET[sefer_id] AND r.durum != 'iptal'");
$rezerve_koltuklar = [];
while ($row = mysqli_fetch_assoc($sorgu)) {
    $rezerve_koltuklar[] = $row['koltuk_no'];
}

$koltuklar = [];
for ($i = 1; $i <= $satir['kapasite']; $i++) {
    $koltuklar[] = "K$i";
}
?>

<div class="container">
Sefer: <?php echo "$satir[nereden] - $satir[nereye] ($satir[tarih])"; ?><br>
<form method="post" action="odeme.php">
<input type="hidden" name="sefer_id" value="<?php echo $_GET['sefer_id']; ?>"><br>
<input type="hidden" name="tutar" value="<?php echo $satir['ucret']; ?>"><br>
<table>
<?php
for ($i = 0; $i < count($koltuklar); $i += 4) {
    echo "<tr>";
    for ($j = $i; $j < $i + 4 && $j < count($koltuklar); $j++) {
        $durum = in_array($koltuklar[$j], $rezerve_koltuklar) ? 'reserved' : 'available';
        $disabled = in_array($koltuklar[$j], $rezerve_koltuklar) ? 'disabled' : '';
        echo "<td class='$durum'>
              <input type='radio' name='koltuk_no' value='$koltuklar[$j]' $disabled required>
              $koltuklar[$j]
              </td>";
    }
    echo "</tr>";
}
?>
</table><br>
Ad Soyad: <input type="text" name="ad" required><br>
Cinsiyet: <select name="cinsiyet" required>
    <option value="erkek">Erkek</option>
    <option value="kadin">Kadin</option>
</select><br>
Telefon: <input type="text" name="telefon"><br>
<input type="submit" value="Onayla"><br>
</form>
</div>
</body>
</html>