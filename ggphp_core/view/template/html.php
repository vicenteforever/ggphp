<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo response()->script();?>
<?php echo response()->css();?>
<title><?php echo $data['title']?></title>
</head>

<body>
<div class='container'>
<?php echo $data['content']?>
</div>
</body>
</html>
