<?php


/**
 * Permissions config
 *
 * @date   23/10/2020
 */

return [
    // 'Dashboard'=>
    //     [
    //         'View dashboard' => 'dashboard.index',
    //     ],
    'Roles'=>
        [
            'Roles List' => 'role.index',
            'Create' => 'role.create|role.store',
            'Edit' => 'role.edit|role.update',
            'View' => 'role.show',
            'Set permissions' => 'role.set-permissions|role.set-permissions.update',
        ],
    'Sub Admin'=>
        [
            'Sub Admins' => 'sub-admin.index|subAdmin.data',
            'Create' => 'sub-admin.add|sub-admin.create',
            'Edit' => 'sub-admin.edit|sub-admin.update',
            'Status change' => 'sub-admin.active|sub-admin.inactive',
            'View' => 'sub-admin.profile',
            'Delete' => 'sub-admin.destroy',
        ],
        'Montreal Routing' =>
        [
            'Montreal Route' => 'montreal-routes.index',
            'Montreal Route Map' => 'montreal-routes.route-location.joey|montreal-routes.route-map-location',
            'Montreal Route Details' => 'montreal-routes.route-detail',
            'Montreal Route Edit' => 'montreal-routes.edit-hub',
            'Montreal Route Transfer' => 'montreal-routes.route-transfer',
            'Montreal Route Map of Whole Route' => 'montreal-routes.route-map',
            'Montreal Route Map of Current Route' => 'montreal-routes.route-remaining',
            'Montreal Route Delete ' => 'montreal-routes.hub-delete',
            'Montreal Route Re-Routing' => 'montreal-routes.hub-re-route',
            'Montreal Route History' => 'montreal-routes.route-history',
            'Montreal Jobs' => 'montreal-job.routific-job',
            'Montreal Jobs Create Route' => 'montreal-job.create-route',
            'Montreal Jobs Create Custom Route' => 'montreal-job.createCustom-route',
            'Montreal Jobs Delete' => 'montreal-job.routific-job-delete',
            'Assign To Sorter' => 'montreal-assign.hub-route-assign',
            'Assign To Sorter Route Edit' => 'montreal-sorter.edit-hub',
            'Assign To Sorter Route transfer' =>'montreal-routes-locations-transfer-sorter.post',
            'Assign Route' => 'montreal-assign.hub-route-assign-add',
            'Assign To Sorter Detail' => 'montreal-assign.route-joey',
            'Assign To Sorter Delete' => 'montreal-assign.joey-route-delete',
           // 'Montreal Deleted Route' => 'montreal-routes.deleted',
          //  'Deleted Route ' => 'montreal-routes.hub-delete',
           // 'Deleted Route Assign ' => 'montreal-routes.assign',
            'Montreal Custom Routing' => 'montreal-custom.routing',
            'Montreal Custom Routing Scan Order' => 'montreal-custom.tracking-detail|montreal-custom.create-order|montreal-custom.edit-order|montreal-custom.remove-trackingid|montreal-custom.create-reattempt.post|montreal-custom-mark-delivery-reattempt-trackingid.post|montreal-routes-locations-transfer.post',
            'Custom Routing Create' =>'montreal-custom.create-order',
            'Custom Routing Edit' =>'montreal-custom.edit-order',
            'Custom Routing Clean' =>'montreal-custom.remove-order',
            'Create Job ID' => 'montreal-custom.create-routing',
            'Add Joey Vehicle' => 'montreal-custom.add-joey-count|montreal-custom.joey-count|montreal-custom.edit-joey-count|montreal-custom.remove-joey-count',
            'Add Joey Vehicle Edit' => 'montreal-custom.joey-count|montreal-custom.edit-joey-count',
            'Add Joey Vehicle Remove' => 'montreal-custom.remove-joey-count',
            'Scanned Order Deleted' => 'montreal-custom.remove-multiple-tracking-id',
            'Scanned Order Remove' => 'montreal-custom.remove-trackingid',
           // 'Scanned Order Create' => 'montreal-custom.create-order',
            'Montreal Unattempt Order' => 'montreal-incomplete.route',
            //'Unattempt Order Assign' => 'montreal-routes.assign',
            'Mark Attempt' => 'montreal-incomplete.mark-attampt',
            'Create Reattempt'=>'montreal-custom.create-reattempt.post',
            'Update Status & Create Reattempt'=>'montreal-custom-update-status-create-reattempt.post',
            'Create Reattempt Of delivered Order'=>'montreal-custom-mark-delivery-reattempt-trackingid.post',
            'Montreal Routes Locations Transfer'=>'montreal-routes-locations-transfer.post',


        ],
        'Ottawa Routing' =>
        [
            'Ottawa Route' => 'ottawa-routes.index',
            'Ottawa Route Map' => 'ottawa-routes.route-location.joey|ottawa-routes.route-map-location',
            'Ottawa Route Details' => 'ottawa-routes.route-detail',
            'Ottawa Route Edit ' => 'ottawa-routes.edit-hub',
            'Ottawa Route Transfer' => 'ottawa-routes.route-transfer',
            'Ottawa Route Map of Whole Route' => 'ottawa-routes.route-map',
            'Ottawa Route Map of Current Route' => 'ottawa-routes.route-remaining',
            'Ottawa Route Delete ' => 'ottawa-routes.hub-delete',
            'Ottawa Route Re-Routing' => 'ottawa-routes.hub-re-route',
            'Ottawa Route  History' => 'ottawa-routes.route-history',
            'Ottawa Jobs' => 'ottawa-job.routific-job',
            'Ottawa Jobs Create Route' => 'ottawa-job.create-route',
            'Ottawa Jobs Create Custom Route' => 'ottawa-job.createCustom-route',
            'Ottawa Jobs Delete' => 'ottawa-job.routific-job-delete',
            'Assign To Sorter' => 'ottawa-assign.hub-route-assign',
            'Assign To Sorter Route Edit' => 'ottawa-sorter.edit-hub',
            'Assign To Sorter Route transfer' =>'ottawa-routes-locations-transfer-sorter.post',
            //'Assign To Sorter Route Edit' => 'ottawa-routes.edit-hub',
            'Assign Route' => 'ottawa-assign.hub-route-assign-add',
            'Assign To Sorter Detail' => 'ottawa-assign.route-joey',
            'Assign To Sorter Delete' => 'ottawa-assign.joey-route-delete',
           // 'Ottawa Deleted Route' => 'ottawa-routes.deleted',
            //'Deleted Route ' => 'ottawa-routes.hub-delete',
           // 'Deleted Route Assign ' => 'ottawa-routes.assign',
            'Ottawa Custom Routing' => 'ottawa-custom.routing',
            'Ottawa Custom Routing Scan Order' => 'ottawa-custom.tracking-detail|ottawa-custom.create-order|ottawa-custom.edit-order|ottawa-custom.remove-trackingid|ottawa-custom.create-reattempt.post|ottawa-custom-mark-delivery-reattempt-trackingid.post|ottawa-routes-locations-transfer.post',
            'Custom Routing Create' =>'ottawa-custom.create-order',
            'Custom Routing Edit' =>'ottawa-custom.edit-order',
            'Custom Routing Clean' =>'ottawa-custom.remove-order',
            'Create Job ID' => 'ottawa-custom.create-routing',
            'Add Joey Vehicle' => 'ottawa-custom.add-joey-count|ottawa-custom.joey-count|ottawa-custom.edit-joey-count|ottawa-custom.remove-joey-count',
            'Add Joey Vehicle Edit' => 'ottawa-custom.joey-count|ottawa-custom.edit-joey-count',
            'Add Joey Vehicle Remove' => 'ottawa-custom.remove-joey-count',
            'Scanned Order Deleted' => 'ottawa-custom.remove-multiple-tracking-id',
            'Scanned Order Remove' => 'ottawa-custom.remove-trackingid',
           // 'Scanned Order Create' => 'ottawa-custom.create-order',
            'Ottawa Unattempt Order' => 'ottawa-incomplete.route',
           // 'Unattempt Order Assign' => 'ottawa-routes.assign',
            'Mark Attempt' => 'ottawa-incomplete.mark-attampt',
            'Create Reattempt'=>'ottawa-custom.create-reattempt',
            'Update Status & Create Reattempt'=>'ottawa-custom-update-status-create-reattempt.post',
            'Create Reattempt Of delivered Order'=>'ottawa-custom-mark-delivery-reattempt-trackingid.post',
            'Ottawa Routes Locations Transfer'=>'ottawa-routes-locations-transfer.post',


        ],
        'CTC Routing' =>
        [
            'CTC Route' => 'ctc-routes.index',
            'CTC Route Map' => 'ctc-routes.route-location.joey|ctc-routes.route-map-location',
            'CTC Route Details' => 'ctc-routes.route-detail',
            'CTC Route Edit' => 'ctc-routes.edit-hub',
            'CTC Route Transfer' => 'ctc-routes.route-transfer',
            'CTC Route Map of Whole Route' => 'ctc-routes.route-map',
            'CTC Route Map of Current Route' => 'ctc-routes.route-remaining',
            'CTC Route Delete' => 'ctc-routes.hub-delete',
            'CTC Route Re-Routing' => 'ctc-routes.hub-re-route',
            'CTC Route History' => 'ctc-routes.route-history',
            'CTC Jobs' => 'ctc-job.routific-job',
            'CTC Jobs Create Route' => 'ctc-job.create-route',
            'CTC Jobs Create Custom Route' => 'ctc-job.createCustom-route',
            'CTC Jobs Delete' => 'ctc-job.routific-job-delete',
            'Assign To Sorter' => 'ctc-assign.hub-route-assign',
            'Assign To Sorter Route Edit' => 'ctc-sorter.edit-hub',
            'Assign To Sorter Route transfer' =>'ctc-routes-locations-transfer-sorter.post',
            //'Assign To Sorter Route Edit' => 'ctc-routes.edit-hub',
            'Assign Route' => 'ctc-assign.hub-route-assign-add',
            'Assign To Sorter Detail' => 'ctc-assign.route-joey',
            'Assign To Sorter Delete' => 'ctc-assign.joey-route-delete',
            'CTC Deleted Route' => 'ctc-routes.deleted',
           // 'Deleted Route ' => 'ctc-routes.hub-delete',
            //'Deleted Route Assign ' => 'ctc-routes.assign',
            'CTC Custom Routing' => 'ctc-custom.routing',
            'CTC Custom Routing Scan Order' => 'ctc-custom.tracking-detail|ctc-custom.create-order|ctc-custom.edit-order|ctc-custom.remove-trackingid|ctc-custom.create-reattempt.post|ctc-custom-mark-delivery-reattempt-trackingid.post|ctc-routes-locations-transfer.post',
            'Custom Routing Create' =>'ctc-custom.create-order',
            'Custom Routing Edit' =>'ctc-custom.edit-order',
            'Custom Routing Clean' =>'ctc-custom.remove-order',
            'Create Job ID' => 'ctc-custom.create-routing',
            'Add Joey Vehicle' => 'ctc-custom.add-joey-count|ctc-custom.joey-count|ctc-custom.edit-joey-count|ctc-custom.remove-joey-count',
            'Add Joey Vehicle Edit' => 'ctc-custom.joey-count|ctc-custom.edit-joey-count',
            'Add Joey Vehicle Remove' => 'ctc-custom.remove-joey-count',
            'Scanned Order Deleted' => 'ctc-custom.remove-multiple-tracking-id',
            'Scanned Order Remove' => 'ctc-custom.remove-trackingid',
            'CTC Unattempt Order' => 'ctc-incomplete.route',
            // 'Unattempt Order Assign' => 'ctc-routes.assign',
            'Mark Attempt' => 'ctc-incomplete.mark-attampt',
            'Create Reattempt'=>'ctc-custom.create-reattempt',
            'Update Status & Create Reattempt'=>'ctc-custom-update-status-create-reattempt.post',
            'Create Reattempt Of delivered Order'=>'ctc-custom-mark-delivery-reattempt-trackingid.post',
            'CTC Routes Locations Transfer'=>'ctc-routes-locations-transfer.post',

        ],
    // 'Montreal Manifest' =>
    //     [
    //         'Manifest Routing ' => 'montreal-manifest-routes.index|montreal-manifest-routes.data',
    //         'Create Job ID' => 'montreal-manifest-routes.create',
    //         'View Slot' => 'montreal-slot-list-hubid-get',
    //         'Create Slot' => 'montreal-slot-create',
    //         'Slot Edit' => 'montreal-slot-update|montreal-slot-del-update',
    //         'Slot Detail' => 'montreal-slot-detail',
    //         'Slot Delete' => 'montreal-slot-deleteslot',
    //         'Manifest Report' => 'montreal-manifest-report.index|montreal-manifest-report.data',
    //         'Manifest Report CSV' => 'montreal-manifest-report-csv-download',
    //     ],
    // 'Ottawa Manifest' =>
    //     [
    //         'Manifest Routing ' => 'ottawa-manifest-routes.index|ottawa-manifest-routes.data',
    //         'Create Job ID' => 'ottawa-manifest-routes.create',
    //         'View Slot' => 'ottawa-slot-list-hubid-get',
    //         'Create Slot' => 'ottawa-slot-create',
    //         'Slot Edit' => 'ottawa-slot-update|ottawa-slot-del-update',
    //         'Slot Detail' => 'ottawa-slot-detail',
    //         'Slot Delete' => 'ottawa-slot-deleteslot',
    //         'Manifest Report' => 'ottawa-manifest-report.index|ottawa-manifest-report.data',
    //         'Manifest Report CSV' => 'ottawa-manifest-report-csv-download',
    //     ],

   
    'Montreal Big Box' =>
        [
            'Big Box Custom Routing' => 'montreal-bigbox-custom-routing.hub',
            'Big Box Custom Job' => 'montreal-bigbox-routific.job',
            'Scan Order' => 'montreal-bigbox-trackingId.isInroute|montreal-bigbox-tracking.detail|montreal-bigbox-custom-create.order|montreal-bigbox-remove.trackingid|montreal-bigbox-custom-edit.order',
            'Clear Order' => 'montreal-bigbox-order.inroute',
            'Create Job Id ' => 'montreal-bigbox-create-route-custom.routing',
            'Delete Job ID' =>'montreal-bigbox-routific-job-delete.post',
            'Create Custom Route' =>'montreal-bigbox-job-createCustom-route.get',
            'Create Route' =>'montreal-bigbox-job-create-route.get',
            'Add Joey Vehicle' => 'montreal-bigbox-custom-add-joey.count|montreal-bigbox-custom-joey.count|montreal-bigbox-custom-joey-.count|montreal-bigbox-remove.joeycount',
            'Edit Joey Vehicle' => 'montreal-bigbox-custom-joey.count|montreal-bigbox-custom-joey-.count',
            'Remove Joey Vehicle' => 'montreal-bigbox-remove.joeycount',
            'Delete Record' => 'montreal-bigbox-remove.multipletrackingid',
            'Scan Order Create' => 'montreal-bigbox-custom-create.order',
            'Scan Order Remove' => 'montreal-bigbox-remove.trackingid',
            'Scan Order Edit' => 'montreal-bigbox-custom-edit.order',

        ],

    'Ottawa Big Box' =>
        [
            'Big Box Custom Routing' => 'ottawa-bigbox-custom-routing.hub',
            'Big Box Custom Job' => 'ottawa-bigbox-routific.job',
            'Scan Order' => 'ottawa-bigbox-trackingId.isInroute|ottawa-bigbox-tracking.detail|ottawa-bigbox-custom-create.order|ottawa-bigbox-remove.trackingid|ottawa-bigbox-custom-edit.order',
            'Clear Order' => 'ottawa-bigbox-order.inroute',
            'Create Job Id ' => 'ottawa-bigbox-create-route-custom.routing',
            'Delete Job ID' =>'ottawa-bigbox-routific-job-delete.post',
            'Create Custom Route' =>'ottawa-bigbox-job-createCustom-route.get',
            'Create Route' =>'ottawa-bigbox-job-create-route.get',
            'Add Joey Vehicle' => 'ottawa-bigbox-custom-add-joey.count|ottawa-bigbox-custom-joey.count|ottawa-bigbox-custom-joey-.count|ottawa-bigbox-remove.joeycount',
            'Edit Joey Vehicle' => 'ottawa-bigbox-custom-joey.count|ottawa-bigbox-custom-joey-.count',
            'Remove Joey Vehicle' => 'ottawa-bigbox-remove.joeycount',
            'Delete Record' => 'ottawa-bigbox-remove.multipletrackingid',
            'Scan Order Create' => 'ottawa-bigbox-custom-create.order',
            'Scan Order Remove' => 'ottawa-bigbox-remove.trackingid',
            'Scan Order Edit' => 'ottawa-bigbox-custom-edit.order',

        ],

    'CTC Big Box' =>
        [
            'Big Box Custom Routing' => 'ctc-bigbox-custom-routing.hub',
            'Big Box Custom Job' => 'ctc-bigbox-routific.job',
            'Scan Order' => 'ctc-bigbox-trackingId.isInroute|ctc-bigbox-tracking.detail|ctc-bigbox-custom-create.order|ctc-bigbox-remove.trackingid|ctc-bigbox-custom-edit.order',
            'Clear Order' => 'ctc-bigbox-order.inroute',
            'Create Job Id ' => 'ctc-bigbox-create-route-custom.routing',
            'Delete Job ID' =>'ctc-bigbox-routific-job-delete.post',
            'Create Custom Route' =>'ctc-bigbox-job-createCustom-route.get',
            'Create Route' =>'ctc-bigbox-job-create-route.get',
            'Add Joey Vehicle' => 'ctc-bigbox-custom-add-joey.count|ctc-bigbox-custom-joey.count|ctc-bigbox-custom-joey-.count|ctc-bigbox-remove.joeycount',
            'Edit Joey Vehicle' => 'ctc-bigbox-custom-joey.count|ctc-bigbox-custom-joey-.count',
            'Remove Joey Vehicle' => 'ctc-bigbox-remove.joeycount',
            'Delete Record' => 'ctc-bigbox-remove.multipletrackingid',
            'Scan Order Create' => 'ctc-bigbox-custom-create.order',
            'Scan Order Remove' => 'ctc-bigbox-remove.trackingid',
            'Scan Order Edit' => 'ctc-bigbox-custom-edit.order',

        ],

    'Zone Types' =>
        [
            'Zone Types List ' => 'zonestypes.index',
            'Create Zone Type' => 'zonestypes.add|zonestypes.create',
            'Update Zone Type' => 'zonestypes.edit|zonestypes.update',
            'Delete Zone Type' => 'zonestypes.delete',
        ],

    'Account Setting' =>
        [
            'Account Edit Profile' => 'admin.edit|admin.update',
            'Account Security' => 'account-security.edit|account-security.update',
            'Change Password' => 'password.edit|password.update',
        ],
'First Mile' => [
            'First Mile' => 'hub.list.stores|first.mile.job.ctc|first.mile.ctc.routes.list',
            'First Mile Hub List' => 'hub.list.stores',
            'First Mile Job List' => 'first.mile.job.ctc',
            'First Mile Route List' => 'first.mile.ctc.routes.list',
            'Create Job Id First Mile' => 'first.mile.route.store',
            'First Mile Slots list' => 'first.mile.slots.list',
            'Create First Mile Slots' => 'first.mile.slot.store',
            'First Mile Order Count' => 'first.mile.order.count',
            'Create Route For First Mile' => 'first.mile.create.route.ctc',
        ],
    'Other Action' =>
        [
            'Update Order Status' => 'update-multiple-trackingid.get|update-multiple-trackingid.update',
            'Search Orders' => 'search-trackingid-multiple.get',
            'Search Orders Update Status' => 'update-order-status.update',
            'Search Orders Detail' => 'search-orders-trackingid-details.get',
            'Order Image Upload' => 'sprint-image-upload',
            'Manual Status History' => 'manual-status.index',
            // 'Out For Delivery' => 'routific-outfordelivery.get',
            // 'Out For Delivery Status' => 'routific-outfordelivery.update',
            'Unattempt Orders' => 'mark-incomplete.get',
            'Remove Unattempt Orders' => 'mark-incomplete.post',
            'Enable For Routes' => 'enable-route.post|enable-route-forroute.post|custom-enable-trackingid.post|custom-upload-file.post|enable-route-file.get|enable-route-forroute.post',
            'Enable Route' => 'enable-route-forroute.post',
            'Enable Route TextField' => 'custom-enable-trackingid.post',
            'Enable Route UploadFile' =>'custom-upload-file.post|enable-route-file.get|enable-route-forroute.post'
        ],
    'Return Portal' =>
        [
            'Reattempt Order List' => 'reattempt-order.index|show-notes|reattempt-order-column-update|tracking-order.search|update-status-of-scanned-order',
            'Reattempt Order Search' => 'tracking-order.search|update-status-of-scanned-order',
            'Transfer to customer support' => 'transfer-order',
            'Scan for reattempt' => 'reattempt-order-id',
            'Remove' => 'reattempt-delete-id',
            'Customer Approved' => 'customer-support.approved|show-notes',
            'Customer Approved Scan for reattempt' => 'reattempt-order-id',
            'History' => 'reattempt-history.index|show-notes',
        ],
    'Report' =>
        [
            'Route Volume By Zone' => 'route-volume-state',
            'Tracking Report' => 'tracking-report',
            'Tracking Report Note' => 'tracking-note',

        ],
    'Montreal zones' =>
        [
            'Zones List' => 'montreal-zonestesting-list.index',
            'Edit' => 'montreal-zonestesting-update.update|montreal-zones-update.post',
            'Delete' => 'montreal-zonestesting-deletezone.delete',
            'Order Counts' => 'montreal-order-count-zone-date.index',
            'Zones List Order Counts' => 'montreal-total-order-notinroute.index',
            'Submit For Route' => 'montreal-routes.add',
          //  'Test Submit For Route'=>'montreal-routes.test-add',
            'View Slots ' => 'montreal-slot-list-hubid-get',
            'Create Zone' => 'montreal-zones-create.index',
            'Custom Routes Zones' => 'montreal-custom-routing-zones-list.index',
            'Custom Routes Edit' => 'montreal-zones-update.index|montreal-zones-update.post',
            'Custom Routes Delete' => 'montreal-zones-deletezone.delete',
            'Custom Routes Count' => 'montreal-customzones-list-count.index',
            'Custom Routes Submit For Route' => 'montreal-custom-montreal-routes.add',
            'Custom Routes Create Zone' => 'montreal-custom-routing-zones.create',
            'Create Slots ' => 'montreal-slot-create',
            'Edit Slots ' => 'montreal-slot-del-update|montreal-slot-update',
            'Delete Slots ' => 'montreal-slot-deleteslot',
            'Detail Slots ' =>'montreal-slot-detail',

        ],

    'Ottawa zones' =>
        [
            'Zones List' => 'ottawa-zonestesting-list.index',
            'Edit' => 'ottawa-zonestesting-update.update|ottawa-zones-update.post',
            'Delete' => 'ottawa-zonestesting-deletezone.delete',
            'Order Counts' => 'ottawa-order-count-zone-date.index',
            'Zones List Order Counts' => 'ottawa-total-order-notinroute.index',
            'Submit For Route' => 'ottawa-routes.add',
            'View Slots ' => 'ottawa-slot-list-hubid-get',
            'Create Zone' => 'ottawa-zones-create.index',
            'Custom Routes Zones' => 'ottawa-custom-routing-zones-list.index',
            'Custom Routes Edit' => 'ottawa-zones-update.index|ottawa-zones-update.post',
            'Custom Routes Delete' => 'ottawa-zones-deletezone.delete',
            'Custom Routes Count' => 'ottawa-customzones-list-count.index',
            'Custom Routes Submit For Route' => 'ottawa-custom-ottawa-routes.add',
            'Custom Routes Create Zone' => 'ottawa-custom-routing-zones.create',
            'Create Slots ' => 'ottawa-slot-create',
            'Edit Slots ' => 'ottawa-slot-del-update|ottawa-slot-update',
            'Delete Slots ' => 'ottawa-slot-deleteslot',
            'Detail Slots ' =>'ottawa-slot-detail',

        ],
    'CTC zones' =>
        [
            'Zones List' => 'ctc-zonestesting-list.index',
            'Edit' => 'ctc-zonestesting-update.update|ctc-zones-update.post',
            'Delete' => 'ctc-zonestesting-deletezone.delete',
            'Order Counts' => 'ctc-order-count-zone-date.index',
            'Zones List Order Counts' => 'ctc-total-order-notinroute.index',
            'Submit For Route' => 'ctc-routes.add',
            'View Slots ' => 'ctc-slot-list-hubid-get',
            'Create Zone' => 'ctc-zones-create.index',
            'Custom Routes Zones' => 'ctc-custom-routing-zones-list.index',
            'Custom Routes Edit' => 'ctc-zones-update.index|ctc-zones-update.post',
            'Custom Routes Delete' => 'ctc-zones-deletezone.delete',
            'Custom Routes Count' => 'ctc-customzones-list-count.index',
            'Custom Routes Submit For Route' => 'ctc-custom-ctc-routes.add',
            'Custom Routes Create Zone' => 'ctc-custom-routing-zones.create',
            'Create Slots ' => 'ctc-slot-create',
            'Edit Slots ' => 'ctc-slot-del-update|ctc-slot-update',
            'Delete Slots ' => 'ctc-slot-deleteslot',
            'Detail Slots ' =>'ctc-slot-detail',
            'Attach Micro Hub' => 'ctc-zones-microhub.add'

        ],

 'Failed Order' =>
        [
            'Montreal Amazon Failed Order' => 'amazon-failed-order.get',
            'Montreal Edit Order' => 'amazon-failed-order.post',
            'Montreal Create Selected Order' => 'amazon-create-all-order.post',
            'Ottawa Amazon Failed Order' => 'ottawa-amazon-failed-order.get',
            'Ottawa Edit Order' => 'ottawa-amazon-failed-order.post',
            'Ottawa Create Selected Order' => 'ottawa-amazon-create-all-order.post',
            'Toronto CTC Failed Order' => 'ctc-failed-order.get',
            'Toronto Failed Order Edit' => 'ctc-failed-order.post',
            'Toronto Failed Order Create Selected Order' => 'ctc-create-all-order.post',
            'Ottawa CTC Failed Order' => 'ottawa-ctc-failed-order.get',
            'Ottawa Failed Order Edit' => 'ottawa-ctc-failed-order.post',
            'Ottawa Failed Order Create Selected Order' => 'ottawa-ctc-create-all-order.post',

        ],
        
//  'Logistic Routing' =>
//         [
//             'Montreal Logistic Custom Routing' => 'montreal-logistic-custom-routing.index',
//             'Montreal Clear Order'=>'montreal-logistic-remove-order-inroute.post',
//             'Montreal Add Joeys Vehicle'=>'montreal-logistic-custom-add-joey-count.post',
//             'Montreal Edit Joeys Vehicle'=>'montreal-logistic-custom-joey-count.get|montreal-logistic-custom-edit-joey-count.post',
//             'Montreal Delete Joeys Vehicle'=>'montreal-logistic-remove-joeycount.post',
//             'Montreal Create Order'=>'montreal-logistic-custom-create-order.post',
//             'Montreal Edit Order'=>'montreal-logistic-custom-edit-order.post',
//             'Montreal Remove Order'=>'montreal-logistic-remove-trackingid.post',
//             'Montreal Create Job Id'=>'montreal-logistic-create-route-custom-routing.post',
//             'Montreal Scan Tracking Id'=>'montreal-logistic-tracking-detail.get',
//             'Montreal Job'=>'montreal-logistic-job.get',
//             'Montreal Create Route'=>'montreal-logistic-create-route.get',
//             'Montreal Delete Job Id'=>'montreal-logistic-routific-job-delete.post',
//             'Montreal Route'=>'montreal-logistic-routes.get',
//             'Montreal Route Details'=>'montreal-logistic-route-details.get',
//             'Montreal Current Route Map'=>'montreal-logistic-route-map.get',
//             'Montreal Remaining Route Map'=>'montreal-logistic-route-remaining.get',
//             'Montreal Edit Route'=>'montreal-logistic-route-edit-hub.get',
//             'Montreal Route History'=>'montreal-logistic-route-history.get',
//             'Montreal Delete Route'=>'montreal-logistic-route-delete-hub.get', 
//             'Montreal Route Transfer'=>'montreal-logistic-route-transfer.post',
//             'Montreal Re Route'=>'montreal-logistic-routes-hub-re-route.get',

//             'ottawa Logistic Custom Routing' => 'ottawa-logistic-custom-routing.index',
//             'Ottawa Clear Order'=>'ottawa-logistic-remove-order-inroute.post',
//             'Ottawa Add Joeys Vehicle'=>'ottawa-logistic-custom-add-joey-count.post',
//             'Ottawa Edit Joeys Vehicle'=>'ottawa-logistic-custom-joey-count.get|ottawa-logistic-custom-edit-joey-count.post',
//             'Ottawa Delete Joeys Vehicle'=>'ottawa-logistic-remove-joeycount.post',
//             'Ottawa Create Order'=>'ottawa-logistic-custom-create-order.post',
//             'Ottawa Edit Order'=>'ottawa-logistic-custom-edit-order.post',
//             'Ottawa Remove Order'=>'ottawa-logistic-remove-trackingid.post',
//             'Ottawa Create Job Id'=>'ottawa-logistic-create-route-custom-routing.post',
//             'Ottawa Scan Tracking Id'=>'ottawa-logistic-tracking-detail.get',
//             'Ottawa Job'=>'ottawa-logistic-job.get',
//             'Ottawa Create Route'=>'ottawa-logistic-create-route.get',
//             'Ottawa Delete Job Id'=>'ottawa-logistic-routific-job-delete.post',
//             'Ottawa Route'=>'ottawa-logistic-routes.get',
//             'Ottawa Route Details'=>'ottawa-logistic-route-details.get',
//             'Ottawa Current Route Map'=>'ottawa-logistic-route-map.get',
//             'Ottawa Remaining Route Map'=>'ottawa-logistic-route-remaining.get',
//             'Ottawa Edit Route'=>'ottawa-logistic-route-edit-hub.get',
//             'Ottawa Route History'=>'ottawa-logistic-route-history.get',
//             'Ottawa Delete Route'=>'ottawa-logistic-route-delete-hub.get', 
//             'Ottawa Route Transfer'=>'ottawa-logistic-route-transfer.post',
//             'Ottawa Re Route'=>'ottawa-logistic-routes-hub-re-route.get',

//             'CTC Logistic Custom Routing' => 'ctc-logistic-custom-routing.index',
//             'CTC Clear Order'=>'ctc-logistic-remove-order-inroute.post',
//             'CTC Add Joeys Vehicle'=>'ctc-logistic-custom-add-joey-count.post',
//             'CTC Edit Joeys Vehicle'=>'ctc-logistic-custom-joey-count.get|ctc-logistic-custom-edit-joey-count.post',
//             'CTC Delete Joeys Vehicle'=>'ctc-logistic-remove-joeycount.post',
//             'CTC Create Order'=>'ctc-logistic-custom-create-order.post',
//             'CTC Edit Order'=>'ctc-logistic-custom-edit-order.post',
//             'CTC Remove Order'=>'ctc-logistic-remove-trackingid.post',
//             'CTC Create Job Id'=>'ctc-logistic-create-route-custom-routing.post',
//             'CTC Scan Tracking Id'=>'ctc-logistic-tracking-detail.get',
//             'CTC Job'=>'ctc-logistic-job.get',
//             'CTC Create Route'=>'ctc-logistic-create-route.get',
//             'CTC Delete Job Id'=>'ctc-logistic-routific-job-delete.post',
//             'CTC Route'=>'ctc-logistic-routes.get',
//             'CTC Route Details'=>'ctc-logistic-route-details.get',
//             'CTC Current Route Map'=>'ctc-logistic-route-map.get',
//             'CTC Remaining Route Map'=>'ctc-logistic-route-remaining.get',
//             'CTC Edit Route'=>'ctc-logistic-route-edit-hub.get',
//             'CTC Route History'=>'ctc-logistic-route-history.get',
//             'CTC Delete Route'=>'ctc-logistic-route-delete-hub.get', 
//             'CTC Route Transfer'=>'ctc-logistic-route-transfer.post',
//             'CTC Re Route'=>'ctc-logistic-routes-hub-re-route.get',
//         ],
    'Hub' =>
        [
            'Hub List' => 'hub.get',
            'Add' => 'hub-add.get|hub-create.post',

            // 'Edit' => 'hub-edit.get|hub-update.put',
            // 'Delete' => 'hub-deletehub.post',
        ],

    'Hub Store' => [
        'Hub Store List' => 'hub.list.zones',
        'Hub Store Create' => 'hub.zone.vendor|hub.stores|hub.stores.post',
        'Attach Zones' => 'attach.zones',
    ],

    'Mid Mile' => [
        'Mid Mile Joey List' => 'index',
    ],

    'Micro Hub' =>
        [
            'Micro Hub Request List' => 'microhub-routes-hub-request.get',
            'Micro Hub Request' => 'create-micro-hub.get',
            'Create Micro Hub' => 'create-micro-hub.post',
            'Declined' => 'micro-hub-request-declined.post',

            'View Slot' => 'micro-hub-slot-list-hubid.get',
            'Create Slot' => 'micro-hub-slot-create.post',
            'Slot Edit' => 'micro-hub-slot-update.post|micro-hub-slot-update.get',
            'Slot Detail' => 'micro-hub-slot-detail.get',
            'Slot Delete' => 'micro-hub-slot-deleteslot.post',

            'Zone List'=>'micro-hub-zones.get',
            'Create Zone'=>'micro-hub-zones-create.post',
            'Update Zone'=>'micro-hub-zones-update.get|micro-hub-zones-update.post',
            'Delete Zone'=>'micro-hub-zones-delete.post',
            'Zone Order Count'=>'micro-hub-zones-count.get|micro-hub-ottawa-routes-add.post|micro-hub-montreal-routes-add.post|micro-hub-ctc-routes-add.post',
            'Order Not in Route'=>'micro-hub-total-order-notinroute.post',
            'Submit For Route'=>'micro-hub-ottawa-routes-add.post|micro-hub-montreal-routes-add.post|micro-hub-ctc-routes-add.post',

            'Routific Job'=>'micro-hub-routific-job.get',
            'Delete Job Id'=>'micro-hub-routific-job-delete.post',
            'Create Route'=>'micro-hub-create-route.get|micro-hub-job-createCustom-route.get',

            'Routes'=>'micro-hub-routes.get',
            'Route Detail'=>'micro-hub-route-details.get',
            'Edit Route'=>'route-micro-hub-edit-hub.get',
            'Route Map'=>'micro-hub-route-map.get',
            'Route Map Remaining'=>'micro-hub-route-remaining.get',
            'Delete Route'=>'micro-hub-route-delete.get',
            'Re Route'=>'micro-hub-re-route.get',
            'Route History'=>'micro-hub-routes-route-history.get',
            'Whole Map'=>'micro-hub-routes-route-map-location.post|micro-hub-allroute-locations.get',
            'Route Transfer' =>'micro-hub-routes-route-transfer.post',
        ],
    // 'Beta Routific' =>
    //     [
    //         'Montreal Custom Routing' => 'beta-montreal-custom-routing.index',
    //         'Montreal Create Order'=>'beta-montreal-custom-create-order.post',
    //         'Montreal Edit Joeys Vehicle'=>'beta-montreal-custom-joey-count.get|beta-montreal-custom-edit-joey-count.post',
    //         'Montreal Delete Joeys Vehicle'=>'beta-montreal-custom-remove-joey-count.post',
    //         'Montreal Clear Order'=>'beta-montreal-custom-remove-order.post',
    //         'Montreal Create Route'=>'beta-montreal-create-route-custom-routing.post',
    //         'Montreal Scan Tracking Id'=>'beta-montreal-tracking-detail.get',
    //         'Montreal Add Joeys Vehicle'=>'beta-montreal-custom-add-joey-count.post',
    //         'Montreal Edit Order'=>'beta-montreal-custom-edit-order.post',
    //         'Montreal Remove Order'=>'beta-montreal-remove-trackingid.post',
    //         'Montreal Create Job Id'=>'beta-montreal-custom-create-routing.post',
    //         'Montreal Scanned Order Deleted' => 'beta-montreal-remove-multiple-tracking-id.post',
    //         'Montreal Job'=>'beta-montreal-routific-job.get',
    //         'Montreal Mark Deliverd Order Reattempt'=>'beta-montreal-markdeliveryreattempt-trackingid.post',
    //         'Montreal Update Status To Create Reattempt'=>'beta-montreal-update-status-create-reattempt.post',
    //         'Montreal Create Reattempt'=>'beta-montreal-create-reattempt.post',
            
    //         'Montreal Delete Job Id'=>'beta-montreal-routific-job-delete.post',
    //         'Montreal Route'=>'beta-montreal-routes.get',
    //         'Montreal Route Details'=>'beta-montreal-route-details.get',
    //         'Montreal Current Route Map'=>'beta-montreal-route-map.get',
    //         'Montreal Remaining Route Map'=>'beta-montreal-route-remaining.get',
    //         'Montreal Edit Route'=>'beta-montreal-route-edit-hub.get',
    //         'Montreal Route History'=>'beta-montreal-route-history.get',
    //         'Montreal Delete Route'=>'beta-montreal-route-delete-hub.get', 
    //         'Montreal Route Transfer'=>'beta-montreal-route-transfer.post',
    //         'Montreal Remove Multiple Scan Orders'=>'beta-montreal-custom-remove-multiple-tracking-id.post',
            

    //         'ottawa Custom Routing' => 'beta-ottawa-custom-routing.index',
    //         'Ottawa Clear Order'=>'beta-ottawa-custom-remove-order.post',
    //         'Ottawa Add Joeys Vehicle'=>'beta-ottawa-add-joey-count.post',
    //         'Ottawa Edit Joeys Vehicle'=>'beta-ottawa-custom-joey-count.get|beta-ottawa-custom-edit-joey-count.post',
    //         'Ottawa Delete Joeys Vehicle'=>'beta-ottawa-remove-joeycount.post',
    //         'Ottawa Create Order'=>'beta-ottawa-custom-create-order.post',
    //         'Ottawa Edit Order'=>'beta-ottawa-custom-edit-order.post',
    //         'Ottawa Remove Order'=>'beta-ottawa-remove-trackingid.post',
    //         'Ottawa Create Job Id'=>'beta-ottawa-custom-create-routing.post',
    //         'Ottawa Scan Tracking Id'=>'beta-ottawa-tracking-detail.get',
    //         'Ottawa Create Reattempt'=>'beta-ottawa-create-reattempt.post',
    //         'Ottawa Job'=>'beta-ottawa-job.get',
    //         'Ottawa Mark Deliverd Order Reattempt'=>'beta-ottawa-markdeliveryreattempt-trackingid.post',
    //         'Ottawa Update Status To Create Reattempt'=>'beta-ottawa-update-status-create-reattempt.post',
    //         'Ottawa Create Route'=>'beta-ottawa-createCustom-route.get',
    //         'Ottawa Delete Job Id'=>'beta-ottawa-routific-job-delete.post',
    //         'Ottawa Route'=>'beta-ottawa-routes.get',
    //         'Ottawa Route Details'=>'beta-ottawa-route-details.get',
    //         'Ottawa Current Route Map'=>'beta-ottawa-route-map.get',
    //         'Ottawa Remaining Route Map'=>'beta-ottawa-route-remaining.get',
    //         'Ottawa Edit Route'=>'beta-ottawa-route-edit-hub.get',
    //         'Ottawa Route History'=>'beta-ottawa-route-history.get',
    //         'Ottawa Delete Route'=>'beta-ottawa-route-delete-hub.get', 
    //         'Ottawa Route Transfer'=>'beta-ottawa-route-transfer.post',
    //         'Ottawa Remove Multiple Scan Orders'=>'beta-ottawa-custom-remove-multiple-tracking-id.post',

    //         'CTC Custom Routing' => 'beta-ctc-custom-routing.index',
    //         'CTC Clear Order'=>'beta-ctc-custom-remove-order.post',
    //         'CTC Add Joeys Vehicle'=>'beta-ctc-custom-add-joey-count.post',
    //         'CTC Edit Joeys Vehicle'=>'beta-ctc-custom-joey-count.get|beta-ctc-custom-edit-joey-count.post',
    //         'CTC Delete Joeys Vehicle'=>'beta-ctc-custom-remove-joey-count.post',
    //         'CTC Create Order'=>'beta-ctc-custom-create-order.post',
    //         'CTC Edit Order'=>'beta-ctc-custom-edit-order.post',
    //         'CTC Remove Order'=>'beta-ctc-remove-trackingid.post',
    //         'CTC Create Job Id'=>'beta-ctc-custom-create-routing.post',
    //         'CTC Scan Tracking Id'=>'beta-ctc-tracking-detail.get',
    //         'CTC Create Reattempt'=>'beta-ctc-create-reattempt.post',
    //         'CTC Job'=>'beta-ctc-job.get',
    //         'CTC Mark Deliverd Order Reattempt'=>'beta-ctc-markdeliveryreattempt-trackingid.post',
    //         'CTC Update Status To Create Reattempt'=>'beta-ctc-update-status-create-reattempt.post',
    //         'CTC Create Route'=>'beta-ctc-createCustom-route.get',
    //         'CTC Delete Job Id'=>'beta-ctc-routific-job-delete.post',
    //         'CTC Route'=>'beta-ctc-routes.get',
    //         'CTC Route Details'=>'beta-ctc-route-details.get',
    //         'CTC Current Route Map'=>'beta-ctc-route-map.get',
    //         'CTC Remaining Route Map'=>'beta-ctc-route-remaining.get',
    //         'CTC Edit Route'=>'beta-ctc-route-edit-hub.get',
    //         'CTC Route History'=>'beta-ctc-route-history.get',
    //         'CTC Delete Route'=>'beta-ctc-route-delete-hub.get', 
    //         'CTC Route Transfer'=>'beta-ctc-route-transfer.post',
    //         'CTC Remove Multiple Scan Orders'=>'beta-ctc-custom-remove-multiple-tracking-id.post'
    //     ],
        'Order Limit' =>
        [
            'Montreal Order Limit' => 'montreal-order-limit-control.get',
            'Montreal Enable For Route' => 'montreal-enable-for-route.post',
            'Montreal Mark Return Merchant' => 'montreal-mark-return-merchant.post',
            'Ottawa Order Limit' => 'ottawa-order-limit-control.get',
            'Ottawa Enable For Route' => 'ottawa-enable-for-route.post',
            'Ottawa Mark Return Merchant' => 'ottawa-mark-return-merchant.post',
            'CTC Order Limit' => 'ctc-order-limit-control.get',
            'CTC Enable For Route' => 'ctc-enable-for-route.post',
            'CTC Mark Return Merchant' => 'ctc-mark-return-merchant.post',

        ],
];