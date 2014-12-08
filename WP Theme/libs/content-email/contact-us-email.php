<?php
extract($_REQUEST);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

</head>

<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
<table>
    <tr>
        <td>Subject:</td>
        <td><?php echo @$send_subject; ?></td>
    </tr>
    <tr>
        <td>Name:</td>
        <td><?php echo @$send_name; ?></td>
    </tr>
    <tr>
        <td>Email:</td>
        <td><?php echo @$send_email; ?></td>
    </tr>
    <tr>
        <td>Phone number:</td>
        <td><?php echo @$send_phone_number; ?></td>
    </tr>
    <tr>
        <td>Message:</td>
        <td><?php echo @$send_message; ?></td>
    </tr>
</table>
</body>
</html>
