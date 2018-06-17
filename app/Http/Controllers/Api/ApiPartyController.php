<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.6.18.
 * Time: 09.28
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\EditParty;
use App\Http\Requests\SaveParty;
use App\Model\Song;
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
    public function saveParty(SaveParty $request)
    {

        $previous_party = Party::latest()->first();
        $previous_party_song = $previous_party ? $previous_party->songs()->latest()->first() : null;
        //return $previous_party_song;

        try {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('/images'), $imageName);
            $party = new Party();
            $party->name = $request->name;
            $party->description = $request->description;
            $party->date = $request->date;
            $party->tags = $request->tags;
            $party->capacity = $request->capacity;
            $party->length = $request->length;
            $party->image = $imageName;
            $party->user_id = $request->user()->id;
            $party->save();

            $songs = Song::inRandomOrder()->get();
            $total = $party->length * 60;
            $duration = 0;
            $array = [];
            if (isset($previous_party_song)) {
                $start = ($songs[0]->track == $previous_party_song->track) ? 1 : 0;
            } else {
                $start = 0;
            }
            $song_list = $this->createPlaylist($start, $songs, $duration, $total, $array);

            foreach ($song_list as $song) {
                $party->songs()->attach($song->id);
            }
            return new PartyResource($party);
        } catch (\Exception $exception) {
            return new JsonResponse("Something went wrong", 400);
        }
    }

    /**
     *
     * @param $date
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getParties($date=null)
    {
        if(!isset($date)){
            return PartyResource::collection(Party::all());
        }
        $current_date = date('Y-m-d');
        $parties = Party::where('date', '>=', $current_date)->orderBy('date', 'asc')->get();
        return PartyResource::collection($parties);
    }

    /**
     * Creating list of songs for the party
     * @param $start
     * @param $songs
     * @param $duration
     * @param $total
     * @param $array
     * @param string $last_song
     * @return array
     */
    public function createPlaylist($start, $songs, $duration, $total, $array, $last_song = "")
    {
        for ($i = $start; $i < count($songs); $i++) {
            if (($last_song != "") && ($i == 0) && ($last_song->track == $songs[$i]->track)) {
                continue;
            }
            if ($duration <= $total) {
                $duration += $songs[$i]->length;
                if ($duration > $total) {
                    break;
                }
                $array[] = $songs[$i];
            }
        }
        if ($duration < $total) {
            $last_song = $array[count($array) - 1];
            return $this->createPlaylist($start = 0, $songs, $duration, $total, $array, $last_song);
        }
        return $array;
    }

    /**
     * Update party description, tags and image
     * @param $id
     * @param EditParty $request
     * @return PartyResource|JsonResponse
     */
    public function updateParty($id, EditParty $request)
    {
        try {
            $party = Party::find($id);
            $party->description = $request->description;
            $party->tags = $request->tags;
            if(isset($request->image)){
                if(file_exists('images/' . $party->image)) {
                    unlink('images/' . $party->image);
                }
                $imageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('/images'), $imageName);
                $party->image = $imageName;
            }
            $party->user_id = $request->user()->id;
            $party->save();
            return new PartyResource($party);
        } catch (\Exception $exception) {
            return new JsonResponse("Something went wrong", 400);
        }
    }

    public function deleteParty($id){
        try{
            $party = Party::find($id);
            $party->songs()->detach();
            $party->delete();
            return new JsonResponse($id);
        } catch (\Exception $exception){
            return new JsonResponse("Something went wrong", 400);
        }
    }

    public function joinParty($id)
    {
        $party = Party::find($id);
        $user = auth()->user();
        $party->users()->attach($user->id);
        return new PartyResource($party);
    }
}