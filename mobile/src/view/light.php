<?php foreach($data as $id=>$light){ ?>
<div onclick="light(this)" class='light_<?php echo $light['status']?>' id='<?php echo $id?>'>
<table width=100% height=100%><tr><td align=center valign=middle><?php echo $light['title']?></td></tr></table>
</div>
<?php } ?>