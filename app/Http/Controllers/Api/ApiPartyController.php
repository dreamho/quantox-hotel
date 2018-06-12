<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.6.18.
 * Time: 09.28
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\SaveParty;
use Illuminate\Http\JsonResponse;
use App\Model\Party;
use App\Http\Resources\Party as PartyResource;

/**
 * Class ApiPartyController
 * @package App\Http\Controllers\Api
 */
class ApiPartyController extends Controller
{
    /**
     * Saving new Party
     * @param SaveParty $request
     * @return PartyResource|JsonResponse
     */
    public function saveParty(SaveParty $request){
        $imageName = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('/images'), $imageName);
        try {
            $party = new Party();
            $party->name = $request->name;
            $party->description = $request->description;
            $party->date = $request->date;
            $party->tags = $request->tags;
            $party->capacity = $request->capacity;
            $party->length = $request->length;
            $party->image = $imageName;
            $party->user_id = $request->user_id;
            $party->save();
            return new PartyResource($party);
        } catch (\Exception $exception) {
            return new JsonResponse("Something went wrong", 400);
        }
    }
}