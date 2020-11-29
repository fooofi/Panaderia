<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [API\FairUserController::class, 'create'])->name('register');

Route::post('verifyemail', [API\FairUserController::class, 'validateEmail'])->name('verify_email');
Route::post('resendverifyemail', [API\FairUserController::class, 'resendValidateEmail'])->name('resend_verify_email');

Route::post('recoverpassword', [API\FairUserController::class, 'recoverPassword'])->name('recover_password');
Route::post('sendrecoverypassword', [API\FairUserController::class, 'sendResetPasswordEmail'])->name(
    'send_recover_password'
);
Route::post('/contact', [API\ContactController::class, 'sendContact'])->name('contact.send');
Route::get('/contact/types', [API\ContactController::class, 'types'])->name('contact.types');

Route::get('/files/{id}', [API\FileController::class, 'show'])->name('files.show')->where('id', '[0-9]+');
Route::get('/countries', [API\LocationController::class, 'countries'])->name('countries');
Route::get('/countries/{country_id}/regions', [API\LocationController::class, 'regions'])->name('regions');
Route::get('/countries/{country_id}/regions/{region_id}/provinces', [API\LocationController::class, 'provinces'])->name(
    'provinces'
);
Route::get('/countries/{country_id}/regions/{region_id}/provinces/{province_id}/communes', [
    API\LocationController::class,
    'communes',
])->name('communes');

Route::get('/regions', [API\LocationController::class, 'allRegions'])->name('regions.all');
Route::get('/grades', [API\FairSurveyController::class, 'grades'])->name('grades');
Route::get('/career_types', [API\CareerTypeController::class, 'show'])->name('career_types');
Route::get('/areas', [API\AreaController::class, 'show'])->name('areas');
Route::get('/schools/search', [API\SearchController::class, 'schools'])->name('search.schools');
Route::get('/communes/search', [API\SearchController::class, 'communes'])->name('search.communes');
Route::get('/careers/search', [API\SearchController::class, 'careers'])->name('search.careers');
Route::group(
    [
        'prefix' => 'institutions',
        'as' => 'institutions.',
    ],
    function () {
        Route::get('', [API\InstitutionController::class, 'index'])->name('index');
        Route::get('random8', [API\InstitutionController::class, 'random8'])->name('random8');
        Route::get('/types', [API\InstitutionController::class, 'types'])->name('types');
        Route::get('/regions', [API\InstitutionController::class, 'byRegion'])->name('regions');
        Route::get('/{id}', [API\InstitutionController::class, 'show'])->name('show');
        Route::get('/{institution_id}/campuses/{campus_id}', [API\CampusController::class, 'show'])->name(
            'campuses.show'
        );
    }
);

Route::get('/institution/{institution_id}/campuses/{campus_id}/career/{career_id}', [
    API\CareerController::class,
    'show',
])->name('career.show');

Route::group(
    [
        'middleware' => ['auth:api', 'role:fairuser'],
        'prefix' => 'fairuser',
        'as' => 'fairuser.',
    ],
    function () {
        // Fair User Protected Routes.

        Route::get('', [API\FairUserController::class, 'index'])->name('index');
        Route::post('edit', [API\FairUserController::class, 'edit'])->name('edit');
        Route::post('password', [API\FairUserController::class, 'password'])->name('password');
        Route::post('survey', [API\FairSurveyController::class, 'store'])->name('survey.store');
        Route::get('survey', [API\FairSurveyController::class, 'index'])->name('survey.index');
        Route::post('contact', [API\ContactController::class, 'create'])->name('contact');
        Route::get('chat/token', [API\ChatController::class, 'getToken'])->name('chat.token');
    }
);
