<?php

Route::post('login', 'Api\Auth\LoginController@login');


Route::get('inventory-management/setting/category/item-category-detail/main/info/{id}', 'Api\InventoryManagement\Setting\Category\ItemMainCategoryController@categoryInfo');

Route::group(['middleware' => 'auth:api'], function()
{
    Route::post('user/password', 'Api\Auth\ResetPasswordController@reset');
    Route::get('user/logout', 'Api\Auth\LogoutController@logout');
    /******************** Start User Module ********************/
        Route::post('user/theme', 'Api\User\ThemeController@store');
    /******************** End User Module ********************/
    /******************** Start Project Management Module ********************/
        /********** Start Setting Module **********/
        Route::apiResource('project-management/setting/project/project', 'Api\ProjectManagement\Setting\Project\ProjectController');
        Route::get('project-management/setting/project/project/project-user/{id}', 'Api\ProjectManagement\Setting\Project\ProjectUserController@show');

        Route::get('project-management/setting/workforce/user/{id}', 'Api\ProjectManagement\Setting\Workforce\UserController@show');
        Route::get('project-management/setting/workforce/project-user-role', 'Api\ProjectManagement\Setting\Workforce\ProjectUserRoleController@index');
        Route::apiResource('project-management/setting/workforce/project-user', 'Api\ProjectManagement\Setting\Workforce\ProjectUserController');
        /********** End Setting Module **********/

        /********** Start Form Module **********/
        Route::get('project-management/form/project', 'Api\ProjectManagement\Form\ProjectController@index');
        Route::post('project-management/form/quantity-takeoff-header', 'Api\ProjectManagement\Form\QuantityTakeoffHeaderController@store');
        /********** End Form Module **********/

        /********** Start Transaction Module **********/
            /********** Start Draft Tab **********/
            Route::get('project-management/transaction/draft/quantity-takeoff-header/count', 'Api\ProjectManagement\Transaction\Draft\QuantityTakeoffHeaderController@qtoHeaderCount');
            Route::apiResource('project-management/transaction/draft/quantity-takeoff-header', 'Api\ProjectManagement\Transaction\Draft\QuantityTakeoffHeaderController');
            /********** End Draft Tab **********/

            /********** Start In-Progress Tab **********/
            Route::get('project-management/transaction/in-progress/quantity-takeoff-header/count', 'Api\ProjectManagement\Transaction\InProgress\QuantityTakeoffHeaderController@qtoHeaderCount');
            Route::apiResource('project-management/transaction/in-progress/quantity-takeoff-header', 'Api\ProjectManagement\Transaction\InProgress\QuantityTakeoffHeaderController');
            /********** End In-Progress Tab **********/

            /********** Start History Tab **********/
            Route::get('project-management/transaction/history/quantity-takeoff-header/count', 'Api\ProjectManagement\Transaction\History\QuantityTakeoffHeaderController@qtoHeaderCount');
            Route::apiResource('project-management/transaction/history/quantity-takeoff-header', 'Api\ProjectManagement\Transaction\History\QuantityTakeoffHeaderController');
            /********** End History Tab **********/

            Route::get('/project-management/transaction/quantity-takeoff-header/{id}', 'Api\ProjectManagement\Transaction\QuantityTakeoffHeaderController@show');
        /********** End Transaction Module **********/

        /********** Start For Approval Module **********/
            /********** Start Pending Tab **********/
            Route::get('project-management/for-approval/pending/quantity-takeoff-header/count', 'Api\ProjectManagement\ForApproval\Pending\QuantityTakeoffHeaderController@qtoHeaderCount');
            Route::apiResource('project-management/for-approval/pending/quantity-takeoff-header', 'Api\ProjectManagement\ForApproval\Pending\QuantityTakeoffHeaderController');
            Route::post('project-management/for-approval/pending/modal/quantity-takeoff-header/{id}', 'Api\ProjectManagement\ForApproval\Pending\Modal\QuantityTakeoffHeaderController@update');
            /********** End Pending Tab **********/

            /********** Start Tagged Tab **********/
            Route::get('project-management/for-approval/tagged/quantity-takeoff-header/count', 'Api\ProjectManagement\ForApproval\Tagged\QuantityTakeoffHeaderController@qtoHeaderCount');
            Route::apiResource('project-management/for-approval/tagged/quantity-takeoff-header', 'Api\ProjectManagement\ForApproval\Tagged\QuantityTakeoffHeaderController');
            Route::post('project-management/for-approval/tagged/modal/quantity-takeoff-header/{id}', 'Api\ProjectManagement\ForApproval\Tagged\Modal\QuantityTakeoffHeaderController@update');
            /********** End Tagged Tab **********/

            /********** Start In-Progress Tab **********/
            Route::get('project-management/for-approval/in-progress/quantity-takeoff-header/count', 'Api\ProjectManagement\ForApproval\InProgress\QuantityTakeoffHeaderController@qtoHeaderCount');
            Route::apiResource('project-management/for-approval/in-progress/quantity-takeoff-header', 'Api\ProjectManagement\ForApproval\InProgress\QuantityTakeoffHeaderController');
            /********** End In-Progress Tab **********/

            /********** Start History Tab **********/
            Route::get('project-management/for-approval/history/quantity-takeoff-header/count', 'Api\ProjectManagement\ForApproval\History\QuantityTakeoffHeaderController@qtoHeaderCount');
            Route::apiResource('project-management/for-approval/history/quantity-takeoff-header', 'Api\ProjectManagement\ForApproval\History\QuantityTakeoffHeaderController');
            /********** End History Tab **********/
        /********** End For Approval Module **********/

        /********** Start Monitoring Module **********/
        /********** End Monitoring Module **********/

        Route::get('/project-management/for-approval/quantity-takeoff-header/{id}', 'Api\ProjectManagement\ForApproval\QuantityTakeoffHeaderController@show');
    /******************** End Project Management Module ********************/


    /******************** Start Provision Request Module ********************/ 
        /********** Start Form Module **********/
        Route::get('provision-request/form/business-unit', 'Api\ProvisionRequest\Form\BusinessUnitController@index');
        Route::get('provision-request/form/project/{id}', 'Api\ProvisionRequest\Form\ProjectController@show');
        Route::get('provision-request/form/warehouse/{id}', 'Api\ProvisionRequest\Form\WarehouseController@show');
        Route::post('provision-request/form/item-request-temp', 'Api\ProvisionRequest\Form\ItemRequestTempController@store');
        Route::get('provision-request/form/item-request/{warehouse_id}', 'Api\ProvisionRequest\Form\ItemRequestController@show'); //JM
        Route::get('provision-request/form/item-request/{warehouse_id}/{seacrh}', 'Api\ProvisionRequest\Form\ItemRequestController@search'); //JM
        Route::post('provision-request/form/item-request', 'Api\ProvisionRequest\Form\ItemRequestController@store');
        Route::post('provision-request/form/pdf', 'Api\ProvisionRequest\Form\PDFController@pdf');
        /********** End Form Module **********/

        /********** Start Transaction Module  **********/
            /********** Start Form **********/
            Route::post('provision-request/transaction/form/item-request-temp/{id}', 'Api\ProvisionRequest\Transaction\Form\ItemRequestTempController@update');
            Route::apiResource('provision-request/transaction/form/item-request-temp', 'Api\ProvisionRequest\Transaction\Form\ItemRequestTempController');
            Route::post('provision-request/transaction/form/item-request', 'Api\ProvisionRequest\Transaction\Form\ItemRequestController@store');
            Route::get('provision-request/transaction/form/project/{id}', 'Api\ProvisionRequest\Transaction\Form\ProjectController@show');
            /********** End Form **********/

            /********** Start Draft Tab **********/
            Route::get('provision-request/transaction/draft/item-request-temp/count', 'Api\ProvisionRequest\Transaction\Draft\ItemRequestTempController@itemRequestCount');
            Route::apiResource('provision-request/transaction/draft/item-request-temp', 'Api\ProvisionRequest\Transaction\Draft\ItemRequestTempController');
            /********** End Draft Tab **********/

            /********** Start In-Progress Tab **********/
            Route::get('provision-request/transaction/in-progress/item-request/count', 'Api\ProvisionRequest\Transaction\InProgress\ItemRequestController@itemRequestCount');
            Route::apiResource('provision-request/transaction/in-progress/item-request', 'Api\ProvisionRequest\Transaction\InProgress\ItemRequestController');
            Route::apiResource('provision-request/transaction/in-progress/item-request-header-comment', 'Api\ProvisionRequest\Transaction\InProgress\ItemRequestHeaderCommentController');
            /********** End In-Progress Tab **********/

            /********** Start History Tab **********/
            Route::get('provision-request/transaction/history/item-request/count', 'Api\ProvisionRequest\Transaction\History\ItemRequestController@itemRequestCount');
            Route::apiResource('provision-request/transaction/history/item-request', 'Api\ProvisionRequest\Transaction\History\ItemRequestController');
            /********** End History Tab **********/

            Route::get('provision-request/transaction/item-request/{id}', 'Api\ProvisionRequest\Transaction\ItemRequestController@show');
        /********** End Transaction Module **********/

        /********** Start For Approval Module **********/
            /********** Start Pending Tab **********/
            Route::get('provision-request/for-approval/pending/item-request/count', 'Api\ProvisionRequest\ForApproval\Pending\ItemRequestController@itemRequestCount');
            Route::apiResource('provision-request/for-approval/pending/item-request', 'Api\ProvisionRequest\ForApproval\Pending\ItemRequestController');
            Route::post('provision-request/for-approval/pending/modal/item-request-header/{id}', 'Api\ProvisionRequest\ForApproval\Pending\Modal\ItemRequestHeaderController@update');
            /********** End Pending Tab **********/

            /********** Start Tagged Tab **********/
            Route::get('provision-request/for-approval/tagged/item-request/count', 'Api\ProvisionRequest\ForApproval\Tagged\ItemRequestController@itemRequestCount');
            Route::apiResource('provision-request/for-approval/tagged/item-request', 'Api\ProvisionRequest\ForApproval\Tagged\ItemRequestController');
            
            Route::post('provision-request/for-approval/tagged/modal/item-request/{id}', 'Api\ProvisionRequest\ForApproval\Tagged\Modal\ItemRequestController@update');
            Route::post('provision-request/for-approval/tagged/modal/item-request-header/{id}', 'Api\ProvisionRequest\ForApproval\Tagged\Modal\ItemRequestHeaderController@update');
            Route::apiResource('provision-request/for-approval/tagged/item-request-header-comment', 'Api\ProvisionRequest\ForApproval\Tagged\ItemRequestHeaderCommentController');
            /********** End Tagged Tab **********/

            /********** Start In-Progress Tab **********/
            Route::get('provision-request/for-approval/in-progress/item-request/count', 'Api\ProvisionRequest\ForApproval\InProgress\ItemRequestController@itemRequestCount');
            Route::apiResource('provision-request/for-approval/in-progress/item-request', 'Api\ProvisionRequest\ForApproval\InProgress\ItemRequestController');
            Route::apiResource('provision-request/for-approval/in-progress/item-request-header-comment', 'Api\ProvisionRequest\ForApproval\InProgress\ItemRequestHeaderCommentController');
            /********** End In-Progress Tab **********/

            /********** Start History Tab **********/
            Route::get('provision-request/for-approval/history/item-request/count', 'Api\ProvisionRequest\ForApproval\History\ItemRequestController@itemRequestCount');
            Route::apiResource('provision-request/for-approval/history/item-request', 'Api\ProvisionRequest\ForApproval\History\ItemRequestController');
            /********** End History Tab **********/

            Route::get('provision-request/for-approval/item-request/{id}', 'Api\ProvisionRequest\ForApproval\ItemRequestController@show');
        /********** End For Approval Module **********/

        /********** Start Monitoring Module **********/
        /********** End Monitoring Module **********/
    /******************** End Provision Request Module  ********************/

    /******************** Start Cost Control Module ********************/ 
        /********** Start Approval Module **********/
        /********** End Approval Module **********/

        /********** Start Monitoring Module **********/
        /********** End Monitoring Module **********/
    /******************** End Cost Control Module ********************/ 

    /******************** Start Inventory Management Module ********************/
        /********** Start Provision Request Module **********/
            /********** Start Pending Tab **********/
            Route::get('inventory-management/provision-request/pending/item-request-header/count', 'Api\InventoryManagement\ProvisionRequest\Pending\ItemRequestHeaderController@itemRequestCount');
            Route::apiResource('inventory-management/provision-request/pending/item-request-header', 'Api\InventoryManagement\ProvisionRequest\Pending\ItemRequestHeaderController');
            Route::post('inventory-management/provision-request/pending/modal/item-request-header/{id}', 'Api\InventoryManagement\ProvisionRequest\Pending\Modal\ItemRequestHeaderController@update');
            /********** End Pending Tab **********/

            /********** Start Tagged Tab **********/
            Route::post('inventory-management/provision-request/tagged/modal/item-request/update/{id}', 'Api\InventoryManagement\ProvisionRequest\Tagged\Modal\ItemRequestController@update_status'); //JM
            Route::post('inventory-management/provision-request/tagged/modal/item-request/store', 'Api\InventoryManagement\ProvisionRequest\Tagged\Modal\ItemRequestController@store'); //JM
            Route::get('inventory-management/provision-request/tagged/item-request-header/alternative/{category_id}/{warehouse_id}', 'Api\InventoryManagement\ProvisionRequest\ItemRequestHeaderController@alternative'); //JM
            Route::get('inventory-management/provision-request/tagged/item-request-header/count', 'Api\InventoryManagement\ProvisionRequest\Tagged\ItemRequestHeaderController@itemRequestCount');
            Route::apiResource('inventory-management/provision-request/tagged/item-request-header', 'Api\InventoryManagement\ProvisionRequest\Tagged\ItemRequestHeaderController');
            Route::post('inventory-management/provision-request/tagged/modal/item-request/{id}', 'Api\InventoryManagement\ProvisionRequest\Tagged\Modal\ItemRequestController@update');
            Route::post('inventory-management/provision-request/tagged/modal/item-request-header/print/pfd', 'Api\InventoryManagement\ProvisionRequest\Tagged\Modal\ItemRequestHeaderController@printPdf');
            Route::post('inventory-management/provision-request/tagged/modal/item-request-header/{id}', 'Api\InventoryManagement\ProvisionRequest\Tagged\Modal\ItemRequestHeaderController@update');
            Route::apiResource('inventory-management/provision-request/tagged/item-request-header-comment', 'Api\InventoryManagement\ProvisionRequest\Tagged\ItemRequestHeaderCommentController');
            /********** End Tagged Tab **********/

            /********** Start In-Progress Tab **********/
            Route::get('inventory-management/provision-request/in-progress/item-request-header/count', 'Api\InventoryManagement\ProvisionRequest\InProgress\ItemRequestHeaderController@itemRequestCount');
            Route::apiResource('inventory-management/provision-request/in-progress/item-request-header', 'Api\InventoryManagement\ProvisionRequest\InProgress\ItemRequestHeaderController');
            /********** End In-Progress Tab **********/

            /********** Start History Tab **********/
            Route::get('inventory-management/provision-request/history/item-request-header/count', 'Api\InventoryManagement\ProvisionRequest\History\ItemRequestHeaderController@itemRequestCount');
            Route::apiResource('inventory-management/provision-request/history/item-request-header', 'Api\InventoryManagement\ProvisionRequest\History\ItemRequestHeaderController');
            /********** End History Tab **********/

            Route::get('inventory-management/provision-request/item-request-header/{id}', 'Api\InventoryManagement\ProvisionRequest\ItemRequestHeaderController@show');
        /********** End Provision Request Module **********/

        /********** Start Monitoring Module **********/
            /********** Start Item Function **********/
            Route::get('inventory-management/monitoring/item/search/{search}', 'Api\InventoryManagement\Monitoring\MonitoringItemController@SearchItem');
            Route::apiResource('inventory-management/monitoring/item', 'Api\InventoryManagement\Monitoring\MonitoringItemController');
            /********** End Item Function **********/

            /********** Start Log Function **********/
            Route::get('inventory-management/monitoring/log/out', 'Api\InventoryManagement\Monitoring\MonitoringLogController@LogOut');
            Route::get('inventory-management/monitoring/log/in', 'Api\InventoryManagement\Monitoring\MonitoringLogController@LogIn');
            Route::get('inventory-management/monitoring/log/count', 'Api\InventoryManagement\Monitoring\MonitoringLogController@LogCount');
            Route::apiResource('inventory-management/monitoring/log', 'Api\InventoryManagement\Monitoring\MonitoringLogController');
            /********** End Log Function **********/

            /********** Start Request Function **********/
            Route::get('inventory-management/monitoring/item-request/individual/{id}', 'Api\InventoryManagement\Monitoring\MonitoringRequestItemController@ListItemRequest');
            Route::apiResource('inventory-management/monitoring/item-request', 'Api\InventoryManagement\Monitoring\MonitoringRequestItemController');
            /********** End Request Function **********/
        /********** End Monitoring Module **********/

        //--Added by JM--
        /********** Start Item Module **********/
        Route::apiResource('inventory-management/setting/item/item-detail', 'Api\InventoryManagement\Setting\Item\ItemController');
        /********** End Item Module **********/

        /********** Start Stock-in Module **********/
        Route::get('inventory-management/stock-in/item/search/{search}', 'Api\InventoryManagement\StockIn\ItemController@SearchItem');
        Route::apiResource('inventory-management/stock-in/item', 'Api\InventoryManagement\StockIn\ItemController');
        Route::apiResource('inventory-management/stock-in/item-in-stock', 'Api\InventoryManagement\StockIn\ItemInStockController');
        /********** End Stock-in Module **********/

        /********** Start Stock-out Module **********/
        Route::get('inventory-management/stock-out/item-in-stock/search/{search}', 'Api\InventoryManagement\StockOut\ItemInStockController@SearchItem');
        Route::apiResource('inventory-management/stock-out/item-in-stock', 'Api\InventoryManagement\StockOut\ItemInStockController');
        Route::apiResource('inventory-management/stock-out/item-out-stock', 'Api\InventoryManagement\StockOut\ItemOutStockController');
        /********** End Stock-out Module **********/

         /********** Start Setting Module **********/
            /********** Start Category Module **********/
                /********** Start Attribute Function **********/
                Route::apiResource('inventory-management/setting/category/attribute', 'Api\InventoryManagement\Setting\Category\ItemAttributeController');
                /********** End Attribute Function **********/

                /********** Start Main Category Function **********/
                //
                //
                //
                Route::get('inventory-management/setting/category/item-category-detail/main/no-child', 'Api\InventoryManagement\Setting\Category\ItemMainCategoryController@Show_Nochild_Category');
                Route::apiResource('inventory-management/setting/category/item-category-detail/main', 'Api\InventoryManagement\Setting\Category\ItemMainCategoryController');
                /********** End Main Category Function **********/

                /********** Start Sub Category Function **********/
                Route::get('inventory-management/setting/category/item-category-detail/sub/relation/{id}','Api\InventoryManagement\Setting\Category\ItemSubCategoryController@CategoryRelationDetail');
                Route::apiResource('inventory-management/setting/category/item-category-detail/sub', 'Api\InventoryManagement\Setting\Category\ItemSubCategoryController');
                /********** End Sub Category Function **********/
 
                /********** Start Measurement Function **********/
                Route::apiResource('inventory-management/setting/category/measurement', 'Api\InventoryManagement\Setting\Category\ItemMeasurementController');
                /********** End Measurement Function **********/
            /********** End Category Module **********/

            /********** Start Item Module **********/
                /********** Start Attribute Function **********/
                Route::get('inventory-management/setting/item/item-attribute/array/{id}','Api\InventoryManagement\Setting\Item\ItemAttributeController@Attribute_Array');
                Route::get('inventory-management/setting/item/item-attribute/detail/{id}','Api\InventoryManagement\Setting\Item\ItemAttributeController@AttributeDetail');
                Route::apiResource('inventory-management/setting/item/item-attribute', 'Api\InventoryManagement\Setting\Item\ItemAttributeController');
                /********** End Attribute Function **********/

                /********** Start Brand Function **********/
                Route::get('inventory-management/setting/item/item-brand/{id}', 'Api\InventoryManagement\Setting\Item\ItemBrandController@show_brand');
                Route::get('inventory-management/setting/item/item-brand/{id}/{cat_id}', 'Api\InventoryManagement\Setting\Item\ItemBrandController@show');
                Route::apiResource('inventory-management/setting/item/item-brand', 'Api\InventoryManagement\Setting\Item\ItemBrandController');
                /********** End Brand Function **********/

                /********** Start category Function **********/
                Route::apiResource('inventory-management/setting/item/item-category', 'Api\InventoryManagement\Setting\Item\ItemCategoryController');
                /********** End Category Function **********/

                /********** Start Add Item Function **********/
            //    Route::get('inventory-management/setting/item/item-detail/log/{id}', 'Api\InventoryManagement\Setting\Item\ItemController@Log');
                Route::get('inventory-management/setting/item/item-detail/search/{warehouse_id}/{search}', 'Api\InventoryManagement\Setting\Item\ItemController@SearchItem');
                Route::apiResource('inventory-management/setting/item/item-detail', 'Api\InventoryManagement\Setting\Item\ItemController');
                /********** End Add Item Function **********/
 
                /********** Start Warehouse Function **********/
                Route::get('inventory-management/setting/item/warehouse/businessunit', 'Api\InventoryManagement\Setting\Item\WarehouseController@business_unit');
                Route::apiResource('inventory-management/setting/item/warehouse', 'Api\InventoryManagement\Setting\Item\WarehouseController');
                /********** End Warehouse Function **********/

                 /********** Start Location Function **********/
                 Route::apiResource('inventory-management/setting/item/location', 'Api\InventoryManagement\Setting\Item\LocationController');
                 /********** End Location Function **********/
            /********** End Item Module **********/

            /********** Start Brand Module **********/
            Route::get('inventory-management/setting/brand/item-brand/model/{id}', 'Api\InventoryManagement\Setting\Brand\ItemBrandController@show_model');
            Route::apiResource('inventory-management/setting/brand/item-brand', 'Api\InventoryManagement\Setting\Brand\ItemBrandController');

            Route::get('inventory-management/setting/brand/item-model/category', 'Api\InventoryManagement\Setting\Brand\ItemModelController@category_show');
            Route::get('inventory-management/setting/brand/item-model/category/model/{id}', 'Api\InventoryManagement\Setting\Brand\ItemModelController@category_model_show');
            Route::apiResource('inventory-management/setting/brand/item-model', 'Api\InventoryManagement\Setting\Brand\ItemModelController');
            /********** End Brand Module **********/
        /********** End Setting Module **********/


    /******************** End Inventory Management Module ********************/

    /******************** Start Procurement Management Module ********************/
        /********** Start Provision Request Module **********/
            /********** Start Pending Tab **********/
            Route::get('procurement-management/provision-request/pending/item-request-header/count', 'Api\ProcurementManagement\ProvisionRequest\Pending\ItemRequestHeaderController@itemRequestCount');
            Route::apiResource('procurement-management/provision-request/pending/item-request-header', 'Api\ProcurementManagement\ProvisionRequest\Pending\ItemRequestHeaderController');
            /********** End Pending Tab **********/

            /********** Start In-Progress Tab **********/
            Route::get('procurement-management/provision-request/in-progress/item-request-header/count', 'Api\ProcurementManagement\ProvisionRequest\InProgress\ItemRequestHeaderController@itemRequestCount');
            Route::apiResource('procurement-management/provision-request/in-progress/item-request-header', 'Api\ProcurementManagement\ProvisionRequest\InProgress\ItemRequestHeaderController');
            /********** End In-Progress Tab **********/

            /********** Start History Tab **********/
            Route::get('procurement-management/provision-request/history/item-request-header/count', 'Api\ProcurementManagement\ProvisionRequest\History\ItemRequestHeaderController@itemRequestCount');
            Route::apiResource('procurement-management/provision-request/history/item-request-header', 'Api\ProcurementManagement\ProvisionRequest\History\ItemRequestHeaderController');
            /********** End History Tab **********/

            Route::apiResource('procurement-management/provision-request/item-request-header', 'Api\ProcurementManagement\ProvisionRequest\ItemRequestHeaderController');
        /********** End Provision Request Module **********/

    /******************** End Procurement Management Module ********************/

    /******************** Start Administrator Module ********************/
        /********** Start User Module **********/
        Route::get('administrator/user/business-unit', 'Api\Administrator\User\BusinessUnitController@index');
        Route::get('administrator/user/department/{id}', 'Api\Administrator\User\DepartmentController@show');
        Route::get('administrator/user/group/{id}', 'Api\Administrator\User\GroupController@show');
        Route::get('administrator/user/business-unit-position/{id}', 'Api\Administrator\User\BusinessUnitPositionController@show');
        Route::post('administrator/user/store', 'Api\Administrator\User\UserController@store');
        Route::apiResource('administrator/user', 'Api\Administrator\User\UserController');
        /********** End User Module **********/

    /******************** End Administrator Module ********************/

    Route::apiResource('unit-of-measure', 'Api\UnitOfMeasureController');
});

