<?php
global $addVendorSubject;
global $addvendorMessage;
$addVendorSubject= "Welcome to XDI Connect!";
$addvendorMessage='<body>
	<div style="width:800px;margin:0 auto;background:#fff;border-radius:2px; border:1px solid #ddd;">
	<!-- Header Start -->
		<table style="border:0;width:100%;border-collapse: collapse;border-radius:20px;font-family:Arial, Helvetica, sans-serif;font-size:17px;">
			<tr BGCOLOR="#f5f7f9" style="border-bottom:1px solid #ddd;color:#666">
				<td style="padding:10px 20px"><img src="http://aapthitech.com/assets/images/admin_logo.png"></td><td style="padding:10px 20px;text-align:right;">Contact :<a href="#" style="text-decoration:none;color:#0092d2">admin@xdi.com</a></td>
			</tr>
		</table>
		<!-- Body Start-->
		<table style="border:0;width:100%;border-collapse: collapse;font-family:Arial, Helvetica, sans-serif;color:#333;font-size:17px;">
			<tr BGCOLOR="#fff">
				<td style="padding:20px">
					<p style="color:#666;margin:0;padding-top:5px;line-height:24px;">Vendor account has been created in xdi application, please login and update your due diligence.</p>
					<p style="color:#666;margin:0;padding-top:15px;line-height:22px;">Click here: <a href="http://www.xdi.com/">www.xdi.com</a></p>
					<p style="color:#666;margin:0;padding-top:5px;line-height:22px;"><b>Email :</b> <EMAIL></p>
					<p style="color:#666;margin:0;padding-top:5px;line-height:22px;"><b>Password :</b> <PASSWORD></p>
				</td>
			</tr>
		</table>
		<!-- Footer Strtt-->
		<table style="border:0;width:100%;border-collapse: collapse;">
		<tr bgcolor="#33373b" style="font-size:14px;line-height:22px;">
			<td style="padding:20px;color:#fff;text-align:center;font-family:Arial, Helvetica, sans-serif">Have a question? Check out the <a href="#" style="text-decoration:none;color:#6ebe44">XDI FAQs </a> on our website<br/></td>
		</tr>
		</table>
		</td>
	</div>
  </body>';

global $saveListSubject;
global $saveListMessage;
//$saveListSubject= "<SUBJECT>";
$saveListMessage='<body>
	<div style="width:800px;margin:0 auto;background:#fff;border-radius:2px; border:1px solid #ddd;">
	<!-- Header Start -->
		<table style="border:0;width:100%;border-collapse: collapse;border-radius:20px;font-family:Arial, Helvetica, sans-serif;font-size:17px;">
			<tr BGCOLOR="#f5f7f9" style="border-bottom:1px solid #ddd;color:#666">
				<td style="padding:10px 20px"><img src="http://aapthitech.com/assets/images/admin_logo.png"></td><td style="padding:10px 20px;text-align:right;">Contact :<a href="#" style="text-decoration:none;color:#0092d2">admin@xdi.com</a></td>
			</tr>
		</table>
		<!-- Body Start-->
		<table style="border:0;width:100%;border-collapse: collapse;font-family:Arial, Helvetica, sans-serif;color:#333;font-size:17px;">
			<tr BGCOLOR="#fff">
				<td style="padding:20px">
					<h4 style="color:#666;margin:0;padding-top:5px;line-height:24px"><u>VENDORS LIST</u></h4
					<p style="color:#666;margin:0;padding-top:15px;line-height:22px;"><NAMES></p>
				</td>
			</tr>
		</table>
		<!-- Footer Strtt-->
		<table style="border:0;width:100%;border-collapse: collapse;">
		<tr bgcolor="#33373b" style="font-size:14px;line-height:22px;">
			<td style="padding:20px;color:#fff;text-align:center;font-family:Arial, Helvetica, sans-serif">Have a question? Check out the <a href="#" style="text-decoration:none;color:#6ebe44">XDI FAQs </a> on our website<br/></td>
		</tr>
		</table>
		</td>
	</div>
  </body>';
  
  
