<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('submit-comments'))
        {
            $validated = $request->validate([
                'text' => 'required|string',
                'commentable_id' => 'required',
                'commentable_type' => 'required',
                'author_id' => 'required'
            ]);

            Comment::create($validated);

            return redirect()->back();
        }
    }
}
