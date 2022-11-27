<?php

namespace App\Http\Controllers;

use App\Enums\UserSeederEnum;
use App\Exceptions\DeleteUserException;
use App\Models\Comment;
use App\Models\ServiceRequest;
use App\Models\Ticket;
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
        // The following is here because while it works in my local SQLite without these lines
        // (using default values defined in schema), it doesn't work without it on the server
        // which is using MySQL - even though it should work
        Comment::where('author_id', $delete_user_id)
            ->update(['author_id' => UserSeederEnum::TECHNICIAN->value]);
        Ticket::where('author_id', $delete_user_id)
            ->update(['author_id' => UserSeederEnum::CITIZEN->value]);
        ServiceRequest::where('technician_id', $delete_user_id)
            ->update(['technician_id' => UserSeederEnum::TECHNICIAN->value]);
        ServiceRequest::where('city_admin_id', $delete_user_id)
            ->update(['city_admin_id' => UserSeederEnum::CITY_ADMIN->value]);

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
