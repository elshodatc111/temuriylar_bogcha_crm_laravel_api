<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    EmploesController,
    RoomController,
    SettingController,
    ChildController,
    KassaController,
    GroupsController,
};
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::get('/check-token', [AuthController::class, 'checkToken']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/rooms', [RoomController::class, 'index']);
    Route::post('/room-create', [RoomController::class, 'create']);
    Route::post('/room-delete', [RoomController::class, 'delete']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/emploes', [EmploesController::class, 'index']);
    Route::get('/emploes-end', [EmploesController::class, 'index_end']);
    Route::get('/get-position', [EmploesController::class, 'get_position']);
    Route::post('/emploes-create', [EmploesController::class, 'create']);
    Route::post('/emploes-paymart', [EmploesController::class, 'create_paymart']);
    Route::post('/emploes-paymart-meneger', [EmploesController::class, 'create_paymart_meneger']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/setting-sms', [SettingController::class, 'sms']);
    Route::post('/setting-sms-update', [SettingController::class, 'sms_update']);
    Route::get('/setting-paymart', [SettingController::class, 'paymart']);
    Route::post('/setting-paymart-update', [SettingController::class, 'paymart_update']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/child-all', [ChildController::class, 'child_all']);
    Route::get('/child-debet', [ChildController::class, 'child_debet']);
    Route::get('/child-end', [ChildController::class, 'child_end']);
    Route::get('/child-active', [ChildController::class, 'child_active']);
    Route::post('/child-create', [ChildController::class, 'create']);
    Route::get('/child-show/{id}', [ChildController::class, 'show']);
    Route::get('/child-show-document/{id}', [ChildController::class, 'showDocument']);
    Route::post('/child-show-document-delete', [ChildController::class, 'showDocumentDelete']);
    Route::get('/child-show-qarindosh/{id}', [ChildController::class, 'showQarindosh']);
    Route::post('/child-show-qarindosh-delete', [ChildController::class, 'showQarindoshDelete']);
    Route::get('/child-all-paymart/{id}', [ChildController::class, 'all_paymart']);
    Route::get('/child-all-paymarts', [ChildController::class, 'all_paymarts']);
    Route::post('/child-create-document', [ChildController::class, 'create_document']);
    Route::post('/child-create-paymart', [ChildController::class, 'create_paymart']);
    Route::post('/child-create-qarindosh', [ChildController::class, 'create_qarindosh']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/kassa-get', [KassaController::class, 'kassa']);
    Route::post('/kassa-success-paymart', [KassaController::class, 'success_paymart']);
    Route::post('/kassa-chiqim', [KassaController::class, 'chiqim_post']);
    Route::post('/kassa-chiqim-cancel', [KassaController::class, 'cancel_chiqim']);
    Route::post('/kassa-chiqim-success', [KassaController::class, 'success_chiqim']);
    Route::post('/kassa-ish-haqi-success', [KassaController::class, 'success_ishHaqi']);
    Route::post('/kassa-ish-haqi-cancel', [KassaController::class, 'cancel_ishHaqi']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/group-active', [GroupsController::class, 'indexAktive']);
    Route::get('/group-end', [GroupsController::class, 'indexEnd']);
    Route::get('/group-show/{id}', [GroupsController::class, 'show']);
    Route::get('/group-get-room', [GroupsController::class, 'getRoom']);
    Route::post('/group-create', [GroupsController::class, 'create']);
    Route::get('/group-show-update/{id}', [GroupsController::class, 'showGroup']);
    Route::post('/group-update', [GroupsController::class, 'update']);
    Route::get('/group-hodim-new', [GroupsController::class, 'getNewHodim']);
    Route::post('/group-add-hodim', [GroupsController::class, 'createHodim']);
    Route::get('/group-hodim-show/{id}', [GroupsController::class, 'getAktiveHodim']);
    Route::post('/group-end-hodim', [GroupsController::class, 'deleteHodim']);
    Route::get('/group-new-child', [GroupsController::class, 'getNewChild']);
    Route::post('/group-add-child', [GroupsController::class, 'createChild']);
    Route::get('/group-active-child/{id}', [GroupsController::class, 'activeChild']);
    Route::post('/group-end-child', [GroupsController::class, 'deleteChild']);
    Route::post('/group-create-davomad', [GroupsController::class, 'createDavomat']);
});
