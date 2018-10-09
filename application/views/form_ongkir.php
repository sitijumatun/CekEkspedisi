<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Cek Ongkir</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="">
</head>
<body>
	<div class="container py-5">
		<div class="row">
			<div class="col-md-12">
				<center><h1>Cek Biaya Ekspedisi JNE, POS dan TIKI</h1></center>
				<form>
				  <div class="form-group">
				    <label for="formGroupExampleInput">Provinsi Asal</label>
				    <select onChange="get_kota('asal')" id="provinsi_asal" class="form-control provinsi"></select>
				  </div>
				  <div class="form-group">
				    <label for="formGroupExampleInput">Kota Asal</label>
				    <select id="kota_asal" class="form-control"></select>
				  </div>
				  <div class="form-group">
				    <label for="formGroupExampleInput">Provinsi Tujuan</label>
				    <select onChange="get_kota('tujuan')" id="provinsi_tujuan" class="form-control provinsi"></select>
				  </div>
				  <div class="form-group">
				    <label for="formGroupExampleInput">Kota Tujuan</label>
				    <select id="kota_tujuan" class="form-control"></select>
				  </div>
				  <div class="form-group">
				    <label for="formGroupExampleInput">Berat (Kg)</label>
				    <input type="number" name="berat" id="berat" class="form-control">
				  </div>
				  <div class="form-group">
				    <label for="kurir">Kurir</label>
				    <select onChange="get_ongkir()" name="kurir" id="kurir" class="form-control">
				    	<option value="jne">JNE</option>
				    	<option value="pos">POS</option>
				    	<option value="tiki">TIKI</option>
				    </select>
				  </div>
				  <div class="form-group">
				    <label for="service">Service</label>
				    <select name="service" id="service" class="form-control"></select>
				  </div>
				</form>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(function(){
				$.get("http://localhost/rajaongkir/index.php/Ongkir/get_provinsi",{},(response)=>{
				let output='';
				let provinsi = response.rajaongkir.results
				console.log(response)

				provinsi.map((val,i)=>{
					output+=`<option value="${val.province_id}">${val.province}
					</option>`
				})
				$('.provinsi').html(output)
			})
		});

		function get_kota(type){
			let id_provinsi = $(`#provinsi_${type}`).val();
			$.get("http://localhost/rajaongkir/index.php/Ongkir/get_kota/"+id_provinsi,{},(response)=>{
				let output='';
				let kota = response.rajaongkir.results
				console.log(response)

				kota.map((val,i)=>{
					output+=`<option value="${val.city_id}">${val.city_name}
					</option>`
				})
				$(`#kota_${type}`).html(output)
			
			})
		}


		function get_ongkir(){
			let berat = $(`#berat`).val();
			let asal = $(`#kota_asal`).val();
			let tujuan = $(`#kota_tujuan`).val();
			let kurir = $(`#kurir`).val();
			let output='';

			$.get("http://localhost/rajaongkir/index.php/Ongkir/harga/"+asal+"/"+tujuan+"/"+berat+"/"+kurir,{},(response)=>{
				console.log(response);
				let biaya = response.rajaongkir.results
				console.log(biaya)

				biaya.map((val,i)=>{
					for( var i=0; i < val.costs.length;i++){
						let jenis_layanan = val.costs[i].service
						val.costs[i].cost.map((val,i)=>{
							output+=`<option value="${val.value}">${jenis_layanan} - Rp. ${val.value} ${val.etd} </option>`

						})
					}
					
				})
				$(`#service`).html(output)
			
			})
		}


	</script>
</body>
</html>