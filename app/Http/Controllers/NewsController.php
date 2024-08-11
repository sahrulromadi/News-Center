<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use App\Events\NewsCreated;
use Illuminate\Http\Request;
use App\Events\NewsStatusUpdated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $latestNews = News::where('status', 'Accept')->latest()->get();
        $topNews = News::where('status', 'Accept')->orderBy('views', 'desc')->get();
        $popularNews = News::where('status', 'Accept')
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->get();
        $topCategory = Category::orderBy('views', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home', compact(
            'latestNews',
            'topNews',
            'popularNews',
            'topCategory',
        ));
    }

    public function manage()
    {
        $allNews = News::with('category')->get();
        return view('admin.news.manage', compact('allNews'));
    }

    public function viewCategory(Category $categories)
    {
        $latestNews = $categories->news()->where('status', 'Accept')->latest()->get();
        $topNews = $categories->news()->where('status', 'Accept')->orderBy('views', 'desc')->get();
        $popularNews = $categories->news()
            ->where('status', 'Accept')
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->get();

        $categories->increment('views');

        return view('viewCategory', compact('categories', 'latestNews', 'topNews', 'popularNews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allCategory = Category::all();
        return view('news.create', compact('allCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|min:1',
                'content' => 'required|string|min:1',
                'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
                'category_id' => 'required|exists:category,id',
            ]);

            $imageHashName = null;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageHashName = $image->hashName();
                $image->storeAs('public/images', $imageHashName);
            }

            $news = News::create([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'image' => $imageHashName,
            ]);

            event(new NewsCreated($news));

            return response()->json([
                'success' => true,
                'message' => 'Successfully saved the data.',
                'redirect_url' => route('dashboard')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        $randomNews = News::inRandomOrder()->take(2)->get();
        $news->increment('views');

        return view('detail', compact('news', 'randomNews'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $allCategory = Category::all();

        if ($news->status != 'Reject') {
            return redirect()->back()->with('error', 'News can only be edited if it is rejected.');
        }

        return view('news.edit', compact('news', 'allCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
                'category_id' => 'required|exists:category,id'
            ]);

            $data = [
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
            ];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image->storeAs('public/images/', $image->hashName());

                Storage::delete('public/images/' . $news->image);

                $data['image'] = $image->hashName();
            }

            $news->update($data);

            event(new NewsCreated($news));

            return response()->json([
                'success' => true,
                'message' => 'Successfully update the data.',
                'redirect_url' => route('dashboard')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        try {
            Storage::delete('public/images/' . $news->image);
            $news->delete();

            return response()->json([
                'success' => true,
                'message' => 'Successfully delete the data.',
                'redirect_url' => route('admin.news.manage')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function status(Request $request, News $news)
    {
        $draftNews = News::with('category')
            ->whereIn('status', ['Pending', 'Reject'])
            ->get();

        return view('news.status', compact('draftNews'));
    }

    public function view(Request $request, News $news)
    {
        return view('news.view', compact('news'));
    }

    public function updateStatus(Request $request, News $news)
    {
        try {
            $request->validate([
                'status' => 'required'
            ]);

            $news->status = $request->status;
            $news->save();

            event(new NewsStatusUpdated($news));

            return response()->json([
                'success' => true,
                'message' => 'Successfully updated status the news.',
                'redirect_url' => route('news.status')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function draft()
    {
        $userId = auth()->id();

        $acceptedNews = News::with('category')
            ->where('status', 'Accept')
            ->where('user_id', $userId)
            ->get();

        $notAcceptedNews = News::with('category')
            ->whereIn('status', ['Pending', 'Reject'])
            ->where('user_id', $userId)
            ->get();

        return view('admin.users.draft', compact('acceptedNews', 'notAcceptedNews'));
    }
}
