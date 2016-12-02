<?php
/* ForgetPassword */
	global $smsForgetMessage;
	$smsForgetMessage = '<OTP> is your OTP for Bike seva reset password.';
/*End*/
/* Assigned Service to ServiceProvider */
global $proccessStatusSubject;
global $proccessStatusMessage;
$proccessStatusSubject= "Your Service is assigned";
$proccessStatusMessage='<body style="margin: 0;padding: 0;">
       <div style="position: relative;margin-left: auto;margin-right: auto;width: 620px;height: 500px;overflow: hidden;z-index:0;border:1px solid #ddd; box-shadow:0 2px 2px rgba(0, 0, 0, 0.3);">
               <div style="border-bottom:1px solid #ddd;padding:10px 10px;background:#f7f7f7;">
                       <img src="https://mydigitalsurvey.com/images/logoblack1.png">
               </div>
               <div style="position:relative;padding:20px 30px;">
                       <div style="font-size:15px;">Dear   &nbsp;<FULLNAME>,</div>
                       <div style="width: 620px;height: 360px;display:table-cell;vertical-align:middle;text-align:center;">        
                               <p style="font-family:sinkin_sans500_medium, sans-serif;font-weight:bold;">
							   Your booing <BOOKINGID> service is  moved <BTRACKSTAGE> - <BTRACKSTATUS> to <PTRACKSTAGE> - <PTRACKSTATUS> .</p> 							   
                       </div> 
               </div>
       </div>
</body>';
/*End*/

global $secondStepMessage;
$secondStepMessage = 'Dear Customer, In short time our pick-up boy will come and pick your bike for service. Brief your problem to him and check your Pick-up ID <PICKUPID> against him -Bikeseva.com';

global $smsSentToMessage;
$smsSentToMessage = 'Hi,Bike service pick-up ID: <PICKUPID> Name: <USERNAME> Mob: <MOBILE> Bike: <BIKENAME> - <BIKEREG> Add: <ADDRESS>';


global $finalCloseMessage;
$finalCloseMessage = 'Dear Customer, Your Bike service (<BOOKINGID>) is completed and ready for delivery at your door step. Please be ready with bill amount <TOTALAMOUNT> /-  -Bikeseva.com';

global $adminLoginOtpMessage;
$adminLoginOtpMessage = '<OTP> is your OTP for Login to Bikeseva admin account - Bikeseva.com';
/* ReAssignedService Service to ServiceProvider */
global $reAssignedServiceSubject;
global $reAssignedServiceMessage;
$reAssignedServiceSubject= "Reassigned to Service";
$reAssignedServiceMessage='<body style="margin: 0;padding: 0;">
       <div style="position: relative;margin-left: auto;margin-right: auto;width: 620px;height: 500px;overflow: hidden;z-index:0;border:1px solid #ddd; box-shadow:0 2px 2px rgba(0, 0, 0, 0.3);">
               <div style="border-bottom:1px solid #ddd;padding:10px 10px;background:#f7f7f7;">
                       <img src="https://mydigitalsurvey.com/images/logoblack1.png">
               </div>
               <div style="position:relative;padding:20px 30px;">
                       <div style="font-size:15px;">Dear   &nbsp;<FULLNAME>,</div>
                       <div style="width: 620px;height: 360px;display:table-cell;vertical-align:middle;text-align:center;">        
                               <p style="font-family:sinkin_sans500_medium, sans-serif;font-weight:bold;">
							   Your booing <BOOKINGID> service is to <SP> .</p> 							   
                       </div> 
               </div>
       </div>
</body>';
/*End*/
/* Assigned Service to ServiceProvider */
global $assignedServiceSubject;
global $assignedServiceMessage;
$assignedServiceSubject= "Your Service is assigned";
$assignedServiceMessage='<body style="margin: 0;padding: 0;">
       <div style="position: relative;margin-left: auto;margin-right: auto;width: 620px;height: 500px;overflow: hidden;z-index:0;border:1px solid #ddd; box-shadow:0 2px 2px rgba(0, 0, 0, 0.3);">
               <div style="border-bottom:1px solid #ddd;padding:10px 10px;background:#f7f7f7;">
                       <img src="https://mydigitalsurvey.com/images/logoblack1.png">
               </div>
               <div style="position:relative;padding:20px 30px;">
                       <div style="font-size:15px;">Dear   &nbsp;<FULLNAME>,</div>
                       <div style="width: 620px;height: 360px;display:table-cell;vertical-align:middle;text-align:center;">        
                               <p style="font-family:sinkin_sans500_medium, sans-serif;font-weight:bold;">
							   Your booing <BOOKINGID> service is to <SP> .</p> 							   
                       </div> 
               </div>
       </div>
