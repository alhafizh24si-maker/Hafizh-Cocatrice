<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    /**
     * Store multiple documents for a user
     */
    public function store(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $validator = Validator::make($request->all(), [
            'documents.*' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,txt|max:5120', // 5MB max
            'descriptions.*' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $uploadedFiles = [];

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $index => $file) {
                $originalName = $file->getClientOriginalName();
                $fileName = time() . '_' . $originalName;
                $filePath = $file->storeAs('documents', $fileName, 'public');

                $description = $request->descriptions[$index] ?? null;

                $document = Document::create([
                    'user_id' => $user->id,
                    'original_name' => $originalName,
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'description' => $description
                ]);

                $uploadedFiles[] = $document;
            }
        }

        return redirect()->back()
            ->with('success', count($uploadedFiles) . ' file berhasil diupload!');
    }

    /**
     * Download a document
     */
    public function download($id)
    {
        $document = Document::findOrFail($id);

        if (!Storage::disk('public')->exists($document->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }

        return Storage::disk('public')->download($document->file_path, $document->original_name);
    }

    /**
     * View a document
     */
    public function view($id)
    {
        $document = Document::findOrFail($id);

        if (!Storage::disk('public')->exists($document->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }

        return response()->file(Storage::disk('public')->path($document->file_path));
    }

    /**
     * Delete a document
     */
    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        // Delete file from storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->back()->with('success', 'File berhasil dihapus!');
    }

    /**
     * Show documents for a user
     */
    public function showUserDocuments($userId)
    {
        $user = User::with('documents')->findOrFail($userId);
        return view('admin.user.documents', compact('user'));
    }
}
