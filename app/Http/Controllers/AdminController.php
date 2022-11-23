<?php

namespace App\Http\Controllers;

use App\Exceptions\DeleteUserException;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // send there a user
        return view('admin.index', [
            'users' => User::orderby('email')->paginate(0),
        ]);
    }

    public function store(Request $request) {
        if ($request->email == null) {
            return $this->index();
        }
        return view('admin.index', [
            'users' => User::where('email', 'like', "%$request->email%")->orderby('email')->paginate(0),
        ]);
    }

    /**
     * @throws DeleteUserException
     */
    public function destroy(Request $request, int $delete_user_id) {
        Gate::authorize('delete-user', [$request->user(), $delete_user_id]);

        if ($request->user()->id == $delete_user_id) {
            if (User::where('role_id', User::getRoleId('admin'))->count() <= 1) {
                throw new DeleteUserException(
                    'Cannot delete the last admin in the system.', 409);
            }
        }
        User::where('id', $delete_user_id)->first()->delete();
        return redirect(route('admin.index'));
    }

    public function update(Request $request, int $user_id) {
        $user = User::where('id', $user_id)->first();
        Gate::authorize('update-user', [$user, $request->role]);

        $user->setRole($request->role);
        $user->save();
        return redirect(route('admin.index'));
    }
}