Route::get('inventory-management/report/log/all/{warehouse_id}/{date_from}/{date_to}', 'Api\InventoryManagement\Setting\Item\ItemReportController@item_report_all');
Route::get('inventory-management/report/log/in/{warehouse_id}/{date_from}/{date_to}', 'Api\InventoryManagement\Setting\Item\ItemReportController@item_report_in');
Route::get('inventory-management/report/log/out/{warehouse_id}/{date_from}/{date_to}', 'Api\InventoryManagement\Setting\Item\ItemReportController@item_report_out');
Route::get('inventory-management/report/log/receiving/{warehouse_id}/{date_from}/{date_to}', 'Api\InventoryManagement\Setting\Item\ItemReportController@item_report_recieving');
Route::get('inventory-management/report/log/releasing/{warehouse_id}/{date_from}/{date_to}', 'Api\InventoryManagement\Setting\Item\ItemReportController@item_report_releasing');
Route::get('inventory-management/report/log/pdf', 'Api\InventoryManagement\Setting\Item\ItemReportController@item_report_releasing');

Route::get('inventory-management/setting/category/item-category-detail/main/relation/category/{id}', 'Api\InventoryManagement\Setting\Category\ItemMainCategoryController@ShowCategoryRelations_Test');

///////////////////////  Bicol Health Facility /////////////////////////

