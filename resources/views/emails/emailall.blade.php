<!DOCTYPE html>
<html lang="en-US">
  <head>
  <meta charset="utf-8" />

  <style>


  </style>
  </head>

  <body>
    <h2>A new article has been added by {{ $user }},</h2>
    <p>Article titled <strong>{{ $title }}</strong> has been added to section <strong>{{ $section }}</strong></p>
    Check it out here

    <a href="{{ url('/articles',$id) }}"><h4>{{ $title }}</h4></a>

    <p>Thanks,</p>


  </body>
</html>
