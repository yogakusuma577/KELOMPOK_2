<?php

	@$halaman = $_GET['halaman'];

	if($halaman == "jenis")
	{
		//tampilkan halaman jenis
		//echo "Tampil Halaman Modul Jenis";
		include "modul/jenis/jenis.php";

	}
	elseif ($halaman == "pengirim"){
		//tampilkan halaman pengirim ]
		include "modul/pengirim/pengirim.php";
	}
	elseif($halaman == "dokumen")
	{
		//tampilkan halaman dokumen
		if(@$_GET['hal'] == "tambahdata" || @$_GET['hal'] == "edit" || @$_GET['hal'] == "hapus"){
			include "modul/dokumen/form.php";
		}else{
			include "modul/dokumen/dataa.php";
		}
	}
	else
	{
		//echo "Tampil Halaman Home";
		include "modul/home.php";
	}

?>