</body>';
/*End*/
/* Waiting approval */
global $adminLoginSubject;
global $adminLoginMessage;
$adminLoginSubject= "Waiting for approval from admin";
$adminLoginMessage='<body style="margin: 0;padding: 0;">
       <div style="position: relative;margin-left: auto;margin-right: auto;width: 620px;height: 500px;overflow: hidden;z-index:0;border:1px solid #ddd; box-shadow:0 2px 2px rgba(0, 0, 0, 0.3);">
               <div style="border-bottom:1px solid #ddd;padding:10px 10px;background:#f7f7f7;">
                       <img src="https://mydigitalsurvey.com/images/logoblack1.png">
               </div>
               <div style="position:relative;padding:20px 30px;">
                       <div style="font-size:15px;">Dear   &nbsp;<ADMIN>,</div>
                       <div style="width: 620px;height: 360px;display:table-cell;vertical-align:middle;text-align:center;">        
                               <p style="font-family:sinkin_sans500_medium, sans-serif;font-weight:bold;">
							   <FULLNAME> <USERLEVEL> is waiting for approval from your side.</p> 							   
                       </div> 
               </div>
       </div>
</body>';
/*End*/
/* Waiting approval */
global $adminApprovedSubject;
global $adminApprovedMessage;
$adminApprovedSubject= "Approve your login";
$adminApprovedMessage='<body style="margin: 0;padding: 0;">
       <div style="position: relative;margin-left: auto;margin-right: auto;width: 620px;height: 500px;overflow: hidden;z-index:0;border:1px solid #ddd; box-shadow:0 2px 2px rgba(0, 0, 0, 0.3);">
               <div style="border-bottom:1px solid #ddd;padding:10px 10px;background:#f7f7f7;">
                       <img src="https://mydigitalsurvey.com/images/logoblack1.png">
               </div>
               <div style="position:relative;padding:20px 30px;">
                       <div style="font-size:15px;">Dear   &nbsp;<FULLNAME>,</div>
                       <div style="width: 620px;height: 360px;display:table-cell;vertical-align:middle;text-align:center;">        
                               <p style="font-family:sinkin_sans500_medium, sans-serif;font-weight:bold;">
							   <ADMIN> is approved to login. Your stay to login in <SESSION> , after <SESSION> automatically session out.</p> 							   
                       </div> 
               </div>
       </div>
</body>';
/*End*/
/* register subject */
global $regTESubject;
global $regTEMessage;
$regTESubject= "Registration confirmation";
$regTEMessage='<body style="margin: 0;padding: 0;">
       <div style="position: relative;margin-left: auto;margin-right: auto;width: 620px;height: 500px;overflow: hidden;z-index:0;border:1px solid #ddd; box-shadow:0 2px 2px rgba(0, 0, 0, 0.3);">
               <div style="border-bottom:1px solid #ddd;padding:10px 10px;background:#f7f7f7;">
                       <img src="https://mydigitalsurvey.com/images/logoblack1.png">
               </div>
               <div style="position:relative;padding:20px 30px;">
                       <div style="font-size:15px;">Dear   &nbsp;<FULLNAME>,</div>
                       <div style="width: 620px;height: 360px;display:table-cell;vertical-align:middle;text-align:center;">        
                               <p style="font-family: sinkin_sans500_medium, sans-serif;font-size:16px">Login credentials </p>
                               <p style="font-family:sinkin_sans500_medium, sans-serif;font-weight:bold;">
							   <EMAIL></p> 
							   <p style="font-family:sinkin_sans500_medium, sans-serif;font-weight:bold;">
							   <PASSWORD></p>
							   <p style="font-family:sinkin_sans500_medium, sans-serif;font-weight:bold;">
							   <a href="<REGLINK>"><REGLINK></a></p> 
                       </div> 
               </div>
       </div>
