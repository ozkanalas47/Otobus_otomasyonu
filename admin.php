<html>
<head>
    <title>Admin Paneli</title>
    <style>
        body {
            background-color: #FFFF99;
            font-family: Arial;
            color: black;

        }
        table {
            border: 1px solid black;
        }
        td {
            border: 1px solid black;
            padding: 5px;
        }
        input, select {
            margin: 5px 0;
            padding: 2px;
        }
        .mesaj {
            border: 1px solid black;
            padding: 5px;
            width: 300px;
        }
    </style>
</head>
<body>
<h2>Admin Paneli</h2>

<div class="mesaj">
<?php
$baglanti = mysqli_connect("localhost", "root", "", "otobus");

if (isset($_GET['sil'])) {
    $id = $_GET['id'];
    if ($_GET['tablo'] == 'otobus') {
        mysqli_query($baglanti, "DELETE FROM sefer WHERE otobus_id = $id");
        mysqli_query($baglanti, "DELETE FROM otobus WHERE otobus_id = $id");
        echo "Otobus ve bagli seferler silindi!";
    } else {
        mysqli_query($baglanti, "DELETE FROM sefer WHERE sefer_id = $id");
        echo "Sefer silindi!";
    }
}

if (isset($_POST['otobus_ekle'])) {
    $otobus_no = $_POST['otobus_no'];
    $plaka = $_POST['plaka'];
    if (mysqli_num_rows(mysqli_query($baglanti, "SELECT * FROM otobus WHERE otobus_no = '$otobus_no'")) > 0) {
        echo "Hata: Otobus no ($otobus_no) zaten var!";
    } elseif (mysqli_num_rows(mysqli_query($baglanti, "SELECT * FROM otobus WHERE plaka = '$plaka'")) > 0) {
        echo "Hata: Plaka ($plaka) zaten var!";
    } else {
        $sorgu = mysqli_query($baglanti, "INSERT INTO otobus (otobus_no, plaka, firma, kapasite) 
                                         VALUES ('$otobus_no', '$plaka', '$_POST[firma]', $_POST[kapasite])");
        if ($sorgu) {
            echo "Otobus eklendi!";
        } else {
            echo "Hata!";
        }
    }
}

if (isset($_POST['sefer_ekle'])) {
    $sorgu = mysqli_query($baglanti, "INSERT INTO sefer (otobus_id, nereden, nereye, tarih, kalkis_saat, varis_saat, ucret) 
                                     VALUES ($_POST[otobus_id], '$_POST[nereden]', '$_POST[nereye]', '$_POST[tarih]', 
                                             '$_POST[kalkis_saat]', '$_POST[varis_saat]', $_POST[ucret])");
    if ($sorgu) {
        echo "Sefer eklendi!";
    } else {
        echo "Hata!";
    }
}
?>
</div>

Otobus Ekle:<br>
<form method="POST">
Otobus No: <input type="text" name="otobus_no" required><br>
Plaka: <input type="text" name="plaka" required><br>
Firma: <input type="text" name="firma" required><br>
Kapasite: <input type="number" name="kapasite" required><br>
<input type="submit" name="otobus_ekle" value="Ekle"><br>
</form>

<br>

Sefer Ekle:<br>
<form method="POST">
Otobus: <select name="otobus_id" required>
    <option value="">Seciniz</option>
    <?php
    $sonuclar = mysqli_query($baglanti, "SELECT * FROM otobus");
    while ($satir = mysqli_fetch_assoc($sonuclar)) {
        echo "<option value='$satir[otobus_id]'>$satir[otobus_no] - $satir[firma]</option>";
    }
    ?>
</select><br>
Nereden: <input type="text" name="nereden" required><br>
Nereye: <input type="text" name="nereye" required><br>
Tarih: <input type="date" name="tarih" required><br>
Kalkis Saati: <input type="time" name="kalkis_saat" required><br>
Varis Saati: <input type="time" name="varis_saat" required><br>
Ucret: <input type="number" name="ucret" required><br>
<input type="submit" name="sefer_ekle" value="Ekle"><br>
</form>

<br>

Otobusler:<br>
<table>
<?php
$sonuclar = mysqli_query($baglanti, "SELECT * FROM otobus");
while ($satir = mysqli_fetch_assoc($sonuclar)) {
    echo "<tr><td>$satir[otobus_no] - $satir[firma] (Kapasite: $satir[kapasite])</td>
              <td><a href='?sil=1&tablo=otobus&id=$satir[otobus_id]'>Sil</a></td></tr>";
}
?>
</table>

<br>

Seferler:<br>
<table>
<?php
$sonuclar = mysqli_query($baglanti, "SELECT s.*, o.otobus_no FROM sefer s JOIN otobus o ON s.otobus_id = o.otobus_id");
while ($satir = mysqli_fetch_assoc($sonuclar)) {
    echo "<tr><td>$satir[nereden] -> $satir[nereye] ($satir[tarih] $satir[kalkis_saat])</td>
              <td>$satir[ucret] TL</td>
              <td><a href='?sil=1&tablo=sefer&id=$satir[sefer_id]'>Sil</a></td></tr>";
}
?>
</table>

</body>
</html>