<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatarRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Str;

class AvatarController extends Controller
{
    // public static function saveAvatar($file){
    //     $content = file_get_contents($request->file('avatar'));
    //     $filename = Str::random(20);

    //     $path = Storage::disk('public')->put("avatars/$filename.jpg", $content);

    //     auth()->user()->update(['avatar' => $path]);
    // }

    public function update(UpdateAvatarRequest $request): RedirectResponse{
        // store avatar

        if ($old_avatar = $request->user()->avatar) {
            Storage::disk('public')->delete($old_avatar);
        }

        $content = file_get_contents($request->file('avatar'));
        $filename = Str::random(20);

        $path = Storage::disk('public')->put("avatars/$filename.jpg", $content);

        auth()->user()->update(['avatar' => $path]);
        return back()->with('message', 'Avatar updated!');
    }
    
    public function generateAvatar(){

        $result = OpenAI::images()->create([
            'prompt' => 'generate a single user avatar',
            'n' => 1,
            'size' => '256x256'
        ]);

        $content = file_get_contents($result->data[0]->url);

        $filename = Str::random(20);

        if ($old_avatar = auth()->user()->avatar) {
            Storage::disk('public')->delete($old_avatar);
        }

        Storage::disk('public')->put("avatars/$filename.jpg", $content);

        auth()->user()->update(['avatar' => "avatars/$filename.jpg"]);
        return back()->with('message', 'Avatar generated!');
        
    }
}
