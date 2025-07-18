<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Gambar;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Artikel::with('gambar')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaAcara' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'penulis' => 'nullable|string|max:255',
            'tanggalAcara' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $article = Artikel::create([
            'id' => (string) Str::uuid(),
            'namaAcara' => $request->namaAcara,
            'deskripsi' => $request->deskripsi,
            'penulis' => $request->penulis,
            'tanggalAcara' => $request->tanggalAcara,
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/articles'), $imageName);

            Gambar::create([
                'id' => (string) Str::uuid(),
                'acaraId' => $article->id,
                'url' => 'images/articles/' . $imageName,
                'kategori' => 'ACARA',
            ]);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dibuat.');
    }

    public function edit($id)
    {
        $article = Artikel::with('gambar')->findOrFail($id);
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'namaAcara' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'penulis' => 'nullable|string|max:255',
            'tanggalAcara' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $article = Artikel::findOrFail($id);
        $article->update([
            'namaAcara' => $request->namaAcara,
            'deskripsi' => $request->deskripsi,
            'penulis' => $request->penulis,
            'tanggalAcara' => $request->tanggalAcara,
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($article->gambar) {
                $oldImagePath = public_path($article->gambar->url);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                $article->gambar->delete();
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/articles'), $imageName);

            Gambar::create([
                'id' => (string) Str::uuid(),
                'acaraId' => $article->id,
                'url' => 'images/articles/' . $imageName,
                'kategori' => 'ACARA',
            ]);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $article = Artikel::with('gambar')->findOrFail($id);
        
        // Hapus gambar jika ada
        if ($article->gambar) {
            $imagePath = public_path($article->gambar->url);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $article->gambar->delete();
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
} 
 