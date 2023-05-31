<?php
	//panggil function.php untuk upload file
	include "config/function.php";

	//Uji Jika klik tombol edit / hapus
	if(isset($_GET['hal']))
	{

		if($_GET['hal'] == "edit")
		{

			//tampilkan data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT 
    				  	tbl_dokumen.*,
    				  	tbl_jenis.nama_jenis,
    				  	tbl_pengirim.nama_pengirim, tbl_pengirim.no_hp
    				  FROM 
    				  	tbl_dokumen, tbl_jenis, tbl_pengirim
    				  WHERE 
    				  	tbl_dokumen.id_jenis = tbl_jenis.id_jenis
    				  	and tbl_dokumen.id_pengirim = tbl_pengirim.id_pengirim
					    and tbl_dokumen.id_dokumen='$_GET[id]'");


			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//jika data ditemukan, maka data ditampung ke dalam variabel
				$vno_surat = $data['no_dokumen'];
				$vtanggal_surat = $data['tanggal_dokumen'];
				$vtanggal_diterima = $data['tanggal_diterima'];
				$vprihal = $data['prihal'];
				$vid_departemen = $data['id_jenis'];
				$vnama_departemen = $data['nama_jenis'];
				$vid_pengirim = $data['id_pengirim'];
				$vnama_pengirim = $data['nama_pengirim'];
				$vfile = $data['file'];
			}

		}
		elseif($_GET['hal'] == 'hapus')
		{
			$hapus = mysqli_query($koneksi, "DELETE FROM tbl_dokumen WHERE id_dokumen='$_GET[id]'");
			if($hapus){
				echo "<script>
						alert('Hapus Data Sukses');
						document.location='?halaman=dokumen';
					  </script>";
			}
		}
		

	}
	
	//uji jika tombol simpan diklik
	if(isset($_POST['bsimpan']))
	{
		
		//pengujian apakah data akan diedit / simpan baru
		if(@$_GET['hal'] == "edit"){
			//perintah edit data
			//ubah data

			// cek apakah user pilih file/gambar atau tidak 
			if($_FILES['file']['error'] === 4){
				$file = $vfile;
			}else{
				$file = upload();
			}

			$ubah = mysqli_query($koneksi, "UPDATE tbl_dokumen SET 
												no_dokumen		= '$_POST[no_dokumen]',
												tanggal_dokumen	= '$_POST[tanggal_dokumen]',
												tanggal_diterima = '$_POST[tanggal_diterima]',
												prihal 			= '$_POST[prihal]',
												id_jenis 	= '$_POST[id_jenis]',
												id_pengirim 	= '$_POST[id_pengirim]',
												file 			= '$file'
											where id_dokumen = '$_GET[id]' ");
			
			if($ubah)
			{
				echo "<script>
						alert('Ubah Data Sukses');
						document.location='?halaman=dokumen';
					  </script>";
			}
			else
			{
				echo "<script>
						alert('Ubah Data GAGAL!!');
						document.location='?halaman=dokumen';
					  </script>";
			}
		}
		else
		{
			//perintah simpan data baru
			//simpan data
			$file = upload();
			$simpan = mysqli_query($koneksi, "INSERT INTO tbl_dokumen
											  VALUES (	'', 
											  		  	'$_POST[no_dokumen]', 
											  		  	'$_POST[tanggal_dokumen]',
											  		  	'$_POST[tanggal_diterima]',
											  		  	'$_POST[prihal]',
											  		  	'$_POST[id_jenis]',
											  		  	'$_POST[id_pengirim]',
											  		  	'$file'
											  		  ) ");

			if($simpan)
			{
				echo "<script>
						alert('Simpan Data Sukses');
						document.location='?halaman=dokumen';
					  </script>";
			}else
			{
				echo "<script>
						alert('Simpan Data GAGAL!!');
						document.location='?halaman=dokumen';
					  </script>";
			}

		}


		
	}

	

?>


<div class="card mt-3">
  <div class="card-header bg-info text-white ">
    Form Data Dokumen
  </div>
  <div class="card-body">
    <form method="post" action="" enctype="multipart/form-data" >
	  <div class="form-group">
	    <label for="no_dokumen">No. Dokumen</label>
	    <input type="text" class="form-control" id="no_dokumen" name="no_dokumen" value="<?=@$vno_dokumen?>">
	  </div>
	  <div class="form-group">
	    <label for="tanggal_dokumen">Tanggal Dokumen</label>
	    <input type="date" class="form-control" id="tanggal_dokumen" name="tanggal_dokumen" value="<?=@$vtanggal_dokumen?>">
	  </div>
	  <div class="form-group">
	    <label for="tanggal_diterima">Tanggal Diterima</label>
	    <input type="date" class="form-control" id="tanggal_diterima" name="tanggal_diterima" value="<?=@$vtanggal_diterima?>">
	  </div>
	  <div class="form-group">
	    <label for="prihal">Prihal</label>
	    <input type="text" class="form-control" id="prihal" name="prihal" value="<?=@$vprihal?>">
	  </div>
	  <div class="form-group">
	    <label for="id_jenis">Jenis Dokumen</label>
	   	<select class="form-control" name="id_jenis">
	   		<option value="<?=@$vid_jenis?>"><?=@$vnama_jenis?></option>
	   		<?php
	   			$tampil = mysqli_query($koneksi, "SELECT * from tbl_jenis order by nama_jenis asc");
	   			while($data = mysqli_fetch_array($tampil)){
	   				echo "<option value = '$data[id_jenis]'> $data[nama_jenis] </option> ";
	   			}

	   		?>
	   	</select>
	  </div>
	  <div class="form-group">
	    <label for="id_pengirim">Pengirim Dokumen</label>
	   	<select class="form-control" name="id_pengirim">
	   		<option value="<?=@$vid_pengirim?>"><?=@$vnama_pengirim?></option>
	   		<?php
	   			$tampil = mysqli_query($koneksi, "SELECT * from tbl_pengirim order by nama_pengirim asc");
	   			while($data = mysqli_fetch_array($tampil)){
	   				echo "<option value = '$data[id_pengirim]'> $data[nama_pengirim] </option> ";
	   			}

	   		?>
	   	</select>
	  </div>

	  <div class="form-group">
	    <label for="file">Pilih File</label>
	    <input type="file" class="form-control" id="file" name="file" value="<?=@$vfile?>">
	  </div>

	  <button type="submit" name="bsimpan" class="btn btn-primary">Simpan</button>
	  <button type="reset" name="bbatal" class="btn btn-danger">Batal</button>
	</form>
  </div>
</div>