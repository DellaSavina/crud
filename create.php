<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $merk = isset($_POST['merk']) ? $_POST['merk'] : '';
    $tipe = isset($_POST['tipe']) ? $_POST['tipe'] : '';
    $tahun_produksi = isset($_POST['tahun_produksi']) ? $_POST['tahun_produksi'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO hp VALUES (?, ?, ?, ?)');
    $stmt->execute([$id, $merk, $tipe, $tahun_produksi]);
    // Output message
    $msg = 'data berhasil ditambahkan';
}
?>


<?=template_header('Create')?>

<div class="content update">
	<h2>Tambah Data</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="nama">Merk</label>
        <input type="text" name="id" value="auto" id="id">
        <input type="text" name="merk" id="merk">
        <label for="email">Tipe</label>
        <label for="notelp">Tahun Produksi</label>
        <input type="text" name="tipe" id="tipe">
        <input type="text" name="tahun_produksi" id="tahun_produksi">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>