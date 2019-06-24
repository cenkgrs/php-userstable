<!DOCTYPE html>
<html>
	<head>
		<title>Projem</title>
		<link href="sayfalama.css" rel="stylesheet" type="text/css" />
		<link href="A_green.css" rel="stylesheet" type="text/css" />
			<style>
			
				body{
					background-color:#2c2c54;
				}
				.t1{
					width:50%;
					height:50%;
					background-color:#474787;
					border: 5px solid black;
				}
				.tk{
					width:50%;
					height:50%;
					background-color:#40407a;
					border: 5px solid black;
					float:left;
				}
				th{
					border:3px groove black;
					width:190px;
					color:#aaa69d;
				}
				td{
					border:3px groove black;
					width:190px;
					color:#d1ccc0;
				}
				td:hover{
					color:#aaa69d;
				}
				.i1{
					
					width:100%;
					background-color:#A8B2CA;
				}
				.s1{
					width:100%;
					background-color:#AFBDDE;
				}
				.s1:hover{
					color:blue;
				}
				.a1{
					color:#34ace0;
					text-decoration:none;
					padding:1px;
				}
				.a1:visited{
					color:#34ace0;
				}
				.a1:hover{
					color:#C8D2EA;
				}
				a{
					padding:20px;
					text-decoration:none;
					color:#25CCF7;
				}
				a:hover{
					color:white;
				}
				
				.stable{
					width:49%;
					height:50%;
					background-color:#40407a;
					border: 5px solid black;
					float:right;
				}
				.itable{
					width:50%;
					height:50%;
					background-color:#40407a;
					border: 5px solid black;
					float:left;
				}
				.linkler{
					padding:20px;
					
					float:left;
					
				}
				
				
			</style>
	<body>
	<?php
		
	
	
		$conn= mysqli_connect('localhost' , 'root' ,'', 'proje');
		
		ResultSet();
			
		
			if(! $conn)
				echo "Bağlantı Hatası" ;
			
			//Formlardan gönderilenlere göre fonksiyonlar çalışıyor
			if(isset($_POST['add']))	
				ekle();
		
			if(isset($_POST['search']))
				search();
					
					//Silme ve değiştirme linklerini url den çekip fonksiyonlar çalışıyor
			if(isset($_GET['sil']))
						sil();
					
					if (isset($_GET['sno']))
						{
							$var1 = $_GET['sno'];
							sil($var1);
						}
							
					if (isset($_GET['gno']))
						{
							
							$var2 = $_GET['gno'];
							update($var2);
						}
					
						
						
						
			
			
			?>
	
				
	
	