/*forgetPassword*/
global $fpPwdWithOtpSubject;
global $fpPwdWithOtpMessage;
$fpPwdWithOtpSubject = "Password Reset request for Bikeseva Admin account";
$fpPwdWithOtpMessage = '<body>
	<table style="width:600px; font-family:arial,sans-serif;font-size: 12px !important;line-height: 1.5; border-collapse: collapse; border:1px solid #ff0000;" border="0" cellpadding="2">
		<tr>
			<td align="center" colspan="3" bgcolor="#fff">
				<a href="https://bikeseva.com/" alt="Bikeseva" target="_blank" style="text-decoration: none;">
				<img src="https://bikeseva.com/images/email/email_header.png" width="600px" height="auto"></a></td>
		</tr>
			<tr>
				<td colspan="3">
					<p>Dear&nbsp;&nbsp;<FULLNAME>,</p>
					<p>We have received a password reset request for your Bikeseva Admin account.</p>
					<p style="color:#333" align="center">Click below to reset</p>
					<center><a style="text-decoration: none; color:#333" href="<PASSWORDLINK>"><p style="color:#333"><span style="color:#fff; font:normal 12px arial;background:rgba(255, 0, 0, 0.8) none repeat scroll 0 0;padding: 6px 10px 6px 10px;  border-radius: 8px;text-align:center;">Reset Password</span></p></a></center>
					<p style="color:#333">Or copy and paste the following into your browser:
					Link... <br>&nbsp;&nbsp; <PASSWORDLINK>  </p>
					<p style="color:#333"> If clicking the above link does not work, copy and paste the URL in a new browser window. The URL will expire in 24 hours for security reasons. If you did not make this request, simply ignore this message. </p>
					<p style="color:#333"><strong>Note</strong>: <span style="color:red">This email is having confidential information about your account; please do not share this email to anyone</span>. </p>					
				</td>
			</tr>
			<tr style="background-color:#e4e4e4;">
			<td colspan="3">  
				Thank you,<br/>
				Bikeseva Team
			</td>
		</tr>
		<tr style="background-color:#c0bebe; line-height:1.5;" >
			<td colspan="3">
				<p align="center" style="font-size:80%;">We will be happy to assist you. For any questions, suggestions or comments please contact us at<br/>
				<img src="https://bikeseva.com/images/email/pe.png" width="65%" height="auto">
				<br/>
				Get social and make sure you join in the fun with Bikeseva on<br/>
				<span style="padding-left:0px;" >
					<a style="text-decoration: none;" target="_blank" href="https://www.facebook.com/bikeseva"><img src="https://bikeseva.com/images/email/facebook.png" width="4%" height="auto"></a> 
					<a style="text-decoration: none;" target="_blank" href="https://www.twitter.com/bikeseva"><img src="https://bikeseva.com/images/email/twitter.png" width="4%" height="auto"></a>
					<a style="text-decoration: none;" target="_blank" href="https://plus.google.com/116548473641821145146/about"><img src="https://bikeseva.com/images/email/g+.png" width="4%" height="auto"></a>
					<a style="text-decoration: none;" target="_blank" href="https://www.linkedin.com/company/bikeseva"><img src="https://bikeseva.com/images/email/linkedin.png" width="4%" height="auto"> </a>
				</span><br/>
				<span style="font-size:75%;" >You have received this message because you have either registered or accepted privacy policies and terms of use of bikeseva. Please add customercare@bikeseva.com to your address book or safe sender list to ensure that you continue to receive Bikeseva emails to your inbox.</span></p>
			</td> 				
		</tr>
		<tr style="background-color:#e4e4e4; text-align:center;">
			<td colspan="3">
				<a style="text-decoration: none; font-size:11px;color:#ff0000" href="https://bikeseva.com/" target="_blank"><strong>&#169 2016 BIKESEVA ALL RIGHTS RESERVED</strong>.</a>
			</td>
		</tr>
	</table>
</body>';
/*End*/