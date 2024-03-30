<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;


class FileController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');

        $documentName = $file->getClientOriginalName();
        $file->move(public_path('documents/property_documents'), $documentName);

        $fileModel = new File();
        $fileModel->name = $documentName;
        $fileModel->path = 'documents/property_documents/' . $documentName;
        $fileModel->mime_type = $file->getClientMimeType();

        $fileModel->save();

        return response()->json(['message' => 'File uploaded successfully', 'file' => $fileModel], 201);
    }

    public function destroy($id)
    {
        $file = File::find($id);
        
        if (!$file) {
            return response()->json(['error' => 'File not found'], 404);
        }

        Storage::delete($file->path);
        $file->delete();

        return response()->json(['message' => 'File deleted successfully']);
    }

    public function destroy_all()
    {
        $files = File::all();

        if ($files->isEmpty()) {
            return response()->json(['error' => 'No files found'], 404);
        }

        foreach($files as $file) {
            Storage::delete($file->path);
            $file->delete();
        }

        return response()->json(['message' => 'All files deleted successfully']);
    }

    public function get() 
    {
        $fileModel = File::all();

        if ($fileModel->isEmpty()) {
            return response()->json(['error' => ' No file found. Store a file first'], 404);
        }

        return response()->json(['message' => 'Files retrieved successfully', 'files' => $fileModel], 201);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'file' => 'required|file',
        ]);

        $file = File::find($id);

        if (!$file) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $newFile = $request->file('file');

        $documentName = $newFile->getClientOriginalName();
        $newFile->move(public_path('documents/property_documents'), $documentName);

        $file->name = $documentName;
        $file->path = 'documents/property_documents/' . $documentName;
        $file->mime_type = $newFile->getClientMimeType();

        $file->save();

        return response()->json(['message' => 'File updated successfully', 'file' => $file]);
    }
}
