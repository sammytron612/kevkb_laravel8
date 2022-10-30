<!DOCTYPE html>
<html lang="en-US">
  <head>
  <meta charset="utf-8" />

  <style>


  </style>
  </head>

  <body>
    <h2>Hi {{ $user }},</h2>
    <p>Sadly the article <strong>'{{ $title }}'</strong> has been rejected</p>
    <p>for the following reason</p>
    <h5> {{ $reason }} </h5>
    It has been moved to your drafts for editing
    <p>Thanks</p>


  </body>
</html>
