<?php
defined('JPATH_BASE') or die;

$d = $displayData;
$width = null;
foreach ([0, 25, 50, 75, 100] as $allowed) {
	if ($width === null || abs($d->cols - $width) > abs($allowed - $d->cols)) {
		$width = $allowed;
	}
}

if ($width == 0) $width = "auto";
$height_style = $d->height > 1 ? ' style="overflow-y:auto; overflow-wrap:anywhere; height:'. ($d->height +.9)*1.5 . 'rem"' : '';
?>

<div class="form-control-plaintext w-<?php echo $width;?> "<?php echo $height_style;?> 
	name="<?php echo $d->name;?>"
	id="<?php echo $d->id;?>" >
	<?php echo htmlspecialchars_decode($d->value);?>
	</div>