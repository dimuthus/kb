<?php
use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title></title>
    
</head>
    <body>
<!--<h3 style="color:limegreen"><em>RE: LMS_Loyality Offer: < ? echo $accepted_offer ?> </em></h3>
<p><span><b>Enquiry:-</b> State the reference number for the registration form and/or the request - (i.e. "Customer Registration: Package A")</span></p>
<h3 style="color:limegreen"><em>Solution:</em></h3>
<p><span><b>Dear Team:-</b></p>-->
<!--<h3 style="color:limegreen"><em>Opening:</em></h3>-->
<p>Please find the following details for your kind action.</p>
<br/>
<table>
    
     <tr>
        <td>Interaction Date & Time : </td>
        <td><?php echo $creation_datetime ?></td>
    </tr>
   
    <tr>
        <td>Caller's full name : </td>
        <td><?php echo $full_name ?></td>
    </tr>
    <tr>
        <td>Contact Number : </td>
        <td><?php echo $mobile_number ?></td>
    </tr>
    <tr>
        <td>Email Address : </td>
        <td><?php echo $email ?></td>
    </tr>
	<tr>
        <td>Language (Caller Spoken in) : </td>
        <td><?php echo $customer_language ?></td>
    </tr>
	<tr>
        <td>Case Created by : </td>
        <td><?php echo $created_by ?></td>
    </tr>
	<tr>
        <td>Case Type : </td>
        <td><?php echo $caseType ?></td>
    </tr>
    <tr>
        <td>Case Note : </td>
        <td><?php echo $comments ?></td>
    </tr>
</table>
<!--<ol>
    <li>Customer Name</li>
    <li>Phone Number</li>
    <li>Accepted Offer</li>
    <li>Delivery Address</li>
    <li>Preferred Delivery Date</li>
    <li>Device</li>
    <li>New SIM Card Required</li>
    <li>Preferred Time for follow up call</li>
    <li>Requested Pot Out Time</li>
</ol>
<p>Please feel free to revert should you require further information regarding this.</p>-->
<p>Thank you and best regards,</p>
<p style="color: lightskyblue">ExxonMobil ERPIC Contact Center - Scicom</p>
<br>
<!--<span style="color:limegreen"><em>Disclaimer:</em></span><br>
<span style="color: blue"><b>DISCLAIMER:</b></span><br>
<span style="color: dodgerblue">(Disclaimer to be obtained from Clients)</span><br>-->
    </body>
    </html>
<?php $this->endPage() ?>