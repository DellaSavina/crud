<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $merk = isset($_POST['merk']) ? $_POST['merk'] : '';
        $tipe = isset($_POST['tipe']) ? $_POST['tipe'] : '';
        $tahun_produksi = isset($_POST['tahun_produksi']) ? $_POST['tahun_produksi'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE hp SET id = ?, merk = ?, tipe = ?, tahun_produksi = ? WHERE id = ?');
        $stmt->execute([$id, $merk, $tipe, $tahun_produksi, $_GET['id']]);
        $msg = 'Update sukses!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM hp WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $data_hp = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$data_hp) {
        exit('Tidak ditemukan data dengan ID tersebut');
    }
} else {
    exit('ID tidak diisi');
}
?>



<?=template_header('Read')?>

<div class="content update">
	<h2>Update Data #<?=$data_hp['id']?></h2>
    <form action="update.php?id=<?=$data_hp['id']?>" method="post">
        <label for="id">ID</label>
        <label for="merk">Merk</label>
        <input type="text" name="id" value="<?=$data_hp['id']?>" id="id">
        <input type="text" name="merk" value="<?=$data_hp['merk']?>" id="merk">
        <label for="tipe">Tipe</label>
        <label for="tahun_produksi">Tahun Produksi</label>
        <input type="text" name="tipe" value="<?=$data_hp['tipe']?>" id="tipe">
        <input type="text" name="tahun_produksi" value="<?=$data_hp['tahun_produksi']?>" id="tahun_produksi">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>