</body>';
/*End*/
/* Verfication Register */
global $reAuthSubject;
global $reAuthMessage;
$reAuthSubject= "BIKESEVA";
$reAuthMessage='<body style="margin: 0;padding: 0;">
       <div style="position: relative;margin-left: auto;margin-right: auto;width: 620px;height: 500px;overflow: hidden;z-index:0;border:1px solid #ddd; box-shadow:0 2px 2px rgba(0, 0, 0, 0.3);">
               <div style="border-bottom:1px solid #ddd;padding:10px 10px;background:#f7f7f7;">
                       <img src="https://mydigitalsurvey.com/images/logoblack1.png">
               </div>
               <div style="position:relative;padding:20px 30px;">
                       <div style="font-size:15px;">Dear   &nbsp;<FULLNAME>,</div>
                       <div style="width: 620px;height: 360px;display:table-cell;vertical-align:middle;text-align:center;">        
                               <p style="font-family: sinkin_sans500_medium, sans-serif;font-size:16px">Your account has been Activated.</p>
                               <p style="font-family:sinkin_sans500_medium, sans-serif;font-weight:bold;"><a href="<REGLINK>"><REGLINK></a></p> 
                       </div> 
               </div>
       </div>
</body>';
/*END*/
/*forgetPassword*/
global $fpPwdSubject;
global $fpPwdMessage;
$fpPwdSubject = "BikeSeva Password Reset Link.";
$fpPwdMessage = '<body style="margin: 0;padding: 0;">
       <div style="position: relative;margin-left: auto;margin-right: auto;width: 620px;height: 500px;overflow: hidden;z-index:0;border:1px solid #ddd; box-shadow:0 2px 2px rgba(0, 0, 0, 0.3);">
               <div style="border-bottom:1px solid #ddd;padding:10px 10px;background:#f7f7f7;">
                       <img src="https://mydigitalsurvey.com/images/logoblack1.png">
               </div>
               <div style="position:relative;padding:20px 30px;">
                       <div style="font-size:15px;">Dear   &nbsp;<FULLNAME>,</div>
                       <div style="width: 620px;height: 360px;display:table-cell;vertical-align:middle;text-align:center;">        
                               <p style="font-family: sinkin_sans500_medium, sans-serif;font-size:16px"><MESSAGE></p>
							   <p style="font-family:sinkin_sans500_medium, sans-serif;font-weight:bold;"><PASSWORDLINK></p>
                       </div> 
               </div>
       </div>
</body>';
/*End*/
/*forgetPassword*/
global $fpPwdWithOtpSubject;
global $fpPwdWithOtpMessage;
$fpPwdWithOtpSubject = "BikeSeva Password Reset Link.";
$fpPwdWithOtpMessage = '<body style="margin: 0;padding: 0;">
       <div style="position: relative;margin-left: auto;margin-right: auto;width: 620px;height: 500px;overflow: hidden;z-index:0;border:1px solid #ddd; box-shadow:0 2px 2px rgba(0, 0, 0, 0.3);">
               <div style="border-bottom:1px solid #ddd;padding:10px 10px;background:#f7f7f7;">
                       <img src="https://mydigitalsurvey.com/images/logoblack1.png">
               </div>
               <div style="position:relative;padding:20px 30px;">
                       <div style="font-size:15px;">Dear   &nbsp;<FULLNAME>,</div>
                       <div style="width: 620px;height: 360px;display:table-cell;vertical-align:middle;text-align:center;">        
                               <p style="font-family: sinkin_sans500_medium, sans-serif;font-size:16px"><MESSAGE></p>
							   <p style="font-family:sinkin_sans500_medium, sans-serif;font-weight:bold;"><PASSWORDLINK></p>
                       </div> 
               </div>
       </div>
</body>';
/*End*/
/*Add Booking*/
global $bookSubject;
global $bookMessage;
$bookSubject = "Booking Confirmation.";
$bookMessage = '<body style="margin: 0;padding: 0;">
       <div style="position: relative;margin-left: auto;margin-right: auto;width: 620px;height: 500px;overflow: hidden;z-index:0;border:1px solid #ddd; box-shadow:0 2px 2px rgba(0, 0, 0, 0.3);">
               <div style="border-bottom:1px solid #ddd;padding:10px 10px;background:#f7f7f7;">
                       <img src="https://mydigitalsurvey.com/images/logoblack1.png">
               </div>
               <div style="position:relative;padding:20px 30px;">
                       <div style="font-size:15px;">Dear &nbsp;<FULLNAME>,</div>
                       <div style="width: 620px;height: 360px;display:table-cell;vertical-align:middle;text-align:center;">        
                               <p style="font-family: sinkin_sans500_medium, sans-serif;font-size:16px">Booking Id: <BOOKINGID></p>
							   <p style="font-family: sinkin_sans500_medium, sans-serif;font-size:16px">Tracking Id: <TXNTID></p> 
							   <p style="font-family: sinkin_sans500_medium, sans-serif;font-size:16px">Note: TrackingId and Booking Id are same.</p>							  
                       </div> 
               </div>
       </div>
