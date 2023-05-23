
<!DOCTYPE html>
<html>
    <head>

        <title>APPMOLINDO | Print Surat</title></head>
    <body onload="window.print();">

        <!-- Main content -->
        <?php foreach ($dataprint as $row) {
            foreach ($row as $data) {
                ?>
                <table style="width: 100%">
                    <tr>
                        <th colspan="9" ><?= strtoupper($data['kop_surat']); ?></th>
                    </tr>
                    <tr>
                        <th colspan="9"><?= strtoupper($data['jenis_surat']); ?></th>
                    </tr>
                    <tr>
                        <th colspan="9"><?= strtoupper($data['isi_kop_surat']); ?></th>
                    </tr>
                    <tr>
                        <td colspan="3"> Tanggal Cetak : <?= date('d/m/Y'); ?></td>
                        <td colspan="3"></td>
                        <td align="right" colspan="3">Jam : <?= date('H:i:s'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="9"><hr></td>
                    </tr>
                    <tr>
                        <td>Tanggal Input</td>
                        <td>:</td>
                        <td><?= date('d-m-Y', strtotime($data['tgl'])); ?></td>
                        <td colspan="3"></td>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td><?= date('d-m-Y', strtotime($data['tgl1'])); ?></td>
                    </tr>
                    <tr>
                        <td>Ind </td>
                        <td> :</td>
                        <td><?= $data['index_id']; ?></td>
                        <td colspan="3"></td>
                        <td>No.Urut</td>
                        <td>:</td>
                        <td><?= $data['no']; ?></td>
                    </tr>
                    <tr>
                        <td>Nomor </td>
                        <td> :</td>
                        <td><?= $data['nomor']; ?></td>
                        <td colspan="3"></td>
                        <td>Kode</td>
                        <td>:</td>
                        <td><?= $data['kode']; ?></td>
                    </tr>
                    <tr>
                        <td>Dari </td>
                        <td> :</td>
                        <td><?= $data['dari']; ?></td>
                        <td colspan="3"></td>
                        <td>Kepada</td>
                        <td>:</td>
                        <td><?= $data['kepada'] ? $data['kepada'] : ''; ?></td>
                    </tr>
                    <tr>

                        <td colspan="2"></td>
                        <td><?= $data['dari1'] ? $data['dari1'] : ''; ?></td>
                        <td colspan="3"></td>
                        <td colspan="2"></td>
                        <td><?= $data['kepada1'] ? $data['kepada1'] : ''; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td><?= $data['dari2'] ? $data['dari2'] : ''; ?></td>
                        <td colspan="3"></td>
                        <td colspan="2"></td>
                        <td><?= $data['kepada2'] ? $data['kepada2'] : ''; ?></td>
                    </tr>
                    <tr>
                        <td colspan="9"><b> ISI RINGKASAN SURAT </b></td>
                    </tr>
                    <tr>
                        <td colspan="9"><hr><?= $data['isi']; ?> <hr></td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td>Pengelola</td>
                        <td></td>
                        <td align="center">Menyetujui</td>
                    </tr>
                    <tr>
                        <td colspan="9">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td>(<?= $data['nama']; ?>)</td>
                        <td></td>
                        <td align="center">(Yolha)</td>
                    </tr>
                </table><br><br>
    <?php }
} ?>
    </body>
</html>
