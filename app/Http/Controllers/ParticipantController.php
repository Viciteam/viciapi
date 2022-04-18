<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
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

        $participant = Participant::create([
            'challenge_id' => $data['challenge_id'],
            'user_id' => $data['user_id'],
            'status' => $data['status']

        ]);
        $response = [
            'participant' => $participant
        ];
        $code = 201;

        return response($response, $code);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function show(Participant $participant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function edit(Participant $participant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();

        $participanttemp = Participant::where('user_id', $data["user_id"])
            ->where('challenge_id', $data["challenge_id"])
            ->first()->get(['id']);
        # die(json_encode($participanttemp[0]->id));

        $participant = Participant::find($participanttemp[0]->id);
        $participant->status = $data["status"];
        $participant->save();
        $response = [
            'participant' => $participant
        ];
        $code = 200;

        return response($response, $code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Participant $participant)
    {
        //
    }

    public function get_all_participants($challenge_id)
    {
        $participants = Participant::join('user_profiles', 'user_profiles.user_id', '=', 'participants.user_id')
            ->select('participants.*', 'user_profiles.profpic_link as profpic_link', 'user_profiles.name as name_of_user', 'user_profiles.username as user_name')
            ->join('challenges', 'challenges.id', '=', 'participants.challenge_id')
            ->where('challenge_id', $challenge_id)
            ->paginate(10);
        $response = [
            'participants' => $participants
        ];
        $code = 200;


        return response($response, $code);
    }

    public function get_all_active_participants($challenge_id)
    {
        $participants = Participant::join('user_profiles', 'user_profiles.user_id', '=', 'participants.user_id')
            ->select('participants.*', 'user_profiles.profpic_link as profpic_link', 'user_profiles.name as name_of_user', 'user_profiles.username as user_name')
            ->join('challenges', 'challenges.id', '=', 'participants.challenge_id')
            ->where('challenge_id', $challenge_id)
            ->where('status', 'Active')
            ->paginate(10);
        $response = [
            'participants' => $participants
        ];
        $code = 200;

        return response($response, $code);
    }

    public function get_all_quit_participants($challenge_id)
    {
        $participants = Participant::join('user_profiles', 'user_profiles.user_id', '=', 'participants.user_id')
            ->select('participants.*', 'user_profiles.profpic_link as profpic_link', 'user_profiles.name as name_of_user', 'user_profiles.username as user_name')
            ->join('challenges', 'challenges.id', '=', 'participants.challenge_id')
            ->where('challenge_id', $challenge_id)
            ->where('status', 'Quit')
            ->paginate(10);
        $response = [
            'participants' => $participants
        ];
        $code = 200;

        return response($response, $code);
    }

    public function get_all_not_active_participants($challenge_id)
    {
        $participants = Participant::join('user_profiles', 'user_profiles.user_id', '=', 'participants.user_id')
            ->select('participants.*', 'user_profiles.profpic_link as profpic_link', 'user_profiles.name as name_of_user', 'user_profiles.username as user_name')
            ->join('challenges', 'challenges.id', '=', 'participants.challenge_id')
            ->where('challenge_id', $challenge_id)
            ->where('status','!=', 'Active')
            ->paginate(10);
        $response = [
            'participants' => $participants
        ];
        $code = 200;

        return response($response, $code);
    }

    public function get_participants($challenge_id,$status)
    {
        $participants = Participant::join('user_profiles', 'user_profiles.user_id', '=', 'participants.user_id')
            ->select('participants.*', 'user_profiles.profpic_link as profpic_link', 'user_profiles.name as name_of_user', 'user_profiles.username as user_name')
            ->join('challenges', 'challenges.id', '=', 'participants.challenge_id')
            ->where('challenge_id', $challenge_id)
            ->where('status', $status)
            ->paginate(10);
        $response = [
            'participants' => $participants
        ];
        $code = 200;

        return response($response, $code);
    }
}
