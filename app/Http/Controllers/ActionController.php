<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Action;
use App\Models\ActionDetail;

class ActionController extends Controller
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

        
        $action = Action::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'challenge_id' => $data['challenge_id']

        ]);
        
        $action_id = $action['id'];
        $adetails = [];
        foreach($data['details'] as $detail){
            $actiondetail = ActionDetail::create([
                'action_id' => $action_id,
                'field' => $detail['field'],
                'data' => $detail['data']
    
            ]);
            array_push($adetails,$actiondetail);
        }

        $response = [
            'action' => $action,
            'action details' => $adetails
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
        //
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
