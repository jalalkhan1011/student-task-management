<?php

namespace App\Http\Controllers\Headmaster;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Headmaster']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcements = Announcement::all();
        return view('admin.headmaster.announcement.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.headmaster.announcement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image',
            'scheduled_at' => 'required|date|after:now',
        ]);

        $paths = [
            'original' => null,
            'webp' => null,
        ];

        if ($request->hasFile('image')) {
            $original = $request->file('image');
            $filename = uniqid() . '.' . $original->getClientOriginalExtension();
            $webpName = uniqid() . '.webp';

            //original
            $originalPath = $original->storeAs('announcements/original', $filename, 'public');
            $paths['original'] = $originalPath;

            // webp convert
            $imageManager = new ImageManager(
                new \Intervention\Image\Drivers\Gd\Driver()
            );
            $image = $imageManager->read($original);
            $encoded = $image->encode(new WebpEncoder(quality: 80));

            Storage::disk('public')->put('announcements/webp/' . $webpName, $encoded);
            $paths['webp'] = 'announcements/webp/' . $webpName;
        }

        $announcement = Announcement::create([
            'title' => $request->title,
            'description' => $request->description,
            'original_image_path' => $paths['original'],
            'webp_image_path' => $paths['webp'],
            'scheduled_at' => $request->scheduled_at,
        ]);

        return redirect()->route('announcements.index')->with('success', 'Announcement created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $announcement = Announcement::findOrFail($id);

        return view('admin.headmaster.announcement.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $announcement = Announcement::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|image',
            'scheduled_at' => 'required|date|after:now',
        ]);

        $paths = [
            'original' => null,
            'webp' => null,
        ];

        if ($request->hasFile('image')) {
            $original = $request->file('image');
            $filename = uniqid() . '.' . $original->getClientOriginalExtension();
            $webpName = uniqid() . '.webp';

            //original
            $originalPath = $original->storeAs('announcements/original', $filename, 'public');
            $paths['original'] = $originalPath;

            // webp convert
            $imageManager = new ImageManager(
                new \Intervention\Image\Drivers\Gd\Driver()
            );
            $image = $imageManager->read($original);
            $encoded = $image->encode(new WebpEncoder(quality: 80));

            Storage::disk('public')->put('announcements/webp/' . $webpName, $encoded);
            $paths['webp'] = 'announcements/webp/' . $webpName;
        }

        $announcement->update([
            'title' => $request->title,
            'description' => $request->description,
            'original_image_path' => $paths['original'],
            'webp_image_path' => $paths['webp'],
            'scheduled_at' => $request->scheduled_at,
        ]);

        return redirect()->route('announcements.index')->with('success', 'Announcement update.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $announcement = Announcement::findOrFail($id);

        $announcement->delete();

        return back()->with('success', 'Announcement Deleted.');
    }
}
