<?php

function redirect_to($time_in_seconds, $newloc)
{
  header("refresh:{$time_in_seconds};url={$newloc}");
}
?>