<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoterPostRequest;
use App\Models\Event;
use App\Models\Voter;
use Illuminate\Http\Request;

class VoterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Require authentication and email verification
        $this->middleware(['auth', 'verified']);

        // Authorize all actions.
        $this->authorizeResource(Voter::class, 'voter');

        // Ensure if event is editable to create new voter.
        $this->middleware('event.editable')->except(['index']);
    }

    /**
     * Get the map of resource methods to ability names.
     *
     * @return array
     */
    protected function resourceAbilityMap()
    {
        return collect(parent::resourceAbilityMap())
            ->except(['index', 'store'])
            ->all();
    }

    /**
     * Display a listing of the voter.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Event $event)
    {
        $this->authorize('viewAny', [Voter::class, $event]);

        $data['title'] = 'Voters | '.config('app.name');
        $data['event'] = $event;

        return view('pages.voters', $data);
    }

    /**
     * Show the form for creating a new voter.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created voter in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VoterPostRequest $request, Event $event)
    {
        $this->authorize('create', [Voter::class, $event]);

        // Validate the request.
        $validatedData = $request->validated();
        $validatedData['event_id'] = $event->id;

        // Create a new voter.
        $voter = Voter::create($validatedData);

        if (empty($voter)) {
            return redirect()->route('events.voters.index', ['event' => $event])
                ->with('error', 'Failed adding new voter.');
        }

        return redirect()->route('events.voters.index', ['event' => $event]);
    }

    /**
     * Display the specified voter.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Voter $voter)
    {
        //
    }

    /**
     * Show the form for editing the specified voter.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Voter $voter)
    {
        //
    }

    /**
     * Update the specified voter in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voter $voter)
    {
        //
    }

    /**
     * Remove the specified voter from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voter $voter)
    {
        // Delete the voter.
        if (! $voter->delete()) {
            return redirect()->route('events.voters.index', ['event' => $voter->event])
                ->with('error', 'Failed deleting the voter.');
        }

        return redirect()->route('events.voters.index', ['event' => $voter->event]);
    }
}
