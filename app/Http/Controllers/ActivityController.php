<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::orderBy('activity_date', 'desc')->paginate(10);
        return view('activities.index', compact('activities'));
    }

    public function create()
    {
        return view('activities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'activity_date' => 'required|date',
        ]);

        Activity::create([
            'title' => $request->title,
            'description' => $request->description,
            'activity_date' => $request->activity_date,
            'status' => $request->status ?? 'pending',
        ]);

        return redirect('/activities')->with('success', 'Aktivitas berhasil ditambahkan');
    }

    public function edit(Activity $activity)
    {
        return view('activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'title' => 'required',
            'activity_date' => 'required|date',
        ]);

        $activity->update([
            'title' => $request->title,
            'description' => $request->description,
            'activity_date' => $request->activity_date,
            'status' => $request->status ?? 'pending',
        ]);

        return redirect('/activities')->with('success', 'Aktivitas berhasil diupdate');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect('/activities')->with('success', 'Aktivitas berhasil dihapus');
    }

    public function complete(Activity $activity)
    {
        $activity->update(['status' => 'completed']);
        return redirect('/activities')->with('success', 'Aktivitas selesai');
    }
}
