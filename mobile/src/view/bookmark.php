<?php foreach($data as $id=>$bookmark){ ?>
<div class='bookmark' style='margin:5px;float:left;border:1px solid #ccc;width:100%;height:50px' id='<?php echo $id?>'>
<table style="word-break:break-all; table-layout:fix;overflow:hidden" border=0 width=100% height=100%><tr>
<td onclick="bookmarkplay('<?php echo addslashes($bookmark['file'])?>', '<?php echo $bookmark['time']?>')" align=left valign=middle><?php echo $bookmark['title'].'<br>'.$bookmark['time']?></td>
<td width=50 onclick="bookmarkdelete('<?php echo addslashes($id)?>',this)">删除</td>
</tr></table>
</div>
<?php } ?>