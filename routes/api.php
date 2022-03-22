<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

#public routes
Route::post('/register',[AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/getallchallenges','ChallengeController@get_all_challenges');
Route::get('/getallchallengeparticipants/{challenge_id}','ParticipantController@get_all_participants');
Route::get('/getpublicnewsfeed','NewsfeedController@get_public_newsfeed');
Route::post('/uploadFile','uploadController@upload');

#protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    #profile
    Route::resource('userprofile','UserProfileController');

    #challenges
    Route::patch('challenge/{challenge_id}','ChallengeController@update');
    Route::resource('challenge','ChallengeController');
    Route::resource('action','ActionController');
    Route::resource('tracking','TrackingController');
    Route::get('/userchallenge/{user_id}','ChallengeController@get_challenge_by_user');
    Route::get('/gettemplates/{user_id}','ChallengeController@get_challenge_template_per_user');

    #participants
    Route::patch('participant','ParticipantController@update');
    Route::resource('participant','ParticipantController');

    #Friend List
    Route::resource('friendlist','FriendlistController');
    Route::post('/friend/approve/{request_id}','FriendlistController@approve_request');
    Route::post('/friend/follow','FriendlistController@follow_user');
    Route::get('get_friends/{id}','FriendlistController@get_friends');

    #Newsfeed
    Route::patch('newsfeed/{id}','NewsfeedController@update');
    Route::get('/getnewsfeed/{id}','NewsfeedController@get_user_newsfeed');
    Route::post('/addreaction/{id}','NewsfeedController@add_reaction');
    Route::resource('newsfeed','NewsfeedController');

    #Comments
    Route::patch('newsfeed_comment/{id}','NewsfeedCommentController@update');
    Route::get('/getnewsfeed_comments/{id}','NewsfeedCommentController@get_post_comments');
    Route::post('/addreaction_comment/{id}','NewsfeedCommentController@add_reaction');
    Route::resource('newsfeed_comment','NewsfeedCommentController');

    Route::patch('challenge_comment/{id}','ChallengeCommentController@update');
    Route::get('/getchallenge_comments/{id}','ChallengeCommentController@get_challenge_comments');
    Route::post('/addchallengereaction_comment/{id}','ChallengeCommentController@add_reaction');
    Route::resource('challenge_comment','ChallengeCommentController');
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
