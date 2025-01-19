<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ContentController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $query = Content::query();
        
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $contents = $query->paginate(10);
        return response()->json($contents);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $content = Content::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'created_by' => JWTAuth::user()->id,
        ]);

        return response()->json(['message' => 'Content created successfully', 'content' => $content]);
    }

    public function update(Request $request, $id)
    {
        $user = JWTAuth::user();
        if (!$user) {
            return response()->json(['message' => 'User not found or invalid token'], 401);
        }
        
        $content = Content::findOrFail($id);

        
        if ($content->created_by !== JWTAuth::user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'body' => 'sometimes|required|string',
        ]);

        $content->update($validated);

        return response()->json([
            'message' => 'Content updated successfully',
            'content' => $content,
        ]);
    }

    public function destroy($id)
    {
        $content = Content::findOrFail($id);
        $content->delete();

        return response()->json(['message' => 'Content deleted successfully']);
    }
}
