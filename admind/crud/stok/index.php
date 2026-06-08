<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Stok Menu</title>
</head>
<body>

<h2>Manajemen Stok Menu</h2>

<form action="update_stok.php" method="POST">
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Nama Menu</th>
            <th>Stok</th>
            <th>Status</th>
        </tr>

        <?php
        $data = mysqli_query($conn, "SELECT * FROM menu");

        while ($row = mysqli_fetch_array($data)) {
        ?>
            <tr>
                <td>
                    <?= htmlspecialchars($row['nama_menu']) ?>
                    <input type="hidden" name="id_menu[]" value="<?= $row['id_menu'] ?>">
                </td>

                <td>
                    <input
                        type="number"
                        name="stok[]"
                        value="<?= $row['stok'] ?>"
                        min="0"
                        required
                        style="width:70px;"
                    >
                </td>

                <td>
                    <select name="status[]">
                        <option value="tersedia"
                            <?= $row['status'] == 'tersedia' ? 'selected' : '' ?>>
                            Tersedia
                        </option>

                        <option value="habis"
                            <?= $row['status'] == 'habis' ? 'selected' : '' ?>>
                            Habis
                        </option>
                    </select>
                </td>
            </tr>
        <?php } ?>
    </table>

    <br>
    <button type="submit">Update Semua</button>
</form>

</body>
</html>