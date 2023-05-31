<div class="card mt-3">
  <div class="card-header bg-info text-white ">
    Data Dokumen
  </div>
  <div class="card-body">
  	<a href="?halaman=dokumen&hal=tambahdata" class="btn btn-info mb-3" >Tambah Data</a>
    <table class="table table-borderd table-hovered table-striped">
    	<tr>
    		<th>No</th>
    		<th>No Dokumen</th>
    		<th>Tanggal Dokumen</th>
    		<th>Tanggal Diterima</th>
    		<th>Prihal</th>
    		<th>Jenis</th>
    		<th>Pengirim</th>
    		<th>File</th>
    		<th>Aksi</th>
    	</tr>
    	<?php
    		$tampil = mysqli_query($koneksi, "
    				  SELECT 
    				  	tbl_dokumen.*,
    				  	tbl_jenis.nama_jenis,
    				  	tbl_pengirim.nama_pengirim, tbl_pengirim_.no_hp
    				  FROM 
    				  	tbl_dokumen, tbl_jenis, tbl_pengirim
    				  WHERE 
    				  	tbl_dokumen.id_jenis = tbl_jenis.id_jenis
    				  	and tbl_dokumen.id_pengirim = tbl_pengirim.id_pengirim
    				  ");
    	
			
    		$tampil = mysqli_query($koneksi, "SELECT * from tbl_dokumen INNER JOIN tbl_jenis INNER JOIN tbl_pengirim order by id_dokumen desc");
    		$no = 1;
			while($data = mysqli_fetch_array($tampil)) :

    	?>
    
    	<tr>
    		<td><?=$no++?></td>
    		<td><?=$data['no_dokumen']?></td>
    		<td><?=$data['tanggal_dokumen']?></td>
    		<td><?=$data['tanggal_diterima']?></td>
    		<td><?=$data['prihal']?></td>
    		<td><?=$data['nama_jenis']?></td>
    		<td><?=$data['nama_pengirim']?> / <?=$data['no_hp']?></td>
    		<td>
    			<?php
    				//uji apakah file nya ada atau tidak
    				if(empty($data['file'])){
    					echo " - ";
    				}else{
    			?>
    				<a href="file/<?=$data['file']?>" target="$_blank"> lihat file </a>
    			<?php
    				}
    			?>
    		</td>
    		<td>
    			<a href="?halaman=dokumen&hal=edit&id=<?=$data['id_dokumen']?>" class="btn btn-success" >Edit </a>
    			<a href="?halaman=dokumen&hal=hapus&id=<?=$data['id_dokumen']?>" class="btn btn-danger" 
    				onclick="return confirm('Apakah yakin ingin menghapus data ini?')" >Hapus </a>
    		</td>
    	</tr>
    <?php endwhile; ?>
    </table>
  </div>
</div>