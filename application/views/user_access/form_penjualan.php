<div class="row">
	<div class="col-md-12">
	<form action="app/simpan_penjualan" method="POST">
		<div class="form-group">
            <label>Kode Penjualan </label>
            <input type="text" class="form-control" name="kode_penjualan" id="kode_penjualan" value="<?php echo $kodeurut; ?>" readonly/>
        </div>
        <table class="table table-bordered">
        	<tr>
        		<th>No.</th>
        		<th>Kode Barang</th>
        		<th>Nama Barang</th>
        		<th>Jumlah</th>
        		<th>Harga</th>
        		<th>Subtotal</th>
        		<th>
        			<!-- Trigger the modal with a button -->
					<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Tambah Barang</button>
        		</th>
        	</tr>
        	<tr>
        	<?php $i=1; $no=1;?>
            <?php foreach($this->cart->contents() as $items): ?>
        		<td><?php echo $no; ?></td>
                <td><?php echo $items['id']; ?></td>
                <td><?php echo $items['name']; ?></td>
                <td><?php echo $items['qty']; ?></td>
                <td>Rp. <?php echo $this->cart->format_number($items['price']); ?></td>
                <td>Rp. <?php echo $this->cart->format_number($items['subtotal']); ?></td>
                <td>
                    <a href="app/hapus_cart/<?php echo $items['rowid'] ?>" class="btn btn-warning btn-sm">X</a>
                </td>
        	</tr>
        	<?php $i++; $no++;?>
            <?php endforeach; ?>
            <tr>
        		<th colspan="5">Total Harga</th>
        		<th colspan="2">Rp. <?php echo $this->cart->format_number($this->cart->total()); ?></th>
        	</tr>
        </table>
        <div class="form-group">
            <label>Metode Pembayaran </label>
            <select name="metode" class="form-control" id="metode">
            	<option value="CASH">CASH</option>
            	<!-- <option value="ID CARD">ID CARD</option> -->
            </select>
        </div>
        <div class="form-group" id="input_metode">
                <label>Nis</label><br>
                <select id="nis" name="nis" class="selectpicker" class="form-control" data-live-search="true" autofocus>
                    <?php 
                    $sql = $this->db->query("SELECT * FROM user, tabungan where user.nis=tabungan.nis order by user.id_siswa DESC");
                    foreach ($sql->result() as $row) {
                     ?>
                    <option value="<?php echo $row->nis ?>"><?php echo $row->nis.' - '.$row->nama ?></option>
                    <?php } ?>
                  </select>
            </div>
        <div class="form-group">
        	<input type="hidden" name="total_harga" value="<?php echo $this->cart->total() ?>">
        	<input type="hidden" name="tgl_penjualan" value="<?php echo date('Y-m-d') ?>">            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="app/penjualan" class="btn btn-default">Close</a>
        </div>
	</form>
	</div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <form action="app/simpan_cart" method="POST">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Barang</h4>
      </div>
      <div class="modal-body">
      	
        <div class="form-group">
        	<label>Nama Barang</label><br>
	      <select id="nama_barang" name="nama_barang" class="selectpicker" class="form-control" data-live-search="true" title="Pilih nama barang ...">
	        <?php 
	        $sql = $this->db->get('barang');
	        foreach ($sql->result() as $row) {
	         ?>
	       <?php if($row->stok > 0){
            ?>
            <option value="<?php echo $row->kode_barang ?>" min='0'>
                <?php echo $row->nama_barang ?>
            </option>
            <?php } ?>
	        <?php } ?>
	      </select>
	    </div>
	    <div class="form-group">
            <label>Kode barang</label>
            <input type="text" class="form-control" name="kode_barang" id="kode_barang" readonly/>
        </div>
	    <div class="form-group">
            <label>Stok tersedia</label>
            <input type="text" class="form-control" name="stok" id="stok" readonly/>
        </div>
        <div class="form-group">
            <label>Harga </label>
            <input type="text" class="form-control" name="harga" id="harga" readonly/>
        </div>
        <div class="form-group">
            <label>Jumlah Beli </label>
            <input type="number" class="form-control" name="jumlah" id="jumlah" min='1' />
            <input type="hidden" class="form-control" name="nabar" id="nabar"/>
        </div>
      </div>
      <div class="modal-footer">
      	<button class="btn btn-info" type="submit">Simpan</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>

  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#nama_barang').change(function() {
      var id = $(this).val();
      $.ajax({
        type : 'POST',
        url : '<?php echo base_url('app/cek_barang') ?>',
        Cache : false,
        dataType: "json",
        data : 'kode_barang='+id,
        success : function(resp) {
            $('#kode_barang').val(resp.kode_barang); 
            $('#stok').val(resp.stok); 
            $('#harga').val(resp.harga); 
            $('#nabar').val(resp.nama_barang); 
        }
      });
    });

    $('#metode').change(function() {
      var id = $(this).val();
      $.ajax({
        type : 'POST',
        url : '<?php echo base_url('app/cek_metode') ?>',
        Cache : false,
        data : 'id='+id,
        success : function(resp) {
            $('#input_metode').show();
            //alert(resp);  
        }
      });
    });

    
  });
</script>