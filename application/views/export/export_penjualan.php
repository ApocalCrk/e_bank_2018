<?php
 
 header("Content-type: application/vnd-ms-excel");
 
 header("Content-Disposition: attachment; filename=penjualan.xls");
 
 header("Pragma: no-cache");
 
 header("Expires: 0");
 
 ?>

 <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Penjualan</th>
                    <th>Nama siswa</th>
                    <th>Tanggal Penjualan</th>
                    <th>Total Bayar</th>
                    <th>Nama Kasir</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sql = $this->db->query("SELECT * FROM penjualan_header,user where penjualan_header.nis=siswa.nis order by penjualan_header.id_penjualan DESC");
                $no = 1;
                foreach ($sql->result() as $row) {
                 ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row->kode_penjualan; ?></td>
                    <td><?php echo $row->nama_siswa; ?></td>
                    
                    <td><?php echo $row->tgl_penjualan; ?></td>
                    <td><?php echo $row->total_harga; ?></td>
                    <td><?php echo $row->kasir; ?></td>
                    
                </tr>
                <?php } ?>
            </tbody>
        </table>