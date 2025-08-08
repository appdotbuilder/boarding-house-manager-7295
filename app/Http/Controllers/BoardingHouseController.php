<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBoardingHouseRequest;
use App\Http\Requests\UpdateBoardingHouseRequest;
use App\Models\BoardingHouse;
use Inertia\Inertia;

class BoardingHouseController extends Controller
{
    /**
     * Display a listing of boarding houses.
     */
    public function index()
    {
        $boardingHouses = BoardingHouse::withCount(['rooms', 'occupiedRooms', 'vacantRooms'])
            ->latest()
            ->paginate(10);

        return Inertia::render('boarding-houses/index', [
            'boardingHouses' => $boardingHouses
        ]);
    }

    /**
     * Show the form for creating a new boarding house.
     */
    public function create()
    {
        return Inertia::render('boarding-houses/create');
    }

    /**
     * Store a newly created boarding house.
     */
    public function store(StoreBoardingHouseRequest $request)
    {
        $boardingHouse = BoardingHouse::create($request->validated());

        return redirect()->route('boarding-houses.show', $boardingHouse)
            ->with('success', 'Boarding house created successfully.');
    }

    /**
     * Display the specified boarding house.
     */
    public function show(BoardingHouse $boardingHouse)
    {
        $boardingHouse->load(['rooms.activeAssignment.tenant']);

        return Inertia::render('boarding-houses/show', [
            'boardingHouse' => $boardingHouse
        ]);
    }

    /**
     * Show the form for editing the specified boarding house.
     */
    public function edit(BoardingHouse $boardingHouse)
    {
        return Inertia::render('boarding-houses/edit', [
            'boardingHouse' => $boardingHouse
        ]);
    }

    /**
     * Update the specified boarding house.
     */
    public function update(UpdateBoardingHouseRequest $request, BoardingHouse $boardingHouse)
    {
        $boardingHouse->update($request->validated());

        return redirect()->route('boarding-houses.show', $boardingHouse)
            ->with('success', 'Boarding house updated successfully.');
    }

    /**
     * Remove the specified boarding house.
     */
    public function destroy(BoardingHouse $boardingHouse)
    {
        $boardingHouse->delete();

        return redirect()->route('boarding-houses.index')
            ->with('success', 'Boarding house deleted successfully.');
    }
}