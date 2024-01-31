<?php
/*

  |--------------------------------------------------------------------------

  | Application Routes


  |--------------------------------------------------------------------------

  |

  | Here is where you can register all of the routes for an application.

  | It's a breeze. Simply tell Laravel the URIs it should respond to

  | and give it the controller to call when that URI is requested.

  |

 */

header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
 




Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::group(['middleware' => 'web', 'prefix' => 'backend', 'namespace' => 'Backend'], function ()
{
    Route::get('/', function () {
        return redirect( 'backend/login' );
     });
    Route::match(['GET', 'POST'], 'login', 'Auth\AuthController@adminLogin')->name('login');

    Route::match(['GET', 'POST'], 'reset-password/{token?}', 'Auth\PasswordController@resetPasswordAction');

    Route::post('reset-password-finally', 'Auth\PasswordController@reset');    
	


		    ###Reset Password###
    Route::post('/password/email', 'Auth\PasswordController@send_reset_link_email')->name('password.email');
    Route::post('/password/reset', 'Auth\PasswordController@reset_password_update')->name('reset.password.update');
    Route::get('/password/reset', 'Auth\PasswordController@showLinkRequestForm')->name('password.request');
    Route::get('/password/reset/{email}/{token}/{role_id}', 'Auth\PasswordController@reset_password_from_show')->name('password.reset');
	
	    Route::post('google/auth','Auth\AuthController@postgoogleAuth');//->middleware('audit:POST');
    Route::get('google-auth','Auth\AuthController@getgoogleAuth');
    Route::post('verify/code','Auth\AuthController@postverifycode');//->middleware('audit:POST');
    Route::get('verify-code','Auth\AuthController@getverifycode');
    Route::post('type/auth','Auth\AuthController@posttypeauth');
    Route::get( 'type-auth','Auth\AuthController@getType');

    Route::group(['middleware' => ['admin']], function () {

       #routific Routes
       Route::get('montreal/routes', 'RoutificController@montrealRoutificControls');
       Route::post('montreal/routes/add', 'RoutificController@montrealRoutificCreate');
	   Route::post('test/montreal/routes/add', 'RoutificController@montrealcreate');
       Route::get('route/montreal/deleted', 'RoutificController@routeMontrealDeleted');
       Route::get('route/montreal/{id}/assign','RoutificController@assignMontrealRoute');
       Route::get('ottawa/routes', 'RoutificController@ottawaRoutificControls');
       Route::post('ottawa/routes/add', 'RoutificController@ottawaRoutificCreate');
       Route::get('route/ottawa/deleted', 'RoutificController@routeOttawaDeleted');
        Route::get('route/ottawa/{id}/assign','RoutificController@assignOttawaRoute');
       Route::get('ctc/routes', 'RoutificController@ctcRoutificControls');
       Route::post('ctc/routes/add', 'RoutificController@ctcRoutificCreate');
       Route::get('route/ctc/deleted', 'RoutificController@routectcdeleted');
        Route::get('route/ctc/{id}/assign','RoutificController@assignCtcRoute');
       Route::get('route/{di}/edit/hub/{id}', 'RoutificController@hubRouteEdit');
       Route::post('route/transfer/hub', 'RoutificController@RouteTransfer');
       Route::post('route/locations/transfer', 'RoutificController@routelocTransfer');

       // Vancouver Routing
       Route::get('vancouver/routes', 'RoutificController@vancouverRoutificControls');
       Route::post('vancouver/routes/add', 'RoutificController@vancouverRoutificCreate');

        //Scarborough
        Route::get('scarborough/routes', 'RoutificController@scarboroughRoutificControls');
        Route::post('scarborough/routes/add', 'RoutificController@scarboroughRoutificCreate');
        Route::get('route/scarborough/deleted', 'RoutificController@routescarboroughdeleted');
        Route::get('scarborough/failed/orders', 'ScarboroughFailedOrderController@getAllBorderlessFailedOrder')->name('scarborough-failed-order.get');
        Route::post('scarborough/failed/orders', 'ScarboroughFailedOrderController@createBorderlessOrder')->name('scarborough-failed-order.post');
        Route::post('scarborough/create/all/order', 'ScarboroughFailedOrderController@createAllBorderlessOrder')->name('scarborough-create-all-order.post');
        Route::post('scarborough/task','ScarboroughFailedOrderController@createBorderlessTask')->name('scarborough-create-task');

       Route::get('flower/routes', 'RoutificController@flowerRoutificControls');
       Route::get('route/flower/{id}/assign','RoutificController@assignFflowerRoute');
	   ### hub Stores work 2022-04-01 ###
		// get all hubs with zones
		Route::get('hub/list/zones', 'HubStoresController@index')->name('hub.list.zones');
		// calculate hub and vendor distance route
		Route::get('hub/zone/vendor/{id}', 'HubStoresController@createHubAndVendorDistance')->name('hub.zone.vendor');
		// create hub stores
		Route::get('hub_stores/{id}', 'HubStoresController@hubStores')->name('hub.stores');
		// store hub stores
		Route::post('hub_stores/store', 'HubStoresController@hubStoresCreate')->name('hub.stores.post');
        // attach zones
        Route::get('attach/zones/{id}', 'HubStoresController@attachZones')->name('attach.zones');
        // update attach zones
        Route::post('attach/zones', 'HubStoresController@attachZonesUpdate')->name('attach.zones.update');
		### hub Stores work 2022-04-01 ###
	   
	   Route::get('ottawa/routes/test', 'RoutificController@getOttawaRoutific')->name('ottawa.index');
        Route::get('ottawa/test/routes-data', 'RoutificController@ottawaRoutificControlsData')->name('ottawa-routing.data');

Route::get('montreal/routes/test', 'RoutificController@montrealRoutificControls1');
        Route::get('montreal/routes/data', 'RoutificController@data')->name('montreal-routing.data');
		

      Route::get('create/{id}/route', 'RoutificController@createCustomRouteApi');
	  Route::get('createCustom/{id}/route', 'RoutificController@createCustomRouteApi');
      Route::get('routific/{id}/job', 'RoutificController@getroutificjob');
      Route::post('routific/job/delete','RoutificController@droutificjob');
      Route::get('routific/outfordelivery', 'RoutificController@getoutfordeliveryindex');
      Route::post('routific/outfordelivery/status','RoutificController@postoutfordeliverystatus');
      Route::get('route/{id}/map','RoutificController@RouteMap');
      Route::get('route/{id}/remaining','RoutificController@remainigrouteMap');
      Route::get('allroute/{id}/location/joey','RoutificController@getLocationMap');
      Route::post('route/map/location','RoutificController@getRouteMapLocation');
      Route::get('route/{id}/details','RoutificController@routeDetails');
      Route::get('hub/{hubId}/re-route/{id}','RoutificController@reRoute');
      Route::get('route/{id}/delete/hub','RoutificController@deleteRoute');


      Route::get('searchorder/trackingid', 'SearchOrdersController@get_trackingid');
      Route::get('search/orders/trackingid/{id}/details','SearchOrdersController@get_trackingorderdetails');
      Route::post('update/order/status','SearchOrdersController@updatestatus');

      #slotsRoutes
      Route::get('zone/{id}/slots', 'SlotsController@zoneSlots');
      Route::get('slots/list/{id}', 'SlotsController@slotsdata');
      Route::post('slots/create', 'SlotsController@create');
      Route::post('slots/update', 'SlotsController@post_update');
      Route::get('slots/{id}/update', 'SlotsController@get_update');
      Route::get('slots/{id}/delete', 'SlotsController@get_delete');
      Route::post('slots/deleteslot', 'SlotsController@post_deleteslot');
      Route::get('slots/{id}/detail', 'SlotsController@get_detail');
      Route::get('slots/list/hubid/{id}/zoneid/{zoneid}', 'SlotsController@slotsdata');
      Route::get('postal-codes/hub/{id}', 'SlotsController@getPostalCodes');

      Route::post('slots/create/data', 'SlotsController@createSlot');

      Route::post('hub/routific/updatestatus','RoutificController@poststatusupdate');
      Route::get('hub/routific/status', 'RoutificController@getstatus');


      // Sorter Assigning
      Route::get('hub/{id}/route/assign', 'RoutificController@getrouteAssign');
      Route::post('hub/route/assign/add','RoutificController@postrouteAssignCreate');
      Route::get('route/{id}/joey','RoutificController@getroutedetail');
      Route::post('joey/route/delete','RoutificController@postjoeyroutedelete');
      Route::get('hub/sorter/{id}/edit','RoutificController@getedit_routes');
      Route::post('hub/delete/sorter','RoutificController@deleteroutes');

        // Get Reports
        Route::get('route-volume-state', 'RouteVolumeStateController@routeVolumeState')->name('route-volume-state');
        Route::get('tracking-report', 'TrackingReportController@getTrackingReport');
		        Route::post('tracking-note','TrackingReportController@saveTrackingReport')->name('tracking-note');
        Route::get('montreal-manifest-report', 'TrackingReportController@getMontrealManifestReport');
        Route::get('montreal-manifest-report/data', 'TrackingReportController@getMontrealManifestData')->name('montreal-manifest-report.data');
        Route::get('ottawa-manifest-report', 'TrackingReportController@getOttawaManifestReport');
        Route::get('ottawa-manifest-report/data', 'TrackingReportController@getOttawaManifestData')->name('ottawa-manifest-report.data');

      //wm route
       Route::get('wm/store', 'WMRoutificController@getStore');
       Route::post('wm/store/delete', 'WMRoutificController@deleteStore');     
       Route::get('wmroutific/{id}/job', 'WMRoutificController@wmCreateRoute');    
       Route::post('wm/routes','WMRoutificController@wmCreateJobId');
      //wm routific job wm/routific/job/delete
      Route::get('routific/wm/jobs', 'WMRoutificController@getWMRoutificJob'); 
      Route::post('wm/routific/job/delete', 'WMRoutificController@deleteWMRoutificJob'); 
      //wm slots
      Route::get('wm/{store}/slots','WMSlotsController@wmSlotsData');
      Route::post('wm/slots/create', 'WMSlotsController@wmSlotCreate');
      Route::post('wm/slots/update', 'WMSlotsController@postUpdate');
      Route::post('wm/slots/deleteslot', 'WMSlotsController@postDeleteslot');
      Route::get('wm/slots/{id}/update', 'WMSlotsController@getUpdate');
      Route::get('wm/slots/{id}/detail', 'WMSlotsController@getDetail');

      Route::get('wm/route/{id}/details','WMRoutificController@routeDetails');
      Route::get('walmart/routes', 'WMRoutificController@wmRoutificControls');

       //wm routific routes
       Route::get('wm/route/{id}/delete','WMRoutificController@wmDeleteRoute');
       Route::post('wm/route/transfer', 'WMRoutificController@wmRouteTransfer');
       Route::post('wm/order/delete', 'WMRoutificController@wmOrderDelete');
       Route::post('wm/route/transfer', 'WMRoutificController@wmRouteTransfer');
       Route::get('wm/route/{di}/edit', 'WMRoutificController@wmRouteEdit');
 
       //wm map routes
       Route::get('wm/allroute/location/joey','WMRoutificController@getWMLocationMap');
       Route::post('wm/route/map/location','WMRoutificController@getWMRouteMapLocation');
       Route::get('wm/route/{id}/map','WMRoutificController@wmRouteMap');
       Route::get('wm/route/{id}/remaining','WMRoutificController@wmremainigrouteMap');

       Route::get('custom/routing', 'CustomRoutingController@getIndex');

        Route::post('custom/routing','CustomRoutingController@postFileRead');

        Route::post('logout', 'Auth\AuthController@logout');
        Route::get('dashboard', 'DashboardController@getIndex');

        #### Needy People ####
        //Admin Edit Route
        Route::get('adminedit/{user}', 'SubadminController@adminedit');

        Route::put('admin/update/{user}', 'SubadminController@adminupdate');
        Route::get('sub/admin', 'ServiceProviderController@getIndex');

        Route::delete('sub/admin/{user}', 'ServiceProviderController@destroy');

        Route::get('sub/admin/edit/{user}', 'ServiceProviderController@edit');

        Route::put('needy/people/{user}', 'ServiceProviderController@update');

        Route::get('sub/admin/add', 'ServiceProviderController@add');

        Route::post('needy/people/create', 'ServiceProviderController@create');

        Route::get('sub/admin/profile/{id}', 'ServiceProviderController@profile');
		        Route::get('sub-admin/active/{record}', 'SubadminController@active')->name('sub-admin.active');
        Route::get('sub-admin/inactive/{record}', 'SubadminController@inactive')->name('sub-admin.inactive');

        ###Sub Admins###
        Route::get('subadmins', 'SubadminController@getIndex');

        Route::get('subadmin/add', 'SubadminController@add');

        Route::post('subadmin/create', 'SubadminController@create');

        Route::get('subadmin/edit/{id}', 'SubadminController@edit');

        Route::get('sub/admin/profile/{id}', 'SubadminController@profile');

        Route::put('subadmin/update/{user}', 'SubadminController@update');

		Route::delete('subadmins/{user}', 'SubadminController@destroy');

        Route::get('subadmin/change/password/{user}','SubadminController@getChangePassword');

        Route::post('subadmin/change/password/{user}','SubadminController@putChangePassword');

        Route::get('search/trackingid/multiple', 'SearchOrdersController@get_multipletrackingid');

        // multi update status
         Route::post('update/multiple/trackingid','SearchOrdersController@post_multiOrderUpdates');
        Route::get('update/multiple/trackingid','SearchOrdersController@get_multiOrderUpdates');
Route::post('sprint/image/upload','SearchOrdersController@sprintImageUpload')->name('sprint-image-upload');
  Route::get('account/security/edit/{user}', 'SubadminController@accountSecurityEdit')->name('account-security.edit');

        Route::put('account/security/{user}', 'SubadminController@accountSecurityUpdate')->name('account-security.update');
		
        #zonesRoutes
        Route::get('zones/list/{id}', 'RoutingZonesController@zonesdata');
        Route::post('zones/create', 'RoutingZonesController@create');
        Route::get('zones/{id}/update', 'RoutingZonesController@get_update');
        Route::post('zones/update', 'RoutingZonesController@post_update');
        Route::get('zones/{id}/detail', 'RoutingZonesController@get_detail');
        Route::post('zones/deletezone', 'RoutingZonesController@post_deletezone');

		//delete custom route
        Route::get('route/delete', 'RoutificController@getdeleteRouteview');
        Route::post('route/delete', 'RoutificController@deleteRouteId');


        // Routing enable for cusotm tracking ids
        Route::get('routing/enable','CustomRoutingController@getIndex');
        Route::post('routing/enable','CustomRoutingController@postFileRead');

        Route::get('custom/routing/{id}/hub', 'CustomRoutingController@getIndex');
        Route::get('tracking/detail','CustomRoutingController@getTrackingIdDetail');
        Route::get('inbound/tracking/detail','InboundScanningController@getTrackingIdDetail');
        Route::post('create/route/custom/routing','CustomRoutingController@postCreateRoute'); 
        Route::post('custom/create/order','CustomRoutingController@postCreateOrder');
        Route::get('custom/routific/{id}/job', 'CustomRoutingController@customJob');
		
		

        ### Manual Status Update ###
        Route::get('manual/status', 'ManualStatusController@getManualStatus')->name('manual-status.index');
        
        ### Manual Route Update ###
        Route::get('manual/route', 'ManualRouteController@getManualRoute')->name('manual-route.index');
        Route::post('update/manual/route', 'ManualRouteController@postUpdateManualRoute');
        Route::post('update/manual/route/view', 'ManualRouteController@postUpdateManualRouteView');
        Route::post('update/manual/route/viewMultiple', 'ManualRouteController@postUpdateManualRouteViewMultiple');
        Route::get('route/trackingid/enable', 'RouteOrdersController@get_multipletrackingid');


        ### Move Route Date ###
        Route::get('move/route', 'MoveRouteController@getMoveRoute')->name('move-route.index');
        Route::post('update/route/date', 'MoveRouteController@postUpdateRouteDate');

        ### Manual Sorted Section ###
        Route::get('manual/sorting/tracking', 'ManualSortedTrackingController@index')->name('manual.sorting.index');
        Route::get('manual/sorting/single_tracking', 'ManualSortedTrackingController@singleMarked')->name('manual.single.tracking.index');
        Route::get('manual/sorting/multiple_tracking', 'ManualSortedTrackingController@multipleMarkedTrackingIds')->name('manual.multiple.tracking.index');

        ### FSA assigning ###
        Route::get('fsa/assigning', 'AssigningFsaController@index')->name('assigning.fsa.index');
        Route::post('fsa/assigning/postal_code', 'AssigningFsaController@assigningPostalCode')->name('assigning.postal.code');
        Route::get('zone_list_by_hub', 'AssigningFsaController@zoneListByHubId')->name('hub.zone.list');

        // Processed xml files view
        Route::get('manifest/file/creation', 'ProcessedXmlFileController@index')->name('processed.xml.file');
        Route::get('delete/duplicate/orders', 'ProcessedXmlFileController@removeDuplicateSprintIds')->name('delete.duplicate.file');

        // Csv File Uploader
        Route::get('csv/file/uploader', 'CsvFileUploaderController@index')->name('csv.file.uploader');
        Route::post('csv_import_process', 'CsvFileUploaderController@processImport')->name('import_process');

        // Route History View
        Route::get('routific/route/{id}/history', 'RoutificController@getRouteHistory');

		//Montreal Incomplete Route

            Route::get('montreal/incomplete/route', 'RoutificController@incompleteMontrealRoute');


        //Ottawa Incomplete Route

                Route::get('ottawa/incomplete/route', 'RoutificController@incompleteOttawaRoute');


        //CTC Incomplete Route

                Route::get('ctc/incomplete/route', 'RoutificController@incompleteCtcRoute');

        //For Mark Incomplete

                Route::get('mark/incomplete', 'RoutificController@getMarkIncomplete');
                Route::post('mark/incomplete', 'RoutificController@markIncomplete')->name('mark-incomplete.update');

                // remove location from unattempt and show in app
                Route::post('mark/attampt', 'RoutificController@markattampt');

                Route::post('remove/trackingid','CustomRoutingController@removeTrackingid');
                Route::post('remove/inbound/trackingid','InboundScanningController@removeTrackingid');

                //Custom Routing Edit
                Route::post('custom/edit/order','CustomRoutingController@editOrder');

                Route::post('custom/add/joey/count','CustomRoutingController@addJoeyCount');
                Route::get('custom/joey/count','CustomRoutingController@getJoeyCountDetail');
                Route::post('custom/edit/joey/count','CustomRoutingController@updateJoeyCountDetail');
                Route::post('remove/joeycount','CustomRoutingController@deleteJoeyCount');

                // Enable for Route
                Route::get('enable/route','CustomRoutingController@routeEnable');
                Route::post('custom/upload/file','CustomRoutingController@postFileRead');
                Route::post('custom/enable/trackingid','CustomRoutingController@enableTrackingId');
                Route::post('enable/order/forroute',"CustomRoutingController@enableOrderForRoute");
                // Enable orders fro Route by file
                Route::get('enable/route/{id}/file','CustomRoutingController@routeEnableOrders');

                Route::get('changepwd', 'UserController@getChangePwd');
                Route::post('changepwd/create', 'UserController@changepwd');

                #zonesRoutestesting
                Route::get('zonestesting/list/{id}', 'RoutingZonesController2@zonesdata');
                Route::post('zonestesting/create', 'RoutingZonesController2@create');
                Route::get('zonestesting/{id}/update', 'RoutingZonesController2@get_update');
                Route::post('zonestesting/update', 'RoutingZonesController2@post_update');
                Route::get('zonestesting/{id}/detail', 'RoutingZonesController2@get_detail');
                Route::get('zonestesting/list/{id}/count/{date}/{del_id}','RoutingZonesController2@get_count');
        Route::get('test/zonestesting/list/{id}/count/{date}/{del_id}','RoutingZonesController2@get_count_test');
                Route::get('zonestesting/count/{id}/{date}', 'RoutingZonesController2@order_count');
                Route::post('zonestesting/deletezone', 'RoutingZonesController2@post_deletezone');

                // Clear custom routing screen
                Route::post('remove/order/inroute','CustomRoutingController@removeOrderInRoute');

                // Custom routing reattempt
                Route::post('create/reattempt', 'CustomRoutingController@createReattempt');
                Route::post('update/status/create/reattempt','CustomRoutingController@updateStatuscreateReattempt');
                Route::post('trackingid/retuned/metchant', 'CustomRoutingController@markReturnedMerchant');

                //Incomplete Route
                Route::get('incomplete/{id}/route', 'RoutificController@incompleteRoute');

                 #zonesCustomRoutes
                Route::get('custom/routing/zones/list/{id}', 'RoutingZonesController@custom_routing_zonesdata');
                Route::post('custom/routing/zones/create', 'RoutingZonesController@custom_routing_create');
                Route::get('customzones/list/{id}/count/{del_id}','RoutingZonesController@customZoneOrderCount');
 
                // Custom Route job create
                Route::post('custom/montreal/routes/add', 'RoutificController@customMontrealRoutificCreate');
                Route::post('custom/ottawa/routes/add', 'RoutificController@customOttawaRoutificCreate');
                Route::post('custom/ctc/routes/add', 'RoutificController@customCtcRoutificCreate');

                Route::get('route/joey/data', 'RoutificController@routeJoeyData');

                //For returned
				Route::get('mark/returned', 'RoutificController@getMarkReturned');
				Route::post('mark/returned', 'routificcontroller@markreturned')->name('mark-returned.update');

                 ###Zone Types###
                Route::get('zonestypes', 'ZonesTypeController@getIndex');
                Route::get('zonestypes/add', 'ZonesTypeController@add');
                Route::post('zonestypes/create', 'ZonesTypeController@create');
                Route::get('zonestypes/edit/{id}', 'ZonesTypeController@edit');
                Route::put('zonestypes/update/{zoneTypes}', 'ZonesTypeController@update');
                Route::delete('zonestypes/{zoneTypes}', 'ZonesTypeController@destroy');

                // ctc-failed-order
                // Route::get('ctc/failed/orders', 'FailedOrderController@getAllCTCFailedOrder');
                // Route::post('ctc/failed/orders', 'FailedOrderController@createCtcOrder');
                // Route::post('ctc/create/all/order', 'FailedOrderController@createAllCtcOrder');

                // // Amazon failed order
                // Route::get('amazon/failed/orders', 'FailedOrderController@getAllAmazonFailedOrder');
                // Route::post('amazon/failed/orders', 'FailedOrderController@createAmazonOrder');
                // Route::post('amazon/create/all/order', 'FailedOrderController@createAllOrder');

                ###Reattempt Order###
                Route::get('reattempt/order', 'ReattemptOrdersController@getIndex')->name('reattempt-order.index');
                ###Scan Tracking Id ####
                Route::get('reattempt/order/search', 'ReattemptOrdersController@searchTrackingId')->name('tracking-order.search');
                ###Transfer Order###
                Route::get('transfer/order/{id}', 'ReattemptOrdersController@transferOrder')->name('transfer-order');
                ###Reattempt Order###
                Route::get('reattempt/order/{id}', 'ReattemptOrdersController@reattemptOrder')->name('reattempt-order');
				###Update status for reattempt ###
                Route::get('update-status-of-scanned-order-for-reattempt', 'ReattemptOrdersController@updateStatusOfScannedOrder')->name('update-status-of-scanned-order');
				###Multiple Reattempt Order###
                Route::get('multiple/reattempt/order', 'ReattemptOrdersController@multipleReattemptOrder')->name('multiple-reattempt-order');
                ###Update Column###
                Route::get('reattempt/order/column/update', 'ReattemptOrdersController@reattemptOrderColumnUpdate');
                ###Return Order###
                Route::get('Return/order/{id}', 'ReattemptOrdersController@returnOrder');
                ###Delete Data From Return And Reattempt Order###
        		Route::get('Reattempt/delete/{id}', 'ReattemptOrdersController@deleteReattempt');
        		###Reattempt Order List###
        		Route::get('reattempt/history', 'ReattemptOrdersController@reattemptOrderList');
				###Show Notes###
                Route::get('notes/{id}', 'ReattemptOrdersController@showNotes')->name('show-notes');
				###Approved Order By Customer Support List###
                Route::get('customer/support/approved', 'ReattemptOrdersController@approvedOrderList');
                ## Approved Customer Order Count
                Route::get('approved/customer/order/count', 'ReattemptOrdersController@approvedCustomerOrderCount');


                //remove multiple trackings
                Route::post('remove/multipletrackingid','CustomRoutingController@multipleRemoveTrackingid');
                Route::post('remove/inbound/multipletrackingid','InboundScanningController@multipleRemoveTrackingid');

                // CTC failed orders
                Route::get('ctc/failed/orders', 'TestingFailedOrderController@getAlltorontoCTCFailedOrder');
                Route::get('ctc/failed/orders/ottawa', 'TestingFailedOrderController@getAllOttawaCTCFailedOrder');
                Route::post('ctc/failed/orders', 'TestingFailedOrderController@createCtcOrder');
                Route::post('ctc/create/all/order', 'TestingFailedOrderController@createAllCtcOrder');

                // Amazon failed order
                Route::get('amazon/failed/orders', 'TestingFailedOrderController@getAllAmazonFailedOrder');
                Route::get('amazon/failed/orders/ottawa', 'TestingFailedOrderController@getAllAmazonOttawaFailedOrder');
                Route::post('amazon/failed/orders', 'TestingFailedOrderController@createAmazonOrder');
                Route::post('amazon/create/all/order', 'TestingFailedOrderController@createAllOrder');

                // big box 
                Route::get('bigbox/custom/routing/{id}/hub', 'CustomRoutingBigBoxController@getIndex');
                Route::get('bigbox/tracking/detail','CustomRoutingBigBoxController@getTrackingIdDetail');
                Route::post('bigbox/create/route/custom/routing','CustomRoutingBigBoxController@postCreateRoute'); 
                Route::post('bigbox/custom/create/order','CustomRoutingBigBoxController@postCreateOrder');
                Route::post('bigbox/remove/trackingid','CustomRoutingBigBoxController@removeTrackingid');
                Route::post('bigbox/custom/edit/order','CustomRoutingBigBoxController@editOrder');
                Route::post('bigbox/custom/add/joey/count','CustomRoutingBigBoxController@addJoeyCount');
                Route::get('bigbox/custom/joey/count','CustomRoutingBigBoxController@getJoeyCountDetail');
                Route::post('bigbox/custom/edit/joey/count','CustomRoutingBigBoxController@updateJoeyCountDetail');
                Route::post('bigbox/remove/joeycount','CustomRoutingBigBoxController@deleteJoeyCount');
                Route::post('bigbox/remove/order/inroute','CustomRoutingBigBoxController@removeOrderInRoute');
                Route::post('bigbox/remove/multipletrackingid','CustomRoutingBigBoxController@multipleRemoveTrackingid');
                Route::get('bigbox/routific/{id}/job', 'CustomRoutingBigBoxController@getBigBoxJob');

                Route::get('create/route', 'RoutificController@createCustomRouteApi');
                Route::get('createCustom/route', 'RoutificController@createCustomRouteApi');
                Route::get('job/{id}', 'RoutificController@jobsDetailsNew');

                Route::get('bigbox/trackingId/isInroute', 'CustomRoutingBigBoxController@isInRoute');

                //total/order/notinroute
                Route::post('total/order/notinroute', 'RoutificController@totalOrderNotinroute');

                // Optimized zones orders onts
                Route::get('order/count/{hub}/zone/{id}/date/{date}','RoutingZonesController2@get_count2');

                /*Added By Muhammad Raqib
                @date 30/09/2022*/
                Route::get('order/{hub}/zone/{id}/date/{date}','RoutingZonesController2@viewlist');
                /*end*/
                //attach microhub on zones 2022-05-17
               Route::post('ctc/zones/microhub/add', 'RoutingZonesController2@attachZonesMicrohub')->name('ctc-zones-microhub.add');
              //attach microhub on zones 2022-05-17

                // Route by mainfest
                Route::post('manifest/routes/data', 'AmazonOrderController@manifestRoutesData');
                Route::get('manifest/{id}/routes', 'AmazonOrderController@manifestRoutes');
                Route::post('manifest/routes/create', 'AmazonOrderController@manifestRouteCreate');

                // Get CTC vendors
                Route::get('get/ctc/vendors', 'CustomRoutingController@getCTCVendors');


                // borderless failed orders
                Route::get('borderless/failed/orders', 'TestingFailedOrderController@getAllBorderlessFailedOrder')->name('borderless-failed-order.get');
                Route::post('borderless/failed/orders', 'TestingFailedOrderController@createBorderlessOrder')->name('borderless-failed-order.post');
                Route::post('borderless/create/all/order', 'TestingFailedOrderController@createAllBorderlessOrder')->name('borderless-create-all-order.post');
                Route::post('borderless/task','TestingFailedOrderController@createBorderlessTask')->name('borderless-create-task');
                

                // vancouver failed orders
                Route::get('vancouver/failed/orders', 'VancouverFailedOrderController@getAllBorderlessFailedOrder')->name('vancouver-failed-order.get');
                Route::post('vancouver/failed/orders', 'VancouverFailedOrderController@createBorderlessOrder')->name('vancouver-failed-order.post');
                Route::post('vancouver/create/all/order', 'VancouverFailedOrderController@createAllBorderlessOrder')->name('vancouver-create-all-order.post');
                Route::post('vancouver/task','VancouverFailedOrderController@createBorderlessTask')->name('vancouver-create-task');
                 
                /*Ottawa Failed Orders*/
                Route::get('ottawa/failed/orders', 'OttawaFailedOrderController@getAllBorderlessFailedOrder')->name('ottawa-failed-order.get');
                Route::post('ottawa/failed/orders', 'OttawaFailedOrderController@createBorderlessOrder')->name('ottawa-failed-order.post');
                Route::post('ottawa/create/all/order', 'OttawaFailedOrderController@createAllBorderlessOrder')->name('ottawa-create-all-order.post');
                Route::post('ottawa/task','OttawaFailedOrderController@createBorderlessTask')->name('ottawa-create-task');
                /*End*/

                #### Routing Engine
                Route::get('routing/engine', 'RouteRngineController@getIndex')->name('routing-engine.get');
                Route::post('routing/engine', 'RouteRngineController@routingEngine')->name('routing-engine.post');

                ### Mid Mile Routing Work 2022-04-12 ###

                // mid mile hub list
                Route::get('mid/mile/hub/list', 'MidMileController@index')->name('mid.mile.hubs.list');
                // mid mile order count
                Route::get('mid/mile/order/count/hub_id/{id}/date/{date}', 'MidMileController@getMidMileOrderCount')->name('mid.mile.order.count');
                // mid mile create request for pdp routing
                Route::get('mid/mile/create/jobId', 'MidMileController@createJobId')->name('mid.mile.create.jobId');
                // mid mile slots
                Route::get('mid/mile/slots/list/hub_id/{id}', 'MidMileController@slotsListData')->name('mid.mile.slots.list');
                //create first mile slots
                Route::post('mid/mile/slot/create', 'MidMileController@storeMidMileSlot')->name('mid.mile.slot.store');
                //get data of first mile slots
                Route::get('mid/mile/slot/{id}/edit', 'MidMileController@getMidMileEditSlot')->name('mid.mile.slot.edit');
                // update data of first mile slot
                Route::post('mid/mile/slot/update', 'MidMileController@midMileSlotUpdate')->name('mid.mile.slot.update');
                //delete first mile slot
                Route::post('mid/mile/slot/delete', 'MidMileController@midMileSlotDelete')->name('mid.mile.slot.delete');
                //get detail of First mile slot
                Route::get('mid/mile/slot/{id}/detail', 'MidMileController@getDetailOfMidMileSlot')->name('mid.mile.slot.detail');
                // mid mile jobs
                Route::get('mid/mile/jobs', 'MidMileController@getMidMileJobList')->name('mid.mile.jobs');
                //create route for first mile
                Route::get('mid/mile/create/{id}/route', 'MidMileController@createRouteForMidMile')->name('mid.mile.create.route');
                //delete job of first mile
                Route::post('mid/mile/job/delete', 'MidMileController@deleteMidMileJob')->name('mid.mile.job.delete');
                //route list of mid mile
                Route::get('mid/mile/routes/list', 'MidMileController@midMileRoutesList')->name('mid.mile.route.list');
                //get route detail for mid mile
                Route::get('mid/mile/route/{id}/details', 'MidMileController@getRouteDetail')->name('mid.mile.route.detail');
                // edit route of mid mile
                Route::get('mid/mile/route/{di}/edit/hub/{id}', 'MidMileController@midMileRouteEdit')->name('nid.mile.routes.edit');
                // route transfer
                Route::post('mid/mile/route/transfer', 'MidMileController@RouteTransfer')->name('mid.mile.route.transfer');
                // map marker point
                Route::get('mid/mile/route/{id}/map', 'MidMileController@RouteMap')->name('mid.mile.route.map');
                // get map
                Route::get('mid/mile/hub/{hubId}/re_route/{id}', 'MidMileController@reRoute')->name('first.mile.re.route');
                // delete route
                Route::get('mid/mile/route/{id}/delete', 'MidMileController@midMileDeleteRoute')->name('mid.mile.route.delete');
                // get route history Of mid mile
                Route::get('mid/mile/route/{id}/history', 'MidMileController@getMidMileRouteHistory')->name('mid.mile.route.history');
                ### Mid Mile Routing Work 2022-04-12 ###

                Route::get('mi_jobs', 'MiJobController@index')->name('mi.jobs');
                Route::get('mi_job/create', 'MiJobController@create')->name('mi.job.create');
                Route::post('mi_job/store', 'MiJobController@store')->name('mi.job.store');
                Route::post('mi_job/create/job', 'MiJobController@route')->name('mi.job.route');
                Route::get('mi_job', 'MiJobController@createJob')->name('mi.job.create.job');
                Route::get('mi_job/create/{id}/route', 'MiJobController@createRoute')->name('mi.job.create.route');
                Route::get('mi_job/route/list', 'MiJobController@miJobRoutesList')->name('mi.job.route.list');
                Route::get('mi_job/route/{id}/detail', 'MiJobController@getRouteDetail')->name('mi.job.route.detail');
                Route::get('mi_job/route/{id}/edit', 'MiJobController@miJobRouteEdit')->name('mi.job.route.edit');
                Route::post('mi_job/route/transfer', 'MiJobController@routeTransfer')->name('mi.job.route.transfer');
                Route::get('mi_job/route/{id}/map', 'MiJobController@RouteMap')->name('mi.job.route.map');
                Route::get('mi_job/route/{id}/delete', 'MiJobController@miJobDeleteRoute')->name('mi.job.route.delete');
                Route::get('mi_job/route/{id}/history', 'MiJobController@miJobRouteHistory')->name('mi.job.route.history');
                Route::get('mi_job/delete/{id}', 'MiJobController@destroy')->name('mi.job.destroy');
                Route::post('job/delete', 'MiJobController@deleteMiJob')->name('mi_job.delete');
                Route::get('mi_job/{mi_job}/edit', 'MiJobController@edit')->name('mi.job.edit');
                Route::put('mi_job/{miJob}/update', 'MiJobController@update')->name('mi.job.update');
                Route::get('mi_job/{mi_job}/detail', 'MiJobController@detail')->name('mi.job.detail');
                Route::get('mi_job/hub/{hub_id}/order/{bundle_id}', 'MiJobController@orderDetail')->name('mi.job.order.detail');
                Route::post('mi_job/get_hub_name', 'MiJobController@getHubName')->name('mi.job.get.hub.name');
                Route::post('mi_job/get_vendor_name', 'MiJobController@getVendorName')->name('mi.job.get.vendor.name');
                Route::post('mi_job/assign', 'MiJobController@jobAssign')->name('mi.job.assign');

                // Inbounnd
                Route::get('inbound/scanning/{id}/hub', 'InboundScanningController@getIndex');
                Route::get('check/status/detail','InboundScanningController@checkTrackingIdStatus');
                Route::get('mark/invalid','InboundScanningController@invalidTrackingId');
                Route::get('mark/valid','InboundScanningController@validTrackingId');
                Route::get('display/invalid/{id}','InboundScanningController@displayInvalidTrackingIds')->name('display.invalid');
                Route::get('orders/tocount','InboundScanningController@OrdersToScan')->name('orders.toscan');
                // Route::get('display/date/filter/{id}','InboundScanningController@displayInvalidTrackingIdsDate')->name('display.invalid.detail');
				
				Route::get('fulfilment/list','FulfilmentController@fulfilmentList')->name('fulfilment.index');
                Route::get('fulfilment-label/{id}', 'FulfilmentController@FulfilmentPrint')->name('fulfilment.printLabel');

                Route::get('phpmyinfo', function () {
                    phpinfo(); 
                })->name('phpmyinfo');

                //Haillify Work
                Route::get('haillify/booking/list', 'HaillifyController@index')->name('haillify.booking.list');
                Route::get('haillify/complete/booking/list', 'HaillifyController@completeBooking')->name('haillify.complete.booking.list');
                Route::post('haillify/booking/transfer', 'HaillifyController@haillifyBookingTransfer')->name('haillify.booking.transfer');
                Route::post('haillify/booking/unassign', 'HaillifyController@haillifyBookingUnAssign')->name('haillify.booking.unassign');
                Route::post('haillify/booking/cancel', 'HaillifyController@haillifyBookingCancel')->name('haillify.booking.cancel');
                Route::post('haillify/booking/reject', 'HaillifyController@haillifyBookingReject')->name('haillify.booking.reject');
                Route::get('haillify/booking/{booking_id}', 'HaillifyController@haillifyBookingDetail')->name('haillify.booking.detail');
                Route::get('haillify/booking/sprint/{booking_id}', 'HaillifyController@haillifyBookingSprintDetail')->name('haillify.booking.sprint.detail');
                Route::post('haillify/booking/update/status', 'HaillifyController@haillifyBookingUpdateStatus')->name('haillify.booking.update.status');
                Route::post('haillify/booking/un_assign/driver', 'HaillifyController@haillifyUnAssignDriver')->name('haillify.booking.un_assign.driver');
                //Haillify Work

                //Raqeeb complain work
                Route::get('complain','ComplainController@index')->name('complain.index');
                Route::post('complain/add','ComplainController@create')->name('complain.create');

                // Address update using tracking id
                Route::get('updateaddress/trackingid/multiple', 'AddressUpdateController@get_multipletrackingid');
                Route::post('update/order/address/approval','AddressUpdateController@updateaddressapproval');
                Route::get('updateaddress/trackingid/multiple/approve','AddressUpdateController@updateaddressapprovaladmin');
                Route::post('trackingid/multiple/approve/btn','AddressUpdateController@updateaddressapprovaladminbtn');
                Route::post('trackingid/multiple/approve/del','AddressUpdateController@updateaddressdecline');
                Route::post('update/order/address','AddressUpdateController@updateaddress');


                // Wildork Routing
                Route::get('wildfork/routes', 'RoutificController@wildforkRoutificControls');
                Route::post('wildfork/routes/add', 'RoutificController@wildforkRoutificCreate');

                Route::get('routific/job/details/{id}', 'RoutificController@getJobDetails');
    });

});





Route::get('/test', function() {

    $userCreated = App\User::find(1);

    $emailBody = 'test';

    \Mail::raw($emailBody, function($m) use($userCreated) {

        $m->to($userCreated->email)->from(env('MAIL_USERNAME'))->subject('Welcome on Board - ValuationApp');

    });

});





       