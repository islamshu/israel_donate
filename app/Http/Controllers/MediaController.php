<?php
namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $media = Media::latest()->get();
    
        return view('dashboard.media.index', [
            'media' => $media,
            'selectMode' => $request->get('select_mode') 
        ]);
    }
    public function grid(Request $request)
    {
        $media = Media::latest()->paginate(20);
        $selectMode = $request->has('select_mode');
        
        // إذا كان الطلب AJAX، نرجع جزء الـ grid فقط
        if ($request->ajax() || $request->wantsJson()) {
            return view('dashboard.media._media_grid', compact('media', 'selectMode'));
        }
        
        // للطلبات العادية
        return view('dashboard.media.index', compact('media', 'selectMode'));
    }

    public function upload(Request $request)
    {
        try {
            $request->validate([
                'files'   => 'required|array',
                'files.*' => 'image|max:5120', // 5MB
            ]);
    
            $uploadedMedia = [];
    
            foreach ($request->file('files') as $file) {
                $path = $file->store('media', 'public');
    
                $media = Media::create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
    
                $uploadedMedia[] = $media;
            }
    
            return response()->json([
                'success' => true,
                'media' => $uploadedMedia
            ]);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    

    public function update(Request $request, Media $media)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'alt' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:500',
            'description' => 'nullable|string',
        ]);

        $media->update(
            $request->only(['title','alt','caption','description'])
        );
    
        return response()->json([
            'success' => true,
            'media' => [
                'id' => $media->id,
                'title' => $media->title,
                'alt' => $media->alt,
                'caption' => $media->caption,
                'description' => $media->description,
                'file_name' => $media->file_name,
                'created_at' => $media->created_at->format('Y/m/d'),
                'url' => $media->url,
                'human_size' => $media->human_size,
            ]
        ]);
    }

    public function destroy(Media $media)
    {
        // حذف الملف من التخزين
        Storage::disk('public')->delete($media->file_path);
        
        // حذف السجل من قاعدة البيانات
        $media->delete();
        
        return response()->json(['success' => true]);
    }
}