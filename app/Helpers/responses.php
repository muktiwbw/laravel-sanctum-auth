<?php

function res($msg = null, $pyld = null, $code = 200) {
  $status = 'success';
  $message = $msg ?? 'Ok.';

  switch ($code) {
    case 200:
      $status = 'ok';
      $message = $msg ?? 'Succes';
      break;

    case 201:
      $status = 'data-created';
      $message = $msg ?? 'Data has been created';
      break;

    // Add more...
  }

  $res = [
    'status' => $status,
    'message' => $message
  ];

  if ($pyld) $res['data'] = $pyld;

  return $res;
}

function err($e) {
  $message = 'Unexpected error.';

  switch ($e->getCode()) {
    case 23000:
      $message = 'Error for duplicate value.';
      break;

    // Add more...

    // For manually thrown exceptions
    default:
      $message = $e->getMessage();
      break;
  }

  return [
    'status' => 'fail',
    'code' => $e->getCode(),
    'message' => $message
  ];
}