<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" href="<?php echo base_url().'assets/jquerymobile'?>jquery.mobile-1.0rc1.min.css" />
	<link rel="stylesheet" href="<?php echo base_url().'assets/jquerymobile'?>site.css" />
	<link rel="stylesheet" href="<?php echo base_url().'assets/jquerymobile'?>mysite.css" />
	<script src="<?php echo base_url().'assets/jquerymobile'?>jquery-1.6.4.min.js"></script>
	<script src="<?php echo base_url().'assets/jquerymobile'?>jquery.mobile-1.0rc1.min.js"></script>
</head> 
<body>
<?php o(@$view['body'])?>
<script>
function showPage(url,page){
	$.mobile.changePage(url, {type:'post', data:{page:page}});
}
</script>
</body>
</html>
