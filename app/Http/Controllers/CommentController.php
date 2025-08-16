<?php

namespace App\Http\Controllers;

use App\Models\Comment; // Pastikan model Comment di-import
use App\Models\Post;    // Pastikan model Post di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Untuk flash message

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        // 1. Validasi data yang masuk dari formulir
        $validatedData = $request->validate([
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|string|email|max:255',
            'content' => 'required|string|min:5',
        ]);

        // 2. Buat komentar baru
        $comment = new Comment();
        $comment->post_id = $post->id; // Ambil ID post dari parameter rute
        $comment->author_name = $validatedData['author_name'];
        $comment->author_email = $validatedData['author_email'];
        $comment->content = $validatedData['content'];
        // Jika Anda memiliki sistem user login, Anda bisa menambahkan user_id:
        // $comment->user_id = auth()->id(); // Jika user sedang login

        // 3. Simpan komentar ke database
        $comment->save();

        // 4. Redirect kembali ke halaman berita dengan pesan sukses
        Session::flash('success_message', 'Komentar Anda berhasil ditambahkan!');
        return redirect()->back();
        // Atau: return redirect()->route('post.show', $post->slug)->with('success', 'Komentar Anda berhasil ditambahkan!');
    }
}
