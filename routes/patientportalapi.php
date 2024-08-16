<?php
use Illuminate\Http\Request;


Route::any('/upload-prescription-image', 'API23MAR2023\MedicineController@uploadPrescriptionImage');
Route::any('/notifyDoctorForVcall', 'API23MAR2023\HomeController@notifyDoctorForVcall');
Route::any('/checkVersionOfApp', 'API23MAR2023\HomeController@checkVersionOfApp');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test/', function () {
	return "I am Meraj Ahamad testing ";
});

Route::group([],function () {
    Route::get('/getListItemGanga','API\HomeController@getListItemGanga');
    Route::post('/login','API23MAR2023\UserController@login');
	Route::post('/resendOtp','API23MAR2023\UserController@resendOtp');
	Route::post('/otpVerified', 'API23MAR2023\UserController@otpVerified');
	Route::post('/otpVerifiedNew', 'API23MAR2023\UserController@otpVerifiedNew');
	Route::post('/forgot-password', 'API23MAR2023\UserController@forgot');
	Route::match(['get', 'post'],'/thyrocarelogin', 'API23MAR2023\LabController@thyrocarelogin')->name('thyrocarelogin');
	Route::match(['get', 'post'],'/getPatientPortalSliders', 'API23MAR2023\HomeController@getPatientPortalSliders');
	Route::match(['get', 'post'],'/appointmentCheckout', 'API23MAR2023\HomeController@appointmentCheckout')->name('appointmentCheckout');
	Route::match(['get', 'post'],'/getPatientOpd', 'API23MAR2023\PatientEhrController@getPatientOpd');
	Route::match(['get', 'post'],'/subscriptionPay', 'API23MAR2023\SubscriptionController@subscriptionPay');
	Route::match(['get', 'post'],'/labCheckout', 'API23MAR2023\LabController@labCheckout')->name('labCheckout');
	Route::match(['get', 'post'],'/getThyrocarePackageGroup', 'API23MAR2023\LabController@getThyrocarePackageGroup')->name('getThyrocarePackageGroup');
	Route::match(['get', 'post'],'/createLaborderAddresses', 'API23MAR2023\LabController@createLaborderAddresses')->name('createLaborderAddresses');
	Route::match(['get', 'post'],'/getMyLabOrders', 'API23MAR2023\LabController@getMyLabOrders')->name('getMyLabOrders');
    Route::group([
      // 'middleware' => 'auth:api'
    ], function() {
		Route::post('details', 'API23MAR2023\UserController@details');
		/********* Patient Portal API23MAR2023 ***********/
		Route::match(['get', 'post'],'/download-subscription-receipt', 'API23MAR2023\SubscriptionController@downloadSubscriptionReceipt');
		Route::any('/saveuserlocation', 'API23MAR2023\UserController@saveUserLocation');
		Route::any('/checkFirstDirectTeleAppointment', 'API23MAR2023\HomeController@checkFirstDirectTeleAppointment');
		Route::any('/checkFirstTeleAppointment', 'API23MAR2023\HomeController@checkFirstTeleAppointment');
		Route::post('/logoutUser','API23MAR2023\UserController@logoutUser');
		Route::post('/updateFcmToken','API23MAR2023\UserController@updateFcmToken');
		Route::post('/addUser','API23MAR2023\UserController@addUser');
		Route::post('/change-password', 'API23MAR2023\UserController@ChangePassword');
		Route::match(['get', 'post'],'/getOnCallDoctors', 'API23MAR2023\HomeController@getOnCallDoctors');
		Route::match(['get', 'post'],'/getOnCallDoctorsDemo', 'API23MAR2023\HomeController@getOnCallDoctorsDemo');
		Route::match(['get', 'post'],'/getCountryPhoneCode', 'API23MAR2023\HomeController@getCountryPhoneCode');
		Route::match(['get', 'post'],'/getNewsFeedsData', 'API23MAR2023\HomeController@getNewsFeedsData');
		Route::match(['get', 'post'],'/searchDoctors', 'API23MAR2023\HomeController@searchDoctors');
		Route::match(['get', 'post'],'/getDocSpeciality', 'API23MAR2023\HomeController@getDocSpeciality');
		Route::match(['get', 'post'],'/getDocByPractice', 'API23MAR2023\HomeController@getDocByPractice');
		Route::match(['get', 'post'],'/getCountry', 'API23MAR2023\HomeController@getCountry');
		Route::match(['get', 'post'],'/getState', 'API23MAR2023\HomeController@getState');
		Route::match(['get', 'post'],'/getCity', 'API23MAR2023\HomeController@getCity');
		Route::match(['get', 'post'],'/getMyProfile', 'API23MAR2023\HomeController@getMyProfile');
		Route::match(['get', 'post'],'/updateMyProfile', 'API23MAR2023\HomeController@updateMyProfile');
		Route::match(['get', 'post'],'/getUserImage', 'API23MAR2023\HomeController@getUserImage');
		Route::match(['get', 'post'],'/searchDoctorsByAddress', 'API23MAR2023\HomeController@searchDoctorsByAddress');
		Route::match(['get', 'post'],'/addAppointment', 'API23MAR2023\HomeController@addAppointment');
		Route::match(['get', 'post'],'/addAppointmentDemo', 'API23MAR2023\HomeController@addAppointmentDemo');
		Route::match(['get', 'post'],'/searchDoctorsByFilters', 'API23MAR2023\HomeController@searchDoctorsByFilters');
		Route::match(['get', 'post'],'/getDoctorCounsultMaxFees', 'API23MAR2023\HomeController@getDoctorCounsultMaxFees');
		Route::match(['get', 'post'],'/getDoctorSlotsByDay', 'API23MAR2023\HomeController@getDoctorSlotsByDay');
		Route::match(['get', 'post'],'/getDocById', 'API23MAR2023\HomeController@getDocById');
		Route::match(['get', 'post'],'/getDocDetailById', 'API23MAR2023\HomeController@getDocDetailById');
		Route::match(['get', 'post'],'/cancelAppointment', 'API23MAR2023\HomeController@cancelAppointment');
		Route::match(['get', 'post'],'/updateSchedule', 'API23MAR2023\HomeController@updateSchedule');
		Route::match(['get', 'post'],'/checkAppointmentStatus', 'API23MAR2023\HomeController@checkAppointmentStatus');
		Route::match(['get', 'post'],'/staticPages', 'API23MAR2023\HomeController@staticPages')->name('staticPages');
		Route::match(['get', 'post'],'/move-on-1mg', 'API23MAR2023\HomeController@moveTo1MgSite')->name('moveTo1MgSite');
		Route::match(['get', 'post'],'/getSponseredDoc', 'API23MAR2023\HomeController@getSponseredDoc');
		Route::match(['get', 'post'],'/getHospitalInfoById', 'API23MAR2023\HomeController@getHospitalInfoById')->name('getHospitalInfoById');
		Route::match(['get', 'post'],'/makeFollowUpAppt', 'API23MAR2023\HomeController@makeFollowUpAppt')->name('makeFollowUpAppt');

		Route::match(['get', 'post'],'/getDoctorSlots', 'API23MAR2023\HomeController@getDoctorSlots');
		Route::match(['get', 'post'],'/getDocBySpeciality', 'API23MAR2023\HomeController@getDocBySpeciality');
		Route::match(['get', 'post'],'/getPatients', 'API23MAR2023\CommonController@getPatients');
		Route::match(['get', 'post'],'/getComplimentsData', 'API23MAR2023\CommonController@getComplimentsData');
		Route::match(['get', 'post'],'/getWaitingTimeData', 'API23MAR2023\CommonController@getWaitingTimeData');

		Route::match(['get', 'post'],'/getFoodPreferenceMaster', 'API23MAR2023\CommonController@getFoodPreferenceMaster');
		Route::match(['get', 'post'],'/getSmokingHabitsMaster', 'API23MAR2023\CommonController@getSmokingHabitsMaster');
		Route::match(['get', 'post'],'/getOccupationMaster', 'API23MAR2023\CommonController@getOccupationMaster');
		Route::match(['get', 'post'],'/getAlcoholConsumptionMaster', 'API23MAR2023\CommonController@getAlcoholConsumptionMaster');
		Route::match(['get', 'post'],'/getActivityLevelMaster', 'API23MAR2023\CommonController@getActivityLevelMaster');
		Route::match(['get', 'post'],'/getTopSpecialities', 'API23MAR2023\CommonController@getTopSpecialities');
		Route::match(['get', 'post'],'/getReferLinkMsg', 'API23MAR2023\CommonController@getReferLinkMsg');
		Route::match(['get', 'post'],'/getCouponCodeLists', 'API23MAR2023\CommonController@getCouponCodeLists');

		Route::match(['get', 'post'],'/getPatientPrescriptionData', 'API23MAR2023\PatientEhrController@getPatientPrescriptionData');
		Route::match(['get', 'post'],'/getPatientPrescription', 'API23MAR2023\PatientEhrController@getPatientPrescription');
		Route::match(['get', 'post'],'/getPatientOpdNew', 'API23MAR2023\PatientEhrController@getPatientOpdNew');
		Route::match(['get', 'post'],'/getClinicalNoteByApp', 'API23MAR2023\PatientEhrController@getClinicalNoteByApp');
		Route::match(['get', 'post'],'/downloadReceipt', 'API23MAR2023\PatientEhrController@downloadReceipt');
		Route::match(['get', 'post'],'/uploadDocument', 'API23MAR2023\PatientEhrController@uploadDocument');
		Route::match(['get', 'post'],'/getUserDocument', 'API23MAR2023\PatientEhrController@getUserDocument');
		Route::match(['get', 'post'],'/deletePrescription', 'API23MAR2023\PatientEhrController@deletePrescription');
		Route::match(['get', 'post'],'/deleteDocument', 'API23MAR2023\PatientEhrController@deleteDocument');
		Route::match(['get', 'post'],'/feedback', 'API23MAR2023\PatientEhrController@feedback');
		Route::match(['get', 'post'],'/latestappointmentfeedback', 'API23MAR2023\PatientEhrController@latestappointmentfeedback');
		Route::match(['get', 'post'],'/checkAppointmentCouponCode', 'API23MAR2023\PatientEhrController@checkAppointmentCouponCode');
		Route::post('/getCashcack', 'API23MAR2023\CommonController@getCashcack');
		Route::post('/get-rewards', 'API23MAR2023\CommonController@getRewards');
		Route::post('/send-invite-sms', 'API23MAR2023\CommonController@sendInviteSms');
		Route::post('/get-ref-page-data', 'API23MAR2023\CommonController@getRefPageData');
		Route::post('/put-ref-code', 'API23MAR2023\CommonController@registerReferred');
		
		/** Static pages **/
		Route::match(['get', 'post'],'/getStaticPage', 'API23MAR2023\CommonController@getStaticPage');

		/** Health Tracker **/
		Route::match(['get', 'post'],'/updateSteps', 'API23MAR2023\CommonController@updateSteps');
		Route::match(['get', 'post'],'/getTotalSteps', 'API23MAR2023\CommonController@getTotalSteps');
		Route::match(['get', 'post'],'/updateMedicineDetails', 'API23MAR2023\CommonController@updateMedicineDetails');
		Route::match(['get', 'post'],'/getMedicineReminderList', 'API23MAR2023\CommonController@getMedicineReminderList');
		Route::match(['get', 'post'],'/deleteMedicineReminder', 'API23MAR2023\CommonController@deleteMedicineReminder');
		Route::match(['get', 'post'],'/getMedicineListPdf', 'API23MAR2023\CommonController@getMedicineListPdf');

		/*Bp record*/
		Route::match(['get', 'post'],'/updateBpRecordDetails', 'API23MAR2023\CommonController@updateBpRecordDetails');
		Route::match(['get', 'post'],'/bpRecordList', 'API23MAR2023\CommonController@bpRecordList');
		Route::match(['get', 'post'],'/deleteBpRecord', 'API23MAR2023\CommonController@deleteBpRecord');
		Route::match(['get', 'post'],'/getBpListPdf', 'API23MAR2023\CommonController@getBpListPdf');
		/*diabetesRecordList*/
		Route::match(['get', 'post'],'/updateDiabetesRecordDetails', 'API23MAR2023\CommonController@updateDiabetesRecordDetails');
		Route::match(['get', 'post'],'/diabetesRecordList', 'API23MAR2023\CommonController@diabetesRecordList');
		Route::match(['get', 'post'],'/deleteDiabetesRecord', 'API23MAR2023\CommonController@deleteDiabetesRecord');
		Route::match(['get', 'post'],'/getDiaListPdf', 'API23MAR2023\CommonController@getDiabetesListPdf');
		/*weightRecordList*/
		Route::match(['get', 'post'],'/updateWeightDetails', 'API23MAR2023\CommonController@updateWeightDetails');
		Route::match(['get', 'post'],'/weightList', 'API23MAR2023\CommonController@weightList');
		Route::match(['get', 'post'],'/deleteWeightRecord', 'API23MAR2023\CommonController@deleteWeightRecord');
		Route::match(['get', 'post'],'/getweightListPdf', 'API23MAR2023\CommonController@getweightListPdf');
		/*temptRecordList*/
		Route::match(['get', 'post'],'/updateTempDetails', 'API23MAR2023\CommonController@updateTempDetails');
		Route::match(['get', 'post'],'/tempList', 'API23MAR2023\CommonController@tempList');
		Route::match(['get', 'post'],'/deleteTempRecord', 'API23MAR2023\CommonController@deleteTempRecord');
		Route::match(['get', 'post'],'/gettempListPdf', 'API23MAR2023\CommonController@gettempListPdf');
		/*search reslut API23MAR2023's*/
		Route::match(['get', 'post'],'/saveSearchResults', 'API23MAR2023\CommonController@saveSearchResults');
		Route::match(['get', 'post'],'/usersBuymedicineHits', 'API23MAR2023\CommonController@usersBuymedicineHits');
		Route::match(['post'],'/usersAdsHits', 'API23MAR2023\CommonController@usersAdsHits');
		/** getOfferBanners **/
		Route::match(['get', 'post'],'/getOfferBanners', 'API23MAR2023\CommonController@getOfferBanners');
		Route::match(['get', 'post'],'/getOfferBannersNew', 'API23MAR2023\CommonController@getOfferBannersNew');
		Route::match(['post'],'/getAds', 'API23MAR2023\CommonController@getAds');
		/* Locality */
		Route::match(['get', 'post'],'/getLocalitiesByCity', 'API23MAR2023\CommonController@getLocalitiesByCity');
		Route::match(['get', 'post'],'/getLocalitiesbySearch', 'API23MAR2023\CommonController@getLocalitiesbySearch');
		Route::match(['get', 'post'],'/getcityIdByLocality', 'API23MAR2023\CommonController@getcityIdByLocality');
		Route::match(['get', 'post'],'/support', 'API23MAR2023\CommonController@support')->name('support');

		/* Organizations */
		Route::match(['get', 'post'],'/appointmentCheckoutDetails', 'API23MAR2023\CommonController@appointmentCheckoutDetails');

		/* Organizations */
		Route::match(['get', 'post'],'/getOrganizations', 'API23MAR2023\CommonController@getOrganizations')->name('getOrganizations');
		Route::match(['get', 'post'],'/getBlogCount', 'API23MAR2023\CommonController@getBlogCount');

		/* Lab API23MAR2023s */
		Route::match(['get', 'post'],'/getthyrocareData', 'API23MAR2023\LabController@getthyrocareData')->name('getthyrocareData');
		/* Thyrocare Package Group*/
		
		Route::match(['get', 'post'],'/getLaborderAddresses', 'API23MAR2023\LabController@getLaborderAddresses')->name('getLaborderAddresses');
		Route::match(['get', 'post'],'/deleteLaborderAddress', 'API23MAR2023\LabController@deleteLaborderAddress')->name('deleteLaborderAddress');

		/*  Lab API23MAR2023s */
		Route::match(['get', 'post'],'/checkCouponCode', 'API23MAR2023\LabController@checkCouponCode')->name('checkCouponCode');
		Route::match(['get', 'post'],'/getUniqueOrderId', 'API23MAR2023\LabController@getUniqueOrderId')->name('getUniqueOrderId');
		Route::match(['get', 'post'],'/createLabOrder', 'API23MAR2023\LabController@createLabOrder')->name('createLabOrder');
		Route::match(['get', 'post'],'/cancelLabOrder', 'API23MAR2023\LabController@cancelLabOrder')->name('cancelLabOrder');
		Route::match(['get', 'post'],'/createLabOrderOnline', 'API23MAR2023\LabController@createLabOrderOnline')->name('createLabOrderOnline');
		Route::match(['get', 'post'],'/getMyLabOrderData', 'API23MAR2023\LabController@getMyLabOrderData')->name('getMyLabOrderData');
		Route::match(['get', 'post'],'/getMyLabReports', 'API23MAR2023\LabController@getMyLabReports')->name('getMyLabReports');
		Route::match(['get', 'post'],'/getLabCartData', 'API23MAR2023\LabController@getLabCartData');
		Route::match(['get', 'post'],'/addLabCartData', 'API23MAR2023\LabController@addLabCartData');
		Route::match(['get', 'post'],'/deleteLabCartData', 'API23MAR2023\LabController@deleteLabCartData');
		Route::match(['get', 'post'],'/GetAppointmentSlots', 'API23MAR2023\LabController@GetAppointmentSlots');
		Route::match(['get', 'post'],'/PincodeAvailability', 'API23MAR2023\LabController@PincodeAvailability');
		Route::match(['get', 'post'],'/getLabTestSlots', 'API23MAR2023\LabController@getLabTestSlots');
        Route::match(['post'],'/ViewCart', 'API23MAR2023\LabController@ViewCart');
        Route::match(['post'],'/getLabByName', 'API23MAR2023\LabController@getLabByName');
        Route::match(['post'],'/getDefLabByName', 'API23MAR2023\LabController@getDefLabByName');
        Route::match(['post'],'/getLabsByIds', 'API23MAR2023\LabController@getLabsByIds');
		Route::match(['get', 'post'],'/getLabPackage', 'API23MAR2023\LabController@getLabPackage');
		Route::match(['get', 'post'],'/getLabCompanies', 'API23MAR2023\LabController@getLabCompanies');


		Route::match(['get', 'post'],'/createCustomLabOrder', 'API23MAR2023\LabController@createCustomLabOrder')->name('createCustomLabOrder');
		Route::match(['get', 'post'],'/createCustomLabOrderOnline', 'API23MAR2023\LabController@createCustomLabOrderOnline')->name('createCustomLabOrderOnline');
		Route::match(['post'],'/labRequestViaPrescription', 'API23MAR2023\LabController@labRequestViaPrescription');
		Route::match(['post'],'/checkLabPinCode', 'API23MAR2023\LabController@checkLabPinCode');
		Route::match(['post'],'/getLabPackageById', 'API23MAR2023\LabController@getLabPackageById');
		
		/*  Subscription API23MAR2023s */
		Route::match(['get', 'post'],'/offer-plans', 'API23MAR2023\SubscriptionController@getOffersPlans');
		Route::match(['get', 'post'],'/getSubscriptionPlans', 'API23MAR2023\SubscriptionController@getSubscriptionPlans');
		Route::match(['get', 'post'],'/getMySubscription', 'API23MAR2023\SubscriptionController@getMySubscription');
		Route::match(['get', 'post'],'/checkMySubscription', 'API23MAR2023\SubscriptionController@checkMySubscription');
		Route::match(['get', 'post'],'/checkRefCode', 'API23MAR2023\SubscriptionController@checkRefCode');  
        Route::match(['post'],'/checkFcmToken', 'API23MAR2023\CommonController@checkFcmToken'); 		
        Route::match(['post'],'/updateFcmToken', 'API23MAR2023\CommonController@updateFcmToken'); 		
        Route::match(['post'],'/updateUserNotifyStatus', 'API23MAR2023\CommonController@updateUserNotifyStatus'); 		
        Route::match(['post'],'/get-ques-by-type', 'API23MAR2023\CommonController@getQuesByType');
		Route::match(['get', 'post'],'/getReferCodeLists', 'API23MAR2023\CommonController@getReferCodeLists');
		Route::match(['get', 'post'],'/wallet-details', 'API23MAR2023\CommonController@getWalletDetails');
		Route::match(['get', 'post'],'/apply-wallet-amt', 'API23MAR2023\CommonController@applyWalletAmt');
		/******Medicine API23MAR2023S******/
		Route::match(['post'],'/delete-prescription-image', 'API23MAR2023\MedicineController@deletePrescriptionImage');
		Route::match(['post'],'/crt-med-order', 'API23MAR2023\MedicineController@createMedicineOrder');
		Route::match(['post'],'/get-pres-image', 'API23MAR2023\MedicineController@getMedPrescription');
		Route::match(['post'],'/get-med-order', 'API23MAR2023\MedicineController@getMedOrder');
		Route::match(['post'],'/view-invoice', 'API23MAR2023\MedicineController@viewInvoice');
		Route::match(['get', 'post'],'/updateMedCart', 'API23MAR2023\MedicineController@updateMedCart');
		Route::match(['get', 'post'],'/getMedCart', 'API23MAR2023\MedicineController@getMedCart');
		Route::match(['get', 'post'],'/deleteMedCart', 'API23MAR2023\MedicineController@deleteMedCart');
		Route::match(['get','post'],'/updateMedQty', 'API23MAR2023\MedicineController@updateMedQty');
		Route::match(['get','post'],'/checkMedCouponCode', 'API23MAR2023\MedicineController@checkMedCouponCode');
		Route::match(['get', 'post'],'/searchMedicine', 'API23MAR2023\MedicineController@searchMedicine');
		Route::match(['get', 'post'],'/vieworderPres', 'API23MAR2023\MedicineController@vieworderPres');
		Route::match(['get', 'post'],'/cancel-med-order', 'API23MAR2023\MedicineController@cancelOrder');
    });
});