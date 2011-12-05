<?php
header('Content-Disposition: attachment; filename="'.$data['filename'].'"');
echo $data['content'];