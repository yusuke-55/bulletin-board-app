<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|max:1024',
            'remove_avatar' => 'nullable|boolean',
        ]);

        $avatarPath = $user->avatar_path;

        if ($request->boolean('remove_avatar')) {
            if ($avatarPath) {
                Storage::disk('public')->delete($avatarPath);
            }
            $avatarPath = null;
        }

        if ($request->hasFile('avatar')) {
            if ($avatarPath) {
                Storage::disk('public')->delete($avatarPath);
            }
            $avatarPath = Storage::disk('public')->putFile('avatars', $request->file('avatar'));
        }

        $user->update([
            'name' => $validated['name'],
            'avatar_path' => $avatarPath,
        ]);

        return redirect()->route('profile.edit')->with('success', 'アカウントを更新しました。');
    }
}