/////////////////////// Registration Maintenance /////////////////////////
//Route::apiResource('bicolhealthfacility/registration/store', 'Api\BicolHealthFacility\Registration\RegistrationController@store');
Route::get('bicolhealthfacility/record/forms/test', 'Api\BicolHealthFacility\Form\FormController@test');
Route::post('bicolhealthfacility/record/forms', 'Api\BicolHealthFacility\Form\FormController@pdf');

Route::get('bicolhealthfacility/record/previous_illnesses/{id}', 'Api\BicolHealthFacility\Record\RecordController@previous_illnesses');
Route::get('bicolhealthfacility/record/family_history_father/{id}', 'Api\BicolHealthFacility\Record\RecordController@family_history_father');
Route::get('bicolhealthfacility/record/family_history_mother/{id}', 'Api\BicolHealthFacility\Record\RecordController@family_history_mother');
Route::get('bicolhealthfacility/record/lifestyle_info/{id}', 'Api\BicolHealthFacility\Record\RecordController@lifestyle_info');
Route::get('bicolhealthfacility/record/present_illnesses/{id}', 'Api\BicolHealthFacility\Record\RecordController@present_illnesses');
Route::get('bicolhealthfacility/record/immunization_history/{id}', 'Api\BicolHealthFacility\Record\RecordController@immunization_history');

