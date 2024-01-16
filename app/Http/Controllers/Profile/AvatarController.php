<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatarRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function update(UpdateAvatarRequest $request): RedirectResponse{
        // store avatar

        $path = Storage::disk('public')->put('avatars', $request->file('avatar'));
        // $path = $request->file('avatar')->store('avatars', 'public');

        if ($old_avatar = $request->user()->avatar) {
            Storage::disk('public')->delete($old_avatar);
        }

        auth()->user()->update(['avatar' => $path]);
        return back()->with('message', 'Avatar updated!');
    }
        
}