<?php //Listeleme fonksiyonu
		function ResultSet(){
			
				$asc1; $desc1;
				$sort='ASC';
				$sil; $degistir;  
				
				//Linkden çekilen veriye göre liste sıralaması
				if(isset($_GET['asc'])){
				$sort='ASC';}
				else if(isset($_GET['desc'])){
					$sort='DESC';
				}
				
				
				?>
				<table class="t1">
		<tr>
			<th > <a class='a1' href = 'p1.php?asc="asc" '><img src="asc.png" style="width:40px; height:30px" > </a>  NO  <a class='a1' href = 'p1.php?desc="desc" '><img src="desc.png" style="width:40px; height:30px" > </a> </th>
			<th > Ad</th>
			<th > Soyad</th>
			<th > </th>
			<th > </th>
		</tr>
		
		<tr><form class=""   method="post" > 
			<td> <input class='i1' type=text name=ono ></td>
			<td><input class='i1' type=text name=ad ></td>
			<td><input class='i1' type=text name=soyad></td>
			<td><input class='s1' type=submit name=add value=EKLE> </td>
			<td> </td>
			</form>
		</tr>
		
		<tr> <form method="post">
			<td><input class='i1' type=text name=noara> </td>
			<td><input class='i1' type=text name=adara> </td>
			<td><input class='i1' type=text name=soyadara> </td>
			<td><input class='s1' type=submit name=search value=ARA.. > </td>
			<td><input class='s1' type=button name=clear value=TEMİZLE onclick="window.location.href='http://localhost/proje/p1.php'"> </td>
		</form>
		</tr>
	</table>
	
	<?php
				
				$conn= mysqli_connect('localhost' , 'root' ,'', 'proje');
				
				$sql="SELECT count(*) FROM kisiler";		//satır sayısısını COUNT sorgusuyla hesapla
				$sqlsonuc=mysqli_query($conn,$sql);
				$row=mysqli_fetch_row($sqlsonuc);
				$numrows = $row[0];			//kaç satır olduğunu hesapla
				
				
				$rowperpage=5;
				$totalpage= ceil($numrows / $rowperpage); //sayfa sayısı hesapla
				
					//mevcut sayfa numarasını al ya da 1 den başlat (sayfa açıldığında default olarak 1 den başlıcak)
				if(isset($_GET['currentpage']) && is_numeric($_GET['currentpage']) ){
					$currentpage = (int) $_GET['currentpage']; 
					
				}
						else {
							$currentpage=1;
							}
				
					//mevcut sayfa sayfa sayısından büyük ise son sayfaya eşitle
				if($currentpage > $totalpage){
					
					$currentpage = $totalpage;
				}
					//mevcut sayfa 1 den küçük ise ilk sayfaya eşitle
				if($currentpage <1 ){
					
					$currentpage = 1;
				}
				 //offset i mevcut sayfaya göre ayarla
				$offset = ($currentpage - 1) * $rowperpage;  //Örneğin mevcut sayfa 1 ise diziden 0 dan başlayıp rowperpage kadar(5 tane ) eleman getiricek
				
				
				
				
				
				
				
				$statement = "kisiler order by ono {$sort}	";  // sorgu kısmı (sort değişkeni ayrı olarak alınıyor ve değiştiriliyor)
			
				$records = mysqli_query($conn, "SELECT * FROM {$statement}  LIMIT {$offset} , {$rowperpage};");
	
	
		echo "
		<table class='tk' >";
		while($rec = mysqli_fetch_array($records) ){
		echo"
			<tr width=1000px>
				<td width=250px>", $rec[0] ,"</td> 
				
				<td width=250px>", $rec[1] ,"</td>
				<td width=250px>", $rec[2] ,"</td> ";?>  
				<td> <a class='a1' href=	'p1.php?sno=<?php echo "$rec[0]" ;?> '>	Sil		</a>		</td> <?php // bu linkler url den çekilip fonksiyonlar çalıştırılıyor ?>
				<td> <a class='a1' href=	'p1.php?gno=<?php echo "$rec[0]" ;?> '>	Değiştir		</a> </td>	
			</tr>
		
			<?php 
			}	
			echo " </table> ";
		
		
			//---SAYFALAMA LİNKLERİ//
			
			?>
			<div class='linkler'> <?php
			
				$range = 3; //ne kadar uzaktaki sayfayı göstereceği
				
					if($currentpage > 1){
						
					echo "<a href = '{$_SERVER['PHP_SELF']}?currentpage=1' > <<< </a>  "; //ilk sayfaya gitme linki
					
					$prevpage = $currentpage - 1;
					
					echo "<a href = '{$_SERVER['PHP_SELF']}?currentpage=$prevpage ' > << </a> " ;//bir önceki sayfa linki 
				}
					
					for($x = ($currentpage - $range ) ; $x < ($currentpage + $range ) +1 ; $x++   ){ //mevcut sayfanın ilerisi ve gerisindeki sayfaların gösterilmesini sağlıyan algoritma
						
						if(($x > 0) && ($x <= $totalpage) ){
							
							if($x == $currentpage){
						
								echo " [<b> $x </b>] " ;  // eğer mevcut sayfa örn 3 ise sayfa 3 linki tıklanamıycak
							}
							else{
								
								echo "<a href= '{$_SERVER['PHP_SELF']}?currentpage=$x '> $x </a> ";
							}
						}	
						
					}
					
					if($currentpage != $totalpage){
						
						$nextpage = $currentpage + 1;
						echo "<a href = '  p1deneme.php?currentpage=$nextpage ' > >> </a>	" ;
						
						echo "<a href = ' {$_SERVER['PHP_SELF']}?currentpage=$totalpage' > >>> 	</a> ";
					}
			?>
			</div>
			<?php
			
			mysqli_close($conn);
		}
		
		function search(){
			$sort='ASC';
				
				if(isset($_GET['asc'])){
				$sort='ASC';
	
				}
				else if(isset($_GET['desc'])){
					$sort='DESC';
					
				}
				else{
					$sort='ASC';
				}
			$conn= mysqli_connect('localhost' , 'root' ,'', 'proje'); 
			
			// formdan post edilen veriler bu fonksiyonda tanımlı değişkenlere atanıyor
			$noa=$_POST['noara'];
			$ada=$_POST['adara'];
			$soya=$_POST['soyadara'];
					
				
				
				$rowperpage=10; // kaç kayıt gösterileceği
				
				
				 
				
				$statement="kisiler WHERE  ad like '{$ada}%'  and  ono like '{$noa}%' and soyadi like '{$soya}%' ORDER BY ono {$sort} "; // like komutu ile inputtan gelen verileri içeren veriler aranıyor
				
			$ara= mysqli_query($conn,"SELECT * FROM {$statement} LIMIT {$rowperpage};" );
			echo "
			<table class='stable' >"; ?>
			<tr>
				<th colspan=5> Arama Sonuçları </th>
			
			</tr>
			
			<tr>
				<th > NO  </th>
				<th > Ad  </th>
				<th > Soyad</th>
				<th > </th>
				<th > </th>
			</tr>
			
			</tr><?php
			while($rec = mysqli_fetch_array($ara)){
				
			echo " 
				<tr >
					<td width=250px>", $rec[0] ,"</td>  
					<td width=250px>", $rec[1] ,"</td>
					<td width=250px>", $rec[2] ,"</td> 		"; ?>
					<td> <a class='a1' href=	'p1.php?sno=<?php echo "$rec[0]" ;?> '>	Sil	</a>		</td>
					<td> <a class='a1' href=	'p1.php?gno=<?php echo "$rec[0]" ;?> '>	Değiştir		</a> </td>	
				
				 
			</tr> 
				<?php
			}
			echo " </table> ";
			
			
		}
		
		function sil($col1){
			
			$conn = mysqli_connect('localhost' , 'root' , '', 'proje');
			$sql = "DELETE FROM kisiler WHERE ono= {$col1} ";  //get ile url den alınan ono ya göre silme işlemi yapılıyor
			$sil = mysqli_query($conn, $sql);
				if(!mysqli_query($conn,$sil)){
						echo "silindii";}
							else{
								echo "silinemedi";}
								
			mysqli_close($conn);
			
			
						
		}
		
		function update($col2){
			
			?>
			<table class="itable">
			<form method="post" >
			<tr>
			
				<td> <input class='i1' type='text' name='n1' placeholder="Numara giriniz" > </td> 	
				<td> <input class='i1' type='text' name='a1' placeholder="İsim Giriniz" > </td>
				<td> <input class='i1' type='text' name='s1' placeholder="Soyisim giriniz" > </td>
				<td> <input class='s1' type='submit' name='chg' value='DEĞİŞTİR' > </td>
			
				
			</tr>
			</form>
			</table>
				<?php	
				
				if(isset($_POST['chg']))
							update2($col2); ?>
			<?php
			
				
		}
		function update2($col3)
		{
			
					$n1=$_POST['n1'];
					$a1=$_POST['a1'];
					$s1=$_POST['s1'];
					$conn = mysqli_connect('localhost','root','','proje');
					
					
					$guncelle = "UPDATE kisiler SET ono = '$n1' , ad = '$a1' , soyadi = '$s1' WHERE ono = {$col3}  ";
					
					$result=mysqli_query($conn , $guncelle );
					

					mysqli_close($conn);
					
			
		}
		function ekle(){
				$conn= mysqli_connect('localhost' , 'root' ,'', 'proje');
				$no=$_POST['ono'];
				$name=$_POST['ad'];
				$surname=$_POST['soyad'];
				$ekle= "INSERT INTO kisiler(ono,ad,soyadi) VALUES('$no','$name','$surname')";
				
					if(!mysqli_query($conn,$ekle)){
						echo "eklenemedi";}
							else{
								echo "eklendi";}
				
				
			
	
			}
			?>
			
	
	
	
	
	
	
	
	
	
	</body>
</html>