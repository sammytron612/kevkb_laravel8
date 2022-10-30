<!DOCTYPE html>
<html lang="en-US">
  <head>
  <meta charset="utf-8" />

  <style>


  </style>
  </head>

  <body>
    <h2>Welcome to Knowledge base</h2>
    <p><strong>'{{ $user }}'</strong>' has shared article <strong>'{{ $title }}'</strong> with you</p>
    <p>Click on the following  to view article</p>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
      <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <a href="{{ $url }}" target="_blank" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 3px; background-color: #EB7035; border-top: 12px solid #EB7035; border-bottom: 12px solid #EB7035; border-right: 18px solid #EB7035; border-left: 18px solid #EB7035; display: inline-block;">Click to view &rarr;</a>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

    <br>
    <br>
    <p>This link will be valid for 1 Hour</p>
    Regards,


    <br><br>
    @KLW 2020
  </body>
</html>
