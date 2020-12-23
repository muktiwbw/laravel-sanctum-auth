<?php

function catcher($fn) {
  try {
    return $fn();
  } catch (\Exception $e) {
    return response()->json(err($e));
  }
}