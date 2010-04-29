<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Tulsa Hub - Bicycle Driver's Licenses</title>
</head>

<?php
$names = array(
	"Joe Smith",
	"Ren Berger",
	"Jesus H Christo"
);

foreach ($names as $name) {
?>
	<div style="width: 3in; height: 2in; background: right bottom url(images/logo_hub_small.gif); background-repeat: no-repeat; border: 1px solid black; margin-top: 5px;">
    	<div style="padding: 5px">
			<?php echo $name; ?><br />
            Certified Bicyclist<br />
            <?php echo date("m/d/Y"); ?>
        </div>
	</div>
<?php
}
?>
<body>
</body>
</html>
