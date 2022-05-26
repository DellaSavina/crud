<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM hp WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $data_hp = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$data_hp) {
        exit('Tidak ditemukan data dengan ID tersebut');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM hp WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Data telah berhasil dihapus';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('ID tidak diisi');
}
?>


<?=template_header('Delete')?>

<div class="content delete">
	<h2>Hapus Data #<?=$data_hp['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Apakah Kamu yakin ingin menghapus data ini? #<?=$data_hp['id']?>?</p>
    <div class="yesno">
        <a href="delete.php?id=<?=$data_hp['id']?>&confirm=yes">Yes</a>
        <a href="delete.php?id=<?=$data_hp['id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>