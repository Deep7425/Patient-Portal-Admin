<?php
use Illuminate\Http\Request;
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([],function () {
	Route::post('/upload-prescription-image', 'API23MAR2023\MedicineController@uploadPrescriptionImage');
	Route::post('/notifyDoctorForVcall', 'API23MAR2023\HomeController@notifyDoctorForVcall');
	Route::post('/checkVersionOfApp', 'API23MAR2023\HomeController@checkVersionOfApp');
    Route::post('/login','API23MAR2023\UserController@login');
	Route::post('/resendOtp','API23MAR2023\UserController@resendOtp');
	Route::post('/otpVerified', 'API23MAR2023\UserController@otpVerified');
	Route::post('/forgot-password', 'API23MAR2023\UserController@forgot');
	Route::post('/getPatientPortalSliders', 'API23MAR2023\HomeController@getPatientPortalSliders');
	Route::post('/thyrocarelogin', 'API23MAR2023\LabController@thyrocarelogin');
	
	Route::any('/appointmentCheckout', 'API23MAR2023\HomeController@appointmentCheckout');
	Route::any('/subscriptionPay', 'API23MAR2023\SubscriptionController@subscriptionPay');
	Route::any('/labCheckout', 'API23MAR2023\LabController@labCheckout');
	Route::post('/uploadDocument', 'API23MAR2023\PatientEhrController@uploadDocument');
	
	Route::post('/staticPages', 'API23MAR2023\HomeController@staticPages');
	
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
		Route::post('/getPatientOpd', 'API23MAR2023\PatientEhrController@getPatientOpd');
		Route::post('/getThyrocarePackageGroup', 'API23MAR2023\LabController@getThyrocarePackageGroup');
		Route::post('/createLaborderAddresses', 'API23MAR2023\LabController@createLaborderAddresses');
		Route::post('/getMyLabOrders', 'API23MAR2023\LabController@getMyLabOrders');
		Route::post('details', 'API23MAR2023\UserController@details');
		/********* Patient Portal API23MAR2023 ***********/
		Route::post('/download-subscription-receipt', 'API23MAR2023\SubscriptionController@downloadSubscriptionReceipt');
		Route::post('/saveuserlocation', 'API23MAR2023\UserController@saveUserLocation');
		Route::post('/checkFirstDirectTeleAppointment', 'API23MAR2023\HomeController@checkFirstDirectTeleAppointment');
		Route::post('/checkFirstTeleAppointment', 'API23MAR2023\HomeController@checkFirstTeleAppointment');
		Route::post('/logoutUser','API23MAR2023\UserController@logoutUser');
		Route::post('/updateFcmToken','API23MAR2023\UserController@updateFcmToken');
		Route::post('/addUser','API23MAR2023\UserController@addUser');
		Route::post('/change-password', 'API23MAR2023\UserController@ChangePassword');
		Route::post('/getOnCallDoctors', 'API23MAR2023\HomeController@getOnCallDoctors');
		Route::post('/getOnCallDoctorsDemo', 'API23MAR2023\HomeController@getOnCallDoctorsDemo');
		Route::post('/getCountryPhoneCode', 'API23MAR2023\HomeController@getCountryPhoneCode');
		Route::post('/getNewsFeedsData', 'API23MAR2023\HomeController@getNewsFeedsData');
		Route::post('/searchDoctors', 'API23MAR2023\HomeController@searchDoctors');
		Route::post('/getDocSpeciality', 'API23MAR2023\HomeController@getDocSpeciality');
		Route::post('/getDocByPractice', 'API23MAR2023\HomeController@getDocByPractice');
		Route::post('/getCountry', 'API23MAR2023\HomeController@getCountry');
		Route::post('/getState', 'API23MAR2023\HomeController@getState');
		Route::post('/getCity', 'API23MAR2023\HomeController@getCity');
		Route::post('/searchCity', 'API23MAR2023\HomeController@searchCity');
		Route::post('/getMyProfile', 'API23MAR2023\HomeController@getMyProfile');
		Route::post('/updateMyProfile', 'API23MAR2023\HomeController@updateMyProfile');
		Route::post('/getUserImage', 'API23MAR2023\HomeController@getUserImage');
		Route::post('/searchDoctorsByAddress', 'API23MAR2023\HomeController@searchDoctorsByAddress');
		Route::post('/addAppointment', 'API23MAR2023\HomeController@addAppointment');
		Route::post('/addAppointmentDemo', 'API23MAR2023\HomeController@addAppointmentDemo');
		Route::post('/searchDoctorsByFilters', 'API23MAR2023\HomeController@searchDoctorsByFilters');
		Route::post('/getDoctorCounsultMaxFees', 'API23MAR2023\HomeController@getDoctorCounsultMaxFees');
		Route::post('/getDoctorSlotsByDay', 'API23MAR2023\HomeController@getDoctorSlotsByDay');
		Route::post('/getDocById', 'API23MAR2023\HomeController@getDocById');
		Route::post('/getDocDetailById', 'API23MAR2023\HomeController@getDocDetailById');
		Route::post('/cancelAppointment', 'API23MAR2023\HomeController@cancelAppointment');
		Route::post('/updateSchedule', 'API23MAR2023\HomeController@updateSchedule');
		Route::post('/checkAppointmentStatus', 'API23MAR2023\HomeController@checkAppointmentStatus');
		Route::post('/move-on-1mg', 'API23MAR2023\HomeController@moveTo1MgSite');
		Route::post('/getSponseredDoc', 'API23MAR2023\HomeController@getSponseredDoc');
		Route::post('/getHospitalInfoById', 'API23MAR2023\HomeController@getHospitalInfoById');
		Route::post('/makeFollowUpAppt', 'API23MAR2023\HomeController@makeFollowUpAppt');



		Route::post('/getDoctorSlots', 'API23MAR2023\HomeController@getDoctorSlots');
		Route::post('/getDocBySpeciality', 'API23MAR2023\HomeController@getDocBySpeciality');
		Route::post('/getPatients', 'API23MAR2023\CommonController@getPatients');
		Route::post('/getComplimentsData', 'API23MAR2023\CommonController@getComplimentsData');
		Route::post('/getWaitingTimeData', 'API23MAR2023\CommonController@getWaitingTimeData');

		Route::post('/getFoodPreferenceMaster', 'API23MAR2023\CommonController@getFoodPreferenceMaster');
		Route::post('/getSmokingHabitsMaster', 'API23MAR2023\CommonController@getSmokingHabitsMaster');
		Route::post('/getOccupationMaster', 'API23MAR2023\CommonController@getOccupationMaster');
		Route::post('/getAlcoholConsumptionMaster', 'API23MAR2023\CommonController@getAlcoholConsumptionMaster');
		Route::post('/getActivityLevelMaster', 'API23MAR2023\CommonController@getActivityLevelMaster');
		Route::post('/getTopSpecialities', 'API23MAR2023\CommonController@getTopSpecialities');
		Route::post('/getReferLinkMsg', 'API23MAR2023\CommonController@getReferLinkMsg');
		Route::post('/getCouponCodeLists', 'API23MAR2023\CommonController@getCouponCodeLists');

		Route::post('/getPatientPrescriptionData', 'API23MAR2023\PatientEhrController@getPatientPrescriptionData');
		Route::post('/getPatientPrescription', 'API23MAR2023\PatientEhrController@getPatientPrescription');
		Route::post('/getPatientOpdNew', 'API23MAR2023\PatientEhrController@getPatientOpdNew');
		Route::post('/getClinicalNoteByApp', 'API23MAR2023\PatientEhrController@getClinicalNoteByApp');
		Route::post('/downloadReceipt', 'API23MAR2023\PatientEhrController@downloadReceipt');
		Route::post('/getUserDocument', 'API23MAR2023\PatientEhrController@getUserDocument');
		Route::post('/deletePrescription', 'API23MAR2023\PatientEhrController@deletePrescription');
		Route::post('/deleteDocument', 'API23MAR2023\PatientEhrController@deleteDocument');
		Route::post('/feedback', 'API23MAR2023\PatientEhrController@feedback');
		Route::post('/latestappointmentfeedback', 'API23MAR2023\PatientEhrController@latestappointmentfeedback');
		Route::post('/checkAppointmentCouponCode', 'API23MAR2023\PatientEhrController@checkAppointmentCouponCode');
		Route::post('/getCashcack', 'API23MAR2023\CommonController@getCashcack');
		Route::post('/get-rewards', 'API23MAR2023\CommonController@getRewards');
		Route::post('/send-invite-sms', 'API23MAR2023\CommonController@sendInviteSms');
		Route::post('/get-ref-page-data', 'API23MAR2023\CommonController@getRefPageData');
		Route::post('/put-ref-code', 'API23MAR2023\CommonController@registerReferred');
		Route::post('/getSymtomData', 'API23MAR2023\CommonController@getSymtomData');
		
		/** Static pages **/
		Route::post('/getStaticPage', 'API23MAR2023\CommonController@getStaticPage');

		/** Health Tracker **/
		Route::post('/updateSteps', 'API23MAR2023\CommonController@updateSteps');
		Route::post('/getTotalSteps', 'API23MAR2023\CommonController@getTotalSteps');
		Route::post('/updateMedicineDetails', 'API23MAR2023\CommonController@updateMedicineDetails');
		Route::post('/getMedicineReminderList', 'API23MAR2023\CommonController@getMedicineReminderList');
		Route::post('/deleteMedicineReminder', 'API23MAR2023\CommonController@deleteMedicineReminder');
		Route::post('/getMedicineListPdf', 'API23MAR2023\CommonController@getMedicineListPdf');

		/*Bp record*/
		Route::post('/updateBpRecordDetails', 'API23MAR2023\CommonController@updateBpRecordDetails');
		Route::post('/bpRecordList', 'API23MAR2023\CommonController@bpRecordList');
		Route::post('/deleteBpRecord', 'API23MAR2023\CommonController@deleteBpRecord');
		Route::post('/getBpListPdf', 'API23MAR2023\CommonController@getBpListPdf');
		/*diabetesRecordList*/
		Route::post('/updateDiabetesRecordDetails', 'API23MAR2023\CommonController@updateDiabetesRecordDetails');
		Route::post('/diabetesRecordList', 'API23MAR2023\CommonController@diabetesRecordList');
		Route::post('/deleteDiabetesRecord', 'API23MAR2023\CommonController@deleteDiabetesRecord');
		Route::post('/getDiaListPdf', 'API23MAR2023\CommonController@getDiabetesListPdf');
		/*weightRecordList*/
		Route::post('/updateWeightDetails', 'API23MAR2023\CommonController@updateWeightDetails');
		Route::post('/weightList', 'API23MAR2023\CommonController@weightList');
		Route::post('/deleteWeightRecord', 'API23MAR2023\CommonController@deleteWeightRecord');
		Route::post('/getweightListPdf', 'API23MAR2023\CommonController@getweightListPdf');
		/*temptRecordList*/
		Route::post('/updateTempDetails', 'API23MAR2023\CommonController@updateTempDetails');
		Route::post('/tempList', 'API23MAR2023\CommonController@tempList');
		Route::post('/deleteTempRecord', 'API23MAR2023\CommonController@deleteTempRecord');
		Route::post('/gettempListPdf', 'API23MAR2023\CommonController@gettempListPdf');
		/*search reslut API23MAR2023's*/
		Route::post('/saveSearchResults', 'API23MAR2023\CommonController@saveSearchResults');
		Route::post('/usersBuymedicineHits', 'API23MAR2023\CommonController@usersBuymedicineHits');
		Route::post('/usersAdsHits', 'API23MAR2023\CommonController@usersAdsHits');
		/** getOfferBanners **/
		Route::post('/getOfferBanners', 'API23MAR2023\CommonController@getOfferBanners');
		Route::post('/getOfferBannersNew', 'API23MAR2023\CommonController@getOfferBannersNew');
		Route::post('/getAds', 'API23MAR2023\CommonController@getAds');
		/* Locality */
		Route::post('/getLocalitiesByCity', 'API23MAR2023\CommonController@getLocalitiesByCity');
		Route::post('/getLocalitiesbySearch', 'API23MAR2023\CommonController@getLocalitiesbySearch');
		Route::post('/getcityIdByLocality', 'API23MAR2023\CommonController@getcityIdByLocality');
		Route::post('/support', 'API23MAR2023\CommonController@support');

		/* Organizations */
		Route::post('/appointmentCheckoutDetails', 'API23MAR2023\CommonController@appointmentCheckoutDetails');

		/* Organizations */
		Route::post('/getOrganizations', 'API23MAR2023\CommonController@getOrganizations');
		Route::post('/getBlogCount', 'API23MAR2023\CommonController@getBlogCount');

		/* Lab API23MAR2023s */
		Route::post('/getthyrocareData', 'API23MAR2023\LabController@getthyrocareData');
		/* Thyrocare Package Group*/
		
		Route::post('/getLaborderAddresses', 'API23MAR2023\LabController@getLaborderAddresses');
		Route::post('/deleteLaborderAddress', 'API23MAR2023\LabController@deleteLaborderAddress');


			// Route::match(['get', 'post'],'/storeMessage', 'API23MAR2023\HomeController@storeMessage');

			Route::match(['get', 'post'] , '/receiveMessage', 'API23MAR2023\HomeController@receiveMessage');
			Route::match(['get', 'post'] , '/sendMessage', 'API23MAR2023\HomeController@sendMessage');
			Route::match(['get', 'post'] , '/generateResponse', 'API23MAR2023\HomeController@generateResponse');
		

			//  Route::match(['get', 'post'],'/covid-guide','HomeController@covidGuide')->name('covidGuide');

		/*  Lab API23MAR2023s */
		Route::post('/checkCouponCode', 'API23MAR2023\LabController@checkCouponCode');
		Route::post('/getUniqueOrderId', 'API23MAR2023\LabController@getUniqueOrderId');
		Route::post('/createLabOrder', 'API23MAR2023\LabController@createLabOrder');
		Route::post('/cancelLabOrder', 'API23MAR2023\LabController@cancelLabOrder');
		Route::post('/createLabOrderOnline', 'API23MAR2023\LabController@createLabOrderOnline');
		Route::post('/getMyLabOrderData', 'API23MAR2023\LabController@getMyLabOrderData');
		Route::post('/getMyLabReports', 'API23MAR2023\LabController@getMyLabReports');
		Route::post('/getLabCartData', 'API23MAR2023\LabController@getLabCartData');
		Route::post('/addLabCartData', 'API23MAR2023\LabController@addLabCartData');
		Route::post('/deleteLabCartData', 'API23MAR2023\LabController@deleteLabCartData');
		Route::post('/GetAppointmentSlots', 'API23MAR2023\LabController@GetAppointmentSlots');
		Route::post('/PincodeAvailability', 'API23MAR2023\LabController@PincodeAvailability');
		Route::post('/getLabTestSlots', 'API23MAR2023\LabController@getLabTestSlots');
        Route::post('/ViewCart', 'API23MAR2023\LabController@ViewCart');
        Route::post('/getLabByName', 'API23MAR2023\LabController@getLabByName');
        Route::post('/getDefLabByName', 'API23MAR2023\LabController@getDefLabByName');
        Route::post('/getLabsByIds', 'API23MAR2023\LabController@getLabsByIds');
		Route::post('/getLabPackage', 'API23MAR2023\LabController@getLabPackage');
		Route::post('/getLabCompanies', 'API23MAR2023\LabController@getLabCompanies');

		Route::post('/createCustomLabOrder', 'API23MAR2023\LabController@createCustomLabOrder');
		Route::post('/createCustomLabOrderOnline', 'API23MAR2023\LabController@createCustomLabOrderOnline');
		Route::post('/labRequestViaPrescription', 'API23MAR2023\LabController@labRequestViaPrescription');
		Route::post('/checkLabPinCode', 'API23MAR2023\LabController@checkLabPinCode');
		Route::post('/getLabPackageById', 'API23MAR2023\LabController@getLabPackageById');
		
		/*  Subscription API23MAR2023s */
		Route::post('/offer-plans', 'API23MAR2023\SubscriptionController@getOffersPlans');
		Route::post('/getSubscriptionPlans', 'API23MAR2023\SubscriptionController@getSubscriptionPlans');
		Route::post('/getPlanDetails', 'API23MAR2023\SubscriptionController@getPlanDetails');
		Route::post('/getMySubscription', 'API23MAR2023\SubscriptionController@getMySubscription');
		Route::post('/checkMySubscription', 'API23MAR2023\SubscriptionController@checkMySubscription');
		Route::post('/checkRefCode', 'API23MAR2023\SubscriptionController@checkRefCode');  
        Route::post('/checkFcmToken', 'API23MAR2023\CommonController@checkFcmToken'); 		
        Route::post('/updateFcmToken', 'API23MAR2023\CommonController@updateFcmToken'); 		
        Route::post('/updateUserNotifyStatus', 'API23MAR2023\CommonController@updateUserNotifyStatus'); 		
        Route::post('/get-ques-by-type', 'API23MAR2023\CommonController@getQuesByType');
		Route::post('/getReferCodeLists', 'API23MAR2023\CommonController@getReferCodeLists');
		Route::post('/wallet-details', 'API23MAR2023\CommonController@getWalletDetails');
		Route::post('/apply-wallet-amt', 'API23MAR2023\CommonController@applyWalletAmt');
		Route::post('/update-appt-fedd-status', 'API23MAR2023\CommonController@updateAppFeedStatus');
		/******Medicine API23MAR2023S******/
		Route::post('/delete-prescription-image', 'API23MAR2023\MedicineController@deletePrescriptionImage');
		Route::post('/crt-med-order', 'API23MAR2023\MedicineController@createMedicineOrder');
		Route::post('/get-pres-image', 'API23MAR2023\MedicineController@getMedPrescription');
		Route::post('/get-med-order', 'API23MAR2023\MedicineController@getMedOrder');
		Route::post('/view-invoice', 'API23MAR2023\MedicineController@viewInvoice');
		Route::post('/updateMedCart', 'API23MAR2023\MedicineController@updateMedCart');
		Route::post('/getMedCart', 'API23MAR2023\MedicineController@getMedCart');
		Route::post('/deleteMedCart', 'API23MAR2023\MedicineController@deleteMedCart');
		Route::post('/updateMedQty', 'API23MAR2023\MedicineController@updateMedQty');
		Route::post('/checkMedCouponCode', 'API23MAR2023\MedicineController@checkMedCouponCode');
		Route::post('/searchMedicine', 'API23MAR2023\MedicineController@searchMedicine');
		Route::post('/vieworderPres', 'API23MAR2023\MedicineController@vieworderPres');
		Route::post('/cancel-med-order', 'API23MAR2023\MedicineController@cancelOrder');


		// Route::post('/send-video-notification', 'API23MAR2023\HomeController@sendVideoCallNotification');

    });
});