</body>';
/*End*/
/*Cancell Booking*/
global $bookCancelSubject;
global $bookCancelMessage;
$bookCancelSubject = "Cancelled Your Booking.";
$bookCancelMessage = '<body style="margin: 0;padding: 0;">
       <div style="position: relative;margin-left: auto;margin-right: auto;width: 620px;height: 500px;overflow: hidden;z-index:0;border:1px solid #ddd; box-shadow:0 2px 2px rgba(0, 0, 0, 0.3);">
               <div style="border-bottom:1px solid #ddd;padding:10px 10px;background:#f7f7f7;">
                       <img src="https://mydigitalsurvey.com/images/logoblack1.png">
               </div>
               <div style="position:relative;padding:20px 30px;">
                       <div style="font-size:15px;">Dear &nbsp;<FULLNAME>,</div>
                       <div style="width: 620px;height: 360px;display:table-cell;vertical-align:middle;text-align:center;">        
                       <p style="font-family: sinkin_sans500_medium, sans-serif;font-size:16px">Booking Id: <BOOKINGID></p>
					   <p style="font-family: sinkin_sans500_medium, sans-serif;font-size:16px">Transaction Id: <TXNTID></p> 
					   <p style="font-family: sinkin_sans500_medium, sans-serif;font-size:16px">Note: TrackingId and Booking Id are same.</p>							  
                       </div> 
               </div>
       </div>
</body>';
/*End*/
/*Cancell OTP Booking*/
global $bookCancelOTPSubject;
global $bookCancelOTPMessage;
$bookCancelOTPSubject = "Cancelled OTP.";
$bookCancelOTPMessage = '<body style="margin: 0;padding: 0;">
       <div style="position: relative;margin-left: auto;margin-right: auto;width: 620px;height: 500px;overflow: hidden;z-index:0;border:1px solid #ddd; box-shadow:0 2px 2px rgba(0, 0, 0, 0.3);">
               <div style="border-bottom:1px solid #ddd;padding:10px 10px;background:#f7f7f7;">
                       <img src="https://mydigitalsurvey.com/images/logoblack1.png">
               </div>
               <div style="position:relative;padding:20px 30px;">
                       <div style="font-size:15px;">Dear &nbsp;<FULLNAME>,</div>
                       <div style="width: 620px;height: 360px;display:table-cell;vertical-align:middle;text-align:center;">        
                               <p style="font-family: sinkin_sans500_medium, sans-serif;font-size:16px">Booking Id : <BOOKINGID></p>
							   <p style="font-family: sinkin_sans500_medium, sans-serif;font-size:16px">Otp: <OTP></p> 
							   <p style="font-family: sinkin_sans500_medium, sans-serif;font-size:16px">Note: TrackingId and Booking Id are same.</p>							  
                       </div> 
               </div>
       </div>
</body>';
/*End*/
/*Profile OTP */
global $profileOTPSubject;
global $profileOTPMessage;
$profileOTPSubject = "Confirmation Otp";
$profileOTPMessage = '<body style="margin: 0;padding: 0;">
       <div style="position: relative;margin-left: auto;margin-right: auto;width: 620px;height: 500px;overflow: hidden;z-index:0;border:1px solid #ddd; box-shadow:0 2px 2px rgba(0, 0, 0, 0.3);">
               <div style="border-bottom:1px solid #ddd;padding:10px 10px;background:#f7f7f7;">
                       <img src="https://mydigitalsurvey.com/images/logoblack1.png">
               </div>
               <div style="position:relative;padding:20px 30px;">
				   <div style="font-size:15px;">Dear &nbsp;<FULLNAME>,</div>
				   <div style="width: 620px;height: 360px;display:table-cell;vertical-align:middle;text-align:center;"> 
					<p style="font-family: sinkin_sans500_medium, sans-serif;font-size:16px">Otp: <OTP></p> 
				</div> 
               </div>
       </div>
</body>';
/*End*/