Route::post('bicolhealthfacility/record/update_personal_details', 'Api\BicolHealthFacility\Record\RecordController@update');
Route::post('bicolhealthfacility/record/update_previous_illnesses', 'Api\BicolHealthFacility\Record\RecordController@update');
Route::post('bicolhealthfacility/record/update_family_history_father', 'Api\BicolHealthFacility\Record\RecordController@update');
Route::post('bicolhealthfacility/record/update_family_history_mother', 'Api\BicolHealthFacility\Record\RecordController@update');
Route::post('bicolhealthfacility/record/update_lifestyle_info', 'Api\BicolHealthFacility\Record\RecordController@update');
Route::post('bicolhealthfacility/record/update_present_illnesses', 'Api\BicolHealthFacility\Record\RecordController@update');
Route::post('bicolhealthfacility/record/update_immunization_history', 'Api\BicolHealthFacility\Record\RecordController@update');

Route::get('bicolhealthfacility/record/individual/{id}', 'Api\BicolHealthFacility\Record\RecordController@individual');
Route::get('bicolhealthfacility/record/{search}', 'Api\BicolHealthFacility\Record\RecordController@show');
Route::get('bicolhealthfacility/record/filter/{date_from}/{date_to}/{checkbox1}/{checkbox2}', 'Api\BicolHealthFacility\Record\RecordController@filter');
Route::apiResource('bicolhealthfacility/record', 'Api\BicolHealthFacility\Record\RecordController');

Route::post('bicolhealthfacility/registration/store/duplicate', 'Api\BicolHealthFacility\Registration\RegistrationController@store_duplicate');
Route::get('bicolhealthfacility/registration/{action}', 'Api\BicolHealthFacility\Registration\RegistrationController@show_maintenance');
Route::apiResource('bicolhealthfacility/registration', 'Api\BicolHealthFacility\Registration\RegistrationController');

//module
Route::apiResource('bicolhealthfacility/module', 'Api\BicolHealthFacility\User\ModuleController');

//user
Route::post('bicolhealthfacility/user/store', 'Api\BicolHealthFacility\User\UserController@store');
Route::post('bicolhealthfacility/user/update', 'Api\BicolHealthFacility\User\UserController@update_access');
Route::get('bicolhealthfacility/user/access/{id}', 'Api\BicolHealthFacility\User\UserController@access');
Route::apiResource('bicolhealthfacility/user', 'Api\BicolHealthFacility\User\ModuleController');