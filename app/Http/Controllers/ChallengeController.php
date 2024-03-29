<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Challenge;
use App\Models\ChallengeDetail;
use App\Models\Action;
use App\Models\Tracking;
use App\Models\UserProfile;
use App\Models\ActionDetail;
use App\Models\TrackingDetail;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        #save challenge first and get challenge id


        $challenge = Challenge::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'is_template' => $data['is_template'],
            'owner_id' => $data['owner_id']

        ]);

        $challenge_id = $challenge['id'];
        $cdetails = [];
        foreach ($data['details'] as $detail) {
            $challengedetail = ChallengeDetail::create([
                'challenge_id' => $challenge_id,
                'field' => $detail['field'],
                'data' => $detail['data']

            ]);
            array_push($cdetails, $challengedetail);
        }

        $response = [
            'challenge' => $challenge,
            'challenge details' => $cdetails
        ];
        $code = 201;

        return response($response, $code);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        #get challenges per challenge_id
        $challenge_id = $id;

        $challenges = Challenge::where('id', $challenge_id)->get();
        $userchallenges = [];
        foreach ($challenges as $challenge) {
            $challenge_id = $challenge->id;

            $details = ChallengeDetail::where('challenge_id', $challenge_id)->get();
            $challenge['challenge_details'] = $details;
            $actions = Action::where('challenge_id', $challenge_id)->get();
            $challenge['actions'] = $actions;
            foreach ($actions as $action) {
                $action_id = $action->id;
                $action_detail = ActionDetail::where('action_id', $action->id)->get();
                $action['action_details'] = $action_detail;
                $trackings = Tracking::where('action_id', $action->id)->get();
                $action['trackings'] = $trackings;
                foreach ($trackings as $tracking) {
                    $tracking_detail = TrackingDetail::where('tracking_id', $tracking->id)->get();
                    $tracking["tracking_detail"] = $tracking_detail;
                }
            }


            array_push($userchallenges, $challenge);
        }

        $response = [
            'challenges' => $userchallenges
        ];
        $code = 200;

        return response($response, $code);
    }

    public function get_challenge_by_user($id)
    {
        $user_id = $id;

        $challenges = Challenge::where('owner_id', $user_id)->get();
        $userchallenges = [];
        foreach ($challenges as $challenge) {
            $challenge_id = $challenge->id;

            $actions = Action::where('challenge_id', $challenge_id)->get();
            $challenge['actions'] = $actions;
            foreach ($actions as $action) {
                $action_id = $action->id;
                $tracking = Tracking::where('action_id', $action->id)->get();

                $action['trackings'] = $tracking;
            }


            array_push($userchallenges, $challenge);
        }

        $response = [
            'challenges' => $userchallenges
        ];
        $code = 200;

        return response($response, $code);
    }

    public function get_challenge_template_per_user($id)
    {
        $user_id = $id;

        $challenges = Challenge::where('owner_id', $user_id)
            ->where('is_template', 'yes')
            ->get();
        $userchallenges = [];
        foreach ($challenges as $challenge) {
            $challenge_id = $challenge->id;

            $actions = Action::where('challenge_id', $challenge_id)->get();
            $challenge['actions'] = $actions;
            foreach ($actions as $action) {
                $action_id = $action->id;
                $tracking = Tracking::where('action_id', $action->id)->get();

                $action['trackings'] = $tracking;
            }


            array_push($userchallenges, $challenge);
        }

        $response = [
            'challenges' => $userchallenges
        ];
        $code = 200;

        return response($response, $code);
    }

    public function get_all_challenges()
    {


        $challenges = Challenge::join('user_profiles', 'user_profiles.user_id', '=', 'challenges.owner_id')
            ->select('challenges.*', 'user_profiles.profpic_link as profpic_link', 'user_profiles.name as name_of_user', 'user_profiles.username as user_name')
            ->latest('challenges.created_at')
            ->paginate(10);

        $userchallenges = [];
        foreach ($challenges as $challenge) {
            $challenge_id = $challenge->id;

            $actions = Action::where('challenge_id', $challenge_id)->get();

            $details = ChallengeDetail::where('challenge_id', $challenge_id)->get();
            $challenge['challenge_details'] = $details;
            $challenge['actions'] = $actions;
            foreach ($actions as $action) {
                $action_id = $action->id;
                $tracking = Tracking::where('action_id', $action->id)->get();
                $action['trackings'] = $tracking;
            }


            array_push($userchallenges, $challenge);
        }

        $response = [
            'challenges' => $userchallenges,
            'challenge meta' => $challenges
        ];
        $code = 200;

        return response($response, $code);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = $request->all();
        $challenge = Challenge::find($id);

        $challenge->name = $data['name'];
        $challenge->description = $data['description'];
        $challenge->is_template = $data['is_template'];
        $challenge->owner_id = $data['owner_id'];
        $challenge->save();

        $challenge_id = $challenge['id'];
        $cdetails = [];
        foreach ($data['details'] as $detail) {
            $challengedetail = ChallengeDetail::create([
                'challenge_id' => $challenge_id,
                'field' => $detail['field'],
                'data' => $detail['data']

            ]);
            array_push($cdetails, $challengedetail);
        }

        $response = [
            'challenge' => $this->show($id)
        ];
        $code = 200;

        return response($response, $code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
