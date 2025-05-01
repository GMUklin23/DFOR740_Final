<?php
if($_SERVER['HTTP_USER_AGENT'] != "fake" ) {
 echo "good";
 echo $_SERVER['HTTP_USER_AGENT'];
} else {
 echo "bad";
}
?>
<script>
 // Fake JS stuff here but it will always be part of the web page unlike PHP
</script>
