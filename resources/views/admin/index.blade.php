<x-app-layout>
    <div class="max-w-5xl mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-3xl text-center">User management</h1>

        <div class="max-w-5xl mx-auto p-4 sm:p-6 lg:p-8">
            <form method="POST" action="{{ route('admin.index') }}">
                @csrf
                <label for="email" class="block">Search for user:</label>
                <input
                    type="text"
                    id="email"
                    name="email"
                    placeholder="{{ __('jose@email.com') }}"
                    class="w-4/5 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                     focus:ring-opacity-50 rounded-md shadow-sm"
                >
                <x-primary-button>{{ __('Search') }}</x-primary-button>
            </form>
        </div>

        <table class="shadow-md rounded w=80 table-auto mx-auto">
            <tr class="p-3 bg-gray-300">
                <th class="p-3 text-left">Name</th>
                <th class="p-3 text-left">Email</th>
                <th class="p-3">Role</th>
                @if(Auth::user()->role_id == User::getRoleId('admin'))
                    <th class="p-3">Admin</th>
                    <th class="p-3">City admin</th>
                @endif
                <th class="p-3">Technician</th>
                <th class="p-3">Citizen</th>
                @if(Auth::user()->role_id == User::getRoleId('admin'))
                    <th class="p-3">Remove</th>
                @endif
            </tr>

            @foreach($users as $user)
            @unless(in_array($user->id, UserSeeder::never_delete_user_ids())
                || (Auth::user()->role_id == User::getRoleId('city_admin') && !in_array($user->getRoleAsString(), ['technician', 'citizen']))
                )
                <tr class="bg-white m-2 hover:bg-slate-200">
                    <td class="text-gray-800 font-bold pl-3">{{ $user->name }}</td>
                    <td class="text-gray-800">{{ $user->email }}</td>
                    <td class="text-gray-800 text-center">{{ $user->getRoleAsString() }}</td>
                    @if(Auth::user()->role_id == User::getRoleId('admin'))
                        <td>
                            @unless($user->is_admin())
                                <form method="POST" action="{{ route('admin.update', $user->id) }}"
                                      class="block inline pl-2 pr-2">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" id="role" name="role" value="admin"/>
                                    <x-primary-button class="mt-1 mb-1">{{ __('Admin') }}</x-primary-button>
                                </form>
                            @endunless
                        </td>
                        <td>
                            @unless($user->role_id == User::getRoleId("city_admin"))
                                <form method="POST" action="{{ route('admin.update', $user->id) }}"
                                      class="block inline p-2">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" id="role" name="role" value="city_admin"/>
                                    <x-primary-button class="mt-1 mb-1">{{ __('City Ad.') }}</x-primary-button>
                                </form>
                            @endunless
                        </td>
                    @endif
                    <td>
                        @unless($user->role_id == User::getRoleId("technician"))
                            <form method="POST" action="{{ route('admin.update', $user->id) }}"
                                  class="block inline p-2">
                                @csrf
                                @method('patch')
                                <input type="hidden" id="role" name="role" value="technician"/>
                                <x-primary-button class="mt-1 mb-1">{{ __('Technician') }}</x-primary-button>
                            </form>
                        @endunless
                    </td>
                    <td>
                        @unless($user->role_id == User::getRoleId("citizen"))
                            <form method="POST" action="{{ route('admin.update', $user->id) }}"
                                  class="block inline p-2">
                                @csrf
                                @method('patch')
                                <input type="hidden" id="role" name="role" value="citizen"/>
                                <x-primary-button class="mt-1 mb-1">{{ __('Citizen') }}</x-primary-button>
                            </form>
                        @endunless
                    </td>
                    <td>
                        @if(Auth::user()->role_id == User::getRoleId('admin'))
                            <form method="POST" action="{{ route('admin.destroy', $user->id) }}"
                                  class="block inline p-2">
                                @csrf
                                @method('delete')
                                <x-primary-button class="mt-1 mb-1">{{ __('Remove') }}</x-primary-button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endunless
            @endforeach
        </table>
        <br>
        {{ $users->links() }}
        <br>
    </div>
</x-app-layout>
