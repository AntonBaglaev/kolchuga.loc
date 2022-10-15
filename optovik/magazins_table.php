<link href='/local/templates/kolchuga_2016/css/bootstrap.css' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="/local/templates/kolchuga_2016/js/bootstrap.min.js"></script>
<?
$rsData = include_once 'magazins_array.php';
?>
<div class="table-responsive" style="background-color:#fff;padding: 1em;">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ГОРОД</th>
      <th scope="col">Название магазина</th>
      <th scope="col">Телефон</th>
      <th scope="col">Адрес магазина</th>
    </tr>
  </thead>
  <tbody>
    
<?
foreach ($rsData as $gorod=>$store0) {
	foreach($store0 as $store){
		?>
		<tr>
      <th scope="row"><?=$gorod?></th>
      <td><?=$store[1]?></td>
      <td><?=$store[2]?></td>
      <td><?=$store['fulladress']?></td>
    </tr>
	<?
	}
	
}
?>
</tbody>
</table>
</div>