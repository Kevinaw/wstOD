<html>
<header>
</header>
<body>

<input type="image" style="border:none;" src="/images/right_arrow.png" name="sdf">



<?php

$ass = array("1"=> 123, "2"=>2222,"3"=>3333,"4"=>4444,"5"=>5555);
var_dump($ass);

unset($ass['2']);
var_dump($ass);


unset($ass['20']);
var_dump($ass);
?>
</body>
</html>